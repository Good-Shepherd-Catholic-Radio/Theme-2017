<?php
/**
 * Radio Shows with On-Air Personalities on the Home Page
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/home
 */

defined( 'ABSPATH' ) || die();

// Just in case there are any Hooks for Events
locate_template( '/includes/hooks/tribe_events-hooks.php', true, true );

global $post;

$radio_shows = new WP_Query( array(
	'post_type' => 'tribe_events',
	'posts_per_page' => -1,
	'eventDisplay' => 'custom',
	'post_parent' => 0,
	'order' => 'ASC',
	'orderby' => 'title',
	'tax_query' => array(
		'relationship' => 'AND',
		array(
			'taxonomy' => 'tribe_events_cat',
			'field' => 'slug',
			'terms' => array( 'radio-show' ),
			'operator' => 'IN'
		),
	),
	'meta_query' => array(
		'relation' => 'AND',
		array(
			'key' => '_EventHideFromUpcoming',
			'compare' => 'NOT EXISTS',
		),
		array(
			'key' => '_rbm_radio_show_on_home_page', // Only show ones for the Home Page
			'value' => '1',
			'compare' => '=',
		),
	),
) );

// Remove all duplicate entries. This is important for shows like Blue Collar Theology which have all their shows broken out of the series
$temp = array();
foreach( $radio_shows->posts as $key => $object ) {
	
	$title = _gscr_sanitize_radio_show_name( $object->post_title );
	
    $temp[ $key ] = $title;
	
}

$temp = array_unique( $temp );

foreach ( $radio_shows->posts as $key => $object ) {
	
	if ( ! array_key_exists( $key, $temp ) ) {
		unset( $radio_shows->posts[ $key ] );
	}
	
}

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

		if ( has_post_thumbnail() ) {
			$attachment_id = get_post_thumbnail_id( get_the_ID() );
			$image_url = wp_get_attachment_image_url( $attachment_id, 'full' );
		}
		else {
			$image_url = THEME_URL . '/assets/images/default-radio-show.png';
		}
	
		$on_air_personalities = rbm_cpts_get_p2p_children( 'on-air-personality', get_the_ID() );
	
	?>

		
		<div class="radio-show-on-air-personality small-12 medium-4 columns">
			
			<a href="/radio-show/program/<?php echo urlencode( _gscr_sanitize_radio_show_name( get_the_title() ) ); ?>/" title="<?php echo _gscr_sanitize_radio_show_name( get_the_title() ); ?>">

				<div class="image-container">

					<div class="image" style="background-image: url('<?php echo $image_url; ?>');"></div>
					
					<div class="on-air-personality-title">
						<div class="on-air-personality-title-overlay"></div>
						<h5>
							<?php echo _gscr_sanitize_radio_show_name( get_the_title() ); ?>
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