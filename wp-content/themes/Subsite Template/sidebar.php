<?php if (!dynamic_sidebar('home-sidebar')): ?>

	<div class="box">
		<h3>Recent Posts</h3>
		<ul>
		    <?php
    $args=array(
      'offset' => 0,
      'post_type' => 'post',
      'post_status' => 'publish',
      'posts_per_page' => 5,
      'caller_get_posts'=> 1
      );
    $my_query = null;
    $my_query = new WP_Query($args);
    if( $my_query->have_posts() ) {
      while ($my_query->have_posts()) : $my_query->the_post(); ?>
      <li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
       <?php
      endwhile;
    }
wp_reset_query();  // Restore global post data stomped by the_post().
		    ?>
		</ul>
	</div>
	
	<div class="box">
		<h3>Archives</h3>
	    <ul>
	    	<?php wp_get_archives('type=monthly'); ?>
	    </ul>
	</div>
	
	<div class="box">
		<h3>Categories</h3>
	    <ul>
			 <?php wp_list_categories('title_li='); ?> 
	    </ul>
	</div>
	
	<div class="box">
		<?php wp_list_bookmarks('title_before=<h3>&title_after=</h3>&category_name=Popular Links'); ?>
	</div>
	
<?php endif; ?>