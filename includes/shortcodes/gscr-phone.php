<?php
/**
 * Adds the [gscr_phone] shortcode
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
 * Add Phone Shortcode
 *
 * @since       1.0.0
 * @return      HTML
 */
add_shortcode( 'gscr_phone', 'add_gscr_phone_shortcode' );
function add_gscr_phone_shortcode( $atts, $content = '' ) {
    
    $atts = shortcode_atts(
        array( // a few default values
            'phone_number' => '',
			'extension' => false,
			'phone_icon' => false,
        ),
        $atts,
        'gscr_phone'
    );
	
	if ( empty( $atts['phone_number'] ) ) {
		$atts['phone_number'] = get_theme_mod( 'gscr_phone_number', '1-517-513-3340' );
	}
    
    ob_start();
    
    echo gscr_get_phone_number_link( $atts['phone_number'], $atts['extension'], $content, $atts['phone_icon'] );
    
    $output = ob_get_contents();
    ob_end_clean();
    
    return html_entity_decode( $output );
    
}