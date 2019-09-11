<?php
/**
 * The theme's functions file that loads on EVERY page, used for uniform functionality.
 *
 * @since   1.0.0
 * @package Good_Shepherd_Catholic_Radio
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Make sure PHP version is correct
if ( ! version_compare( PHP_VERSION, '5.3.0', '>=' ) ) {
	wp_die( 'ERROR in Good Shepherd Catholic Radio - Theme 2017 theme: PHP version 5.3 or greater is required.' );
}

// Make sure no theme constants are already defined (realistically, there should be no conflicts)
if ( defined( 'THEME_VER' ) ||
	defined( 'THEME_URL' ) ||
	defined( 'THEME_DIR' ) ||
	defined( 'THEME_FILE' ) ||
	isset( $theme_fonts ) ) {
	wp_die( 'ERROR in Good Shepherd Catholic Radio - Theme 2017 theme: There is a conflicting constant. Please either find the conflict or rename the constant.' );
}

/**
 * Define Constants based on our Stylesheet Header. Update things only once!
 */
$theme_header = wp_get_theme();

define( 'THEME_VER', $theme_header->get( 'Version' ) );
define( 'THEME_URL', get_template_directory_uri() );
define( 'THEME_DIR', get_template_directory() );

/**
 * Fonts for the theme. Must be hosted font (Google fonts for example).
 */
$theme_fonts = array(
	'poppins' => '//fonts.googleapis.com/css?family=Poppins:400,700',
	'open-sans' => '//fonts.googleapis.com/css?family=Open+Sans:300italic,700,300,800',
	'font-awesome' => '//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css',
);

/**
 * Register theme files.
 *
 * @since 1.0.0
 */
add_action( 'init', function () {

	global $theme_fonts;

	// Theme styles
	wp_register_style(
		'good-shepherd-catholic-radio',
		THEME_URL . '/assets/css/app.css',
		null,
		defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VER
	);

	// Theme script
	wp_register_script(
		'good-shepherd-catholic-radio',
		THEME_URL . '/assets/js/script.js',
		array( 'jquery' ),
		defined( 'WP_DEBUG' ) && WP_DEBUG ? time() : THEME_VER,
		true
	);

	$communityBase = '';
	if ( class_exists( 'Tribe__Events__Community__Main' ) ) {
		$communityBase = trailingslashit( tribe_get_events_link() . tribe( 'community.main' )->getOption( 'communityRewriteSlug', 'community', true ) );
	}
	
	wp_localize_script(
		'good-shepherd-catholic-radio',
		'goodShepherdCatholicRadio',
		apply_filters( 'good_shepherd_catholic_radio_localize_script', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'siteUrl' => site_url(),
			'baseName' => basename( dirname( __FILE__ ) ),
			'ajaxIgnore' => array( 
				'urlPatterns' => array (
					// The AJAX Refresh will instantly bail if a URL matches these patterns. It will force a normal load
					// This should only be used in cases where you obviously wouldn't want it, like downloading a .ZIP or accessing /wp-admin/
					'#',
					'/wp-',
					'.pdf',
					'.zip',
					'.rar',
				),
				'classes' => array(
					// The AJAX Refresh will instantly bail if a Class on an element matches one from this list. It will force a normal load
					// This can be applied onto buttons where for some reason a URL match would be inappropriate
					'no-ajax',
				),
			),
			'navigationConfirm' => array( // The Navigation Confirmation message is only shown if they are listening to the Radio Stream
				'urlPatterns' => array( // The AJAX Refresh cannot work for anything matching these URL Patterns, so a regular refresh will occur
					// The User will be asked if this is OK before proceeding
					$communityBase
				),
				'classes' => array( // The AJAX Refresh cannot work for elements with a Class on this list. It will force a normal load
					// The User will be asked if this is OK before proceeding
					'no-ajax-confirm',
				),
				'message' => __( 'Are you sure? This will stop playback of the Radio Stream', 'good-shepherd-catholic-radio' ),
			),
		) )
	);

	// Theme fonts
	if ( ! empty( $theme_fonts ) ) {
		foreach ( $theme_fonts as $ID => $link ) {
			wp_register_style(
				'good-shepherd-catholic-radio' . "-font-$ID",
				$link
			);
		}
	}
} );

