<?php

// lots of front end functions? consider compartmentalizing admin:
// if ( is_admin() ) require_once('functions_admin.php');

if ( is_admin() ) : // why execute all the code below at all if we're not in admin?

add_action( 'login_head', 'custom_login_css' );

function custom_login_css() 
{
	echo '<link rel="stylesheet" href="https://sd54.org/wp-content/themes/SD54/admin.css" type="text/css" media="all" />'; 
}
/**************************/
/*** PART ONE: BRANDING ***/
/**************************/
 
/**
 * call in custom admin stylesheet - this will be global for admin and also login
 */
 
add_action( 'admin_print_styles', 'load_custom_admin_css' );

function load_custom_admin_css()
{
	wp_enqueue_style( 'custom_admin_css', '/wp-content/themes/SD54/admin.css' );
} 

/**
 * cleaning up and customizing the dashboard
 */
 
add_action('wp_dashboard_setup', 'custom_dashboard_widgets');

function custom_dashboard_widgets() {
	global $wp_meta_boxes;
	
	// remove unnecessary widgets
	//var_dump( $wp_meta_boxes['dashboard'] ); // use to get all the widget IDs
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	
	//custom dashboard widgets
	//wp_add_dashboard_widget('dashboard_custom_feed', 'News from C. Murray Consulting', 'dashboard_custom_feed_output'); //add new rss feed output
}

/*
function dashboard_custom_feed_output()
{
	echo '<div class="rss-widget">';
	wp_widget_rss_output(array(
		'url' => 'http://www.cmurrayconsulting.com/feed',
		'title' => 'New at C. Murray Consulting',
		'items' => 2,
		'show_summary' => 1,
		'show_author' => 0,
		'show_date' => 1 
	));
	echo "</div>";	
}
*/


/***********************************/
/*** PART TWO: CLEANING UP ADMIN ***/
/***********************************/

/**
 * custom "admin lite" role
 * we want an editor that can also: manage users, manage plugins, unfiltered upload, manage options
 */

// remove_role( 'adminlite' );

if ( !get_role('adminlite') )
{
	$caps = get_role('editor')->capabilities; //let's use the editor as the base  capabilities
	$caps = array_merge( $caps, array(
		'unfiltered_upload' => true,
		'edit_theme_options' => true //wp3.0
	)); //adding new capabilities: reference http://codex.wordpress.org/Roles_and_Capabilities#Capability_vs._Role_Table
	
	add_role( 'adminlite', 'Administrator Lite', $caps );
}


/**
 * let's eliminate some sidebar widgets we know the client will never use
 */
 
add_action( 'widgets_init', 'custom_remove_widgets' );

function custom_remove_widgets() 
{
	unregister_widget( 'WP_Widget_Meta' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Widget_bcn_widget' );
}


/**
 * trim down page and post meta boxes to the basics... except for full admins
 */

if ( !current_user_can('manage_options') ) { add_action('admin_init','customize_page_meta_boxes');  }

function customize_page_meta_boxes() 
{
	remove_meta_box('postcustom','page','normal');
	remove_meta_box('postcustom','post','normal');
	remove_meta_box('commentstatusdiv','page','normal');
	remove_meta_box('commentstatusdiv','post','normal');
	remove_meta_box('trackbacksdiv','post','normal');
	remove_meta_box('postexcerpt','post','normal');				 
	remove_meta_box('trackbacksdiv','post','normal');			  	
	remove_meta_box('commentsdiv','post','normal');
}

endif; //wrapper for admin functions

if ( ! function_exists( 'twentyten_init' ) ) :
/**
 * Set up defaults for our theme.
 *
 * Sets up theme defaults and tells wordpress that this is a
 * theme that will take advantage of Post Thumbnails, Custom
 * Background, Nav Menus and automatic feed links.  To
 * override any of the settings in a child theme, create your
 * own twentyten_init function
 *
 * @uses add_theme_support()
 */
function twentyten_init() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
/* 	add_editor_style(); */

	// This theme needs post thumbnails
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu()
	add_theme_support( 'nav-menus');
	
	function register_my_menus() {
register_nav_menus(
array(
'header-menu' => __( 'Header Menu' ),
'extra-menu' => __( 'Extra Menu' ))
);
}
add_action( 'init', 'register_my_menus' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'twentyten', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// Your Changeable header business starts here
	// No CSS, just IMG call
	define( 'HEADER_TEXTCOLOR', '' );
	define( 'HEADER_IMAGE', 'http://addams.sd54.org/wp-content/themes/Subsite Template/images/defaultheader.jpg' ); // %s is theme dir uri

	// Add a filter to twentyten_header_image_width and twentyten_header_image_height to change these values
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'twentyten_header_image_width',  940 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'twentyten_header_image_height',	310 ) );
	define( 'NO_HEADER_TEXT', true );
	
		// We'll be using them for custom header images on posts and pages
	// so we want them to be 940 pixels wide by 198 pixels tall (larger images will be auto-cropped to fit)
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	add_custom_image_header( '', 'twentyten_admin_header_style' );
	// and thus ends the changeable header business

}
endif;
add_action( 'after_setup_theme', 'twentyten_init' );

