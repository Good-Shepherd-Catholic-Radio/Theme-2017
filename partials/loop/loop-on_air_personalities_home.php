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
	$image_url = THEME_URL . '/assets/images/default-radio-show.png';
}

?>

<div <?php post_class( array(
	'small-6',
	$medium_class,
	'columns'
) ); ?>>
	
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		
		<div class="row">
			
			<div class="small-5 columns image-container alignright">
				
				<div class="image" style="background-image: url('<?php echo $image_url; ?>');"></div>
				
			</div>
			
			<div class="small-12 columns on-air-personality-title">
				<div class="on-air-personality-title-overlay"></div>
				<h5>
					<?php the_title(); ?>
				</h5>
			</div>
			
		</div>

	</a>

</div>