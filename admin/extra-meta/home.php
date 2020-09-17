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
            'gscr-home-donate-listen',
            _x( 'Donate/Listen Section', 'Home Donate/Listen Metabox Title', 'good-shepherd-catholic-radio' ),
            'gscr_home_donate_listen_metabox_content',
            'page',
            'normal'
        );
		
		/*
		add_meta_box(
            'gscr-home-on-air-personalities',
            _x( 'On-Air Personalities Section', 'Home On-Air Personalities Metabox Title', 'good-shepherd-catholic-radio' ),
            'gscr_home_on_air_personalities_metabox_content',
            'page',
            'normal'
        );
		*/
		
		add_meta_box(
            'gscr-home-radio-show-programs',
            _x( 'Programs Section', 'Home Programs Metabox Title', 'good-shepherd-catholic-radio' ),
            'gscr_home_radio_show_programs_metabox_content',
            'page',
            'normal'
        );
		
		add_meta_box(
            'gscr-home-events',
            _x( 'Upcoming Events Section', 'Home Events Metabox Title', 'good-shepherd-catholic-radio' ),
            'gscr_home_events_metabox_content',
            'page',
            'normal'
        );
		
		add_meta_box(
            'gscr-home-underwriters',
            _x( 'Underwriters Section', 'Home Underwriters Metabox Title', 'good-shepherd-catholic-radio' ),
            'gscr_home_underwriters_metabox_content',
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
	
	rbm_do_field_text(
		'gscr_home_events_psa_title',
		_x( 'Events/PSA Title', 'Home Events/PSA Title', 'good-shepherd-catholic-radio' ),
		false,
		array(
			'default' => __( 'Events/Public Service Announcement Policies and Forms', 'good-shepherd-catholic-radio' ),
		)
	);
    
    rbm_do_field_select(
		'gscr_home_events_background',
		_x( 'Events Background Color', 'Home Events Background Color Label', 'good-shepherd-catholic-radio' ),
		false,
		array(
			'options' => array(
				'' => __( 'White', 'good-shepherd-catholic-radio' ),
				'primary' => _x( 'Purple', 'Primary Theme Color', 'good-shepherd-catholic-radio' ),
				'secondary' => _x( 'Green', 'Secondary Theme Color', 'good-shepherd-catholic-radio' ),
				'tertiary' => _x( 'Blue', 'Tertiary Theme Color', 'good-shepherd-catholic-radio' ),
				'quaternary' => _x( 'Gold', 'Quaternary Theme Color', 'good-shepherd-catholic-radio' ),
				'quinary' => _x( 'Rose', 'Quinary Theme Color', 'good-shepherd-catholic-radio' ),
            ),
		)
	);
	
	rbm_do_field_select(
		'gscr_home_events_button_color',
		_x( 'Events Button Color', 'Home Events Button Color Label', 'good-shepherd-catholic-radio' ),
		false,
		array(
			'description' => __( 'This changes the color of the buttons in this section', 'good-shepherd-catholic-radio' ),
			'default' => 'secondary',
			'options' => array(
				'primary' => _x( 'Purple', 'Primary Theme Color', 'good-shepherd-catholic-radio' ),
				'secondary' => _x( 'Green', 'Secondary Theme Color', 'good-shepherd-catholic-radio' ),
				'tertiary' => _x( 'Blue', 'Tertiary Theme Color', 'good-shepherd-catholic-radio' ),
				'quaternary' => _x( 'Gold', 'Quaternary Theme Color', 'good-shepherd-catholic-radio' ),
				'quinary' => _x( 'Rose', 'Quinary Theme Color', 'good-shepherd-catholic-radio' ),
            ),
		)
	);
	
	rbm_do_field_media(
        'gscr_home_events_image',
        _x( 'Background Image', 'Home Upcomming Events Background Image Label', 'good-shepherd-catholic-radio' ),
        false,
        array(
			'description' => _x( 'This is also used as the Hero Image on the Calendar page', 'Home Upcoming Events Background Image Description', 'good-shepherd-catholic-radio' ),
            'type' => 'image',
            'button_text' => _x( 'Upload/Choose Image', 'Home Events Image Upload Button Text', 'good-shepherd-catholic-radio' ),
            'button_remove_text' => _x( 'Remove Image', 'Home Events Image Remove Button Text', 'good-shepherd-catholic-radio' ),
            'window_title' => _x( 'Choose Image', 'Home Events Image Window Title', 'good-shepherd-catholic-radio' ),
            'window_button_text' => _x( 'Use Image', 'Home Events Image Select Button Text', 'good-shepherd-catholic-radio' ),
        )
    );
    
}

