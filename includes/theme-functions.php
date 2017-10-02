<?php
/**
 * Adds helper functions
 * 
 * @since   1.0.0
 * @package Good_Shepherd_Catholic_Radio
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die;
}

function gscr_custom_breadcrumbs() {
 
    $delimiter = __( ' &raquo; ', 'good-shepherd-catholic-radio' ); // delimiter between miscellaneous things
    $home = __( 'Home', 'good-shepherd-catholic-radio' ); // text for the 'Home' link
    $show_current = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $before_current = '<li><span class="show-for-sr">Current: </span>'; // tag before the current crumb
    $before = '<li>'; // tag before every crumb
    $after = '</li>'; // tag after the current crumb
    if ( is_front_page() ) return false;
    global $post;
    $home_link = get_bloginfo( 'url' ); 	
				
	// Somehow this is broken. Events Calendar must be doing something dumb
	wp_reset_postdata();
	
	global $wp_query;
	
?>
 
    <nav aria-label="<?php _e( 'You are here:', 'good-shepherd-catholic-radio' ); ?>" role="navigation">
        <ul class="breadcrumbs">
            <li><a href="<?php echo $home_link; ?>"><?php echo $home; ?></a></li>

            <?php
            if ( is_home() ) { // Since we have a static front page, this is actually for the Blog
                $post_type = get_post_type_object( get_post_type() );
                echo $before_current . $post_type->labels->name . $after;
                
            }
            elseif ( is_category() ) {
                
                $this_cat = get_category( get_query_var( 'cat' ), false );
                if ( $this_cat->parent != 0 ) echo get_category_parents( $this_cat->parent, TRUE, $delimiter );
                $post_type = get_post_type_object( get_post_type() );
                echo $before . '<a href="' . $home_link . '/blog/">' . $post_type->labels->menu_name . '</a>' . $after;
                echo $before_current . sprintf( __( '"%s" Archives', 'good-shepherd-catholic-radio' ), single_cat_title( '', false ) ) . $after;
            }
            elseif ( is_search() ) {
                echo $before_current . sprintf( __( 'Search results for "%s"', 'good-shepherd-catholic-radio' ), get_search_query() ) . $after;
            }
            elseif ( is_day() ) {
                $post_type = get_post_type_object( get_post_type() );
                echo $before . '<a href="' . $home_link . '/blog/">' . $post_type->labels->menu_name . '</a>' . $after;
                echo $before . '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a>' . $after;
                echo $before . '<a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a>' . $after;
                echo $before_current . get_the_time( 'd' ) . $after;
            }
            elseif ( is_month() ) {
                $post_type = get_post_type_object( get_post_type() );
                echo $before . '<a href="' . $home_link . '/blog/">' . $post_type->labels->menu_name . '</a>' . $after;
                echo $before . '<a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a>' . $after;
                echo $before_current . get_the_time( 'F' ) . $after;
            }
            elseif ( is_year() ) {
                $post_type = get_post_type_object( get_post_type() );
                echo $before . '<a href="' . $home_link . '/blog/">' . $post_type->labels->menu_name . '</a>' . $after;
                echo $before_current . get_the_time( 'Y' ) . $after;
            }
            elseif ( is_single() && ! is_attachment() ) {
                // Since we used Page Templates for most Archives (To allow a Content Editor), we need to make our own Breadcrumbs for each
                
				if ( get_post_type() == 'tribe_events' ) {
					
					if ( ! gscr_is_radio_show() ) {
						echo $before . '<a href="' . $home_link . '/' . Tribe__Settings_Manager::get_option( 'eventsSlug', 'events' ) . '/">' . tribe_get_event_label_plural() . '</a>' . $after;
						if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;
					}
					else {
						echo $before . tribe_get_event_label_plural() . $after;
						if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;
					}
					
				}
				else if ( get_post_type() == 'wp_router_page' ) {
					
					if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;
					
				}
                else if ( get_post_type() != 'post' ) {
                    $post_type = get_post_type_object( get_post_type() );
                    $slug = $post_type->rewrite;
                    echo $before . '<a href="' . $home_link . '/' . $slug['slug'] . '/">' . $post_type->labels->name . '</a>' . $after;
                    if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;
                }
                else if ( get_post_type() == 'post' ) {
                    $post_type = get_post_type_object( get_post_type() );
                    echo $before . '<a href="' . $home_link . '/blog/">' . $post_type->labels->menu_name . '</a>' . $after;
                    if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;
                }
                else {
                    $cat = get_the_category(); $cat = $cat[0];
                    $cats = get_category_parents( $cat, TRUE, $delimiter );
                    if ( $show_current == 0 ) $cats = preg_replace( "#^(.+)\s$delimiter\s$#", "$1", $cats );
                    echo $cats;
                    if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;
                }
            } 
            elseif ( ! is_single() && ! is_page() && get_post_type() != 'post' && ! is_404() ) {
				
				// Seriously, what the heck Events Calendar. What are you even doing
				// Edit from the future: Stupid things. It always reports that it is a Page, so it hijacks your Page template
				if ( $wp_query->query['post_type'] == 'tribe_events' ) {
					$post_type = 'tribe_events';
				}
				else {
                	$post_type = get_post_type();
				}
				
				$post_type = get_post_type_object( $post_type );
				
                echo $before_current . $post_type->labels->name . $after;
				
            }
            elseif ( is_attachment() ) {
                $parent = get_post( $post->post_parent );
                $cat = get_the_category( $parent->ID ); $cat = $cat[0];
                
                echo $before . get_category_parents( $cat, TRUE, $delimiter );
                echo '<a href="' . get_permalink( $parent ) . '">' . $parent->post_title . '</a>' . $after;
                if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;
            }
            elseif ( is_page() && ! $post->post_parent ) {
                if ( $show_current == 1) echo $before_current . get_the_title() . $after;
            }
            elseif ( is_page() && $post->post_parent ) {
                $parent_id  = $post->post_parent;
                $breadcrumbs = array();
                while ( $parent_id ) {
                    $page = get_page( $parent_id );
                    $breadcrumbs[] = $before . '<a href="' . get_permalink( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a>' . $after;
                    $parent_id  = $page->post_parent;
                }
                $breadcrumbs = array_reverse( $breadcrumbs );
                for ( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
                    echo $breadcrumbs[$i];
                    
                }
                if ( $show_current == 1 ) echo $before_current . get_the_title() . $after;
            }
            elseif ( is_tag() ) {
                echo $before_current . sprintf( __( 'Posts tagged "%s"', 'good-shepherd-catholic-radio' ), single_tag_title( '', false ) ) . $after;
            }
            elseif ( is_author() ) {
                global $author;
                $userdata = get_userdata( $author );
                echo $before_current . sprintf( __( 'Articles posted by %s', 'good-shepherd-catholic-radio' ), $userdata->display_name ) . $after;
            }
            elseif ( is_404() ) {
                echo $before_current . __( 'Error 404', 'good-shepherd-catholic-radio' ) . $after;
            }
            if ( get_query_var( 'paged' ) ) {
                
                echo $before;
                if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
                echo sprintf( __( 'Page %d', 'good-shepherd-catholic-radio' ), get_query_var( 'paged' ) );
                if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
                
                echo $after;
            }
            ?>

        </ul>
</nav>

<?php
}

/**
 * Determine if a Post is a Radio Show
 * 
 * @param		integer $post_id WP_Post ID
 *                                  
 * @since		1.0.0
 * @return		boolean True if it is a Radio Show
 */
