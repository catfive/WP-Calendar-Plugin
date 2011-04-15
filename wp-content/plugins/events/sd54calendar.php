<?php
/*
Plugin Name: District Event Calendar
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: The Plugin's Version Number, e.g.: 1.0
Author: John Rork
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/
//load calendar javascript
add_action('wp_print_styles', 'load_calendar_css');
add_action( 'admin_print_styles', 'load_calendar_css' );

function load_calendar_css()
{
	wp_enqueue_style( 'custom_admin_css', '/wp-content/plugins/events/calendar.css' );
} 
add_action( 'admin_init', 'my_plugin_admin_init' );
function my_plugin_admin_init() {
        /* Register our script. */
        // wp_register_script( 'myPluginScript', WP_PLUGIN_URL . '/myPlugin/script.js' );
        wp_enqueue_script('jquery');
        wp_register_script( 'myPluginScript', plugins_url('events.js', __FILE__), array('jquery') );
        wp_register_script('datejs', plugins_url('date.js', __FILE__));
        wp_enqueue_script( 'myPluginScript' );
        wp_enqueue_script('datejs');
    }

//url arguments allowing year/month permalinks
add_filter('query_vars', 'add_my_var');
function add_my_var($public_query_vars) {
	$public_query_vars[] = 'calendaryear';
	$public_query_vars[] = 'calendarmonth';
	return $public_query_vars;
}

//rewrite rules to pretty up year/month variables
function do_rewrite() {
    add_rewrite_rule('events/([0-9]+)/?([0-9]+)?/?$', 'index.php?pagename=events&calendaryear=$matches[1]&calendarmonth=$matches[2]','top');
}
add_action('init', 'do_rewrite');
add_action('init', 'load_calendar_script');
function load_calendar_script(){
	wp_register_script('calendarScript', plugins_url('cal.js', __FILE__), array('jquery'));
	wp_enqueue_script('calendarScript');
}
//create the "Event" post type
add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'events',
    array(
      'labels' => array(
      	'name' => __( 'Events' ),
        'singular_name' => __( 'Event' )
      ),
      'public' => true,
      'menu_position' => 20,
      '_builtin' => false,
      'rewrite' => true,
      'show_ui' => true,
	  'capability_type' => 'post',
	  'hierarchical' => false,
	  'query_var' => false,
	  'supports' => array('title', 'editor', 'custom-fields')
    )
  );
  
//create the "Calendars" taxonomy
register_taxonomy( 'calendars', 'events', array( 'hierarchical' => true, 'label' => __('Calendars') ) );
}

//redirect to the event page template when looking at an event type post
add_action("template_redirect", 'my_template_redirect');
function my_template_redirect()
{
    global $wp;
    global $wp_query;
    if ($wp->query_vars["post_type"] == "events")
    {
        // Let's look for the property.php template file in the current theme
        if (have_posts())
        {
            include(TEMPLATEPATH . '/event.php');
            die();
        }
        else
        {
            $wp_query->is_404 = true;
        }
    }
}

//this supposedly adds events to rss
function myfeed_request($qv) {
    if (isset($qv['feed']))
        $qv['post_type'] = get_post_types();
    return $qv;
}
add_filter('request', 'myfeed_request');