/**
 * Enqueue theme files.
 *
 * @since 1.0.0
 */
add_action( 'wp_enqueue_scripts', function () {

	global $theme_fonts;

	// Theme styles
	wp_enqueue_style( 'good-shepherd-catholic-radio' );

	// Theme script
	wp_enqueue_script( 'good-shepherd-catholic-radio' );

	// Theme fonts
	if ( ! empty( $theme_fonts ) ) {
		foreach ( $theme_fonts as $ID => $link ) {
			wp_enqueue_style( 'good-shepherd-catholic-radio' . "-font-$ID" );
		}
	}
	
} );

/**
 * Register nav menus.
 *
 * @since 1.0.0
 */
add_action( 'after_setup_theme', function () {
	register_nav_menu( 'primary', 'Primary Menu' );
} );

/**
 * Register sidebars.
 *
 * @since 1.0.0
 */
add_action( 'widgets_init', function () {
    
    // Main Sidebar
    register_sidebar( array(
    	'name' => 'Main Sidebar',
    	'id' => 'sidebar-main',
    	'description' => 'Displays on Interior Pages.',
    ) );
	
	// Footer
    $footer_columns = get_theme_mod( 'gscr_footer_columns', 4 );
    for ( $index = 0; $index < $footer_columns; $index++ ) {
        register_sidebar(
            array(
                'name'          =>  'Footer ' . ( $index + 1 ),
                'id'            =>  'footer-' . ( $index + 1 ),
                'description'   =>  sprintf( __( 'This is Footer Widget Area %d', 'good-shepherd-catholic-radio' ), ( $index + 1 ) ),
                'before_widget' =>  '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  =>  '</aside>',
                'before_title'  =>  '<h3 class="widget-title">',
                'after_title'   =>  '</h3>',
            )
        );
    }
	
	// Affiliates
    register_sidebar( array(
    	'name' => 'Footer Affiliates',
    	'id' => 'footer-affiliates',
    	'description' => 'Displays beneathe the other Footer Widget Areas.',
		'before_widget' =>  '<aside id="%1$s" class="widget small-12 medium-4 columns text-center %2$s" data-equalizer-watch><div class="vertical-align">',
		'after_widget'  =>  '</div></aside>',
    ) );
	
	// To the right of the Copyright in the Footer
    register_sidebar( array(
    	'name' => 'Privacy Policy',
    	'id' => 'copyright-right',
    	'description' => 'Displays to the right of the Copyright in the Footer.',
    ) );
    
} );

/**
 * Setup theme properties and stuff
 * 
 * @since 1.0.0
 * @return void
 */
add_action( 'after_setup_theme', function () {

    // Add theme support
    require_once __DIR__ . '/core/theme-support.php';
	
	// Add theme functions
    require_once __DIR__ . '/includes/theme-functions.php';
	
	// Add Endpoints
	require_once __DIR__ . '/includes/rest-api.php';
	
	// Add Shortcodes
    require_once __DIR__ . '/includes/shortcodes/gscr-button.php';
	require_once __DIR__ . '/includes/shortcodes/gscr-phone.php';
	require_once __DIR__ . '/includes/shortcodes/gscr-form-overlay.php';

	require_once __DIR__ . '/includes/shortcodes/gscr-underwriters.php';
	require_once __DIR__ . '/includes/shortcodes/gscr-staff.php';
	require_once __DIR__ . '/includes/shortcodes/gscr-on-air-personalities.php';
	require_once __DIR__ . '/includes/shortcodes/gscr-radio-show-programs.php';
	
	// Add Customer Controls
	require_once __DIR__ . '/includes/customizer.php';
	
	// Nav Walker for Foundation
    require_once __DIR__ . '/includes/class-foundation-nav-walker.php';

    // Allow shortcodes in text widget
    add_filter( 'widget_text', 'do_shortcode' );

} );

