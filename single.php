<?php
/**
 * The theme's single file use for displaying single posts.
 * 
 * @since 1.0.0
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

?>

<?php if ( $has_featured_image && 
		  get_post_type() == 'post' ) : ?>

	<div class="post-title">
		<div class="post-title-color-overlay"></div>
		<div class="post-title-text">
			<h1>
				<?php the_title(); ?>
			</h1>
			<?php if ( get_post_type() == 'post' ) : ?>
				<span class="timestamp"><span class="fa fa-clock-o"></span>&nbsp;<?php the_date(); ?></span>
			<?php endif; ?>
		</div>
	</div>

<?php endif; ?>

<div class="main-content">

	<div class="row">

		<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'columns', 'small-12' ) ); ?>>
			
			<?php if ( ! $has_featured_image && get_post_type() !== 'tribe_events' || 
					 get_post_type() !== 'post' && get_post_type() !== 'tribe_events' ) : ?>

				<h1 class="post-title">
					<?php the_title(); ?>
				</h1>
			
			<?php endif; ?>

			<?php if ( ! $has_featured_image && 
					  get_post_type() == 'post' ) : ?>

				<p>
					<span class="timestamp"><span class="fa fa-clock-o"></span>&nbsp;<?php the_date(); ?></span>
				</p>

			<?php endif; ?>

			<?php the_content(); ?>

		</article>

		<?php if ( comments_open() ) : ?>

		<div class="columns small-12">
			<?php comments_template(); ?>
		</div>

		<?php endif; ?>

	</div>
	
</div>

<?php get_footer();