function gscr_is_radio_show( $post_id = null ) {
	
	if ( $post_id == null ) {
		$post_id = get_the_ID();
	}
	
	if ( get_post_type( $post_id ) !== 'tribe_events' ) return false;
		
	$terms = wp_get_post_terms( $post_id, 'tribe_events_cat' );

	// Flatten down the returned Array of Objects into just an Associative Array
	$terms = wp_list_pluck( $terms, 'slug', 'term_id' );

	if ( ! in_array( 'radio-show', $terms ) ) return false;
	
	return true;
	
}

/**
 * Returns a tel: link formatted all nicely
 * 
 * @param		string  $phone_number Phone Number
 * @param		string  $extension    Optional Extension to auto-dial to
 * @param		string  $link_text    Text to use instead of the Phone Number
 * @param		boolean $phone_icon   Whether to auto-include a Font Awesome Phone Icon or not
 *                                                                                    
 * @return		string  tel: Link
 */
function gscr_get_phone_number_link( $phone_number, $extension = false, $link_text = '', $phone_icon = false ) {
    
    $trimmed_phone_number = preg_replace( '/\D/', '', trim( $phone_number ) );
    
    if ( strlen( $trimmed_phone_number ) == 10 ) { // No Country Code
        $trimmed_phone_number = '1' . $trimmed_phone_number;
    }
    else if ( strlen( $trimmed_phone_number ) == 7 ) { // No Country or Area Code
        $trimmed_phone_number = '1616' . $trimmed_phone_number; // We'll assume 616
    }
    
    $tel_link = 'tel:' . $trimmed_phone_number;
    
    if ( $link_text == '' ) {
        
        $link_text = $phone_number;
        
        if ( ( $extension !== false ) && ( $extension !== '' ) ) {
            $link_text = $link_text . __( ' x ', THEME_ID ) . $extension;
        }
        
    }
    
    if ( ( $extension !== false ) && ( $extension !== '' ) ) {
        $tel_link = $tel_link . ',' . $extension;
    }
    
    if ( $phone_icon ) $phone_icon = '<span class="fa fa-phone"></span> ';
    
    return "<a href='$tel_link' class='phone-number-link'>$phone_icon$link_text</a>";
    
}

