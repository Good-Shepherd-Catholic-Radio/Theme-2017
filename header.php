<?php
/**
 * The theme's header file that appears on EVERY page.
 *
 * @since   0.1.0
 * @package Good_Shepherd_Catholic_Radio
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width">

        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

        <!--[if lt IE 9]>
            <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/vendor/js/html5.js"></script>
        <![endif]-->

        <?php wp_head(); ?>

    </head>

    <body <?php body_class( 'off-canvas-wrapper' ); ?>>

        <div id="wrapper" class = "off-canvass-wrapper-inner" data-off-canvas-wrapper>

            <div class="off-canvas position-right nav-menu" id="offCanvasRight" data-off-canvas>

                <?php
                wp_nav_menu( array(
                    'container' => false,
                    'menu' => __( 'Primary Menu', 'good-shepherd-catholic-radio' ),
                    'menu_class' => 'menu',
                    'theme_location' => 'primary',
                    'items_wrap' => '<ul id="%1$s" class="vertical %2$s">%3$s</ul>',
                    'fallback_cb' => false,
                    'walker' => new Foundation_Nav_Walker(),
                ) );
                ?>

            </div>

            <div class="off-canvas-content" data-off-canvas-content>

                <header id="site-header">
					
					<div id="header-logo-container" class="top-bar extra" data-equalizer data-equalize-on="medium">
						
						<div class="top-bar-left logo" data-equalizer-watch>
							
							<div class="vertical-align">
							
								<a href="<?php bloginfo( 'url' ); ?>" title="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
								<?php 
									
									$header_logo_id = get_theme_mod( 'gscr_logo_image', 1 );
									
									if ( get_post_mime_type( $header_logo_id ) == 'image/svg+xml' ) {
                                        echo file_get_contents( get_attached_file( $header_logo_id ) );
                                    }
                                    else {
                                        echo wp_get_attachment_image( $header_log_id, 'medium', false, array(
											'title' => get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' ),
											'alt' => get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' ),
										) ); 
                                    }
									
								?>
							   </a>
								
							</div>
							
						</div>
						
						<div class="top-bar-right social" data-equalizer-watch>
							
							<div class="vertical-align">
							
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
											<span class="fa fa-2x fa-<?php echo $social['icon']; ?>"></span>
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
						
						<div class="top-bar-right phone" data-equalizer-watch>
							
							<div class="vertical-align">
							
								<?php echo gscr_get_phone_number_link( get_theme_mod( 'gscr_phone_number', '1-517-513-3340' ), false, '', true ); ?>
								
							</div>
							
						</div>
						
					</div>
					
					<div id="sticky-anchor">
						<?php // This allows the Sticky Menu Bar to only become stuck once it hits the top of the screen ?>
					</div>

                    <div data-sticky-container style="z-index: 999 !important;">
						
						<div class="top-bar sticky" data-sticky data-stick-to="top" data-sticky-on="small" data-top-anchor="sticky-anchor"<?php echo ( is_admin_bar_showing() ) ? ' data-margin-top="2"' : ' data-margin-top="0"'; ?>>

							<div class="top-bar-left top-bar-title">
								
								<div class="top-bar-logo show-for-medium">
									<a href="<?php bloginfo( 'url' ); ?>" title="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
									<?php 

										$header_logo_id = get_theme_mod( 'gscr_logo_image', 1 );

										if ( get_post_mime_type( $header_logo_id ) == 'image/svg+xml' ) {
											echo file_get_contents( get_attached_file( $header_logo_id ) );
										}
										else {
											echo wp_get_attachment_image( $header_log_id, 'medium', false, array(
												'title' => get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' ),
												'alt' => get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' ),
											) ); 
										}

									?>
								   </a>
								</div>
								
								<div class="top-bar-logo show-for-small-only">
									<a href="<?php bloginfo( 'url' ); ?>" title="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
									<?php 

										$header_logo_id = get_theme_mod( 'gscr_logo_image_scroll', 1 );

										if ( get_post_mime_type( $header_logo_id ) == 'image/svg+xml' ) {
											echo file_get_contents( get_attached_file( $header_logo_id ) );
										}
										else {
											echo wp_get_attachment_image( $header_log_id, 'medium', false, array(
												'title' => get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' ),
												'alt' => get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' ),
											) ); 
										}

									?>
								   </a>
								</div>

								<div class="stream-container">

									<div id="gscr-radio-stream-header" class="jp-jplayer"></div>
									<div id="jp_container_1" class="jp-audio-stream hide-for-print" role="application" aria-label="media player">
										<div class="jp-type-single">

											<div class="jp-gui jp-interface row small-collapse large-uncollapse expanded">

												<div class="small-12 columns">

													<div class="row">

														<div class="jp-controls small-1 columns">
															<button class="jp-play" role="button" tabindex="0">
																<span class="fa fa-2x play-icon"></span>
															</button>
														</div>

														<div class="title-container jp-details text-center hide-for-small-only large-4 large-pull-1 columns">
															<div class="jp-title" aria-label="title">
																<?php _e( 'Listen Live!', 'good-shepherd-catholic-radio' ); ?>
															</div>
														</div>

														<div class="jp-volume-controls small-2 small-pull-9 medium-5 medium-pull-6 large-5 large-pull-3 columns">

															<div class="row expanded small-collapse">

																<div class="small-3 medium-2 large-2 large-offset-1 columns">

																	<button class="jp-mute" role="button" tabindex="0">
																		<span class="fa fa-2x mute-icon"></span>
																	</button>

																</div>

																<div class="volume-bar-container small-5 columns">

																	<div class="jp-volume-bar">
																		<div class="jp-volume-bar-value"></div>
																	</div>

																</div>

																<div class="small-2 small-pull-1 medium-2 medium-pull-2 large-pull-1 columns">

																	<button class="jp-volume-max" role="button" tabindex="0">
																		<span class="fa fa-2x volume-max-icon"></span>
																	</button>

																</div>

															</div>

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

							</div>

							<div class="top-bar-right hide-for-small-only nav-menu">
								
								<?php
								wp_nav_menu( array(
									'container' => false,
									'menu' => __( 'Primary Menu', 'good-shepherd-catholic-radio' ),
									'menu_class' => 'dropdown menu',
									'theme_location' => 'primary',
									'items_wrap' => '<ul id="%1$s" class="%2$s" data-dropdown-menu>%3$s</ul>',
									'fallback_cb' => false,
									'walker' => new Foundation_Nav_Walker(),
								) );
								?>
								
							</div>
								
							<div class="top-bar-right show-for-small-only menu-icon-container" data-responsive-toggle="responsive-menu" data-hide-for="medium">
								<button type="button" data-open="offCanvasRight">
									<span class="menu-icon"></span>
								</button>
							</div>

						</div>

                    </div>

                </header>

                <section id="site-content">
					
					<?php if ( ! is_front_page() &&
						 has_post_thumbnail() ) : ?>
					
							<?php if ( ( is_single() && get_post_type() == 'post' ) ||
									 get_post_type() == 'page' ) : ?>

									<div class="row expanded small-collapse featured-image-container">

										<?php
											$attachment_id = get_post_thumbnail_id( get_the_ID() );
											$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
										?>

										<div class="image" style="background-image: url('<?php echo $image_url; ?>');"></div>

									</div>

							<?php endif; ?>

					<?php endif; ?>
                    
                    <?php if ( ! is_front_page() ) : ?>
                    
                        <div class="row breadcrumbs-container">
                            <div class="small-12 columns">
                                <?php gscr_custom_breadcrumbs(); ?>
                            </div>
                        </div>
                    
                    <?php endif; ?>