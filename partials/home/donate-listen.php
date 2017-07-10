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

<div class="donate-listen row expanded collapse-small">
	
	<div class="small-12 columns">
		
		<div class="row">
	
			<div class="small-12 medium-8 columns donate">
				
				<h3><?php printf( __( 'Support %s', 'good-shepherd-catholic-radio' ), get_bloginfo( 'name' ) ); ?></h3>

				<?php if ( $give_form = rbm_get_field( 'gscr_home_donate_form' ) ) : ?>

					<?php echo do_shortcode( '[give_form id="' . $give_form . '" show_title="false" show_goal="false" show_content="none" display_style="modal"]' ); ?>

				<?php else : ?>

					<?php echo _x( 'Please select a Donation Form on the Edit Screen for this page', 'No Donation Form set', 'good-shepherd-catholic-radio' ); ?>

				<?php endif; ?>

			</div>

			<div class="small-12 medium-4 columns listen">
				
				<h3><?php _e( 'Listening Options', 'good-shepherd-catholic-radio' ); ?></h3>
				
				<?php echo apply_filters( 'the_content', rbm_get_field( 'gscr_home_listen_text' ) ); ?>

			</div>
			
		</div>
		
	</div>
	
</div>