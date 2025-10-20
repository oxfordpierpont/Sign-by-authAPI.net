<?php
/**
 * Settings Management
 *
 * Handles plugin settings registration and sanitization.
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sign_Settings class
 *
 * @since 1.0.0
 */
class Sign_Settings {

	/**
	 * Register settings.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		// LibreSign Settings Section.
		add_settings_section(
			'sign_libresign_section',
			__( 'LibreSign API Configuration', 'sign-by-authapi' ),
			array( $this, 'render_libresign_section' ),
			'sign-settings'
		);

		register_setting( 'sign_settings_group', 'sign_libresign_url', array( 'sanitize_callback' => 'esc_url_raw' ) );
		register_setting( 'sign_settings_group', 'sign_libresign_api_key', array( 'sanitize_callback' => 'sanitize_text_field' ) );

		add_settings_field(
			'sign_libresign_url',
			__( 'LibreSign API URL', 'sign-by-authapi' ),
			array( $this, 'render_libresign_url_field' ),
			'sign-settings',
			'sign_libresign_section'
		);

		add_settings_field(
			'sign_libresign_api_key',
			__( 'API Key', 'sign-by-authapi' ),
			array( $this, 'render_libresign_api_key_field' ),
			'sign-settings',
			'sign_libresign_section'
		);

		// General Settings Section.
		add_settings_section(
			'sign_general_section',
			__( 'General Settings', 'sign-by-authapi' ),
			array( $this, 'render_general_section' ),
			'sign-settings'
		);

		register_setting( 'sign_settings_group', 'sign_active', array( 'sanitize_callback' => array( $this, 'sanitize_checkbox' ) ) );
		register_setting( 'sign_settings_group', 'sign_reminder_enabled', array( 'sanitize_callback' => array( $this, 'sanitize_checkbox' ) ) );
		register_setting( 'sign_settings_group', 'sign_reminder_interval', array( 'sanitize_callback' => 'absint' ) );

		add_settings_field(
			'sign_active',
			__( 'Activate Plugin', 'sign-by-authapi' ),
			array( $this, 'render_active_field' ),
			'sign-settings',
			'sign_general_section'
		);

		add_settings_field(
			'sign_reminder_enabled',
			__( 'Enable Reminders', 'sign-by-authapi' ),
			array( $this, 'render_reminder_enabled_field' ),
			'sign-settings',
			'sign_general_section'
		);

		add_settings_field(
			'sign_reminder_interval',
			__( 'Reminder Interval (Days)', 'sign-by-authapi' ),
			array( $this, 'render_reminder_interval_field' ),
			'sign-settings',
			'sign_general_section'
		);

		// Email Settings Section.
		add_settings_section(
			'sign_email_section',
			__( 'Email Settings', 'sign-by-authapi' ),
			array( $this, 'render_email_section' ),
			'sign-settings'
		);

		register_setting( 'sign_settings_group', 'sign_email_from_name', array( 'sanitize_callback' => 'sanitize_text_field' ) );
		register_setting( 'sign_settings_group', 'sign_email_from_address', array( 'sanitize_callback' => 'sanitize_email' ) );

		add_settings_field(
			'sign_email_from_name',
			__( 'From Name', 'sign-by-authapi' ),
			array( $this, 'render_email_from_name_field' ),
			'sign-settings',
			'sign_email_section'
		);

		add_settings_field(
			'sign_email_from_address',
			__( 'From Email Address', 'sign-by-authapi' ),
			array( $this, 'render_email_from_address_field' ),
			'sign-settings',
			'sign_email_section'
		);

		// Redirect Settings Section.
		add_settings_section(
			'sign_redirect_section',
			__( 'Redirect URLs', 'sign-by-authapi' ),
			array( $this, 'render_redirect_section' ),
			'sign-settings'
		);

		register_setting( 'sign_settings_group', 'sign_after_signing_url', array( 'sanitize_callback' => 'esc_url_raw' ) );
		register_setting( 'sign_settings_group', 'sign_cancel_url', array( 'sanitize_callback' => 'esc_url_raw' ) );

		add_settings_field(
			'sign_after_signing_url',
			__( 'After Signing Redirect URL', 'sign-by-authapi' ),
			array( $this, 'render_after_signing_url_field' ),
			'sign-settings',
			'sign_redirect_section'
		);

		add_settings_field(
			'sign_cancel_url',
			__( 'Cancel Redirect URL', 'sign-by-authapi' ),
			array( $this, 'render_cancel_url_field' ),
			'sign-settings',
			'sign_redirect_section'
		);
	}

	/**
	 * Sanitize checkbox value.
	 *
	 * @since 1.0.0
	 *
	 * @param mixed $value Input value.
	 * @return bool Sanitized value.
	 */
	public function sanitize_checkbox( $value ) {
		return (bool) $value;
	}

	/**
	 * Render LibreSign section description.
	 *
	 * @since 1.0.0
	 */
	public function render_libresign_section() {
		echo '<p>' . esc_html__( 'Configure your LibreSign API connection settings.', 'sign-by-authapi' ) . '</p>';
	}

