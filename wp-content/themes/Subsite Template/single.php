<?php get_header(); ?>

	<div id="words">
			<div id="content">
			<?php
			// Retrieve the dimensions of the current post thumbnail -- no teensy header images for us!
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail');
			list($src, $width, $height) = $image;
			
			// Check if this is a post or page, if it has a thumbnail, and if it's a big one
			if ( is_singular() && has_post_thumbnail( $post->ID ) && $width >= 600 ) :		
			    // Houston, we have a new header image!
			    echo get_the_post_thumbnail( $post->ID, array(620,310) );
			    echo "<br/><br/>";
			endif;?>

				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
							<div class="post" id="post-<?php the_ID(); ?>">		
					<div class="entry">
						<h1 style="border-bottom: 1px solid #ccc" class="title"><?php the_title(); ?></h1>
						
						<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>
						<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
						<?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>
		
						<p class="postmetadata alt">
							<small>
								This entry was posted on <?php the_time('l, F jS, Y') ?> by <?php the_author() ?> at <?php the_time() ?>
								and is filed under <?php the_category(', ') ?>.
		
								<?php edit_post_link('Edit this entry','','.'); ?>
							</small>
						</p>
					</div>
					<div class="navigation">
					<?php previous_post_link('&laquo; Previous Entry: %link') ?>
					<div style="float:right"><?php next_post_link('Next Entry: %link &raquo;') ?></div>
				</div>
				</div>
		
				<?php endwhile; else: ?>
		
				<p>Sorry, no posts matched your criteria.</p>
		
				<?php endif; ?>			
				<br class="clear"/>
			</div>
			<div id="sidebar">
				<?php get_sidebar(); ?>
			</div>		

			<br class="clear"/>
		</div>

<?php get_footer(); ?>