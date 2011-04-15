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
						if ($EventStartTime = get_post_meta($post->ID, 'event_date_start', true)) $details = "<p><strong>Event begins:</strong> ";
						if ($EventTimeStartStr = get_post_meta($post->ID, 'event_time_start', true)) $details .= preg_replace('/([ap])(m)/', '$1.$2.', date('g a', $EventStartTime))." ";
						$details.= date('l, F d, Y', $EventStartTime)."</p>";
						if ($EventEndTime = get_post_meta($post->ID, 'event_date_end', true)){
							$details .= "<p><strong>Event ends:</strong> ";
							if ($EventTimeEndStr = get_post_meta($post->ID, 'event_time_end', true)) $details .= preg_replace('/([ap])(m)/', '$1.$2.', date('g a', $EventEndTime))." ";
							$details.= date('l, F d, Y', $EventEndTime)."</p>";
						}
						if (get_post_meta($post->ID, 'event_repeats', true)){
							if ($repeat = get_post_meta($post->ID, 'event_repeat_on_description', true)) $details .= "<p><em>This event occurs $repeat.</em></p>";
							elseif ($unit = get_post_meta($post->ID, 'event_repeat_unit', true)){ 
								$interval = get_post_meta($post->ID, 'event_repeat_interval', true);
								$details .="<p><em>This event ocurrs every ";
								if ($interval < 2) $details .= "$unit</em></p>";
								else $details .= $interval ." ".$unit."s.</em></p>";	
							}
						}
												if ($EventLocation = get_post_meta($post->ID, 'event_location', true)) $details .= "<p><strong>Location: </strong>$EventLocation</p>";
						?> 
						<?php echo $details ?>
						<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
						<?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>
						<?php if(get_the_content()){echo "<p><strong>Description:</strong></p> ";}?>
					  	<div class="eventdetails"><?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?></div>
						<p class="postmetadata alt">
							<small>
								This entry was posted on <?php the_time('l, F jS, Y') ?> by <?php the_author() ?> at <?php the_time() ?>
								and is filed under <?php printf( __( 'Category Archives: %s', 'Subsite Template' ), '<span>' . $term_name . '</span>' );?>  
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