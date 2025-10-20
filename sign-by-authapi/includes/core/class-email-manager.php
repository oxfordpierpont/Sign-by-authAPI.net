<?php
/**
 * Email Manager
 *
 * Handles all email notifications for the signing workflow.
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sign_Email_Manager class
 *
 * @since 1.0.0
 */
class Sign_Email_Manager {

	/**
	 * Send initial email to customer.
	 *
	 * @since 1.0.0
	 *
	 * @param int $cpt_id Post ID.
	 * @return bool True on success, false on failure.
	 */
	public function send_initial_email( $cpt_id ) {
		$data = $this->get_email_data( $cpt_id );

		if ( empty( $data['email'] ) ) {
			return false;
		}

		$subject = 'Please complete your contract signing';
		$message = $this->get_initial_email_template( $data );

		return $this->send_email( $data['email'], $subject, $message );
	}

	/**
	 * Send reminder email to customer.
	 *
	 * @since 1.0.0
	 *
	 * @param int $cpt_id Post ID.
	 * @return bool True on success, false on failure.
	 */
	public function send_reminder_email( $cpt_id ) {
		$data = $this->get_email_data( $cpt_id );

		if ( empty( $data['email'] ) ) {
			return false;
		}

		$subject = 'Reminder: Please complete your contract signing';
		$message = $this->get_reminder_email_template( $data );

		// Increment reminder count.
		$reminder_count = get_post_meta( $cpt_id, 'esign_reminder_count', true );
		$reminder_count = $reminder_count ? (int) $reminder_count : 0;
		update_post_meta( $cpt_id, 'esign_reminder_count', $reminder_count + 1 );
		update_post_meta( $cpt_id, 'esign_last_reminder_at', current_time( 'mysql' ) );

		return $this->send_email( $data['email'], $subject, $message );
	}

	/**
	 * Send completion email to customer.
	 *
	 * @since 1.0.0
	 *
	 * @param int $cpt_id Post ID.
	 * @return bool True on success, false on failure.
	 */
	public function send_completion_email( $cpt_id ) {
		$data = $this->get_email_data( $cpt_id );

		if ( empty( $data['email'] ) ) {
			return false;
		}

		$subject = 'Your contract has been signed successfully';
		$message = $this->get_completion_email_template( $data );

		// Attach signed PDF and certificate.
		$attachments = array();
		$signed_pdf = get_post_meta( $cpt_id, 'esign_signed_pdf_url', true );
		$certificate = get_post_meta( $cpt_id, 'esign_certificate_url', true );

		if ( $signed_pdf && file_exists( $signed_pdf ) ) {
			$attachments[] = $signed_pdf;
		}
		if ( $certificate && file_exists( $certificate ) ) {
			$attachments[] = $certificate;
		}

		return $this->send_email( $data['email'], $subject, $message, $attachments );
	}

	/**
	 * Send admin notification.
	 *
	 * @since 1.0.0
	 *
	 * @param int $cpt_id Post ID.
	 * @return bool True on success, false on failure.
	 */
	public function send_admin_notification( $cpt_id ) {
		$data = $this->get_email_data( $cpt_id );
		$admin_email = get_option( 'admin_email' );

		if ( empty( $admin_email ) ) {
			return false;
		}

		$subject = 'New signed contract from ' . $data['name'];
		$message = $this->get_admin_notification_template( $data );

		// Attach signed PDF and certificate.
		$attachments = array();
		$signed_pdf = get_post_meta( $cpt_id, 'esign_signed_pdf_url', true );
		$certificate = get_post_meta( $cpt_id, 'esign_certificate_url', true );

		if ( $signed_pdf && file_exists( $signed_pdf ) ) {
			$attachments[] = $signed_pdf;
		}
		if ( $certificate && file_exists( $certificate ) ) {
			$attachments[] = $certificate;
		}

		return $this->send_email( $admin_email, $subject, $message, $attachments );
	}

	/**
	 * Get email data for templates.
	 *
	 * @since 1.0.0
	 *
	 * @param int $cpt_id Post ID.
	 * @return array Email data.
	 */
	private function get_email_data( $cpt_id ) {
		$first_name = get_post_meta( $cpt_id, 'esign_first_name', true );
		$last_name = get_post_meta( $cpt_id, 'esign_last_name', true );
		$email = get_post_meta( $cpt_id, 'esign_email', true );
		$token = get_post_meta( $cpt_id, 'esign_token', true );

		// Generate dashboard URL.
		$dashboard_url = home_url( '/signing-dashboard/' ) . '?token=' . $token;

		return array(
			'name'          => trim( $first_name . ' ' . $last_name ),
			'first_name'    => $first_name,
			'last_name'     => $last_name,
			'email'         => $email,
			'dashboard_url' => $dashboard_url,
			'site_name'     => get_bloginfo( 'name' ),
			'site_url'      => home_url(),
		);
	}

