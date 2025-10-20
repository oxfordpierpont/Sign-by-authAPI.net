<?php
/**
 * Plugin Name: Sign by authAPI.net
 * Plugin URI: https://authapi.net/sign
 * Description: Automate contract signing workflows by converting form submissions into legally-signed PDFs. Integrates with JetFormBuilder and LibreSign for seamless e-signature workflows.
 * Version: 1.0.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: authAPI.net, Oxford Pierpont
 * Author URI: https://authapi.net
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: sign-by-authapi
 * Domain Path: /languages
 *
 * @package SignByAuthAPI
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin constants.
define( 'SIGN_VERSION', '1.0.0' );
define( 'SIGN_PLUGIN_FILE', __FILE__ );
define( 'SIGN_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SIGN_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'SIGN_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * Main plugin class - Sign by authAPI.net
 *
 * This class is the core of the plugin and manages all hooks, dependencies, and initialization.
 *
 * @since 1.0.0
 */
final class Sign_Plugin {

	/**
	 * Single instance of the plugin.
	 *
	 * @var Sign_Plugin|null
	 */
	private static $instance = null;

	/**
	 * Get singleton instance.
	 *
	 * @return Sign_Plugin
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor - Initialize plugin.
	 *
	 * Private constructor to prevent direct instantiation.
	 */
	private function __construct() {
		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_integration_hooks();
	}

	/**
	 * Load all required class files.
	 *
	 * @since 1.0.0
	 */
	private function load_dependencies() {
		// Load Composer autoloader if it exists.
		if ( file_exists( SIGN_PLUGIN_DIR . 'vendor/autoload.php' ) ) {
			require_once SIGN_PLUGIN_DIR . 'vendor/autoload.php';
		}

		// Core classes.
		require_once SIGN_PLUGIN_DIR . 'includes/class-activator.php';
		require_once SIGN_PLUGIN_DIR . 'includes/class-deactivator.php';
		require_once SIGN_PLUGIN_DIR . 'includes/class-post-type.php';

		// Core functionality classes.
		require_once SIGN_PLUGIN_DIR . 'includes/core/class-pdf-generator.php';
		require_once SIGN_PLUGIN_DIR . 'includes/core/class-pdf-combiner.php';
		require_once SIGN_PLUGIN_DIR . 'includes/core/class-libresign-client.php';
		require_once SIGN_PLUGIN_DIR . 'includes/core/class-signing-controller.php';
		require_once SIGN_PLUGIN_DIR . 'includes/core/class-webhook-handler.php';
		require_once SIGN_PLUGIN_DIR . 'includes/core/class-email-manager.php';

		// Admin classes.
		require_once SIGN_PLUGIN_DIR . 'includes/admin/class-admin.php';
		require_once SIGN_PLUGIN_DIR . 'includes/admin/class-settings.php';
		require_once SIGN_PLUGIN_DIR . 'includes/admin/class-branding.php';
		require_once SIGN_PLUGIN_DIR . 'includes/admin/class-documents.php';
		require_once SIGN_PLUGIN_DIR . 'includes/admin/class-field-editor.php';

		// Public classes.
		require_once SIGN_PLUGIN_DIR . 'includes/public/class-dashboard.php';
		require_once SIGN_PLUGIN_DIR . 'includes/public/class-auth.php';
	}

	/**
	 * Register WordPress hooks for admin functionality.
	 *
	 * @since 1.0.0
	 */
	private function define_admin_hooks() {
		$admin = new Sign_Admin();

		// Add admin menu pages.
		add_action( 'admin_menu', array( $admin, 'add_menu_pages' ) );

		// Enqueue admin scripts and styles.
		add_action( 'admin_enqueue_scripts', array( $admin, 'enqueue_scripts' ) );

		// Register settings.
		add_action( 'admin_init', array( $admin, 'register_settings' ) );
	}

	/**
	 * Register WordPress hooks for public-facing functionality.
	 *
	 * @since 1.0.0
	 */
	private function define_public_hooks() {
		$dashboard = new Sign_Dashboard();

		// Register custom rewrite rules.
		add_action( 'init', array( $dashboard, 'register_rewrites' ) );

		// Enqueue public scripts and styles.
		add_action( 'wp_enqueue_scripts', array( $dashboard, 'enqueue_scripts' ) );

		// Register dashboard shortcode.
		add_shortcode( 'sign_dashboard', array( $dashboard, 'render_dashboard' ) );
	}

	/**
	 * Register integration hooks for third-party plugins and APIs.
	 *
	 * @since 1.0.0
	 */
	private function define_integration_hooks() {
		// JetFormBuilder integration.
		add_action(
			'jet-form-builder/form-handler/after-send',
			array( $this, 'handle_form_submission' ),
			10,
			2
		);

		// Register REST API endpoints.
		add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );
	}

	/**
	 * Handle form submission from JetFormBuilder.
	 *
	 * @since 1.0.0
	 *
	 * @param array  $form_data Form field data.
	 * @param object $form      Form object.
	 */
	public function handle_form_submission( $form_data, $form ) {
		$controller = new Sign_Signing_Controller();
		$controller->create_signing_request( $form_data, $form );
	}

	/**
	 * Register REST API routes.
	 *
	 * @since 1.0.0
	 */
	public function register_rest_routes() {
		// Webhook endpoint for LibreSign callbacks.
		register_rest_route(
			'sign/v1',
			'/webhook',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'handle_webhook' ),
				'permission_callback' => '__return_true', // Security verification done in handler.
			)
		);

		// API endpoint for generating PDFs.
		register_rest_route(
			'sign/v1',
			'/generate-pdf/(?P<id>\d+)',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'handle_generate_pdf' ),
				'permission_callback' => array( $this, 'verify_nonce' ),
			)
		);
	}

	/**
	 * Handle webhook callback from LibreSign.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_REST_Request $request REST request object.
	 * @return WP_REST_Response|WP_Error Response object.
	 */
	public function handle_webhook( $request ) {
		$handler = new Sign_Webhook_Handler();
		return $handler->process( $request );
	}

	/**
	 * Handle PDF generation request.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_REST_Request $request REST request object.
	 * @return WP_REST_Response|WP_Error Response object.
	 */
	public function handle_generate_pdf( $request ) {
		$controller = new Sign_Signing_Controller();
		return $controller->generate_and_send_pdf( $request->get_param( 'id' ) );
	}

	/**
	 * Verify nonce for REST API requests.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_REST_Request $request REST request object.
	 * @return bool True if verified, false otherwise.
	 */
	public function verify_nonce( $request ) {
		$nonce = $request->get_header( 'X-WP-Nonce' );
		return wp_verify_nonce( $nonce, 'wp_rest' );
	}
}

/**
 * Plugin activation hook.
 *
 * @since 1.0.0
 */
function activate_sign_plugin() {
	require_once SIGN_PLUGIN_DIR . 'includes/class-activator.php';
	Sign_Activator::activate();
}

/**
 * Plugin deactivation hook.
 *
 * @since 1.0.0
 */
function deactivate_sign_plugin() {
	require_once SIGN_PLUGIN_DIR . 'includes/class-deactivator.php';
	Sign_Deactivator::deactivate();
}

// Register activation and deactivation hooks.
register_activation_hook( __FILE__, 'activate_sign_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_sign_plugin' );

/**
 * Initialize the plugin.
 *
 * @since 1.0.0
 */
function sign_init() {
	// Initialize post type.
	Sign_Post_Type::init();

	// Get plugin instance.
	return Sign_Plugin::get_instance();
}

// Start the plugin.
add_action( 'plugins_loaded', 'sign_init' );