if ( ! function_exists( 'remove_class_filter' ) ) {

	/**
	 * Remove Class Filter Without Access to Class Object
	 *
	 * In order to use the core WordPress remove_filter() on a filter added with the callback
	 * to a class, you either have to have access to that class object, or it has to be a call
	 * to a static method.  This method allows you to remove filters with a callback to a class
	 * you don't have access to.
	 *
	 * Works with WordPress 1.2+ (4.7+ support added 9-19-2016)
	 *
	 * @param		string $tag         Filter to remove
	 * @param		string $class_name  Class name for the filter's callback
	 * @param		string $method_name Method name for the filter's callback
	 * @param		int    $priority    Priority of the filter (default 10)
	 *
	 * @since		1.0.0
	 * @return		bool 				Whether the function is removed.
	 */
	function remove_class_filter( $tag, $class_name = '', $method_name = '', $priority = 10 ) {
		global $wp_filter;

		// Check that filter actually exists first
		if ( ! isset( $wp_filter[ $tag ] ) ) return FALSE;

		/**
		 * If filter config is an object, means we're using WordPress 4.7+ and the config is no longer
		 * a simple array, rather it is an object that implements the ArrayAccess interface.
		 *
		 * To be backwards compatible, we set $callbacks equal to the correct array as a reference (so $wp_filter is updated)
		 *
		 * @see https://make.wordpress.org/core/2016/09/08/wp_hook-next-generation-actions-and-filters/
		 */
		if ( is_object( $wp_filter[ $tag ] ) && isset( $wp_filter[ $tag ]->callbacks ) ) {
			$callbacks = &$wp_filter[ $tag ]->callbacks;
		} else {
			$callbacks = &$wp_filter[ $tag ];
		}

		// Exit if there aren't any callbacks for specified priority
		if ( ! isset( $callbacks[ $priority ] ) || empty( $callbacks[ $priority ] ) ) return FALSE;

		// Loop through each filter for the specified priority, looking for our class & method
		foreach( (array) $callbacks[ $priority ] as $filter_id => $filter ) {
			
			if ( is_string( $filter['function'][ 0 ] ) ) { // Support Static Methods
				$filter[ 'function' ][ 0 ] = strtok( $filter[ 'function' ][ 0 ], ':' );
			}
			else if ( ! is_object( $filter[ 'function' ][ 0 ] ) ) {
				// If first value in array is not an object, it can't be a class
				continue;
			}

			// Method doesn't match the one we're looking for, goto next
			if ( $filter[ 'function' ][ 1 ] !== $method_name ) continue;

			// Method matched, now let's check the Class
			if ( $filter[ 'function'][ 0 ] == $class_name || 
				get_class( $filter[ 'function' ][ 0 ] ) === $class_name ) {

				// Now let's remove it from the array
				unset( $callbacks[ $priority ][ $filter_id ] );

				// and if it was the only filter in that priority, unset that priority
				if ( empty( $callbacks[ $priority ] ) ) unset( $callbacks[ $priority ] );

				// and if the only filter for that tag, set the tag to an empty array
				if ( empty( $callbacks ) ) $callbacks = array();

				// If using WordPress older than 4.7
				if ( ! is_object( $wp_filter[ $tag ] ) ) {
					// Remove this filter from merged_filters, which specifies if filters have been sorted
					unset( $GLOBALS[ 'merged_filters' ][ $tag ] );
				}

				return TRUE;
			}
		}

		return FALSE;
	}
	
}

if ( ! function_exists( 'remove_class_action' ) ) {

	/**
	 * Remove Class Action Without Access to Class Object
	 *
	 * In order to use the core WordPress remove_action() on an action added with the callback
	 * to a class, you either have to have access to that class object, or it has to be a call
	 * to a static method.  This method allows you to remove actions with a callback to a class
	 * you don't have access to.
	 *
	 * Works with WordPress 1.2+ (4.7+ support added 9-19-2016)
	 *
	 * @param		string $tag         Action to remove
	 * @param		string $class_name  Class name for the action's callback
	 * @param		string $method_name Method name for the action's callback
	 * @param		int    $priority    Priority of the action (default 10)
	 *
	 * @since		1.0.0
	 * @return		bool			    Whether the function is removed.
	 */
	function remove_class_action( $tag, $class_name = '', $method_name = '', $priority = 10 ) {
		remove_class_filter( $tag, $class_name, $method_name, $priority );
	}
	
}

