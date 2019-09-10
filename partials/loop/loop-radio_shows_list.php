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

$image_url = '';

$attachment_id = rbm_cpts_get_field( 'radio_show_background_image' );

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
			
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				
				<div class="image" style="background-image: url('<?php echo $image_url; ?>');"></div>
				
			</a>
			
		</div>
		
		<div class="small-12 medium-9 columns content">
	
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				<?php the_title(); ?>
			</a>
			
			<?php edit_post_link( '<span class="fa fa-edit"></span> ' . __( 'Edit this Radio Show', 'good-shepherd-catholic-radio' ) ); ?>
			
			<br />
			
			<ul>
				
				<?php 

					$occurrences = new WP_Query( array(
						'post_type' => 'radio-show',
						'post_parent' => get_the_ID(),
						'posts_per_page' => -1,
						'post_status' => 'radioshow-occurrence',
						'orderby' => array(
							'rbm_cpts_day_of_the_week' => 'ASC',
							'rbm_cpts_start_time' => 'ASC',
						),
						'meta_query' => array(
							'relation' => 'AND',
							array(
								'key' => 'rbm_cpts_day_of_the_week',
								'type' => 'NUMERIC',
							),
							array(
								'key' => 'rbm_cpts_start_time',
								'type' => 'TIME',
							),
						),
					) );

					if ( $occurrences->have_posts() ) : 

						while ( $occurrences->have_posts() ) : $occurrences->the_post(); ?>

							<li>

								<?php echo date_i18n( 'l', strtotime( "Sunday +" . rbm_cpts_get_field( 'day_of_the_week' ) . " days" ) ); ?>
								<?php echo ' @ '; ?>
								<?php echo date_i18n( $time_format, strtotime( rbm_cpts_get_field( 'start_time' ) ) ); ?>
								<?php echo ' - '; ?>
								<?php echo date_i18n( $time_format, strtotime( rbm_cpts_get_field( 'end_time' ) ) ); ?>

							</li>

						<?php endwhile;

						wp_reset_postdata();

					endif;

				?>
			
			</ul>
			
			<?php the_excerpt(); ?>
			
			<a href="<?php the_permalink(); ?>" class="button secondary">
				<?php _e( 'Find Out More', 'good-shepherd-catholic-radio' ); ?>
			</a>
			
		</div>
	
	</div>

</article>