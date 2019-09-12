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
	
	<?php 
	
		// Events Calendar is such garbage
		wp_reset_postdata();
	
		global $wp_query;
	
		$body_class = array( 'off-canvas-wrapper' );
	
		if ( get_post_type() == 'tribe_events' && 
			$post->post_parent !== 0 ) {
			$post_id = $post->post_parent;
		}
		else {
			$post_id = get_the_ID();
		}
	
		global $has_featured_image;
		$has_featured_image = false;
		if ( get_post_type() == 'radio-show' && rbm_cpts_get_field( 'radio_show_background_image' ) ) {
			$body_class[] = 'has-featured-image';
			$has_featured_image = true;
		}
		if ( ! is_front_page() && has_post_thumbnail() && get_post_type() !== 'tribe_events' || 
			 get_post_type() == 'tribe_events' && is_single() && has_post_thumbnail( $post_id ) ) {
			$body_class[] = 'has-featured-image';
			$has_featured_image = true;
		}
	
		$body_class = apply_filters( 'gscr_body_class', $body_class, $post_id );
	
	?>

    <body <?php body_class( $body_class ); ?>>
		
		<?php do_action( 'gscr_body_start' ); // For Google Tag Manager ?>

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
					
					<div class="top-bar extra">
						
						<div class="top-bar-right social">
							
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
						
						<div class="top-bar-right phone">
							
							<?php echo gscr_get_phone_number_link( get_theme_mod( 'gscr_phone_number', '1-517-513-3340' ), false, '', true ); ?>
							
						</div>
						
					</div>
					
					<div id="sticky-anchor">
						<?php // This allows the Sticky Menu Bar to only become stuck once it hits the top of the screen ?>
					</div>

                    <div data-sticky-container style="z-index: 999 !important;">
						
						<div class="top-bar sticky" data-sticky data-stick-to="top" data-sticky-on="small" data-top-anchor="sticky-anchor"<?php echo ( is_admin_bar_showing() ) ? ' data-margin-top="2"' : ' data-margin-top="0"'; ?>>

							<div class="top-bar-left top-bar-title">
								
								<div class="top-bar-logo">
							
									<a href="<?php bloginfo( 'url' ); ?>" title="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
									<?php 

										$header_logo_id = get_theme_mod( 'gscr_logo_image', 1 );

										if ( get_post_mime_type( $header_logo_id ) == 'image/svg+xml' ) {
											echo file_get_contents( get_attached_file( $header_logo_id ) );
										}
										else {
											echo wp_get_attachment_image( $header_logo_id, 'medium', false, array(
												'title' => get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' ),
												'alt' => get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' ),
											) ); 
										}

									?>
								   </a>

								</div>
								
								<div class="top-bar-logo on-scroll">
									<a href="<?php bloginfo( 'url' ); ?>" title="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
									<?php 

										$header_logo_id = get_theme_mod( 'gscr_logo_image_scroll', 1 );

										if ( get_post_mime_type( $header_logo_id ) == 'image/svg+xml' ) {
											echo file_get_contents( get_attached_file( $header_logo_id ) );
										}
										else {
											echo wp_get_attachment_image( $header_logo_id, 'medium', false, array(
												'title' => get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' ),
												'alt' => get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' ),
											) ); 
										}

									?>
								   </a>
								</div>
								
								<div class="radio-stations-header">
									<?php _e( '93.3 FM', 'good-shepherd-catholic-radio' ); ?> <br />
									<?php _e( '1510 AM', 'good-shepherd-catholic-radio' ); ?>
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

														<div class="title-container jp-details text-center hide-for-small-only medium-4 medium-pull-1 columns">
															<div class="jp-title" aria-label="title">
																<?php _e( 'Listen Live!', 'good-shepherd-catholic-radio' ); ?>
															</div>
														</div>

														<div class="jp-volume-controls small-2 small-pull-9 medium-5 medium-pull-3 large-5 large-pull-3 columns">

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
					
					<?php if ( $has_featured_image ) : ?>
					
							<?php if ( ( is_single() && get_post_type() == 'post' ) ||
									 get_post_type() == 'page' || 
									 get_post_type() == 'radio-show' || 
									 ( get_post_type() == 'tribe_events' && ! $wp_query->get( 'gscr_radio_show_search' ) ) ) : ?>

									<div class="row expanded small-collapse featured-image-container">

										<?php

											$background_color = false;
										
											if ( is_archive() && get_post_type() == 'tribe_events' ) {
												$attachment_id = rbm_get_field( 'gscr_home_events_image', get_option( 'page_on_front' ) );
												$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
											}
											else if ( get_post_type() == 'radio-show' ) {

												$attachment_id = rbm_cpts_get_field( 'radio_show_background_image' );
												$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
												$background_color = rbm_cpts_get_field( 'radio_show_background_image_color' );

											}
											else {
												$attachment_id = get_post_thumbnail_id( get_the_ID() );
												$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
											}
										
										?>

										<div class="image<?php echo ( get_post_type() == 'radio-show' && ( $image_url || ( ( ! has_post_thumbnail() && ! rbm_cpts_get_field( 'radio_show_headshot_image' ) ) ) ) ? ' has-image-url' : '' ); ?>" style="background-image: url('<?php echo $image_url; ?>');<?php echo ( $background_color ) ? ' background-color: ' . $background_color . ';': ''; ?>"></div>

										<?php if ( get_post_type() == 'radio-show' ) : 

											if ( $attachment_id = rbm_cpts_get_field( 'radio_show_headshot_image' ) ) : 

												echo wp_get_attachment_image( $attachment_id, 'full', false, array(
													'class' => 'attachment-full size-full wp-post-image radio-show-headshot',
												) );

											endif;

											if ( has_post_thumbnail() ) : // Logo

												the_post_thumbnail( 'full', array(
													'class' => 'attachment-full size-full wp-post-image radio-show-logo' . ( ( $attachment_id ) ? ' hide-for-small-only' : ' no-headshot' ),
												) );

											endif;

										endif; ?>

									</div>
					
							<?php elseif ( $wp_query->get( 'gscr_radio_show_search' ) ) : ?>
					
									<div class="row expanded small-collapse featured-image-container">
					
										<?php
										
										$attachment_id = get_post_thumbnail_id( $wp_query->posts[0]->ID );
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