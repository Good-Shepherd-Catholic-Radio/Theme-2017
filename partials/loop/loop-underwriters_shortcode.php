<?php
/**
 * Underwriters Loop for the Shortcode.
 * Underwriters don't have an Archive (To allow for a Content Editor above them)
 * Keeping it out of a Page Template allows for more flexibility as well
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/loop
 */

defined( 'ABSPATH' ) || die();

$classes = array(
	'small-12',
	$medium_class,
	'columns',
	'closed',
);

if ( $count % 2 == 0 ) {
	$classes[] = 'background-quaternary';
}

?>

<div <?php post_class( $classes ); ?>>
	
	<?php if ( has_post_thumbnail() ) : ?>
	
		<div class="image-container">
			
			<div class="vertical-align">
	
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

					<?php the_post_thumbnail( 'full', array(
						'class' => 'aligncenter',
					) ); ?>

				</a>
				
			</div>
			
		</div>
			
	<?php else : ?>
	
		<div class="header-container">
			
			<div class="vertical-align">
	
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

					<h3><?php the_title(); ?></h3>

				</a>
				
			</div>
			
		</div>
	
	<?php endif; ?>
	
	<?php the_content(); ?>
	
	<div class="read-more-container text-center">
		<a class="secondary button" href="#">
			<?php _e( 'Read More', 'good-shepherd-catholic-radio' ); ?>
		</a>
	</div>

</div>