<?php
/**
 * Popup modal for Stream on IE 11 or below
 *
 * @since       {{VERSION}}
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/static
 */

defined( 'ABSPATH' ) || die(); ?>

<div class="reveal" id="gscr_stream_old" data-reveal>

	<p>
		<?php _e( 'Our Radio Stream is not supported on Internet Explorer versions 11 and older. We recommend you switch to <a href="//www.google.com/chrome/">Google Chrome</a>, <a href="//www.mozilla.org/firefox/">Mozilla Firefox</a>, or <a href="//www.microsoft.com/windows/microsoft-edge">Microsoft Edge</a>. We apologize for the inconvenience.', 'good-shepherd-catholic-radio' ); ?>
	</p>

	<button class="close-button" data-close aria-label="<?php _e( 'Close modal', 'good-shepherd-catholic-radio' ); ?>" type="button">
		<span aria-hidden="true">&times;</span>
	</button>

</div>