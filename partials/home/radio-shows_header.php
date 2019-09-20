<?php
/**
 * Radio Shows on the Home Page
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/home
 */

defined( 'ABSPATH' ) || die();

global $post;

$current_day_index = current_time( 'w' );

$radio_shows = new WP_Query( array(
	'post_type' => 'radio-show',
	'posts_per_page' => 3,
	'post_status' => 'radioshow-occurrence',
	'orderby' => array(
		'rbm_cpts_start_time' => 'ASC',
	),
	'meta_query' => array(
		'relation' => 'AND',
		'rbm_cpts_start_time' => array(
			'key' => 'rbm_cpts_start_time',
			'type' => 'TIME',
		),
		'rbm_cpts_day_of_the_week' => array(
			'key' => 'rbm_cpts_day_of_the_week',
			'type' => 'NUMERIC',
			'value' => $current_day_index,
		),
		'rbm_cpts_end_time' => array(
			'key' => 'rbm_cpts_end_time',
			'type' => 'TIME',
			'compare' => '>',
			'value' => current_time( 'H:i' ), // Show only results with an End Time after our current Time
		),
	),
) );

// If there were not enough results in the current day (We're nearing the end of the day), start pulling results for the next day
if ( $radio_shows->post_count < 3 ) {
	
	$more = new WP_Query( array(
		'post_type' => 'radio-show',
		'post_status' => 'publish',
		'post_status' => 'radioshow-occurrence',
		'posts_per_page' => 3 - $radio_shows->post_count,
		'orderby' => array(
			'rbm_cpts_day_of_the_week' => 'ASC',
			'rbm_cpts_start_time' => 'ASC',
		),
		'meta_query' => array(
			'relation' => 'AND',
			'rbm_cpts_day_of_the_week' => array(
				'key' => 'rbm_cpts_day_of_the_week',
				'type' => 'NUMERIC',
				'value' => ( $current_day_index == 6 ) ? 0 : $current_day_index, // Use Sunday if it is Saturday
				'compare' => ( $current_day_index == 6 ) ? '>=' : '>', // If Saturday, show results Sunday or later. Otherwise just later than current day
			),
			'rbm_cpts_start_time' => array(
				'key' => 'rbm_cpts_start_time',
				'type' => 'TIME',
			),
			// We are not checking for a specific Time since we just want to show whateven is earliest in this case. It should always be Midnight unless there is a gap in the schedule
		),
	) );
	
	$radio_shows->post_count = $radio_shows->post_count + $more->post_count;
	
	$radio_shows->posts = array_merge( $radio_shows->posts, $more->posts );
	
	$radio_shows->posts = array_values( $radio_shows->posts );
	
}

$index = 0; 
$max_per_row = 0;

?>

<div class="radio-shows-header row expanded small-collapse">

	<?php if ( $radio_shows->have_posts() ) : $radio_shows->the_post(); // Forcefully start loop to have our side-section ?>
	
		<div class="small-12 medium-6 columns radio-shows-left">
			
			<div class="row expanded">
			
				<?php 
				
				$first = true;
				
				// Included outside so that we have the one large cell to the left
				include locate_template( 'partials/loop/loop-radio-shows_header.php', false, false );
				
				$first = false; ?>
				
			</div>
			
			<div class="header-overlay">
					
				<div class="row">
					<div class="small-12 columns">

						<h2>
							<?php _e( 'Now Playing', 'good-shepherd-catholic-radio' ); ?>
						</h2>

					</div>
				</div>

			</div>
			
		</div>
	
		<div class="small-12 medium-6 columns radio-shows-right">

			<?php while ( $radio_shows->have_posts() ) : $radio_shows->the_post(); ?>
			
				<?php if ( $index == 0 ) : ?>
			
					<div class="row expanded">
						
				<?php endif;

						include locate_template( 'partials/loop/loop-radio-shows_header.php', false, false );
						
				if ( $index == $max_per_row ) : ?>
						
					</div>
			
				<?php
			
					$index = 0;
			
				else : 
			
					$index++;
			
				endif; ?>

			<?php endwhile; ?>
			
			<div class="header-overlay">
				
				<div class="row">
					<div class="small-12 columns">
					
						<h2>
							<?php _e( 'Up Next', 'good-shepherd-catholic-radio' ); ?>
						</h2>
						
					</div>
				</div>

			</div>
			
		</div>

		<?php wp_reset_postdata();

	endif; ?> 
	
</div>