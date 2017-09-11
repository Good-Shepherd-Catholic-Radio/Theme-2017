<?php
/**
 * Add a TinyMCE button to create [gscr_form_overlay] Shortcodes
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
add_action( 'admin_init', 'add_gscr_form_overlay_tinymce_filters' );
function add_gscr_form_overlay_tinymce_filters() {
    
    if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
        
        add_filter( 'mce_buttons', function( $buttons ) {
            array_push( $buttons, 'gscr_form_overlay_shortcode' );
            return $buttons;
        } );
        
        // Attach script to the button rather than enqueueing it
        add_filter( 'mce_external_plugins', function( $plugin_array ) {
            $plugin_array['gscr_form_overlay_shortcode_script'] = get_stylesheet_directory_uri() . '/assets/js/tinymce/form-overlay-shortcode.js';
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
add_filter( 'gscr_tinymce_l10n', 'gscr_form_overlay_tinymce_l10n' );
function gscr_form_overlay_tinymce_l10n( $l10n ) {
	
	$gravity_forms = wp_list_pluck( RGFormsModel::get_forms( null, 'title' ), 'title', 'id' );
    
    $l10n['gscr_form_overlay_shortcode'] = array(
        'tinymce_title' => _x( 'Add Form Overlay', 'Form Overlay Shortcode TinyMCE Button Text', 'good-shepherd-catholic-radio' ),
		'form_id' => array(
			'label' => _x( 'Gravity Form', 'Form to use in Overlay Label', 'good-shepherd-catholic-radio' ),
			'choices' => $gravity_forms,
		),
        'button_text' => array(
            'label' => _x( 'Button Text', "Button's Text", 'good-shepherd-catholic-radio' ),
        ),
        'colors' => array(
            'label' => _x( 'Button Color', 'Button Color Selection Label', 'good-shepherd-catholic-radio' ),
        ),
        'size' => array(
            'label' => _x( 'Button Size', 'Button Size Selection Lable', 'good-shepherd-catholic-radio' ),
        ),
        'hollow' => array(
            'label' => _x( 'Hollow/"Ghost" Button?', 'Hollow Button Style', 'good-shepherd-catholic-radio' ),
        ),
        'expand' => array(
            'label' => _x( 'Full Width Button?', 'Full Width Button', 'good-shepherd-catholic-radio' ),
        ),
    );
    
    return $l10n;
    
}