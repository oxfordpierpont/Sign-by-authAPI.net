<?php
/**
 * Public Dashboard
 *
 * Customer-facing signing dashboard.
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sign_Dashboard class
 *
 * @since 1.0.0
 */
class Sign_Dashboard {

	/**
	 * Register rewrite rules.
	 *
	 * @since 1.0.0
	 */
	public function register_rewrites() {
		add_rewrite_rule( '^signing-dashboard/?$', 'index.php?signing_dashboard=1', 'top' );
		add_rewrite_tag( '%signing_dashboard%', '1' );
	}

	/**
	 * Enqueue public scripts and styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {
		// Only enqueue on dashboard page.
		if ( ! is_page( 'signing-dashboard' ) && ! get_query_var( 'signing_dashboard' ) ) {
			return;
		}

		wp_enqueue_style(
			'sign-public-css',
			SIGN_PLUGIN_URL . 'assets/css/public.css',
			array(),
			SIGN_VERSION
		);

		wp_enqueue_script(
			'sign-public-js',
			SIGN_PLUGIN_URL . 'assets/js/public.js',
			array( 'jquery' ),
			SIGN_VERSION,
			true
		);

		wp_localize_script(
			'sign-public-js',
			'signPublicData',
			array(
				'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
				'restUrl'  => rest_url( 'sign/v1' ),
				'nonce'    => wp_create_nonce( 'wp_rest' ),
			)
		);
	}

	/**
	 * Render dashboard shortcode.
	 *
	 * @since 1.0.0
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string Dashboard HTML.
	 */
	public function render_dashboard( $atts = array() ) {
		// Check for token authentication.
		$token = isset( $_GET['token'] ) ? sanitize_text_field( $_GET['token'] ) : '';

		if ( empty( $token ) ) {
			return $this->render_error( __( 'Invalid access. Please use the link from your email.', 'sign-by-authapi' ) );
		}

		// Get signing request by token.
		$signing_request = $this->get_signing_request_by_token( $token );

		if ( ! $signing_request ) {
			return $this->render_error( __( 'Signing request not found.', 'sign-by-authapi' ) );
		}

		// Get signing status.
		$status = $signing_request['esign_signing_status'] ?? 'incomplete';

		if ( 'complete' === $status ) {
			return $this->render_completed_view( $signing_request );
		}

		return $this->render_pending_view( $signing_request );
	}

	/**
	 * Get signing request by token.
	 *
	 * @since 1.0.0
	 *
	 * @param string $token Security token.
	 * @return array|null Signing request data or null.
	 */
	private function get_signing_request_by_token( $token ) {
		$args = array(
			'post_type'      => 'sign_request',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'meta_query'     => array(
				array(
					'key'   => 'esign_token',
					'value' => $token,
				),
			),
		);

		$posts = get_posts( $args );

		if ( empty( $posts ) ) {
			return null;
		}

		return Sign_Post_Type::get_signing_request( $posts[0]->ID );
	}

