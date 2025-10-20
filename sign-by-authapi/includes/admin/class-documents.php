<?php
/**
 * Documents Management
 *
 * Handles contract document uploads and management.
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sign_Documents class
 *
 * @since 1.0.0
 */
class Sign_Documents {

	/**
	 * Render documents page.
	 *
	 * @since 1.0.0
	 */
	public function render() {
		// Handle form submission.
		if ( isset( $_POST['upload_document'] ) && check_admin_referer( 'sign_documents_nonce' ) ) {
			$this->upload_document();
		}

		// Handle delete action.
		if ( isset( $_GET['action'] ) && 'delete' === $_GET['action'] && isset( $_GET['document_id'] ) ) {
			$this->delete_document( (int) $_GET['document_id'] );
		}

		// Get all documents.
		$documents = $this->get_documents();

		include SIGN_PLUGIN_DIR . 'templates/admin/documents.php';
	}

	/**
	 * Get all documents.
	 *
	 * @since 1.0.0
	 *
	 * @return array Documents.
	 */
	private function get_documents() {
		global $wpdb;

		$table = $wpdb->prefix . 'sign_documents';
		$documents = $wpdb->get_results( "SELECT * FROM {$table} ORDER BY sequence ASC", ARRAY_A );

		return $documents ? $documents : array();
	}

	/**
	 * Upload document.
	 *
	 * @since 1.0.0
	 */
	private function upload_document() {
		if ( empty( $_FILES['document']['name'] ) ) {
			add_settings_error(
				'sign_documents',
				'no_file',
				__( 'Please select a file to upload.', 'sign-by-authapi' ),
				'error'
			);
			return;
		}

		$uploaded = $this->handle_document_upload();

		if ( is_wp_error( $uploaded ) ) {
			add_settings_error(
				'sign_documents',
				'upload_failed',
				$uploaded->get_error_message(),
				'error'
			);
			return;
		}

		// Save document to database.
		global $wpdb;

		$table = $wpdb->prefix . 'sign_documents';

		// Get default business ID.
		$business_table = $wpdb->prefix . 'sign_businesses';
		$business_id    = $wpdb->get_var( "SELECT id FROM {$business_table} ORDER BY id ASC LIMIT 1" );

		if ( ! $business_id ) {
			$business_id = 1;
		}

		$data = array(
			'business_id' => $business_id,
			'name'        => sanitize_text_field( $_POST['document_name'] ?? basename( $uploaded['file'] ) ),
			'file_path'   => $uploaded['file'],
			'file_url'    => $uploaded['url'],
			'sequence'    => (int) ( $_POST['sequence'] ?? 0 ),
		);

		$wpdb->insert( $table, $data );

		add_settings_error(
			'sign_documents',
			'document_uploaded',
			__( 'Document uploaded successfully.', 'sign-by-authapi' ),
			'success'
		);
	}

	/**
	 * Handle document PDF upload.
	 *
	 * @since 1.0.0
	 *
	 * @return array|WP_Error Upload data or error.
	 */
	private function handle_document_upload() {
		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		$uploadedfile     = $_FILES['document'];
		$upload_overrides = array(
			'test_form' => false,
			'mimes'     => array( 'pdf' => 'application/pdf' ),
		);

		return wp_handle_upload( $uploadedfile, $upload_overrides );
	}

	/**
	 * Delete document.
	 *
	 * @since 1.0.0
	 *
	 * @param int $document_id Document ID.
	 */
	private function delete_document( $document_id ) {
		global $wpdb;

		$table = $wpdb->prefix . 'sign_documents';

		// Get document file path.
		$document = $wpdb->get_row(
			$wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $document_id ),
			ARRAY_A
		);

		if ( ! $document ) {
			return;
		}

		// Delete file.
		if ( ! empty( $document['file_path'] ) && file_exists( $document['file_path'] ) ) {
			unlink( $document['file_path'] );
		}

		// Delete from database.
		$wpdb->delete( $table, array( 'id' => $document_id ) );

		// Delete associated signature fields.
		$fields_table = $wpdb->prefix . 'sign_fields';
		$wpdb->delete( $fields_table, array( 'document_id' => $document_id ) );

		add_settings_error(
			'sign_documents',
			'document_deleted',
			__( 'Document deleted successfully.', 'sign-by-authapi' ),
			'success'
		);
	}
}
