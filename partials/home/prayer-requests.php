<?php
/**
 * Events on the Home Page
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/home
 */

defined( 'ABSPATH' ) || die();

?>

<div class="prayer-requests row expanded small-collapse">
	
	<div class="small-12 medium-6 medium-offset-3 columns text-center">
		
		<h2>
			<?php _e( 'Submit a Prayer Request', 'good-shepherd-catholic-radio' ); ?>
		</h2>

		<?php echo do_shortcode( '[gravityform id="2" title="false" description="false" ajax="true"]' ); ?>
		
	</div>
	
</div>