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

                $occurrences = new WP_Query( array(
                    'post_type' => 'radio-show',
                    'post_parent' => get_the_ID(),
                    'post_status' => 'radioshow-occurrence',
                    'posts_per_page' => -1,
                    'orderby' => array(
                        'rbm_cpts_day_of_the_week' => 'ASC',
                        'rbm_cpts_start_time' => 'ASC',
                    ),
                    'meta_query' => array(
                        'relation' => 'AND',
                        'rbm_cpts_day_of_the_week' => array(
                            'key' => 'rbm_cpts_day_of_the_week',
                            'type' => 'NUMERIC',
                        ),
                        'rbm_cpts_start_time' => array(
                            'key' => 'rbm_cpts_start_time',
                            'type' => 'TIME',
                        ),
                    ),
                    'fields' => 'ids',
                ) );

                ?>

                <div class="radio-show-details row">

                    <?php if ( $occurrences->have_posts() ) : 

                        $time_format = get_option( 'time_format', 'g:i a' );
                    
                    ?>

                    <div class="small-12 medium-6 columns">

                        <h3><?php _e( 'Broadcast Times', 'good-shepherd-catholic-radio' ); ?></h3>

                        <ul>

                        <?php foreach ( $occurrences->posts as $occurrence_id ) : ?>

                            <?php $broadcast_type = rbm_cpts_get_field( 'broadcast_type', $occurrence_id ); ?>

                            <li>

                                <?php echo date_i18n( 'l', strtotime( "Sunday +" . rbm_cpts_get_field( 'day_of_the_week', $occurrence_id ) . " days" ) ); ?>
                                <?php echo ' @ '; ?>
                                <?php echo date_i18n( $time_format, strtotime( rbm_cpts_get_field( 'start_time', $occurrence_id ) ) ); ?>
                                <?php echo ' - '; ?>
                                <?php echo date_i18n( $time_format, strtotime( rbm_cpts_get_field( 'end_time', $occurrence_id ) ) ); ?>
                                <?php if ( in_array( $broadcast_type, array( 'live', 'encore', 'pre-recorded' ) ) ): ?>
                                    <?php echo ' '; ?>
                                    (<?php echo gscr_get_broadcast_type_label( $broadcast_type ); ?>)
                                <?php endif; ?>

                            </li>

                        <?php endforeach; ?>

                        </ul>

                    </div>

                    <?php endif; ?>

                    <div class="small-12 medium-6 columns">

                        <?php 

                            $phone_number = rbm_cpts_get_field( 'radio_show_call_in' );
                            $is_local = rbm_cpts_get_field( 'radio_show_is_local' );

                            $broadcasters = wp_get_post_terms( get_the_ID(), 'radio-show-broadcaster', array() );

                            $email = rbm_cpts_get_field( 'radio_show_email' );

                            if ( $phone_number || $is_local || ! empty( $on_air_personalities ) || ( ! is_wp_error( $broadcasters ) && ! empty( $broadcasters ) ) || $email ) : ?>

                                <h3><?php _e( 'Details', 'good-shepherd-catholic-radio' ); ?></h3>

                                <ul>

                                    <?php if ( $phone_number ) : ?>
                                        <li><?php _e( 'Call in now!', 'good-shepherd-catholic-radio' ); ?> <?php echo gscr_get_phone_number_link( $phone_number ); ?></li>
                                    <?php endif; ?>

                                    <?php if ( $is_local ) : ?>
                                        <li><?php _e( 'Local Radio Show', 'good-shepherd-catholic-radio' ); ?></li>
                                    <?php endif; ?>

                                    <?php if ( ! empty( $on_air_personalities ) ) : ?>

                                        <li>
                                            
                                            <?php _e( 'On-Air Personalities', 'good-shepherd-catholic-radio' ); ?>

                                            <ul>
                                                <?php foreach ( $on_air_personalities as $personality_id ) : ?>
                                                    <li>
                                                        <a href="<?php echo get_permalink( $personality_id ); ?>" title="<?php echo get_the_title( $personality_id ); ?>">
                                                            <?php echo get_the_title( $personality_id ); ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                    
                                        </li>

                                    <?php endif; ?>

                                    <?php if ( ! is_wp_error( $broadcasters ) && ! empty( $broadcasters ) ) : ?>

                                        <li>
                                            
                                            <?php _e( 'Broadcasted by:', 'good-shepherd-catholic-radio' ); ?>

                                            <ul>
                                                <?php foreach ( $broadcasters as $term ) : ?>
                                                    <li>
                                                        <?php echo $term->name; ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                    
                                        </li>

                                    <?php endif; ?>

                                    <?php if ( $email ) : ?>

                                        <li>
                                            <a href="mailto:<?php echo esc_attr( $email ); ?>">
                                                <?php echo esc_html( $email ); ?>
                                            </a>
                                        </li>

                                    <?php endif; ?>

                                </ul>

                            <?php endif; 
                            
                        ?>

                    </div>

                </div>

                <div class="row small-collapse">
                    <div class="small-12 columns">
			            <?php the_content(); ?>
                    </div>
                </div>

		</article>

		<?php if ( comments_open() ) : ?>

		<div class="columns small-12">
			<?php comments_template(); ?>
		</div>

		<?php endif; ?>

	</div>
	
</div>

<?php get_footer();