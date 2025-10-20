<?php
/**
 * Admin Interface
 *
 * Manages all admin functionality and menu pages.
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sign_Admin class
 *
 * @since 1.0.0
 */
class Sign_Admin {

	/**
	 * Add admin menu pages.
	 *
	 * @since 1.0.0
	 */
	public function add_menu_pages() {
		// Main menu page.
		add_menu_page(
			__( 'Sign by authAPI.net', 'sign-by-authapi' ),
			__( 'Sign', 'sign-by-authapi' ),
			'manage_options',
			'sign-plugin',
			array( $this, 'render_dashboard_page' ),
			'dashicons-edit-page',
			30
		);

		// Dashboard submenu.
		add_submenu_page(
			'sign-plugin',
			__( 'Dashboard', 'sign-by-authapi' ),
			__( 'Dashboard', 'sign-by-authapi' ),
			'manage_options',
			'sign-plugin',
			array( $this, 'render_dashboard_page' )
		);

		// Branding submenu.
		add_submenu_page(
			'sign-plugin',
			__( 'Branding', 'sign-by-authapi' ),
			__( 'Branding', 'sign-by-authapi' ),
			'manage_options',
			'sign-branding',
			array( $this, 'render_branding_page' )
		);

		// Documents submenu.
		add_submenu_page(
			'sign-plugin',
			__( 'Documents', 'sign-by-authapi' ),
			__( 'Documents', 'sign-by-authapi' ),
			'manage_options',
			'sign-documents',
			array( $this, 'render_documents_page' )
		);

		// Settings submenu.
		add_submenu_page(
			'sign-plugin',
			__( 'Settings', 'sign-by-authapi' ),
			__( 'Settings', 'sign-by-authapi' ),
			'manage_options',
			'sign-settings',
			array( $this, 'render_settings_page' )
		);

		// Activity Log submenu.
		add_submenu_page(
			'sign-plugin',
			__( 'Activity Log', 'sign-by-authapi' ),
			__( 'Activity Log', 'sign-by-authapi' ),
			'manage_options',
			'sign-activity-log',
			array( $this, 'render_activity_log_page' )
		);
	}

	/**
	 * Enqueue admin scripts and styles.
	 *
	 * @since 1.0.0
	 *
	 * @param string $hook Current admin page hook.
	 */
	public function enqueue_scripts( $hook ) {
		// Only load on our plugin pages.
		if ( strpos( $hook, 'sign-' ) === false && strpos( $hook, 'sign_request' ) === false ) {
			return;
		}

		// Enqueue CSS.
		wp_enqueue_style(
			'sign-admin-css',
			SIGN_PLUGIN_URL . 'assets/css/admin.css',
			array(),
			SIGN_VERSION
		);

		// Enqueue JS.
		wp_enqueue_script(
			'sign-admin-js',
			SIGN_PLUGIN_URL . 'assets/js/admin.js',
			array( 'jquery' ),
			SIGN_VERSION,
			true
		);

		// Localize script.
		wp_localize_script(
			'sign-admin-js',
			'signAdminData',
			array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'nonce'   => wp_create_nonce( 'sign_admin_nonce' ),
			)
		);
	}

	/**
	 * Register settings.
	 *
	 * @since 1.0.0
	 */
	public function register_settings() {
		$settings = new Sign_Settings();
		$settings->register();
	}

	/**
	 * Render dashboard page.
	 *
	 * @since 1.0.0
	 */
	public function render_dashboard_page() {
		include SIGN_PLUGIN_DIR . 'templates/admin/dashboard.php';
	}

	/**
	 * Render branding page.
	 *
	 * @since 1.0.0
	 */
	public function render_branding_page() {
		$branding = new Sign_Branding();
		$branding->render();
	}

	/**
	 * Render documents page.
	 *
	 * @since 1.0.0
	 */
	public function render_documents_page() {
		$documents = new Sign_Documents();
		$documents->render();
	}

	/**
	 * Render settings page.
	 *
	 * @since 1.0.0
	 */
	public function render_settings_page() {
		include SIGN_PLUGIN_DIR . 'templates/admin/settings.php';
	}

	/**
	 * Render activity log page.
	 *
	 * @since 1.0.0
	 */
	public function render_activity_log_page() {
		include SIGN_PLUGIN_DIR . 'templates/admin/activity-log.php';
	}
}