if ( ! function_exists( 'twentyten_admin_header_style' ) ) :
/**
 * Callback to style the header image inside the admin
 */
function twentyten_admin_header_style() {
?>
<style type="text/css">
#headimg {
	height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
	width: <?php echo HEADER_IMAGE_WIDTH; ?>px;
}
#headimg h1, #headimg #desc {
	display: none;
}
</style>
<?php
}
endif;

if ( ! function_exists( 'twentyten_widgets_init' ) ) :
/**
 * Register widgetized areas
 *
 * @uses register_sidebar
 */
function twentyten_widgets_init() {

		register_sidebar( array (
		'name' => 'Sidebar',
		'id' => 'home-sidebar',
		'description' => __( 'Appears throughout your site' , 'twentyten' ),
		'before_widget' => '<div class="box">',
		'after_widget' => "</div>",
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
}
endif;

add_action( 'init', 'twentyten_widgets_init' );

add_shortcode("trigger", "slideController");
function slideController($atts, $content = null)
{
	extract(
		shortcode_atts(
			array("number" => '0'), $atts)
	);
	
	return '<a href="#" class="collapse slider'.$number.'">'.$content.'</a>';
}

add_shortcode("slider", "divSlider");

function divSlider($atts, $content = null)
{
	extract(
		shortcode_atts(
			array(
				"start" => 'closed',
				"number" => '0',
				), 
			$atts
		)			
	);
	
	
	$slidereturn = '<div id="slider'.$number.'" class="collapse"><p>'.$content.'</p><a href="#" class="collapse slider'.$number.'">Close section</a></div><br/>';
	return $slidereturn;
}

add_shortcode("infobox", "infoBox");

function infoBox($atts, $content = null)
{
	extract(
		shortcode_atts(
			array(), 
			$atts
		)			
	);
	
	
	$infobox = '<div id="infobox">'.$content.'</div>';
	return do_shortcode($infobox);
}

add_shortcode("filter", "quickSearch");

function quickSearch()
{

	
	$quicksearch = true;
	
	$searchform = '<h2>Filter</h2>
	<form>
		<input type="text" id="search"/>
		<input type="reset" id="reset"/>
	</form>';
	
	return $searchform;

}

add_shortcode("anchor", "anchorLink");

function anchorLink($atts, $content = null)
{
	extract(
		shortcode_atts(
			array(
			"name" => 'null',
			), 
			$atts
		)			
	);
	
	
	$anchor = '<a name="'.$name.'" style="border-bottom:none">'.$content.'</a>';
	return $anchor;
}

add_shortcode('map', 'mapFrame');

function mapFrame($atts)
{
	extract(
		shortcode_atts(
			array(
			"url" => 'null',
			), 
			$atts
		)			
	);

$map_iframe = '<p><iframe style=" margin-left:10px; float:right" width="350" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$url.'&amp;output=embed"></iframe></p>';


return $map_iframe;
}

add_shortcode('video', 'embedFunc');

function embedFunc($atts, $content){
	extract(shortcode_atts(array(
		'width' => '620',
		'height' => '377',
		'src' => '',
	), $atts));
	
   return '<object width="'.$width.'" height="'.$height.'" id="videoPlayer" name="videoPlayer" type="application/x-shockwave-flash"><param name="movie" value="http://fms01.sd54.k12.il.us/swfs/videoPlayer.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /> <param name="allowfullscreen" value="true" /> <param name="flashvars" value= "&videoWidth=0&videoHeight=0&dsControl=manual&dsSensitivity=100&serverURL='.$src.'&DS_Status=true&streamType=vod&autoStart=false"/><embed src="http://fms01.sd54.k12.il.us/swfs/videoPlayer.swf" width="'.$width.'" height="'.$height.'" id="videoPlayer" quality="high" bgcolor="#ffffff" name="videoPlayer" allowfullscreen="true" pluginspage="http://www.adobe.com/go/getflashplayer" flashvars="&videoWidth=0&videoHeight=0&dsControl=manual&dsSensitivity=100&serverURL='.$src.'&DS_Status=true&streamType=vod&autoStart=false" type="application/x-shockwave-flash"> </embed></object>';
}
?>