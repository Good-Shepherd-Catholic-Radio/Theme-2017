<?php
/**
 * Adds the [gscr_radio_show_programs] shortcode
 *
 * @since   1.0.24
 * @package Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/includes/shortcodes
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Add Underwriters Shortcode
 *
 * @since       1.0.0
 * @return      HTML
 */
add_shortcode( 'gscr_radio_show_programs', 'add_gscr_radio_show_programs_shortcode' );
function add_gscr_radio_show_programs_shortcode( $atts, $content ) {
    
    $atts = shortcode_atts(
        array( // a few default values
			'posts_per_page' => -1,
			'per_row' => 3,
        ),
        $atts,
        'gscr_radio_show_programs'
    );
	
	$programs = new WP_Query( array(
		'post_type' => 'tribe_events',
		'posts_per_page' => $atts['posts_per_page'],
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
				'relation' => 'OR',
				array(
					'key' => '_rbm_radio_show_on_home_page', // Only show ones for the Home Page
					'value' => '1',
					'compare' => '=',
				),
				array(
					'key' => '_rbm_radio_show_on_home_page', // New RBM FH format
					'value' => '"1"',
					'compare' => 'LIKE',
				),
			),
		),
	) );
	
	// Remove all duplicate entries. This is important for shows like Blue Collar Theology which have all their shows broken out of the series
	$temp = array();
	foreach( $programs->posts as $key => $object ) {

		$title = _gscr_sanitize_radio_show_name( $object->post_title );

		$temp[ $key ] = $title;

	}

	$temp = array_unique( $temp );

	foreach ( $programs->posts as $key => $object ) {

		if ( ! array_key_exists( $key, $temp ) ) {
			unset( $programs->posts[ $key ] );
		}

	}

	// Reindex array
	$programs->posts = array_values( $programs->posts );

	// Set Post Count to the new value
	$programs->post_count = count( $programs->posts );
	
	$index = 0;
	$medium_class = 'medium-' . ( 12 / $atts['per_row'] );
    
    ob_start();
	
	echo '<div class="radio-show-programs-shortcode">';
	
		if ( $programs->have_posts() ) : 

			while ( $programs->have_posts() ) : $programs->the_post(); ?>

				<?php if ( $index == 0 ) : ?>

					<div class="row">

				<?php endif;

						include locate_template( '/partials/loop/loop-radio_show_programs_shortcode.php' );

				if ( $index == ( $atts['per_row'] - 1 ) ) : ?>

					</div>

				<?php 

					$index = 0;

				else :

					$index++;

				endif;

			endwhile;

			wp_reset_postdata();

		endif;
	
	echo '</div>';
    
    $output = ob_get_contents();
    ob_end_clean();
    
    return html_entity_decode( $output );
    
}