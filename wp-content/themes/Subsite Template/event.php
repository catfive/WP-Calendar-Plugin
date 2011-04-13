<?php get_header();?>

<?php 
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
?>
	<div id="words">
			<div id="content">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<div class="post" id="post-<?php the_ID(); ?>">		
					<div class="entry">
						<h1 style="border-bottom: 1px solid #ccc" class="title"><?php the_title();?></h1>
						<?php
						global $post;
						$EventStartTime = get_post_meta($post->ID, 'event_date_start', true);
						$EventTimeStartStr = get_post_meta($post->ID, 'event_time_start', true);
						$EventEndTime = get_post_meta($post->ID, 'event_date_end', true);
						$EventTimeEndStr = get_post_meta($post->ID, 'event_time_end', true);
						$EventLocation = get_post_meta($post->ID, 'event_location', true);
						?>
						<p><strong>Event begins: </strong><?php echo date('m/d/y', $EventStartTime); 
						if ($EventTimeStartStr) echo ' at '.date('g:i a', $EventStartTime);?></p>
						<p><strong>Event ends: </strong><?php echo get_post_meta(get_the_id(), 'event_time_start', true)?></p>
						<p><strong>Location: </strong><?php echo $EventLocation?></p>
						<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
						<?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>
						<?php if(get_the_content()){echo "<p><strong>Description:</strong></p> ";}?>
					  	<div class="eventdetails"><?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?></div>
						<p class="postmetadata alt">
							<small>
								This entry was posted on <?php the_time('l, F jS, Y') ?> by <?php the_author() ?> at <?php the_time() ?>
								and is filed under <?php printf( __( 'Category Archives: %s', 'Subsite Template' ), '<span>' . $term_name . '</span>' );?>  
.
		
								<?php edit_post_link('Edit this entry','','.'); ?>
							</small>
						</p>
					</div>
					<div class="navigation">
						<?php previous_post_link('&laquo; Previous Event: %link') ?>
						<div style="float:right"><?php next_post_link('Next Event: %link &raquo;') ?></div>
					</div>
				</div>
		
				<?php endwhile; else: ?>
		
				<p>Sorry, no posts matched your criteria.</p>
		
				<?php endif; ?>			
				<br class="clear"/>
			</div>
			<div id="sidebar">
			
			</div>		

			<br class="clear"/>
		</div>

<?php get_footer(); ?>