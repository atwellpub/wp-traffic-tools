<?php

define("QUICK_CACHE_ALLOWED", false); 
define("DONOTCACHEPAGE", true); 
define('DONOTCACHCEOBJECT', true); 
define('DONOTCDN', true); 

$keywords_nature = $_COOKIE['keywords_nature'];
$keywords_query = $_COOKIE['keywords_query'];
$spider_check = $_COOKIE['wpttcheck'];

//echo $keywords_query;exit;

include_once('./../../../wp-config.php');

$timezone_format = _x('Y-m-d', 'timezone date format');
$date =  date_i18n($timezone_format);

$permalink = $_GET['permalink'];

$parts = explode('?',$permalink);
$permalink = $parts[0];
if (isset($parts[1]))
{
	$params = explode('&',$parts[1]);
}

//check for extra parameters
if (strstr($permalink,' '))
{
	$parameters_array = explode(" ",$permalink);
	array_shift($parameters_array);
	$extra_parameters = "?";
	
	$i=0;
	foreach ($parameters_array as $key=> $value)
	{
		//echo $value. "<br>";
		if ($i==0)
		{
			$extra_parameters = $extra_parameters.$value;
			$i++;
		}
		else
		{
			$extra_parameters = $extra_parameters."&".$value;
		}
	}

	$permalink = str_replace(' ', '+', $permalink);
	$permalink = str_replace('%', '%25', $permalink);
	
	//check for keyword token instances
	$extra_parameters = str_replace('%25keyword_query%25',$keywords_query,$extra_parameters);
	$extra_parameters = str_replace('%keyword_query%',$keywords_query,$extra_parameters);

}




//clean up permalink
$permalink = str_replace('/','',$permalink);
$referrer = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '' ;


if (!$keywords_nature)
{
	$keywords_nature = 'n/a';
}
if (!$keywords_query)
{
	$keywords_query = 'n/a';
}

$wordpress_url = get_bloginfo( 'url' ); 
if (substr($wordpress_url, -1, -1)!='/')
{
	$wordpress_url = $wordpress_url."/";
}
				
function wptt_url_exists($url) {
    // Version 4.x supported
    $handle   = curl_init($url);
    if (false === $handle)
    {
        return false;
    }
    curl_setopt($handle, CURLOPT_HEADER, false);
    curl_setopt($handle, CURLOPT_FAILONERROR, true);  // this works
    curl_setopt($handle, CURLOPT_HTTPHEADER, Array("User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.15) Gecko/20080623 Firefox/2.0.0.15") ); // request as if Firefox   
    curl_setopt($handle, CURLOPT_NOBODY, true);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, false);
    $connectable = curl_exec($handle);
    curl_close($handle);  
    return $connectable;
}

if ($spider_check!=1)
{
	/* Retrieve the global settings */ 
	$query = "SELECT `option_value` FROM {$table_prefix}wptt_wptraffictools_options WHERE option_name='wptt_options' ORDER BY id ASC";
	$result = mysql_query($query);

	if ($result)
	{
		//echo 1;exit;
		$array = mysql_fetch_array($result);
		$wptt_options = $array['option_value'];
		$wptt_options = str_replace("\r\n", "\n", $wptt_options);
		$wptt_options = str_replace("\r", "\n", $wptt_options);
		$wptt_options = str_replace("\n", "\\n", $wptt_options);
		$wptt_options = json_decode($wptt_options, true);
		//print_r($wptt_options);exit; 
		
		$useragents = $wptt_options['useragents'];
		$ip_addresses = $wptt_options['ip_addresses'];
		$shadowmaker_username = (isset($wptt_options['shadowmaker_username'])) ? $wptt_options['shadowmaker_username'] : '';
	}
	
	$useragents = explode(';', $useragents);
	$ip_addresses = explode(';', $ip_addresses);
	$visitor_useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
	//echo $visitor_useragent;exit;
	//echo "<hr>";
	$visitor_ip = $_SERVER['REMOTE_ADDR'];
	
	$spider =1;
	//check to make sure useragent is present
	if ($visitor_useragent)
	{
		foreach ($useragents as $k=>$v) 
		{
			//echo $v;
			//echo "<br>";
			$v = trim($v);
			if ($v)
			{
				if(stristr($visitor_useragent, $v))
				{
					$spider = 0;
					//echo $v;exit;
				}
			}
		}
	}
	//echo $visitor_useragent;exit;
	//echo $spider;exit;
	if ($spider!=1)
	{
		//check for blocked ip
		if ($ip_addresses)
		{			
			if ($shadowmaker_username)
			{
				$query = "SELECT * FROM wptt_ip_addresses WHERE string = '$visitor_ip' LIMIT 1";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); exit;}	
				$count = mysql_num_rows($result);
				if ($count>0)
				{
					$spider=1;
				}
			}
			else
			{
				foreach ($ip_addresses as $k=>$v)
				{
					$v = str_replace('*','(.*)',$v);
					
					//echo $v;
					if((preg_match("/$v/",$visitor_ip)&&$v))
					{
						//echo 2;exit;
						$spider=1;
					}				
				}
			}
		}
	}
}
else
{
	//echo 2;exit;
	$spider=1;
}


