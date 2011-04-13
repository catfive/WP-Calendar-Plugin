<?php get_header(); ?>

	<div id="words">
			<div id="content">

				<?php if (have_posts()) : ?>


			<?php while (have_posts()) : the_post(); ?>
			<div class="post">
				<div class="entry">
					<h1 class="title" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
					<small>Posted <?php the_time('l, F jS, Y') ?> by <?php the_author() ?></small>
					<?php the_content() ?>
				</div>
				<p class="postmetadata"><?php the_tags('Tags: ', ', ', '<br />'); ?> Posted under <?php the_category(', ')?> <?php edit_post_link(' | Edit', ''); ?>  <!--<?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>--></p>
			</div>
			<?php endwhile; ?>
			<div class="navigation">
				<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
				<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
			</div>
			<?php else : ?>
			<h2 class="center">Not Found</h2>
			<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			<?php endif; ?>
		</div>
		<div id="sidebar">	
			<?php get_sidebar();?>
		</div>
		<br class="clear"/>
</div>
<?php get_footer(); ?>
