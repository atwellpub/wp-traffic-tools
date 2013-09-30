<?php
    session_start();
	define('WP_INSTALLING', true);
	if ( file_exists ( './../../../wp-config.php' ) )
	{
		include_once ( './../../../wp-config.php' );
	}
	else if ( file_exists ( './../../../../wp-config.php' ) )
	{
		include_once ( './../../../../wp-config.php' );
	}

	include_once('./../../../wp-admin/includes/class-pclzip.php');
	global $table_prefix;
	global $wpdb;
	
	
	
	$wordpress_url = get_bloginfo('url');
	if (substr($wordpress_url, -1, -1)!='/')
	{
		$wordpress_url = $wordpress_url."/";
	}
	
	//check for multisite
	if (function_exists('switch_to_blog')) 
	{
		
		$nuprefix = explode('_',$table_prefix);
		$nuprefix= $nuprefix[0]."_";
	}
	else
	{
		$nuprefix = $table_prefix;
	}

	if (!function_exists('traffic_tools_remote_connect'))
	{
		function traffic_tools_remote_connect($url)
		{
			$method1 = ini_get('allow_url_fopen') ? "Enabled" : "Disabled";
			if ($method1 == 'Disabled')
			{
				//do curl
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "$url");
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
				curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
				curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
				$string = curl_exec($ch);
			}
			else
			{
				$string = file_get_contents($url);
			}
			
			return $string;
		}
	}
	
	function traffic_zip_extract($download_file, $store_path)
	{
		//echo 1; exit;
		//echo $remove_path; exit;
		$archive = new PclZip($download_file);
		$list = $archive->extract( PCLZIP_OPT_PATH, $store_path, PCLZIP_OPT_REPLACE_NEWER );
		if ($list == 0) 
		{
			//echo "death here"; exit;
			die("Error : ".$archive->errorInfo(true));
		}
		else
		{
			//print_r($list); exit;
			return 1;
		}
	}
	
	
	$url = 'http://www.hatnohat.com/api/wp-traffic-tools/version_check.php';
	$server_version = traffic_tools_remote_connect($url);
	
	$query = "SELECT `option_value` FROM {$table_prefix}wptt_wptraffictools_options  WHERE option_name='license_key' ";
	$result = mysql_query($query);
	if (!$result){echo $query; echo mysql_error(); exit;}
	
	$array = mysql_fetch_array($result);
	$licence_key = $array['option_value'];
	
	$query = "SELECT `option_value` FROM {$table_prefix}wptt_wptraffictools_options  WHERE option_name='current_version' ";
	$result = mysql_query($query);
	if (!$result){echo $query; echo mysql_error(); exit;}
	
	$array = mysql_fetch_array($result);
	$current_version = $array['option_value'];
	
	
	$url = "http://www.wptraffictools.com/members/wp-traffic-tools.zip";
	
	
	$temp_file = tempnam('/tmp','WPTRAFFICTOOLS');
	//define('WP_TEMP_DIR', ini_get('upload_tmp_dir'));
	//$temp_file = WP_TEMP_DIR;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$file = curl_exec($ch);
	curl_close($ch);
	
	//echo $file;exit;
	
	$handle = fopen($temp_file, "w");
	fwrite($handle, $file);
	fclose($handle);
	
	
	$get = traffic_zip_extract($temp_file, './../../../wp-content/plugins/');
	
	unlink($temp_file);
	
	if ($get==1)
	{
		
		$sql = "UPDATE {$table_prefix}wptt_wptraffictools_options SET option_value='{$server_version}' WHERE option_name='current_version'";
		$result = $wpdb->get_results($sql, ARRAY_A);	
		$path = WP_PLUGIN_URL.'/'.plugin_basename( dirname(__FILE__) ).'/';
		$url = $path."update_sql.php?server_version=$server_version";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		$data = curl_exec($ch);
		
		curl_close($ch);
		//echo $url;
		//echo $data;
		echo 1;
	}
	else
	{
		echo 0;
	}
?>