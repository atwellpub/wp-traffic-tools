<?php
    session_start();
	define('WP_INSTALLING', true);
	include_once('./../../../wp-config.php');
	include_once('./../../../wp-admin/includes/class-pclzip.php');
	global $table_prefix;
	global $wpdb;
	
	$wordpress_url = get_bloginfo('url');
	if (substr($wordpress_url, -1, -1)!='/')
	{
		$wordpress_url = $wordpress_url."/";
	}

	ini_set('memory_limit', '128M');
	
	$m = $_GET['m'];
	
	if ($m==1)
	{
		//print_r($these_ids);exit;
		$this_xml ="<?xml version='1.0' ?>\n<rss version='2.0'>\n<channel>\n";
		$this_xml .="<title>WP Traffic Tools - Link Profiles</title>\n";
		
		$query = "SELECT * FROM {$table_prefix}wptt_cloakme_profiles WHERE type='affiliate'";
		$result = mysql_query($query);
		if (!$result){ echo $query; echo mysql_error($result); }
		
		
		
		while ($array = mysql_fetch_array($result))
		{
			
			
					//echo 1; exit;
					$this_array['classification_prefix'] = $array['classification_prefix'];
					$this_array['permalink'] = $array['permalink'];
					$this_array['cloaked_url'] = $array['cloaked_url'];
					$this_array['redirect_url'] = $array['redirect_url'];
					$this_array['redirect_spider'] = $array['redirect_spider'];
					$this_array['redirect_method'] = $array['redirect_method'];
					$this_array['redirect_type'] = $array['redirect_type'];
					$this_array['blank_referrer'] = $array['blank_referrer'];
					$this_array['cloak_target'] = $array['cloak_target'];
					$this_array['visitor_count'] = $array['visitor_count'];
					$this_array['spider_count'] = $array['spider_count'];
					$this_array['type'] = $array['type'];
					$this_array['keywords'] = $array['keywords'];
					$this_array['keywords_limit'] = $array['keywords_limit'];
					$this_array['keywords_limit_total'] = $array['keywords_limit_total'];
					$this_array['keywords_affect'] = $array['keywords_affect'];
					$this_array['keywords_target_page'] = $array['keywords_target_page'];
					$this_array['stuff_cookie'] = $array['stuff_cookie'];
					$this_array['notes'] = $array['notes'];
					$this_array['link_masking'] = $array['link_masking'];
					$this_array['rotate_urls'] = $array['rotate_urls'];
					
					
					$this_json = json_encode($this_array);
					//echo 1;
					$this_xml .="<link_profile>\n";
					$this_xml .="<![CDATA[ {$this_json} ]]>\n";
					$this_xml .="</link_profile>\n";
					
					//echo $this_xml;exit;
					unset($this_json);
					unset($this_array);
				
			
		}
		
			$filename = "wptt-linkprofiles-".date('m-d-Y')."-".time().".xml";
			
			
			//echo $backup;exit;
			$handle = fopen($filename,'w+');
			fwrite($handle,$this_xml);
			fclose($handle);

		$filename = "wptt-linkprofiles-".date('m-d-Y')."-".time().".xml";
			
			
		
		header('Content-type: application/xml');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		readfile($filename);
		
		exit;
	}
	if ($m==2)
	{
		//print_r($these_ids);exit;
		$this_xml ="<?xml version='1.0' ?>\n<rss version='2.0'>\n<channel>\n";
		$this_xml .="<title>WP Traffic Tools - Redirection Profiles</title>\n";
		
		$query = "SELECT * FROM {$table_prefix}wptt_wpredirect_profiles";
		$result = mysql_query($query);
		if (!$result){ echo $query; echo mysql_error($result); }
		
		
		
		while ($array = mysql_fetch_array($result))
		{
			
			
					//echo 1; exit;
					$this_array['post_id'] = $array['post_id'];
					$this_array['redirect_url'] = $array['redirect_url'];
					$this_array['redirect_keywords'] = $array['redirect_keywords'];
					$this_array['blank_referrer'] = $array['blank_referrer'];
					$this_array['ignore_spider'] = $array['ignore_spider'];
					$this_array['redirect_type'] = $array['redirect_type'];
					$this_array['human_redirect_count'] = $array['human_redirect_count'];
					$this_array['spider_redirect_count'] = $array['spider_redirect_count'];
					$this_array['exclude_items'] = $array['exclude_items'];
					$this_array['redirect_delay'] = $array['redirect_delay'];
					$this_array['require_referrer'] = $array['require_referrer'];
					$this_array['notes'] = $array['notes'];
					$this_array['throttle'] = $array['throttle'];
					$this_array['status'] = $array['status'];
					
					
					$this_json = json_encode($this_array);
					//echo 1;
					$this_xml .="<redirect_profile>\n";
					$this_xml .="<![CDATA[ {$this_json} ]]>\n";
					$this_xml .="</redirect_profile>\n";
					
					//echo $this_xml;exit;
					unset($this_json);
					unset($this_array);
		}
		
		$filename = "wptt-redirectprofiles".date('m-d-Y')."-".time().".xml";
		
		//echo $this_xml;exit;
		
		//echo $backup;exit;
		$handle = fopen($filename,'w+');
		fwrite($handle,$this_xml);
		fclose($handle);

		//$filename = "wptt-redirectprofiles-".date('m-d-Y')."-".time().".xml";
			
			
		
		header('Content-type: application/xml');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		readfile($filename);
		
		exit;
	}	
?>