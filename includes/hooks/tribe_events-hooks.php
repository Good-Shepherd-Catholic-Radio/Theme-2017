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

/**
 * Add whether a Radio Show is Live/Local to the Event Meta
 * 
 * @since		1.0.0
 */
add_action( 'tribe_events_single_meta_details_section_start', function() {
	
	if ( ! gscr_is_radio_show() ) return false;
	
	if ( rbm_get_field( 'radio_show_local' ) ) : ?>
			
		<dt>
			<?php _e( 'Local Radio Show', 'good-shepherd-catholic-radio' ); ?>
		</dt>
		<dd></dd>

	<?php endif; ?>

	<?php if ( rbm_get_field( 'radio_show_live' ) ) : ?>

		<dt>
			<?php _e( 'Live Radio Show', 'good-shepherd-catholic-radio' ); ?>
		</dt>
		<dd></dd>

	<?php endif;
	
	global $post;
	
	if ( $post->post_parent !== 0 ) {
		$post_id = $post->post_parent;
	}
	else {
		$post_id = get_the_ID();
	}
	
	$on_air_personalities = rbm_cpts_get_p2p_children( 'on-air-personality', $post_id );
	if ( ! is_array( $on_air_personalities ) ) $on_air_personalities = array( $on_air_personalities );
	
	if ( ! empty( $on_air_personalities ) ) : ?>

		<dt><?php _e( 'On-Air Personalities', 'good-shepherd-catholic-radio' ); ?></dt>
		<dd>
			<ul>
				<?php foreach ( $on_air_personalities as $personality ) : ?>
					<li>
						<a href="<?php echo get_permalink( $personality ); ?>" title="<?php echo get_the_title( $personality ); ?>">
							<?php echo get_the_title( $personality ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</dd>

	<?php endif;
	
} );