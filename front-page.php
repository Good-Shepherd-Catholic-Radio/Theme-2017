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

do_action( 'gscr_before_content' );

?>

<div class="row expanded small-collapse">
	
	<div class="small-12 medium-8 columns">

		<?php include locate_template( 'partials/home/radio-shows_header.php' ); ?>
		
	</div>
	
	<div class="small-12 medium-4 columns">

		<?php include locate_template( 'partials/home/donate-listen.php' ); ?>
		
	</div>
	
</div>

<?php

include locate_template( 'partials/home/radio-shows-with-on-air-personalities.php' );

include locate_template( 'partials/home/events.php' );

include locate_template( 'partials/home/underwriters.php' );

include locate_template( 'partials/home/prayer-requests.php' );

include locate_template( 'partials/home/blog.php' );

get_footer();