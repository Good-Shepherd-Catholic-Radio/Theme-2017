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

$radio_shows = new WP_Query( array(
	'post_type' => 'radio-show',
	'posts_per_page' => -1,
	'post_status' => 'radioshow-occurrence',
	'orderby' => array(
		'rbm_cpts_day_of_the_week' => 'ASC',
		'rbm_cpts_start_time' => 'ASC',
	),
	'meta_query' => array(
		'relation' => 'AND',
		array(
			'key' => 'rbm_cpts_day_of_the_week',
			'type' => 'NUMERIC',
		),
		array(
			'key' => 'rbm_cpts_start_time',
			'type' => 'TIME',
		),
	),
) );

$weekdays = gscr_get_weekdays();
$current_day_index = current_time( 'w' );

?>

<div class="row">
	
	<div class="small-12 columns">
		<?php the_content(); ?>
	</div>
	
</div>

<div class="row">
	
	<div class="small-12 columns radio-show-week-schedule">

		<ul class="tabs hide-for-print" data-deep-link="true" data-update-history="true" data-deep-link-smudge="true" data-deep-link-smudge="500" data-tabs id="radio-show-schedule-tabs">

			<?php foreach ( $weekdays as $index => $weekday ) : ?>
				<li class="tabs-title<?php echo ( $index == $current_day_index ) ? ' is-active' : ''; ?>">
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

					<?php $parent_id = wp_get_post_parent_id( get_the_ID() ); ?>
					<?php $start_time = rbm_cpts_get_field( 'start_time' ); ?>
					<?php $start_index = rbm_cpts_get_field( 'day_of_the_week' ); ?>
					<?php $end_time = rbm_cpts_get_field( 'end_time' ); ?>

					<?php if ( $day_index == $start_index &&
							 $first ) : ?>

						<div id="<?php echo strtolower( $weekdays[ $day_index ] ); ?>" class="<?php echo implode( ' ', $tab_classes ); ?>">
							
							<article class="small-12 columns tribe_events show-for-print-only">
								
								<div class="row expanded">

									<div class="small-12 medium-3 columns">

										<h3>
											<?php _e( $weekdays[ $day_index ] ); ?>
										</h3>

									</div>

								</div>

							</article>

					<?php 
							
							include locate_template( '/partials/loop/loop-radio_shows_week.php' );

							$first = false;

					elseif ( (int) $start_index == ( $day_index + 1 ) ) : // If it is the end of a day, close out the Day and then set the Pointer for our WP_Query one Post back so that we can re-do it as "First". This is a little dirty, but it should hopefully not break ?>
							
						</div>

					<?php 
			
						$first = true;
						$day_index++;
			
						$radio_shows->current_post--;
			
					elseif ( (int) $start_index == $day_index ) : // If we're still in the same day, just include the Show
			
						include locate_template( '/partials/loop/loop-radio_shows_week.php' );
			
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