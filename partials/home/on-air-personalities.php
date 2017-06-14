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
	'posts_per_page' => -1,
) );

$index = 0;
$per_row = 4;

?>

<div class="on-air-personalities-section row expanded collapse-small">

	<h2 class="text-center"><?php _e( 'On-Air Personalities', 'good-shepherd-catholic-radio' ); ?></h2>
	
	<?php if ( $on_air_personalities->have_posts() ) : ?>
	
		<?php while ( $on_air_personalities->have_posts() ) : $on_air_personalities->the_post(); ?>
	
			<?php include locate_template( 'partials/loop/loop-on_air_personalities_home.php' ); ?>
	
		<?php endwhile; ?>
	
		<?php wp_reset_postdata(); ?>
	
	<?php else : ?>
	
		<?php _e( 'No On-Air Personalities Found', 'good-shepherd-catholic-radio' ); ?>
	
	<?php endif; ?>
	
</div>