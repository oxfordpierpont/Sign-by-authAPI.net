<?php
/**
 * Custom Post Type Registration
 *
 * Registers the 'sign_request' custom post type for storing signing requests.
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sign_Post_Type class
 *
 * @since 1.0.0
 */
class Sign_Post_Type {

	/**
	 * Initialize the custom post type.
	 *
	 * @since 1.0.0
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
		add_action( 'init', array( __CLASS__, 'register_meta_fields' ) );
	}

	/**
	 * Register the custom post type.
	 *
	 * @since 1.0.0
	 */
	public static function register_post_type() {
		$labels = array(
			'name'                  => _x( 'Signing Requests', 'Post type general name', 'sign-by-authapi' ),
			'singular_name'         => _x( 'Signing Request', 'Post type singular name', 'sign-by-authapi' ),
			'menu_name'             => _x( 'Signing Requests', 'Admin Menu text', 'sign-by-authapi' ),
			'name_admin_bar'        => _x( 'Signing Request', 'Add New on Toolbar', 'sign-by-authapi' ),
			'add_new'               => __( 'Add New', 'sign-by-authapi' ),
			'add_new_item'          => __( 'Add New Signing Request', 'sign-by-authapi' ),
			'new_item'              => __( 'New Signing Request', 'sign-by-authapi' ),
			'edit_item'             => __( 'Edit Signing Request', 'sign-by-authapi' ),
			'view_item'             => __( 'View Signing Request', 'sign-by-authapi' ),
			'all_items'             => __( 'All Requests', 'sign-by-authapi' ),
			'search_items'          => __( 'Search Signing Requests', 'sign-by-authapi' ),
			'parent_item_colon'     => __( 'Parent Signing Requests:', 'sign-by-authapi' ),
			'not_found'             => __( 'No signing requests found.', 'sign-by-authapi' ),
			'not_found_in_trash'    => __( 'No signing requests found in Trash.', 'sign-by-authapi' ),
			'featured_image'        => _x( 'Signing Request Image', 'Overrides the "Featured Image" phrase', 'sign-by-authapi' ),
			'set_featured_image'    => _x( 'Set image', 'Overrides the "Set featured image" phrase', 'sign-by-authapi' ),
			'remove_featured_image' => _x( 'Remove image', 'Overrides the "Remove featured image" phrase', 'sign-by-authapi' ),
			'use_featured_image'    => _x( 'Use as image', 'Overrides the "Use as featured image" phrase', 'sign-by-authapi' ),
			'archives'              => _x( 'Signing Request archives', 'The post type archive label', 'sign-by-authapi' ),
			'insert_into_item'      => _x( 'Insert into signing request', 'Overrides the "Insert into post" phrase', 'sign-by-authapi' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this signing request', 'Overrides the "Uploaded to this post" phrase', 'sign-by-authapi' ),
			'filter_items_list'     => _x( 'Filter signing requests list', 'Screen reader text for the filter links', 'sign-by-authapi' ),
			'items_list_navigation' => _x( 'Signing requests list navigation', 'Screen reader text for the pagination', 'sign-by-authapi' ),
			'items_list'            => _x( 'Signing requests list', 'Screen reader text for the items list', 'sign-by-authapi' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => 'sign-plugin',
			'query_var'          => false,
			'rewrite'            => false,
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' ),
			'show_in_rest'       => false,
		);

		register_post_type( 'sign_request', $args );
	}

	/**
	 * Register meta fields for the custom post type.
	 *
	 * @since 1.0.0
	 */
	public static function register_meta_fields() {
		// Standard customer information fields.
		$standard_fields = array(
			'esign_first_name',
			'esign_last_name',
			'esign_email',
			'esign_phone',
			'esign_address_line1',
			'esign_address_line2',
			'esign_city',
			'esign_state',
			'esign_zip',
		);

		foreach ( $standard_fields as $field ) {
			register_post_meta(
				'sign_request',
				$field,
				array(
					'type'          => 'string',
					'description'   => 'Customer information field',
					'single'        => true,
					'show_in_rest'  => false,
					'auth_callback' => function() {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}

		// System fields.
		$system_fields = array(
			'esign_business_id'       => 'integer',
			'esign_signing_status'    => 'string',
			'esign_token'             => 'string',
			'esign_libresign_uuid'    => 'string',
			'esign_signed_pdf_url'    => 'string',
			'esign_certificate_url'   => 'string',
			'esign_signed_date'       => 'string',
			'esign_signer_ip'         => 'string',
			'esign_created_at'        => 'string',
			'esign_sent_at'           => 'string',
			'esign_last_reminder_at'  => 'string',
			'esign_reminder_count'    => 'integer',
		);

		foreach ( $system_fields as $field => $type ) {
			register_post_meta(
				'sign_request',
				$field,
				array(
					'type'          => $type,
					'description'   => 'System field for signing workflow',
					'single'        => true,
					'show_in_rest'  => false,
					'auth_callback' => function() {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}
	}

	/**
	 * Get signing request by ID.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id Post ID.
	 * @return array|null Signing request data or null if not found.
	 */
	public static function get_signing_request( $post_id ) {
		$post = get_post( $post_id );

		if ( ! $post || 'sign_request' !== $post->post_type ) {
			return null;
		}

		$meta = get_post_meta( $post_id );
		$data = array(
			'id'    => $post->ID,
			'title' => $post->post_title,
		);

		// Extract all meta fields.
		foreach ( $meta as $key => $value ) {
			if ( strpos( $key, 'esign_' ) === 0 ) {
				$data[ $key ] = is_array( $value ) && count( $value ) === 1 ? $value[0] : $value;
			} else {
				// Custom fields (not starting with esign_).
				if ( strpos( $key, '_' ) !== 0 ) {
					$data[ $key ] = is_array( $value ) && count( $value ) === 1 ? $value[0] : $value;
				}
			}
		}

		return $data;
	}

	/**
	 * Get all signing requests by status.
	 *
	 * @since 1.0.0
	 *
	 * @param string $status Signing status (incomplete|complete).
	 * @param int    $user_id Optional user ID to filter by.
	 * @return array Array of signing request data.
	 */
	public static function get_signing_requests_by_status( $status, $user_id = null ) {
		$args = array(
			'post_type'      => 'sign_request',
			'post_status'    => 'any',
			'posts_per_page' => -1,
			'meta_query'     => array(
				array(
					'key'   => 'esign_signing_status',
					'value' => $status,
				),
			),
		);

		if ( $user_id ) {
			$args['author'] = $user_id;
		}

		$posts = get_posts( $args );
		$requests = array();

		foreach ( $posts as $post ) {
			$requests[] = self::get_signing_request( $post->ID );
		}

		return $requests;
	}

	/**
	 * Update signing request meta.
	 *
	 * @since 1.0.0
	 *
	 * @param int   $post_id Post ID.
	 * @param array $data Meta data to update.
	 * @return bool True on success, false on failure.
	 */
	public static function update_signing_request( $post_id, $data ) {
		$post = get_post( $post_id );

		if ( ! $post || 'sign_request' !== $post->post_type ) {
			return false;
		}

		foreach ( $data as $key => $value ) {
			update_post_meta( $post_id, $key, $value );
		}

		return true;
	}
}
