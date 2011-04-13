<?php
/*
Plugin Name: Debug Queries
Plugin URI: http://bueltge.de/wordpress-performance-analysieren-plugin/558/
Description: List query-actions only for admins; for debug purposes
Author: Frank B&uuml;ltge
Author URI: http://bueltge.de/
Version: 1.0.0
License: GPL
Last Change: 01.12.2010 16:00:51
*/

//avoid direct calls to this file, because now WP core and framework has been used
if ( !function_exists('add_action') ) {
	header('Status: 403 Forbidden');
	header('HTTP/1.1 403 Forbidden');
	exit();
}

if ( function_exists('add_action') ) {
	//WordPress definitions
	if ( !defined('WP_CONTENT_URL') )
		define('WP_CONTENT_URL', get_option('siteurl') . '/wp-content');
	if ( !defined('WP_CONTENT_DIR') )
		define('WP_CONTENT_DIR', ABSPATH . 'wp-content');
	if ( !defined('WP_PLUGIN_URL') )
		define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');
}

// disable mySQL Session Cache
define( 'QUERY_CACHE_TYPE_OFF', true );

if ( !defined('SAVEQUERIES') )
	define('SAVEQUERIES', true);

if ( !class_exists('DebugQueries') ) {
	class DebugQueries {
		
		// constructor
		function DebugQueries() {
			
			if ( function_exists('register_activation_hook') )
				register_activation_hook(__FILE__, array(&$this, 'activate') );
			if ( function_exists('register_uninstall_hook') )
				register_uninstall_hook(__FILE__, array(&$this, 'deactivate') );
			if ( function_exists('register_deactivation_hook') )
				register_deactivation_hook(__FILE__, array(&$this, 'deactivate') );
				
			add_action( 'wp_head', array(&$this, 'wp_head') );
			add_action( 'wp_footer', array(&$this, 'the_fbDebugQueries') );
		}

		// core
		function get_fbDebugQueries() {
			global $wpdb;
			
			// disabled session cache of mySQL
			if ( QUERY_CACHE_TYPE_OFF )
				$wpdb->query( 'SET SESSION query_cache_type = 0;' );
			
			$debugQueries  = '';
			if ($wpdb->queries) {
				$x = 0;
				$total_time = timer_stop( false, 22 );
				$total_query_time = 0;
				$class = ''; 
				$debugQueries .= '<ol>' . "\n";
				
				foreach ($wpdb->queries as $q) {
					if ( $x % 2 != 0 )
						$class = '';
					else
						$class = ' class="alt"';
					$q[0] = trim( ereg_replace('[[:space:]]+', ' ', $q[0]) );
					$total_query_time += $q[1];
					$debugQueries .= '<li' . $class . '><strong>' . __('Time:') . '</strong> ' . $q[1];
					if ( isset($q[1]) )
						$debugQueries .= '<br /><strong>' . __('Query:') . '</strong> ' . htmlentities( $q[0] );
					if ( isset($q[2]) )
						$debugQueries .= '<br /><strong>' . __('Call from:') . '</strong> ' . htmlentities( $q[2] );
					$debugQueries .= '</li>' . "\n";
					$x++;
				}
				
				$debugQueries .= '</ol>' . "\n\n";
			}
			
			$php_time = $total_time - $total_query_time;
			// Create the percentages
			$mysqlper = number_format_i18n( $total_query_time / $total_time * 100, 2 );
			$phpper   = number_format_i18n( $php_time / $total_time * 100, 2 );
			
			$debugQueries .= '<ul>' . "\n";
			$debugQueries .= '<li><strong>' . __('Total query time:') . ' ' . number_format_i18n( $total_query_time, 5 ) . __('s for') . ' ' . count($wpdb->queries) . ' ' . __('queries.') . '</strong></li>';
			if ( count($wpdb->queries) != get_num_queries() ) {
				$debugQueries .= '<li><strong>' . __('Total num_query time:') . ' ' . timer_stop() . ' ' . __('for') . ' ' . get_num_queries() . ' ' . __('num_queries.') . '</strong></li>' . "\n";
				$debugQueries .= '<li class="none_list">' . __('&raquo; Different values in num_query and query? - please set the constant') . ' <code>define(\'SAVEQUERIES\', true);</code>' . __('in your') . ' <code>wp-config.php</code></li>' . "\n";
			}
			if ( $total_query_time == 0 )
				$debugQueries .= '<li class="none_list">' . __('&raquo; Query time is null (0)? - please set the constant') . ' <code>SAVEQUERIES</code>' . ' ' . __('at') . ' <code>TRUE</code> ' . __('in your') . ' <code>wp-config.php</code></li>' . "\n";
			$debugQueries .= '<li>' . __('Page generated in'). ' ' . number_format_i18n( $total_time, 5 ) . __('s, ') . $phpper . __('% PHP') . ', ' . $mysqlper . __('% MySQL') . '</li>' . "\n";
			$debugQueries .= '</ul>' . "\n";
			
			return $debugQueries;
		}

		// echo in html-comment
		function fbDebugQueries() {
			
			if ( !current_user_can('DebugQueries') )
				return;
			
			$echo 	= '';
			$echo .= "\n\n" . __('<!-- Debug Queries by Frank Bueltge, bueltge.de');
			$echo .= "\n\t" . __('! Deactivate after analysis !');
			$echo .= "\n" . $this->get_fbDebugQueries() . "\n" . ' -->' . "\n\n";
			
			echo $echo;
		}
		
		// echo in frontend
		function the_fbDebugQueries() {
			
			if ( !current_user_can('DebugQueries') )
				return;
			
			$echo 	= '';
			$echo .= '<div id="debugqueries" class="transparent">' . "\n";
			$echo .= '<h3><a href="http://bueltge.de/wordpress-performance-analysieren-plugin/558/">Debug Queries</a> ' . __('by Frank B&uuml;ltge') . ', <a href="http://bueltge.de/">bueltge.de</a></h3>' . "\n";
			$echo .= '<p>' . __('&raquo; Deactivate after analysis!'). '</p>' . "\n";
			$echo .= $this->get_fbDebugQueries();
			$echo .= '</div>' . "\n\n";
			
			echo $echo;
		}
		
		// add user rights
		function activate() {
			global $wp_roles;
			
			$wp_roles->add_cap('administrator', 'DebugQueries');
		}
		
		// delete user rights
		function deactivate() {
			global $wp_roles;
			
			$wp_roles->remove_cap('administrator', 'DebugQueries');
		}
		
		// function for WP < 2.8
		function plugins_url($path = '', $plugin = '') {
			if ( function_exists('is_ssl') )
				$scheme = ( is_ssl() ? 'https' : 'http' );
			else
				$scheme = 'http';
			$url = WP_PLUGIN_URL;
			if ( 0 === strpos($url, 'http') ) {
				if ( function_exists('is_ssl') && is_ssl() )
					$url = str_replace( 'http://', "{$scheme}://", $url );
			}
		
			if ( !empty($plugin) && is_string($plugin) )
			{
				$folder = dirname(plugin_basename($plugin));
				if ('.' != $folder)
					$url .= '/' . ltrim($folder, '/');
			}
		
			if ( !empty($path) && is_string($path) && strpos($path, '..') === false )
				$url .= '/' . ltrim($path, '/');
		
			return apply_filters('plugins_url', $url, $path, $plugin);
		}
		
		// infos in frontend, add css to head
		function wp_head() {
			global $wp_version;
			
			if ( !current_user_can('DebugQueries') )
				return;
				
			if ( version_compare( $wp_version, '2.8dev', '>' ) )
				$style = plugins_url('css/style-frontend.css', __FILE__);
			else
				$style = $this->plugins_url('css/style-frontend.css', __FILE__);
			
			$return = '<link rel="stylesheet" href="' . $style . '" type="text/css" media="screen" />';
			
			echo $return;
		}
		
	}
	
	$DebugQueries = new DebugQueries();
}

?>