/**
 * Put fields in the On-Air Personalities Metabox
 * 
 * @since       1.0.0
 * @return      void
 */
function gscr_home_on_air_personalities_metabox_content() {
    
    rbm_do_field_select(
		'gscr_home_on_air_personalities_background',
		_x( 'On-Air Personalities Background Color', 'Home On-Air Personalities Background Color Label', 'good-shepherd-catholic-radio' ),
		false,
		array(
			'options' => array(
				'' => __( 'White', 'good-shepherd-catholic-radio' ),
				'primary' => _x( 'Purple', 'Primary Theme Color', 'good-shepherd-catholic-radio' ),
				'secondary' => _x( 'Green', 'Secondary Theme Color', 'good-shepherd-catholic-radio' ),
				'tertiary' => _x( 'Blue', 'Tertiary Theme Color', 'good-shepherd-catholic-radio' ),
				'quaternary' => _x( 'Gold', 'Quaternary Theme Color', 'good-shepherd-catholic-radio' ),
				'quinary' => _x( 'Rose', 'Quinary Theme Color', 'good-shepherd-catholic-radio' ),
            ),
		)
	);
	
	rbm_do_field_select(
		'gscr_home_on_air_personalities_button_color',
		_x( 'On-Air Personalities Button Color', 'Home On-Air Personalities Button Color Label', 'good-shepherd-catholic-radio' ),
		false,
		array(
			'description' => __( 'This changes the color of the buttons in this section', 'good-shepherd-catholic-radio' ),
			'default' => 'secondary',
			'options' => array(
				'primary' => _x( 'Purple', 'Primary Theme Color', 'good-shepherd-catholic-radio' ),
				'secondary' => _x( 'Green', 'Secondary Theme Color', 'good-shepherd-catholic-radio' ),
				'tertiary' => _x( 'Blue', 'Tertiary Theme Color', 'good-shepherd-catholic-radio' ),
				'quaternary' => _x( 'Gold', 'Quaternary Theme Color', 'good-shepherd-catholic-radio' ),
				'quinary' => _x( 'Rose', 'Quinary Theme Color', 'good-shepherd-catholic-radio' ),
            ),
		)
	);
    
}

/**
 * Put fields in the Programs Metabox
 * 
 * @since       1.0.24
 * @return      void
 */
function gscr_home_radio_show_programs_metabox_content() {
    
    rbm_do_field_select(
		'gscr_home_radio_show_programs_background',
		_x( 'Programs Background Color', 'Home Programs Background Color Label', 'good-shepherd-catholic-radio' ),
		false,
		array(
			'options' => array(
				'' => __( 'White', 'good-shepherd-catholic-radio' ),
				'primary' => _x( 'Purple', 'Primary Theme Color', 'good-shepherd-catholic-radio' ),
				'secondary' => _x( 'Green', 'Secondary Theme Color', 'good-shepherd-catholic-radio' ),
				'tertiary' => _x( 'Blue', 'Tertiary Theme Color', 'good-shepherd-catholic-radio' ),
				'quaternary' => _x( 'Gold', 'Quaternary Theme Color', 'good-shepherd-catholic-radio' ),
				'quinary' => _x( 'Rose', 'Quinary Theme Color', 'good-shepherd-catholic-radio' ),
            ),
		)
	);
	
	rbm_do_field_select(
		'gscr_home_radio_show_programs_button_color',
		_x( 'Programs Button Color', 'Home Programs Button Color Label', 'good-shepherd-catholic-radio' ),
		false,
		array(
			'description' => __( 'This changes the color of the buttons in this section', 'good-shepherd-catholic-radio' ),
			'default' => 'secondary',
			'options' => array(
				'primary' => _x( 'Purple', 'Primary Theme Color', 'good-shepherd-catholic-radio' ),
				'secondary' => _x( 'Green', 'Secondary Theme Color', 'good-shepherd-catholic-radio' ),
				'tertiary' => _x( 'Blue', 'Tertiary Theme Color', 'good-shepherd-catholic-radio' ),
				'quaternary' => _x( 'Gold', 'Quaternary Theme Color', 'good-shepherd-catholic-radio' ),
				'quinary' => _x( 'Rose', 'Quinary Theme Color', 'good-shepherd-catholic-radio' ),
            ),
		)
	);
    
}

