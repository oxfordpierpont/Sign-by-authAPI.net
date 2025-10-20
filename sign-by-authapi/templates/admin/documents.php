<?php
/**
 * Documents Management Template
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// $documents variable is passed from the class.
?>

<div class="wrap sign-admin-page">
	<div class="sign-admin-header">
		<h1><?php echo esc_html__( 'Contract Documents', 'sign-by-authapi' ); ?></h1>
		<p><?php echo esc_html__( 'Upload and manage contract templates that will be attached to customer documents.', 'sign-by-authapi' ); ?></p>
	</div>

	<?php settings_errors( 'sign_documents' ); ?>

	<div class="sign-admin-section">
		<h2><?php echo esc_html__( 'Upload New Document', 'sign-by-authapi' ); ?></h2>
		<form method="post" action="" enctype="multipart/form-data">
			<?php wp_nonce_field( 'sign_documents_nonce' ); ?>
			<table class="sign-form-table">
				<tr>
					<th><label for="document_name"><?php echo esc_html__( 'Document Name', 'sign-by-authapi' ); ?></label></th>
					<td>
						<input type="text" id="document_name" name="document_name" class="regular-text" required>
						<p class="description"><?php echo esc_html__( 'e.g., Service Agreement, Terms & Conditions', 'sign-by-authapi' ); ?></p>
					</td>
				</tr>
				<tr>
					<th><label for="document"><?php echo esc_html__( 'PDF File', 'sign-by-authapi' ); ?></label></th>
					<td>
						<input type="file" id="document" name="document" accept=".pdf" required>
					</td>
				</tr>
				<tr>
					<th><label for="sequence"><?php echo esc_html__( 'Sequence', 'sign-by-authapi' ); ?></label></th>
					<td>
						<input type="number" id="sequence" name="sequence" value="0" class="small-text" min="0">
						<p class="description"><?php echo esc_html__( 'Order in which documents are assembled (lower numbers first).', 'sign-by-authapi' ); ?></p>
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" name="upload_document" class="button button-primary" value="<?php echo esc_attr__( 'Upload Document', 'sign-by-authapi' ); ?>">
			</p>
		</form>
	</div>

	<?php if ( ! empty( $documents ) ) : ?>
	<div class="sign-admin-section">
		<h2><?php echo esc_html__( 'Uploaded Documents', 'sign-by-authapi' ); ?></h2>
		<ul class="sign-document-list">
			<?php foreach ( $documents as $doc ) : ?>
			<li class="sign-document-item">
				<div class="sign-document-info">
					<h4><?php echo esc_html( $doc['name'] ); ?></h4>
					<p>
						<strong><?php echo esc_html__( 'File:', 'sign-by-authapi' ); ?></strong>
						<?php echo esc_html( basename( $doc['file_path'] ) ); ?>
						<br>
						<strong><?php echo esc_html__( 'Sequence:', 'sign-by-authapi' ); ?></strong>
						<?php echo esc_html( $doc['sequence'] ); ?>
						<br>
						<strong><?php echo esc_html__( 'Uploaded:', 'sign-by-authapi' ); ?></strong>
						<?php echo esc_html( gmdate( 'F j, Y', strtotime( $doc['created_at'] ) ) ); ?>
					</p>
				</div>
				<div class="sign-document-actions">
					<?php if ( ! empty( $doc['file_url'] ) ) : ?>
						<a href="<?php echo esc_url( $doc['file_url'] ); ?>" class="button" target="_blank">
							<?php echo esc_html__( 'View', 'sign-by-authapi' ); ?>
						</a>
					<?php endif; ?>
					<a href="<?php echo esc_url( admin_url( 'admin.php?page=sign-documents&action=delete&document_id=' . $doc['id'] ) ); ?>"
					   class="button button-secondary sign-delete-action">
						<?php echo esc_html__( 'Delete', 'sign-by-authapi' ); ?>
					</a>
				</div>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php else : ?>
	<div class="sign-admin-section">
		<p><?php echo esc_html__( 'No documents uploaded yet. Upload your first contract template above.', 'sign-by-authapi' ); ?></p>
	</div>
	<?php endif; ?>
</div>