	/**
	 * Get initial email template.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Email data.
	 * @return string Email HTML.
	 */
	private function get_initial_email_template( $data ) {
		ob_start();
		?>
		<html>
		<head>
			<style>
				body { font-family: Arial, sans-serif; color: #333; }
				.container { max-width: 600px; margin: 0 auto; padding: 20px; }
				.button { display: inline-block; padding: 12px 24px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 4px; }
			</style>
		</head>
		<body>
			<div class="container">
				<h2>Hello <?php echo esc_html( $data['first_name'] ); ?>,</h2>
				<p>Thank you for submitting your information. We need you to review and sign your contract to complete the process.</p>
				<p>Please click the button below to access your signing dashboard:</p>
				<p><a href="<?php echo esc_url( $data['dashboard_url'] ); ?>" class="button">Review & Sign Contract</a></p>
				<p>If the button doesn't work, copy and paste this link into your browser:</p>
				<p><?php echo esc_url( $data['dashboard_url'] ); ?></p>
				<p>Thank you,<br><?php echo esc_html( $data['site_name'] ); ?></p>
			</div>
		</body>
		</html>
		<?php
		return ob_get_clean();
	}

	/**
	 * Get reminder email template.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Email data.
	 * @return string Email HTML.
	 */
	private function get_reminder_email_template( $data ) {
		ob_start();
		?>
		<html>
		<head>
			<style>
				body { font-family: Arial, sans-serif; color: #333; }
				.container { max-width: 600px; margin: 0 auto; padding: 20px; }
				.button { display: inline-block; padding: 12px 24px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 4px; }
			</style>
		</head>
		<body>
			<div class="container">
				<h2>Hello <?php echo esc_html( $data['first_name'] ); ?>,</h2>
				<p>This is a friendly reminder that you have a contract pending signature.</p>
				<p>Please click the button below to access your signing dashboard:</p>
				<p><a href="<?php echo esc_url( $data['dashboard_url'] ); ?>" class="button">Review & Sign Contract</a></p>
				<p>If the button doesn't work, copy and paste this link into your browser:</p>
				<p><?php echo esc_url( $data['dashboard_url'] ); ?></p>
				<p>Thank you,<br><?php echo esc_html( $data['site_name'] ); ?></p>
			</div>
		</body>
		</html>
		<?php
		return ob_get_clean();
	}

	/**
	 * Get completion email template.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Email data.
	 * @return string Email HTML.
	 */
	private function get_completion_email_template( $data ) {
		ob_start();
		?>
		<html>
		<head>
			<style>
				body { font-family: Arial, sans-serif; color: #333; }
				.container { max-width: 600px; margin: 0 auto; padding: 20px; }
			</style>
		</head>
		<body>
			<div class="container">
				<h2>Hello <?php echo esc_html( $data['first_name'] ); ?>,</h2>
				<p>Your contract has been signed successfully!</p>
				<p>Attached to this email you will find:</p>
				<ul>
					<li>Your signed contract</li>
					<li>Verification certificate</li>
				</ul>
				<p>Please keep these documents for your records.</p>
				<p>If you have any questions, please don't hesitate to contact us.</p>
				<p>Thank you,<br><?php echo esc_html( $data['site_name'] ); ?></p>
			</div>
		</body>
		</html>
		<?php
		return ob_get_clean();
	}

	/**
	 * Get admin notification template.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Email data.
	 * @return string Email HTML.
	 */
	private function get_admin_notification_template( $data ) {
		ob_start();
		?>
		<html>
		<head>
			<style>
				body { font-family: Arial, sans-serif; color: #333; }
				.container { max-width: 600px; margin: 0 auto; padding: 20px; }
			</style>
		</head>
		<body>
			<div class="container">
				<h2>New Signed Contract</h2>
				<p>A contract has been signed by <?php echo esc_html( $data['name'] ); ?>.</p>
				<p><strong>Customer Details:</strong></p>
				<ul>
					<li>Name: <?php echo esc_html( $data['name'] ); ?></li>
					<li>Email: <?php echo esc_html( $data['email'] ); ?></li>
				</ul>
				<p>The signed contract and verification certificate are attached to this email.</p>
			</div>
		</body>
		</html>
		<?php
		return ob_get_clean();
	}

	/**
	 * Send email.
	 *
	 * @since 1.0.0
	 *
	 * @param string $to          Recipient email.
	 * @param string $subject     Email subject.
	 * @param string $message     Email message.
	 * @param array  $attachments File attachments.
	 * @return bool True on success, false on failure.
	 */
	private function send_email( $to, $subject, $message, $attachments = array() ) {
		$from_name = get_option( 'sign_email_from_name', get_bloginfo( 'name' ) );
		$from_email = get_option( 'sign_email_from_address', get_option( 'admin_email' ) );

		$headers = array(
			'Content-Type: text/html; charset=UTF-8',
			'From: ' . $from_name . ' <' . $from_email . '>',
		);

		return wp_mail( $to, $subject, $message, $headers, $attachments );
	}
}
