<?php
/**
 * Events on the Home Page
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/home
 */

defined( 'ABSPATH' ) || die();

// Just in case there are any Hooks for Events
locate_template( '/includes/hooks/tribe_events-hooks.php', true, true );

$background_color = rbm_get_field( 'gscr_home_events_background' );
$background_color = ( ! $background_color ) ? '' : ' background-' . $background_color;

$button_color = rbm_get_field( 'gscr_home_events_button_color' );						
$button_color = ( ! $button_color ) ? 'secondary' : $button_color;

global $post;

$events = new WP_Query( array(
	'post_type' => 'tribe_events',
	'posts_per_page' => 5,
	'tax_query' => array(
		'relationship' => 'AND',
		array(
			'taxonomy' => 'tribe_events_cat',
			'field' => 'slug',
			'terms' => array( 'radio-show' ),
			'operator' => 'NOT IN'
		),
	),
	'meta_query'     => array(
		'relation'    => 'AND',
		array(
			'key' => '_EventStartDate',
			'value' => current_time( 'Y-m-d' ),
			'type' => 'DATETIME',
			'compare' => '>=',
		),
		array(
			'key' => '_EventEndDate',
			'value' => current_time( 'Y-m-d H:i:s' ),
			'type' => 'DATETIME',
			'compare' => '>',
		),
		array(
			'key' => '_EventHideFromUpcoming',
			'compare' => 'NOT EXISTS',
		),
	),
) );

$attachment_id = rbm_get_field( 'gscr_home_events_image' );

$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );

?>

<div class="home-section upcoming-events row expanded<?php echo $background_color; ?>">

	<div class="image" style="background-image: url('<?php echo $image_url; ?>');"></div>

	<div class="small-12 columns">
		
		<div class="row">
	
			<div class="small-12 medium-4 columns form">

				<div class="row small-collapse">
					<div class="small-12 columns">

						<h2>Events/PSA Form will go here</h2>

						<a data-open="gscr_events_modal" class="<?php echo $button_color; ?> button">
							<?php _e( 'Submit an Event/PSA', 'good-shepherd-catholic-radio' ); ?>
						</a>

					</div>

				</div>

				<div class="reveal" id="gscr_events_modal" data-reveal>

					Nothing here... yet

					<button class="close-button" data-close aria-label="<?php _e( 'Close modal', 'good-shepherd-catholic-radio' ); ?>" type="button">
						<span aria-hidden="true">&times;</span>
					</button>

				</div>

			</div>

			<div class="small-12 medium-8 columns content">

				<div class="row small-collapse">

					<div class="small-12 columns">

						<h2>
							
							<?php _e( 'Upcoming Events', 'good-shepherd-catholic-radio' ); ?>
							
							<a href="<?php echo get_post_type_archive_link( 'tribe_events' ); ?>" class="button <?php echo $button_color; ?> alignright view-all-button">
								<?php _e( 'View All', 'good-shepherd-catholic-radio' ); ?>
							</a>
							
						</h2>

						<?php if ( $events->have_posts() ) : ?>

							<?php while ( $events->have_posts() ) : $events->the_post(); ?>

								<?php include locate_template( 'partials/loop/loop-tribe_events_home.php' ); ?>

							<?php endwhile; ?>

							<?php wp_reset_postdata(); ?>

						<?php else : ?>

							<?php _e( 'No Events Found', 'good-shepherd-catholic-radio' ); ?>

						<?php endif; ?>

					</div>

				</div>

			</div>
			
		</div>
		
	</div>
	
</div>