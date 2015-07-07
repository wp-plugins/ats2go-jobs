<?php
/*
Plugin Name: ATS2goJobs
Plugin URI: http://www.ats2go.com
Description: Show ATS2go vacancies on your WordPress website! Quick integration with your CMS.
Version: 1.02
Author: ATS2go
Author URI: http://www.ats2go.com
Text Domain: ATS2goJobs
License: GPLv2
*/

define('ATS2GOJOBS_DIR', plugin_dir_path( __FILE__ ) );

/****** functions ******/
require_once(ATS2GOJOBS_DIR.'ATS2goJobs-functions.php');

/****** Shortcodes ******/
require_once(ATS2GOJOBS_DIR.'classes/ATS2goJobs-shortcodes.php');

/****** Settings ******/
require_once(ATS2GOJOBS_DIR.'classes/ATS2goJobs-settings.php');


// ACTIVATE 
if( ! function_exists('ats2gojobs_activate')) {
	function ats2gojobs_activate() {
	}
}

// DEACTIVATE
if( ! function_exists('ats2gojobs_deactivation')) {
	function ats2gojobs_deactivation(){
		// clear scheduled tasks
		wp_clear_scheduled_hook('ats2gojobs_jobs_hook');
	}
}

// UNINSTALL 
if( ! function_exists('ats2gojobs_uninstall')) {
	function ats2gojobs_uninstall() {
		// clear scheduled tasks
		wp_clear_scheduled_hook('ats2gojobs_jobs_hook');
	}
}

// INIT
function ats2gojobs_init() {

	// load language
  $plugin_dir = basename(dirname(__FILE__)) . '/languages';
  load_plugin_textdomain('ATS2goJobs', false, $plugin_dir );
}
add_action('plugins_loaded', 'ats2gojobs_init');


//
// HOOKS

// Install and uninstall
register_activation_hook( __FILE__, 'ats2gojobs_activate'); // activate plugin
register_uninstall_hook( __FILE__, 'ats2gojobs_uninstall'); // uninstall plugin
register_deactivation_hook(__FILE__, 'ats2gojobs_deactivation');	// deactivate plugin

// Hook the job scheduler
add_action ('ats2gojobs_jobs_hook', 'insert_jobs_from_feed');

// Register ats2gojobs post type
add_action('init', 'ats2gojobs_create_post_type'); 
//add_action('wp_loaded', 'insert_jobs_from_feed'); // DEBUG ONLY !


?>