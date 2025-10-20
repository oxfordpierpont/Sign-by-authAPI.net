<?php
/**
 * Activity Log Template
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get activity log entries.
global $wpdb;
$table = $wpdb->prefix . 'sign_activity_log';

$per_page = 50;
$page     = isset( $_GET['paged'] ) ? max( 1, (int) $_GET['paged'] ) : 1;
$offset   = ( $page - 1 ) * $per_page;

$total_items = $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );
$activities  = $wpdb->get_results(
	$wpdb->prepare(
		"SELECT * FROM {$table} ORDER BY created_at DESC LIMIT %d OFFSET %d",
		$per_page,
		$offset
	),
	ARRAY_A
);

$total_pages = ceil( $total_items / $per_page );
?>

<div class="wrap sign-admin-page">
	<div class="sign-admin-header">
		<h1><?php echo esc_html__( 'Activity Log', 'sign-by-authapi' ); ?></h1>
		<p><?php echo esc_html__( 'Complete audit trail of all signing activities.', 'sign-by-authapi' ); ?></p>
	</div>

	<?php if ( ! empty( $activities ) ) : ?>
	<div class="sign-admin-section">
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th><?php echo esc_html__( 'Date/Time', 'sign-by-authapi' ); ?></th>
					<th><?php echo esc_html__( 'Request ID', 'sign-by-authapi' ); ?></th>
					<th><?php echo esc_html__( 'Action', 'sign-by-authapi' ); ?></th>
					<th><?php echo esc_html__( 'Details', 'sign-by-authapi' ); ?></th>
					<th><?php echo esc_html__( 'IP Address', 'sign-by-authapi' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $activities as $activity ) : ?>
				<tr>
					<td><?php echo esc_html( gmdate( 'Y-m-d H:i:s', strtotime( $activity['created_at'] ) ) ); ?></td>
					<td>
						<?php if ( $activity['cpt_id'] > 0 ) : ?>
							<a href="<?php echo esc_url( get_edit_post_link( $activity['cpt_id'] ) ); ?>">
								#<?php echo esc_html( $activity['cpt_id'] ); ?>
							</a>
						<?php else : ?>
							<?php echo esc_html__( 'N/A', 'sign-by-authapi' ); ?>
						<?php endif; ?>
					</td>
					<td><strong><?php echo esc_html( $activity['action'] ); ?></strong></td>
					<td><?php echo esc_html( $activity['details'] ); ?></td>
					<td><?php echo esc_html( $activity['ip_address'] ); ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<?php if ( $total_pages > 1 ) : ?>
		<div class="tablenav">
			<div class="tablenav-pages">
				<?php
				echo wp_kses_post(
					paginate_links(
						array(
							'base'    => add_query_arg( 'paged', '%#%' ),
							'format'  => '',
							'current' => $page,
							'total'   => $total_pages,
						)
					)
				);
				?>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<?php else : ?>
	<div class="sign-admin-section">
		<p><?php echo esc_html__( 'No activity logged yet.', 'sign-by-authapi' ); ?></p>
	</div>
	<?php endif; ?>
</div>
