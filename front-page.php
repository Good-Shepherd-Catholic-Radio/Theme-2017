<?php
/**
 * Displays the home page
 *
 * @since   1.0.0
 * @package Good_Shepherd_Catholic_Radio
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Load any post-type specific hooks, if they exist
locate_template( '/includes/hooks/front_page-hooks.php', true, true );

get_header();

the_post();

include locate_template( 'partials/home/radio-shows_header.php' );

include locate_template( 'partials/home/events.php' );

include locate_template( 'partials/home/blog.php' );

var_dump( date( 'Y-m-d', strtotime( 'last Sunday', strtotime( current_time( 'Y-m-d' ) ) ) ) );
var_dump( date( 'Y-m-d', strtotime( 'next Saturday', strtotime( current_time( 'Y-m-d' ) ) ) ) );

get_footer();