	/**
	 * Render LibreSign URL field.
	 *
	 * @since 1.0.0
	 */
	public function render_libresign_url_field() {
		$value = get_option( 'sign_libresign_url', '' );
		echo '<input type="url" name="sign_libresign_url" value="' . esc_attr( $value ) . '" class="regular-text" placeholder="https://your-libresign-instance.com">';
		echo '<p class="description">' . esc_html__( 'The URL of your LibreSign instance (e.g., https://libresign.example.com)', 'sign-by-authapi' ) . '</p>';
	}

	/**
	 * Render LibreSign API key field.
	 *
	 * @since 1.0.0
	 */
	public function render_libresign_api_key_field() {
		$value = get_option( 'sign_libresign_api_key', '' );
		echo '<input type="password" name="sign_libresign_api_key" value="' . esc_attr( $value ) . '" class="regular-text">';
		echo '<p class="description">' . esc_html__( 'Your LibreSign API key', 'sign-by-authapi' ) . '</p>';
	}

	/**
	 * Render general section description.
	 *
	 * @since 1.0.0
	 */
	public function render_general_section() {
		echo '<p>' . esc_html__( 'General plugin settings.', 'sign-by-authapi' ) . '</p>';
	}

	/**
	 * Render active field.
	 *
	 * @since 1.0.0
	 */
	public function render_active_field() {
		$value = get_option( 'sign_active', false );
		echo '<label><input type="checkbox" name="sign_active" value="1" ' . checked( $value, true, false ) . '> ';
		echo esc_html__( 'Enable signing workflow', 'sign-by-authapi' ) . '</label>';
		echo '<p class="description">' . esc_html__( 'When enabled, form submissions will trigger the signing workflow.', 'sign-by-authapi' ) . '</p>';
	}

	/**
	 * Render reminder enabled field.
	 *
	 * @since 1.0.0
	 */
	public function render_reminder_enabled_field() {
		$value = get_option( 'sign_reminder_enabled', true );
		echo '<label><input type="checkbox" name="sign_reminder_enabled" value="1" ' . checked( $value, true, false ) . '> ';
		echo esc_html__( 'Send reminder emails for incomplete signatures', 'sign-by-authapi' ) . '</label>';
	}

	/**
	 * Render reminder interval field.
	 *
	 * @since 1.0.0
	 */
	public function render_reminder_interval_field() {
		$value = get_option( 'sign_reminder_interval', 3 );
		echo '<input type="number" name="sign_reminder_interval" value="' . esc_attr( $value ) . '" class="small-text" min="1" max="30"> ';
		echo esc_html__( 'days', 'sign-by-authapi' );
		echo '<p class="description">' . esc_html__( 'How often to send reminder emails (in days).', 'sign-by-authapi' ) . '</p>';
	}

	/**
	 * Render email section description.
	 *
	 * @since 1.0.0
	 */
	public function render_email_section() {
		echo '<p>' . esc_html__( 'Configure email notification settings.', 'sign-by-authapi' ) . '</p>';
	}

	/**
	 * Render email from name field.
	 *
	 * @since 1.0.0
	 */
	public function render_email_from_name_field() {
		$value = get_option( 'sign_email_from_name', get_bloginfo( 'name' ) );
		echo '<input type="text" name="sign_email_from_name" value="' . esc_attr( $value ) . '" class="regular-text">';
	}

	/**
	 * Render email from address field.
	 *
	 * @since 1.0.0
	 */
	public function render_email_from_address_field() {
		$value = get_option( 'sign_email_from_address', get_option( 'admin_email' ) );
		echo '<input type="email" name="sign_email_from_address" value="' . esc_attr( $value ) . '" class="regular-text">';
	}

	/**
	 * Render redirect section description.
	 *
	 * @since 1.0.0
	 */
	public function render_redirect_section() {
		echo '<p>' . esc_html__( 'Configure where customers are redirected after signing.', 'sign-by-authapi' ) . '</p>';
	}

	/**
	 * Render after signing URL field.
	 *
	 * @since 1.0.0
	 */
	public function render_after_signing_url_field() {
		$value = get_option( 'sign_after_signing_url', home_url() );
		echo '<input type="url" name="sign_after_signing_url" value="' . esc_attr( $value ) . '" class="regular-text">';
		echo '<p class="description">' . esc_html__( 'Where to redirect customers after successfully signing.', 'sign-by-authapi' ) . '</p>';
	}

	/**
	 * Render cancel URL field.
	 *
	 * @since 1.0.0
	 */
	public function render_cancel_url_field() {
		$value = get_option( 'sign_cancel_url', home_url() );
		echo '<input type="url" name="sign_cancel_url" value="' . esc_attr( $value ) . '" class="regular-text">';
		echo '<p class="description">' . esc_html__( 'Where to redirect if customer cancels the signing process.', 'sign-by-authapi' ) . '</p>';
	}
}
