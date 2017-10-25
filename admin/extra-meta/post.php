<?php
/**
 * Posts extra meta.
 *
 * @since   {{VERSION}}
 * @package Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/admin/extra-meta
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Add the Metaboxes that we want for Posts
add_action( 'add_meta_boxes', 'gscr_add_post_metaboxes' );

/**
 * Create Metaboxes for the Posts
 * 
 * @since       {{VERSION}}
 * @return      void
 */
function gscr_add_post_metaboxes() {
		
	add_meta_box(
		'gscr-post-banner-image',
		_x( 'Banner Image', 'Post Banner Image Metabox Title', 'good-shepherd-catholic-radio' ),
		'gscr_post_banner_image_metabox_content',
		'post',
		'side'
	);
    
}

/**
 * Put fields in the Banner Image Metabox
 * 
 * @since       {{VERSION}}
 * @return      void
 */
function gscr_post_banner_image_metabox_content() {
	
	rbm_do_field_media(
        'gscr_post_banner_image',
        _x( 'Banner Image (Recommended 1170 × 400)', 'Posts Banner Image Label', 'good-shepherd-catholic-radio' ),
        false,
        array(
            'type' => 'image',
            'button_text' => _x( 'Upload/Choose Image', 'Home Events Image Upload Button Text', 'good-shepherd-catholic-radio' ),
            'button_remove_text' => _x( 'Remove Image', 'Home Events Image Remove Button Text', 'good-shepherd-catholic-radio' ),
            'window_title' => _x( 'Choose Image', 'Home Events Image Window Title', 'good-shepherd-catholic-radio' ),
            'window_button_text' => _x( 'Use Image', 'Home Events Image Select Button Text', 'good-shepherd-catholic-radio' ),
        )
    );
    
}