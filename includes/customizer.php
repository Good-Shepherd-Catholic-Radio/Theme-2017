<?php
/**
 * Adds Customizer Functionality
 * 
 * @since   1.0.0
 * @package Good_Shepherd_Catholic_Radio
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

/**
 * Adds custom Customizer Controls.
 *
 * @since 1.0.0
 */
add_action( 'customize_register', function( $wp_customize ) {
    
    // General Theme Options
    $wp_customize->add_section( 'gscr_customizer_section' , array(
            'title'      => __( 'Good Shepherd Catholic Radio Settings', 'good-shepherd-catholic-radio' ),
            'priority'   => 30,
        ) 
    );
	
	$wp_customize->add_setting( 'gscr_logo_image', array(
            'default'     => 1,
            'transport'   => 'refresh',
        ) 
    );
    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'gscr_logo_image', array(
        'label'        => __( 'Header Logo', 'good-shepherd-catholic-radio' ),
        'section'    => 'gscr_customizer_section',
        'settings'   => 'gscr_logo_image',
        'mime_type'  => 'image',
    ) ) );
	
	$wp_customize->add_setting( 'gscr_logo_image_scroll', array(
            'default'     => 1,
            'transport'   => 'refresh',
        ) 
    );
    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'gscr_logo_image_scroll', array(
        'label'        => __( 'Header Logo on Scroll', 'good-shepherd-catholic-radio' ),
        'section'    => 'gscr_customizer_section',
        'settings'   => 'gscr_logo_image_scroll',
        'mime_type'  => 'image',
    ) ) );
	
	$wp_customize->add_setting( 'gscr_psa_policies_and_guidelines', array(
            'default'     => false,
            'transport'   => 'refresh',
        ) 
    );
    $wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, 'gscr_psa_policies_and_guidelines', array(
        'label'        => __( 'PSA Policies and Guidelines Document', 'good-shepherd-catholic-radio' ),
        'section'    => 'gscr_customizer_section',
        'settings'   => 'gscr_psa_policies_and_guidelines',
    ) ) );
	
	$wp_customize->add_setting( 'gscr_stream_emails', array(
            'default'     => get_option( 'admin_email', 'hshill@gscr.org' ),
            'transport'   => 'refresh',
        )
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'gscr_stream_emails', array(
        'label'        => __( 'Email on Stream Failure', 'good-shepherd-catholic-radio' ),
		'description' => __( 'If an attempt to run the Stream is made while the Stream is down, these Email Addresses will recieve an Email. This will only happen once per Hour to prevent rapid fire Emails.<br /><br />Email Addresses must be separated by commas.', 'good-shepherd-catholic-radio' ),
        'section'    => 'gscr_customizer_section',
        'settings'   => 'gscr_stream_emails',
    ) ) );
    
    $wp_customize->add_setting( 'gscr_phone_number', array(
            'default'     => '1-517-513-3340',
            'transport'   => 'refresh',
        )
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'gscr_phone_number', array(
        'label'        => __( 'Phone Number', 'good-shepherd-catholic-radio' ),
        'section'    => 'gscr_customizer_section',
        'settings'   => 'gscr_phone_number',
    ) ) );
    
    $wp_customize->add_setting( 'gscr_address', array(
            'default'     => "704 N. East Avenue\nJackson, MI 49202-3423",
            'transport'   => 'refresh',
        )
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'gscr_address', array(
        'type' => 'textarea',
        'label'        => __( 'Physical Address', 'good-shepherd-catholic-radio' ),
        'section'    => 'gscr_customizer_section',
        'settings'   => 'gscr_address',
    ) ) );
	
	$wp_customize->add_setting( 'gscr_cron_secret', array(
            'default'     => '',
            'transport'   => 'refresh',
        )
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'gscr_cron_secret', array(
        'label'        => __( 'Cron Secret. This is used as the "?key=" parameter in Ghost Inspector', 'good-shepherd-catholic-radio' ),
        'section'    => 'gscr_customizer_section',
        'settings'   => 'gscr_cron_secret',
    ) ) );
    
    $wp_customize->add_setting( 'gscr_facebook', array(
            'default'     => '//www.facebook.com/goodshepherdcatholicradio',
            'transport'   => 'refresh',
        )
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'gscr_facebook', array(
        'type' => 'url',
        'label'        => __( 'Facebook URL', 'good-shepherd-catholic-radio' ),
        'section'    => 'gscr_customizer_section',
        'settings'   => 'gscr_facebook',
    ) ) );
    
    $wp_customize->add_setting( 'gscr_twitter', array(
            'default'     => '',
            'transport'   => 'refresh',
        )
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'gscr_twitter', array(
        'type' => 'url',
        'label'        => __( 'Twitter URL', 'good-shepherd-catholic-radio' ),
        'section'    => 'gscr_customizer_section',
        'settings'   => 'gscr_twitter',
    ) ) );
    
    $wp_customize->add_setting( 'gscr_pinterest', array(
            'default'     => '',
            'transport'   => 'refresh',
        )
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'gscr_pinterest', array(
        'type' => 'url',
        'label'        => __( 'Pinterest URL', 'good-shepherd-catholic-radio' ),
        'section'    => 'gscr_customizer_section',
        'settings'   => 'gscr_pinterest',
    ) ) );
    
    $wp_customize->add_setting( 'gscr_linkedin', array(
            'default'     => '',
            'transport'   => 'refresh',
        )
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'gscr_linkedin', array(
        'type' => 'url',
        'label'        => __( 'LinkedIn URL', 'good-shepherd-catholic-radio' ),
        'section'    => 'gscr_customizer_section',
        'settings'   => 'gscr_linkedin',
    ) ) );
    
    $wp_customize->add_setting( 'gscr_instagram', array(
            'default'     => '',
            'transport'   => 'refresh',
        )
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'gscr_instagram', array(
        'type' => 'url',
        'label'        => __( 'Instagram URL', 'good-shepherd-catholic-radio' ),
        'section'    => 'gscr_customizer_section',
        'settings'   => 'gscr_instagram',
    ) ) );
    
    $wp_customize->add_setting( 'gscr_rss_show', array(
            'default'     => false,
            'transport'   => 'refresh',
        )
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'gscr_rss_show', array(
        'type' => 'checkbox',
        'label'        => __( 'Show RSS Button', 'good-shepherd-catholic-radio' ),
        'section'    => 'gscr_customizer_section',
        'settings'   => 'gscr_rss_show',
    ) ) );
    
    $wp_customize->add_setting( 'gscr_footer_columns', array(
            'default'     => 4,
            'transport'   => 'refresh',
        )
    );
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'gscr_footer_columns', array(
        'type' => 'number',
        'label'        => __( 'Footer Number of Columns/Widget Areas', 'good-shepherd-catholic-radio' ),
        'section'    => 'gscr_customizer_section',
        'settings'   => 'gscr_footer_columns',
    ) ) );
    
} );