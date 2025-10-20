<?php
/**
 * Plugin Activation Handler
 *
 * Handles plugin activation tasks including database table creation.
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sign_Activator class
 *
 * @since 1.0.0
 */
class Sign_Activator {

	/**
	 * Activate the plugin.
	 *
	 * Creates database tables and sets up default options.
	 *
	 * @since 1.0.0
	 */
	public static function activate() {
		self::create_tables();
		self::set_default_options();
		self::schedule_cron_jobs();

		// Flush rewrite rules.
		flush_rewrite_rules();

		// Log activation.
		self::log_activation();
	}

	/**
	 * Create custom database tables.
	 *
	 * @since 1.0.0
	 */
	private static function create_tables() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		// Table 1: Businesses (Multi-tenant support).
		$table_businesses = $wpdb->prefix . 'sign_businesses';
		$sql_businesses   = "CREATE TABLE IF NOT EXISTS {$table_businesses} (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			name VARCHAR(255) NOT NULL,
			logo_url VARCHAR(500),
			letterhead_path VARCHAR(500),
			primary_color VARCHAR(7) DEFAULT '#007bff',
			secondary_color VARCHAR(7) DEFAULT '#6c757d',
			accent_color VARCHAR(7) DEFAULT '#28a745',
			company_name VARCHAR(255),
			authorized_rep VARCHAR(255),
			rep_title VARCHAR(255),
			company_email VARCHAR(255),
			company_phone VARCHAR(50),
			company_address TEXT,
			created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
			updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (id)
		) {$charset_collate};";

		// Table 2: Documents (Uploaded contract PDFs).
		$table_documents = $wpdb->prefix . 'sign_documents';
		$sql_documents   = "CREATE TABLE IF NOT EXISTS {$table_documents} (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			business_id BIGINT(20) UNSIGNED NOT NULL,
			name VARCHAR(255) NOT NULL,
			file_path VARCHAR(500) NOT NULL,
			file_url VARCHAR(500) NOT NULL,
			sequence INT DEFAULT 0,
			created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
			updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			KEY business_id (business_id),
			KEY sequence (sequence)
		) {$charset_collate};";

		// Table 3: Signature Fields (Field coordinates for each document).
		$table_fields = $wpdb->prefix . 'sign_fields';
		$sql_fields   = "CREATE TABLE IF NOT EXISTS {$table_fields} (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			business_id BIGINT(20) UNSIGNED NOT NULL,
			document_id BIGINT(20) UNSIGNED NOT NULL,
			type ENUM('signature', 'initial', 'date', 'text') NOT NULL,
			label VARCHAR(255),
			page INT NOT NULL,
			x INT NOT NULL,
			y INT NOT NULL,
			width INT NOT NULL,
			height INT NOT NULL,
			required BOOLEAN DEFAULT TRUE,
			created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			KEY business_id (business_id),
			KEY document_id (document_id)
		) {$charset_collate};";

		// Table 4: Activity Log (Audit trail).
		$table_log = $wpdb->prefix . 'sign_activity_log';
		$sql_log   = "CREATE TABLE IF NOT EXISTS {$table_log} (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			cpt_id BIGINT(20) UNSIGNED NOT NULL,
			action VARCHAR(100) NOT NULL,
			details TEXT,
			user_id BIGINT(20) UNSIGNED,
			ip_address VARCHAR(45),
			created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (id),
			KEY cpt_id (cpt_id),
			KEY action (action),
			KEY created_at (created_at)
		) {$charset_collate};";

		// Execute table creation.
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql_businesses );
		dbDelta( $sql_documents );
		dbDelta( $sql_fields );
		dbDelta( $sql_log );

		// Create default business if none exists.
		self::create_default_business();
	}

	/**
	 * Create default business entry.
	 *
	 * @since 1.0.0
	 */
	private static function create_default_business() {
		global $wpdb;

		$table     = $wpdb->prefix . 'sign_businesses';
		$row_count = $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );

		if ( 0 === (int) $row_count ) {
			$site_name = get_bloginfo( 'name' );
			$admin_email = get_bloginfo( 'admin_email' );

			$wpdb->insert(
				$table,
				array(
					'name'          => $site_name,
					'company_name'  => $site_name,
					'company_email' => $admin_email,
				),
				array( '%s', '%s', '%s' )
			);
		}
	}

	/**
	 * Set default plugin options.
	 *
	 * @since 1.0.0
	 */
	private static function set_default_options() {
		// LibreSign settings.
		add_option( 'sign_libresign_url', '' );
		add_option( 'sign_libresign_api_key', '' );

		// General settings.
		add_option( 'sign_active', false );
		add_option( 'sign_reminder_enabled', true );
		add_option( 'sign_reminder_interval', 3 ); // Days.

		// Email settings.
		add_option( 'sign_email_from_name', get_bloginfo( 'name' ) );
		add_option( 'sign_email_from_address', get_bloginfo( 'admin_email' ) );

		// Redirect URLs.
		add_option( 'sign_after_signing_url', home_url() );
		add_option( 'sign_cancel_url', home_url() );

		// Store activation time.
		add_option( 'sign_activated_at', current_time( 'mysql' ) );
		add_option( 'sign_version', SIGN_VERSION );
	}

	/**
	 * Schedule WordPress cron jobs.
	 *
	 * @since 1.0.0
	 */
	private static function schedule_cron_jobs() {
		// Schedule reminder email cron job (runs daily).
		if ( ! wp_next_scheduled( 'sign_send_reminders' ) ) {
			wp_schedule_event( time(), 'daily', 'sign_send_reminders' );
		}

		// Schedule cleanup cron job (runs weekly).
		if ( ! wp_next_scheduled( 'sign_cleanup_temp_files' ) ) {
			wp_schedule_event( time(), 'weekly', 'sign_cleanup_temp_files' );
		}
	}

	/**
	 * Log activation event.
	 *
	 * @since 1.0.0
	 */
	private static function log_activation() {
		global $wpdb;

		$table = $wpdb->prefix . 'sign_activity_log';

		$wpdb->insert(
			$table,
			array(
				'cpt_id'     => 0,
				'action'     => 'plugin_activated',
				'details'    => 'Sign by authAPI.net plugin activated',
				'user_id'    => get_current_user_id(),
				'ip_address' => self::get_user_ip(),
			),
			array( '%d', '%s', '%s', '%d', '%s' )
		);
	}

	/**
	 * Get user IP address.
	 *
	 * @since 1.0.0
	 * @return string IP address.
	 */
	private static function get_user_ip() {
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
