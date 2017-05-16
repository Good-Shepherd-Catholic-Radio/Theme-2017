<?php
/**
 * Displays archive of posts.
 *
 * @since   1.0.0
 * @package Good_Shepherd_Catholic_Radio
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

get_header();

?>

<h1 class="page-title columns small-12">
    <?php echo _x( 'Blog', 'Blog Header', 'good-shepherd-catholic-radio' ); ?>
</h1>

<?php

get_template_part( 'partials/loop/loop', get_post_type() );

get_footer();