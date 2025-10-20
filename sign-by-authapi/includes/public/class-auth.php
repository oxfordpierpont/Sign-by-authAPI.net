<?php
/**
 * Authentication
 *
 * Handles token-based authentication for customer dashboard access.
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sign_Auth class
 *
 * @since 1.0.0
 */
class Sign_Auth {

	/**
	 * Verify token.
	 *
	 * @since 1.0.0
	 *
	 * @param string $token Security token.
	 * @return int|false Post ID if valid, false otherwise.
	 */
	public static function verify_token( $token ) {
		if ( empty( $token ) ) {
			return false;
		}

		$args = array(
			'post_type'      => 'sign_request',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'meta_query'     => array(
				array(
					'key'   => 'esign_token',
					'value' => sanitize_text_field( $token ),
				),
			),
		);

		$posts = get_posts( $args );

		if ( empty( $posts ) ) {
			return false;
		}

		return $posts[0]->ID;
	}

	/**
	 * Generate secure token.
	 *
	 * @since 1.0.0
	 *
	 * @return string Secure token.
	 */
	public static function generate_token() {
		return bin2hex( random_bytes( 32 ) );
	}

	/**
	 * Check if current request has valid token.
	 *
	 * @since 1.0.0
	 *
	 * @return bool True if valid token, false otherwise.
	 */
	public static function has_valid_token() {
		$token = isset( $_GET['token'] ) ? sanitize_text_field( $_GET['token'] ) : '';
		return self::verify_token( $token ) !== false;
	}

	/**
	 * Get signing request by token.
	 *
	 * @since 1.0.0
	 *
	 * @param string $token Security token.
	 * @return array|null Signing request data or null.
	 */
	public static function get_signing_request_by_token( $token ) {
		$post_id = self::verify_token( $token );

		if ( ! $post_id ) {
			return null;
		}

		return Sign_Post_Type::get_signing_request( $post_id );
	}
}
