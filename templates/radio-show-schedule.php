<?php
/**
 * Template Name: Radio Show Schedule
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/loop
 */

defined( 'ABSPATH' ) || die();

get_header();

// Just in case there are any Hooks for Events
locate_template( '/includes/hooks/tribe_events-hooks.php', true, true );

global $post;

$current_time = current_time( 'Y-m-d' );

// If today is a Sunday, use today. Else get the last Sunday
$sunday = '';
if ( (string) date( 'w', strtotime( $current_time ) ) == '0' ) {
	$sunday = $current_time; 
}
else {
	$sunday = date( 'Y-m-d', strtotime( 'last Sunday', strtotime( $current_time ) ) );
}

// If today is a Saturday, use today. Else get the next Saturday
$saturday = '';
if ( (string) date( 'w', strtotime( $current_time ) ) == '6' ) {
	$saturday = $current_time; 
}
else {
	$saturday = date( 'Y-m-d', strtotime( 'next Saturday', strtotime( $current_time ) ) );
}

$radio_shows = new WP_Query( array(
	'post_type' => 'tribe_events',
	'posts_per_page' => -1,
	'eventDisplay' => 'custom',
	'start_date' => $sunday . ' 00:00',
	'order' => 'ASC',
	'tax_query' => array(
		'relationship' => 'AND',
		array(
			'taxonomy' => 'tribe_events_cat',
			'field' => 'slug',
			'terms' => array( 'radio-show' ),
			'operator' => 'IN'
		),
	),
	'meta_query' => array(
		'relation' => 'AND',
		array(
			'key' => '_EventStartDate',
			'value' => $sunday . ' 00:00',
			'type' => 'DATETIME',
			'compare' => '>=',
		),
		array(
			'key' => '_EventStartDate',
			'value' => $saturday . ' 23:59',
			'type' => 'DATETIME',
			'compare' => '<=',
		),
		array(
			'key' => '_EventHideFromUpcoming',
			'compare' => 'NOT EXISTS',
		),
	),
) );

the_content();

$weekdays = gscr_get_weekdays(); ?>

<div class="row">
	
	<div class="small-12 columns">

		<ul class="tabs" data-deep-link="true" data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge="500" data-tabs id="radio-show-schedule-tabs">

			<?php foreach ( $weekdays as $index => $weekday ) : ?>
				<li class="tabs-title<?php echo ( $index == 0 ) ? ' is-active' : ''; ?>">
					<a href="#<?php echo strtolower( $weekday ); ?>"<?php echo ( $index == 0 ) ? ' aria-selected="true"' : ''; ?>>
						<?php echo $weekday; ?>
					</a>
				</li>
			<?php endforeach; ?>

		</ul>

		<div class="tabs-content" data-tabs-content="radio-show-schedule-tabs">

			<?php

			$tab_classes = array(
				'tabs-panel',
				'row',
				'expanded',
			);

			$first = true;
			$day_index = 0;
			if ( $radio_shows->have_posts() ) : 

				while ( $radio_shows->have_posts() ) : $radio_shows->the_post(); ?>

					<?php $start_datetime = get_post_meta( get_the_ID(), '_EventStartDate', true ); ?>
					<?php $end_datetime = get_post_meta( get_the_ID(), '_EventEndDate', true ); ?>
					<?php $start_index = date( 'w', strtotime( $start_datetime ) ); ?>
					<?php $end_index = date( 'w', strtotime( $end_datetime ) ); ?>

					<?php if ( $day_index == $start_index &&
							 $first ) : ?>

						<div id="<?php echo strtolower( $weekdays[ $day_index ] ); ?>" class="<?php echo implode( ' ', $tab_classes ); ?>">

					<?php 

							$first = false;

					endif; ?>

					<?php include locate_template( '/partials/loop/loop-radio_shows_week.php' ); ?>

					<?php if ( $start_index !== $end_index ) : ?>

						</div>

					<?php 

						$first = true;
						$day_index++;

					endif; ?>

				<?php endwhile; ?>

				</div>

				<?php // Close out final <div> from the Loop

				wp_reset_postdata();

			endif;

			?>

		</div>

	</div>
	
</div>

<?php

get_footer();