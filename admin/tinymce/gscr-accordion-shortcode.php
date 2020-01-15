<?php
/**
 * Add a TinyMCE button to create [gscr_accordion] Shortcodes
 *
 * @since   1.0.0
 * @package Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/admin/tinymce
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Add Accordion Shortcode to TinyMCE
 *
 * @since       1.0.0
 * @return      void
 */
add_action( 'admin_init', 'add_gscr_accordion_tinymce_filters' );
function add_gscr_accordion_tinymce_filters() {
    
    if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
        
        add_filter( 'mce_buttons', function( $accordions ) {
            array_push( $accordions, 'gscr_accordion_shortcode' );
            return $accordions;
        } );
        
        // Attach script to the accordion rather than enqueueing it
        add_filter( 'mce_external_plugins', function( $plugin_array ) {
            $plugin_array['gscr_accordion_shortcode_script'] = get_stylesheet_directory_uri() . '/assets/js/tinymce/accordion-shortcode.js';
            return $plugin_array;
        } );
        
    }
    
}

/**
 * Add Localized Text for our TinyMCE Accordion
 *
 * @since       1.0.0
 * @return      Array Localized Text
 */
add_filter( 'gscr_tinymce_l10n', 'gscr_accordion_tinymce_l10n' );
function gscr_accordion_tinymce_l10n( $l10n ) {
    
    $l10n['gscr_accordion_shortcode'] = array(
        'tinymce_title' => _x( 'Add Accordion', 'Accordion Shortcode TinyMCE Accordion Text', 'good-shepherd-catholic-radio' ),
        'accordion_title' => array(
            'label' => _x( 'Accordion Title', "Accordion's Title", 'good-shepherd-catholic-radio' ),
        ),
        'accordion_open' => array(
            'label' => __( 'Open by default?', 'good-shepherd-catholic-radio' ),
        ),
        'accordion_contents' => array(
            'label' => _x( 'Place whatever you would like inside the Accordion here', "Accordion's Content", 'good-shepherd-catholic-radio' ),
        )
    );
    
    return $l10n;
    
}