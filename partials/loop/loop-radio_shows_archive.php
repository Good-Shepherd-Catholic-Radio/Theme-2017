<?php
/**
 * Individual Days for the Radio Shows Week View
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/loop
 */

defined( 'ABSPATH' ) || die(); 

$date_format = get_option( 'date_format', 'F j, Y' );
$time_format = get_option( 'time_format', 'g:i a' );

$start_datetime = strtotime( get_post_meta( get_the_ID(), '_EventStartDate', true ) );
$end_datetime = strtotime( get_post_meta( get_the_ID(), '_EventEndDate', true ) );

?>
	
<div class="row expanded">

	<div <?php post_class( array(
		'small-12',
		'columns',
	) ); ?>>
		
		<div class="row expanded">
			
			<div class="small-12 medium-2 columns text-center date">
				
				<h4 class="day">
					<?php echo date_i18n( 'j', $start_datetime ); ?>
				</h4>
				<h5>
					<span class="month">
						<?php echo date_i18n( 'M', $start_datetime ); ?>
					</span>
					<span class="year">
						'<?php echo date_i18n( 'y', $start_datetime ); ?>
					</span>
				</h5>
				
			</div>
			
			<div class="small-12 medium-10 columns content">

				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

					<h5 class="radio-show-title">
						<?php the_title(); ?>
					</h5>

				</a>
				
				<p class="fa fa-clock-o"></p>&nbsp;
				<?php echo date( $date_format, $start_datetime ); ?>
				<?php echo tribe_get_option( 'dateTimeSeparator', ' @ ' ); ?>
				<?php echo date( $time_format, $start_datetime ); ?>
				<?php echo tribe_get_option( 'timeRangeSeparator', ' - ' ); ?>
				<?php echo date( $date_format, $end_datetime ); ?>
				<?php echo tribe_get_option( 'dateTimeSeparator', ' @ ' ); ?>
				<?php echo date( $time_format, $end_datetime ); ?>
				
				<?php the_excerpt(); ?>
				
			</div>
			
		</div>

	</div>

</div>