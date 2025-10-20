<?php
/**
 * Plugin Deactivation Handler
 *
 * Handles plugin deactivation tasks.
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sign_Deactivator class
 *
 * @since 1.0.0
 */
class Sign_Deactivator {

	/**
	 * Deactivate the plugin.
	 *
	 * Cleans up scheduled cron jobs and flushes rewrite rules.
	 * Does NOT delete data - that's handled by uninstall.php
	 *
	 * @since 1.0.0
	 */
	public static function deactivate() {
		self::clear_cron_jobs();
		self::log_deactivation();

		// Flush rewrite rules.
		flush_rewrite_rules();
	}

	/**
	 * Clear scheduled cron jobs.
	 *
	 * @since 1.0.0
	 */
	private static function clear_cron_jobs() {
		// Clear reminder cron job.
		$timestamp = wp_next_scheduled( 'sign_send_reminders' );
		if ( $timestamp ) {
			wp_unschedule_event( $timestamp, 'sign_send_reminders' );
		}

		// Clear cleanup cron job.
		$timestamp = wp_next_scheduled( 'sign_cleanup_temp_files' );
		if ( $timestamp ) {
			wp_unschedule_event( $timestamp, 'sign_cleanup_temp_files' );
		}
	}

	/**
	 * Log deactivation event.
	 *
	 * @since 1.0.0
	 */
	private static function log_deactivation() {
		global $wpdb;

		$table = $wpdb->prefix . 'sign_activity_log';

		// Check if table exists before trying to insert.
		$table_exists = $wpdb->get_var( "SHOW TABLES LIKE '{$table}'" ) === $table;

		if ( $table_exists ) {
			$wpdb->insert(
				$table,
				array(
					'cpt_id'     => 0,
					'action'     => 'plugin_deactivated',
					'details'    => 'Sign by authAPI.net plugin deactivated',
					'user_id'    => get_current_user_id(),
					'ip_address' => self::get_user_ip(),
				),
				array( '%d', '%s', '%s', '%d', '%s' )
			);
		}
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
