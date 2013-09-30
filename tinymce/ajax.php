<?php
include_once('./../../../../wp-config.php');
$method = $_GET['method'];
$wordpress_url = get_bloginfo('url');

if (substr($wordpress_url, -1)!='/')
{
	$wordpress_url = $wordpress_url."/";
}

if ($method=='create_new')
{
	$classification_prefix = $_GET['var1'];
	$permalink = $_GET['var2'];
	if (!$permalink)
	{
		$secret_phrase ="1234567890cloakme";
		$key = str_shuffle($secret_phrase);
		$permalink = substr($key, 0, 5);
	}
	else
	{
		$permalink = sanitize_title_with_dashes($permalink);
	}
	
	$redirect_url = $_GET['var3'];
	$redirect_url = urldecode($redirect_url);
	$blank_referrer = $_GET['var4'];
	$redirect_spider = $_GET['var5'];
	$redirect_method = $_GET['var6'];
	$redirect_type = $_GET['var7'];
	$cloak_target = $_GET['var4'];

	
	$cloaked_url = $wordpress_url.$classification_prefix."/".$permalink;
	
	
	$query = "INSERT INTO {$table_prefix}wptt_cloakme_profiles (`id`,`classification_prefix`,`permalink`,`cloaked_url`,`redirect_url`,`blank_referrer`,`redirect_spider`,`redirect_method`,`redirect_type`,`cloak_target`,`visitor_count`,`spider_count`,`type`) VALUES ('','$classification_prefix','$permalink','$cloaked_url','$redirect_url','$blank_referrer','$redirect_spider','$redirect_method','$redirect_type','$cloak_target','0','0','affiliate')";
	$result = mysql_query($query);
	if (!$result){echo $query; echo mysql_error(); exit;}
	
	echo $cloaked_url;
}
else
{
	$profile_id = $_GET['var1'];
	/* Retrieve the profile data */ 
	$query = "SELECT * FROM {$table_prefix}wptt_cloakme_profiles	WHERE id='$profile_id' LIMIT 1";
	$result = mysql_query($query);
	if (!$result){echo $query; echo mysql_error(); exit;}
	while ($arr = mysql_fetch_array($result))
	{		
		$cloaked_url = $arr['cloaked_url'];
	}
	echo $cloaked_url;
}
?>