<?php
/**
 * Loop Template for Events
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/loop
 */

defined( 'ABSPATH' ) || die();

if ( have_posts() ) : ?>

    <div class="row">
        
        <div class="small-12 <?php echo ( is_active_sidebar( 'sidebar-main' ) ) ? 'medium-9': 'no-sidebar'; ?> columns">

            <?php while ( have_posts() ) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class( array() ); ?>>

                    <div class="media-object stack-for-small">

                        <div class="media-object-section image-section">

                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="thumbnail">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                        <?php the_post_thumbnail( 'medium' ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                        </div>

                        <div class="media-object-section main-section">

                            <h1 class="post-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h1>
                            <span class="datetimestamp"><span class="fa fa-calendar"></span>&nbsp;<?php echo tribe_events_event_schedule_details(); ?></span>
                            <br />

                            <?php the_excerpt(); ?>

                            <a href="<?php the_permalink(); ?>" class="button primary alignright">
                                <?php echo _x( 'Read More', 'Read More Text', 'good-shepherd-catholic-radio' ); ?>
                            </a>

                        </div>

                    </div>

                </article>
            <?php endwhile; ?>
            
        </div>
        
        <?php if ( is_active_sidebar( 'sidebar-main' ) ) : ?>
    
            <div class="small-12 medium-3 columns">

                <?php dynamic_sidebar( 'sidebar-main' ); ?>

            </div>

        <?php endif; ?>
        
    </div>

    <div class="row">

        <div class="columns small-12">
        <?php
            the_posts_pagination( array(
                'prev_text'          => _x( 'Previous Page', 'Previous Page Pagination Text', 'good-shepherd-catholic-radio' ),
                'next_text'          => _x( 'Next Page', 'Next Page Pagination Text', 'good-shepherd-catholic-radio' ),
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . _x( 'Page', 'Page Screen Reader Text', 'good-shepherd-catholic-radio' ) . ' </span>',
                'mid_size' => 9,
            ) );
            ?>
        </div>
        
    </div>

<?php else: ?>

    <div class="row">

        <div class="columns small-12">
            <?php echo _x( 'Nothing found, sorry!', 'No Posts Found Text', 'good-shepherd-catholic-radio' ); ?>
        </div>
        
    </div>

<?php endif; ?>