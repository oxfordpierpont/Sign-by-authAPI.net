<?php
/**
 * Admin Dashboard Template
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get statistics.
global $wpdb;
$table = $wpdb->prefix . 'posts';

$total_requests = $wpdb->get_var(
	"SELECT COUNT(*) FROM {$table} WHERE post_type = 'sign_request'"
);

$incomplete_requests = $wpdb->get_var(
	$wpdb->prepare(
		"SELECT COUNT(*) FROM {$table} p
		INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
		WHERE p.post_type = 'sign_request'
		AND pm.meta_key = 'esign_signing_status'
		AND pm.meta_value = %s",
		'incomplete'
	)
);

$completed_requests = $wpdb->get_var(
	$wpdb->prepare(
		"SELECT COUNT(*) FROM {$table} p
		INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
		WHERE p.post_type = 'sign_request'
		AND pm.meta_key = 'esign_signing_status'
		AND pm.meta_value = %s",
		'complete'
	)
);

// Get recent activity.
$activity_table = $wpdb->prefix . 'sign_activity_log';
$recent_activity = $wpdb->get_results(
	"SELECT * FROM {$activity_table} ORDER BY created_at DESC LIMIT 10",
	ARRAY_A
);
?>

<div class="wrap sign-admin-page">
	<div class="sign-admin-header">
		<h1><?php echo esc_html__( 'Sign by authAPI.net Dashboard', 'sign-by-authapi' ); ?></h1>
		<p><?php echo esc_html__( 'Welcome to your contract signing management dashboard.', 'sign-by-authapi' ); ?></p>
	</div>

	<div class="sign-stats">
		<div class="sign-stat-box">
			<span class="stat-number"><?php echo esc_html( $total_requests ); ?></span>
			<span class="stat-label"><?php echo esc_html__( 'Total Requests', 'sign-by-authapi' ); ?></span>
		</div>
		<div class="sign-stat-box">
			<span class="stat-number"><?php echo esc_html( $incomplete_requests ); ?></span>
			<span class="stat-label"><?php echo esc_html__( 'Pending Signatures', 'sign-by-authapi' ); ?></span>
		</div>
		<div class="sign-stat-box">
			<span class="stat-number"><?php echo esc_html( $completed_requests ); ?></span>
			<span class="stat-label"><?php echo esc_html__( 'Completed', 'sign-by-authapi' ); ?></span>
		</div>
	</div>

	<div class="sign-admin-section">
		<h2><?php echo esc_html__( 'Quick Actions', 'sign-by-authapi' ); ?></h2>
		<p>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=sign-branding' ) ); ?>" class="sign-button">
				<?php echo esc_html__( 'Configure Branding', 'sign-by-authapi' ); ?>
			</a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=sign-documents' ) ); ?>" class="sign-button">
				<?php echo esc_html__( 'Manage Documents', 'sign-by-authapi' ); ?>
			</a>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=sign-settings' ) ); ?>" class="sign-button sign-button-secondary">
				<?php echo esc_html__( 'Settings', 'sign-by-authapi' ); ?>
			</a>
		</p>
	</div>

	<?php if ( ! empty( $recent_activity ) ) : ?>
	<div class="sign-admin-section">
		<h2><?php echo esc_html__( 'Recent Activity', 'sign-by-authapi' ); ?></h2>
		<div class="sign-activity-log">
			<?php foreach ( $recent_activity as $activity ) : ?>
			<div class="sign-activity-item">
				<strong><?php echo esc_html( $activity['action'] ); ?></strong>
				<?php if ( ! empty( $activity['details'] ) ) : ?>
					<br><small><?php echo esc_html( $activity['details'] ); ?></small>
				<?php endif; ?>
				<div class="sign-activity-time">
					<?php echo esc_html( gmdate( 'F j, Y g:i A', strtotime( $activity['created_at'] ) ) ); ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<p>
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=sign-activity-log' ) ); ?>">
				<?php echo esc_html__( 'View Full Activity Log', 'sign-by-authapi' ); ?> →
			</a>
		</p>
	</div>
	<?php endif; ?>

	<div class="sign-admin-section">
		<h2><?php echo esc_html__( 'System Status', 'sign-by-authapi' ); ?></h2>
		<table class="sign-form-table">
			<tr>
				<th><?php echo esc_html__( 'Plugin Status', 'sign-by-authapi' ); ?></th>
				<td>
					<?php if ( get_option( 'sign_active' ) ) : ?>
						<span style="color: green;">●</span> <?php echo esc_html__( 'Active', 'sign-by-authapi' ); ?>
					<?php else : ?>
						<span style="color: orange;">●</span> <?php echo esc_html__( 'Inactive', 'sign-by-authapi' ); ?>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<th><?php echo esc_html__( 'LibreSign Connection', 'sign-by-authapi' ); ?></th>
				<td>
					<?php
					$libresign_url = get_option( 'sign_libresign_url' );
					$libresign_key = get_option( 'sign_libresign_api_key' );
					?>
					<?php if ( ! empty( $libresign_url ) && ! empty( $libresign_key ) ) : ?>
						<span style="color: green;">●</span> <?php echo esc_html__( 'Configured', 'sign-by-authapi' ); ?>
					<?php else : ?>
						<span style="color: red;">●</span> <?php echo esc_html__( 'Not Configured', 'sign-by-authapi' ); ?>
						<br><small><a href="<?php echo esc_url( admin_url( 'admin.php?page=sign-settings' ) ); ?>"><?php echo esc_html__( 'Configure Now', 'sign-by-authapi' ); ?></a></small>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<th><?php echo esc_html__( 'PHP Version', 'sign-by-authapi' ); ?></th>
				<td><?php echo esc_html( PHP_VERSION ); ?></td>
			</tr>
			<tr>
				<th><?php echo esc_html__( 'WordPress Version', 'sign-by-authapi' ); ?></th>
				<td><?php echo esc_html( get_bloginfo( 'version' ) ); ?></td>
			</tr>
		</table>
	</div>
</div>
