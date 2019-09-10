<?php
/**
 * Radio Show Programs Loop for the Shortcode.
 * Radio Show Programs don't have an Archive, period. This allows one with a Content editor above it.
 *
 * @since       1.0.24
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/loop
 */

defined( 'ABSPATH' ) || die();

?>

<div <?php post_class( array(
	'radio-show-on-air-personality',
	'small-12',
	$medium_class,
	'columns'
) ); ?>>
	
	<?php 

	$attachment_id = rbm_cpts_get_field( 'banner' );
	
	if ( $attachment_id ) {
			$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
		}
		else {
			$image_url = THEME_URL . '/assets/images/default-radio-show.png';
		}
	
		$on_air_personalities = rbm_cpts_get_p2p_children( 'on-air-personality', get_the_ID() );
	
		if ( ! $on_air_personalities ) $on_air_personalities = array();
	
		remove_filter( 'the_title', 'wptexturize' );
	
		$url = urlencode( _gscr_sanitize_radio_show_name( get_the_title() ) );
						 
		add_filter( 'the_title', 'wptexturize' );
	
	?>
			
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

				<div class="image-container">

					<div class="image" style="background-image: url('<?php echo $image_url; ?>');"></div>
					
					<div class="on-air-personality-title">
						<div class="on-air-personality-title-overlay"></div>
						<h5>
							<?php the_title(); ?>
						</h5>

						<?php foreach ( $on_air_personalities as $personality_id ) : ?>

							<h6>
								<?php echo get_the_title( $personality_id ); ?>
							</h6>

						<?php endforeach; ?>

					</div>

				</div>

			</a>

</div>