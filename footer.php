<?php
/**
 * The theme's footer file that appears on EVERY page.
 * 
 * @since 1.0.0
 * @package Good_Shepherd_Catholic_Radio
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}
?>

</section><!-- #site-content -->

<footer id="site-footer">
    
    <div class="row">
    
        <?php 

        $footer_sidebars = array(
            'footer-left',
            'footer-center',
            'footer-right',
        ); 

        foreach ( $footer_sidebars as $sidebar ) : ?>

            <div class="small-12 medium-4 columns">

                <?php dynamic_sidebar( $sidebar ); ?>

            </div>

        <?php endforeach; ?>
        
    </div>
    
    <div class="row">
        <div class="small-12 columns text-center">
            <?php echo sprintf( _x( 'Site by %s', 'Site By Footer Text', 'good-shepherd-catholic-radio' ), '<a href="//realbigmarketing.com/" target="_blank">Real Big Marketing</a>' ); ?>
            <br />
            <?php echo sprintf( _x( 'Copyright &copy; %s %s', 'Copyright Footer Text', 'good-shepherd-catholic-radio' ), date( 'Y' ), get_bloginfo( 'name' ) ); ?>
        </div>
    </div>

</footer>

</div><!-- .off-canvas-content -->

</div><!-- #wrapper -->

<?php wp_footer(); ?>

</body>

</html>