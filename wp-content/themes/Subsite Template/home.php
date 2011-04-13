<?php get_header(); ?>
	
	<div id="words">	
		<?php if (get_bloginfo('url') != 'http://sd54.org/media'):?>
		<div id="headerimage">
			<?php
			// Retrieve the dimensions of the current post thumbnail -- no teensy header images for us!
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail');
			list($src, $width, $height) = $image;
			
			// Check if this is a post or page, if it has a thumbnail, and if it's a big one
			if ( is_singular() && has_post_thumbnail( $post->ID ) && $width >= HEADER_IMAGE_WIDTH ) :		
			    // Houston, we have a new header image!
			    echo get_the_post_thumbnail( $post->ID, 'post-thumbnail' );
			elseif ( get_header_image() ) : ?>
			    
			    <img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" />
			<?php endif; ?>
		</div>		
		<?php endif;?>
		<div id="content">
			<h3>News</h3>
				
				<?php query_posts('showposts=1'); ?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
				<div class="post" id="post-<?php the_ID(); ?>">
	
					<div class="entry">
						<h1 class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
						<small>Posted <?php the_time('F jS, Y') ?> by <?php the_author() ?></small>
					
						<?php the_content('Read the rest of this entry &raquo;'); ?>
					</div>
					<!-- <p class="postmetadata"><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?>  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></p> -->
					
				</div>
			<?php endwhile; ?>
			<?php else : ?>
			<h2 class="center">Not Found</h2>
			<p class="center">Sorry, but you are looking for something that isn't here.</p>
			<?php include (TEMPLATEPATH . "/searchform.php"); ?>
			<?php endif; ?>	
		<div class="navigation">
					<?php if ( is_main_site() ):?>
						<a href="<?php echo date('Y');?>">More news >></a>
					<?php endif;?>
					</div>
		</div>
		
		<div id="sidebar">
			<?php get_sidebar();?>
		</div>
		<br class="clear"/>
	</div>



<?php get_footer(); ?>

