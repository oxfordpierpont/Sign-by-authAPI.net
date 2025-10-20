<?php
/**
 * Settings Page Template
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wrap sign-admin-page">
	<div class="sign-admin-header">
		<h1><?php echo esc_html__( 'Sign Settings', 'sign-by-authapi' ); ?></h1>
		<p><?php echo esc_html__( 'Configure your signing workflow settings.', 'sign-by-authapi' ); ?></p>
	</div>

	<form method="post" action="options.php">
		<?php
		settings_fields( 'sign_settings_group' );
		do_settings_sections( 'sign-settings' );
		submit_button();
		?>
	</form>
</div>
