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

$attachment_id = rbm_cpts_get_field( 'banner', $parent_id );

if ( ! $attachment_id ) {
	$image_url = THEME_URL . '/assets/images/default-radio-show.png';
}
else {
	$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
}

?>

<article <?php post_class( array(
	'small-12',
	'columns',
) ); ?>>
	
	<div class="row expanded">
		
		<div class="small-12 medium-3 columns image-container hide-for-print">
			
			<a href="<?php the_permalink(); ?>" title="<?php get_the_title( $parent_id ); ?>">
				
				<div class="image" style="background-image: url('<?php echo $image_url; ?>');"></div>
				
			</a>
			
		</div>
		
		<div class="small-12 medium-9 columns content">
	
			<a href="<?php the_permalink(); ?>" title="<?php get_the_title( $parent_id ); ?>">

				<div class="radio-show-title">
					<?php the_title(); ?>
					<br />
					<?php echo date( $time_format, strtotime( $start_time ) ); ?>
					<?php echo ' - '; ?>
					<?php echo date( $time_format, strtotime( $end_time ) ); ?>
				</div>

			</a>
			
		</div>
	
	</div>

</article>