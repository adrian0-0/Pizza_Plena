<?php
/**
 * Search console options.
 *
 * @package Rank_Math
 */

use RankMath\Analytics\DB;
use MyThemeShop\Helpers\Str;
use RankMath\Google\Authentication;

defined( 'ABSPATH' ) || exit;

// phpcs:disable
$actions = \as_get_scheduled_actions(
	[
		'hook' => 'rank_math/analytics/clear_cache',
		'status' => \ActionScheduler_Store::STATUS_PENDING,
	]
);
$db_info        = DB::info();
$is_queue_empty = empty( $actions );
$disable        = ( ! Authentication::is_authorized() || ! $is_queue_empty ) ? true : false;

if ( ! empty( $db_info ) ) {
	$db_info = [
		/* translators: number of days */
		'<div class="rank-math-console-db-info"><i class="rm-icon rm-icon-calendar"></i> ' . sprintf( esc_html__( 'Storage Days: %s', 'rank-math' ), '<strong>' . $db_info['days'] . '</strong>' ) . '</div>',
		/* translators: number of rows */
		'<div class="rank-math-console-db-info"><i class="rm-icon rm-icon-faq"></i> ' . sprintf( esc_html__( 'Data Rows: %s', 'rank-math' ), '<strong>' . Str::human_number( $db_info['rows'] ) . '</strong>' ) . '</div>',
		/* translators: database size */
		'<div class="rank-math-console-db-info"><i class="rm-icon rm-icon-database"></i> ' . sprintf( esc_html__( 'Size: %s', 'rank-math' ), '<strong>' . size_format( $db_info['size'] ) . '</strong>' ) . '</div>',
	];
}

$actions = as_get_scheduled_actions(
	[
		'order'  => 'DESC',
		'hook'   => 'rank_math/analytics/data_fetch',
		'status' => \ActionScheduler_Store::STATUS_PENDING,
	]
);
if ( Authentication::is_authorized() && ! empty( $actions ) ) {
	$action    = current( $actions );
	$schedule  = $action->get_schedule();
	$next_date = $schedule->get_date();
	if ( $next_date ) {
		$cmb->add_field(
			[
				'id'      => 'console_data_empty',
				'type'    => 'raw',
				/* translators: date */
				'content' => sprintf(
					'<span class="next-fetch">' . __( 'Next data fetch on %s', 'rank-math' ),
					date_i18n( 'd M, Y H:m:i', $next_date->getTimestamp() ) . '</span>'
				),
			]
		);
	}
}
// phpcs:enable

$cmb->add_field(
	[
		'id'   => 'search_console_ui',
		'type' => 'raw',
		'file' => rank_math()->admin_dir() . '/wizard/views/search-console-ui.php',
	]
);

$is_fetching = 'fetching' === get_option( 'rank_math_analytics_first_fetch' );
$buttons     = '<br>' .
	'<button class="button button-small console-cache-delete" data-days="-1">' . esc_html__( 'Delete Data', 'rank-math' ) . '</button>' .
	'&nbsp;&nbsp;<button class="button button-small console-cache-update-manually"' . ( $disable ? ' disabled="disabled"' : '' ) . '>' . ( $is_queue_empty ? esc_html__( 'Update Data manually', 'rank-math' ) : esc_html__( 'Fetching in Progress', 'rank-math' ) ) . '</button>' .
	'&nbsp;&nbsp;<button class="button button-link-delete button-small cancel-fetch"' . disabled( $is_fetching, false, false ) . '>' . esc_html__( 'Cancel Fetching', 'rank-math' ) . '</button>';

$buttons .= '<br>' . join( '', $db_info );

$description = sprintf( __( 'Enter the number of days to keep Analytics data in your database. The maximum allowed days are 90 in the %s. Though, 2x data will be stored in the DB for calculating the difference properly.', 'rank-math' ), '<a href="https://rankmath.com/pricing/?utm_source=Plugin&utm_medium=Analytics%20DB%20Option&utm_campaign=WP" target="_blank" rel="noopener noreferrer">' . __( 'free version', 'rank-math' ) . '</a>' );
$description = apply_filters_deprecated( 'rank_math/analytics/options/cahce_control/description', [ $description ], '1.0.61.1', 'rank_math/analytics/options/cache_control/description' );
$description = apply_filters( 'rank_math/analytics/options/cache_control/description', $description );

$cmb->add_field(
	[
		'id'              => 'console_caching_control',
		'type'            => 'text',
		'name'            => __( 'Analytics Database', 'rank-math' ),
		// translators: Anchor text 'free version', linking to pricing page.
		'description'     => $description,
		'default'         => 90,
		'sanitization_cb' => function( $value ) {
			$max   = apply_filters( 'rank_math/analytics/max_days_allowed', 90 );
			$value = absint( $value );
			if ( $value > $max ) {
				$value = $max;
			}

			return $value;
		},
		'after_field'     => $buttons,
	]
);