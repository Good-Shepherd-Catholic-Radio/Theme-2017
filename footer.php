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

<div data-sticky-container>

	<div id="gscr-radio-stream" class="jp-jplayer"></div>
	<div id="jp_container_1" class="jp-audio-stream sticky" role="application" aria-label="media player" data-sticky data-stick-to="bottom" data-margin-bottom="0" data-sticky-on="small">
		<div class="jp-type-single">

			<div class="jp-gui jp-interface row expanded">

				<div class="jp-controls small-2 medium-1 columns">
					<button class="jp-play" role="button" tabindex="0">
						<span class="fa fa-3x play-icon"></span>
					</button>
				</div>

				<div class="title-container jp-details small-7 medium-8 columns">
					<div class="jp-title" aria-label="title">Now Playing: (Not able to pull Track Information...yet)</div>
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
				<span>Update Required</span>
				To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
			</div>
		</div>
	</div>
	
</div>

</div><!-- .off-canvas-content -->

</div><!-- #wrapper -->

<?php wp_footer(); ?>

</body>

</html>