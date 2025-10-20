<?php
/**
 * Field Editor Template
 *
 * Visual editor for placing signature fields on PDFs.
 * This is a placeholder for Phase 7 implementation.
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
		<h1><?php echo esc_html__( 'Visual Field Editor', 'sign-by-authapi' ); ?></h1>
		<p><?php echo esc_html__( 'Place signature fields on your contract documents.', 'sign-by-authapi' ); ?></p>
	</div>

	<div class="sign-admin-section">
		<h2><?php echo esc_html__( 'Coming Soon', 'sign-by-authapi' ); ?></h2>
		<p><?php echo esc_html__( 'The visual field editor is currently under development. This feature will allow you to:', 'sign-by-authapi' ); ?></p>
		<ul>
			<li><?php echo esc_html__( 'View your contract PDFs in the browser', 'sign-by-authapi' ); ?></li>
			<li><?php echo esc_html__( 'Drag and drop signature fields onto specific pages', 'sign-by-authapi' ); ?></li>
			<li><?php echo esc_html__( 'Add signature, initial, date, and text fields', 'sign-by-authapi' ); ?></li>
			<li><?php echo esc_html__( 'Configure field properties (required, size, position)', 'sign-by-authapi' ); ?></li>
			<li><?php echo esc_html__( 'Save field coordinates for use in signing workflow', 'sign-by-authapi' ); ?></li>
		</ul>
		<p><strong><?php echo esc_html__( 'Planned for Phase 7', 'sign-by-authapi' ); ?></strong></p>
		<p><?php echo esc_html__( 'For now, signature fields can be manually configured in the database or via custom code.', 'sign-by-authapi' ); ?></p>
	</div>

	<div class="sign-admin-section">
		<h2><?php echo esc_html__( 'Technical Implementation', 'sign-by-authapi' ); ?></h2>
		<p><?php echo esc_html__( 'This feature will use:', 'sign-by-authapi' ); ?></p>
		<ul>
			<li><strong>PDF.js</strong> - For rendering PDFs in the browser</li>
			<li><strong>Fabric.js</strong> - For drag-drop field placement and manipulation</li>
			<li><strong>REST API</strong> - For saving field coordinates</li>
		</ul>
	</div>
</div>
