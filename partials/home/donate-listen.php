<?php
/**
 * Donate/Listen section on the Home Page
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/home
 */

defined( 'ABSPATH' ) || die();

$blocks = array(
	'donate',
	'listen',
);

?>

<div class="donate-listen row expanded small-collapse<?php echo ( ! rbm_get_field( 'gscr_show_two_donate_listen_sections' ) ) ? ' only-donate' : ''; ?>">
	
	<div class="small-12 columns">
		
		<div class="row small-collapse">
	
			<div class="small-12 columns">

				<?php foreach ( $blocks as $index => $name ) : ?>

					<?php if ( $name == 'listen' && ! rbm_get_field( 'gscr_show_two_donate_listen_sections' ) ) continue; ?>

					<div class="<?php echo esc_attr( $name ); ?>">
						
						<?php

							$attachment_id = rbm_get_field( 'gscr_home_' . $name . '_image' );
							$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );

						?>

						<?php if ( $link = rbm_get_field( 'gscr_home_' . $name . '_link' ) ) : ?>

							<a href="<?php echo esc_attr( $link ); ?>"<?php echo ( rbm_get_field( 'gscr_home_' . $name . '_link_new_tab' ) ? ' target="_blank"' : '' ); ?>>

						<?php endif; ?>

						<div class="image" style="background-image: url('<?php echo $image_url ?>');"></div>
						
						<div class="content row">
							
							<div class="small-12 columns">

								<?php 
								
								$title = rbm_get_field( 'gscr_home_' . $name . '_title' );
								$title = ( $title ) ? $title : __( 'Listening Options', 'good-shepherd-catholic-radio' );

								$content = rbm_get_field( 'gscr_home_' . $name . '_text' );

								?>

								<?php if ( $title ) : ?>
									<h3><?php echo $title; ?></h3>
								<?php endif; ?>

								<?php 
								
								echo apply_filters( 'the_content', $content ); 
								
								?>
								
							</div>
							
						</div>

						<?php if ( $link ) : ?>
							<div class="color-overlay"></div>
							</a>
						<?php endif; ?>

					</div>

				<?php endforeach; ?>
				
			</div>
			
		</div>
		
	</div>
	
</div>