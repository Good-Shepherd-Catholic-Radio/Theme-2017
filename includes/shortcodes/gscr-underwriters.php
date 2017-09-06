<?php
/**
 * Adds the [gscr_underwriters] shortcode
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
add_shortcode( 'gscr_underwriters', 'add_gscr_underwriters_shortcode' );
function add_gscr_underwriters_shortcode( $atts, $content ) {
    
    $atts = shortcode_atts(
        array( // a few default values
			'posts_per_page' => -1,
			'per_row' => 2,
			'category' => '',
        ),
        $atts,
        'gscr_underwriters'
    );
	
	$args = array(
		'post_type' => 'underwriter',
		'posts_per_page' => $atts['posts_per_page'],
	);
	
	if ( ! empty( $atts['category'] ) ) {
		
		$categories = explode( ',', trim( $atts['category'] ) );
		$categories = array_map( 'trim', $categories );
		
		$args['tax_query'] = array(
			'relationship' => 'AND',
			array(
				'taxonomy' => 'underwriter-category',
				'field' => 'name',
				'terms' => $categories,
				'operator' => 'IN'
			),
		);
		
	}
	
	$underwriters = new WP_Query( $args );
	
	$index = 0;
	$medium_class = 'medium-' . ( 12 / $atts['per_row'] );
    
    ob_start();
	
	if ( $underwriters->have_posts() ) : 
	
		while ( $underwriters->have_posts() ) : $underwriters->the_post(); ?>

			<?php if ( $index == 0 ) : ?>

				<div class="row">

			<?php endif;
	
					include locate_template( '/partials/loop/loop-underwriters_shortcode.php' );
					
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