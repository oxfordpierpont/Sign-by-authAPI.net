<?php
/**
 * Field Editor
 *
 * Visual editor for placing signature fields on PDFs.
 * This is a placeholder for the complex visual editor implementation.
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sign_Field_Editor class
 *
 * @since 1.0.0
 */
class Sign_Field_Editor {

	/**
	 * Render field editor page.
	 *
	 * @since 1.0.0
	 */
	public function render() {
		// Note: This will require implementation of PDF.js and Fabric.js integration
		// For now, provide a basic interface for manually adding field coordinates.

		include SIGN_PLUGIN_DIR . 'templates/admin/field-editor.php';
	}

	/**
	 * Get signature fields for a document.
	 *
	 * @since 1.0.0
	 *
	 * @param int $document_id Document ID.
	 * @return array Signature fields.
	 */
	public function get_fields( $document_id ) {
		global $wpdb;

		$table = $wpdb->prefix . 'sign_fields';
		$fields = $wpdb->get_results(
			$wpdb->prepare( "SELECT * FROM {$table} WHERE document_id = %d ORDER BY page, y, x", $document_id ),
			ARRAY_A
		);

		return $fields ? $fields : array();
	}

	/**
	 * Save signature field.
	 *
	 * @since 1.0.0
	 *
	 * @param array $field_data Field data.
	 * @return int|false Field ID or false on failure.
	 */
	public function save_field( $field_data ) {
		global $wpdb;

		$table = $wpdb->prefix . 'sign_fields';

		$data = array(
			'business_id' => (int) $field_data['business_id'],
			'document_id' => (int) $field_data['document_id'],
			'type'        => sanitize_text_field( $field_data['type'] ),
			'label'       => sanitize_text_field( $field_data['label'] ?? '' ),
			'page'        => (int) $field_data['page'],
			'x'           => (int) $field_data['x'],
			'y'           => (int) $field_data['y'],
			'width'       => (int) $field_data['width'],
			'height'      => (int) $field_data['height'],
			'required'    => isset( $field_data['required'] ) ? (bool) $field_data['required'] : true,
		);

		$result = $wpdb->insert( $table, $data );

		return $result ? $wpdb->insert_id : false;
	}

	/**
	 * Delete signature field.
	 *
	 * @since 1.0.0
	 *
	 * @param int $field_id Field ID.
	 * @return bool True on success, false on failure.
	 */
	public function delete_field( $field_id ) {
		global $wpdb;

		$table = $wpdb->prefix . 'sign_fields';

		return (bool) $wpdb->delete( $table, array( 'id' => $field_id ) );
	}
}
