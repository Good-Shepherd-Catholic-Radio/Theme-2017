<?php

// Remove nasty recurrence data. We don't need to know that it happens every third Tuesday into the future	
remove_class_filter( 'tribe_events_event_schedule_details', 'Tribe__Events__Pro__Main', 'append_recurring_info_tooltip', 9 );

add_filter( 'tribe_events_event_schedule_details', function( $output, $post_id ) {
	
	ob_start();

	if ( tribe_is_recurring_event( $post_id ) ) : ?>

		<div class="recurringinfo">
			<div class="event-is-recurring">
				<span class="tribe-events-divider">|</span>

				<?php if ( ! gscr_is_radio_show( $post_id ) ) : ?>
					<?php _e( 'Recurring Event', 'tribe-events-calendar-pro' ); ?>
				<?php else : ?>
					<?php _e( 'Recurring Radio Show', 'good-shepherd-catholic-radio' ); ?>
				<?php endif; ?>
				
				<?php printf(
					' <a href="%s">%s</a>',
					tribe_all_occurences_link( $post_id, false ),
					__( '(See all)', 'tribe-events-calendar-pro' )
				); ?>
			</div>
		</div>

	<?php endif;

	$output .= ob_get_clean();
	
	return $output;

}, 9, 2 );