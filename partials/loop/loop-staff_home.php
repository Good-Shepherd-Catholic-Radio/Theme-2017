<?php
/**
 * Staff Loop for the Home Page.
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/loop
 */

defined( 'ABSPATH' ) || die();

?>

<div <?php post_class( array(
	'small-12',
	'medium-3',
	'columns'
) ); ?>>
	
	<?php if ( has_post_thumbnail() ) : ?>
	
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
			
			<?php the_post_thumbnail( 'full', array(
				'class' => 'aligncenter',
			) ); ?>
			
		</a>
			
	<?php endif; ?>
	
	<a class="text-center" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

		<h4><?php the_title(); ?></h4>

	</a>
	
	<?php if ( $position = rbm_get_field( 'staff_position' ) ) : ?>
		<h6><?php echo $position; ?></h6>
	<?php endif; ?>

</div>