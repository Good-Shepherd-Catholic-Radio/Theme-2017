<?php
/**
 * Radio Shows on the Home Page
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/home
 */

defined( 'ABSPATH' ) || die();

// Just in case there are any Hooks for Events
locate_template( '/includes/hooks/tribe_events-hooks.php', true, true );

global $post;

$radio_shows = new WP_Query( array(
	'post_type' => 'tribe_events',
	'posts_per_page' => 3,
	'tax_query' => array(
		'relationship' => 'AND',
		array(
			'taxonomy' => 'tribe_events_cat',
			'field' => 'slug',
			'terms' => array( 'radio-show' ),
			'operator' => 'IN'
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

$index = 0; 
$max_per_row = 0;

?>

<div class="radio-shows-header row expanded small-collapse">

	<?php if ( $radio_shows->have_posts() ) : $radio_shows->the_post(); // Forcefully start loop to have our side-section ?>
	
		<div class="small-12 medium-6 columns radio-shows-left">
			
			<div class="row expanded">
			
				<?php 
				// Included outside so that we have the one large cell to the left
				get_template_part( 'partials/loop/loop', 'radio-shows_header' ); ?>
				
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

						get_template_part( 'partials/loop/loop', 'radio-shows_header' );
						
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
							<?php _e( 'Upcoming', 'good-shepherd-catholic-radio' ); ?>
						</h2>
						
					</div>
				</div>

			</div>
			
		</div>

		<?php wp_reset_postdata();

	endif; ?> 
	
</div>