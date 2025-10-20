<?php
/**
 * Branding Configuration Template
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// $branding variable is passed from the class.
?>

<div class="wrap sign-admin-page">
	<div class="sign-admin-header">
		<h1><?php echo esc_html__( 'Branding Configuration', 'sign-by-authapi' ); ?></h1>
		<p><?php echo esc_html__( 'Customize your company branding for contracts and emails.', 'sign-by-authapi' ); ?></p>
	</div>

	<?php settings_errors( 'sign_branding' ); ?>

	<form method="post" action="" enctype="multipart/form-data">
		<?php wp_nonce_field( 'sign_branding_nonce' ); ?>
		<input type="hidden" name="business_id" value="<?php echo esc_attr( $branding['id'] ); ?>">

		<div class="sign-admin-section">
			<h2><?php echo esc_html__( 'Company Information', 'sign-by-authapi' ); ?></h2>
			<table class="sign-form-table">
				<tr>
					<th><label for="business_name"><?php echo esc_html__( 'Business Name', 'sign-by-authapi' ); ?></label></th>
					<td>
						<input type="text" id="business_name" name="business_name" value="<?php echo esc_attr( $branding['name'] ?? '' ); ?>" class="regular-text" required>
						<p class="description"><?php echo esc_html__( 'Internal name for this business configuration.', 'sign-by-authapi' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="company_name"><?php echo esc_html__( 'Company Name', 'sign-by-authapi' ); ?></label></th>
					<td>
						<input type="text" id="company_name" name="company_name" value="<?php echo esc_attr( $branding['company_name'] ?? '' ); ?>" class="regular-text">
						<p class="description"><?php echo esc_html__( 'Name displayed on contracts and emails.', 'sign-by-authapi' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="company_email"><?php echo esc_html__( 'Company Email', 'sign-by-authapi' ); ?></label></th>
					<td>
						<input type="email" id="company_email" name="company_email" value="<?php echo esc_attr( $branding['company_email'] ?? '' ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="company_phone"><?php echo esc_html__( 'Company Phone', 'sign-by-authapi' ); ?></label></th>
					<td>
						<input type="text" id="company_phone" name="company_phone" value="<?php echo esc_attr( $branding['company_phone'] ?? '' ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="company_address"><?php echo esc_html__( 'Company Address', 'sign-by-authapi' ); ?></label></th>
					<td>
						<textarea id="company_address" name="company_address" rows="4" class="large-text"><?php echo esc_textarea( $branding['company_address'] ?? '' ); ?></textarea>
					</td>
				</tr>
			</table>
		</div>

		<div class="sign-admin-section">
			<h2><?php echo esc_html__( 'Authorized Representative', 'sign-by-authapi' ); ?></h2>
			<table class="sign-form-table">
				<tr>
					<th><label for="authorized_rep"><?php echo esc_html__( 'Representative Name', 'sign-by-authapi' ); ?></label></th>
					<td>
						<input type="text" id="authorized_rep" name="authorized_rep" value="<?php echo esc_attr( $branding['authorized_rep'] ?? '' ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th><label for="rep_title"><?php echo esc_html__( 'Title', 'sign-by-authapi' ); ?></label></th>
					<td>
						<input type="text" id="rep_title" name="rep_title" value="<?php echo esc_attr( $branding['rep_title'] ?? '' ); ?>" class="regular-text">
						<p class="description"><?php echo esc_html__( 'e.g., CEO, President, Managing Director', 'sign-by-authapi' ); ?></p>
					</td>
				</tr>
			</table>
		</div>

		<div class="sign-admin-section">
			<h2><?php echo esc_html__( 'Visual Branding', 'sign-by-authapi' ); ?></h2>
			<table class="sign-form-table">
				<tr>
					<th><label for="logo"><?php echo esc_html__( 'Company Logo', 'sign-by-authapi' ); ?></label></th>
					<td>
						<?php if ( ! empty( $branding['logo_url'] ) ) : ?>
							<img src="<?php echo esc_url( $branding['logo_url'] ); ?>" style="max-width: 200px; margin-bottom: 10px; display: block;">
						<?php endif; ?>
						<input type="file" id="logo" name="logo" accept="image/*">
						<p class="description"><?php echo esc_html__( 'Upload your company logo (recommended: PNG, 200x200px).', 'sign-by-authapi' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="letterhead"><?php echo esc_html__( 'Custom Letterhead PDF', 'sign-by-authapi' ); ?></label></th>
					<td>
						<?php if ( ! empty( $branding['letterhead_path'] ) ) : ?>
							<p><strong><?php echo esc_html__( 'Current:', 'sign-by-authapi' ); ?></strong> <?php echo esc_html( basename( $branding['letterhead_path'] ) ); ?></p>
						<?php endif; ?>
						<input type="file" id="letterhead" name="letterhead" accept=".pdf">
						<p class="description"><?php echo esc_html__( 'Optional: Upload custom PDF letterhead. If provided, customer data will be overlaid on this template.', 'sign-by-authapi' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="primary_color"><?php echo esc_html__( 'Primary Color', 'sign-by-authapi' ); ?></label></th>
					<td>
						<input type="text" id="primary_color" name="primary_color" value="<?php echo esc_attr( $branding['primary_color'] ?? '#007bff' ); ?>" class="sign-color-picker">
					</td>
				</tr>
				<tr>
					<th><label for="secondary_color"><?php echo esc_html__( 'Secondary Color', 'sign-by-authapi' ); ?></label></th>
					<td>
						<input type="text" id="secondary_color" name="secondary_color" value="<?php echo esc_attr( $branding['secondary_color'] ?? '#6c757d' ); ?>" class="sign-color-picker">
					</td>
				</tr>
				<tr>
					<th><label for="accent_color"><?php echo esc_html__( 'Accent Color', 'sign-by-authapi' ); ?></label></th>
					<td>
						<input type="text" id="accent_color" name="accent_color" value="<?php echo esc_attr( $branding['accent_color'] ?? '#28a745' ); ?>" class="sign-color-picker">
					</td>
				</tr>
			</table>
		</div>

		<p class="submit">
			<input type="submit" name="save_branding" class="button button-primary" value="<?php echo esc_attr__( 'Save Branding Settings', 'sign-by-authapi' ); ?>">
		</p>
	</form>
</div>
