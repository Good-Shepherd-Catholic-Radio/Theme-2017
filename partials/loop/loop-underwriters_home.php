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
		
		<?php $permalink = get_permalink(); ?>
	
		<?php if ( has_post_thumbnail() ) : ?>

			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"<?php echo ( strpos( $permalink, get_home_url() ) === false ) ? ' target="_blank"' : ''; ?>>

				<?php the_post_thumbnail( 'full', array(
					'class' => 'aligncenter',
				) ); ?>
				
				<div class="underline"></div>

			</a>

		<?php else : ?>

			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"<?php echo ( strpos( $permalink, get_home_url() ) === false ) ? ' target="_blank"' : ''; ?>>

				<h3><?php the_title(); ?></h3>
				
				<div class="underline"></div>

			</a>

		<?php endif; ?>
		
	</div>

</div>