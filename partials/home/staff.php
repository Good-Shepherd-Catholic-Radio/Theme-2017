<?php
/**
 * Staff on the Home Page
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/home
 */

defined( 'ABSPATH' ) || die();

// Just in case there are any Hooks for Staff
locate_template( '/includes/hooks/staff-hooks.php', true, true );

global $post;

$staff = new WP_Query( array(
	'post_type' => 'staff',
	'posts_per_page' => -1,
) );

$index = 0;
$per_row = 4;

?>

<div class="staff-section row">

	<h2 class="text-center"><?php _e( 'Our Team', 'good-shepherd-catholic-radio' ); ?></h2>
	
	<?php if ( $staff->have_posts() ) : ?>
	
		<?php while ( $staff->have_posts() ) : $staff->the_post(); ?>
	
			<?php if ( $index == 0 ) : ?>
	
				<div class="row">
					
			<?php endif; ?>
	
					<?php include locate_template( 'partials/loop/loop-staff_home.php' ); ?>
					
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
	
		<?php _e( 'No Staff Found', 'good-shepherd-catholic-radio' ); ?>
	
	<?php endif; ?>
	
</div>