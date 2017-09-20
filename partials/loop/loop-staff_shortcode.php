<?php
/**
 * Staff Loop for the Shortcode.
 * Staff don't have an Archive (To allow for a Content Editor above them)
 * Keeping it out of a Page Template allows for more flexibility as well
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/loop
 */

defined( 'ABSPATH' ) || die();

?>

<li>

	<?php the_title(); ?>

	<?php if ( $position = rbm_get_field( 'staff_position' ) ) : ?>
		&nbsp;-&nbsp;<?php echo $position; ?>
	<?php endif; ?>

</li>