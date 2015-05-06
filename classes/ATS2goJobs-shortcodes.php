<?php

//
// CLASS
class ATS2goJobs_Shortcodes {
  
	//
	// INIT
	static function init() {
		add_shortcode('ats2gojobs_joblist', array(__CLASS__, 'handle_joblist_shortcode'));
		add_shortcode('ats2gojobs_jobdetail', array( __CLASS__, 'handle_jobdetail_shortcode'));
	}
	
	//
	// JOBLIST
	//
	static function handle_joblist_shortcode($atts=array()) {
		
		$content = '';

		$query_args = array('post_type' => 'ats2gojobs');
											
    $wp_query = new WP_Query($query_args);
		
		$content .= '<div class="joblist">';
		
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
		  	
		  // variables
			$post_id = get_the_ID();
			$meta_data = get_post_meta($post_id); 
			$job = json_decode($meta_data['job_json'][0]);
			$web_page_id = $meta_data['web_page_id'][0];
			$web_site_id = get_option('hs_web_site_id');
			
			// post div
			$content .= '<div id="post-' . get_the_ID() . '" class="ats2gojobs">';
		  
			// job title 
		  $content .= '<h2><a href="' . get_permalink() . '">'. get_the_title() . '</a></h2>';
			
			// classifications
			if (get_option('hs_classionjoblist', '1') == '1') {
			  $content .= create_classifications_div($job); 
		  }
			
			// summary
			if (isset($job -> summary) && get_option('hs_summaryonjoblist', '1') == '1') {
			  $content .= $job -> summary;
			}
			
			// readmore
			if (get_option('hs_readmoreonjoblist', '0') == '1') {
				$content .= '<a href="' . get_permalink() . '" class="readmore">Lees meer</a>';
			}
			
			// close post div
			$content .= '</div>';
			
  	endwhile;
		
		$content .= '</div>';
		
		return $content;
		
	}
	
	//
	// JOBDETAIL
	//
	static function handle_jobdetail_shortcode($atts=array()) {
	  
		$content = '';
				
		// variables
	  $post_id = get_the_ID();
		$meta_data = get_post_meta($post_id); 
		$job = json_decode($meta_data['job_json'][0]);
		$job_description = $meta_data['job_description'][0];
		$web_page_id = $meta_data['web_page_id'][0];
		$web_site_id = get_option('hs_web_site_id');
		
		// post div
		$content .= '<div id="post-' . get_the_ID() . '" class="jobdetail">';
		
		// apply button
		$content .= '<div class="hs_apply_button_code">' .
								'  <script type="text/javascript">' .
								'	   var HS = {};' .
								'		 HS.web_site_id = "'. $web_site_id . '";' .
								'    HS.language = "' . get_option('hs_feed_language', 'DEFAULT') . '";' .
								'		 HS.ga_cookie = "' . get_option('hs_ga_cookie', '__utmz') . '"'.
								'	 </script>' .
								'  <script type="text/javascript" src="//platform.hireserve.com/incl/js/hireserve_api.js"></script>' .
							  '  <script type="HIRESERVE/Apply" data-web_page_id="' . $web_page_id . '"></script>';
	  
	  // if linkedin apply
		if (nvl(get_option('hs_linkedinkey'), '') != '') {
		  $content .= '<script type="text/javascript" src="https://platform.linkedin.com/in.js">' .
									'  api_key: ' . get_option('hs_linkedinkey') . "\n" .
									'  authorize: true' . "\n" .
									'  scope: r_emailaddress r_fullprofile' . "\n" .
									'</script>';
		}
		
		// if facebook apply
		if (nvl(get_option('hs_facebookkey'), '') != '') {
		  $content .= '<div id="fb-root"></div>' .
									'<script type="text/javascript">' .
									'  window.fbAsyncInit = function() {' .
									'    FB.init({' .
									'      appId: ' . get_option('hs_facebookkey') . ', status: true, cookie: true, xfbml: true' .
									'    });' .
									'  };' .
									'  (function(d, s, id) {' .
									'    var js, fjs = d.getElementsByTagName(s)[0];' . 
									'    if (d.getElementById(id)) return;' .
									'    js = d.createElement(s); js.id = id;' .
									'    js.src = "//connect.facebook.net/en_US/all.js";' .
									'    document.getElementById("fb-root").appendChild(js);' .
									'  }(document, "script", "facebook-jssdk"));' .
									'</script>';
		}
		
		// style
		$content .= '<link rel="stylesheet" type="text/css" media="screen" href="//platform.hireserve.com/incl/css/hs_apply.css">';
		
		// close apply button div
		$content .= '</div>';
		
		// classifications
		if (get_option('hs_classionjoblist', '1') == '1') {
		  $content .= create_classifications_div($job); 
		}
		
		// apply button top
		if (in_array(get_option('hs_applybuttonposition', '1'), array('2', '3'))) {
			$content .= '<div class="hs_applybutton"></div>';
		}
		
		// summary
		if (isset($job -> summary) && get_option('hs_summaryonjobdetail', '1') == '1') {
			$content .= '<p class="hs_summary">' . $job -> summary . '</p>';
		}
		
		// description
	  $content .= '<div class="hs_job_description">' .
			            $job_description .
								'</div>';
	  
		// apply button bottom
		if (in_array(get_option('hs_applybuttonposition', '1'), array('1', '3'))) {
			$content .= '<div class="hs_applybutton"></div><br/>';
	  }
		
		// close post div
		$content .= '</div>';
			
	  return $content;		
  }
		
}

ATS2goJobs_Shortcodes::init();



?>