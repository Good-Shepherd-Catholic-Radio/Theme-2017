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

if ( has_post_thumbnail() ) {
	$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
}
else {
	$image_url = '//placeholdit.co/i/1000x500?&bg=ccc&fc=000&text=Placeholder';
}

?>

<div <?php post_class( array(
	'small-12',
	'medium-6',
	'columns'
) ); ?>>
	
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		
		<div class="image" style="background-image: url(<?php echo $image_url; ?>);"></div>
	
		<div class="radio-show-color-overlay"></div>
		
		<div class="radio-show-meta">
			
			<?php if ( rbm_get_field( 'radio_show_local' ) ) : ?>
			
				<span class="fa fa-2x fa-map-marker" title="<?php _e( 'Local', 'good-shepherd-catholic-radio' ); ?>"></span>
			
			<?php endif; ?>
			
			<?php if ( rbm_get_field( 'radio_show_live' ) ) : ?>
			
				<span class="fa-stack microphone-live" title="<?php _e( 'Live', 'good-shepherd-catholic-radio' ); ?>">
					<span class="fa fa-rss fa-flip-horizontal left fa-stack-1x"></span>
					<span class="fa fa-rss right fa-stack-1x"></span>
					<span class="fa fa-microphone fa-stack-2x"></span>
				</span>
			
			<?php endif; ?>
			
		</div>

		<div class="radio-show-title">
			<?php the_title(); ?>
			<br />
			<?php echo date( $time_format, strtotime( get_post_meta( get_the_ID(), '_EventStartDate', true ) ) ); ?>
			<?php echo tribe_get_option( 'timeRangeSeparator', ' - ' ); ?>
			<?php echo date( $time_format, strtotime( get_post_meta( get_the_ID(), '_EventEndDate', true ) ) ); ?>
		</div>
		
	</a>

</div>