//this makes it easy to add custom fields
if ( !class_exists('myCustomFields') ) {

	class myCustomFields {
		/**
		* @var  string  $prefix  The prefix for storing custom fields in the postmeta table
		*/
		var $prefix = 'event_';
		/**
		* @var  array  $customFields  Defines the custom fields available
		*/
		var $customFields =	array(
			array(
				"name"	 => "date_start",
				"title"	 => "From: ",
				"description"	=> "",
				"type"	 => "default",
				"scope"	 => array( "post" ),
				"capability"	=> "edit_posts",
				"colspan" => 2
				),
			array(
				"name"	 => "time_start",
				"title"	 => "",
				"description"	=> "",
				"type"	 => "default",
				"scope"	 => array( "post" ),
				"capability"	=> "edit_posts"
				),
			array(
				"name"	 => "date_end",
				"title"	 => "To: ",
				"description"	=> "",
				"type"	 => "default",
				"scope"	 => array( "post" ),
				"capability"	=> "edit_posts"
				),
			array(
				"name"	 => "time_end",
				"title"	 => "",
				"description"	=> "",
				"type"	 => "default",
				"scope"	 => array( "post" ),
				"capability"	=> "edit_posts"
				),
			array(
				"name"	 => "location",
				"title"	 => "Location: ",
				"description"	=> "",
				"type"	 => "default",
				"scope"	 => array( "post" ),
				"capability"	=> "edit_posts",
				"colspan"	=>	2
				),
			array(
				"name"	=>	"repeats",
				"title"	=>	"Repeat",
				"description"	=>	"",
				"type"	=>	"checkbox",
				"class"	=>	"showrepeatops",	
				"scope"	 => array( "post" ),
				"capability"	=> "edit_posts"
			),
			array(
				"name"	 => "repeat_interval",
				"title"	 => "Every:",
				"description" => "",
				"type"	 => "default",
				"scope"	 => array( "post" ),
				"capability"	=> "edit_posts",
				"class"	=>	"repeating"
				),
			array(
				"name"	 => "repeat_unit",
				"title"	 => "",
				"id" => "repeatunit",
				"description" => "",
				"options"	 => array( "day(s)", "week(s)", "month(s)"),
				"type"	 => "dropdown",
				"scope"	 => array( "post" ),
				"capability"	=> "edit_posts",
				"class"	=> "repeating"
				),
			array(
				"name"	 => "repeat_on",
				"title"	 => "On:",
				"description" => ""  ,
				"options"	 => array( "same weekday", "same date"),
				"type"	 => "dropdown",
				"scope"	 => array( "post" ),
				"capability"	=> "edit_posts",
				"class"	=> "month",
				"colspan" => 2				
			),
			array(
				"name"	 => "repeat_exclude",
				"title"	 => "Except On:",
				"id" => "repeatexclude",
				"description" => "",
				"options"	 => '',
				"type"	 => "default",
				"scope"	 => array( "post" ),
				"capability"	=> "edit_posts",
				"class"	=> "repeating",
				),
			array(
				"name"	 => "repeat_stop",
				"title"	 => "Stop On:",
				"id" => "repeatstop",
				"description" => "",
				"options"	 => '',
				"type"	 => "default",
				"scope"	 => array( "post" ),
				"capability"	=> "edit_posts",
				"class"	=> "repeating",
				),
		);
		/**
		* PHP 5 Constructor
		*/
		function __construct() {
			add_action( 'admin_menu', array( &$this, 'createCustomFields' ) );
			add_action( 'save_post', array( &$this, 'saveCustomFields' ), 1, 2 );
			// Comment this line out if you want to keep default custom fields meta box
			add_action( 'do_meta_boxes', array( &$this, 'removeDefaultCustomFields' ), 10, 3 );
		}
		/**
		* Remove the default Custom Fields meta box
		*/
		function removeDefaultCustomFields( $type, $context, $post ) {
			foreach ( array( 'normal', 'advanced', 'side' ) as $context ) {
				remove_meta_box( 'postcustom', 'events', $context );
				//Use the line below instead of the line above for WP versions older than 2.9.1
				//remove_meta_box( 'pagecustomdiv', 'page', $context );
			}
		}
		/**
		* Create the new Custom Fields meta box
		*/
		function createCustomFields() {
			if ( function_exists( 'add_meta_box' ) ) {
				add_meta_box( 'my-custom-fields', 'Event Details', array( &$this, 'displayCustomFields' ), 'events', 'normal' );
			}
		}
		/**
		* Display the new Custom Fields meta box
		*/
		function displayCustomFields() {
			global $post;
			?>
			<div class="form-wrap">
			<div class="form-field form-required">				
				<?php wp_nonce_field( 'my-custom-fields', 'my-custom-fields_wpnonce', false, true );?>
				<div id="eventhelp">
					<p>A start ("From") date is required. To choose a date, type in the box or click a date on the calendar below.</p>
					<p>While entering information in an additional field, others may activate to show they are also necessary (e.g. an end time cannot be specified without a start time).</p>
					<p>To unset any field, simply clear it.</p>
					<p>Monthly repeat allows a choice of day of week or date of month, e.g. every "Wednesday" or every "12th," respectively.</p>
					<p>Click the help link to close this box.</p>
				</div>
				<a href="javascript:;" id="eventhelp">Help</a>
				<input id="dbeventstart" type="hidden" value=""/>
				<input id="dbeventend" type="hidden" value=""/>
			
				<table id="eventoptions" >
					<tr style="display:none">
					<?php
					foreach ( $this->customFields as $customField ):
						// Check scope
						$scope = $customField[ 'scope' ];
						$output = false;
						foreach ( $scope as $scopeItem ) {
							switch ( $scopeItem ) {
								case "post": {
									// Output on any post screen
									if ( basename( $_SERVER['SCRIPT_FILENAME'] )=="post.php" || $post->post_type=="events" )
										$output = true;
									break;
								}
							}
							if ( $output ) break;
						}
						// Check capability
						if ( !current_user_can( $customField['capability'], $post->ID ) )
							$output = false;
						// Output if allowed
						if ( $output ):
								switch ( $customField[ 'type' ] ):
									case "checkbox":?>
										</tr>
										<tr>
											<td class="<?php echo $customField['class'] ?>">
												<label for="<?php echo $this->prefix . $customField[ 'name' ] ?>" style="display:inline;">
													<strong><?php echo $customField[ 'title' ] ?></strong>
												</label>
											</td>
											<td>
												<input class="<?php echo $customField['class'] ?>" 
													type="checkbox" 
													name="<?php echo $this->prefix . $customField['name'] ?>" 
													id="<?php echo $this->prefix . $customField['name'] ?>"
													<?php if ( get_post_meta( $post->ID, $this->prefix . $customField['name'], true ) == "on" )
														echo ' checked="checked"';?>
												/>
											</td>
											<td></td>
										<?php 
										break;
									
									case "dropdown": 
										// dropdown						
										if (!empty($customField['title'])):?>
											</tr>
											<tr>
												<td valign="top" style="padding-top:5px" class="<?php echo $customField['class']?>">
													<label for="<?php echo $this->prefix . $customField[ 'name' ]?>" style="display:inline;">
														<b><?php echo $customField[ 'title' ]?></b>
													</label>
												</td>
										<?php endif; ?>
										<td class="<?php echo $customField['class']?>" colspan=<?php echo $customField['colspan']?>>
											<select name="<?php echo $this->prefix . $customField['name']?>" 
													id="<?php echo $this->prefix . $customField['name']?>">
										
											<?php foreach($customField['options'] as $cfOption):?>
												<option <?php //<--unclosed intentionally to allow room for 'selected'
													//if the event already has info, select it in the menu
													if (get_post_meta( $post->ID, $this->prefix . $customField['name'], true) == rtrim($cfOption,')s(')){
														echo ' selected ';
													}																	
													if (($customField['name'] == "date_end_month")||($customField['name'] == "date_start_month")) {echo '>' . date('F', mktime(0, 0, 0, $cfOption , 1, date('Y'))) . '</option>';}		
													else echo 'value = "' . rtrim($cfOption, '\)s\(') . '">' . $cfOption. '</option>';
													?>
																			
											<?php endforeach;?>
											</select>
										</td>
										<td id="<?php echo $customField['name'].'details'?>"</td>
										<input type="hidden" id="repeat_on_description" name="repeat_on_description" value="" /> 
										<?php if (!empty($customField['description'])):?>
											</tr><tr><td></td><td colspan=colspan=<?php echo $customField['colspan']?> class="<?php echo $customField['class']?>"><p><?php echo $customField['description']?></p></td>
										 <?php
										 endif;
										 break;
									
									default: 
										// Plain text field
										if (!empty($customField['title'])):?>
										</tr>
										<tr>
											<td class="<?php echo $customField['class']?>">
												<label style="display:inline;" for="<?php echo $this->prefix . $customField[ 'name' ]?>">
													<strong><?php echo $customField[ 'title' ]?></strong>
												</label>
											</td>
										<?php endif; ?>
											<td class="<?php echo $customField['class'] ?>">
												<input type="text" style="width:80px" 
													name="<?php if($customField[ 'name' ] != 'repeat_exclude') echo $this->prefix . $customField[ 'name' ] ?>" 
													id="<?php echo $this->prefix . $customField[ 'name' ] ?>"
													value="<?php if ($value = get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ))
														if ( $customField['name'] == "date_start" || $customField['name'] == "date_end" || $customField['name'] == 'repeat_stop')  $value = date('n/j/Y', $value);
														if ($customField[ 'name' ] != 'repeat_exclude') echo  htmlspecialchars( $value );?>"
												/>
											</td>
										<?php if ($customField['name'] == 'repeat_exclude'):?>
											<td> <a id="add_exclusion" href="javascript:;" class="button">+</a> <a id="remove_exclusion" href="javascript:;" class="button">&minus;</a></td>
											</tr><tr>
												<td></td>
												<td class="repeating" colspan="2">
													<select id="event_repeat_exclusions" name="event_repeat_exclude[]" multiple="multiple">
														<?php
														if($exclusions = unserialize(get_post_meta( $post->ID, 'event_repeat_exclude', true ))){
															foreach($exclusions as $exclusion){
																echo "<option value='$exclusion'>".date('m/d/y', $exclusion)."</option>";
															}
														}
														?>
													</select>
												</td>
											</tr>
										<?php endif; ?>
										<?php
										break;					
								endswitch;
						endif;
					endforeach; ?>
				</table>
					<div id="minical"></div>
				</div>
			</div>
			<?php
		}
		/**
		* Save the new Custom Fields values
		*/
		function saveCustomFields( $post_id, $post ) {
			if ( !wp_verify_nonce( $_POST[ 'my-custom-fields_wpnonce' ], 'my-custom-fields' ) )
				return;
			if ( !current_user_can( 'edit_post', $post_id ) )
				return;
			foreach ( $this->customFields as $customField ) {
				if ( current_user_can( $customField['capability'], $post_id ) ) {

					if (!is_array($_POST[ $this->prefix . $customField['name'] ]) && isset( $_POST[ $this->prefix . $customField['name'] ] ) && trim( $_POST[ $this->prefix . $customField['name'] ] )){ 
						if($customField['name'] == 'repeat_stop'){
							$value = strtotime($_POST[ $this->prefix . $customField['name'] ]);
						}
						elseif ($customField['name'] == 'date_start'){
							$value = $_POST[ $this->prefix . $customField['name'] ]; 
							if (isset($_POST['event_time_start']) && trim($_POST['event_time_start'])) $value .=' ' . $_POST[ 'event_time_start' ];
							$value = strtotime($value);
						}
						elseif ($customField['name'] == 'date_end'){
							$value = $_POST[ $this->prefix . $customField['name'] ];
							if (isset($_POST['event_time_end']) && trim($_POST['event_time_end'])) $value .=' ' . $_POST[ 'event_time_end' ];
							$value = strtotime($value);

						}
						else $value = trim($_POST[ $this->prefix . $customField['name'] ]);
/* 						echo $customField['name'].": $value, post value: ".$_POST[ $this->prefix . $customField['name'] ]."<br>"; */
						update_post_meta( $post_id, $this->prefix . $customField[ 'name' ], $value );
					} 
					elseif($customField['name'] == 'repeat_exclude'){
						$value = serialize($_POST['event_repeat_exclude']);
						update_post_meta( $post_id, $this->prefix . $customField[ 'name' ], $value );
					}	
					else {
						delete_post_meta( $post_id, $this->prefix . $customField[ 'name' ] );
					}
				}
			}
			if (isset($_POST['repeat_on_description'])) update_post_meta( $post_id, $this->prefix . 'repeat_on_description', $_POST['repeat_on_description']);

		}
	} // End Class
} // End if class exists statementma
	
// Instantiate the class
if ( class_exists('myCustomFields') ) {
	$myCustomFields_var = new myCustomFields();
}

add_action("manage_posts_custom_column", "my_custom_columns");
add_filter("manage_edit-events_columns", "my_events_columns");

function my_events_columns($columns)
{
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Event Title",
		"event_date" => "Event Date",
		"event_start_time" => "Start Time",
		"event_end_time" => 'End Time',
		"date" => "Date Created"
	);
	return $columns;
}

function my_custom_columns($column)
{
	global $post;
	if ("ID" == $column) echo $post->ID;
	elseif ("description" == $column) echo $post->post_content;
	elseif ("event_date" == $column) echo date('F d, Y', get_post_meta($post->ID, "event_date_start", true));
	elseif ("event_start_time" == $column) echo date('g:i a', strtotime(get_post_meta($post->ID, "event_time_start", true)));
	elseif ("event_end_time" == $column) echo date('g:i a', strtotime(get_post_meta($post->ID, "event_time_end", true)));
}
?>