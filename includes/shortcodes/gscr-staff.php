<?php
/**
 * Adds the [gscr_staff] shortcode
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
 * Add staffs Shortcode
 *
 * @since       1.0.0
 * @return      HTML
 */
add_shortcode( 'gscr_staff', 'add_gscr_staff_shortcode' );
function add_gscr_staff_shortcode( $atts, $content ) {
    
    $atts = shortcode_atts(
        array( // a few default values
			'posts_per_page' => -1,
			'category' => '',
        ),
        $atts,
        'gscr_staff'
    );
	
	$args = array(
		'post_type' => 'staff',
		'posts_per_page' => $atts['posts_per_page'],
	);
	
	if ( ! empty( $atts['category'] ) ) {
		
		$categories = explode( ',', trim( $atts['category'] ) );
		$categories = array_map( 'trim', $categories );
		
		$args['tax_query'] = array(
			'relationship' => 'AND',
			array(
				'taxonomy' => 'staff-category',
				'field' => 'name',
				'terms' => $categories,
				'operator' => 'IN'
			),
		);
		
	}
	
	$staff = new WP_Query( $args );
	
	$index = 0;
	$medium_class = 'medium-' . ( 12 / $atts['per_row'] );
    
    ob_start();
	
	if ( $staff->have_posts() ) : ?>

		<ul class="no-bullet">
	
			<?php while ( $staff->have_posts() ) : $staff->the_post();

				include locate_template( '/partials/loop/loop-staff_shortcode.php' );

			endwhile;

			wp_reset_postdata(); ?>
			
		</ul>
	
	<?php endif;
    
    $output = ob_get_contents();
    ob_end_clean();
    
    return html_entity_decode( $output );
    
}