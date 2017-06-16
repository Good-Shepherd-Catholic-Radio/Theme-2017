<?php
/**
 * Home extra meta.
 *
 * @since   1.0.0
 * @package Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/admin/extra-meta
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Remove unneeded Default Meta/Supports for the Home Page
add_action( 'init', 'gscr_remove_home_supports' );
add_action( 'do_meta_boxes', 'gscr_remove_home_metaboxes' );

// Add the Metaboxes that we want for the Home Page
add_action( 'add_meta_boxes', 'gscr_add_home_metaboxes' );

/**
 * Remove Supports from the Home Page
 * 
 * @since       1.0.0
 * @return      void
 */
function gscr_remove_home_supports() {
    
    if ( is_admin() && isset( $_REQUEST['post'] ) && $_REQUEST['post'] == get_option( 'page_on_front' ) ) {

        remove_post_type_support( 'page', 'thumbnail' );
        remove_post_type_support( 'page', 'editor' );
        
    }
    
}

/**
 * Needs to be called at do_meta_boxes since it is created at a different time than Supports Metaboxes
 * 
 * @since       1.0.0
 * @return      void
 */
function gscr_remove_home_metaboxes() {
    
    if ( is_admin() && isset( $_REQUEST['post'] ) && $_REQUEST['post'] == get_option( 'page_on_front' ) ) {
    
        // "Attributes" Meta Box
        remove_meta_box( 'pageparentdiv', 'page', 'side' );
        
    }
    
}

/**
 * Create Metaboxes for the Home Page
 * 
 * @since       1.0.0
 * @return      void
 */
function gscr_add_home_metaboxes() {
    
    if ( is_admin() && 
		isset( $_REQUEST['post'] ) && 
		$_REQUEST['post'] == get_option( 'page_on_front' ) ) {
		
		add_meta_box(
            'gscr-home-events',
            _x( 'Upcoming Events Section', 'Home Events Metabox Title', 'good-shepherd-catholic-radio' ),
            'gscr_home_events_metabox_content',
            'page',
            'normal'
        );
		
		add_meta_box(
            'gscr-home-donat-listen',
            _x( 'Donate/Listen Section', 'Home Donate/Listen Metabox Title', 'good-shepherd-catholic-radio' ),
            'gscr_home_donate_listen_metabox_content',
            'page',
            'normal'
        );
		
		add_meta_box(
            'gscr-home-prayer-requests',
            _x( 'Prayer Requests Section', 'Home Prayer Requests Metabox Title', 'good-shepherd-catholic-radio' ),
            'gscr_home_prayer_requests_metabox_content',
            'page',
            'normal'
        );
        
    }
    
}

/**
 * Put fields in the Events Metabox
 * 
 * @since       1.0.0
 * @return      void
 */
function gscr_home_events_metabox_content() {
    
    rbm_do_field_media(
        'gscr_home_events_image',
        _x( 'Background Image', 'Home Upcomming Events Background Image Label', 'good-shepherd-catholic-radio' ),
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

/**
 * Put fields in the Donate/Listen Metabox
 * 
 * @since       1.0.0
 * @return      void
 */
function gscr_home_donate_listen_metabox_content() {
    
    // All Forms
	$give_forms = new WP_Query( array(
		'post_type' => 'give_forms',
		'posts_per_page' => -1,
		'orderby' => 'post_title',
		'order' => 'ASC',
	) );
	
	$give_forms = wp_list_pluck( $give_forms->posts, 'post_title', 'ID' );
    
    rbm_do_field_select(
        'gscr_home_donate_form',
        _x( 'Donate Form', 'Home Donate Form Label', 'good-shepherd-catholic-radio' ),
        false,
        array(
            'description' => __( 'Choose the Give Form through which Visitors will Donate.', 'good-shepherd-catholic-radio' ),
            'options' => $give_forms,
        )
    );
	
	rbm_do_field_wysiwyg(
		'gscr_home_listen_text',
		_x( 'Listening Options', 'Home Listen Text Label', 'good-shepherd-catholic-radio' ),
		false,
		array(
		)
	);
    
}

/**
 * Put fields in the Prayer Requests Metabox
 * 
 * @since       1.0.0
 * @return      void
 */
function gscr_home_prayer_requests_metabox_content() {
    
    $gravity_forms = wp_list_pluck( RGFormsModel::get_forms( null, 'title' ), 'title', 'id' );
    
    rbm_do_field_select(
        'gscr_home_prayer_request_form',
        _x( 'Prayer Requests Form', 'Home Prayer Requests Form Label', 'good-shepherd-catholic-radio' ),
        false,
        array(
            'description' => __( 'Choose the Gravity Form through which Visitors will submit Prayer Requests.', 'good-shepherd-catholic-radio' ),
            'options' => $gravity_forms,
        )
    );
    
}