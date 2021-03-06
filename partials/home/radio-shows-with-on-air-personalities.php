<?php
/**
 * Radio Shows with On-Air Personalities on the Home Page
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/home
 */

defined( 'ABSPATH' ) || die();

global $post;

$radio_shows = new WP_Query( array(
	'post_type' => 'radio-show',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'post_parent' => 0,
	'order' => 'ASC',
	'orderby' => 'title',
) );

$limit = 9;
$offset = get_option( 'gscr_radio_show_programs_offset', 0 );

$before_offset = array_slice( $radio_shows->posts, 0, $offset );
$after_offset = array_slice( $radio_shows->posts, $offset );

$radio_shows->posts = array_merge( $after_offset, $before_offset );

// Reindex array
$radio_shows->posts = array_values( $radio_shows->posts );

// Set Post Count to the new value
$radio_shows->post_count = count( $radio_shows->posts );

$background_color = rbm_get_field( 'gscr_home_radio_show_programs_background' );
$background_color = ( ! $background_color ) ? '' : ' background-' . $background_color;

$button_color = rbm_get_field( 'gscr_home_radio_show_programs_button_color' );						
$button_color = ( ! $button_color ) ? 'secondary' : $button_color;

?>

<div class="home-section on-air-personalities-section row<?php echo $background_color; ?>">
	
	<div class="small-12 columns">
		<div class="row">
			<div class="small-12 columns">
				<h2 class="section-header">
					<?php _e( 'Programs', 'good-shepherd-catholic-radio' ); ?>
				</h2>
			</div>
		</div>
	</div>

<?php
	
$count = 0;

if ( $radio_shows->have_posts() ) : 

	while ( $radio_shows->have_posts() ) : $radio_shows->the_post();
	
		if ( $count == $limit ) break;

		$background_color = rbm_cpts_get_field( 'radio_show_background_image_color' );
		$attachment_id = rbm_cpts_get_field( 'radio_show_background_image' );

		$image_url = '';
		if ( $attachment_id ) {
			$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
		}
		else if ( ! rbm_cpts_get_field( 'radio_show_headshot_image' ) && ! has_post_thumbnail() ) {
			$image_url = THEME_URL . '/assets/images/default-radio-show.png';
		}
	
		$on_air_personalities = rbm_cpts_get_p2p_children( 'on-air-personality', get_the_ID() );
	
		if ( ! $on_air_personalities ) $on_air_personalities = array();
	
	?>

		
		<div class="radio-show-on-air-personality small-12 medium-4 columns">
			
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

				<div class="image-container">

					<div class="image<?php echo ( $image_url || ( ! has_post_thumbnail() && ! rbm_cpts_get_field( 'radio_show_headshot_image' ) ) ? ' has-image-url' : '' ); ?>" style="background-image: url('<?php echo $image_url; ?>');<?php echo ( $background_color ) ? ' background-color: ' . $background_color . ';': ''; ?>"></div>

					<?php 

						if ( $attachment_id = rbm_cpts_get_field( 'radio_show_headshot_image' ) ) : 

							echo wp_get_attachment_image( $attachment_id, 'full', false, array(
								'class' => 'attachment-full size-full wp-post-image radio-show-headshot',
							) );

						endif;

						if ( ! $attachment_id && 
							has_post_thumbnail() ) : // Logo. Only show one of these if it is the first item

							the_post_thumbnail( 'full', array(
								'class' => 'attachment-full size-full wp-post-image radio-show-logo' . ( ( $attachment_id ) ? ' hide-for-small-only' : ' no-headshot' ),
							) );

						endif;

					?>
					
					<div class="on-air-personality-title">
						<div class="on-air-personality-title-overlay"></div>
						<h5>
							<?php the_title(); ?>
						</h5>
					</div>

				</div>

			</a>
	
		</div>

	<?php 
	
		$count++;
	
	endwhile;

	wp_reset_postdata();

endif;
	
?>
	
	<div class="small-12 columns view-all-container">
		<div class="row">
			<div class="small-12 columns text-center">
				<a href="/radio-show-programs/" class="button <?php echo $button_color; ?>">
					<?php _e( 'View All Programs', 'good-shepherd-catholic-radio' ); ?>
				</a>
			</div>
		</div>
	</div>
	
</div>