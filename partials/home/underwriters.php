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

$underwriters = new WP_Query( array(
	'post_type' => 'underwriter',
	'posts_per_page' => -1,
) );

$index = 0;
$per_row = 4;

?>

<div class="underwriters-section expanded row">
	
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