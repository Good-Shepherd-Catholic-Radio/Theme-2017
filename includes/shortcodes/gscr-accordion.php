<?php
/**
 * Shortcode: Accordion.
 *
 * Displays an accordion.
 *
 * @since   1.1.3
 * @package Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/includes/shortcodes
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

add_shortcode( 'gscr_accordion', 'add_gscr_accordion_shortcode' );
function add_gscr_accordion_shortcode( $atts = array(), $content = '' ) {

	$atts = shortcode_atts( array(
		'title' => '',
		'open' => false,
	), $atts );

	$id = 'accordion-' . md5( $atts['title'] );

	ob_start();
	?>
	<ul class="accordion single" data-accordion data-allow-all-closed="true">
		<li class="accordion-navigation<?php echo ( $atts['open'] ? ' is-active' : '' ); ?>" data-accordion-item>
			<a href="#<?php echo $id; ?>" id="<?php echo $id; ?>-heading" aria-controls="<?php echo $id; ?>" class="accordion-title"><?php echo $atts['title']; ?></a>
			<div id="<?php echo $id; ?>" class="accordion-content content" aria-labelledby="<?php echo $id; ?>-heading" data-tab-content>
				<?php 

					remove_filter( 'the_content', 'A2A_SHARE_SAVE_add_to_content', 98 );
				
					echo apply_filters( 'the_content', $content ); 

					add_filter( 'the_content', 'A2A_SHARE_SAVE_add_to_content', 98 );
					
				?>
			</div>
		</li>
	</ul>
	<?php

	return ob_get_clean();
}