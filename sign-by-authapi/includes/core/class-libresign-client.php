<?php
/**
 * LibreSign API Client
 *
 * Handles all communication with the LibreSign API.
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sign_LibreSign_Client class
 *
 * @since 1.0.0
 */
class Sign_LibreSign_Client {

	/**
	 * API URL.
	 *
	 * @var string
	 */
	private $api_url;

	/**
	 * API Key.
	 *
	 * @var string
	 */
	private $api_key;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->api_url = get_option( 'sign_libresign_url' );
		$this->api_key = get_option( 'sign_libresign_api_key' );
	}

	/**
	 * Upload PDF and create signing request.
	 *
	 * @since 1.0.0
	 *
	 * @param string $pdf_path         Path to PDF file.
	 * @param string $signer_email     Customer email.
	 * @param array  $signature_fields Array of signature field coordinates.
	 * @param array  $metadata         Custom metadata (CPT ID, etc.).
	 * @return array|WP_Error Response from LibreSign or error.
	 */
	public function create_signing_request( $pdf_path, $signer_email, $signature_fields, $metadata ) {
		// Validate configuration.
		if ( empty( $this->api_url ) || empty( $this->api_key ) ) {
			return new WP_Error( 'missing_config', 'LibreSign API URL and API Key must be configured.' );
		}

		// Validate file exists.
		if ( ! file_exists( $pdf_path ) ) {
			return new WP_Error( 'file_not_found', 'PDF file not found: ' . $pdf_path );
		}

		// Step 1: Upload the PDF file.
		$file_uuid = $this->upload_file( $pdf_path );
		if ( is_wp_error( $file_uuid ) ) {
			return $file_uuid;
		}

		// Step 2: Create signing request.
		$response = $this->api_request(
			'POST',
			'/api/v1/sign/file',
			array(
				'file'        => array(
					'uuid' => $file_uuid,
				),
				'users'       => array(
					array(
						'email'       => $signer_email,
						'description' => 'Customer',
					),
				),
				'sign_fields' => $this->format_signature_fields( $signature_fields ),
				'metadata'    => $metadata,
				'callback'    => array(
					'url'    => rest_url( 'sign/v1/webhook' ),
					'method' => 'POST',
				),
			)
		);

		return $response;
	}

	/**
	 * Upload PDF file to LibreSign.
	 *
	 * @since 1.0.0
	 *
	 * @param string $pdf_path Path to PDF file.
	 * @return string|WP_Error File UUID or error.
	 */
	private function upload_file( $pdf_path ) {
		$response = $this->api_request(
			'POST',
			'/api/v1/file',
			array(
				'file' => curl_file_create( $pdf_path, 'application/pdf', basename( $pdf_path ) ),
			),
			true // Multipart form-data.
		);

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		if ( isset( $response['uuid'] ) ) {
			return $response['uuid'];
		}

		return new WP_Error( 'upload_failed', 'Failed to upload PDF to LibreSign.' );
	}

	/**
	 * Format signature fields for LibreSign API.
	 *
	 * @since 1.0.0
	 *
	 * @param array $fields Array of signature fields.
	 * @return array Formatted fields.
	 */
	private function format_signature_fields( $fields ) {
		$formatted = array();

		foreach ( $fields as $field ) {
			$formatted[] = array(
				'type'     => $field['type'],
				'page'     => $field['page'],
				'x'        => $field['x'],
				'y'        => $field['y'],
				'width'    => $field['width'],
				'height'   => $field['height'],
				'required' => isset( $field['required'] ) ? $field['required'] : true,
			);
		}

		return $formatted;
	}

	/**
	 * Make API request to LibreSign.
	 *
	 * @since 1.0.0
	 *
	 * @param string $method   HTTP method (GET, POST, etc.).
	 * @param string $endpoint API endpoint.
	 * @param array  $data     Request data.
	 * @param bool   $multipart Whether to use multipart/form-data.
	 * @return array|WP_Error Response data or error.
	 */
	private function api_request( $method, $endpoint, $data = array(), $multipart = false ) {
		$url = trailingslashit( $this->api_url ) . ltrim( $endpoint, '/' );

		$args = array(
			'method'  => $method,
			'headers' => array(
				'Authorization' => 'Bearer ' . $this->api_key,
			),
			'timeout' => 30,
		);

		if ( 'GET' === $method ) {
			$url = add_query_arg( $data, $url );
		} else {
			if ( $multipart ) {
				// For file uploads, use curl directly.
				return $this->curl_request( $url, $data );
			} else {
				$args['headers']['Content-Type'] = 'application/json';
				$args['body']                     = wp_json_encode( $data );
			}
		}

		$response = wp_remote_request( $url, $args );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		$status_code = wp_remote_retrieve_response_code( $response );
		$body        = wp_remote_retrieve_body( $response );
		$decoded     = json_decode( $body, true );

		if ( $status_code >= 200 && $status_code < 300 ) {
			return $decoded;
		}

		$error_message = isset( $decoded['message'] ) ? $decoded['message'] : 'API request failed';
		return new WP_Error( 'api_error', $error_message, array( 'status' => $status_code ) );
	}

	/**
	 * Make cURL request for file uploads.
	 *
	 * @since 1.0.0
	 *
	 * @param string $url  Request URL.
	 * @param array  $data Request data.
	 * @return array|WP_Error Response data or error.
	 */
	private function curl_request( $url, $data ) {
		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt(
			$ch,
			CURLOPT_HTTPHEADER,
			array(
				'Authorization: Bearer ' . $this->api_key,
			)
		);

		$response = curl_exec( $ch );
		$status   = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
		$error    = curl_error( $ch );

		curl_close( $ch );

		if ( $error ) {
			return new WP_Error( 'curl_error', $error );
		}

		$decoded = json_decode( $response, true );

		if ( $status >= 200 && $status < 300 ) {
			return $decoded;
		}

		$error_message = isset( $decoded['message'] ) ? $decoded['message'] : 'File upload failed';
		return new WP_Error( 'upload_error', $error_message, array( 'status' => $status ) );
	}

	/**
	 * Test API connection.
	 *
	 * @since 1.0.0
	 *
	 * @return bool|WP_Error True if connection successful, error otherwise.
	 */
	public function test_connection() {
		$response = $this->api_request( 'GET', '/api/v1/status' );

		if ( is_wp_error( $response ) ) {
			return $response;
		}

		return true;
	}

	/**
	 * Get signature fields for a business and document.
	 *
	 * @since 1.0.0
	 *
	 * @param int $business_id Business ID.
	 * @param int $document_id Document ID (optional - if null, gets all).
	 * @return array Array of signature fields.
	 */
	public function get_signature_fields( $business_id, $document_id = null ) {
		global $wpdb;

		$table = $wpdb->prefix . 'sign_fields';

		if ( $document_id ) {
			$fields = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM {$table} WHERE business_id = %d AND document_id = %d ORDER BY page, y, x",
					$business_id,
					$document_id
				),
				ARRAY_A
			);
		} else {
			$fields = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM {$table} WHERE business_id = %d ORDER BY document_id, page, y, x",
					$business_id
				),
				ARRAY_A
			);
		}

		return $fields;
	}
}
