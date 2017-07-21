<?php
/**
 * On-Air Personalities Loop for the Home Page.
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/loop
 */

defined( 'ABSPATH' ) || die();

$attachment_id = get_post_thumbnail_id( get_the_ID() );

if ( has_post_thumbnail() ) {
	$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
}
else {
	$image_url = '//placeholdit.co//i/1000x500?&bg=ccc&fc=000&text=Placeholder';
}

?>

<div <?php post_class( array(
	'small-6',
	$medium_class,
	'columns'
) ); ?>>
	
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		
		<div class="image" style="background-image: url(<?php echo $image_url; ?>);"></div>

		<div class="on-air-personality-color-overlay"></div>

		<div class="on-air-personality-title">
			<h5>
				<?php the_title(); ?>
			</h5>
		</div>

	</a>

</div>