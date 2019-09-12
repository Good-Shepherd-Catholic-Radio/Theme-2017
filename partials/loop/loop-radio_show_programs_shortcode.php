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

						<?php foreach ( $on_air_personalities as $personality_id ) : ?>

							<h6>
								<?php echo get_the_title( $personality_id ); ?>
							</h6>

						<?php endforeach; ?>

					</div>

				</div>

			</a>

</div>