	/**
	 * Render error message.
	 *
	 * @since 1.0.0
	 *
	 * @param string $message Error message.
	 * @return string Error HTML.
	 */
	private function render_error( $message ) {
		ob_start();
		?>
		<div class="sign-dashboard-error">
			<p><?php echo esc_html( $message ); ?></p>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render pending view.
	 *
	 * @since 1.0.0
	 *
	 * @param array $signing_request Signing request data.
	 * @return string Dashboard HTML.
	 */
	private function render_pending_view( $signing_request ) {
		$cpt_id = $signing_request['id'];
		$name   = $signing_request['esign_first_name'] . ' ' . $signing_request['esign_last_name'];

		ob_start();
		?>
		<div class="sign-dashboard">
			<div class="sign-dashboard-header">
				<h1><?php echo esc_html__( 'Contract Signing', 'sign-by-authapi' ); ?></h1>
				<p><?php echo sprintf( esc_html__( 'Welcome, %s', 'sign-by-authapi' ), esc_html( $name ) ); ?></p>
			</div>

			<div class="sign-dashboard-content">
				<div class="sign-pending-notice">
					<h2><?php echo esc_html__( 'You have 1 document pending signature', 'sign-by-authapi' ); ?></h2>
					<p><?php echo esc_html__( 'Please review and sign your contract to complete the process.', 'sign-by-authapi' ); ?></p>
				</div>

				<div class="sign-actions">
					<button class="sign-button sign-button-primary" onclick="signDocument(<?php echo esc_js( $cpt_id ); ?>)">
						<?php echo esc_html__( 'Review & Sign Contract', 'sign-by-authapi' ); ?>
					</button>
				</div>
			</div>
		</div>

		<script>
		function signDocument(cptId) {
			// Generate PDF and get signing URL from LibreSign
			fetch('<?php echo esc_url( rest_url( 'sign/v1/generate-pdf/' ) ); ?>' + cptId, {
				method: 'POST',
				headers: {
					'X-WP-Nonce': '<?php echo esc_js( wp_create_nonce( 'wp_rest' ) ); ?>'
				}
			})
			.then(response => response.json())
			.then(data => {
				if (data.signing_url) {
					window.location.href = data.signing_url;
				} else {
					alert('<?php echo esc_js( __( 'Error generating document. Please try again.', 'sign-by-authapi' ) ); ?>');
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert('<?php echo esc_js( __( 'Error generating document. Please try again.', 'sign-by-authapi' ) ); ?>');
			});
		}
		</script>
		<?php
		return ob_get_clean();
	}

	/**
	 * Render completed view.
	 *
	 * @since 1.0.0
	 *
	 * @param array $signing_request Signing request data.
	 * @return string Dashboard HTML.
	 */
	private function render_completed_view( $signing_request ) {
		$name        = $signing_request['esign_first_name'] . ' ' . $signing_request['esign_last_name'];
		$signed_date = $signing_request['esign_signed_date'] ?? '';
		$signed_pdf  = $signing_request['esign_signed_pdf_url'] ?? '';
		$certificate = $signing_request['esign_certificate_url'] ?? '';

		ob_start();
		?>
		<div class="sign-dashboard">
			<div class="sign-dashboard-header">
				<h1><?php echo esc_html__( 'Contract Signing', 'sign-by-authapi' ); ?></h1>
				<p><?php echo sprintf( esc_html__( 'Welcome, %s', 'sign-by-authapi' ), esc_html( $name ) ); ?></p>
			</div>

			<div class="sign-dashboard-content">
				<div class="sign-completed-notice">
					<h2><?php echo esc_html__( 'Your contract has been signed successfully!', 'sign-by-authapi' ); ?></h2>
					<?php if ( $signed_date ) : ?>
						<p><?php echo sprintf( esc_html__( 'Signed on: %s', 'sign-by-authapi' ), esc_html( gmdate( 'F j, Y g:i A', strtotime( $signed_date ) ) ) ); ?></p>
					<?php endif; ?>
				</div>

				<div class="sign-downloads">
					<h3><?php echo esc_html__( 'Download Your Documents', 'sign-by-authapi' ); ?></h3>
					<?php if ( $signed_pdf && file_exists( $signed_pdf ) ) : ?>
						<p><a href="<?php echo esc_url( wp_get_attachment_url( $signed_pdf ) ); ?>" class="sign-button" download>
							<?php echo esc_html__( 'Download Signed Contract', 'sign-by-authapi' ); ?>
						</a></p>
					<?php endif; ?>
					<?php if ( $certificate && file_exists( $certificate ) ) : ?>
						<p><a href="<?php echo esc_url( wp_get_attachment_url( $certificate ) ); ?>" class="sign-button" download>
							<?php echo esc_html__( 'Download Verification Certificate', 'sign-by-authapi' ); ?>
						</a></p>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
		return ob_get_clean();
	}
}
