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
		'post_type' => 'radio-show',
		'posts_per_page' => $atts['posts_per_page'],
		'post_status' => 'publish',
		'order' => 'ASC',
		'orderby' => 'title',
	) );
	
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