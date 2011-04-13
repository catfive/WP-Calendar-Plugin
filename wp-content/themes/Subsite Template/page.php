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
						<h1 class="title"><?php the_title(); ?></h1>
						<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>				
						<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
					</div>
				</div>
				
			<?php endwhile; endif; ?>
			
			<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	
		</div>  
		
		<div id="sidebar">
			<?php get_sidebar();?>
		</div>
	
		<br class="clear"/>
	
	</div>

<?php get_footer(); ?>