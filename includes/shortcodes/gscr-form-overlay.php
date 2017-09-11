<?php
/**
 * Adds the [gscr_button] shortcode
 *
 * @since   1.0.0
 * @package Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/includes/shortcodes
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Add Button Shortcode
 *
 * @since       1.0.0
 * @return      HTML
 */
add_shortcode( 'gscr_form_overlay', 'add_gscr_button_form_overlay_shortcode' );
function add_gscr_button_form_overlay_shortcode( $atts, $content = '' ) {
    
    $atts = shortcode_atts(
        array( // a few default values
            'color' => 'primary',
            'size' => '',
            'hollow' => 'false',
            'expand' => 'false',
			'form_id' => 0,
        ),
        $atts,
        'gscr_form_overlay'
    );
    
    ob_start();
	
	
	// Copy of Foundation's implementation, but in PHP
	// This should prevent collisions as they need to be unique
	// Math.round( Math.pow( 36, 7 ) - Math.random() * Math.pow( 36, 6 ) ).toString( 36 ).slice( 1 ) + '-reveal';
	$uuid = substr( base_convert( round( pow( 36, 7 ) - ( mt_rand() / mt_getrandmax() ) * pow( 36, 6 ) ), 10, 36 ), 1 ) . '-reveal';
	
    ?>

	<a data-open="<?php echo $uuid; ?>" class="<?php echo $atts['color'] . ' ' . $atts['size'] . ' button' . ( strtolower( $atts['hollow'] == 'true' ) ? ' hollow' : '' ) . ( strtolower( $atts['expand'] == 'true' ) ? ' expanded' : '' ); ?>">
		<?php echo ( $content ) ? $content : __( 'Open Form', 'good-shepherd-catholic-radio' ); ?>
	</a>

	<div class="reveal" id="<?php echo $uuid; ?>" data-reveal>

		[gravityform id="<?php echo $atts['form_id']; ?>" title="true" description="false" ajax="true"]

		<button class="close-button" data-close aria-label="<?php _e( 'Close modal', 'good-shepherd-catholic-radio' ); ?>" type="button">
			<span aria-hidden="true">&times;</span>
		</button>

	</div>

    <?php
    
    $output = ob_get_contents();
    ob_end_clean();
    
    return html_entity_decode( do_shortcode( $output ) );
    
}