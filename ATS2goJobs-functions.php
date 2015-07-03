<?php

//
// GENERAL LOGIC
//

function nvl($var, $default = "") {
  return isset($var) ? $var : $default;
}

//
// JOBS LOGIC
//

// CREATE POST TYPE
if( ! function_exists('ats2gojobs_create_post_type')) {
	function ats2gojobs_create_post_type() {
		global $wpdb;
		
		if (nvl(get_option('hs_menuposition'), '') == '') {
		  $menuposition = 20;
		} else {
		  $menuposition = intval(get_option('hs_menuposition'));
		}
		register_post_type( 
			'ats2gojobs',
			array( 
				'labels' => array(
					'name' => __('ATS2goJobs', 'ATS2goJobs'),
					'singular_name' 	=> __('icamsjob'),
					'add_new'					=> __('Add ATS2gojob', 'ATS2goJobs'),
					'add_new_item'		=> __('Add icamsjob', 'ATS2goJobs'),
					'edit'						=> __('Edit ATS2gojob', 'ATS2goJobs'),
					'edit_item'				=> __('Edit ATS2gojob', 'ATS2goJobs'),
					'new_item'				=> __('New ATS2gojob', 'ATS2goJobs'),
					'view'						=> __('View ATS2gojob', 'ATS2goJobs'),
					'view_item'				=> __('View ATS2gojob', 'ATS2goJobs'),
					'search_items'		=> __('Search ATS2gojobs', 'ATS2goJobs'),
					'not_found'				=> __('No ATS2gojobs found', 'ATS2goJobs'),
					'not_found_in_trash' => __('No ATS2gojobs found in Trash', 'ATS2goJobs'),
					'parent'				  => __('Parent ATS2gojob', 'ATS2goJobs'),
				),
				'description' => __('ATS2goJobs', 'ATS2goJobs'),
				'public'	=> true,
				'show_ui' => true,
				'publicly_queryable'	=> true,
				//'exclude_from_search' => false,
				'menu_position' => $menuposition,
				'menu_icon' => '',
				'hierarchical' => true,
				'query_var'	=> true,
				'capabilities' => array(
					'create_posts' => false,
				),
				'supports' => array (
					'title',
					'editor',
					'thumbnail', //Displays a box for featured image.
					'author' 
				),
				'rewrite' => array(
          'slug' => get_option('hs_permaname','ats2gojobs')
        )
			)
		);
	}
}

// LOAD JOBS FROM FEED
if ( ! function_exists('insert_jobs_from_feed')) {
	function insert_jobs_from_feed() {
		
		// open or create debug txt
		//$myfile = fopen(WP_PLUGIN_DIR."/ATS2goJobs/debug.txt", "w");
		//fwrite($myfile, date('Y-m-d H:i:s') . "\n");
		//fwrite($myfile, $language . "\n");
	  //fclose($myfile);
		
		// get web_site_id
		$web_site_id = get_option('hs_web_site_id');
	  
		// language
		$language = get_option('hs_feed_language');
		if (empty($language)) {
		  $language = "DEFAULT";
		}
		
		// create feed url
		$json_url = 'https://platform.hireserve.com/wd/plsql/ic_job_feeds.feed_engine?p_web_site_id=' . $web_site_id . '&p_format=MOBILE&p_direct=Y&p_job_description=Y&p_summary=Y&p_language=' . $language;
		
		// initializing curl
		$ch = curl_init( $json_url );

		// configuring curl options
		$options = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HTTPHEADER => array('Content-type: application/json')
		);

		// curl options
		curl_setopt_array($ch, $options );

		// execute curl
		$result = curl_exec($ch);

		// decode
		$data = json_decode($result, true);
		
		$in_query;
	  
		if (isset($data['jobs'])) {
			
			$jobs = $data['jobs'];
			$first = true;
			
			// loop jobs
			foreach ($jobs as $job) {
			  
				// web_page_id 
				$web_page_id = $job['id'];
				
			  // build sql query value
				if ($first == true) {
					$in_query = "'" . $web_page_id . "'";
					$first = false;
				} else {
					$in_query = $in_query . ", '" . $web_page_id . "'"; 
				}
				
				// job title
				$job_title = $job['title'];
				
				// job description
				if (isset($job['jobdescription']['description'])) {
				  $job_description = $job['jobdescription']['description'];
					unset($job['jobdescription']['description']);
				}
				
				// job update date
				if (isset($job['timestamp'])) {
				  $post_date = $job['timestamp'];
				} else {
				  $post_date = date("Y-m-d H:i:s");
				}
				
				// save string version of job json
				$job_string	= json_encode($job);
				
				// get post id based on web_page_id (check if post already exist)
				$job_postid = get_post_id_by_meta_key_and_value('web_page_id', $web_page_id);
				
				// found post
				if ($job_postid) {
					$job_post = array(
						'ID'    				=> $job_postid,
						'post_title'    => $job_title,
						'post_type'     => 'ats2gojobs',
						'post_content'  => '[ats2gojobs_jobdetail]',
						'post_status'   => 'publish',
						'post_date'			=> $post_date
					);
					wp_insert_post($job_post);
					update_post_meta($job_postid, 'job_json', $job_string);
					update_post_meta($job_postid, 'job_description', $job_description);
					
				// new post
				} else {
					$post_id = $job_post = array(
						'post_title'    => $job_title,
						'post_type'     => 'ats2gojobs',
						'post_content'  => '[ats2gojobs_jobdetail]',
						'post_status'   => 'publish',
						'post_date'			=> $post_date
					);
					$job_postid = wp_insert_post($job_post);
					add_post_meta($job_postid, 'web_page_id', $web_page_id, true);
					add_post_meta($job_postid, 'job_json', $job_string, true);
					add_post_meta($job_postid, 'job_description', $job_description, true);
				}
			}
		}
		
		// delete old jobs and metadata
		global $wpdb;
		$wpdb2 = $wpdb;
		if (empty($in_query)) {
	  	$result = $wpdb->get_results("SELECT * FROM `" . $wpdb->posts . "` WHERE post_type = 'ats2gojobs' and ID IN (SELECT post_id FROM `" . $wpdb->postmeta . "` WHERE meta_key = 'web_page_id')");
		} else {
	  	$result = $wpdb->get_results("SELECT * FROM `" . $wpdb->posts . "` WHERE post_type = 'ats2gojobs' and ID IN (SELECT post_id FROM `" . $wpdb->postmeta . "` WHERE meta_key = 'web_page_id' AND meta_value NOT IN(" . $in_query . "))");
		}
		
		if( ! empty( $result ) ) {
			foreach ($result as $post) {
				wp_delete_post($post->ID);
				delete_post_meta($post->ID, 'web_page_id');
				delete_post_meta($post->ID, 'job_json');
			}
		}
		$wpdb = $wpdb2;
	}
}