if ( ! function_exists( 'gscr_get_weekdays' ) ) {

	/**
	 * Returns a localized Array of Weekday names with numeric Indices
	 * The "Week Starts On" day in wp_options does not matter here
	 * 
	 * @since		1.0.0
	 * @return		array Localized Weekday names
	 */
	function gscr_get_weekdays() {

		global $wp_locale;

		$options = array();

		foreach ( $wp_locale->weekday as $index => $weekday ) {
			$options[ $index ] = $weekday;
		}

		return $options;

	}
	
}

if ( ! function_exists( 'gscr_radio_show_list_item' ) ) {

	/**
	 * Generates Radio Show List Items using the Query
	 * 
	 * @param		object $query WP_Query
	 *                       
	 * @since		1.0.0
	 * @return		string HTML
	 */
	function gscr_radio_show_list_item( $query ) {

		ob_start();

		global $post;

		// 0 indexed, so actually 2
		$row_max = 1;
		$column_count = 0;

		if ( $query->have_posts() ) : 

			while ( $query->have_posts() ) : $query->the_post();
		
				include THEME_DIR . '/partials/loop/loop-radio_shows_list.php';

			endwhile;

		endif;

		wp_reset_postdata();

		$output = ob_get_contents();
		ob_end_clean();

		return html_entity_decode( $output );

	}
	
}

add_action( 'wp_ajax_gscr_get_radio_shows', 'gscr_get_radio_shows' );
add_action( 'wp_ajax_nopriv_gscr_get_radio_shows', 'gscr_get_radio_shows' );

if ( ! function_exists( 'gscr_get_radio_shows' ) ) {

	/**
	 * AJAX Callback to grab the Search Results for the Radio Shows List Filter
	 * 
	 * @since		1.0.0
	 * @return		HTML
	 */
	function gscr_get_radio_shows() {

		ob_start();

		$args = wp_parse_args( $_POST, array(
			'search' => '',
		) );
		
		$current_time = current_time( 'Y-m-d' );

		// If today is a Sunday, use today. Else get the last Sunday
		$sunday = '';
		if ( (string) date( 'w', strtotime( $current_time ) ) == '0' ) {
			$sunday = $current_time; 
		}
		else {
			$sunday = date( 'Y-m-d', strtotime( 'last Sunday', strtotime( $current_time ) ) );
		}

		// If today is a Saturday, use today. Else get the next Saturday
		$saturday = '';
		if ( (string) date( 'w', strtotime( $current_time ) ) == '6' ) {
			$saturday = $current_time; 
		}
		else {
			$saturday = date( 'Y-m-d', strtotime( 'next Saturday', strtotime( $current_time ) ) );
		}

		$radio_shows = new WP_Query( array(
			'post_type' => 'tribe_events',
			'posts_per_page' => -1,
			'start_date' => $sunday . ' 00:00',
			'order' => 'ASC',
			'orderby' => 'title',
			'tax_query' => array(
				'relationship' => 'AND',
				array(
					'taxonomy' => 'tribe_events_cat',
					'field' => 'slug',
					'terms' => array( 'radio-show' ),
					'operator' => 'IN'
				),
			),
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => '_EventStartDate',
					'value' => $sunday . ' 00:00',
					'type' => 'DATETIME',
					'compare' => '>=',
				),
				array(
					'key' => '_EventStartDate',
					'value' => $saturday . ' 23:59',
					'type' => 'DATETIME',
					'compare' => '<=',
				),
				array(
					'key' => '_EventHideFromUpcoming',
					'compare' => 'NOT EXISTS',
				),
			),
			's' => ( isset( $args['search'] ) && ! empty( $args['search'] ) ) ? $args['search'] : '',
		) );

		// Remove all duplicate entries. Since by the time this query runs it can basically be guaranteed any particular Event isn't the "original", we can't filter out recurring via SQL
		$temp = array();
		foreach( $radio_shows->posts as $key => $object ) {
			$temp[ $key ] = $object->post_title;
		}

		$temp = array_unique( $temp );

		foreach ( $radio_shows->posts as $key => $object ) {

			if ( ! array_key_exists( $key, $temp ) ) {
				unset( $radio_shows->posts[ $key ] );
			}

		}

		// Reindex array
		$radio_shows->posts = array_values( $radio_shows->posts );

		// Set Post Count to the new value
		$radio_shows->post_count = count( $radio_shows->posts );
		
		//var_dump( $radio_shows->post_count );

		echo gscr_radio_show_list_item( $radio_shows );

		$output = ob_get_contents();
		ob_end_clean();

		echo html_entity_decode( $output );
		die();

	}
	
}

