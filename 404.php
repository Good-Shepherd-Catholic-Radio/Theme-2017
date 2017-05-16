<?php
/**
 * The theme's 404 page for showing not found pages.
 *
 * @since 1.0.0
 * @package Good_Shepherd_Catholic_Radio
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

get_header();

the_post();
?>

<div class="row">

    <article id="page-404" class="small-12 <?php echo ( is_active_sidebar( 'sidebar-main' ) ? 'medium-9' : 'no-sidebar' ); ?> columns">

        <h1 class="page-title">
            <?php echo _x( '404 - Not Found', '404 Page Title', 'good-shepherd-catholic-radio' ); ?>
        </h1>

        <p>
            <?php echo _x( "Sorry, but there's nothing here.", '404 Error Message', 'good-shepherd-catholic-radio' ); ?>
        </p>

    </article>
    
    <?php if ( is_active_sidebar( 'sidebar-main' ) ) : ?>
    
        <div class="small-12 medium-3 columns">
            
            <?php dynamic_sidebar( 'sidebar-main' ); ?>
            
        </div>
    
    <?php endif; ?>
    
</div>

<?php
get_footer();