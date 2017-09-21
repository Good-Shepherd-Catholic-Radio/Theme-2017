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

	<div class="footer-widgets">
        
        <div class="row">

            <?php
            $footer_columns = get_theme_mod( 'gscr_footer_columns', 4 );
            for ( $index = 0; $index < $footer_columns; $index++ ) {
                ?>

                    <div class = "small-12 medium-<?php echo ( 12 / $footer_columns ); ?> columns">
                        <?php dynamic_sidebar( 'footer-' . ( $index + 1 ) ); ?>
                    </div>

                <?php
            }
            ?>
            
        </div>

	</div>
	
	<div class="footer-affiliates">
	
		<div class="row" data-equalizer data-equalize-on="medium" data-equalize-by-row="true">

			<?php dynamic_sidebar( 'footer-affiliates' ); ?>

		</div>
		
	</div>
	
	<div class="social">
	
		<div class="row text-center">

			<div class="small-12 columns">

				<?php 
					$social_accounts = array(
						'gscr_facebook' => array( 
							'label' => 'Facebook',
							'icon' => 'facebook-square',
						),
						'gscr_twitter' => array( 
							'label' => 'Twitter',
							'icon' => 'twitter-square',
						),
						'gscr_pinterest' => array( 
							'label' => 'Pinterest',
							'icon' => 'pinterest-square',
						),
						'gscr_linkedin' => array( 
							'label' => 'LinkedIn',
							'icon' => 'linkedin-square',
						),
						'gscr_instagram' => array( 
							'label' => 'Instagram',
							'icon' => 'instagram',
						),
					);

				foreach ( $social_accounts as $key => $social ) :
					if ( get_theme_mod( $key, '' ) !== '' ) : ?>

						<a class="social-icon" href="<?php echo get_theme_mod( $key, '' ); ?>" target="_blank" title="<?php echo sprintf( __( 'Connect with us on %s', 'good-shepherd-catholic-radio' ), $social['label'] ); ?>">
							<span class="fa fa-<?php echo $social['icon']; ?>"></span>
						</a>

					<?php endif;
				endforeach;

				if ( get_theme_mod( 'gscr_rss_show', false ) === true ) : ?>

					<a class="social-icon" href="<?php bloginfo( 'rss2_url' ); ?>" title="<?php _e( 'Get our RSS Feed', 'good-shepherd-catholic-radio' ); ?>">
						<span class="fa fa-rss-square"></span>
					</a>

				<?php endif; ?>

			</div>

		</div>
		
	</div>

	<div class="copyright">
		<div class="row">
			<div class="small-12 medium-5 medium-push-2 columns text-center">
				<?php echo sprintf( _x( 'Site by %s', 'Site By Footer Text', 'good-shepherd-catholic-radio' ), '<a href="//realbigmarketing.com/" target="_blank">Real Big Marketing</a>' ); ?>
				<br />
				<?php echo sprintf( _x( 'Copyright &copy; %s %s', 'Copyright Footer Text', 'good-shepherd-catholic-radio' ), date( 'Y' ), get_bloginfo( 'name' ) ); ?>
			</div>
			<div class="small-12 medium-4 medium-pull-1 columns text-left">
				<?php dynamic_sidebar( 'copyright-right' ); ?>
			</div>
		</div>
	</div>

</footer>

</div><!-- .off-canvas-content -->

</div><!-- #wrapper -->

<?php wp_footer(); ?>

</body>

<div class="ajax-loading text-center" style="display: none;">
	<span class="fa fa-5x fa-spinner fa-pulse"></span>
</div>

</html>