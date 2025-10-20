<?php
/**
 * Branding Management
 *
 * Handles business branding configuration.
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sign_Branding class
 *
 * @since 1.0.0
 */
class Sign_Branding {

	/**
	 * Render branding page.
	 *
	 * @since 1.0.0
	 */
	public function render() {
		// Handle form submission.
		if ( isset( $_POST['save_branding'] ) && check_admin_referer( 'sign_branding_nonce' ) ) {
			$this->save_branding();
		}

		// Get current branding.
		$branding = $this->get_branding();

		include SIGN_PLUGIN_DIR . 'templates/admin/branding.php';
	}

	/**
	 * Get branding settings.
	 *
	 * @since 1.0.0
	 *
	 * @return array Branding data.
	 */
	private function get_branding() {
		global $wpdb;

		$table = $wpdb->prefix . 'sign_businesses';
		$branding = $wpdb->get_row( "SELECT * FROM {$table} ORDER BY id ASC LIMIT 1", ARRAY_A );

		if ( ! $branding ) {
			return array(
				'id'              => 0,
				'name'            => get_bloginfo( 'name' ),
				'logo_url'        => '',
				'letterhead_path' => '',
				'primary_color'   => '#007bff',
				'secondary_color' => '#6c757d',
				'accent_color'    => '#28a745',
				'company_name'    => get_bloginfo( 'name' ),
				'authorized_rep'  => '',
				'rep_title'       => '',
				'company_email'   => get_option( 'admin_email' ),
				'company_phone'   => '',
				'company_address' => '',
			);
		}

		return $branding;
	}

	/**
	 * Save branding settings.
	 *
	 * @since 1.0.0
	 */
	private function save_branding() {
		global $wpdb;

		$table       = $wpdb->prefix . 'sign_businesses';
		$business_id = isset( $_POST['business_id'] ) ? (int) $_POST['business_id'] : 0;

		$data = array(
			'name'            => sanitize_text_field( $_POST['business_name'] ?? '' ),
			'company_name'    => sanitize_text_field( $_POST['company_name'] ?? '' ),
			'primary_color'   => sanitize_hex_color( $_POST['primary_color'] ?? '#007bff' ),
			'secondary_color' => sanitize_hex_color( $_POST['secondary_color'] ?? '#6c757d' ),
			'accent_color'    => sanitize_hex_color( $_POST['accent_color'] ?? '#28a745' ),
			'authorized_rep'  => sanitize_text_field( $_POST['authorized_rep'] ?? '' ),
			'rep_title'       => sanitize_text_field( $_POST['rep_title'] ?? '' ),
			'company_email'   => sanitize_email( $_POST['company_email'] ?? '' ),
			'company_phone'   => sanitize_text_field( $_POST['company_phone'] ?? '' ),
			'company_address' => sanitize_textarea_field( $_POST['company_address'] ?? '' ),
		);

		// Handle logo upload.
		if ( ! empty( $_FILES['logo']['name'] ) ) {
			$uploaded = $this->handle_logo_upload();
			if ( ! is_wp_error( $uploaded ) ) {
				$data['logo_url'] = $uploaded['url'];
			}
		}

		// Handle letterhead upload.
		if ( ! empty( $_FILES['letterhead']['name'] ) ) {
			$uploaded = $this->handle_letterhead_upload();
			if ( ! is_wp_error( $uploaded ) ) {
				$data['letterhead_path'] = $uploaded['file'];
			}
		}

		if ( $business_id > 0 ) {
			// Update existing.
			$wpdb->update( $table, $data, array( 'id' => $business_id ) );
		} else {
			// Insert new.
			$wpdb->insert( $table, $data );
		}

		add_settings_error(
			'sign_branding',
			'branding_saved',
			__( 'Branding settings saved successfully.', 'sign-by-authapi' ),
			'success'
		);
	}

	/**
	 * Handle logo upload.
	 *
	 * @since 1.0.0
	 *
	 * @return array|WP_Error Upload data or error.
	 */
	private function handle_logo_upload() {
		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		$uploadedfile     = $_FILES['logo'];
		$upload_overrides = array( 'test_form' => false );

		return wp_handle_upload( $uploadedfile, $upload_overrides );
	}

	/**
	 * Handle letterhead PDF upload.
	 *
	 * @since 1.0.0
	 *
	 * @return array|WP_Error Upload data or error.
	 */
	private function handle_letterhead_upload() {
		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		$uploadedfile     = $_FILES['letterhead'];
		$upload_overrides = array(
			'test_form' => false,
			'mimes'     => array( 'pdf' => 'application/pdf' ),
		);

		return wp_handle_upload( $uploadedfile, $upload_overrides );
	}
}
