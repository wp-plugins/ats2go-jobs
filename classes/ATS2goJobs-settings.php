<?php

//
// CLASS
//
class ATS2goJobs_Settings {

	static function init() {
	  add_action('admin_init', array(__CLASS__, 'ats2gojobs_init_settings'));
	  add_action('admin_menu' , array(__CLASS__, 'ats2gojobs_create_settings_menu'));
		add_action('admin_notices', array(__CLASS__,'ats2gojobs_settings_notices')); 
	}
	
	//
	// INIT SETTINGS
	function ats2gojobs_init_settings($atts=array()) {

		//
		// GENERAL
		
		// add section
		add_settings_section(
			'ats2gojobs_settings_general',                            // ID used to identify this section and with which to register options
			__('General', 'ATS2goJobs'),                              // Title to be displayed on the administration page
		  array(__CLASS__, 'ats2gojobs_settings_general_callback'), // Callback used to render the description of the section
			'ats2gojobs_settings_general'                             // Page on which to add this section of options
		);
		
		// add field
		add_settings_field( 
			'hs_web_site_id',                                   // ID used to identify the field throughout the theme
			__('Customer ID', 'ATS2goJobs'),                     // The label to the left of the option interface element
			array(__CLASS__, 'ats2gojobs_web_site_id_callback'), // The name of the function responsible for rendering the option interface
			'ats2gojobs_settings_general',          							// The page on which this option will be displayed
			'ats2gojobs_settings_general'           							// The name of the section to which this field belongs
		);
		 
		// add field
		add_settings_field( 
			'hs_feed_update',                        				     // ID used to identify the field throughout the theme
			__('Jobfeed update every', 'ATS2goJobs'),           		 // The label to the left of the option interface element
			array(__CLASS__, 'ats2gojobs_feed_update_callback'),  // The name of the function responsible for rendering the option interface
			'ats2gojobs_settings_general',          							 // The page on which this option will be displayed
			'ats2gojobs_settings_general'                         // The name of the section to which this field belongs
		);
		
		// add field
		add_settings_field( 
			'hs_feed_language',                        					 // ID used to identify the field throughout the theme
			__('Jobfeed language', 'ATS2goJobs'),         				   // The label to the left of the option interface element
			array(__CLASS__, 'ats2gojobs_feed_language_callback'),// The name of the function responsible for rendering the option interface
			'ats2gojobs_settings_general',          							 // The page on which this option will be displayed
			'ats2gojobs_settings_general'                         // The name of the section to which this field belongs
		);
		
		// add field
		add_settings_field( 
			'hs_menuposition',                        				   // ID used to identify the field throughout the theme
			__('Menu position', 'ATS2goJobs'),           	 // The label to the left of the option interface element
			array(__CLASS__, 'ats2gojobs_menuposition_callback'), // The name of the function responsible for rendering the option interface
			'ats2gojobs_settings_general',          							 // The page on which this option will be displayed
			'ats2gojobs_settings_general'                         // The name of the section to which this field belongs
		);

		// add field
		add_settings_field( 
			'hs_ga_cookie',                        				   // ID used to identify the field throughout the theme
			__('GA cookiename', 'ATS2goJobs'),           	 // The label to the left of the option interface element
			array(__CLASS__, 'ats2gojobs_ga_cookie_callback'), // The name of the function responsible for rendering the option interface
			'ats2gojobs_settings_general',          							 // The page on which this option will be displayed
			'ats2gojobs_settings_general'                         // The name of the section to which this field belongs
		);		
		
		// register settings
		register_setting(
			'ats2gojobs_settings_general', // Option group (section)
			'hs_web_site_id'					  	// Option name (field)
		);
		 
		// register settings
		register_setting(
			'ats2gojobs_settings_general', // Option group (section)
			'hs_feed_update'              // Option name (field)
		);
		
		// register settings
		register_setting(
			'ats2gojobs_settings_general', // Option group (section)
			'hs_feed_language'            // Option name (field)
		);
		
		// register settings
		register_setting(
			'ats2gojobs_settings_general', // Option group (section)
			'hs_menuposition'             // Option name (field)
		);

		// register settings
		register_setting(
			'ats2gojobs_settings_general', // Option group (section)
			'hs_ga_cookie'             		// Option name (field)
		);
		
		//
		// DISPLAY
		
		
		// JOBLIST
		add_settings_section(
			'ats2gojobs_settings_joblist',           	  	           // ID used to identify this section and with which to register options
			__('Joblist', 'ATS2goJobs'),															 // Title to be displayed on the administration page
			array(__CLASS__, 'ats2gojobs_settings_joblist_callback'), // Callback used to render the description of the section
			'ats2gojobs_settings_display'           							     // Page on which to add this section of options
		);
		
		add_settings_field( 
			'hs_summaryonjoblist',                                   // ID used to identify the field throughout the theme
			__('Show summary', 'ATS2goJobs'),                         // The label to the left of the option interface element
			array(__CLASS__, 'ats2gojobs_summaryonjoblist_callback'), // The name of the function responsible for rendering the option interface
			'ats2gojobs_settings_display',     	     			           // The page on which this option will be displayed
			'ats2gojobs_settings_joblist'            		  			     // The name of the section to which this field belongs
		);
		
		add_settings_field( 
			'hs_classionjoblist',                                   // ID used to identify the field throughout the theme
			__('Show classifications', 'ATS2goJobs'),                // The label to the left of the option interface element
			array(__CLASS__, 'ats2gojobs_classionjoblist_callback'), // The name of the function responsible for rendering the option interface
			'ats2gojobs_settings_display',     	     			          // The page on which this option will be displayed
			'ats2gojobs_settings_joblist'            		  			    // The name of the section to which this field belongs
		);
		
		add_settings_field( 
			'hs_readmoreonjoblist',                                   // ID used to identify the field throughout the theme
			__('Show "Read more" link', 'ATS2goJobs'),                 // The label to the left of the option interface element
			array(__CLASS__, 'ats2gojobs_readmoreonjoblist_callback'), // The name of the function responsible for rendering the option interface
			'ats2gojobs_settings_display',     	     			            // The page on which this option will be displayed
			'ats2gojobs_settings_joblist'            		  			      // The name of the section to which this field belongs
		);		
		
		
		// JOBDETAIL
		add_settings_section(
			'ats2gojobs_settings_jobdetail',                      	   	 // ID used to identify this section and with which to register options
			__('Jobdetail', 'ATS2goJobs'),														   // Title to be displayed on the administration page
			array(__CLASS__, 'ats2gojobs_settings_jobdetail_callback'), // Callback used to render the description of the section
			'ats2gojobs_settings_display'           							       // Page on which to add this section of options
		);
		
		add_settings_field( 
			'hs_summaryonjobdetail',                                   // ID used to identify the field throughout the theme
			__('Show summary', 'ATS2goJobs'),                  				 // The label to the left of the option interface element
			array(__CLASS__, 'ats2gojobs_summaryonjobdetail_callback'), // The name of the function responsible for rendering the option interface
			'ats2gojobs_settings_display',     	     			             // The page on which this option will be displayed
			'ats2gojobs_settings_jobdetail'            		  		       // The name of the section to which this field belongs
		);
		
		add_settings_field( 
			'hs_classionjobdetail',                                   // ID used to identify the field throughout the theme
			__('Show classifications', 'ATS2goJobs'),         				  // The label to the left of the option interface element
			array(__CLASS__, 'ats2gojobs_classionjobdetail_callback'), // The name of the function responsible for rendering the option interface
			'ats2gojobs_settings_display',     	     			            // The page on which this option will be displayed
			'ats2gojobs_settings_jobdetail'            		  		      // The name of the section to which this field belongs
		);
		
		add_settings_field( 
			'hs_applybuttonposition',                                    // ID used to identify the field throughout the theme
			__('Applybutton position', 'ATS2goJobs'),                		 // The label to the left of the option interface element
			array(__CLASS__, 'ats2gojobs_applybutton_position_callback'), // The name of the function responsible for rendering the option interface
			'ats2gojobs_settings_display',     	     			               // The page on which this option will be displayed
			'ats2gojobs_settings_jobdetail'            		 			         // The name of the section to which this field belongs
		);
		
		
   	// register settings
		register_setting(
				'ats2gojobs_settings_display', // Option group (section)
				'hs_summaryonjoblist'				  // Option name (field)
		);
		
		// register settings
		register_setting(
				'ats2gojobs_settings_display', // Option group (section)
				'hs_classionjoblist'				  // Option name (field)
		);
		
		// register settings
		register_setting(
				'ats2gojobs_settings_display', // Option group (section)
				'hs_readmoreonjoblist'		    // Option name (field)
		);
		
		// register settings
		register_setting(
				'ats2gojobs_settings_display', // Option group (section)
				'hs_summaryonjobdetail'				// Option name (field)
		);
		
		// register settings
		register_setting(
				'ats2gojobs_settings_display', // Option group (section)
				'hs_classionjobdetail'	      // Option name (field)
		);
		
		// register settings
		register_setting(
				'ats2gojobs_settings_display', // Option group (section)
				'hs_applybuttonposition'		  // Option name (field)
		);
		
		//
		// SOCIAL
		
		// add section
		add_settings_section(
			'ats2gojobs_settings_social',           								  // ID used to identify this section and with which to register options
			__('Social', 'ATS2goJobs'),            									// Title to be displayed on the administration page
			array(__CLASS__, 'ats2gojobs_settings_social_callback'), // Callback used to render the description of the section
			'ats2gojobs_settings_social'            							    // Page on which to add this section of options
		);
		
		// add field
		add_settings_field( 
			'hs_linkedinkey',                                   // ID used to identify the field throughout the theme
			__('LinkedIn Key', 'ATS2goJobs'),                    // The label to the left of the option interface element
			array(__CLASS__, 'ats2gojobs_linkedinkey_callback'), // The name of the function responsible for rendering the option interface
			'ats2gojobs_settings_social',     	     							// The page on which this option will be displayed
			'ats2gojobs_settings_social'            							// The name of the section to which this field belongs
		);
		
		// add field
		add_settings_field( 
			'hs_facebookkey',                                   // ID used to identify the field throughout the theme
			__('Facebook Key', 'ATS2goJobs'),                    // The label to the left of the option interface element
			array(__CLASS__, 'ats2gojobs_facebookkey_callback'), // The name of the function responsible for rendering the option interface
			'ats2gojobs_settings_social',     	     							// The page on which this option will be displayed
			'ats2gojobs_settings_social'            							// The name of the section to which this field belongs
		);
		
		// register settings
		register_setting(
				'ats2gojobs_settings_social', // Option group (section)
				'hs_linkedinkey'					   // Option name (field)
		);
		
		// register settings
		register_setting(
				'ats2gojobs_settings_social', // Option group (section)
				'hs_facebookkey'						 // Option name (field)
		);
	} 
	
