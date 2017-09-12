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

// Just in case there are any Hooks for Events
locate_template( '/includes/hooks/tribe_events-hooks.php', true, true );

global $post;

global $allow_radio_shows;
$allow_radio_shows = true;

$current_time = current_time( 'Y-m-d' );

// If today is a Sunday, use today. Else get the last Sunday
$sunday = '';
if ( (string) date( 'w', strtotime( $current_time ) ) == '0' ) {
	$sunday = $current_time; 
}
else {
	$sunday = date( 'Y-m-d', strtotime( 'last Sunday', strtotime( $current_time ) ) );
}

// If today is a Saturday, use today. Else get the next Saturday
$saturday = '';
if ( (string) date( 'w', strtotime( $current_time ) ) == '6' ) {
	$saturday = $current_time; 
}
else {
	$saturday = date( 'Y-m-d', strtotime( 'next Saturday', strtotime( $current_time ) ) );
}

$radio_shows = new WP_Query( array(
	'post_type' => 'tribe_events',
	'posts_per_page' => -1,
	'eventDisplay' => 'custom',
	'start_date' => $sunday . ' 00:00',
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
			'key' => '_EventStartDate',
			'value' => $sunday . ' 00:00',
			'type' => 'DATETIME',
			'compare' => '>=',
		),
		array(
			'key' => '_EventStartDate',
			'value' => $saturday . ' 23:59',
			'type' => 'DATETIME',
			'compare' => '<=',
		),
		array(
			'key' => '_EventHideFromUpcoming',
			'compare' => 'NOT EXISTS',
		),
	),
) );

$weekdays = gscr_get_weekdays();

// Remove all duplicate entries. Since by the time this query runs it can basically be guaranteed any particular Event isn't the "original", we can't filter out recurring via SQL
$temp = array();
foreach( $radio_shows->posts as $key => $object ) {
    $temp[ $key ] = $object->post_title;
}

$temp = array_unique( $temp );

foreach ( $radio_shows->posts as $key => $object ) {
	
	if ( ! array_key_exists( $key, $temp ) ) {
		unset( $radio_shows->posts[ $key ] );
	}
	
}

// Reindex array
$radio_shows->posts = array_values( $radio_shows->posts );

// Set Post Count to the new value
$radio_shows->post_count = count( $radio_shows->posts );

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