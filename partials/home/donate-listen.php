<?php
/**
 * Donate/Listen section on the Home Page
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/home
 */

defined( 'ABSPATH' ) || die();

?>

<div class="donate-listen row expanded small-collapse">
	
	<div class="small-12 columns">
		
		<div class="row small-collapse">
	
			<div class="small-12 columns">
				
				<div class="donate">
					
					<?php
				
					$attachment_id = rbm_get_field( 'gscr_home_donate_image' );
					$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );

					?>

					<div class="image" style="background-image: url('<?php echo $image_url ?>');"></div>
					
					<div class="content row">
						
						<div class="small-12 columns">
				
							<h3><?php printf( __( 'Support %s', 'good-shepherd-catholic-radio' ), get_bloginfo( 'name' ) ); ?></h3>

							<?php if ( $give_form = rbm_get_field( 'gscr_home_donate_form' ) ) : ?>
							
								<div class="button-container">

									<a data-open="gscr_donate_modal" class="secondary button">
										<?php _e( 'Donate Now', 'good-shepherd-catholic-radio' ); ?>
									</a>
									
								</div>

								<div class="reveal" id="gscr_donate_modal" data-reveal>

									<?php echo do_shortcode( '[give_form id="' . $give_form . '" show_title="true" show_goal="false" show_content="none"]' ); ?>

									<button class="close-button" data-close aria-label="<?php _e( 'Close modal', 'good-shepherd-catholic-radio' ); ?>" type="button">
										<span aria-hidden="true">&times;</span>
									</button>

								</div>

							<?php else : ?>

								<?php echo _x( 'Please select a Donation Form on the Edit Screen for this page', 'No Donation Form set', 'good-shepherd-catholic-radio' ); ?>

							<?php endif; ?>
							
						</div>
						
					</div>
					
				</div>
				
				<div class="listen">
					
					<?php

					$attachment_id = rbm_get_field( 'gscr_home_listen_image' );
					$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );

					?>

					<div class="image" style="background-image: url('<?php echo $image_url ?>');"></div>
					
					<div class="content row">
						
						<div class="small-12 columns">

							<h3><?php _e( 'Listening Options', 'good-shepherd-catholic-radio' ); ?></h3>

							<?php echo apply_filters( 'the_content', rbm_get_field( 'gscr_home_listen_text' ) ); ?>
							
							<div class="button-container">
							
								<p>
									<?php echo do_shortcode( '[gscr_button url="https://play.google.com/store/apps/details?id=com.securenetsystems.wjknam&hl=en" color="secondary" new_tab="true"]On Android <span class="fa fa-android"></span>[/gscr_button]' ); ?>
									<?php echo ' '; ?>
									<?php echo do_shortcode( '[gscr_button url="https://itunes.apple.com/ro/app/good-shepherd-catholic-radio/id951107141?mt=8&ign-mpt=uo%3D2" color="secondary" new_tab="true"]On iTunes <span class="fa fa-apple"></span>[/gscr_button]' ); ?>
								</p>
								
							</div>
							
						</div>
						
					</div>

				</div>
				
			</div>
			
		</div>
		
	</div>
	
</div>