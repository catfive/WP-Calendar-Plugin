<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?></title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<!--[if lte IE 7]>
<link rel="stylesheet" href="/wp-content/themes/SD54/ie.css" type="text/css" media="screen" />
<![endif]-->
<link rel="stylesheet" href="http://sd54.org/wp-content/themes/MasterSubsite/js/fancybox/jquery.fancybox-1.3.1.css" type="text/css" media="screen" /> 
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<style type="text/css" media="screen"></style>

<?php wp_head(); ?>

</head>
<body>

<div id="header">
<div class="wrap">
	<div id="sdlogo"></div>
			<ul class="topleft">
			<li>
				<a href="http://sd54.org">SD54</a>
			</li>
			<li>&raquo;<a href="/"> Addams</a></li> 
			<?php if ( !is_main_site() ):?>
				<li>&raquo;<a href="<?php bloginfo('url')?>"> <?php bloginfo('name');?></a></li> 
			<?php endif;?>
		</ul>
		<ul class="topright">
		<li><a href='http://sd54.org/virtualbackpack'>Virtual Backpack</a></li>
		<li><a href='http://sd54.org/schoolcancellations/'>School Closings</a></li>
		<li><a href='http://www.applitrack.com/sd54/onlineapp/'>Job Openings</a></li> 
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
    	    	switch_to_blog( 10 );
				$menus = get_terms( 'nav_menu', array( 'hide_empty' => true, 'orderby' => 'none' ) );
				foreach ( $menus as $menu ):      
            ?>
              		<ul class="school-menu">
						<a href="#" class="school-menu-title"><?php echo $menu->name; ?></a>	
              			<?php wp_nav_menu(array('menu' => $menu));?>
              		</ul>
            	
            	<?php endforeach; ?>

    	    	<?php restore_current_blog();
    	    
    	else:
 
    	   	$menus = get_terms( 'nav_menu', array( 'hide_empty' => true, 'orderby' => 'none' ) );
           	 
            foreach ( $menus as $menu ): 
            ?>
             
              	<ul class="school-menu">
					<a href="#" class="school-menu-title"><?php echo $menu->name; ?></a>	
              		<?php wp_nav_menu(array('menu' => $menu));?>
              	</ul>
             <?php endforeach;
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
				<h1 class="blogtitle"><a href="<?php bloginfo('url');?>"><?php bloginfo('name');?></a></h1>
		
				<div class="breadcrumb">
					<?php if(function_exists('bcn_display')){ bcn_display();}?>
				</div>	 
				
				<h3 class="contact"><a href="mailto:<?php bloginfo('admin_email');?>"><?php bloginfo('admin_email');?></a> // <?php bloginfo('description');?></h3>
			<br class="clear"/>
			<?php else:?>
			<div class="lgbreadcrumb">
					<?php if (!is_home()) {if(function_exists('bcn_display')){ bcn_display();}}?>
			</div>	
			
			<?php endif;?>
		</div>			
	</div>