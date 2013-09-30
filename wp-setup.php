<?php
	
	
	//ACTIVATION / CREATE TABLES
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	
	function wptt_setup_activate() {	   
		global $wpdb;		
	}
	
	//ADD MENU ITEM AND OPTIONS PAGE
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	function wptt_setup_add_javascript()
	{
		?>
			
			<!-- Support for the delete button , we use Javascript here -->
			<script type="text/javascript">
			

			</script>
		<?php
	}
	
	function wptt_display_setup()
	{
		global $global_wptt;
		//cookie_update_settings();
		//cookie_add_javascript();
		//traffic_tools_javascript();
		//traffic_tools_update_check();
		
		//if active show rest of page
		if (strlen($global_wptt)>2)
		{
			include('wptt_style.php');
			echo "<img src='".WPTRAFFICTOOLS_URLPATH."images/wptt_logo.png'>";
			
			echo "<div id='id_wptt_display' class='class_wptt_display'>";
		
			echo '<div class="wrap">';

			echo "<h2>Administration & Optimization</h2>";
			wptt_setup_settings();
			wptt_display_footer();
			echo '</div>';
			echo '</div>';

		}
		else
		{
			//CSS CONTENT
			include('wptt_style.php');
			traffic_tools_activate_prompt(); 
			exit;
		}
		
		

	}
	
	function wptt_setup_settings()
	{
		global $table_prefix;
		global $wptt_options; 
		
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
			
			$global_wptt = $wptt_options['license_key'];
			$global_wptt_handle = $wptt_options['license_email'];
			$pm = explode(".",$wptt_options['permissions']);	

			$url = "http://www.hatnohat.com/api/wp-traffic-tools/validate.php?mode=2&key={$global_wptt}&email={$global_wptt_handle}";
			$rp = "1.1.1.1.1.1";
			$rp = explode(".",$rp);
			
		}
		else
		{
			echo $query; echo mysql_error(); exit;
		}

		?>
		<div class='wptt_featurebox'>
			<form method="post" action="?page=wp-traffic-tools/wp-traffic-tools.php&tab_display=1">
			<input type="hidden" name="action" value="update" />
			
			
			<table class="form-table">
			
				<tr valign="top">
					<th scope="row">Enable Links Module?<br/></th>
					<td>   
					<?php
					   
					   if ($rp==1)
					   {
							?>
							<input type="checkbox" name="wptt_link_module" value='1' <?php if ($is_active==1){ echo "checked='true'"; }?> >
							<?php
						}
						else
						{
							?>
							Buy Now Link!
							<?php
						}
						?>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Enable Redirection Module?<br/></th>
					<td>   
					<?php
					   
					   if ($rp==1)
					   {
							?>
							<input type="checkbox" name="wptt_redirection_module" value='1' <?php if ($is_active==1){ echo "checked='true'"; }?> >
							<?php
						}
						else
						{
							?>
							Buy Now Link!
							<?php
						}
						?>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Enable Ad Management Module?<br/></th>
					<td>   
					<?php
					   
					   if ($rp==1)
					   {
							?>
							<input type="checkbox" name="wptt_advertisements_module" value='1' <?php if ($is_active==1){ echo "checked='true'"; }?> >
							<?php
						}
						else
						{
							?>
							Buy Now Link!
							<?php
						}
						?>
					</td>
				</tr>
				
				
				<tr valign="top">
					<th scope="row">Enable Cookie Management Module?<br/></th>
					<td>   
					<?php
					   
					   if ($rp==1)
					   {
							?>
							<input type="checkbox" name="wptt_cookie_module" value='1' <?php if ($is_active==1){ echo "checked='true'"; }?> >
							<?php
						}
						else
						{
							?>
							Buy Now Link!
							<?php
						}
						?>
					</td>
				</tr>
				
				
				<tr valign="top">
					<th scope="row">Enable Popup Manamenent Module?<br/></th>
					<td>   
					<?php
					   
					   if ($rp==1)
					   {
							?>
							<input type="checkbox" name="wptt_popup_module" value='1' <?php if ($is_active==1){ echo "checked='true'"; }?> >
							<?php
						}
						else
						{
							?>
							Buy Now Link!
							<?php
						}
						?>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Enable TopSearches Module?<br/></th>
					<td>   
					<?php
					   
					   if ($rp==1)
					   {
							?>
							<input type="checkbox" name="wptt_topsearches_module" value='1' <?php if ($is_active==1){ echo "checked='true'"; }?> >
							<?php
						}
						else
						{
							?>
							Buy Now Link!
							<?php
						}
						?>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Enable 404 Handling Module?<br/></th>
					<td>   
					<?php
					   
					   if ($rp==1)
					   {
							?>
							<input type="checkbox" name="wptt_404_module" value='1' <?php if ($is_active==1){ echo "checked='true'"; }?> >
							<?php
						}
						else
						{
							?>
							Buy Now Link!
							<?php
						}
						?>
					</td>
				</tr>
				
			
			
			
			
			</table>
			
			<p class="submit">
			<input type="submit" name="Submit" value="<?php _e('Save Changes') ?>" />
			</p>
			
			</form>
			</div>
		</div>
		<?php
	}
		
	function wptt_setup_update_settings()
	{
		
		global $table_prefix;
		$wordpress_url = get_bloginfo('url');
		
		
		if ($_POST['cookie_affiliate_form_nature']=='save_profile')
		{
			//get all current profiles
			$cookie_affiliate_profile_id = array();
			$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_affiliate_profiles ";
			$result = mysql_query($query);
			if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
			while ($arr = mysql_fetch_array($result))
			{
				$cookie_affiliate_profile_id[] = $arr['id'];
				$cookie_affiliate_profile_name[] = $arr['profile_name'];
				$cookie_affiliate_affiliate_url[] = $arr['affilaite_url'];
				$cookie_affiliate_throttle[] = $arr['throttle'];
				$cookie_affiliate_throttle_pageviews[] = $arr['throttle_pageviews'];
			}
			
			
			//retrieve new batch
			$profile_id = $_POST['cookie_affiliate_profile_id'] ;
			$profile_name = $_POST['cookie_affiliate_profile_name'] ;
			$affiliate_url = $_POST['cookie_affiliate_affiliate_url'] ;
			$throttle = $_POST['cookie_affiliate_throttle'] ;
			$throttle_pageviews = $_POST['cookie_affiliate_throttle_pageviews'] ;
			
			//delete from database what is no longer 
			foreach ($cookie_affiliate_profile_id as $k=>$v)
			{
				if (!in_array($profile_id[$k], $cookie_affiliate_profile_id))
				{
					$query = "DELETE FROM {$table_prefix}wptt_wpcookie_affiliate_profiles WHERE id='$v'";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo mysql_error(); }
				}
			}
			
			if ($profile_id)
			{
				//insert new items and update old items
				foreach ($profile_id as $k=>$v)
				{
					if (!$v&&$profile_name[$k]&&$affiliate_url[$k])
					{
						$query = "INSERT INTO {$table_prefix}wptt_wpcookie_affiliate_profiles (`id`,`profile_name`,`affiliate_url`,`throttle`,`throttle_pageviews`) VALUES ('','$profile_name[$k]','$affiliate_url[$k]','$throttle[$k]','$throttle_pageviews[$k]')";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo mysql_error(); }
					}
					else
					{
						$query = "UPDATE {$table_prefix}wptt_wpcookie_affiliate_profiles SET profile_name='$profile_name[$k]', affiliate_url='$affiliate_url[$k]', throttle='$throttle[$k]', throttle_pageviews='$throttle_pageviews[$k]' WHERE id='$v'";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo mysql_error(); }
					}
				}	
			}
		}
		
		if ($_POST['cookie_global_form_nature']=='save_profile')
		{
			//echo 1;
			//get all current profiles
			$global_profile_id = array();
			
			
			
			//retrieve new batch
			$profile_id = $_POST['cookie_global_profile_id'] ;
			$affiliate_profile_id = $_POST['cookie_global_affiliate_profile_id'] ;
			$keywords = $_POST['cookie_global_keywords'] ;
			$search_content = $_POST['cookie_global_search_content'] ;
			$search_referrer = $_POST['cookie_global_search_referrer'] ;
			$status = $_POST['cookie_global_status'] ;
			$exclude_items = $_POST['cookie_global_exclude_items'] ;
			

			if ($profile_id)
			{
				$del = "";
				foreach ($profile_id as $k=>$v)
				{
					if (!$del)
					{
						$del .= "id!='$v' ";
					}
					else
					{
						$del.="AND id!='$v' ";
					}
				}
				
				if ($del)
				{
					$query = "DELETE FROM {$table_prefix}wptt_wpcookie_global_profiles WHERE $del";
					$result = mysql_query($query);
					if (!$result) { echo $query."<br>"; echo mysql_error();  }
				}
			}
			else
			{
				$query = "DELETE FROM {$table_prefix}wptt_wpcookie_global_profiles";
				$result = mysql_query($query);
				if (!$result) { echo $query."<br>"; echo mysql_error();  }
			}
			
			
			if ($profile_id)
			{
				//insert new items and update old items
				foreach ($profile_id as $k=>$v)
				{
					if ($profile_id[$k]=='x'&&$keywords[$k])
					{
						//echo 1; exit;
						$query = "INSERT INTO {$table_prefix}wptt_wpcookie_global_profiles (`id`,`affiliate_profile_id`,`keywords`,`search_content`,`search_referrer`,`status`,`exclude_items`) VALUES ('','$affiliate_profile_id[$k]','$keywords[$k]','$search_content[$k]','$search_referrer[$k]','$status[$k]','$exclude_items[$k]')";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo mysql_error(); exit; }
					}
					else
					{
						//echo 2; exit;
						$query = "UPDATE {$table_prefix}wptt_wpcookie_global_profiles SET affiliate_profile_id='$affiliate_profile_id[$k]', keywords='$keywords[$k]', search_content='$search_content[$k]', search_referrer='$search_referrer[$k]', status='$status[$k]', exclude_items='$exclude_items[$k]'  WHERE id='$profile_id[$k]'";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo mysql_error(); exit;}
					}
				}	
			}
		}
		
		if ($_POST['cookie_post_form_nature']=='save_profile')
		{
			//echo 1;
			//get all current profiles
			$post_profile_id = array();			
			
			//retrieve new batch
			$profile_id = $_POST['cookie_post_profile_id'];
			$post_id = $_POST['cookie_post_post_id'];
			$affiliate_profile_id = $_POST['cookie_post_affiliate_profile_id'];
			
			//print_r($post_id); exit;
			//delete from database what is no longer 
			
			if ($profile_id)
			{
				$del = "";
				foreach ($profile_id as $k=>$v)
				{
					if (!$del)
					{
						$del .= "id!='$v' ";
					}
					else
					{
						$del.="AND id!='$v' ";
					}
				}
				
				if ($del)
				{
					$query = "DELETE FROM {$table_prefix}wptt_wpcookie_post_profiles WHERE $del";
					$result = mysql_query($query);
					if (!$result) { echo $query."<br>"; echo mysql_error();  }
				}
			}
			else
			{
				$query = "DELETE FROM {$table_prefix}wptt_wpcookie_post_profiles";
				$result = mysql_query($query);
				if (!$result) { echo $query."<br>"; echo mysql_error();  }
			}
			
			
			//insert new items and update old items
			if ($profile_id)
			{
				//echo 1; exit;
				foreach ($profile_id as $k=>$v)
				{
					if ($profile_id[$k]=='x'&&$post_id[$k])
					{
						//echo 1; exit;
						$query = "INSERT INTO {$table_prefix}wptt_wpcookie_post_profiles (`id`,`post_id`,`affiliate_profile_id`) VALUES ('','$post_id[$k]','$affiliate_profile_id[$k]')";
						$result = mysql_query($query);
						if (!$result) { echo $query."<br>"; echo mysql_error(); exit; }
					}
					else
					{
						//echo $profile_id[$k]; exit;
						$query = "UPDATE {$table_prefix}wptt_wpcookie_post_profiles SET affiliate_profile_id='$affiliate_profile_id[$k]', post_id='$post_id[$k]' WHERE id='$profile_id[$k]'";
						$result = mysql_query($query);
						if (!$result) { echo $query."<br>"; echo mysql_error(); exit;}
					}
				}	
			}
		}
	}
	
?>