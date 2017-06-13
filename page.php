<?php
/**
 * The theme's page file use for displaying pages.
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

the_post();
?>

<div class="row expanded">

    <article id="page-<?php the_ID(); ?>" <?php post_class( array( 
        'columns',
        'small-12',
        'no-sidebar',
    ) ); ?>>

        <h1 class="page-title">
            <?php the_title(); ?>
        </h1>

        <?php the_content(); ?>

    </article>
    
</div>

<?php
get_footer();