/**
 * Increment the Underwriters Offset
 * 
 * @since		1.0.0
 * @return		void
 */
function gscr_underwriters_offset_increment() {
	
	$offset = get_option( 'gscr_underwriters_offset', 0 );
	
	$underwriters = new WP_Query( array(
		'post_type' => 'underwriter',
		'posts_per_page' => -1,
	) );
	
	if ( $offset == $underwriters->post_count ) {
		update_option( 'gscr_underwriters_offset', 1 );
	}
	else {
		update_option( 'gscr_underwriters_offset', $offset + 1 );
	}
	
}

/**
 * Increment the On-Air Personalities Offset
 * 
 * @since		1.0.0
 * @return		void
 */
function gscr_on_air_personalities_offset_increment() {
	
	$offset = get_option( 'gscr_on_air_personalities_offset', 0 );
	
	$on_air_personalities = new WP_Query( array(
		'post_type' => 'on-air-personality',
		'posts_per_page' => -1,
	) );
	
	if ( $offset == $on_air_personalities->post_count ) {
		update_option( 'gscr_on_air_personalities_offset', 1 );
	}
	else {
		update_option( 'gscr_on_air_personalities_offset', $offset + 1 );
	}
	
}

add_action( 'wp_ajax_gscr_stream_down', 'gscr_stream_down_email' );
add_action( 'wp_ajax_nopriv_gscr_stream_down', 'gscr_stream_down_email' );

/**
 * Send an email notification if an attempt to play the Stream is made while it is down
 * This will only be done at a rate of once per hour to prevent it being sent numerous times
 * 
 * @since		{{VERSION}}
 * @return		boolean Success/Failure
 */
function gscr_stream_down_email() {
	
	if ( get_transient( 'gscr_stream_down_timer' ) ) return false;
	
	$emails = get_theme_mod( 'gscr_stream_down_emails', get_option( 'admin_email', 'hshill@gscr.org' ) );
	$emails = str_replace( ' ', '', $emails ); // Remove any whitespace
	
	$date_format = get_option( 'date_format', 'F j, Y' );
	$time_format = get_option( 'time_format', 'g:i a' );
	
	$message = sprintf(
		__( 'A visitor attempted to play the Radio Stream at %s and it failed. This is due to the Stream itself being unavailable.' ),
		current_time( $date_format . ' @ ' . $time_format )
	);
	
	$message .= "\n\n";
	
	$message .= sprintf(
		__( 'If this has not been resolved by %s, attempting to play the Radio Stream again will re-send this email.', 'good-shepherd-catholic-radio' ),
		date_i18n( $date_format . ' @ ' . $time_format, current_time( 'timestamp' ) + HOUR_IN_SECONDS )
	);
	
	$success = wp_mail(
		$emails,
		__( 'GSCR Radio Stream Down', 'good-shepherd-catholic-radio' ),
		$message
	);
	
	if ( $success ) {
		set_transient( 'gscr_stream_down_timer', HOUR_IN_SECONDS );
	}
	
	return $success;
	
}