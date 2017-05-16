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
    $home_link = get_bloginfo( 'url' ); ?>
 
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
                
                if ( get_post_type() != 'post' ) {
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
                $post_type = get_post_type_object( get_post_type() );
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