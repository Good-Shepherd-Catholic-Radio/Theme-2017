<?php
/**
 * Radio Show Search "Template"
 * Generates a page on-the-fly based on the passed Search Term by overloading $wp_query
 * I am sorry
 *
 * @since       {{VERSION}}
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/templates
 */

defined( 'ABSPATH' ) || die();

global $wp_query;

// Stored here to avoid needing to re-do the query later
$radio_shows = $wp_query;

$wp_query = new WP_Query( array(
	's' => get_search_query(),
	'gscr_radio_show_search' => true,
	'post_type' => 'tribe_events',
	'posts_per_page' => 1,
	'eventDisplay' => 'custom',
	'post_parent' => 0,
	'order' => 'ASC',
	'orderby' => 'title',
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
			'key' => '_EventHideFromUpcoming',
			'compare' => 'NOT EXISTS',
		),
		array(
			'key' => '_rbm_radio_show_on_home_page', // Only show ones for the Home Page
			'value' => '1',
			'compare' => '=',
		),
	),
) );

// "Main Show" is the Parent Post ID of the Main Radio Show; the one displayed on the Home Page
$main_show_id = 0;

// If there are no posts, fake a 404
if ( ! have_posts() ) {
	$wp_query->is_404 = true;
	$wp_query->set( 's', false );
	locate_template( '404.php', true, true );
	exit;
}
else {
	
	while ( have_posts() ) : the_post();
	
		$main_show_id = get_the_id();
	
	endwhile;
	
}

$on_air_personalities = rbm_cpts_get_p2p_children( 'on-air-personality', $main_show_id );

// Just in case there are any Hooks for Events
locate_template( '/includes/hooks/tribe_events-hooks.php', true, true );

get_header();

// Restore WP Query, we've done the modifications we need
$wp_query = $radio_shows;

if ( $has_featured_image ) : ?>

	<div class="post-title">
		<div class="post-title-color-overlay"></div>
		<div class="post-title-text">
			<h1>
				<?php echo get_search_query(); ?>
			</h1>
		</div>
	</div>

<?php endif; ?>

<div class="main-content">
	
	<?php if ( ! $has_featured_image ) : ?>
	
		<div class="row">
			
			<div class="small-12 columns">

				<h1 class="post-title">
					<?php echo get_search_query(); ?>
				</h1>
				
			</div>
			
		</div>

	<?php endif; ?>
	
	<?php foreach ( $on_air_personalities as $personality_id ) : $personality = get_post( $personality_id ); ?>
	
		<div class="row on-air-personality post-<?php echo $personality_id; ?>">
			
			<div class="small-12 columns">
				
				<?php if ( has_post_thumbnail( $personality_id ) ) : ?>
					<div class="thumbnail alignleft">
						<a href="<?php echo get_permalink( $personality_id ); ?>" title="<?php echo get_the_title( $personality_id ); ?>">
							<?php echo get_the_post_thumbnail( $personality_id, 'thumbnail' ); ?>
						</a>
					</div>
				<?php endif; ?>

				<h3 class="post-title">
					<a href="<?php echo get_permalink( $personality_id ); ?>" title="<?php echo get_the_title( $personality_id ); ?>">
						<?php echo get_the_title( $personality_id ); ?>
					</a>
				</h3>
				
				<?php echo apply_filters( 'the_content', $personality->post_content ); ?>
				
			</div>
			
		</div>
	
	<?php endforeach; ?>
	
	<div class="row">
		
		<div class="small-12 columns">
			<h3><?php _e( 'Audio Archive', 'good-shepherd-catholic-radio' ); ?></h3>
		</div>
	
	</div>
	
	<?php locate_template( '/includes/hooks/' . get_post_type() . '-hooks.php', true, true );

	include locate_template( '/partials/loop/loop-radio_shows_search.php' );
	
	?>
	
</div>

	<?php

get_footer();