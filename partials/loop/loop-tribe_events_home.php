<?php
/**
 * Individual Rows for the Events on the Home Page
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/loop
 */

defined( 'ABSPATH' ) || die();

$time_format = get_option( 'time_format', 'g:i a' );

?>

<a href="<?php echo tribe_get_event_link(); ?>" title="<?php the_title(); ?>">
	
	<article <?php post_class( array(
		'small-12',
		'columns'
	) ); ?>>

		<div class="row" data-equalizer data-equalize-on="medium">

			<div class="small-12 medium-2 columns date text-center" data-equalizer-watch>

				<?php $start_date = strtotime( get_post_meta( get_the_ID(), '_EventStartDate', true ) ); ?>

				<h4 class="day">
					<?php echo date_i18n( 'j', $start_date ); ?>
				</h4>
				<h5>
					<span class="month">
						<?php echo date_i18n( 'M', $start_date ); ?>
					</span>
					<span class="year">
						'<?php echo date_i18n( 'y', $start_date ); ?>
					</span>
				</h5>

			</div>

			<div class="small-12 medium-10 columns content" data-equalizer-watch>

				<div class="vertical-align">

					<div class="row">

						<div class="small-12 medium-8 columns">

							<h4 class="title">
								<?php the_title(); ?>
							</h4>

						</div>

						<div class="small-12 medium-2 columns">

							<div class="time alignright">
								<?php echo date_i18n( 'l', $start_date ); ?>
								<br />
								<?php echo date_i18n( $time_format, $start_date ); ?>
							</div>

						</div>

						<div class="small-12 medium-2 columns">

							<div class="button primary alignright">
								<?php _e( 'Learn More', 'good-shepherd-catholic-radio' ); ?>
							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

	</article>

</a>