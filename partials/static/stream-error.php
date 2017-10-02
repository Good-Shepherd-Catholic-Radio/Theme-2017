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
		<?php _e( 'The Radio Stream is currently experiencing technical difficulties. This has been reported to our staff. We apologize for the inconvenience.', 'good-shepherd-catholic-radio' ); ?>
	</p>

	<button class="close-button" data-close aria-label="<?php _e( 'Close modal', 'good-shepherd-catholic-radio' ); ?>" type="button">
		<span aria-hidden="true">&times;</span>
	</button>

</div>