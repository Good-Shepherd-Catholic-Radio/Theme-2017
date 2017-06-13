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
		THEME_URL . '/style.css',
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
	
	wp_localize_script(
		'good-shepherd-catholic-radio',
		'goodShepherdCatholicRadio',
		apply_filters( 'good_shepherd_catholic_radio_localize_script', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'siteUrl' => site_url(),
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
	
	// Add Shortcodes
    require_once __DIR__ . '/includes/shortcodes/gscr-button.php';
	require_once __DIR__ . '/includes/shortcodes/gscr-underwriters.php';
	require_once __DIR__ . '/includes/shortcodes/gscr-staff.php';
	require_once __DIR__ . '/includes/shortcodes/gscr-on-air-personalities.php';
	
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

			// Filter should always be an array - array( $this, 'method' ), if not goto next
			if ( ! isset( $filter[ 'function' ] ) || ! is_array( $filter[ 'function' ] ) ) continue;

			// If first value in array is not an object, it can't be a class
			if ( ! is_object( $filter[ 'function' ][ 0 ] ) ) continue;

			// Method doesn't match the one we're looking for, goto next
			if ( $filter[ 'function' ][ 1 ] !== $method_name ) continue;

			// Method matched, now let's check the Class
			if ( get_class( $filter[ 'function' ][ 0 ] ) === $class_name ) {

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