//echo $visitor_useragent; exit;
//print_r($useragents);exit;
$release = 1;
//get affiliate url
$query = "SELECT * FROM {$table_prefix}wptt_cloakme_profiles WHERE permalink='$permalink'";
$result = mysql_query($query);
if (!$result){echo $query; echo mysql_error(); exit;}
while ($arr = mysql_fetch_array($result))
{
	
	$release = 0;
	$redirect_id = $arr['id'];
	$redirect_url = $arr['redirect_url'];
	
	$rotate_urls = $arr['rotate_urls'];
	$rotate_urls_count = $arr['rotate_urls_count'];
	$rotate_marker = $arr['rotate_marker'];
	$blank_referrer = $arr['blank_referrer'];
	$spoof_referrer_url = trim($arr['spoof_referrer_url']);
	$spoof_referrer_url =  preg_split("/[\r\n,]+/", $spoof_referrer_url, -1, PREG_SPLIT_NO_EMPTY);
	$rand_key = array_rand($spoof_referrer_url);
	$spoof_referrer_url = (isset($spoof_referrer_url[$rand_key])) ? $spoof_referrer_url[$rand_key] : '';
	$redirect_spider = $arr['redirect_spider'];
	$redirect_method = $arr['redirect_method'];
	$redirect_method_url = $arr['redirect_method_url'];
	$redirect_type = $arr['redirect_type'];
	$iframe_target = $arr['cloak_target'];
	$stuff_cookie = $arr['stuff_cookie'];

	
	if ($redirect_type==301)
	{
		$redirect_type = "301 Moved Permanently";
	}
	else if ($redirect_type==302)
	{
		$redirect_type = "302 Moved Temporarily";
	}
	else if ($redirect_type==303)
	{
		$redirect_type = "303 See Other";
	}
	else if ($redirect_type==307)
	{
		$redirect_type = "307 Temporary Redirect";
	}
	else
	{
		$redirect_type = "307 Temporary Redirect";
	}
	
}

//echo $redirect_spider;exit;
if ($redirect_spider==1&&$release==0)
{
	//echo $spider;exit;
	if ($spider!=1)
	$go =1;
	
}
if ($redirect_spider==0&&$release==0)
{
	$go=1;
}

//echo $go;exit;
//echo $redirect_spider;exit;

