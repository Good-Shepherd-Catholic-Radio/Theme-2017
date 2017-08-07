<?php
/**
 * Individual "Cells" for the Blog Loop on the Home Page
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/loop
 */

defined( 'ABSPATH' ) || die(); 

$date_format = get_option( 'date_format', 'F j, Y' );

$attachment_id = get_post_thumbnail_id( get_the_ID() );

if ( has_post_thumbnail() ) {
	$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
}
else {
	$image_url = THEME_URL . '/assets/images/default-radio-show.png';
}

?>

<div <?php post_class( array(
	'small-12',
	$medium_class,
	'columns'
) ); ?>>
	
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		
		<div class="image" style="background-image: url(<?php echo $image_url; ?>);"></div>

		<div class="blog-color-overlay"></div>

		<div class="blog-title">
			<div class="blog-title-color-overlay"></div>
			<h5>
				<?php the_title(); ?>
			</h5>
			<span class="timestamp"><span class="fa fa-clock-o"></span>&nbsp;<?php the_time( $date_format ); ?></span>
		</div>

	</a>

</div>