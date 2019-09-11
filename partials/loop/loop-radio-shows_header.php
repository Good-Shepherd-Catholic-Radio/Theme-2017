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

$parent_id = wp_get_post_parent_id( get_the_ID() );

$attachment_id = rbm_cpts_get_field( 'radio_show_background_image', $parent_id );

if ( $attachment_id ) {
	$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
}
else {
	$image_url = THEME_URL . '/assets/images/default-radio-show.png';
}

?>

<div <?php post_class( array(
	'small-12',
	'columns'
) ); ?>>
	
	<?php if ( $first ) : ?>
			
		<div class="stream-control alignright">

			<div class="jp-play">

				<span class="fa fa-3x play-icon"></span>

			</div>

		</div>
	
		<?php if ( $phone_number = rbm_cpts_get_field( $parent_id, 'radio_show_call_in' ) ) : ?>
	
			<div class="call-in-container">
				
				<?php _e( 'Call in now!', 'good-shepherd-catholic-radio' ); ?> <?php echo gscr_get_phone_number_link( $phone_number ); ?>
				
			</div>
	
		<?php endif; ?>

	<?php endif; ?>
	
	<a href="<?php the_permalink(); ?>" title="<?php echo get_the_title( $parent_id ); ?>">
		
		<div class="image" style="background-image: url(<?php echo $image_url; ?>);"></div>
		
		<div class="radio-show-meta">
			
			<?php if ( $first && 
					  rbm_cpts_get_field( $parent_id, 'radio_show_local' ) ) : ?>
			
				<span class="fa fa-2x fa-map-marker" title="<?php _e( 'Local', 'good-shepherd-catholic-radio' ); ?>"></span>
			
			<?php endif; ?>
			
			<?php if ( $first && 
					  rbm_get_field( 'radio_show_live' ) ) : ?>
			
				<span class="fa-stack microphone-live" title="<?php _e( 'Live', 'good-shepherd-catholic-radio' ); ?>">
					<span class="fa fa-rss fa-flip-horizontal left fa-stack-1x"></span>
					<span class="fa fa-rss right fa-stack-1x"></span>
					<span class="fa fa-microphone fa-stack-2x"></span>
				</span>
			
			<?php endif; ?>
			
		</div>

		<div class="radio-show-title">
			
			<div class="radio-show-title-color-overlay"></div>
			
			<span class="alignleft">
			
				<?php echo get_the_title( $parent_id ); ?>
				<br />
				<?php echo date( $time_format, strtotime( rbm_cpts_get_field( 'start_time' ) ) ); ?>
				<?php echo ' - '; ?>
				<?php echo date( $time_format, strtotime( rbm_cpts_get_field( 'end_time' ) ) ); ?>
				
				<?php if ( $first && rbm_cpts_get_field( $parent_id, 'radio_show_call_in' ) ) : ?>
				
					<br />
					&nbsp;
				
				<?php endif; ?>
				
			</span>
			
		</div>
		
	</a>

</div>