<?php
/**
 * Staff Loop for the Shortcode.
 * Staff don't have an Archive (To allow for a Content Editor above them)
 * Keeping it out of a Page Template allows for more flexibility as well
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/loop
 */

defined( 'ABSPATH' ) || die();

?>

<div <?php post_class( array(
	'small-12',
	$medium_class,
	'columns'
) ); ?>>
	
	<?php if ( has_post_thumbnail() ) : ?>
	
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			
			<?php the_post_thumbnail( 'full', array(
				'class' => 'aligncenter',
			) ); ?>
			
		</a>
	
	<?php else : 
	
		$image_url = THEME_URL . '/assets/images/default-radio-show.png';
	
		?>
	
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			
			<img src="<?php echo $image_url; ?>" class="wp-post-image aligncenter" title="<?php the_title(); ?>" alt="<?php the_title(); ?>" />
			
		</a>
	
	<?php endif; ?>
	
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

		<h4><?php the_title(); ?></h4>

	</a>

	<?php if ( $position = rbm_get_field( 'staff_position' ) ) : ?>
		<h6><?php echo $position; ?></h6>
	<?php endif; ?>
	
	<?php the_content(); ?>

</div>