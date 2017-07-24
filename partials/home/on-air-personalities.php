<?php
/**
 * On-Air Personalities on the Home Page
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/home
 */

defined( 'ABSPATH' ) || die();

// Just in case there are any Hooks for Staff
locate_template( '/includes/hooks/on-air-personality-hooks.php', true, true );

global $post;

$on_air_personalities = new WP_Query( array(
	'post_type' => 'on-air-personality',
	'posts_per_page' => 8,
) );

$index = 0;
$per_row = 4;

$count = count( $on_air_personalities->posts );

$medium_class = 'medium-3';

?>

<div class="on-air-personalities-section row expanded">
	
	<div class="small-12 columns">
		<div class="row">
			<div class="small-12 columns">
				<h2 class="section-header">
					<?php _e( 'On-Air Personalities', 'good-shepherd-catholic-radio' ); ?>
				</h2>
			</div>
		</div>
	</div>
	
	<div class="row expanded small-collapse">
		<div class="small-12 columns">
			<div class="row expanded small-collapse">
	
				<?php if ( $on_air_personalities->have_posts() ) : ?>

					<?php while ( $on_air_personalities->have_posts() ) : $on_air_personalities->the_post(); ?>

						<?php include locate_template( 'partials/loop/loop-on_air_personalities_home.php' ); ?>

					<?php endwhile; ?>

					<?php wp_reset_postdata(); ?>

				<?php else : ?>

					<?php _e( 'No On-Air Personalities Found', 'good-shepherd-catholic-radio' ); ?>

				<?php endif; ?>
				
			</div>
		</div>
	</div>
	
	<div class="small-12 columns view-all-container">
		<div class="row">
			<div class="small-12 columns text-center">
				<a href="/on-air-personalities/" class="button secondary">
					<?php _e( 'View All On-Air Personalities', 'good-shepherd-catholic-radio' ); ?>
				</a>
			</div>
		</div>
	</div>
	
</div>