	//
	// SECTION CALLBACKS
	function ats2gojobs_settings_general_callback() {
		echo __('<p>Fill in your ATS2go Customer ID. If your ATS2go implementation supports more than one language, specify the language of the jobs you want to show, example (NL, EN, FR, etc.).<br/>' . 
				    'By default the jobfeed updates every 15 minutes, below you can update the frequency. </p>', 'ATS2goJobs');
	}
	
  function ats2gojobs_settings_joblist_callback() {
		echo __('<p>Edit the settings below to change how the <i>joblist</i> is displayed.</p>', 'ATS2goJobs');
	}
	function ats2gojobs_settings_jobdetail_callback() {
		echo __('<p>Edit the settings below to change how the <i>jobdetail</i> page is displayed.</p>', 'ATS2goJobs');
	}
	
	function ats2gojobs_settings_social_callback() {
		echo __('<p>Add social media Apps to enable new features within the ATS2goJobs plugin.</p>', 'ATS2goJobs');
	}

	//
	// FIELD CALLBACKS
	
	// GENERAL
	function ats2gojobs_web_site_id_callback() {
		$html = '<input type="text" id="hs_web_site_id" name="hs_web_site_id" value="' . get_option('hs_web_site_id') . '" />';
		echo $html;
	}
	
	function ats2gojobs_menuposition_callback() {
		$html = '<input type="text" id="hs_menuposition" name="hs_menuposition" value="' . get_option('hs_menuposition') . '" />';
		echo $html;
	} 
	 
