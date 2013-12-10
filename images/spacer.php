<?php
session_start();
$spacer = 1; 
$this_referrer = trim($_SERVER["HTTP_REFERER"]);
$uri = $_SERVER["REQUEST_URI"];
$wptt_referrer = $_COOKIE["wptt_referrer"];
$visitor_ip = $_SERVER['REMOTE_ADDR'];

//echo $wptt_referrer;exit;
if (isset($_COOKIE["pv"]))
{
	$time =  60 * 60 * 20;
	$new_value = $_COOKIE["pv"] + 1;
	setcookie("pv", $new_value, time()+$time, "/");
	$pageview_count = $new_value;
}
else
{		
	$time = 60 * 60 * 20;
	setcookie("pv", 1, time()+$time, "/");
	$pageview_count = 1;
}
//echo $_COOKIE["pv"];exit;
//$spider_check = $_COOKIE['wpttcheck'];
$spider_check = 0;


if (!$spider_check!=1)
{
	//$this_referrer = '';
	//$wptt_referrer = "";
	
	//echo 1;exit;
	error_reporting(0);
	if(!$this_referrer && strstr($uri,'.php') && $testing!=1)
	{
		header("HTTP/1.0 404 Not Found"); 
		header("Location: ./../../../../404.shtml"); 
		exit;
	}
	else if (!$this_referrer && strstr($uri,'.gif') && $testing!=1)
	{
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: ".gmdate('D, d-M-Y H:i:s \G\M\T',time() - 86400));
		header("Content-Type: image/gif");
		echo file_get_contents('1x1.gif',FILE_BINARY); 
	}  
	else 
	{
		include_once('./../../../../wp-config.php');
		
		$wordpress_url = get_bloginfo( url ); 
		$affiliate_url = urlencode($affiliate_url);
		if (substr($wordpress_url, -1, -1)!='/')
		{
			$wordpress_url = $wordpress_url."/";
		}		
			
		//mail('hudson.atwell@gmail.com','test',$post_id." \n 1 \n".$this_referrer);
		if (!strstr($this_referrer, home_url()))
		{
			$parse = parse_url($this_referrer);
			$this_referrer = str_replace("http://".$parse["host"], home_url(),$this_referrer);
			//mail('hudson.atwell@gmail.com','test',$post_id." \n 2 \n".$this_referrer." \n 3 \n".$_SERVER["HTTP_HOST"]);exit;
		}
		$post_id = url_to_postid($this_referrer);
		if (!$post_id){	$post_id = wptt_url_to_postid($this_referrer); }
		//mail('hudson.atwell@gmail.com','test',$post_id." \n 1 \n".$this_referrer);exit;
		
		$query = "SELECT id FROM {$table_prefix}wptt_wpcookie_affiliate_profiles";
		$result = mysql_query($query);
		if (!$result){echo $query; echo mysql_error(); exit;}
		$count = mysql_num_rows($result);
		
		if ($count==0){exit;};
		
			
		function wptt_check_set_cookie($name,$throttle, $throttle_pageviews)
		{
			global $table_prefix;
			global $pageview_count;
			global $visitor_ip;
			
			if ($throttle_pageviews>0)
			{
				if ($throttle_pageviews<=$pageview_count)
				{
					//echo $throttle_pageviews." v ".$pageview_count; exit;
				}
				else
				{
					return;
				}
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
				$shadowmaker_username = $wptt_options['shadowmaker_username'];
				$useragents = explode(';', $useragents);				
				$ip_addresses = explode(';', $ip_addresses);
				
				$visitor_useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
				
			}
			else
			{
				//echo $query; echo mysql_error(); exit;
			}			
			
			$go=0;
			//check to make sure useragent is present
			foreach ($useragents as $k=>$v)
			{
				$v = trim($v);
				if(strstr($visitor_useragent, $v))
				{
					$go=1;
				}
			}
			
			if ($ip_addresses&&$go==1)
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
					//echo 1; exit;
					foreach ($ip_addresses as $k=>$v)
					{
						$v = str_replace('*','(.*)',$v);
						$v = trim($v);
						
						if((preg_match("/$v/",$visitor_ip)&&$v))
						{
							$go=0;
						}				
					}
				}
			}
			
			if ($go==1)
			{
				$name = str_replace(array("'"," ") , "_" ,$name);
				if (isset($_COOKIE["WPTT_{$name}"]))
				{
					return 0;
				}
				else
				{
					//echo $name; exit;
					$time = $throttle * 60 * 60 * 24;
					setcookie("WPTT_{$name}", 1, time()+$time, "/");
					return 1;
				}
			}
		}
		
		if (!$post_id)
		{
			//check if there are any homepage profiles
			$query = "SELECT affiliate_profile_id FROM {$table_prefix}wptt_wpcookie_post_profiles WHERE post_id='h' LIMIT 1";
			$result = mysql_query($query);
			if (!$result){echo $query; echo mysql_error(); exit;}
			$count = mysql_num_rows($result);
			
			if ($count>0)
			{
				
				$array = mysql_fetch_array($result);
				
				$affiliate_profile_id = $array['affiliate_profile_id'];
				
				$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_affiliate_profiles WHERE id='$affiliate_profile_id'";
				$result = mysql_query($query);
				if (!$result){echo $query; echo mysql_error(); exit;}
				$array = mysql_fetch_array($result);
				
				$affiliate_url = $array['affiliate_url'];	
				$affiliate_url =  preg_split("/[\r\n,]+/", $affiliate_url, -1, PREG_SPLIT_NO_EMPTY);
				if (count($affiliate_url)>1)
				{
					$rand_key = array_rand($affiliate_url);
					$affiliate_url = $affiliate_url[$rand_key];
				}
				else
				{
					$affiliate_url = $affiliate_url[0];
				}
				//echo $affiliate_url;
				
				$profile_name = $array['profile_name'];				
				$throttle = $array['throttle'];
				$throttle_pageviews = $array['throttle_pageviews'];
					
				//header("Location: ".$affiliate_url);
				//exit();
				$result = wptt_check_set_cookie($profile_name,$throttle, $throttle_pageviews);
				if ($result==1)
				{
					header("Location: $affiliate_url");	 
					exit;
				}
			
			}
			
			$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_global_profiles WHERE search_referrer='1' AND status='1'";
			$result = mysql_query($query);
			if (!$result){echo $query; echo mysql_error(); exit;}
			$count = mysql_num_rows($result);
			
			//echo $count;exit;
			if ($count>0)
			{
				unset($affiliate_profile_id);
				while ($arr = mysql_fetch_array($result))
				{					
					$keywords[] = explode(',', $arr['keywords']);
					$search_content[] =$arr['search_content'];
					$search_referrer[] =$arr['search_referrer'];
					$affiliate_profile_id[] = $arr['affiliate_profile_id'];
					$exclude_items[] = $arr['exclude_items'];
				}
				//print_r($keywords);exit;
				foreach ($keywords as $key=>$val)
				{
					//echo $val;
					//echo "<br>";
					foreach ($val as $v)
					{
					
						if (stristr($wptt_referrer,$v))
						{		
							//echo 1; exit;
							$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_affiliate_profiles WHERE id='".$affiliate_profile_id[$key]."'";
							$result = mysql_query($query);
							if (!$result){echo $query; echo mysql_error(); exit;}
							$array = mysql_fetch_array($result);
							
							$affiliate_url = $array['affiliate_url'];	
							$affiliate_url =  preg_split("/[\r\n,]+/", $affiliate_url, -1, PREG_SPLIT_NO_EMPTY);
							if (count($affiliate_url)>1)
							{
								$rand_key = array_rand($affiliate_url);
								$affiliate_url = $affiliate_url[$rand_key];
							}
							else
							{
								$affiliate_url = $affiliate_url[0];
							}
							//echo 1; exit;
							//echo $affiliate_url;exit;
							
							$profile_name = $array['profile_name'];				
							$throttle = $array['throttle'];
							$throttle_pageviews = $array['throttle_pageviews'];
								
							//header("Location: ".$affiliate_url);
							//exit();
							$result = wptt_check_set_cookie($profile_name,$throttle, $throttle_pageviews);
							//echo $result;exit;
							if ($result==1)
							{
								header("Location: $affiliate_url");	 
								exit;
							}
						}
					}
				}
			}
		}
		
		//echo $this_referrer;exit;
		//check if the is a post profile on the post id
		$query = "SELECT affiliate_profile_id FROM {$table_prefix}wptt_wpcookie_post_profiles WHERE post_id='$post_id' ";
		$result = mysql_query($query);
		if (!$result){echo $query; echo mysql_error(); exit;}
		$count = mysql_num_rows($result);
		
		if ($count>0)
		{
			//echo 1; exit;
			$array = mysql_fetch_array($result);
			
			$affiliate_profile_id = $array['affiliate_profile_id'];
			
			$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_affiliate_profiles WHERE id='$affiliate_profile_id'";
			$result = mysql_query($query);
			if (!$result){echo $query; echo mysql_error(); exit;}
			$array = mysql_fetch_array($result);
			
			$affiliate_url = $array['affiliate_url'];	
			$affiliate_url =  preg_split("/[\r\n,]+/", $affiliate_url, -1, PREG_SPLIT_NO_EMPTY);
			if (count($affiliate_url)>1)
			{
				$rand_key = array_rand($affiliate_url);
				$affiliate_url = $affiliate_url[$rand_key];
			}
			else
			{
				$affiliate_url = $affiliate_url[0];
			}
			
			$profile_name = $array['profile_name'];
			$throttle = $array['throttle'];
			$throttle_pageviews = $array['throttle_pageviews'];
			//echo $affiliate_url; exit;
			
			if ($blank_referrer==1)
			{
				
				$blank_referrer_url = $wordpress_url."wp-content/plugins/wp-traffic-tools/redirect.php?url=$redirect_url";	

				$result = wptt_check_set_cookie($profile_name,$throttle, $throttle_pageviews);
				if ($result==1)
				{
					echo "<meta http-equiv='refresh' content='1;url=redirect.php?url={$redirect_url}'>";
					exit;
				}
			}
			else
			{
				
				//header("Location: ".$affiliate_url);
				//exit();
				$result = wptt_check_set_cookie($profile_name,$throttle, $throttle_pageviews);
				if ($result==1)
				{
					header("Location: $affiliate_url");	 
					exit;
				}
			}
		}
		
		//check all global profiles for keyword matches
		$query = "SELECT post_content FROM {$table_prefix}posts WHERE id='$post_id'";
		$result = mysql_query($query);
		if (!$result){echo $query; echo mysql_error(); exit;}
		$count = mysql_num_rows($result);
		
		//mail('hudson.atwell@gmail.com','test',$v." \n a$post_id \n".$post_content);
		
		if ($count>0)
		{
			//mail('hudson.atwell@gmail.com','test',$v." \n 1 \n".$post_content);
			//echo 1; exit;
			$array = mysql_fetch_array($result);
			$post_content = $array['post_content'];
			$post_title = $array['post_title'];
			//echo $post_content;exit;
			
			$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_global_profiles WHERE keywords!='*' AND status='1'";
			$result = mysql_query($query);
			if (!$result){echo $query; echo mysql_error(); exit;}
			$count = mysql_num_rows($result);
			
			if ($count>0)
			{
				$exclude_items = array();
				$keywords = array();
				$search_content = array();
				$search_referrer = array();
				$affiliate_profile_id = array();
				
				while ($arr = mysql_fetch_array($result))
				{
					$keywords[] = explode(',', $arr['keywords']);
					$search_content[] =$arr['search_content'];
					$search_referrer[] =$arr['search_referrer'];
					$affiliate_profile_id[] = $arr['affiliate_profile_id'];
					$exclude_items[] = $arr['exclude_items'];
				}
				
				foreach ($keywords as $key=>$val)
				{
					if ($search_content[$key])
					{
						//echo 1; exit;
						$profile_keywords = $keywords[$key];
						$exclude_array = explode(',',$exclude_items[$key]);
						if (!in_array($post_id,$exclude_array))
						{
							foreach ($profile_keywords as $k=>$v)
							{
								$v = trim($v);
								//echo $v; exit;
								
								$go=1;
								if (stristr($v,'-'))
								{
									$v = str_replace('-','',$v);
									if (stristr($post_content, $v)||stristr($post_title, $v))
									{
										$go=0;
									}
								}
								if (stristr($post_content, $v)&&$go==1||stristr($post_title, $v)&&$go==1)
								{
									
									//mail('hudson.atwell@gmail.com','test',$v." \n 2 \n".$post_content);
									$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_affiliate_profiles WHERE id = '$affiliate_profile_id[$key]'";
									$result = mysql_query($query);
									if (!$result){echo $query; echo mysql_error(); exit;}
									$array = mysql_fetch_array($result);
									$affiliate_url = $array['affiliate_url'];	
									$affiliate_url =  preg_split("/[\r\n,]+/", $affiliate_url, -1, PREG_SPLIT_NO_EMPTY);
									if (count($affiliate_url)>1)
									{
										$rand_key = array_rand($affiliate_url);
										$affiliate_url = $affiliate_url[$rand_key];
									}
									else
									{
										$affiliate_url = $affiliate_url[0];
									}
									$profile_name = $array['profile_name'];
									$throttle = $array['throttle'];
									$throttle_pageviews = $array['throttle_pageviews'];
									
									//$affiliate_url = "http://adistantbo.ranktrack.hop.clickbank.net/";
									$result = wptt_check_set_cookie($profile_name,$throttle, $throttle_pageviews);
									if ($result==1)
									{
										header("Location: $affiliate_url");
										//echo " <iframe src='$affiliate_url' height='100%' width='100%'> </iframe>";	
										exit;
									}
						
								}
							}
						}
					}
					if ($search_referrer[$key])
					{	
						//echo 2;exit;
						$profile_keywords = $keywords[$key];
						$exclude_array = explode(',',$exclude_items[$key]);
						if (!in_array($post_id,$exclude_array))
						{
							foreach ($profile_keywords as $k=>$v)
							{
								$go=1;
								if (stristr($v,'-'))
								{
									$v = str_replace('-','',$v);
									if (stristr($wptt_referrer, $v))
									{
										$go=0;
									}
								}
								
								if (stristr($wptt_referrer, $v)&&$go==1)
								{
									//echo 1; exit;
									$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_affiliate_profiles WHERE id = '$affiliate_profile_id[$key]'";
									$result = mysql_query($query);
									if (!$result){echo $query; echo mysql_error(); exit;}
									$array = mysql_fetch_array($result);
									$affiliate_url = $array['affiliate_url'];	
									$affiliate_url =  preg_split("/[\r\n,]+/", $affiliate_url, -1, PREG_SPLIT_NO_EMPTY);
									if (count($affiliate_url)>1)
									{
										$rand_key = array_rand($affiliate_url);
										$affiliate_url = $affiliate_url[$rand_key];
									}
									else
									{
										$affiliate_url = $affiliate_url[0];
									}
									$profile_name = $array['profile_name'];
									$throttle = $array['throttle'];
									$throttle_pageviews = $array['throttle_pageviews'];
									
									//$affiliate_url = "http://adistantbo.ranktrack.hop.clickbank.net/";
									$result = wptt_check_set_cookie($profile_name,$throttle,$throttle_pageviews);
									if ($result==1)
									{
										header("Location: $affiliate_url");
										//echo " <iframe src='$affiliate_url' height='100%' width='100%'> </iframe>";	
										exit;
									}
								}
							}
						}
					}
				}				
			}
			
			$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_global_profiles WHERE keywords='*' AND status='1'";
			$result = mysql_query($query);
			if (!$result){echo $query; echo mysql_error(); exit;}
			$count = mysql_num_rows($result);
			
			if ($count>0)
			{
				$exclude_items = array();
				while ($arr = mysql_fetch_array($result))
				{
					$keywords[] = explode(',', $arr['keywords']);
					$search_content[] =$arr['search_content'];
					$search_referrer[] =$arr['search_referrer'];
					$affiliate_profile_id[] = $arr['affiliate_profile_id'];
					$exclude_items[] = $arr['exclude_items'];
				}
				
				foreach ($keywords as $key=>$val)
				{
					if ($search_content[$key])
					{
						$profile_keywords = $keywords[$key];
						$exclude_array = explode(',',$exclude_items[$key]);
						if (!in_array($post_id,$exclude_array))
						{
							
							$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_affiliate_profiles WHERE id = '$affiliate_profile_id[$key]'";
							$result = mysql_query($query);
							if (!$result){echo $query; echo mysql_error(); exit;}
							$array = mysql_fetch_array($result);
							$affiliate_url = $array['affiliate_url'];	
							$affiliate_url =  preg_split("/[\r\n,]+/", $affiliate_url, -1, PREG_SPLIT_NO_EMPTY);
							if (count($affiliate_url)>1)
							{
								$rand_key = array_rand($affiliate_url);
								$affiliate_url = $affiliate_url[$rand_key];
							}
							else
							{
								$affiliate_url = $affiliate_url[0];
							}
							$profile_name = $array['profile_name'];
							$throttle = $array['throttle'];
							$throttle_pageviews = $array['throttle_pageviews'];
							
							//$affiliate_url = "http://adistantbo.ranktrack.hop.clickbank.net/";
							$result = wptt_check_set_cookie($profile_name,$throttle, $throttle_pageviews);
							//echo $affiliate_url;exit;
							//echo $result;
							if ($result==1)
							{
								header("Location: $affiliate_url");
								//echo " <iframe src='$affiliate_url' height='100%' width='100%'> </iframe>";	
								exit;
							}		exit;				
						}
					}
					if ($search_referrer[$key])
					{
						$profile_keywords = $keywords[$key];
						$exclude_array = explode(',',$exclude_items[$key]);
						if (!in_array($post_id,$exclude_array))
						{
							$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_affiliate_profiles WHERE id = '$affiliate_profile_id[$key]'";
							$result = mysql_query($query);
							if (!$result){echo $query; echo mysql_error(); exit;}
							$array = mysql_fetch_array($result);
							$affiliate_url = $array['affiliate_url'];	
							$affiliate_url =  preg_split("/[\r\n,]+/", $affiliate_url, -1, PREG_SPLIT_NO_EMPTY);
							if (count($affiliate_url)>1)
							{
								$rand_key = array_rand($affiliate_url);
								$affiliate_url = $affiliate_url[$rand_key];
							}
							else
							{
								$affiliate_url = $affiliate_url[0];
							}
							$profile_name = $array['profile_name'];
							$throttle = $array['throttle'];
							$throttle_pageviews = $array['throttle_pageviews'];
							
							//$affiliate_url = "http://adistantbo.ranktrack.hop.clickbank.net/";
							$result = wptt_check_set_cookie($profile_name,$throttle,$throttle_pageviews);
							if ($result==1)
							{
								header("Location: $affiliate_url");
								//echo " <iframe src='$affiliate_url' height='100%' width='100%'> </iframe>";	
								exit;
							}								
						}
					}
				}
			}
		}
		
	}
}//end if spider check
?>
