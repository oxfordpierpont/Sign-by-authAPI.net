<?php
/**
 * Signing Controller
 *
 * Orchestrates the entire signing workflow from form submission to completion.
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sign_Signing_Controller class
 *
 * @since 1.0.0
 */
class Sign_Signing_Controller {

	/**
	 * Create signing request from form submission.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $form_data Form field data.
	 * @param object $form      Form object.
	 * @return int|WP_Error Post ID or error.
	 */
	public function create_signing_request( $form_data, $form ) {
		// Step 1: Create or update CPT.
		$cpt_id = $this->create_cpt( $form_data );
		if ( is_wp_error( $cpt_id ) ) {
			return $cpt_id;
		}

		// Step 2: Set initial metadata.
		$this->set_initial_metadata( $cpt_id, $form_data );

		// Step 3: Send initial email notification.
		$email_manager = new Sign_Email_Manager();
		$email_manager->send_initial_email( $cpt_id );

		// Step 4: Log activity.
		$this->log_activity( $cpt_id, 'request_created', 'Signing request created from form submission' );

		do_action( 'sign_request_created', $cpt_id, $form_data );

		return $cpt_id;
	}

	/**
	 * Create CPT from form data.
	 *
	 * @since 1.0.0
	 *
	 * @param array $form_data Form field data.
	 * @return int|WP_Error Post ID or error.
	 */
	private function create_cpt( $form_data ) {
		// Extract customer name for post title.
		$first_name = isset( $form_data['first_name'] ) ? $form_data['first_name'] : '';
		$last_name  = isset( $form_data['last_name'] ) ? $form_data['last_name'] : '';
		$email      = isset( $form_data['email'] ) ? $form_data['email'] : '';

		$post_title = trim( $first_name . ' ' . $last_name );
		if ( empty( $post_title ) ) {
			$post_title = $email;
		}
		if ( empty( $post_title ) ) {
			$post_title = 'Signing Request ' . gmdate( 'Y-m-d H:i:s' );
		}

		// Check if user exists by email.
		$user = get_user_by( 'email', $email );
		$author_id = $user ? $user->ID : 0;

		$post_data = array(
			'post_type'   => 'sign_request',
			'post_title'  => $post_title,
			'post_status' => 'publish',
			'post_author' => $author_id,
		);

		$cpt_id = wp_insert_post( $post_data, true );

		if ( is_wp_error( $cpt_id ) ) {
			return $cpt_id;
		}

		// Save all form data as post meta.
		foreach ( $form_data as $key => $value ) {
			// Map standard fields to esign_ prefixed fields.
			$meta_key = $this->map_field_name( $key );
			update_post_meta( $cpt_id, $meta_key, sanitize_text_field( $value ) );
		}

		return $cpt_id;
	}

	/**
	 * Map form field names to meta field names.
	 *
	 * @since 1.0.0
	 *
	 * @param string $field_name Form field name.
	 * @return string Meta field name.
	 */
	private function map_field_name( $field_name ) {
		$standard_fields = array(
			'first_name'    => 'esign_first_name',
			'last_name'     => 'esign_last_name',
			'email'         => 'esign_email',
			'phone'         => 'esign_phone',
			'address_line1' => 'esign_address_line1',
			'address_line2' => 'esign_address_line2',
			'city'          => 'esign_city',
			'state'         => 'esign_state',
			'zip'           => 'esign_zip',
		);

		if ( isset( $standard_fields[ $field_name ] ) ) {
			return $standard_fields[ $field_name ];
		}

		// Custom fields remain unchanged.
		return $field_name;
	}

	/**
	 * Set initial metadata for signing request.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $cpt_id    Post ID.
	 * @param array $form_data Form data.
	 */
	private function set_initial_metadata( $cpt_id, $form_data ) {
		// Get default business ID (first business in database).
		$business_id = $this->get_default_business_id();

		update_post_meta( $cpt_id, 'esign_business_id', $business_id );
		update_post_meta( $cpt_id, 'esign_signing_status', 'incomplete' );
		update_post_meta( $cpt_id, 'esign_token', $this->generate_token() );
		update_post_meta( $cpt_id, 'esign_created_at', current_time( 'mysql' ) );
		update_post_meta( $cpt_id, 'esign_reminder_count', 0 );
	}

