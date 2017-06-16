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

include locate_template( 'partials/home/donate-listen.php' );

include locate_template( 'partials/home/events.php' );

include locate_template( 'partials/home/prayer-requests.php' );

include locate_template( 'partials/home/underwriters.php' );

include locate_template( 'partials/home/blog.php' );

include locate_template( 'partials/home/staff.php' );

include locate_template( 'partials/home/on-air-personalities.php' );

get_footer();