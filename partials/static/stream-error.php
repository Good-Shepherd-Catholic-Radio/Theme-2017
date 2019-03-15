<?php
/**
 * Popup modal for Stream failure
 *
 * @since       1.0.12
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/static
 */

defined( 'ABSPATH' ) || die(); ?>

<div class="reveal" id="gscr_stream_down" data-reveal>

	<p>
		<?php _e( 'You have lost internet connection to the Radio Stream. There could be a number of reasons for this. Please check your connection and try again. If the steam is off-line, GSCR will be notified.', 'good-shepherd-catholic-radio' ); ?>
	</p>

	<button class="close-button" data-close aria-label="<?php _e( 'Close modal', 'good-shepherd-catholic-radio' ); ?>" type="button">
		<span aria-hidden="true">&times;</span>
	</button>

</div>