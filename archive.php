<?php
/**
 * Displays latest blog posts.
 *
 * @since   1.0.0
 * @package Good_Shepherd_Catholic_Radio
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Load any post-type specific hooks, if they exist
locate_template( '/includes/hooks/' . get_post_type() . '-hooks.php', true, true );

get_header();

?>

<h1 class="page-title columns small-12">
    <?php the_archive_title(); ?>
</h1>

<?php
the_archive_description( '<div class="taxonomy-description columns small-12">', '</div>' );

get_template_part( 'partials/loop/loop', get_post_type() );

get_footer();