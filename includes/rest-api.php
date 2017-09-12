<?php
/**
 * Adds REST API Functionality
 * 
 * @since   1.0.0
 * @package Good_Shepherd_Catholic_Radio
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

add_action( 'rest_api_init', 'gscr_create_routes' );

/**
 * Creates WP REST API routes that Listens for hits from Ghost Inspector for "real" Cron Jobs
 * 
 * @since	  1.0.0
 * @return	  void
 */
function gscr_create_routes() {
	
	register_rest_route( 'gscr/v1', '/cron/increment-daily-offsets', array(
		'methods' => 'GET',
		'callback' => 'gscr_increment_daily_offsets'
	) );
	
}

/**
 * Callback for incrementing daily offsets
 * 
 * @param	  object $request WP_REST_Request Object
 *											  
 * @access	  public
 * @since	  1.0.0
 * @return	  void, calls another function
 */
function gscr_increment_daily_offsets( $request ) {
	
	$key = get_theme_mod( 'gscr_cron_secret', false );
	
	if ( isset( $_GET['key'] ) && 
	   $key && 
	   $key == trim( $_GET['key'] ) ) {
	
		gscr_underwriters_offset_increment();
		gscr_on_air_personalities_offset_increment();

		wp_send_json_success();
		
	}
	
	wp_send_json_error();
	
}