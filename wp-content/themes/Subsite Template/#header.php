<!-- Muir header -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
<!--[if lt IE 7]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta3)/IE9.js"></script>
<link rel="stylesheet" href="/wp-content/themes/SD54/ie.css" type="text/css" media="screen" />
<![endif]-->
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<style type="text/css" media="screen"></style>
<script type="text/javascript" src="http://sd54.org/wp-content/themes/SD54/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="http://sd54.org/wp-content/themes/MasterSubsite/js/quicksearch.js"></script>
<script type="text/javascript" src="http://sd54.org/wp-content/themes/MasterSubsite/js/menu.js"></script>


<?php wp_head(); ?>
</head>
<body>



<div id="header">
<div class="wrap">
<!-- 		<div id="sdlogo"></div> -->
			<ul class="topleft">
			<li>
				<a href="http://sd54.org">SD54</a>
			</li>
			<li>&raquo;<a href="/"> Muir</a></li> 
			<?php if ( !is_main_site() ):?>
				<li>&raquo;<a href="/"> <?php bloginfo('name');?></a></li> 
			<?php endif;?>
		</ul>
		<ul class="topright">
		<li><a href=''>Virtual Backpack</a></li>
		<li><a href=''>School Closings</a></li>
		<li><a href=''>Job Openings</a></li> 
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		</ul>
		</div>
</div>

	<div id="mainmenu">
		<div class="wrap">
			<div id="picture"></div>
				<a href="/"><div id="logo"></div></a>

				<div id="schoolmenu">
				<?php
				
				if (!is_main_site()):?>
				
					<?php
					
					switch_to_blog( 4 );
					?>
					<ul class="school-menu">
					<a href="#" class="school-menu-title">About</a>				
					<?php wp_nav_menu(array('menu' => 'About' ));?>
					</ul>
					<ul class="school-menu">
					<a href="#" class="school-menu-title">Student Learning</a>
					<?php wp_nav_menu(array('menu' => 'Student Learning' ));?>
					</ul>
					<ul class="school-menu">
					<a href="#" class="school-menu-title">Family Resources</a>
					<?php wp_nav_menu(array('menu' => 'Family Resources' ));?>
					</ul>
					<ul class="school-menu">
					<a href="#" class="school-menu-title">Activities</a>
					<?php wp_nav_menu(array('menu' => 'Activities' ));?>
					</ul>
					
					<?php restore_current_blog();					
						else:
							dynamic_sidebar( 'main-menu' );  
						endif;
					?>
				</div>
		</div>	
	</div>


<div id="slideshow">

</div>
<div class="wrap">
	<div id="contentheader">
		<div id="bloginfo">
			<?php if (!is_main_site()):?>		
			
				<h1 class="blogtitle"><?php bloginfo('name');?></h1>
				<h3 class="contact"><a href="mailto:<?php bloginfo('admin_email');?>"><?php bloginfo('admin_email');?></a> // <?php bloginfo('description');?></h3>
				<br class="clear"/>
				  				
			<?php endif;?>
		</div>			
		<div id="headerimage">
			<?php
			// Retrieve the dimensions of the current post thumbnail -- no teensy header images for us!
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'post-thumbnail');
			list($src, $width, $height) = $image;
			
			// Check if this is a post or page, if it has a thumbnail, and if it's a big one
			if ( is_singular() && has_post_thumbnail( $post->ID ) && $width >= HEADER_IMAGE_WIDTH ) :		
			    // Houston, we have a new header image!
			    echo get_the_post_thumbnail( $post->ID, 'post-thumbnail' );
			else : ?>
			    <img src="<?php header_image(); ?>" width="<?php echo HEADER_IMAGE_WIDTH; ?>" height="<?php echo HEADER_IMAGE_HEIGHT; ?>" alt="" />
			<?php endif; ?>
		</div>		
