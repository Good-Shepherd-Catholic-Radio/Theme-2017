<?php
/**
 * Individual Days for the Radio Shows Week View
 *
 * @since       1.0.0
 * @package     Good_Shepherd_Catholic_Radio
 * @subpackage  Good_Shepherd_Catholic_Radio/partials/loop
 */

defined( 'ABSPATH' ) || die(); 

$time_format = get_option( 'time_format', 'g:i a' );

$attachment_id = get_post_thumbnail_id( get_the_ID() );

$image_url = '';
if ( ! has_post_thumbnail() ) {
	$image_url = '//placeholdit.co//i/1000x500?&bg=ccc&fc=000&text=Placeholder';
}

?>

<article <?php post_class( array(
	'small-12',
	'columns',
) ); ?>>
	
	<div class="row">
		
		<div class="small-12 medium-4 columns">
			
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
				
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'medium' ); ?>
				<?php else : ?>
					<img src="<?php echo $image_url; ?>" title="<?php the_title(); ?>" />
				<?php endif; ?>
				
			</a>
			
		</div>
	
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

			<div class="radio-show-title">
				<?php the_title(); ?>
				<br />
				<?php echo date( $time_format, strtotime( get_post_meta( get_the_ID(), '_EventStartDate', true ) ) ); ?>
				<?php echo tribe_get_option( 'timeRangeSeparator', ' - ' ); ?>
				<?php echo date( $time_format, strtotime( get_post_meta( get_the_ID(), '_EventEndDate', true ) ) ); ?>
			</div>

		</a>
	
	</div>

</article>