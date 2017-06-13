<?php
/**
 * Posts on the Home Page
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/home
 */

defined( 'ABSPATH' ) || die();

// Just in case there are any Hooks for Events
locate_template( '/includes/hooks/tribe_events-hooks.php', true, true );

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

?>

<div class="upcoming-events row">

	<h2><?php _e( 'Upcoming Events', 'good-shepherd-catholic-radio' ); ?></h2>
	
	<?php if ( $events->have_posts() ) : ?>
	
		<?php while ( $events->have_posts() ) : $events->the_post(); ?>
	
			<a href="<?php echo tribe_get_event_link(); ?>" title="<?php the_title(); ?>">
	
				<article <?php post_class( array(
					'small-12',
					'columns'
				) ); ?>>
				
					<div class="row" data-equalizer data-equalize-on="medium">

						<div class="small-12 medium-2 columns date text-center" data-equalizer-watch>

							<?php $start_date = strtotime( get_post_meta( get_the_ID(), '_EventStartDate', true ) ); ?>

							<h4 class="day">
								<?php echo date_i18n( 'j', $start_date ); ?>
							</h4>
							<h5>
								<span class="month">
									<?php echo date_i18n( 'M', $start_date ); ?>
								</span>
								<span class="year">
									'<?php echo date_i18n( 'y', $start_date ); ?>
								</span>
							</h5>

						</div>

						<div class="small-12 medium-10 columns content" data-equalizer-watch>
							
							<div class="vertical-align">
								
								<div class="row">
									
									<div class="small-12 medium-8 columns">

										<h4 class="title">
											<?php the_title(); ?>
										</h4>
										
									</div>
									
									<div class="small-12 medium-2 columns">
								
										<div class="time alignright">
											<?php echo date_i18n( 'l', $start_date ); ?>
											<br />
											<?php echo date_i18n( 'G:i A', $start_date ); ?>
										</div>
										
									</div>
									
									<div class="small-12 medium-2 columns">
								
										<div class="button primary alignright">
											<?php _e( 'Learn More', 'good-shepherd-catholic-radio' ); ?>
										</div>
										
									</div>
									
								</div>
								
							</div>

						</div>
						
					</div>

				</article>
				
			</a>
	
		<?php endwhile; ?>
	
		<?php wp_reset_postdata(); ?>
	
	<?php else : ?>
	
		<?php _e( 'No Events Found', 'good-shepherd-catholic-radio' ); ?>
	
	<?php endif; ?>
	
</div>