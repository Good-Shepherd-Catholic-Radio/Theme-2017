<?php
/**
 * Posts on the Home Page
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/home
 */

defined( 'ABSPATH' ) || die();

// Just in case there are any Hooks for Post
locate_template( '/includes/hooks/post-hooks.php', true, true );

global $post;

$posts = new WP_Query( array(
	'post_type' => 'post',
	'posts_per_page' => 4, // Gives us 4 nice Posts a Row, 1/4 width each
) );

$count = count( $posts->posts );

$medium_class = 'medium-' . ( 12 / $count );

?>

<div class="blog row expanded">

	<div class="small-12 columns">
		<div class="row">
			<div class="small-12 columns">
				<h2 class="section-header">
					<?php _e( 'Our Blog', 'good-shepherd-catholic-radio' ); ?>
				</h2>
			</div>
		</div>
	</div>
	
	<div class="row expanded small-collapse">
		<div class="small-12 columns">
			<div class="row expanded small-collapse">

				<?php if ( $posts->have_posts() ) : ?>

					<?php while ( $posts->have_posts() ) : $posts->the_post(); ?>

						<?php include locate_template( 'partials/loop/loop-post_home.php' ); ?>

					<?php endwhile; ?>

					<?php wp_reset_postdata(); ?>

				<?php else : ?>

					<?php _e( 'No Blog Posts Found', 'good-shepherd-catholic-radio' ); ?>

				<?php endif; ?>

			</div>
		</div>
	</div>
	
</div>