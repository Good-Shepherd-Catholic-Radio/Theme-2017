<?php
/**
 * Underwriters on the Home Page
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/home
 */

defined( 'ABSPATH' ) || die();

// Just in case there are any Hooks for Underwriters
locate_template( '/includes/hooks/underwriter-hooks.php', true, true );

global $post;

$offset = get_option( 'gscr_underwriters_offset', 0 );

$underwriters = new WP_Query( array(
	'post_type' => 'underwriter',
	'posts_per_page' => 8,
	'order' => 'ASC',
	'offset' => $offset,
) );

$index = 0;
$per_row = 4;

$background_color = rbm_get_field( 'gscr_home_underwriters_background' );
$background_color = ( ! $background_color ) ? '' : ' background-' . $background_color;

$button_color = rbm_get_field( 'gscr_home_underwriters_button_color' );						
$button_color = ( ! $button_color ) ? 'secondary' : $button_color;

if ( $underwriters->post_count < 8 ) {
	
	$more = new WP_Query( array(
		'post_type' => 'underwriter',
		'posts_per_page' => 8 - $underwriters->post_count,
		'order' => 'ASC',
	) );
	
	$underwriters->post_count = 8;
	
	$underwriters->posts = array_merge( $underwriters->posts, $more->posts );
	
	$underwriters->posts = array_values( $underwriters->posts );
	
}

?>

<div class="home-section underwriters-section expanded row<?php echo $background_color; ?>">
	
	<div class="small-12 columns">
		<div class="row">
			<div class="small-12 columns">
				<h2 class="section-header">
					<?php _e( 'Underwriters', 'good-shepherd-catholic-radio' ); ?>
				</h2>
			</div>
		</div>
	</div>
	
	<div class="row expanded small-collapse">
		<div class="small-12 columns">
			<div class="row expanded small-collapse underwriters-container">
	
				<?php if ( $underwriters->have_posts() ) : ?>

					<?php while ( $underwriters->have_posts() ) : $underwriters->the_post(); ?>

						<?php if ( $index == 0 ) : ?>

							<div class="row">

						<?php endif; ?>

								<?php include locate_template( 'partials/loop/loop-underwriters_home.php' ); ?>

						<?php if ( $index == ( $per_row - 1 ) ) : ?>

							</div>

						<?php

							$index = 0;

						else : 

							$index++;

						endif; ?>

					<?php endwhile; ?>

					<?php if ( $index !== 0 ) : ?>

							</div>

					<?php endif; ?>

					<?php wp_reset_postdata(); ?>

				<?php else : ?>

					<?php _e( 'No Underwriters Found', 'good-shepherd-catholic-radio' ); ?>

				<?php endif; ?>
			
			</div>
		</div>
	
	</div>
	
	<div class="small-12 columns view-all-container">
		<div class="row">
			<div class="small-12 columns text-center">
				<a href="/underwriters/" class="button <?php echo $button_color; ?>">
					<?php _e( 'View All Underwriters', 'good-shepherd-catholic-radio' ); ?>
				</a>
			</div>
		</div>
	</div>
	
</div>