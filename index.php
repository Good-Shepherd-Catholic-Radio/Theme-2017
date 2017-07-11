<?php
/**
 * Displays archive of posts.
 *
 * @since   1.0.0
 * @package Good_Shepherd_Catholic_Radio
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

get_header();

?>

<div class="main-content">
	
	<div class="row">
		
		<div class="small-12 columns">

			<h1 class="page-title">
				
				<?php if ( is_search() ) : ?>
                	<?php printf( __( 'Search results for "%s"', 'good-shepherd-catholic-radio' ), get_search_query() ); ?>
				<?php else : ?>
					<?php echo _x( 'Blog', 'Blog Header', 'good-shepherd-catholic-radio' ); ?>
				<?php endif; ?>
				
			</h1>
			
		</div>
		
	</div>

	<?php

	locate_template( '/includes/hooks/' . get_post_type() . '-hooks.php', true, true );

	get_template_part( 'partials/loop/loop', get_post_type() ); 

	?>
	
</div>

<?php

get_footer();