<?php
/**
 * The theme's page file use for displaying pages.
 * 
 * @since   1.0.0
 * @package Good_Shepherd_Catholic_Radio
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Load any post-type specific hooks, if they exist
locate_template( '/includes/hooks/' . get_post_type() . '-hooks.php', true, true );

get_header();

the_post();

global $has_featured_image;
global $wp_query;

wp_reset_postdata();

?>

<?php if ( $has_featured_image ) : ?>

	<?php 

	$title = get_the_title();

	if ( is_archive() && get_post_type() == 'tribe_events' ) {
		
		$post_type = get_post_type_object( 'tribe_events' );
				
		$title = $post_type->labels->name;
		
	}

	if ( is_page() && get_post_type() !== 'tribe_events' || 
	   is_archive() && get_post_type() == 'tribe_events' ) : ?>

		<div class="page-title">
			<div class="page-title-color-overlay"></div>
			<div class="page-title-text">
				<h1>
					<?php echo $title; ?>
				</h1>
			</div>
		</div>

	<?php endif; ?>

	<?php if ( is_single() && 
			  get_post_type() == 'tribe_events' && 
			  ( ! isset( $wp_query->query_vars['eventDisplay'] ) || $wp_query->query_vars['eventDisplay'] !== 'all' )
			 ) : ?>

		<div class="tribe-events-single-event-title">
			<div class="event-title">
				<div class="event-title-color-overlay"></div>
				<div class="event-title-text">
					<h1>
						<?php echo $title; ?>
					</h1>
				</div>
			</div>
		</div>

	<?php endif; ?>

<?php endif; ?>

<div class="main-content">

	<div class="row<?php echo ( $has_featured_image && is_single() && get_post_type() == 'tribe_events' ) ? ' expanded small-collapse' : ''; ?>">

		<article id="page-<?php the_ID(); ?>" <?php post_class( array( 
			'columns',
			'small-12',
			'no-sidebar',
		) ); ?>>
			
			<?php if ( ! $has_featured_image ) : 
			
				$title = get_the_title();

				if ( is_archive() && get_post_type() == 'tribe_events' ) {

					$post_type = get_post_type_object( 'tribe_events' );

					$title = $post_type->labels->name;

				}
			
				if ( get_post_type() !== 'wp_router_page' && 
				   get_post_type() !== 'tribe_events' ) : ?>

					<h1 class="page-title">
						<?php echo $title; ?>
					</h1>
			
				<?php endif;
			
			endif; ?>

			<?php the_content(); ?>

		</article>

	</div>
	
</div>

<?php
get_footer();