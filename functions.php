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
	wp_die( 'ERROR in Love From Louie - Theme 2017 theme: PHP version 5.3 or greater is required.' );
}

// Make sure no theme constants are already defined (realistically, there should be no conflicts)
if ( defined( 'THEME_VER' ) ||
	defined( 'THEME_URL' ) ||
	defined( 'THEME_DIR' ) ||
	defined( 'THEME_FILE' ) ||
	isset( $theme_fonts ) ) {
	wp_die( 'ERROR in Love From Louie - Theme 2017 theme: There is a conflicting constant. Please either find the conflict or rename the constant.' );
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
	
	// Add Button Shortcode
    require_once __DIR__ . '/includes/shortcodes/gscr-button.php';
	
	// Nav Walker for Foundation
    require_once __DIR__ . '/includes/class-foundation-nav-walker.php';

    // Allow shortcodes in text widget
    add_filter( 'widget_text', 'do_shortcode' );

} );

require_once __DIR__ . '/admin/admin.php';