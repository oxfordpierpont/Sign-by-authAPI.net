<?php
/**
 * Webhook Handler
 *
 * Processes webhooks from LibreSign when documents are signed.
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sign_Webhook_Handler class
 *
 * @since 1.0.0
 */
class Sign_Webhook_Handler {

	/**
	 * Process webhook from LibreSign.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_REST_Request $request REST request object.
	 * @return WP_REST_Response|WP_Error Response object.
	 */
	public function process( $request ) {
		// Get webhook payload.
		$payload = $request->get_json_params();

		// Verify webhook signature (if configured).
		$verified = $this->verify_signature( $request );
		if ( is_wp_error( $verified ) ) {
			$this->log_webhook( 0, 'verification_failed', $verified->get_error_message() );
			return $verified;
		}

		// Extract data from payload.
		$event = isset( $payload['event'] ) ? $payload['event'] : '';
		$metadata = isset( $payload['metadata'] ) ? $payload['metadata'] : array();
		$cpt_id = isset( $metadata['cpt_id'] ) ? (int) $metadata['cpt_id'] : 0;

		if ( empty( $cpt_id ) ) {
			$error = new WP_Error( 'missing_cpt_id', 'CPT ID not found in webhook metadata' );
			$this->log_webhook( 0, 'missing_cpt_id', wp_json_encode( $payload ) );
			return $error;
		}

		// Log webhook received.
		$this->log_webhook( $cpt_id, 'webhook_received', "Event: {$event}" );

		// Handle different events.
		switch ( $event ) {
			case 'document_signed':
				return $this->handle_document_signed( $cpt_id, $payload );

			case 'document_opened':
				return $this->handle_document_opened( $cpt_id, $payload );

			case 'document_declined':
				return $this->handle_document_declined( $cpt_id, $payload );

			default:
				$this->log_webhook( $cpt_id, 'unknown_event', "Unknown event: {$event}" );
				return new WP_REST_Response(
					array( 'message' => 'Event not handled' ),
					200
				);
		}
	}

	/**
	 * Verify webhook signature.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_REST_Request $request REST request object.
	 * @return bool|WP_Error True if verified, error otherwise.
	 */
	private function verify_signature( $request ) {
		// For now, just return true.
		// In production, implement HMAC signature verification.
		return true;
	}

	/**
	 * Handle document_signed event.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $cpt_id  Post ID.
	 * @param array $payload Webhook payload.
	 * @return WP_REST_Response Response object.
	 */
	private function handle_document_signed( $cpt_id, $payload ) {
		// Extract signed document URLs.
		$signed_pdf_url = isset( $payload['signed_pdf_url'] ) ? $payload['signed_pdf_url'] : '';
		$certificate_url = isset( $payload['certificate_url'] ) ? $payload['certificate_url'] : '';
		$signer_ip = isset( $payload['signer_ip'] ) ? $payload['signer_ip'] : '';

		// Download and save signed PDF.
		$signed_pdf_path = $this->download_file( $signed_pdf_url, 'signed-' . $cpt_id . '.pdf' );
		$certificate_path = $this->download_file( $certificate_url, 'certificate-' . $cpt_id . '.pdf' );

		// Update CPT metadata.
		update_post_meta( $cpt_id, 'esign_signing_status', 'complete' );
		update_post_meta( $cpt_id, 'esign_signed_pdf_url', $signed_pdf_path );
		update_post_meta( $cpt_id, 'esign_certificate_url', $certificate_path );
		update_post_meta( $cpt_id, 'esign_signed_date', current_time( 'mysql' ) );
		update_post_meta( $cpt_id, 'esign_signer_ip', $signer_ip );

		// Log activity.
		$this->log_webhook( $cpt_id, 'document_signed', 'Document signed successfully' );

		// Send completion emails.
		$email_manager = new Sign_Email_Manager();
		$email_manager->send_completion_email( $cpt_id );
		$email_manager->send_admin_notification( $cpt_id );

		// Fire action for extensibility.
		do_action( 'sign_document_completed', $cpt_id, $payload );

		return new WP_REST_Response(
			array( 'message' => 'Document signed successfully' ),
			200
		);
	}

	/**
	 * Handle document_opened event.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $cpt_id  Post ID.
	 * @param array $payload Webhook payload.
	 * @return WP_REST_Response Response object.
	 */
	private function handle_document_opened( $cpt_id, $payload ) {
		// Log that customer opened the document.
		$this->log_webhook( $cpt_id, 'document_opened', 'Customer opened the document' );

		do_action( 'sign_document_opened', $cpt_id, $payload );

		return new WP_REST_Response(
			array( 'message' => 'Document opened event recorded' ),
			200
		);
	}

	/**
	 * Handle document_declined event.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $cpt_id  Post ID.
	 * @param array $payload Webhook payload.
	 * @return WP_REST_Response Response object.
	 */
	private function handle_document_declined( $cpt_id, $payload ) {
		// Update status.
		update_post_meta( $cpt_id, 'esign_signing_status', 'declined' );

		// Log activity.
		$this->log_webhook( $cpt_id, 'document_declined', 'Customer declined to sign' );

		do_action( 'sign_document_declined', $cpt_id, $payload );

		return new WP_REST_Response(
			array( 'message' => 'Document declined event recorded' ),
			200
		);
	}

	/**
	 * Download file from URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $url      File URL.
	 * @param string $filename Desired filename.
	 * @return string|false File path or false on failure.
	 */
	private function download_file( $url, $filename ) {
		if ( empty( $url ) ) {
			return false;
		}

		// Create signed-docs directory.
		$upload_dir = wp_upload_dir();
		$signed_dir = $upload_dir['basedir'] . '/signed-docs/';

		if ( ! file_exists( $signed_dir ) ) {
			wp_mkdir_p( $signed_dir );
		}

		$filepath = $signed_dir . sanitize_file_name( $filename );

		// Download file.
		$response = wp_remote_get(
			$url,
			array(
				'timeout' => 30,
			)
		);

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$body = wp_remote_retrieve_body( $response );
		file_put_contents( $filepath, $body );

		return $filepath;
	}

	/**
	 * Log webhook activity.
	 *
	 * @since 1.0.0
	 *
	 * @param int    $cpt_id  Post ID.
	 * @param string $action  Action name.
	 * @param string $details Activity details.
	 */
	private function log_webhook( $cpt_id, $action, $details = '' ) {
		global $wpdb;

		$table = $wpdb->prefix . 'sign_activity_log';

		$wpdb->insert(
			$table,
			array(
				'cpt_id'     => $cpt_id,
				'action'     => $action,
				'details'    => $details,
				'user_id'    => 0, // System action.
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
