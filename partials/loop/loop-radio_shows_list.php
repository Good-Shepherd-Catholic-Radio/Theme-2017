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

global $post;

if ( $post->post_parent !== 0 ) {
	$post_id = $post->post_parent;
}
else {
	$post_id = get_the_ID();
}

$image_url = '';
if ( ! has_post_thumbnail( $post_id ) ) {
	$image_url = THEME_URL . '/assets/images/default-radio-show.png';
}
else {
	$attachment_id = get_post_thumbnail_id( $post_id );
	$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
}

?>

<article <?php post_class( array(
	'small-12',
	'columns',
) ); ?>>
	
	<div class="row expanded">
		
		<div class="small-12 medium-3 columns image-container hide-for-print">
			
			<a href="<?php echo tribe_all_occurences_link( $post_id, false ); ?>" title="<?php the_title(); ?>">
				
				<div class="image" style="background-image: url('<?php echo $image_url; ?>');"></div>
				
			</a>
			
		</div>
		
		<div class="small-12 medium-9 columns content">
	
			<a href="<?php echo tribe_all_occurences_link( $post_id, false ); ?>" title="<?php the_title(); ?>">
				<?php the_title(); ?>
			</a>
			
			<?php edit_post_link( '<span class="fa fa-edit"></span> ' . __( 'Edit this Radio Show', 'good-shepherd-catholic-radio' ) ); ?>
			
			<br />
			
			<ul>
				
				<?php 
				
				$weekdays = gscr_get_weekdays();
				
				$recurrence = get_post_meta( $post_id, '_EventRecurrence', true );
				
				foreach ( $recurrence['rules'] as $rule ) : 
				
					$days_array = array();
					$same_time = false;
					if ( isset( $rule['custom']['week'] ) ) {
						
						$days_array = $rule['custom']['week']['day'];
						$same_time = isset( $rule['custom']['week']['same-time'] );
						
					}
					else {
						
						// Every day
						$days_array = array( '1', '2', '3', '4', '5', '6', '7' );
						$same_time = isset( $rule['custom']['day']['same-time'] );
						
					}
				
					foreach ( $days_array as $day_index ) : ?>
				
						<li>
							<?php echo $weekdays[ $day_index - 1 ]; ?>
							<?php echo tribe_get_option( 'dateTimeSeparator', ' @ ' ); ?>
							
							<?php if ( $same_time ) : ?>
								<?php echo date( $time_format, strtotime( get_post_meta( get_the_ID(), '_EventStartDate', true ) ) ); ?>
								<?php echo tribe_get_option( 'timeRangeSeparator', ' - ' ); ?>
								<?php echo date( $time_format, strtotime( get_post_meta( get_the_ID(), '_EventEndDate', true ) ) ); ?>
							<?php else : 
							
								$hour = $rule['custom']['start-time']['hour'];
								$minute = $rule['custom']['start-time']['minute'];
								$meridian = $rule['custom']['start-time']['meridian'];
							
								echo date( $time_format, strtotime( $hour . ':' . $minute . $meridian ) );
							
								$hour = $hour + $rule['custom']['duration']['hours'];
								$minute = $minute + $rule['custom']['duration']['minutes'];
								
								if ( (int) $minute >= 60 ) {
									$minute -= 60;
									$hour++;
								}
							
								// Leading zero
								$minute = sprintf( '%02d', $minute );
							
								if ( (int) $hour > 12 ) {
									$hour -= 12;
								}
							
								if ( (int) $hour == 12 ) {
									
									if ( strtolower( $meridian ) == 'am' ) {
										$merdian = 'pm';
									}
									else {
										$merdian = 'am';
									}
									
								}
							
								echo tribe_get_option( 'timeRangeSeparator', ' - ' );
							
								echo date( $time_format, strtotime( $hour . ':' . $minute . $meridian ) );
							
							endif; ?>
							
						</li>
				
					<?php endforeach;
				
				endforeach; ?>
			
			</ul>
			
			<?php the_excerpt(); ?>
			
			<a href="<?php echo tribe_all_occurences_link( $post_id, false ); ?>" class="button secondary">
				<?php _e( 'Find Out More', 'good-shepherd-catholic-radio' ); ?>
			</a>
			
		</div>
	
	</div>

</article>