<?php
$show_debug_info = 0;

define('WP_INSTALLING', true);
if ( file_exists ( './../../../wp-config.php' ) )
{
	include_once ( './../../../wp-config.php' );
}
else if ( file_exists ( './../../../../wp-config.php' ) )
{
	include_once ( './../../../../wp-config.php' );
}

include_once('./wp-traffic-tools.php');


$multisite=0;
$multisite=0;
if ( ! function_exists( 'is_plugin_active_for_network' ) )
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
    // Makes sure the plugin is defined before trying to use it
 
if ( is_plugin_active_for_network( 'wp-traffic-tools/wp-traffic-tools.php') ) {
   
   if (function_exists('is_multisite') && is_multisite()&&function_exists('switch_to_blog')) {       
		$old_blog = $wpdb->blogid;
		$blogids = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
		$multisite = 1;        
	}
	
}
else
{
	//echo 2;exit;
}


	
//print_r($blogids);exit;
//echo $table_prefix;exit;

if (count($blogids)>1)
{
	$count = count($blogids);
}
else
{
	$count=1;
}

for ($i=0;$i<$count;$i++)
{
	if ($multisite==1)
	{
		 switch_to_blog($blogids[$i]);
	}
	else
	{
		//echo 3;exit;
	}

	/* Retrieve the global settings */ 
	$query = "SELECT `option_value` FROM {$table_prefix}wptt_wptraffictools_options WHERE option_name='wptt_options' ORDER BY id ASC";
	$result = mysql_query($query);

	if ($result)
	{

		$array = mysql_fetch_array($result);
		$wptt_options = $array['option_value'];
		$wptt_options = str_replace("\r\n", "\n", $wptt_options);
		$wptt_options = str_replace("\r", "\n", $wptt_options);
		$wptt_options = str_replace("\n", "\\n", $wptt_options);
		$wptt_options = json_decode($wptt_options, true);
		//var_dump($wptt_options);exit;
		
		$useragents = $wptt_options['useragents'];
		$ip_addresses = $wptt_options['ip_addresses'];
		$global_cloak_links = $wptt_options['cloak_links'];
		$global_redirect_spiders = $wptt_options['redirect_spiders'];
		$global_nofollow_links = $wptt_options['nofollow_links'];
		$global_wptt = $wptt_options['license_key'];
		$global_wptt_handle = $wptt_options['license_email'];
		if (!$_SESSION['wptt_permissions'])
		{
			$global_permissions = $wptt_options['permissions'];
		}
		else
		{
			$global_permissions = $_SESSION['wptt_permissions'];
		}
		$current_version = $wptt_options['current_version'];
		$global_cloak_link_profiles = $wptt_options['cloak_link_profiles'];
		$global_default_classificatin_prefix = $wptt_options['default_classification_prefix'];
		$global_keyword_affects = $wptt_options['keyword_affects'];
		$global_cloak_comments = $wptt_options['cloak_comments'];
		$global_cloak_commenter_url = $wptt_options['cloak_commenter_url'];
		$global_topsearches = $wptt_options['topsearches'];
		$global_topsearches_nature = $wptt_options['topsearches_nature'];
		$global_topsearches_header= $wptt_options['topsearches_header'];
		$global_topsearches_sort= $wptt_options['topsearches_sort'];
		$global_topsearches_limit = $wptt_options['topsearches_limit'];
		$global_topsearches_link = $wptt_options['topsearches_link'];
		$global_topsearches_display_count = $wptt_options['topsearches_display_count'];
		$global_topsearches_ignore = $wptt_options['topsearches_ignore'];
		$global_topsearches_tags = $wptt_options['topsearches_tags'];
		$global_topsearches_nature_deeplinks = $wptt_options['topsearches_nature_deeplinks'];
		$global_cloak_only_posts = $wptt_options['cloak_links_pages'];
		$global_cloak_text_widgets = $wptt_options['cloak_text_widgets'];
		$global_cloak_header_area = $wptt_options['cloak_header'];	
		$global_cloak_footer_area = $wptt_options['cloak_footer'];	
		$global_cloak_exceptions = $wptt_options['cloak_exceptions'];	
		$global_cloak_patterns = $wptt_options['cloak_patterns'];	
		$global_popups_cookie_timeout = $wptt_options['popups_cookie_timeout'];
		
		
	}
	else
	{
		//echo $query; echo mysql_error(); exit;
	}

	//echo $table_prefix;
	//print_r($wptt_options);
	echo "<hr>";
	
	if ($show_debug_info==1)
	{
		echo "WPTT OPTIONS JASON - 1<BR>";
		print_r($wptt_options);
		ECHO "<HR>";
	}


	echo $current_version."<br>";
	if (!$current_version){$current_version = '3.7.9.7';}


	//UPDATE DATABASE TO CURRENT VERSION//
	if ($show_debug_info!=1&&count($wptt_options)>7)
	{
		//echo 2;
		//print_r($wptt_options);exit;
		if (isset($_GET['server_version']))
		{
			$wptt_options['current_version'] =  $_GET['server_version'];
		}
		else
		{
			$wptt_options['current_version'] =  WPTT_CURRENT_VERSION;
		}
		$these_wptt_options = json_encode($wptt_options);

		$query = "UPDATE {$table_prefix}wptt_wptraffictools_options SET option_value='$these_wptt_options' WHERE option_name='wptt_options'";
		$result = mysql_query($query);
		if (!$result) { echo $query; echo mysql_error();}		
	}

	if ($show_debug_info==1)
	{
		echo "WPTT OPTIONS JASON - 2<BR>";
		print_r($wptt_options);
		ECHO "<HR>";
	}

	if (count($wptt_options)<7)
	{
		$default_useragents = "msie;firefox;safari;webkit;opera;netscape;konqueror;gecko;chrome;songbird;seamonkey;flock;AppleWebKit;Android";

		$wptt_options['useragents'] = $default_useragents;
		$wptt_options['ip_addresses'] = "";
		$wptt_options['cloak_links'] = 0;
		$wptt_options['redirect_spiders'] = 0;
		$wptt_options['nofollow_links'] = 0;
		$wptt_options['current_version'] = WPTT_CURRENT_VERSION;
		$wptt_options['permissions'] = "1.1.1.1.1.1.1";
		$wptt_options['cloak_link_profiles'] = 1;
		$wptt_options['default_classification_prefix'] = "go";
		$wptt_options['keyword_affects'] = 0;
		$wptt_options['cloak_comments'] = 1;
		$wptt_options['cloak_commenter_url'] = 1;
		$wptt_options['topsearches'] = 0;
		$wptt_options['topsearches_nature'] = "single";
		$wptt_options['topsearches_header'] = "Top Searches";
		$wptt_options['topsearches_sort'] = "DESC";
		$wptt_options['topsearches_limit'] = 5;
		$wptt_options['topsearches_link'] = 0;
		$wptt_options['topsearches_display_count'] = 0;
		$wptt_options['topsearches_ignore'] = "";
		$wptt_options['topsearches_tags'] = 0;
		$wptt_options['topsearches_nature_deeplinks'] = 0;
		$wptt_options['cloak_links_pages'] = 0;
		$wptt_options['cloak_text_widgets'] = 0;
		$wptt_options['cloak_header'] = 0;
		$wptt_options['cloak_footer'] = 0;	
		$wptt_options['cloak_exceptions'] = "";
		$wptt_options['cloak_patterns'] = "";
		$wptt_options['popups_cookie_timeout'] = 7200;

		
		$this_wptt_options = json_encode($wptt_options);
		$sql = "UPDATE  {$wpdb->prefix}wptt_wptraffictools_options SET option_value = '$this_wptt_options' WHERE option_name = 'wptt_options'"; 
		$result = mysql_query($sql);
		if (!$result){echo $sql; echo "<hr>"; echo mysql_error();exit;}
		
		$safety=1;
	}

	if ($show_debug_info==1)
	{
		echo "WPTT OPTIONS JASON - 3 - $safety<BR>";
		print_r($wptt_options);
		ECHO "<HR>";
	}

	//print_r($wptt_options);exit;
	if ($current_version<'6.2.1.1'||$_GET['all']==1)
	{
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles  ADD  rotate_urls_count INT(9)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
	}
	
	//echo $current_version; exit;
	if ($current_version<'6.1.4.3'||$_GET['all']==1)
	{
		$sql = "ALTER TABLE {$table_prefix}wptt_wpredirect_regex_profiles  ADD  spider_management int(1)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
	}
	
	//echo $current_version; exit;
	if ($current_version<'6.1.4.9'||$_GET['all']==1)
	{
		$sql = "ALTER TABLE {$table_prefix}wptt_wpredirect_profiles  ADD  category_id VARCHAR(225)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
	}
	
	//echo $current_version; exit;
	if ($current_version<'6.1.4.2'||$_GET['all']==1)
	{
		$sql = "ALTER TABLE {$table_prefix}wptt_wpredirect_profiles  ADD  rotate_marker int(3)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
	}
	
	//echo $current_version; exit;
	if ($current_version<'6.1.3.7'||$_GET['all']==1)
	{
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles  ADD  rotate_marker int(3)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
	}
	
	//echo $current_version; exit;
	if ($current_version<'6.1.3.6'||$_GET['all']==1)
	{
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_wpredirect_profiles ADD  iframe_target_title TEXT";
		$result = mysql_query($sql);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
	}
	
	//echo $current_version; exit;
	if ($current_version<'6.1.3.3'||$_GET['all']==1)
	{
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_wpredirect_profiles ADD  iframe_target INT(1)";
		$result = mysql_query($sql);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
	}
	
	if ($current_version<'6.1.0.1'||$_GET['all']==1)
	{
		$sql = "CREATE TABLE IF NOT EXISTS wptt_ip_addresses (
							id INT(20) NOT NULL PRIMARY KEY,
							string VARCHAR(255) NOT NULL
							) {$charset_collate};";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
	}
	
	if ($current_version<'6.0.8.1'||$_GET['all']==1)
	{

		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles  ADD  redirect_method_url VARCHAR(225)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
	}
	
	if ($current_version<'6.0.5.1'||$_GET['all']==1)
	{
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_wpredirect_regex_profiles  ADD  nature INT(1)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles  ADD  attributes VARCHAR(225)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
	}

	if ($current_version<'6.0.2.1'||$_GET['all']==1)
	{
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_wpredirect_profiles  ADD  priority INT(5)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
	}

	if ($current_version<'6.0.1.3'||$_GET['all']==1)
	{
		//echo 1; exit;
		/* Retrieve the global settings */ 
		$query = "SELECT `option_value` FROM {$table_prefix}wptt_wptraffictools_options  ORDER BY id ASC";
		$result = mysql_query($query);

		if ($result)
		{
			while ($array = mysql_fetch_array($result))
			{
			  $results[] = $array['option_value'];
			}

			$useragents = $results[0];
			$ip_addresses =$results[1];
			$global_cloak_links = $results[2];
			$global_redirect_spiders = $results[3];
			$global_nofollow_links = $results[4];
			$global_wptt = $results[5];
			$global_wptt_handle = $results[6];
			$current_version = WPTT_CURRENT_VERSION;
			$global_cloak_link_profiles = $results[8];
			$global_default_classificatin_prefix = $results[9];
			$global_keyword_affects = $results[10];
			$global_cloak_comments = $results[11];
			$global_cloak_commenter_url = $results[12];
			$global_topsearches = $results[13];
			$global_topsearches_nature = $results[14];
			$global_topsearches_header= $results[15];
			$global_topsearches_sort= $results[16];
			$global_topsearches_limit = $results[17];
			$global_topsearches_link = $results[18];
			$global_topsearches_display_count = $results[19];
			$global_cloak_only_posts = $results[20];
			$global_topsearches_ignore = $results[21];
			$global_cloak_exceptions = stripslashes($results[22]);	
			$global_popups_cookie_timeout = stripslashes($results[23]);	
			$global_topsearches_tags = $results[24];
			$global_cloak_text_widgets = $results[25];	
			$global_cloak_header_area = $results[26];	
			$global_cloak_footer_area = $results[27];	
			$global_cloak_patterns = $results[28];	
			$global_topsearches_nature_deeplinks = $results[29];
		}
		
		$wptt_options['useragents'] = $useragents;
		$wptt_options['ip_addresses'] = $ip_addresses;
		$wptt_options['cloak_links'] = $global_cloak_links;
		$wptt_options['redirect_spiders'] = $global_redirect_spiders;
		$wptt_options['nofollow_links'] = $global_nofollow_links;
		$wptt_options['license_key'] = $global_wptt;
		$wptt_options['license_email'] =$global_wptt_handle;
		$wptt_options['permissions'] = "1.1.1.1.1.1.1";
		$wptt_options['current_version'] = $current_version;
		$wptt_options['cloak_link_profiles'] = $global_cloak_link_profiles;
		$wptt_options['default_classification_prefix'] = $global_default_classificatin_prefix;
		$wptt_options['keyword_affects'] = $global_keyword_affects;
		$wptt_options['cloak_comments'] = $global_cloak_comments;
		$wptt_options['cloak_commenter_url'] = $global_cloak_commenter_url;
		$wptt_options['topsearches'] = $global_topsearches;
		$wptt_options['topsearches_nature'] = $global_topsearches_nature;
		$wptt_options['topsearches_header'] = $global_topsearches_header;
		$wptt_options['topsearches_sort'] = $global_topsearches_sort;
		$wptt_options['topsearches_limit'] = $global_topsearches_limit;
		$wptt_options['topsearches_link'] = $global_topsearches_link;
		$wptt_options['topsearches_display_count'] = $global_topsearches_display_count;
		$wptt_options['topsearches_ignore'] = $global_topsearches_ignore;
		$wptt_options['topsearches_tags'] = $global_topsearches_tags;
		$wptt_options['topsearches_nature_deeplinks'] = $global_topsearches_nature_deeplinks;
		$wptt_options['cloak_links_pages'] = $global_cloak_only_posts;
		$wptt_options['cloak_text_widgets'] = $global_cloak_text_widgets;
		$wptt_options['cloak_header'] = $global_cloak_header_area;
		$wptt_options['cloak_footer'] = $global_cloak_footer_area;
		$wptt_options['cloak_exceptions'] = $global_cloak_exceptions;
		$wptt_options['cloak_patterns'] = $global_cloak_patterns;
		$wptt_options['popups_cookie_timeout'] = $global_popups_cookie_timeout;
		$these_wptt_options = json_encode($wptt_options);
		
		//print_r($wptt_options);exit;
		$sql = "INSERT  INTO {$wpdb->prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('32','wptt_options','$these_wptt_options','1')"; 
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		if (count($wptt_options)<10&&$safety!=1)
		{
			echo 2;exit;
			$sql = "UPDATE  {$wpdb->prefix}wptt_wptraffictools_options SET option_value = '$these_wptt_options' WHERE option_name = 'wptt_options'"; 
			$result = mysql_query($sql);
			if ($result){echo $sql; echo "<hr>"; echo mysql_error();exit;}
		}
		
	}


	
	//print_r($wptt_options);exit;
	if ($current_version<'5.2.1.8'||$_GET['all']==1)
	{
		$sql = "ALTER TABLE {$table_prefix}wptt_cookie_affiliate_profiles  CHANGE  affiliate_url affiliate_url TEXT";
		$result = mysql_query($sql);
	}

	if ($current_version<'5.2.1.4'||$_GET['all']==1)
	{
		$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wptt_wpredirect_regex_profiles (
				id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				regex_referrer TEXT NOT NULL,
				regex_landing_page TEXT NOT NULL,
				redirect TEXT NOT NULL,
				popunder INT(1) NOT NULL,
				notes TEXT NOT NULL,
				status INT(1) NOT NULL
				) {$charset_collate};";
		
		$result = $wpdb->get_results($sql, ARRAY_A);	
		
		//rename tables to standardized format
		$sql = "UPDATE {$table_prefix}wptt_wpredirect_profiles  SET  human_redirect_count = '0' WHERE human_redirect_count IS NULL && spider_redirect_count IS NULL";
		$result = $wpdb->get_results($sql, ARRAY_A);
		$sql = "UPDATE {$table_prefix}wptt_wpredirect_profiles  SET  spider_redirect_count = '0' WHERE spider_redirect_count IS NULL";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		$query= "DELETE FROM {$table_prefix}wptt_wptraffictools_google WHERE keyword LIKE '%\"%' OR keyword LIKE '%www%' OR keyword LIKE '%\%22%' OR keyword LIKE '%http%' OR keyword LIKE '%+%' ";
		$result = mysql_query($query);
		//if (!$result){echo $query; echo mysql_error(); exit;}
		
	}

	if ($current_version<'4.7.1.1'||$_GET['all']==1)
	{
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_logs  ADD  date DATE";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_wpredirect_profiles  ADD  notes TEXT";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_popups_profiles  ADD  notes TEXT";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "UPDATE {$table_prefix}wptt_popups_profiles  set  type='posts' WHERE type='post'";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "UPDATE {$table_prefix}wptt_popups_profiles  set  type='category' WHERE type='categories'";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_wpredirect_profiles  ADD  human_redirect_count INT(11)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_wpredirect_profiles  ADD  spider_redirect_count INT(11)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_wpredirect_profiles  ADD  throttle INT(10)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_wpredirect_profiles  ADD  throttle_check INT(10)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "UPDATE {$table_prefix}wptt_wpredirect_profiles  set  throttle_check=0";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_wpredirect_profiles  ADD  status INT(1)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_wpcookie_affiliate_profiles  ADD  throttle_pageviews INT(10)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "UPDATE {$table_prefix}wptt_wpcookie_affiliate_profiles  set  throttle_pageviews=0";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles  CHANGE  spoof_referrer_url spoof_referrer_url TEXT";
		$result = mysql_query($sql);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		$sql = "ALTER TABLE {$table_prefix}wptt_wpredirect_profiles  CHANGE  redirect_url redirect_url TEXT";
		$result = mysql_query($sql);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		$sql = "INSERT  INTO {$wpdb->prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('31','topsearches_nature_deeplinks','0','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_advertisements_keywords_profiles  ADD  geotargeting VARCHAR(255)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_advertisements_post_profiles  ADD  geotargeting VARCHAR(255)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_advertisements_category_profiles  ADD  geotargeting VARCHAR(255)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
	}

	if ($current_version<'4.3.9.5'||$_GET['all']==1)
	{
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_wpredirect_profiles CHANGE  redirect_url redirect_url TEXT";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		$sql = "INSERT  INTO {$wpdb->prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('26','topsearches_tags','0','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "INSERT  INTO {$wpdb->prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('27','cloak_text_widgets','0','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "INSERT  INTO {$wpdb->prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('28','cloak_header','0','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "INSERT  INTO {$wpdb->prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('29','cloak_footer','0','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "INSERT  INTO {$wpdb->prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('30','cloak_patterns','','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);
		


	}
	if ($current_version<'4.2.6.1'||$_GET['all']==1)
	{
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles  ADD  spoof_referrer_url VARCHAR(225)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		$sql = "DELETE FROM {$wpdb->prefix}wptt_wptraffictools_google WHERE post_id='0'";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "INSERT  INTO {$wpdb->prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('25','popups_cookie_timeout','7200','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_wpcookie_affiliate_profiles  ADD  throttle VARCHAR(225)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_wpcookie_global_profiles  ADD search_content INT(1)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_wpcookie_global_profiles  ADD search_referrer INT(1)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		$sql = "UPDATE {$wpdb->prefix}wptt_wpcookie_global_profiles SET search_referrer='1' , search_content='1' ";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "UPDATE {$wpdb->prefix}wptt_wpcookie_affiliate_profiles SET throttle='30' ";
		$result = $wpdb->get_results($sql, ARRAY_A);
	}


	if ($current_version<'4.2.1.6'||$_GET['all']==1)
	{

		$default_useragents = "msie;firefox;safari;webkit;opera;netscape;konqueror;gecko;chrome;songbird;seamonkey;flock;AppleWebKit;Android";
		
		$sql = "UPDATE {$wpdb->prefix}wptt_wptraffictools_options SET option_value='$default_useragents' WHERE option_name='useragents' AND option_value=''";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "INSERT  INTO {$wpdb->prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('23','topsearches_ignore','','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "INSERT  INTO {$wpdb->prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('24','cloak_exceptions','','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_wpredirect_profiles  ADD  redirect_delay INT(11)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_wpredirect_profiles  ADD  require_referrer INT(11)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "UPDATE {$table_prefix}wptt_cloakme_profiles  SET redirect_type='307' WHERE type='global'";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
	}
	if ($current_version<'3.9.4.4'||$_GET['all']==1)
	{
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_logs  ADD  keywords_nature TEXT";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_logs  ADD  keywords_query TEXT";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
	}
	if ($current_version<'3.9.3.1'||$_GET['all']==1)
	{
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles  CHANGE  redirect_url redirect_url TEXT";
		$result = mysql_query($sql);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles  ADD  rotate_urls INT(1)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_logs  ADD  target TEXT";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_logs  DROP 	index referrer";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_logs  DROP 	unique constraint referrer";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
	}
	if ($current_version<'3.9.1.8'||$_GET['all']==1)
	{
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles  ADD  notes TEXT";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles  ADD  link_masking INT(1)";
		$result = mysql_query($sql);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		$query = "UPDATE {$table_prefix}wptt_cloakme_profiles SET link_masking='1'";
		$result = mysql_query($query);
		//if (!$result) { echo $query; echo mysql_error();exit;}
	}

	if ($current_version<'3.8.8.7'||$_GET['all']==1)
	{
		$sql = "DELETE FROM {$table_prefix}wptt_cloakme_profiles  WHERE type = 'global'";
		$result = $wpdb->get_results($sql, ARRAY_A);
	}

	if ($current_version<'3.8.8.3'||$_GET['all']==1)
	{
		//rename tables to standardized format
		$sql = "DELETE FROM {$table_prefix}wptt_cloakme_profiles  WHERE type = 'global'";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		//rename tables to standardized format
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles  ADD UNIQUE (permalink)";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if (!$result){ echo $sql; echo mysql_error(); exit;}
		
		
		
		$sql = "CREATE TABLE IF NOT EXISTS {$table_prefix}wptt_cloakme_logs (
					id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					permalink VARCHAR(225) NOT NULL,
					referrer VARCHAR(225) NOT NULL UNIQUE,
					count INT(10) NOT NULL
					) {$charset_collate};";
			
		$result = mysql_query($sql);
		if (!$result){echo $sql; echo mysql_error();exit;}
		
		//rename tables to standardized format
		$sql = "RENAME TABLE {$table_prefix}wptraffictools_google TO {$table_prefix}wptt_wptraffictools_google";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "RENAME TABLE {$table_prefix}wptraffictools_options TO {$table_prefix}wptt_wptraffictools_options";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "RENAME TABLE {$table_prefix}wptraffictools_cloaking TO {$table_prefix}wptt_wptraffictools_cloaking";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "RENAME TABLE {$table_prefix}cloakme_options TO {$table_prefix}wptt_cloakme_options";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "RENAME TABLE {$table_prefix}cloakme_profiles TO {$table_prefix}wptt_cloakme_profiles";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "RENAME TABLE {$table_prefix}advertisements_content_profiles TO {$table_prefix}wptt_advertisements_content_profiles";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "RENAME TABLE {$table_prefix}advertisements_post_profiles TO {$table_prefix}wptt_advertisements_post_profiles";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "RENAME TABLE {$table_prefix}advertisements_category_profiles TO {$table_prefix}wptt_advertisements_category_profiles";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "RENAME TABLE {$table_prefix}advertisements_google_profiles TO {$table_prefix}wptt_advertisements_google_profiles";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "RENAME TABLE {$table_prefix}advertisements_keywords_profiles TO {$table_prefix}wptt_advertisements_keywords_profiles";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "RENAME TABLE {$table_prefix}wpredirect_profiles TO {$table_prefix}wptt_wpredirect_profiles";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "RENAME TABLE {$table_prefix}wpcookie_affiliate_profiles TO {$table_prefix}wptt_wpcookie_affiliate_profiles";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "RENAME TABLE {$table_prefix}wptt_wpcookie_affiate_profiles TO {$table_prefix}wptt_wpcookie_affiliate_profiles";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "RENAME TABLE {$table_prefix}wpcookie_post_profiles TO {$table_prefix}wptt_wpcookie_post_profiles";
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$sql = "RENAME TABLE {$table_prefix}wpcookie_global_profiles TO {$table_prefix}wptt_wpcookie_global_profiles";
		$result = $wpdb->get_results($sql, ARRAY_A);
	}


	if ($current_version<'3.7.9.7'||$_GET['all']==1)
	{
		//echo 1; exit;
		//update classification prefix storages
			//create the table
				
			//insert the default
				$sql = "INSERT INTO wpt_classification_prefixes (
						`id`,`option_name`,`option_value`,`status`)
						VALUES ('1','classification_prefix','go','1')";
				$result = $wpdb->get_results($sql, ARRAY_A);
			
			//normalize with database
				$query = "SELECT * FROM {$table_prefix}wptt_cloakme_options WHERE option_name='classification_prefix'";
				$result = mysql_query($query);
				
				while ($arr = mysql_fetch_array($result))
				{
					$option_value = $arr['option_value'];
					
					$query2 = "UPDATE wpt_classification_prefixes SET option_value='$option_value' WHERE option_name='classification_prefix'";
					$result2 = mysql_query($query2);
					if (!$result2) { echo $query2; echo mysql_error();exit;}
				}
				

		//update google database with post permalinks
			
			$query = "SELECT * FROM {$table_prefix}wptt_wptraffictools_google ";
			$result = mysql_query($query);
			
			while ($arr = mysql_fetch_array($result))
			{
				$pid = $arr['post_id'];
				$permalink =get_permalink( $pid );
				
				$sql = 	"UPDATE `{$table_prefix}wptt_wptraffictools_google` SET permalink = '$permalink' WHERE post_id='$pid'";
				mysql_query($sql);
			}
	}

	if ($current_version<'3.7.1')
	{
		$sql = 	"UPDATE `{$table_prefix}wptt_advertisements_content_profiles` SET content = REPLACE(content, '%keyword%','%keyword_query%')";
		$result = $wpdb->get_results($sql, ARRAY_A);
					
		$query = "SELECT * FROM {$table_prefix}wptt_advertisements_content_profiles ";
		$result = mysql_query($query);
		if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
		while ($arr = mysql_fetch_array($result))
		{
			$advertisements_content_profile_id[] = $arr['id'];
			$advertisements_content_profile_name[] = $arr['profile_name'];
			$advertisements_content_profile_content[] = stripslashes($arr['content']);
		}
		if ($advertisements_content_profile_id)
		{
			foreach ($advertisements_content_profile_id as $key=>$val)
			{
				if (strpos($advertisements_content_profile_content[$key],'%keyword-'))
				{
					//echo 1; exit;
					$content = preg_replace('/%keyword-(.*?)%/s', "%keyword_query-$1%", $advertisements_content_profile_content[$key]);
					$content = addslashes($content);
					$sql = 	"UPDATE `{$table_prefix}wptt_advertisements_content_profiles` SET content = '$content' WHERE id='$val'";
					$result = $wpdb->get_results($sql, ARRAY_A);
				}
				else
				{
					//echo 2; exit;
				}
			}
		}
	}

	if ($_GET['all']==1)
	{

		$sql = "ALTER TABLE `{$table_prefix}wptt_wpcookie_global_profiles` ADD status INT(1)";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "ALTER TABLE `{$table_prefix}wptt_wpcookie_global_profiles` ADD exclude_items VARCHAR(225)";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "ALTER TABLE `{$table_prefix}wptt_cloakme_profiles` ADD type VARCHAR(20)";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "ALTER TABLE `{$table_prefix}wptt_cloakme_profiles` ADD stuff_cookie VARCHAR(255)";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "ALTER TABLE `{$table_prefix}wptt_cloakme_profiles` ADD keywords MEDIUMTEXT";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "ALTER TABLE `{$table_prefix}wptt_cloakme_profiles` ADD keywords_limit INT(1)";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "ALTER TABLE `{$table_prefix}wptt_cloakme_profiles` ADD keywords_limit_total INT(1)";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "ALTER TABLE `{$table_prefix}wptt_cloakme_profiles` ADD keywords_affect INT(1)";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "ALTER TABLE `{$table_prefix}wptt_cloakme_profiles` ADD keywords_target_page VARCHAR(7)";
		$result = $wpdb->get_results($sql, ARRAY_A);


		$sql = "ALTER TABLE `{$table_prefix}wptt_wpredirect_profiles` ADD exclude_items VARCHAR(225)";
		$result = $wpdb->get_results($sql, ARRAY_A);

		//global settings
		$sql = "INSERT INTO {$table_prefix}wptt_wptraffictools_options (
			`id`,`option_name`,`option_value`,`status`)
			VALUES ('3','cloak_links','0','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "INSERT INTO {$table_prefix}wptt_wptraffictools_options (
			`id`,`option_name`,`option_value`,`status`)
			VALUES ('4','redirect_spiders','0','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);	

		$sql = "INSERT INTO {$table_prefix}wptt_wptraffictools_options (
			`id`,`option_name`,`option_value`,`status`)
			VALUES ('9','cloak_link_profiles','1','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "INSERT INTO {$table_prefix}wptt_wptraffictools_options (
			`id`,`option_name`,`option_value`,`status`)
			VALUES ('11','keyword_affects','1','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "INSERT INTO {$table_prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('12','cloak_comments','1','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "INSERT INTO {$table_prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('13','cloak_commenter_url','1','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "INSERT INTO {$table_prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('14','topsearches','0','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);


		$sql = "INSERT INTO {$table_prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('16','topsearches_nature','single','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "INSERT INTO {$table_prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('17','topsearches_header','<h2>Top Searches</h2>','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "INSERT INTO {$table_prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('18','topsearches_sort','DESC','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "INSERT INTO {$table_prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('19','topsearches_limit','5','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "INSERT INTO {$table_prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('20','topsearches_link','0','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "INSERT INTO {$table_prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('21','topsearches_display_count','0','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);


		$sql = "INSERT INTO {$table_prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('22','cloak_links_pages','0','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);



		$sql = "CREATE TABLE wpt_classification_prefixes (
							id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
							option_name VARCHAR(255) NOT NULL,
							option_value TEXT NOT NULL,
							status INT(2) NOT NULL
							) {$charset_collate};";
					$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "CREATE TABLE {$table_prefix}wptt_wpredirect_profiles (
					id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					post_id VARCHAR(20) NOT NULL,
					redirect_url VARCHAR(255) NOT NULL,
					redirect_keywords TEXT NOT NULL,
					blank_referrer INT(1) NOT NULL,
					ignore_spider INT(1) NOT NULL,
					redirect_type INT(1) NOT NULL,
					redirect_count INT(10) NOT NULL,
					exclude_items VARCHAR(225) NOT NULL
					) {$charset_collate};";
		$result = $wpdb->get_results($sql, ARRAY_A);


		$sql = "CREATE TABLE {$table_prefix}wptt_advertisements_content_profiles (
			id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			content TEXT NOT NULL,
			profile_name VARCHAR(255) NOT NULL
			) {$charset_collate};";

		$result = $wpdb->get_results($sql, ARRAY_A);	

		$sql = "CREATE TABLE {$table_prefix}wptt_advertisements_post_profiles (
			id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			post_id VARCHAR(12) NOT NULL,
			content_profile_id VARCHAR(12) NOT NULL,
			placement VARCHAR(25) NOT NULL,
			drop_count INT(12) NOT NULL
			) {$charset_collate};";

		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "CREATE TABLE {$table_prefix}wptt_advertisements_keywords_profiles (
			id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			keywords VARCHAR(225) NOT NULL,
			content_profile_id VARCHAR(12) NOT NULL,
			placement VARCHAR(25) NOT NULL,
			search_content INT(1) NOT NULL,
			search_referral INT(1) NOT NULL,
			status INT(1) NOT NULL,
			drop_count INT(12) NOT NULL
			) {$charset_collate};";
			
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "CREATE TABLE {$table_prefix}wptt_advertisements_category_profiles (
					id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					content_profile_id VARCHAR(12) NOT NULL,
					category_id INT(10) NOT NULL,
					placement VARCHAR(25) NOT NULL,
					status INT(1) NOT NULL,
					drop_count INT(12) NOT NULL
					) {$charset_collate};";
			
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "INSERT INTO {$table_prefix}wptt_wptraffictools_options (
			`id`,`option_name`,`option_value`,`status`)
			VALUES ('10','default_classification_prefix','go','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "CREATE TABLE {$table_prefix}wptt_advertisements_google_profiles (
					id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					content_profile_id VARCHAR(12) NOT NULL,
					placement VARCHAR(25) NOT NULL,
					status INT(1) NOT NULL,
					drop_count INT(12) NOT NULL
					) {$charset_collate};";
			
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "CREATE TABLE {$table_prefix}wptt_wptraffictools_google (
					id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					post_id INT(15) NOT NULL,
					permalink VARCHAR(225) NOT NULL,
					keyword VARCHAR(225) NOT NULL UNIQUE,
					count INT(20)
					) {$charset_collate};";
				
		$result = $wpdb->get_results($sql, ARRAY_A);	

		$sql = "ALTER TABLE `{$table_prefix}wptt_wptraffictools_google` ADD permalink VARCHAR(225)";
		$result = $wpdb->get_results($sql, ARRAY_A);


		$sql = "ALTER TABLE `{$table_prefix}wptt_wptraffictools_google` ADD count INT(20)";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "INSERT INTO wpt_classification_prefixes (
				`id`,`option_name`,`option_value`,`status`)
				VALUES ('1','classification_prefix','go','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "DELETE FROM `{$table_prefix}wptt_wptraffictools_options` WHERE option_name='topsearches_display'";
		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "ALTER TABLE `{$table_prefix}wptt_wpredirect_profiles` ADD redirect_keywords TEXT";

		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "ALTER TABLE `{$table_prefix}wptt_cloakme_profiles` ADD redirect_url TEXT";

		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "CREATE TABLE {$wpdb->prefix}wptt_popups_profiles (
			id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			type VARCHAR(225) NOT NULL,
			nature VARCHAR(225) NOT NULL,
			width INT(5) NOT NULL,
			height INT(5) NOT NULL,
			href TEXT NOT NULL,
			delay INT(10) NOT NULL,
			search_keywords TEXT NOT NULL,
			search_content INT(1) NOT NULL,
			search_referrer INT(1) NOT NULL,
			include_ids TEXT NOT NULL,
			exclude_ids TEXT NOT NULL,
			drop_count INT(12) NOT NULL,
			status INT(1) NOT NULL
			) {$charset_collate};";

		$result = $wpdb->get_results($sql, ARRAY_A);
	}
}

if ($multisite==1)
{
	switch_to_blog($old_blog);
}


echo "all done!";
?>