	function ats2gojobs_feed_update_callback() {
		$html = '<input type="text" id="hs_feed_update" name="hs_feed_update" value="' . get_option('hs_feed_update') . '" />';
		$html .= __("<span> minutes</span>", 'ATS2goJobs');
		
		echo $html;
	} 
	
	function ats2gojobs_feed_language_callback() {
		$html = '<input type="text" id="hs_feed_language" name="hs_feed_language" value="' . get_option('hs_feed_language') . '" />';
		echo $html;
	} 

	function ats2gojobs_ga_cookie_callback() {
		$html = '<input type="text" id="hs_ga_cookie" name="hs_ga_cookie" value="' . get_option('hs_ga_cookie') . '" />';
		echo $html;
	} 

	// DISPLAY	
	function ats2gojobs_summaryonjobdetail_callback() {
    $html = '<input type="checkbox" id="hs_summaryonjobdetail" name="hs_summaryonjobdetail" value="1" ' . checked('1', get_option('hs_summaryonjobdetail', '0'), false) . '/>';
    echo $html;
  }
	
	function ats2gojobs_classionjobdetail_callback() {
	  $html = '<input type="checkbox" id="hs_classionjobdetail" name="hs_classionjobdetail" value="1" ' . checked('1', get_option('hs_classionjobdetail', '1'), false) . '/>';
    echo $html;
	}
	
