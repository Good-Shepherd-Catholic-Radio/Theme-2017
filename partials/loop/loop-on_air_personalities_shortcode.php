<?php
/**
 * On Air Personalities Loop for the Shortcode.
 * On Air Personalities don't have an Archive (To allow for a Content Editor above them)
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
	
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			
			<h3><?php the_title(); ?></h3>
			
		</a>
			
	<?php else : ?>
	
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			
			<h3><?php the_title(); ?></h3>
			
		</a>
	
	<?php endif; ?>

</div>