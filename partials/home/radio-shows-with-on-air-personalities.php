<?php
/**
 * Radio Shows with On-Air Personalities on the Home Page
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/home
 */

defined( 'ABSPATH' ) || die();

// Just in case there are any Hooks for Events
locate_template( '/includes/hooks/tribe_events-hooks.php', true, true );

function _gscr_sanitize_radio_show_name( $title ) {
	
	// Remove (Live) or (Encore) from the end
	$title = preg_replace( '/\s(?:\(Encore\)|\(Live\))$/si', '', $title );
	
	// Remove "with ..." from the end of Titles
	$title = preg_replace( '/\swith.*$/si', '', $title );
	
	// Remove "The Best of..." from the start of Titles
	$title = preg_replace( '/^The\sBest\sof\s/si', '', $title );
	
	return $title;
	
}

global $post;

$radio_shows = new WP_Query( array(
	'post_type' => 'tribe_events',
	'posts_per_page' => -1,
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

// Remove all duplicate entries. This is important for shows like Blue Collar Theology which have all their shows broken out of the series
$temp = array();
foreach( $radio_shows->posts as $key => $object ) {
	
	$title = _gscr_sanitize_radio_show_name( $object->post_title );
	
    $temp[ $key ] = $title;
	
}

$temp = array_unique( $temp );

foreach ( $radio_shows->posts as $key => $object ) {
	
	if ( ! array_key_exists( $key, $temp ) ) {
		unset( $radio_shows->posts[ $key ] );
	}
	
}

// Reindex array
$radio_shows->posts = array_values( $radio_shows->posts );

// Set Post Count to the new value
$radio_shows->post_count = count( $radio_shows->posts );

?>

<div class="row">

<?php

if ( $radio_shows->have_posts() ) : 

	while ( $radio_shows->have_posts() ) : $radio_shows->the_post(); ?>

		
		<div class="radio-show-on-air-personality small-12 medium-3 columns">
			
			<?php echo _gscr_sanitize_radio_show_name( get_the_title() ); ?>
	
		</div>


	<?php endwhile;

	wp_reset_postdata();

endif;
	
?>
	
</div>