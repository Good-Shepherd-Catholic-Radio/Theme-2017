<?php
/**
 * Underwriters Loop for the Home Page.
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
	'columns',
	'text-center'
) ); ?>>
	
	<div class="vertical-align">
	
		<?php if ( has_post_thumbnail() ) : ?>

			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

				<?php the_post_thumbnail( 'full', array(
					'class' => 'aligncenter',
				) ); ?>

			</a>

		<?php else : ?>

			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

				<h3><?php the_title(); ?></h3>

			</a>

		<?php endif; ?>
		
	</div>

</div>