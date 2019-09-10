<?php
/**
 * Template Name: Radio Show List
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/loop
 */

defined( 'ABSPATH' ) || die();

get_header();

global $post;

$radio_shows = new WP_Query( array(
	'post_type' => 'radio-show',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'order' => 'ASC',
	'orderby' => 'title',
) );

$weekdays = gscr_get_weekdays();

?>

<div class="row">
	
	<div class="small-12 columns">
		<?php the_content(); ?>
	</div>
	
</div>

<div class="row">
	
	<div class="small-12 columns radio-show-list">
		
		<form class="radio-shows-filter">
			
			<input type="text" name="search" class="search-field alignright" placeholder="<?php _e( 'Search Radio Shows', 'good-shepherd-catholic-radio' ); ?>" />
			
		</form>
		
		<div class="radio-shows-results search-content">
		
			<?php echo gscr_radio_show_list_item( $radio_shows ); ?>
			
		</div>
		
	</div>
	
</div>

<?php

get_footer();