if ($go==1)
{
	
	//echo $iframe_target;exit;
	//$redirect_url = strtolower($redirect_url);
	if (strstr($redirect_url,'{')&&!$spider)
	{
		//echo traffic_tools_remote_connect('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']);
		$geo_array = unserialize(traffic_tools_remote_connect('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
		//print_r($geo_array);
		//echo "<br>";
		//exit;
		$redirect_url = explode("\n",$redirect_url);
		foreach ($redirect_url as $key=>$val)
		{
			if (!$check)
			{
				preg_match('/{(.*?)}/i',$val,$match);
				
				if ($match)
				{
					//print_r($match);
					//echo "<hr>";
					$newmatch = explode(":",$match[1]);
					
					if ($newmatch[0]=='areacode'){$newmatch[0]='areaCode';}
					else if ($newmatch[0]=='countrycode'){$newmatch[0]='countryCode';}
					else if ($newmatch[0]=='regioncode'){$newmatch[0]='regionCode';}
					if (strtolower($geo_array["geoplugin_".$newmatch[0]])==$newmatch[1])
					{
					
						$val = explode("{",$val);
						$val = $val[0];
						$redirect_url = $val;
						$check = 1;
					}
				}
				else
				{
					$new_rotate_urls[] = $val;
				}
			}			
		}
		if (!$check)
		{
						
			$rand_key = array_rand($new_rotate_urls);
			$redirect_url = $new_rotate_urls[$rand_key];
			
		}
	}
	else
	{
		if ($rotate_urls==1)
		{	
			$redirect_url = explode("\n",$redirect_url);
			$redirect_url = array_filter($redirect_url);

			$count = count($redirect_url);
			
			$rotate_count_marker = get_option('wptt_rotate_count_'.$redirect_id, 0);
			
			if ($count==1) {
				$rotate_marker = 0;
				$next_key = 0;
			}
			else if ($rotate_count_marker>$rotate_urls_count)
			{
				update_option('wptt_rotate_count_'.$redirect_id, 1 );
				if(empty($rotate_marker))
				{
					$rotate_marker = 0;
					$next_key = 1;
				}
				else
				{		
					if ($rotate_marker>=$count)
					{
						$next_key = 1;
						$rotate_marker = 0;
					}
					else
					{
						//echo '<br>'.$count.'<br>ohthere:'.$rotate_marker;
						$next_key = $rotate_marker+1;
					}
				}
			}
			else
			{				
				if(empty($rotate_marker))
					$rotate_marker = 0;
				
				$next_key = 0;
				
				$rotate_count_marker++;
				update_option('wptt_rotate_count_'.$redirect_id, $rotate_count_marker);
			}
			
			$query = "UPDATE {$table_prefix}wptt_cloakme_profiles SET rotate_marker='{$next_key}' WHERE permalink='$permalink'";
			$result = mysql_query($query);
			if (!$result){echo $query; echo mysql_error(); exit;}

			if (isset($redirect_url[$rotate_marker]))
			$redirect_url = $redirect_url[$rotate_marker];
		}
		else
		{
			$redirect_url = explode("\n",$redirect_url);
			$rand_key = array_rand($redirect_url);
			$redirect_url = $redirect_url[0];
		}
	}
	
	$redirect_url = trim($redirect_url);
	if (isset($extra_parameters))
	{
		$redirect_url = $redirect_url.$extra_parameters;
	}
	

	if (defined('WPTT_CLOAKED_LINK_DEFAULT_PARAM')){
		$defaults = array();
		parse_str( WPTT_CLOAKED_LINK_DEFAULT_PARAM , $defaults );
		
		if (isset($params)) {
			foreach ( $defaults as $key=>$value) {
				if (isset($params[$key])) {
					unset($defaults[$key]);
				}
			}
			$params = $params + $defaults;
		}else {
			$params = $defaults;
		}
		
	}
	
	if (isset($params)) {		
		
		if (strstr($redirect_url,'?'))
		{
			foreach ( $params as $key=>$param ) {
				$redirect_url = $redirect_url.'&'.$key .'='.$param;
			}
			
		}
		else
		{
			$i=0;
			foreach ( $params as $key=>$param ) {
				if ($i==0) {				
					$redirect_url = $redirect_url.'?'.$key .'='.$param;
				}else {
					$redirect_url = $redirect_url.'&'.$key .'='.$param;
				}
				$i++;
			}
		}
	}
	
	if ($spider!=1)
	{
		$query = "UPDATE {$table_prefix}wptt_cloakme_profiles SET visitor_count = visitor_count+1 WHERE permalink='$permalink'";
		$result = mysql_query($query);
		if (!$result) { echo $query; echo mysql_error(); }
	}
	else
	{
		$query = "UPDATE {$table_prefix}wptt_cloakme_profiles SET spider_count = spider_count+1 WHERE permalink='$permalink'";
		$result = mysql_query($query);
		if (!$result) { echo $query; echo mysql_error(); }
	}
	
	if (!$referrer) { $referrer = 'none'; }
	
	$query = "SELECT id FROM {$table_prefix}wptt_cloakme_logs WHERE permalink='$permalink' AND target='".addslashes($redirect_url)."' AND referrer= '$referrer' AND keywords_nature = '$keywords_nature' AND keywords_query = '$keywords_query' AND date='$date'";
	$result = mysql_query($query);
	if (!$result) { echo $query; echo mysql_error(); exit; }
	if (mysql_num_rows($result)==1)
	{
		if ($spider!=1)
		{
			$array = mysql_fetch_array($result);
			$id = $array['id'];
			$query = "UPDATE {$table_prefix}wptt_cloakme_logs SET count=count+1 WHERE id='$id'";
			$result = mysql_query($query);
			if (!$result) { echo $query; echo mysql_error(); exit; }
		}
		
	}
	else
	{
		if ($spider!=1)
		{
			$query = "INSERT INTO {$table_prefix}wptt_cloakme_logs (`permalink`,`target`,`referrer`,`keywords_nature`,`keywords_query`,`date`,`count`) VALUES ('$permalink','".addslashes($redirect_url)."','$referrer','$keywords_nature','$keywords_query','$date',1)";
			$result = mysql_query($query);
			if (!$result) { echo $query; echo mysql_error(); exit; }
		}
	}
	
	
	if ($blank_referrer==1)
	{		
		//echo 1; exit;
	
			$spoof_referrer_url = " ";
							
			//$affiliate_url = $wordpress_url."wp-content/plugins/wp-traffic-tools/go.php?url=$affiliate_url_preserved";
			//echo $affiliate_url;exit;
			$ch = curl_init();
			curl_setopt($ch, 	CURLOPT_URL, 	$redirect_url);
			curl_setopt($ch,    CURLOPT_COOKIESESSION,         true);
			curl_setopt($ch,    CURLOPT_FAILONERROR,         false);
			curl_setopt($ch,	CURLOPT_VERBOSE,			1); 		
			curl_setopt($ch,	CURLOPT_REFERER, 			$spoof_referrer_url); 
			if (!ini_get('open_basedir') && !ini_get('safe_mode'))
			{
					curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			}		
			curl_setopt($ch,    CURLOPT_FRESH_CONNECT,         true);
			curl_setopt($ch,    CURLOPT_HEADER,             fasle);
			curl_setopt($ch,    CURLOPT_RETURNTRANSFER,        true);
			curl_setopt($ch,    CURLOPT_CONNECTTIMEOUT,     30);
			$result = curl_exec($ch);
			curl_close($ch);
			
			$pattern = "#Set-Cookie: (.*?; path=.*?;.*?)\n#";
			preg_match_all($pattern, $result, $matches);
			array_shift($matches);
			$cookie = implode("\n", $matches[0]);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $redirect_url);
			// Then, once we have the cookie, let's use it in the next request:
			curl_setopt($ch,    CURLOPT_COOKIE,               $cookie );
			curl_setopt($ch,	CURLOPT_VERBOSE,			1); 		
			curl_setopt($ch,	CURLOPT_REFERER, 			$spoof_referrer_url); 
			curl_setopt($ch,    CURLOPT_COOKIESESSION,         true);
			curl_setopt($ch,    CURLOPT_FAILONERROR,         false);
			if (!ini_get('open_basedir') && !ini_get('safe_mode'))
			{
					curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			}		
			curl_setopt($ch,    CURLOPT_FRESH_CONNECT,         true);
			curl_setopt($ch,    CURLOPT_HEADER,            false);
			curl_setopt($ch,    CURLOPT_RETURNTRANSFER,        true);
			curl_setopt($ch,    CURLOPT_CONNECTTIMEOUT,     30);
			$result = curl_exec($ch);
			curl_close($ch); 
			//echo 1;
			//echo $redirect_url;
			echo $result;
			exit;

	}
	else if ($blank_referrer==2)
	{
		//echo 1; exit;
		$ch = curl_init();
		curl_setopt($ch, 	CURLOPT_URL, 	$redirect_url);
		curl_setopt($ch,    CURLOPT_COOKIESESSION,         true);
		curl_setopt($ch,    CURLOPT_FAILONERROR,         false);
		curl_setopt($ch,	CURLOPT_VERBOSE,			1); 		
		curl_setopt($ch,	CURLOPT_REFERER, 			$spoof_referrer_url); 
		if (!ini_get('open_basedir') && !ini_get('safe_mode'))
		{
				curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		}		
		curl_setopt($ch,    CURLOPT_FRESH_CONNECT,         true);
		curl_setopt($ch,    CURLOPT_HEADER,             fasle);
		curl_setopt($ch,    CURLOPT_RETURNTRANSFER,        true);
		curl_setopt($ch,    CURLOPT_CONNECTTIMEOUT,     30);
		$result = curl_exec($ch);
		curl_close($ch);
		
		$pattern = "#Set-Cookie: (.*?; path=.*?;.*?)\n#";
		preg_match_all($pattern, $result, $matches);
		array_shift($matches);
		$cookie = implode("\n", $matches[0]);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $redirect_url);
		// Then, once we have the cookie, let's use it in the next request:
		curl_setopt($ch,    CURLOPT_COOKIE,               $cookie );
		curl_setopt($ch,	CURLOPT_VERBOSE,			1); 		
		curl_setopt($ch,	CURLOPT_REFERER, 			$spoof_referrer_url); 
		curl_setopt($ch,    CURLOPT_COOKIESESSION,         true);
		curl_setopt($ch,    CURLOPT_FAILONERROR,         false);
		if (!ini_get('open_basedir') && !ini_get('safe_mode'))
		{
				curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		}		
		curl_setopt($ch,    CURLOPT_FRESH_CONNECT,         true);
		curl_setopt($ch,    CURLOPT_HEADER,            false);
		curl_setopt($ch,    CURLOPT_RETURNTRANSFER,        true);
		curl_setopt($ch,    CURLOPT_CONNECTTIMEOUT,     30);
		$result = curl_exec($ch);
		curl_close($ch); 
		//echo 1;
		//echo $redirect_url;
		echo $result;
		//echo 2;exit;
		
		exit;
	}
	else
	{
		if ($iframe_target==1)
		{
			
			$aff_url = str_replace('http://','*h*',$redirect_url);
			$aff_url = str_replace('https://','*hs*',$aff_url);
			$aff_url = urlencode($aff_url);
			
			?>				
				<html lang="en">
				 <head>
				  <title></title>
				  <style type="text/css">
				   html, body, div, iframe { margin:0; padding:0; height:100%; }
				   iframe { display:block; width:100%; border:none; }
				   background { display:none;}
				  </style>
				 </head>
				 <body>
				  <div>
				   <iframe src="<?php echo  $redirect_url;?>" height="100%" width="100%">
				   </iframe>
				   <img src='<?php echo $wordpress_url."wp-content/plugins/wp-traffic-tools/images/special-$aff_url.gif"; ?>'>
				  </div>
				  <?php
				  if ($stuff_cookie)
				  {
					?>						 
					  <div style='display:none;'>
						<iframe src="<?php echo $stuff_cookie; ?>" height="100%" width="100%">
				   </iframe>
						<img src='<?php echo $stuff_cookie; ?>'>
					  </div>
					<?php
				  }
				  ?>
				 </body>
				</html>
			<?php
			exit;
		}
		else
		{
			if ($stuff_cookie)
			{
				//echo 2;exit;
				$redirect_url = str_replace('http://','*h*',$redirect_url);
				$redirect_url = str_replace('https://','*hs*',$redirect_url);
				$redirect_url = urlencode($redirect_url);
			
				$stuff_cookie = str_replace('http://','*h*',$stuff_cookie);
				$stuff_cookie = str_replace('https://','*hs*',$stuff_cookie);
				$stuff_cookie = urlencode($stuff_cookie);
			
				$redirect_url = $wordpress_url."wp-content/plugins/wp-traffic-tools/redirect.php?url=$redirect_url&stuff_cookie=$stuff_cookie";

				//echo $redirect_url;exit;
				header("HTTP/1.1 $redirect_type ");
				header("Location: $redirect_url");
				exit;
			}
			else
			{
				//echo 1;exit;
				header("HTTP/1.1 $redirect_type ");
				header("Location: $redirect_url");
				exit;
			}
		}
	}
	
}


if ($redirect_method=='random')
{
	$query = "SELECT guid FROM ".$table_prefix."posts WHERE post_status='publish' AND post_type='post' ORDER BY ID LIMIT 10";
	$result = mysql_query($query);
	if (!$result){echo $query; echo mysql_error(); exit; }
	
	$count = mysql_num_rows($result);
	
	if ($count >0)
	{
		while ($arr = mysql_fetch_array($result))
		{
			$list[] = $arr['guid'];			
		}
		$rand = array_rand($list);
		$url = $list[$rand];
	}
	else
	{
		$url = get_bloginfo('url');

	}
}
else if ($redirect_method=='none')
{
	$url =  $referrer;
	if (!$url) { $url = get_bloginfo('url'); }
}
else if ($redirect_method=='custom')
{
	$url =  $redirect_method_url;
}
else
{
	$url = get_bloginfo('url');
}

if ($spider==1)
{
	$query = "UPDATE {$table_prefix}wptt_cloakme_profiles SET spider_count = spider_count+1 WHERE permalink='$permalink'";
	$result = mysql_query($query);
	if (!$result) { echo $query; echo mysql_error(); }
}

header("HTTP/1.1 307 Temporary Redirect");
header("Location: $url");
exit;
?>