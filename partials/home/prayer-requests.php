<?php
/**
 * Events on the Home Page
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/home
 */

defined( 'ABSPATH' ) || die();

$background_color = rbm_get_field( 'gscr_home_prayer_request_background' );

$background_color = ( ! $background_color ) ? '' : ' background-' . $background_color;

?>

<div class="home-section prayer-requests row expanded<?php echo $background_color; ?>">
	
	<div class="small-12 columns">
		<div class="row">
			<div class="small-12 columns">
				<h2>
					<?php _e( 'Submit a Prayer Request', 'good-shepherd-catholic-radio' ); ?>
				</h2>
			</div>
		</div>
	</div>
		
	<div class="small-12 columns">
		<div class="row">
			<div class="small-12 columns">
				<div class="row expanded small-collapse">

					<div class="medium-6 columns">

						<?php echo apply_filters( 'the_content', rbm_get_field( 'gscr_home_prayer_request_text' ) ); ?>

					</div>

					<div class="medium-6 columns text-center button-container">
						
						<?php $button_color = rbm_get_field( 'gscr_home_prayer_request_button_color' );
						
						$button_color = ( ! $button_color ) ? 'secondary' : $button_color; ?>

						<a data-open="gscr_prayer_request_modal" class="<?php echo $button_color; ?> button">
							<?php _e( 'Submit a Prayer Request', 'good-shepherd-catholic-radio' ); ?>
						</a>

						<div class="reveal" id="gscr_prayer_request_modal" data-reveal>

							<?php if ( $form_id = rbm_get_field( 'gscr_home_prayer_request_form' ) ) : 

								echo do_shortcode( '[gravityform id="' . $form_id . '" title="true" description="false" ajax="true"]' );

							else : 

								echo _e( 'Set a Gravity Form on the Edit Screen for this page', 'good-shepherd-catholic-radio' );

							endif; ?>

							<button class="close-button" data-close aria-label="<?php _e( 'Close modal', 'good-shepherd-catholic-radio' ); ?>" type="button">
								<span aria-hidden="true">&times;</span>
							</button>

						</div>

						<?php 



						?>
					</div>

				</div>
			</div>
		</div>
	</div>
	
</div>