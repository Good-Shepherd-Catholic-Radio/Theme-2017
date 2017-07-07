<?php
/**
 * Add a TinyMCE button to create [gscr_button] Shortcodes
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
 * Add Button Shortcode to TinyMCE
 *
 * @since       1.0.0
 * @return      void
 */
add_action( 'admin_init', 'add_gscr_button_tinymce_filters' );
function add_gscr_button_tinymce_filters() {
    
    if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
        
        add_filter( 'mce_buttons', function( $buttons ) {
            array_push( $buttons, 'gscr_button_shortcode' );
            return $buttons;
        } );
        
        // Attach script to the button rather than enqueueing it
        add_filter( 'mce_external_plugins', function( $plugin_array ) {
            $plugin_array['gscr_button_shortcode_script'] = get_stylesheet_directory_uri() . '/assets/js/tinymce/button-shortcode.js';
            return $plugin_array;
        } );
        
    }
    
}

/**
 * Add Localized Text for our TinyMCE Button
 *
 * @since       1.0.0
 * @return      Array Localized Text
 */
add_filter( 'gscr_tinymce_l10n', 'gscr_button_tinymce_l10n' );
function gscr_button_tinymce_l10n( $l10n ) {
    
    $l10n['gscr_button_shortcode'] = array(
        'tinymce_title' => _x( 'Add Button', 'Button Shortcode TinyMCE Button Text', 'good-shepherd-catholic-radio' ),
        'button_text' => array(
            'label' => _x( 'Button Text', "Button's Text", 'good-shepherd-catholic-radio' ),
        ),
        'button_url' => array(
            'label' => _x( 'Button Link', 'Link for the Button', 'good-shepherd-catholic-radio' ),
        ),
        'colors' => array(
            'label' => _x( 'Color', 'Button Color Selection Label', 'good-shepherd-catholic-radio' ),
            'default' => 'secondary',
            'choices' => array(
                'primary' => _x( 'Violet', 'Primary Theme Color', 'good-shepherd-catholic-radio' ),
                'secondary' => _x( 'Green', 'Secondary Theme Color', 'good-shepherd-catholic-radio' ),
				'tertiary' => _x( 'Dark Purple', 'Secondary Theme Color', 'good-shepherd-catholic-radio' ),
				'quaternary' => _x( 'Gold', 'Secondary Theme Color', 'good-shepherd-catholic-radio' ),
            ),
        ),
        'size' => array(
            'label' => _x( 'Size', 'Button Size Selection Lable', 'good-shepherd-catholic-radio' ),
            'default' => '',
            'choices' => array(
				'' => _x( 'Default', 'Default Button Size', 'good-shepherd-catholic-radio' ),
                'tiny' => _x( 'Tiny', 'Tiny Button Size', 'good-shepherd-catholic-radio' ),
                'small' => _x( 'Small', 'Small Button Size', 'good-shepherd-catholic-radio' ),
                'medium' => _x( 'Medium', 'Medium Button Size', 'good-shepherd-catholic-radio' ),
                'large' => _x( 'Large', 'Large Button Size', 'good-shepherd-catholic-radio' ),
            ),
        ),
        'hollow' => array(
            'label' => _x( 'Hollow/"Ghost" Button?', 'Hollow Button Style', 'good-shepherd-catholic-radio' ),
        ),
        'expand' => array(
            'label' => _x( 'Full Width?', 'Full Width Button', 'good-shepherd-catholic-radio' ),
        ),
        'new_tab' => array(
            'label' => __( 'Open Link in a New Tab?', 'good-shepherd-catholic-radio' ),
        ),
    );
    
    return $l10n;
    
}