require_once __DIR__ . '/admin/admin.php';

locate_template( '/includes/hooks/tribe_events-hooks.php', true, true );

/**
 * I still don't know why WP doesn't support this out of the box
 * 
 * @param		array $mimes Supported MIME Types
 *                                     
 * @since		1.0.0
 * @return		array Supported MIME Types
 */
add_filter('upload_mimes', function ( $mimes ) {
	
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
	
} );

/**
 * Add Google Tag Manager Script
 * 
 * @since		1.0.4
 * @return		void
 */
add_action( 'wp_head', function() { ?>
	
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-KX6JZK3');</script>
	<!-- End Google Tag Manager -->

<?php
	
} );

/**
 * Add Google Tag Manager iFrame for if JavaScript is disabled 
 * 
 * @since		1.0.4
 * @return		void
 */
add_action( 'gscr_body_start', function() { ?>
	
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KX6JZK3"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->

<?php
	
} );

add_filter( 'post_type_labels_page', 'gscr_change_featured_image_banner_labels' );
add_filter( 'post_type_labels_post', 'gscr_change_featured_image_banner_labels' );
add_filter( 'post_type_labels_tribe_events', 'gscr_change_featured_image_banner_labels' );

/**
 * Change Featured Image Labels for Posts, Pages, and Events
 * 
 * @param		array $labels Featured Image Labels
 *                                      
 * @since		1.0.6
 * @return		array Featured Image Labels
 */
function gscr_change_featured_image_banner_labels( $labels ) {

	$labels->featured_image = __( 'Banner Image (Recommended 1170 × 400)', 'good-shepherd-catholic-radio' );
	$labels->set_featured_image = __( 'Set Banner Image', 'good-shepherd-catholic-radio' );
	$labels->remove_featured_image = __( 'Remove Banner Image', 'good-shepherd-catholic-radio' );
	$labels->use_featured_image = __( 'Use as Banner Image', 'good-shepherd-catholic-radio' );

	return $labels;

}

add_filter( 'gscr_radio_show_background_image_label', 'gscr_radio_show_background_image_label', 11 );

/**
 * Add Recommended size to the Background Image Label for Radio Shows
 *
 * @param   string  $label  Metabox Label
 *
 * @since	{{VERSION}}
 * @return  string          Metabox Label
 */
function gscr_radio_show_background_image_label( $label ) {

	return $label . ' ' . __( '(Recommended 1170 × 400)', 'good-shepherd-catholic-radio' ) . '<br /><br />' . __( 'This is the default if no Logo or Headshot is added.', 'good-shepherd-catholic-radio' );

}

add_filter( 'gscr_radio_show_headshot_image_label', 'gscr_radio_show_headshot_image_label', 11 );

/**
 * Add Recommended size to the Headshot Image Label for Radio Shows
 *
 * @param   string  $label  Metabox Label
 *
 * @since	{{VERSION}}
 * @return  string          Metabox Label
 */
function gscr_radio_show_headshot_image_label( $label ) {

	return $label . ' ' . __( '(Recommended 400 × 400)', 'good-shepherd-catholic-radio' );

}

add_filter( 'gscr_radio_show_logo_image_label', 'gscr_radio_show_logo_image_label', 11 );

/**
 * Add Recommended size to the Logo Image Label for Radio Shows
 *
 * @param   string  $label  Metabox Label
 *
 * @since	{{VERSION}}
 * @return  string          Metabox Label
 */
function gscr_radio_show_logo_image_label( $label ) {

	return $label . ' ' . __( '(Recommended 400 × 300)', 'good-shepherd-catholic-radio' );

}

