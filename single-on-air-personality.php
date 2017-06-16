<?php
/**
 * The theme's single file use for displaying single On Air Personalities.
 * 
 * @since 1.0.0
 * @package Good_Shepherd_Catholic_Radio
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

// Load any post-type specific hooks, if they exist
locate_template( '/includes/hooks/' . get_post_type() . '-hooks.php', true, true );

get_header();

the_post();
?>

<div class="row">

    <article id="post-<?php the_ID(); ?>" <?php post_class( array( 'columns', 'small-12' ) ); ?>>
        
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="thumbnail alignleft">
                <?php the_post_thumbnail( 'full' ); ?>
            </div>
        <?php endif; ?>

        <h1 class="post-title">
            <?php the_title(); ?>
        </h1>

        <?php the_content(); ?>
		
		<?php
		
		$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		
		$radio_shows = new WP_Query( array(
			'post_type' => 'tribe_events',
			'posts_per_page' => 10,
			'paged' => $paged,
			'eventDisplay' => 'custom',
			'start_date' => '1970-01-01', // Unix Epoch
			'order' => 'DESC',
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
					'key' => 'p2p_children_on-air-personalitys',
					'value' => get_the_ID(),
					'compare' => 'LIKE', // Data is serialized. Look for our Post ID in there
				),
				array(
					'key' => '_EventEndDate',
					'value' => '1970-01-01',
					'type' => 'DATETIME',
					'compare' => '>=',
				),
				array(
					'key' => '_EventEndDate',
					'value' => current_time( 'Y-m-d' ),
					'type' => 'DATETIME',
					'compare' => '<=',
				),
				array(
					'key' => '_EventHideFromUpcoming',
					'compare' => 'NOT EXISTS',
				),
			),
		) );
		
		// Pagination Fix
		global $wp_query;
		$temp_query = $wp_query;
		$wp_query = NULL;
		$wp_query = $radio_shows;
		
		if ( $radio_shows->have_posts() ) : ?>
		
			<div class="radio-show-archive">
				
				<h3><?php _e( 'Audio Archive', 'good-shepherd-catholic-radio' ); ?></h3>
		
				<?php while( $radio_shows->have_posts() ) : $radio_shows->the_post(); ?>

					<?php include locate_template( '/partials/loop/loop-radio_shows_archive.php' ); ?>

				<?php endwhile; ?>

				<?php wp_reset_postdata(); ?>
				
				<div class="row expanded">

					<div class="columns small-12">
					<?php
						the_posts_pagination( array(
							'prev_text'          => _x( 'Previous Page', 'Previous Page Pagination Text', 'good-shepherd-catholic-radio' ),
							'next_text'          => _x( 'Next Page', 'Next Page Pagination Text', 'good-shepherd-catholic-radio' ),
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . _x( 'Page', 'Page Screen Reader Text', 'good-shepherd-catholic-radio' ) . ' </span>',
						) );
						?>
					</div>

				</div>
				
			</div>
		
		<?php endif; ?>
		
		<?php 
		
		// Reset main query object after Pagination is done.
        $wp_query = NULL;
        $wp_query = $temp_query;
		
		?>

    </article>
    
</div>

<?php get_footer();