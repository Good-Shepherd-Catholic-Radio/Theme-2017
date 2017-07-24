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
	
	<div class="row footer-affiliates">
		
		<?php dynamic_sidebar( 'footer-affiliates' ); ?>
	
	</div>
	
	<div class="social row text-center">

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

	<div class="row">
		<div class="small-12 columns text-center">
			<?php echo sprintf( _x( 'Site by %s', 'Site By Footer Text', 'good-shepherd-catholic-radio' ), '<a href="//realbigmarketing.com/" target="_blank">Real Big Marketing</a>' ); ?>
			<br />
			<?php echo sprintf( _x( 'Copyright &copy; %s %s', 'Copyright Footer Text', 'good-shepherd-catholic-radio' ), date( 'Y' ), get_bloginfo( 'name' ) ); ?>
		</div>
	</div>

</footer>

<div data-sticky-container class="sticky-stream hide-for-medium" style="z-index: 999 !important;">

	<div id="gscr-radio-stream-footer" class="jp-jplayer"></div>
	<div id="jp_container_1" class="jp-audio-stream sticky" role="application" aria-label="media player" data-sticky data-stick-to="bottom" data-margin-bottom="0" data-sticky-on="small">
		<div class="jp-type-single">

			<div class="jp-gui jp-interface row expanded">

				<div class="jp-controls small-2 medium-1 columns">
					<button class="jp-play" role="button" tabindex="0">
						<span class="fa fa-3x play-icon"></span>
					</button>
				</div>

				<div class="title-container jp-details small-7 medium-8 columns">
					<div class="jp-title" aria-label="title">
						<?php _e( 'Listen Live!', 'good-shepherd-catholic-radio' ); ?>
					</div>
				</div>

				<div class="jp-volume-controls small-2 offset-small-1 medium-2 columns">

					<div class="row expanded small-collapse">

						<div class="small-2 columns">

							<button class="jp-mute" role="button" tabindex="0">
								<span class="fa fa-3x mute-icon"></span>
							</button>

						</div>

						<div class="volume-bar-container small-7 columns">

							<div class="jp-volume-bar">
								<div class="jp-volume-bar-value"></div>
							</div>

						</div>

						<div class="small-2 small-offset-1 columns">

							<button class="jp-volume-max" role="button" tabindex="0">
								<span class="fa fa-3x volume-max-icon"></span>
							</button>

						</div>

					</div>

				</div>

			</div>

			<div class="jp-no-solution">
				<span><?php _e( 'Update Required', 'good-shepherd-catholic-radio' ); ?></span>
				<?php _e( 'To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.', 'good-shepherd-catholic-radio' ); ?>
			</div>
		</div>
	</div>

</div>

</div><!-- .off-canvas-content -->

</div><!-- #wrapper -->

<?php wp_footer(); ?>

</body>

<div class="ajax-loading text-center" style="display: none;">
	<span class="fa fa-5x fa-spinner fa-pulse"></span>
</div>

</html>