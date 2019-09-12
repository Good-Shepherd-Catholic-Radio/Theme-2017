<?php
/**
 * Individual Days for the Radio Shows Week View
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/loop
 */

defined( 'ABSPATH' ) || die(); 

$time_format = get_option( 'time_format', 'g:i a' );

$image_url;

$background_color = rbm_cpts_get_field( 'radio_show_background_image_color', $parent_id );
$attachment_id = rbm_cpts_get_field( 'radio_show_background_image', $parent_id );

$image_url = '';
if ( $attachment_id ) {
	$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
}
else if ( ! rbm_cpts_get_field( 'radio_show_headshot_image', $parent_id ) && ! has_post_thumbnail( $parent_id ) ) {
	$image_url = THEME_URL . '/assets/images/default-radio-show.png';
}

$broadcast_type = rbm_cpts_get_field( 'broadcast_type' );

?>

<article <?php post_class( array(
	'small-12',
	'columns',
) ); ?>>
	
	<div class="row expanded">
		
		<div class="small-12 medium-3 columns image-container hide-for-print">
			
			<a href="<?php the_permalink(); ?>" title="<?php echo gscr_get_occurrence_title( $parent_id, $broadcast_type ); ?>">
				
				<div class="image<?php echo ( $image_url || ( ! has_post_thumbnail( $parent_id ) && ! rbm_cpts_get_field( 'radio_show_headshot_image', $parent_id ) ) ? ' has-image-url' : '' ); ?>" style="background-image: url('<?php echo $image_url; ?>');<?php echo ( $background_color ) ? ' background-color: ' . $background_color . ';': ''; ?>"></div>

				<?php 

					if ( $attachment_id = rbm_cpts_get_field( 'radio_show_headshot_image', $parent_id ) ) : 

						echo wp_get_attachment_image( $attachment_id, 'full', false, array(
							'class' => 'attachment-full size-full wp-post-image radio-show-headshot',
						) );

					endif;

					if ( ! $attachment_id && 
						has_post_thumbnail( $parent_id ) ) : // Logo. Only show one of these if it is the first item

						echo get_the_post_thumbnail( $parent_id, 'full', array(
							'class' => 'attachment-full size-full wp-post-image radio-show-logo' . ( ( $attachment_id ) ? ' hide-for-small-only' : ' no-headshot' ),
						) );

					endif;

				?>
				
			</a>
			
		</div>
		
		<div class="small-12 medium-9 columns content">
	
			<a href="<?php the_permalink(); ?>" title="<?php echo gscr_get_occurrence_title( $parent_id, $broadcast_type ); ?>">

				<div class="radio-show-title">
					<?php echo gscr_get_occurrence_title( $parent_id, $broadcast_type ); ?>
					<br />
					<?php echo date( $time_format, strtotime( $start_time ) ); ?>
					<?php echo ' - '; ?>
					<?php echo date( $time_format, strtotime( $end_time ) ); ?>
				</div>

			</a>
			
		</div>
	
	</div>

</article>