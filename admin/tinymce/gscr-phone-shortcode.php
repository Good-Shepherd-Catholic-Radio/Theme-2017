<?php
/**
 * Add a TinyMCE button to create [gscr_phone] Shortcodes
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
 * Add Phone Shortcode to TinyMCE
 *
 * @since       1.0.0
 * @return      void
 */
add_action( 'admin_init', 'add_gscr_phone_tinymce_filters' );
function add_gscr_phone_tinymce_filters() {
    
    if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
        
        add_filter( 'mce_buttons', function( $buttons ) {
            array_push( $buttons, 'gscr_phone_shortcode' );
            return $buttons;
        } );
        
        // Attach script to the button rather than enqueueing it
        add_filter( 'mce_external_plugins', function( $plugin_array ) {
            $plugin_array['gscr_phone_shortcode_script'] = get_stylesheet_directory_uri() . '/assets/js/tinymce/phone-shortcode.js';
            return $plugin_array;
        } );
        
    }
    
}

/**
 * Add Localized Text for our TinyMCE Phone
 *
 * @since       1.0.0
 * @return      Array Localized Text
 */
add_filter( 'gscr_tinymce_l10n', 'gscr_phone_tinymce_l10n' );
function gscr_phone_tinymce_l10n( $l10n ) {
    
    $l10n['gscr_phone_shortcode'] = array(
        'tinymce_title' => _x( 'Add Phone Number', 'Phone Shortcode TinyMCE Phone Text', 'good-shepherd-catholic-radio' ),
        'phone_number' => array(
            'label' => _x( 'Phone Number', "Phone Number Label", 'good-shepherd-catholic-radio' ),
        ),
        'extension' => array(
            'label' => _x( 'Phone Number Extension (Optional)', 'Phone Number Extension Label', 'good-shepherd-catholic-radio' ),
        ),
        'link_text' => array(
            'label' => _x( 'Text for the link to use instead of the Phone Number (Optional)', 'Phone Number Text Label', 'good-shepherd-catholic-radio' ),
        ),
        'phone_icon' => array(
            'label' => _x( 'Place a Phone Icon before the Link?', 'Phone Icon Label', 'good-shepherd-catholic-radio' ),
        ),
    );
    
    return $l10n;
    
}