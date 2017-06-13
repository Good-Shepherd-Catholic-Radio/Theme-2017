<?php
/**
 * Template Name: Radio Show Schedule
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/loop
 */

defined( 'ABSPATH' ) || die();

get_header();

the_content();

var_dump( date( 'Y-m-d', strtotime( 'last Sunday', strtotime( current_time( 'Y-m-d' ) ) ) ) );
var_dump( date( 'Y-m-d', strtotime( 'next Saturday', strtotime( current_time( 'Y-m-d' ) ) ) ) );

?>



<?php

get_footer();