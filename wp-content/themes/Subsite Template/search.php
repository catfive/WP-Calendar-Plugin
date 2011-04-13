<?php get_header(); ?>

<div id="words">
<div class="wrap">
	<div id="content">

	<?php if (have_posts()) : ?>

		<div class="breadcrumb">
			<?php if(function_exists('bcn_display')){ bcn_display();}?>
		</div>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>


		<?php while (have_posts()) : the_post(); ?>

			<div class="post">
				<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a> &mdash; <?php the_time('l, F jS, Y') ?></h2>
				<p><?php the_excerpt() ?></p>
				
			</div>

		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>

	<?php else : ?>

		<h2 class="center">No posts found. Try a different search?</h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>

	</div>

</div>
<div id="sidebar">
<?php get_sidebar(); ?>
</div>
<br class="clear"/>
</div>

<?php get_footer(); ?>