	function ats2gojobs_applybutton_position_callback() {
	  $selected = get_option('hs_applybuttonposition', 1);
    $html = '<select id="hs_applybuttonposition" name="hs_applybuttonposition">';
      $html .= '<option value="1"' . selected($selected, '1', false) . '>' . __('Below', 'ATS2goJobs') .'</option>';
      $html .= '<option value="2"' . selected($selected, '2', false) . '>' . __('Above', 'ATS2goJobs') . '</option>';
      $html .= '<option value="3"' . selected($selected, '3', false) . '>' . __('Below & above', 'ATS2goJobs') . '</option>';
    $html .= '</select>';
		$html .= ' <span>job description</span>';		
		echo $html;
  }
	
	function ats2gojobs_summaryonjoblist_callback() {
	  $html = '<input type="checkbox" id="hs_summaryonjoblist" name="hs_summaryonjoblist" value="1" ' . checked('1', get_option('hs_summaryonjoblist', '1'), false) . '/>';
	  echo $html;
	}
	
	function ats2gojobs_classionjoblist_callback() {
	  $html = '<input type="checkbox" id="hs_classionjoblist" name="hs_classionjoblist" value="1" ' . checked('1', get_option('hs_classionjoblist', '1'), false) . '/>';
	  echo $html;
	}
	
	function ats2gojobs_readmoreonjoblist_callback() {
	  $html = '<input type="checkbox" id="hs_readmoreonjoblist" name="hs_readmoreonjoblist" value="1" ' . checked('1', get_option('hs_readmoreonjoblist', '0'), false) . '/>';
	  echo $html;
	}
	
	// SOCIAL
	function ats2gojobs_linkedinkey_callback() {
		$html = '<input type="text" id="hs_linkedinkey" name="hs_linkedinkey" value="' . get_option('hs_linkedinkey') . '" />';
		echo $html;
	} 

	function ats2gojobs_facebookkey_callback() {
		$html = '<input type="text" id="hs_facebookkey" name="hs_facebookkey" value="' . get_option('hs_facebookkey') . '" />';
		echo $html;
	} 
	
	
	//
	// CREATE SETTINGS MENU ITEM 
	function ats2gojobs_create_settings_menu() {
		add_submenu_page('edit.php?post_type=ats2gojobs', __('Settings', 'ATS2goJobs'), __('Settings', 'ATS2goJobs'), 'edit_posts', basename(__FILE__), array(__CLASS__, 'ats2gojobs_settings_page'));
	}
	
	//
	// CREATE SETTINGS PAGE
	function ats2gojobs_settings_page($atts=array()) {
	?>
		<div class="wrap">
			<h2><?php echo __('ATS2goJobs Settings', 'ATS2goJobs'); ?></h2>
			
			<?php 
			settings_errors(); 

			// active tab
			$active_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'ats2gojobs_settings_general';
			if (!isset($active_tab)) {
			  $active_tab = 'ats2gojobs_settings_general';
			}
			
			// update scheduled job 
			if ($active_tab == 'ats2gojobs_settings_general' && $_GET['settings-updated'] == 'true') {
			  // remove old scheduled (this might be a very long time and user wants faster, we dont want them to need to wait till current finishes before new time)
				wp_clear_scheduled_hook('ats2gojobs_jobs_hook');
			}
			
			?>
			
			<!-- Print tabs -->
			<h2 class="nav-tab-wrapper">
				<a href="edit.php?post_type=ats2gojobs&page=ATS2goJobs-settings.php&tab=ats2gojobs_settings_general" class="nav-tab <?php echo $active_tab == 'ats2gojobs_settings_general' ? 'nav-tab-active' : ''; ?>"><?php echo __('General Settings', 'ATS2goJobs'); ?></a>
				</h2>
			
			<!-- Create options form -->
			<form method="post" action="options.php">
				<?php
				settings_fields($active_tab); 
				do_settings_sections($active_tab);
				
				submit_button();
				?>
			</form>
	
		</div>
	<?php
	}

	// ADMIN NOTICE
	function ats2gojobs_settings_notices() {
		$web_site_id = get_option('hs_web_site_id');
		if (!isset($web_site_id) or $web_site_id == '') {
			echo __('<div class="error"><p><strong>Please specify your ATS2go Customer ID on the settings page. (Go in the menu to ATS2goJobs -> Settings).</strong></p></div>', 'ATS2goJobs');	
		}
	}
}

$obj_settings = new ATS2goJobs_Settings();
$obj_settings -> init();


?>