add_filter( 'post_type_labels_on-air-personality', 'gscr_change_featured_image_on_air_personality_profile_labels' );

/**
 * Change Featured Image Labels for On-Air Personalities
 * 
 * @param		array $labels Featured Image Labels
 *                                      
 * @since		1.0.7
 * @return		array Featured Image Labels
 */
function gscr_change_featured_image_on_air_personality_profile_labels( $labels ) {

	$labels->featured_image = __( 'Profile Image (Recommended 472 * 472)', 'good-shepherd-catholic-radio' );
	$labels->set_featured_image = __( 'Set Profile Image', 'good-shepherd-catholic-radio' );
	$labels->remove_featured_image = __( 'Remove Profile Image', 'good-shepherd-catholic-radio' );
	$labels->use_featured_image = __( 'Use as Profile Image', 'good-shepherd-catholic-radio' );

	return $labels;

}

add_filter( 'post_type_labels_staff', 'gscr_change_featured_image_staff_profile_labels' );

/**
 * Change Featured Image Labels for Staff
 * 
 * @param		array $labels Featured Image Labels
 *                                      
 * @since		1.0.7
 * @return		array Featured Image Labels
 */
function gscr_change_featured_image_staff_profile_labels( $labels ) {

	$labels->featured_image = __( 'Profile Image (Recommended 500 × 300)', 'good-shepherd-catholic-radio' );
	$labels->set_featured_image = __( 'Set Profile Image', 'good-shepherd-catholic-radio' );
	$labels->remove_featured_image = __( 'Remove Profile Image', 'good-shepherd-catholic-radio' );
	$labels->use_featured_image = __( 'Use as Profile Image', 'good-shepherd-catholic-radio' );

	return $labels;

}

/**
 * Get any special modifications to the Title based on the Broadcast Type
 *
 * @param   integer  $post_id         Post ID (This should be the Parent/Source Radio Show)
 * @param   string   $broadcast_type  Broadcast Type
 *
 * @since	{{VERSION}}
 * @return  string                    Post Title with modifications based on Broadcast Type
 */
function gscr_get_occurrence_title( $post_id, $broadcast_type = '' ) {

	$title = get_the_title( $post_id ); 

	switch ( $broadcast_type ) {
		case 'live' : 
		case 'encore' : 
			$title .= ' (' . gscr_get_broadcast_type_label( $broadcast_type ) . ')';
			break;
		case 'best-of' : 
			$title = gscr_get_broadcast_type_label( $broadcast_type ) . ' ' . $title;
			break;
		default: 
			break;
	}

	return $title;

}

/**
 * Gets a label based on the Broadcast Type
 *
 * @param   string  $broadcast_type  Broadcast Type
 *
 * @since	{{VERSION}}
 * @return  string                   Label
 */
function gscr_get_broadcast_type_label( $broadcast_type ) {

	$labels = apply_filters( 'gscr_broadcast_type_labels', array(
		'live' => __( 'Live', 'good-shepherd-catholic-radio' ),
		'encore' => __( 'Encore', 'good-shepherd-catholic-radio' ),
		'best-of' => __( 'The Best of', 'good-shepherd-catholic-radio' ),
		'pre-recorded' => __( 'Pre-recorded', 'good-shepherd-catholic-radio' ),
	) );

	if ( array_key_exists( $broadcast_type, $labels ) ) {
		return $labels[ $broadcast_type ];
	}

	return '';

}

/*

I have no idea why these Radio Shows did not have their categories
Here's the code in case I need it again

add_action( 'init', function() {
	
	$post_ids = array(
		25640,
		25641,
		25642,
		25643,
		25644,
		25645,
		25646,
		25647,
		25648,
		25649,
		25650,
		25651,
		25652,
		25653,
		25654,
		25655,
		25656,
		25657,
		25658,
		25639,
		25659,
		25660,
		25661,
		25662,
		25663,
		25664,
		25665,
		25666
	);
	
	foreach ( $post_ids as $post_id ) {
		wp_set_post_terms( $post_id, array( 5 ), 'tribe_events_cat', true );
	}
	
} );

*/