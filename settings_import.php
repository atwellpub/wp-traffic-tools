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
	
	function clean_cdata($input)
	{
	  if (strstr($input, "<![CDATA["))
	  {
		$input = str_replace ('<![CDATA[','',$input);
		$input = str_replace (array(']]>',']]&gt;'),'',$input);
	  }
	  return $input;
	}
	
	$m = $_GET['m'];
	
	if ($m==1)
	{
		if ($_FILES["backup_file"])
		{
			//echo 1; exit;
			if ($_FILES["backup_file"]["error"] > 0)
			{
				echo "Error: " . $_FILES["backup_file"]["error"] . "<br />";
			}
			else
			{
				
				$string = file_get_contents($_FILES['backup_file']['tmp_name']);
				//echo $string;exit;
				$profiles = explode('<link_profile>',$string);
				array_shift($profiles);
				//print_r($profiles);
				
				$this_blog_url = get_bloginfo('wpurl');
				if (substr($this_blog_url, -1, 1)!='/')
				{
					$this_blog_url = $this_blog_url."/";
				}
				
				foreach ($profiles as $key=>$val)
				{
					$val = str_replace('</link_profile>','',$val);
					$val = clean_cdata($val);
					$this_array = json_decode($val,true);
					//print_r($this_array);exit;
					
					$permalink = "{$this_blog_url}{$this_array['classification_prefix']}/{$this_array['permalink']}";
					
					$query = " INSERT INTO {$table_prefix}wptt_cloakme_profiles (`id`,`link_masking`,`classification_prefix`,`permalink`,`cloaked_url`,`redirect_url`,`rotate_urls`,`blank_referrer`,`redirect_spider`,`redirect_method`,`redirect_type`,`cloak_target`,`stuff_cookie`,`visitor_count`,`spider_count`,`type`,`keywords`,`keywords_affect`,`keywords_limit`,`keywords_limit_total`,`keywords_target_page`,`notes`)";
					$query .= "VALUES ('','{$this_array['link_masking']}','{$this_array['classification_prefix']}','{$permalink}','{$this_array['cloaked_url']}','{$this_array['redirect_url']}','{$this_array['rotate_urls']}','{$this_array['blank_referrer']}','{$this_array['redirect_spider']}','{$this_array['redirect_method']}','{$this_array['redirect_type']}','{$this_array['cloak_target']}','{$this_array['stuff_cookie']}','0','0','affiliate','{$this_array['keywords']}','{$this_array['keywords_affect']}','{$this_array['keywords_limit']}','{$this_array['keywords_limit_total']}','{$this_array['keywords_target_page']}','{$this_array['notes']}')";
					$result = mysql_query($query);
					
					if (!$result){ echo $query; echo mysql_error(); exit; }
					
					
				}
				echo "<br><br><br><center><i><font color='green'>Success! ".count($profiles)." new profiles imported!</font></center>";
				exit;
			}	
		}
		else
		{
		?>
		<html>
			<head>
			</head>
			<body style="font-family:Khmer UI;">
			<form action=""  enctype="multipart/form-data" method="POST">
			<input   name='m' value='2' type='hidden'>
			<table width="100%">
				<tr>
					<td width='50%' valign='top'>
						<center>							   
						<div style="font-size:14px;width:90%;text-align:left;margin-left:auto;margin-right:auto;font-weight:600;">
						Import WPTT Redirect Profiles

						<hr style="width:100%;color:#eeeeee;background-color:#eeeeee;">
						 
						<table  style="width:100%;margin-left:auto;margin-right:auto;border: solid 1px #eeeeee;"> 
						  <tr>
							 <td  align=left valign=top style="font-size:13px;">
								Select Backup: <br> </td>
							 <td align=right style="font-size:13px;">
								<input type='file'  name='backup_file'>
							</td>
							</tr>				  
							<tr>
								 <td colspan=2 align=center valign=top style='font-size:13px;padding:20px;'>
									<input type=submit value='Import Link Profiles'>
								 </td>
							</tr>
						</table>
					</div>
				</td>
			</table>
			</form>
			
			</body>
			</html>
		<?php
		}
	}
	
	if ($m==2)
	{
		if ($_FILES["backup_file"])
		{
			//echo 1; exit;
			if ($_FILES["backup_file"]["error"] > 0)
			{
				echo "Error: " . $_FILES["backup_file"]["error"] . "<br />";
			}
			else
			{
				
				$string = file_get_contents($_FILES['backup_file']['tmp_name']);
				//echo $string;exit;
				$profiles = explode('<redirect_profile>',$string);
				array_shift($profiles);
				//print_r($profiles);
				
				$this_blog_url = get_bloginfo('wpurl');
				if (substr($this_blog_url, -1, 1)!='/')
				{
					$this_blog_url = $this_blog_url."/";
				}
				
				foreach ($profiles as $key=>$val)
				{
					$val = str_replace('</redirect_profile>','',$val);
					$val = clean_cdata($val);
					$this_array = json_decode($val,true);
					//print_r($this_array);exit;
					
					$permalink = "{$this_blog_url}{$this_array['classification_prefix']}/{$this_array['permalink']}";
					
					$query = "INSERT INTO {$table_prefix}wptt_wpredirect_profiles (`id`,`post_id`,`redirect_url`,`redirect_keywords`,`blank_referrer`,`ignore_spider`,`require_referrer`,`redirect_type`,`redirect_delay`,`human_redirect_count`,`spider_redirect_count`,`exclude_items`,`notes`,`throttle`,`throttle_check`,`status`) VALUES ('','".$this_array['post_id']."','".$this_array['redirect_url']."','".$this_array['redirect_keywords']."','".$this_array['blank_referrer']."','".$this_array['redirect_spider']."','".$this_array['require_referrer']."','".$this_array['redirect_type']."','".$this_array['redirect_delay']."','".$this_array['human_redirect_count']."','".$this_array['spider_redirect_count']."','".$this_array['exclude_items']."','".$this_array['notes']."','".$this_array['throttle']."','0','".$this_array['status']."')";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo mysql_error(); }	
					
					if (!$result){ echo $query; echo mysql_error(); exit; }
					
					
				}
				echo "<br><br><br><center><i><font color='green'>Success! ".count($profiles)." new profiles imported!</font></center>";
				exit;
			}	
		}
		else
		{
		?>
		<html>
			<head>
			</head>
			<body style="font-family:Khmer UI;">
			<form action=""  enctype="multipart/form-data" method="POST">
			<input   name='m' value='2' type='hidden'>

			<table width="100%">
				<tr>
					<td width='50%' valign='top'>
						<center>							   
						<div style="font-size:14px;width:90%;text-align:left;margin-left:auto;margin-right:auto;font-weight:600;">Import WPTT Link Profiles

						<hr style="width:100%;color:#eeeeee;background-color:#eeeeee;">
						 
						<table  style="width:100%;margin-left:auto;margin-right:auto;border: solid 1px #eeeeee;"> 
						  <tr>
							 <td  align=left valign=top style="font-size:13px;">
								Select Backup: <br> </td>
							 <td align=right style="font-size:13px;">
								<input type='file'  name='backup_file'>
							</td>
							</tr>				  
							<tr>
								 <td colspan=2 align=center valign=top style='font-size:13px;padding:20px;'>
									<input type=submit value='Import Redirect Profiles'>
								 </td>
							</tr>
					</table>
				</td>
			</table>
			</form>
			</div>
			</body>
			</html>
		<?php
		}
	}