//
// GET POST ID BY META KEY & VALUE
if ( ! function_exists('get_post_id_by_meta_key_and_value')) {
	function get_post_id_by_meta_key_and_value($key, $value) {
	  global $wpdb;
		$wpdb2 = $wpdb;
		$meta = $wpdb->get_results("SELECT * FROM `".$wpdb->postmeta."` WHERE meta_key='".$wpdb->escape($key)."' AND meta_value='".$wpdb->escape($value)."'");
		if (is_array($meta) && !empty($meta) && isset($meta[0])) {
			$meta = $meta[0];
		}
		if (is_object($meta)) {
			return $meta->post_id;
		} else {
			return false;
		}
		$wpdb = $wpdb2;
	}
}

//
// SCHEDULER (not in function, else it will schedule only once)
function ats2gojobs_schedules($cron_schedules){
	$time = get_option('hs_feed_update');

	if (isset($time)) {
		$time_final = 60 * intval($time);
	} else {
		$time_final = 900;
	}
	$cron_schedules['HS_update'] = array(
		'interval'=> $time_final,
		'display'=>  __('iCamsjobs custom update')
	);
	
	return $cron_schedules;
}

// Add new interval
add_filter('cron_schedules', 'ats2gojobs_schedules');

// Schedule the action if not already
if(!wp_next_scheduled('ats2gojobs_jobs_hook')) {
	wp_schedule_event(time(),'HS_update','ats2gojobs_jobs_hook');
}


//
// PRINT CLASSIFICATIONS
if ( ! function_exists('create_classifications_div')) {
	function create_classifications_div($job) {

		$class_div_html = '<div class="hs_job_classifications">';
		
		// classificatie
		foreach($job->classifications as $classification) {		
			// skip if no values object
			if (!isset($classification->values)) {
				continue;
			// skip if 0 values
			} else if(count($classification->values) == 0){
				continue;
			}
			
			// name
			$class_name = $classification->name;
			// start html
			$class_html = '<div class="hs_classification" id="class_' . strtolower(str_replace(' ', '_', $class_name)) . '">';			
			// type
			$class_html .= '<span class="hs_class_type"><strong>' . $class_name . ': </strong></span>';
			// values
			$class_values = '';
			$first_value = true;
			if (isset($classification->values)) {
				// value
				foreach ($classification->values as $value) {
					if ($first_value) {
						$class_values = $value->class_val;
						$first_value = false;
					} else {
						$class_values .= ', ' . $value->class_val;
					}
				}
			}
			$class_html .= '<span class="hs_class_value">' . $class_values . '</span>';
			$class_html .= '</div>';
			
			// append and empty
			$class_div_html .= $class_html;
			$class_html = '';
		}
		$class_div_html .= '</div>';
		return $class_div_html;
	}
}

?>