/**
 * Put fields in the Underwriters Metabox
 * 
 * @since       1.0.0
 * @return      void
 */
function gscr_home_underwriters_metabox_content() {
    
    rbm_do_field_select(
		'gscr_home_underwriters_background',
		_x( 'Underwriters Background Color', 'Home Underwriters Background Color Label', 'good-shepherd-catholic-radio' ),
		false,
		array(
			'options' => array(
				'' => __( 'White', 'good-shepherd-catholic-radio' ),
				'primary' => _x( 'Purple', 'Primary Theme Color', 'good-shepherd-catholic-radio' ),
				'secondary' => _x( 'Green', 'Secondary Theme Color', 'good-shepherd-catholic-radio' ),
				'tertiary' => _x( 'Blue', 'Tertiary Theme Color', 'good-shepherd-catholic-radio' ),
				'quaternary' => _x( 'Gold', 'Quaternary Theme Color', 'good-shepherd-catholic-radio' ),
				'quinary' => _x( 'Rose', 'Quinary Theme Color', 'good-shepherd-catholic-radio' ),
            ),
		)
	);
	
	rbm_do_field_select(
		'gscr_home_underwriters_button_color',
		_x( 'Underwriters Button Color', 'Home Underwriters Button Color Label', 'good-shepherd-catholic-radio' ),
		false,
		array(
			'description' => __( 'This changes the color of the buttons in this section', 'good-shepherd-catholic-radio' ),
			'default' => 'secondary',
			'options' => array(
				'primary' => _x( 'Purple', 'Primary Theme Color', 'good-shepherd-catholic-radio' ),
				'secondary' => _x( 'Green', 'Secondary Theme Color', 'good-shepherd-catholic-radio' ),
				'tertiary' => _x( 'Blue', 'Tertiary Theme Color', 'good-shepherd-catholic-radio' ),
				'quaternary' => _x( 'Gold', 'Quaternary Theme Color', 'good-shepherd-catholic-radio' ),
				'quinary' => _x( 'Rose', 'Quinary Theme Color', 'good-shepherd-catholic-radio' ),
            ),
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

	rbm_fh_do_field_toggle( array(
		'name' => 'gscr_show_two_donate_listen_sections',
		'label' => __( 'Show two blocks?', 'good-shepherd-catholic-radio' ),
	) );

	rbm_do_field_text(
		'gscr_home_donate_title',
		__( 'Block One Title', 'good-shepherd-catholic-radio' ),
		false,
		array(
			'default' => __( 'Support Good Shepherd Catholic Radio', 'good-shepherd-catholic-radio' ),
			'input_atts' => array(
				'required' => true,
			)
		)
	);

	rbm_do_field_wysiwyg(
		'gscr_home_donate_text',
		__( 'Block One Content', 'good-shepherd-catholic-radio' ),
		false,
		array(
			'wysiwyg_options' => array(
				'mediaButtons' => false,
				'tinymce' => array(
					'content_css' => THEME_URL . 'assets/css/app.css',
					'toolbar1' => 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,wp_more,wp_adv',
					'toolbar2' => 'strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help',
				),
			)
		)
	);
	
	rbm_do_field_media(
 		'gscr_home_donate_image',
 		_x( 'Block One Background Image', 'Home Donate Background Image Label', 'good-shepherd-catholic-radio' ),
 		false,
 		array(
			'type' => 'image',
			'button_text' => _x( 'Upload/Choose Image', 'Home Donate Image Upload Button Text', 'good-shepherd-catholic-radio' ),
			'button_remove_text' => _x( 'Remove Image', 'Home Donate Image Remove Button Text', 'good-shepherd-catholic-radio' ),
			'window_title' => _x( 'Choose Image', 'Home Donate Image Window Title', 'good-shepherd-catholic-radio' ),
			'window_button_text' => _x( 'Use Image', 'Home Donate Image Select Button Text', 'good-shepherd-catholic-radio' ),
			'input_atts' => array(
				'required' => true,
			)
 		)
	);

	rbm_do_field_text(
		'gscr_home_donate_link',
		__( 'Block One Link', 'good-shepherd-catholic-radio' ),
		false,
		array(
			
		)
	);

	rbm_fh_do_field_toggle( array(
		'name' => 'gscr_home_donate_link_new_tab',
		'label' => __( 'Open Block One Link in a New Tab?', 'good-shepherd-catholic-radio' ),
	) );

	echo '<hr />';
	 
	rbm_do_field_text(
		'gscr_home_listen_title',
		__( 'Block Two Title', 'good-shepherd-catholic-radio' ),
		false,
		array(
			'default' => __( 'Listening Options', 'good-shepherd-catholic-radio' ),
			'input_atts' => array(
				'required' => true,
			)
		)
	);
	
	rbm_do_field_wysiwyg(
		'gscr_home_listen_text',
		__( 'Block Two Content', 'good-shepherd-catholic-radio' ),
		false,
		array(
			'wysiwyg_options' => array(
				'mediaButtons' => false,
				'tinymce' => array(
					'content_css' => THEME_URL . 'assets/css/app.css',
					'toolbar1' => 'formatselect,bold,italic,bullist,numlist,blockquote,alignleft,aligncenter,alignright,link,wp_more,wp_adv',
					'toolbar2' => 'strikethrough,hr,forecolor,pastetext,removeformat,charmap,outdent,indent,undo,redo,wp_help',
				),
			)
		)
	);
	
	rbm_do_field_media(
 		'gscr_home_listen_image',
 		__( 'Block Two Background Image', 'good-shepherd-catholic-radio' ),
 		false,
 		array(
			'type' => 'image',
			'button_text' => _x( 'Upload/Choose Image', 'Home Listen Image Upload Button Text', 'good-shepherd-catholic-radio' ),
			'button_remove_text' => _x( 'Remove Image', 'Home Listen Image Remove Button Text', 'good-shepherd-catholic-radio' ),
			'window_title' => _x( 'Choose Image', 'Home Listen Image Window Title', 'good-shepherd-catholic-radio' ),
			'window_button_text' => _x( 'Use Image', 'Home Listen Image Select Button Text', 'good-shepherd-catholic-radio' ),
			'input_atts' => array(
				'required' => true,
			)
 		)
	 );
	 
	 rbm_do_field_text(
		'gscr_home_listen_link',
		__( 'Block Two Link', 'good-shepherd-catholic-radio' ),
		false,
		array(

		)
	 );

	 rbm_fh_do_field_toggle( array(
		'name' => 'gscr_home_listen_link_new_tab',
		'label' => __( 'Open Block Two Link in a New Tab?', 'good-shepherd-catholic-radio' ),
	) );
    
}

/**
 * Put fields in the Prayer Requests Metabox
 * 
 * @since       1.0.0
 * @return      void
 */
function gscr_home_prayer_requests_metabox_content() {
    
    $gravity_forms = wp_list_pluck( RGFormsModel::get_forms( null, 'title' ), 'title', 'id' );
	
	rbm_do_field_media(
        'gscr_home_prayer_request_left_image',
        _x( 'Left-side Image', 'Home Prayer Requests Left Side Image Label', 'good-shepherd-catholic-radio' ),
        false,
        array(
			'description' => _x( 'This will optionally show on the left-hand side', 'Home Prayer Requests Left Side Image Description', 'good-shepherd-catholic-radio' ),
            'type' => 'image',
            'button_text' => _x( 'Upload/Choose Image', 'Prayer Requests Image Upload Button Text', 'good-shepherd-catholic-radio' ),
            'button_remove_text' => _x( 'Remove Image', 'Prayer Requests Image Remove Button Text', 'good-shepherd-catholic-radio' ),
            'window_title' => _x( 'Choose Image', 'Prayer Requests Image Window Title', 'good-shepherd-catholic-radio' ),
            'window_button_text' => _x( 'Use Image', 'Prayer Requests Image Select Button Text', 'good-shepherd-catholic-radio' ),
        )
    );
	
	rbm_do_field_wysiwyg(
		'gscr_home_prayer_request_text',
		_x( 'Prayer Request Content', 'Home Prayer Request Text Label', 'good-shepherd-catholic-radio' ),
		false,
		array(
		)
	);
	
	rbm_do_field_select(
        'gscr_home_prayer_request_form',
        _x( 'Prayer Requests Form', 'Home Prayer Requests Form Label', 'good-shepherd-catholic-radio' ),
        false,
        array(
            'description' => __( 'Choose the Gravity Form through which Visitors will submit Prayer Requests.', 'good-shepherd-catholic-radio' ),
            'options' => $gravity_forms,
        )
    );
	
	rbm_do_field_select(
		'gscr_home_prayer_request_background',
		_x( 'Prayer Requests Background Color', 'Home Prayer Requests Background Color Label', 'good-shepherd-catholic-radio' ),
		false,
		array(
			'default' => 'primary',
			'options' => array(
				'' => __( 'White', 'good-shepherd-catholic-radio' ),
				'primary' => _x( 'Purple', 'Primary Theme Color', 'good-shepherd-catholic-radio' ),
				'secondary' => _x( 'Green', 'Secondary Theme Color', 'good-shepherd-catholic-radio' ),
				'tertiary' => _x( 'Blue', 'Tertiary Theme Color', 'good-shepherd-catholic-radio' ),
				'quaternary' => _x( 'Gold', 'Quaternary Theme Color', 'good-shepherd-catholic-radio' ),
				'quinary' => _x( 'Rose', 'Quinary Theme Color', 'good-shepherd-catholic-radio' ),
            ),
		)
	);
	
	rbm_do_field_select(
		'gscr_home_prayer_request_button_color',
		_x( 'Prayer Requests Button Color', 'Home Prayer Requests Button Color Label', 'good-shepherd-catholic-radio' ),
		false,
		array(
			'description' => __( 'This changes the color of the button on the right-hand side of the section', 'good-shepherd-catholic-radio' ),
			'default' => 'secondary',
			'options' => array(
				'primary' => _x( 'Purple', 'Primary Theme Color', 'good-shepherd-catholic-radio' ),
				'secondary' => _x( 'Green', 'Secondary Theme Color', 'good-shepherd-catholic-radio' ),
				'tertiary' => _x( 'Blue', 'Tertiary Theme Color', 'good-shepherd-catholic-radio' ),
				'quaternary' => _x( 'Gold', 'Quaternary Theme Color', 'good-shepherd-catholic-radio' ),
				'quinary' => _x( 'Rose', 'Quinary Theme Color', 'good-shepherd-catholic-radio' ),
            ),
		)
	);
	
	rbm_do_field_media(
        'gscr_home_prayer_request_image',
        _x( 'Background Image', 'Home Prayer Requests Background Image Label', 'good-shepherd-catholic-radio' ),
        false,
        array(
            'type' => 'image',
            'button_text' => _x( 'Upload/Choose Image', 'Prayer Requests Image Upload Button Text', 'good-shepherd-catholic-radio' ),
            'button_remove_text' => _x( 'Remove Image', 'Prayer Requests Image Remove Button Text', 'good-shepherd-catholic-radio' ),
            'window_title' => _x( 'Choose Image', 'Prayer Requests Image Window Title', 'good-shepherd-catholic-radio' ),
            'window_button_text' => _x( 'Use Image', 'Prayer Requests Image Select Button Text', 'good-shepherd-catholic-radio' ),
        )
    );
    
}