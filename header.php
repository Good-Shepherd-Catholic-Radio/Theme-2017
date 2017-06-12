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

            <div class="off-canvas position-left nav-menu" id="offCanvasLeft" data-off-canvas>

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
						
						<div class="top-bar-left social">
							
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

                    <div class="top-bar">

                        <div class="top-bar-left top-bar-title">
                            
                            <div class="show-for-small-only menu-icon-container" data-responsive-toggle="responsive-menu" data-hide-for="medium">
                                <button type="button" data-open="offCanvasLeft">
                                    <span class="menu-icon"></span>
                                    <div class="menu-icon-text">
                                        <?php echo _x( 'Menu', 'Hamburger Button Label', 'good-shepherd-catholic-radio' ); ?>
                                    </div>
                                </button>
                            </div>
                            
                            <a href="<?php bloginfo( 'url' ); ?>" title="<?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?>">
                            <?php 
                                echo wp_get_attachment_image( get_theme_mod( 'gscr_logo_image', 1 ), 'medium', false, array(
                                    'title' => get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' ),
                                    'alt' => get_bloginfo( 'name' ) . ' - ' . get_bloginfo( 'description' ),
                                ) ); 
                            ?>
                           </a>

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

                    </div>

                </header>

                <section id="site-content">
                    
                    <?php if ( ! is_front_page() ) : ?>
                    
                        <div class="row expanded">
                            <div class="small-12 columns">
                                <?php gscr_custom_breadcrumbs(); ?>
                            </div>
                        </div>
                    
                    <?php endif; ?>