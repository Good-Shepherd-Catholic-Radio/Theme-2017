<?php
/**
 * Loop for displaying Radio Shows on the Radio Search Pages
 *
 * @since       {{VERSION}}
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/loop
 */

defined( 'ABSPATH' ) || die(); 

$date_format = get_option( 'date_format', 'F j, Y' );
$time_format = get_option( 'time_format', 'g:i a' );

if ( have_posts() ) : ?>

	<div class="row">

		<div class="small-12 no-sidebar columns radio-show-archive">

			<?php while ( have_posts() ) : the_post();
			
				$start_datetime = strtotime( get_post_meta( get_the_ID(), '_EventStartDate', true ) );
				$end_datetime = strtotime( get_post_meta( get_the_ID(), '_EventEndDate', true ) );
			
				?>
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
			<?php endwhile; ?>

		</div>

	</div>

	<div class="row">

		<div class="columns small-12">
		<?php
			the_posts_pagination( array(
				'prev_text'          => _x( 'Previous Page', 'Previous Page Pagination Text', 'good-shepherd-catholic-radio' ),
				'next_text'          => _x( 'Next Page', 'Next Page Pagination Text', 'good-shepherd-catholic-radio' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . _x( 'Page', 'Page Screen Reader Text', 'good-shepherd-catholic-radio' ) . ' </span>',
			) );
			?>
		</div>

	</div>

<?php else: ?>

	<div class="row">

		<div class="columns small-12">
			<?php echo _x( 'Nothing found, sorry!', 'No Posts Found Text', 'good-shepherd-catholic-radio' ); ?>
		</div>

	</div>

<?php endif; ?>