	/**
	 * Get default business ID.
	 *
	 * @since 1.0.0
	 *
	 * @return int Business ID.
	 */
	private function get_default_business_id() {
		global $wpdb;

		$table = $wpdb->prefix . 'sign_businesses';
		$business_id = $wpdb->get_var( "SELECT id FROM {$table} ORDER BY id ASC LIMIT 1" );

		return $business_id ? (int) $business_id : 1;
	}

	/**
	 * Generate unique token.
	 *
	 * @since 1.0.0
	 *
	 * @return string Token.
	 */
	private function generate_token() {
		return bin2hex( random_bytes( 32 ) );
	}

	/**
	 * Generate PDF and send to LibreSign.
	 *
	 * @since 1.0.0
	 *
	 * @param int $cpt_id Post ID.
	 * @return array|WP_Error Response data or error.
	 */
	public function generate_and_send_pdf( $cpt_id ) {
		// Step 1: Get business ID and signer email.
		$business_id = get_post_meta( $cpt_id, 'esign_business_id', true );
		$signer_email = get_post_meta( $cpt_id, 'esign_email', true );

		if ( empty( $business_id ) || empty( $signer_email ) ) {
			return new WP_Error( 'missing_data', 'Business ID or signer email not found.' );
		}

		// Step 2: Generate customer data PDF.
		$pdf_generator = new Sign_PDF_Generator();
		$customer_pdf = $pdf_generator->generate_customer_data_pdf( $cpt_id, $business_id );

		if ( is_wp_error( $customer_pdf ) ) {
			$this->log_activity( $cpt_id, 'pdf_generation_failed', $customer_pdf->get_error_message() );
			return $customer_pdf;
		}

		$this->log_activity( $cpt_id, 'pdf_generated', 'Customer data PDF generated: ' . $customer_pdf );

		// Step 3: Get contract PDFs.
		$pdf_combiner = new Sign_PDF_Combiner();
		$contract_pdfs = $pdf_combiner->get_contract_pdfs( $business_id );

		// Step 4: Combine PDFs.
		$combined_pdf = $pdf_combiner->combine_pdfs( $customer_pdf, $contract_pdfs, $cpt_id );

		if ( is_wp_error( $combined_pdf ) ) {
			$this->log_activity( $cpt_id, 'pdf_combine_failed', $combined_pdf->get_error_message() );
			return $combined_pdf;
		}

		// Step 5: Get signature fields.
		$libresign_client = new Sign_LibreSign_Client();
		$signature_fields = $libresign_client->get_signature_fields( $business_id );

		// Step 6: Send to LibreSign.
		$metadata = array(
			'cpt_id' => $cpt_id,
			'site_url' => home_url(),
		);

		$response = $libresign_client->create_signing_request(
			$combined_pdf,
			$signer_email,
			$signature_fields,
			$metadata
		);

		if ( is_wp_error( $response ) ) {
			$this->log_activity( $cpt_id, 'libresign_failed', $response->get_error_message() );
			return $response;
		}

		// Step 7: Update CPT metadata.
		update_post_meta( $cpt_id, 'esign_libresign_uuid', $response['uuid'] ?? '' );
		update_post_meta( $cpt_id, 'esign_sent_at', current_time( 'mysql' ) );

		$this->log_activity( $cpt_id, 'sent_to_libresign', 'Document sent to LibreSign for signing' );

		// Step 8: Clean up temporary files.
		@unlink( $customer_pdf );
		@unlink( $combined_pdf );

		do_action( 'sign_pdf_sent', $cpt_id, $response );

		return $response;
	}

	/**
	 * Log activity.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $cpt_id  Post ID.
	 * @param string $action  Action name.
	 * @param string $details Activity details.
	 */
	private function log_activity( $cpt_id, $action, $details = '' ) {
		global $wpdb;

		$table = $wpdb->prefix . 'sign_activity_log';

		$wpdb->insert(
			$table,
			array(
				'cpt_id'     => $cpt_id,
				'action'     => $action,
				'details'    => $details,
				'user_id'    => get_current_user_id(),
				'ip_address' => $this->get_user_ip(),
			),
			array( '%d', '%s', '%s', '%d', '%s' )
		);
	}

	/**
	 * Get user IP address.
	 *
	 * @since 1.0.0
	 *
	 * @return string IP address.
	 */
	private function get_user_ip() {
		$ip_address = '';

		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip_address = sanitize_text_field( wp_unslash( $_SERVER['HTTP_CLIENT_IP'] ) );
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip_address = sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) );
		} elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
			$ip_address = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
		}

		return $ip_address;
	}
}
