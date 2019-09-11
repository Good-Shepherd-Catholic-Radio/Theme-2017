<?php

// Remove nasty recurrence data. We don't need to know that it happens every third Tuesday into the future	
remove_class_filter( 'tribe_events_event_schedule_details', 'Tribe__Events__Pro__Main', 'append_recurring_info_tooltip', 9 );
	
remove_class_action( 'tribe_events_list_before_the_content', 'Tribe__Events__Pro__Templates__Mods__List_View', 'print_all_events_link', 10 );

add_filter( 'tribe_events_event_schedule_details', function( $output, $post_id ) {
	
	ob_start();

	if ( function_exists( 'tribe_is_recurring_event' ) && tribe_is_recurring_event( $post_id ) ) : ?>

		<div class="recurringinfo">
			<div class="event-is-recurring">
			</div>
		</div>

	<?php endif;

	$output .= ob_get_clean();
	
	return $output;

}, 9, 2 );

/**
 * Remove auto-added Featured Image from Single Events
 * 
 * @param		string  $featured_image HTML
 * @param		integer $post_id        Post ID
 * @param		string  $size           Image Size Name
 *                                            
 * @since		1.0.0
 * @return		string  HTML
 */
add_filter( 'tribe_event_featured_image', function( $featured_image, $post_id, $size ) {
	
	if ( is_single( $post_id ) ) {
		return '';
	}
	
	return $featured_image;
	
}, 10, 3 );

add_action( 'tribe_events_community_form_before_template', function( $event_id ) {
	
	$policy_attachment_id = get_theme_mod( 'gscr_psa_policies_and_guidelines', false );
	$policy_url = '/wp-content/uploads/2017/09/PSA.Policies.and_.Guidelines.Revised.pdf';
	
	if ( $policy_attachment_id ) {
		
		$policy_url = wp_get_attachment_url( $policy_attachment_id );
		
	}

?>
	
	<a href="<?php echo $policy_url; ?>" class="tribe-button">
		<?php _e( 'Policies and Guidelines', 'good-shepherd-catholic-radio' ); ?>
	</a>

<?php
	
} );