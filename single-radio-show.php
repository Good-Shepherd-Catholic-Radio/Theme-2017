<?php
/**
 * The theme's single file use for displaying single posts.
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

global $has_featured_image;

?>

<?php if ( $has_featured_image ) : ?>

	<div class="post-title">
		<div class="post-title-color-overlay"></div>
		<div class="post-title-text">
			<h1>
				<?php the_title(); ?>
			</h1>
		</div>
	</div>

<?php endif; ?>

<div class="main-content">

	<div class="row">

		<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'columns', 'small-12' ) ); ?>>
			
			<?php if ( ! $has_featured_image ) : ?>

				<h1 class="post-title">
					<?php the_title(); ?>
				</h1>
			
            <?php endif; ?>
            
            <?php 
            
                $on_air_personalities = rbm_cpts_get_p2p_children( 'on-air-personality' );

                if ( ! $on_air_personalities ) $on_air_personalities = array();

                remove_filter( 'the_content', 'A2A_SHARE_SAVE_add_to_content', 98 );

                foreach ( $on_air_personalities as $personality_id ) : $personality = get_post( $personality_id ); ?>
	
                    <div class="row on-air-personality post-<?php echo $personality_id; ?>">
                        
                        <div class="small-12 columns">
                            
                            <?php if ( has_post_thumbnail( $personality_id ) ) : ?>
                                <div class="thumbnail alignleft">
                                    <a href="<?php echo get_permalink( $personality_id ); ?>" title="<?php echo get_the_title( $personality_id ); ?>">
                                        <?php echo get_the_post_thumbnail( $personality_id, 'thumbnail' ); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <h3 class="post-title">
                                <a href="<?php echo get_permalink( $personality_id ); ?>" title="<?php echo get_the_title( $personality_id ); ?>">
                                    <?php echo get_the_title( $personality_id ); ?>
                                </a>
                            </h3>
                            
                            <?php echo apply_filters( 'the_content', $personality->post_content ); ?>
                            
                        </div>
                        
                    </div>
                
                <?php endforeach;

                add_filter( 'the_content', 'A2A_SHARE_SAVE_add_to_content', 98 );

            ?>

			<?php the_content(); ?>

		</article>

		<?php if ( comments_open() ) : ?>

		<div class="columns small-12">
			<?php comments_template(); ?>
		</div>

		<?php endif; ?>

	</div>
	
</div>

<?php get_footer();