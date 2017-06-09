<?php
/**
 * Adds the [gscr_on_air_personalities] shortcode
 *
 * @since   1.0.0
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
add_shortcode( 'gscr_on_air_personalities', 'add_gscr_on_air_personalities_shortcode' );
function add_gscr_on_air_personalities_shortcode( $atts, $content ) {
    
    $atts = shortcode_atts(
        array( // a few default values
			'posts_per_page' => -1,
			'per_row' => 2,
        ),
        $atts,
        'gscr_on_air_personalities'
    );
	
	$on_air_personalities = new WP_Query( array(
		'post_type' => 'on-air-personality',
		'posts_per_page' => $atts['posts_per_page'],
	) );
	
	$index = 0;
	$medium_class = 'medium-' . ( 12 / $atts['per_row'] );
    
    ob_start();
	
	if ( $on_air_personalities->have_posts() ) : 
	
		while ( $on_air_personalities->have_posts() ) : $on_air_personalities->the_post(); ?>

			<?php if ( $index == 0 ) : ?>

				<div class="row">

			<?php endif;
	
					include locate_template( '/partials/loop/loop-on_air_personalities_shortcode.php' );
					
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
    
    $output = ob_get_contents();
    ob_end_clean();
    
    return html_entity_decode( $output );
    
}