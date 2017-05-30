<?php
/**
 * Individual "Cells" for the Radio Shows Header on the Home Page
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/loop
 */

defined( 'ABSPATH' ) || die(); 

$time_format = get_option( 'time_format', 'g:i a' );

$attachment_id = get_post_thumbnail_id( get_the_ID() );

?>

<div <?php post_class( array(
	'small-12',
	'medium-6',
	'columns'
) ); ?> style="background-image: url(<?php echo wp_get_attachment_image_url( $attachment_id, 'full' ); ?>);">

	<div class="radio-show-meta">
		<?php the_title(); ?>
		<br />
		<?php echo date( $time_format, strtotime( get_post_meta( get_the_ID(), '_EventStartDate', true ) ) ); ?>
		<?php echo date( $time_format, strtotime( get_post_meta( get_the_ID(), '_EventEndDate', true ) ) ); ?>
	</div>

</div>