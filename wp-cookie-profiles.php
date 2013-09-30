<?php

define('COOKIE_URLPATH', WP_PLUGIN_URL.'/'.plugin_basename( dirname(__FILE__) ).'/' );
	
	
	
	//ADD SETTINGS TO POST EDITING AREA
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	
	function cookie_add_meta_box()
	{
		global $rp;
		if ($rp[2]==1)
		{
			add_meta_box( 'wp-cookie-dropper', 'Cookie Options', 'cookie_meta_box' , 'post', 'advanced', 'high' );
			add_meta_box( 'wp-cookie-dropper', 'Cookie Options', 'cookie_meta_box' , 'page', 'advanced', 'high' );
		}
	}
	
	add_action('admin_menu', 'cookie_add_meta_box');
	
	function cookie_meta_box()
	{
	
		global $post;
		global $table_prefix;
		$post_id = $post->ID;
		//echo $post_id;exit;
		
		$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_post_profiles WHERE post_id='{$post_id}' ";
		$result = mysql_query($query);
		if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
		while ($arr = mysql_fetch_array($result))
		{
			$cookie_post_id = $arr['post_id'];
			$cookie_affiliate_profile_id = $arr['affiliate_profile_id'];
		}
		
		$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_affiliate_profiles ";
		$result = mysql_query($query);
		if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
		while ($arr = mysql_fetch_array($result))
		{
			$cookie_profile_id[] = $arr['id'];
			$cookie_profile_name[] = $arr['profile_name'];
		}
		
		
		?>
		<div class=" " id="trackbacksdiv">
			<div class="inside">
					<table>
						<tr>
							<td>
								<label for=keyword>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Redirect URL here."> 
									Cookie to Drop?
								</label>
							</td>
							<td>
								<input type='hidden' name='cookie_post_id' value='<?php echo $post_id; ?>'>
								<select name='cookie_profile_id'>
									<option value='x'>No Dropped Cookies.</option>
									<?php
									
									foreach ($cookie_profile_id as $k=>$v)
									{
										if ($cookie_affiliate_profile_id==$v)
										{
										
											$selected = 'selected';
										}
										else
										{
											$selected = '';
										}
										echo "<option value='$v' $selected>$cookie_profile_name[$k]</option>";
									}
									
									?>
								</select>
							</td>
						</tr>
					</table>
				
				
			</div>	
		</div>
		<?php
	}

	
	//ADD MENU ITEM AND OPTIONS PAGE
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	
	function cookie_add_javascript()
	{
		global $rp;
		if ($rp[2]!=1)
		{
			$add = "disabled='disabled' ";
		}else{ $add = "";}
		$add = str_replace("'",'"',$add);
		?>
			<style type='text/css'>
			input , textarea
			{
				color:#999999;
			}
			.class_navtab_active {

				color:#99999;
				border-left-color: #ADCCE1;
				border-left-style: solid;
				border-left-width: 1px;
				border-right-color: #ADCCE1;
				border-right-style: solid;
				border-right-width: 1px;
				border-top-color: #ADCCE1;
				border-top-style: solid;
				border-top-width: 1px;
				border-bottom-color: #ADCCE1;
				border-bottom-style: solid;
				border-bottom-width: 0px;
				padding-bottom: 0.2em;
				padding-left: 0.5em;
				padding-right: 0.5em;
				padding-top: 0.2em;
				cursor:pointer;
				margin-right:-6px;
				text-decoration:none;
			}
			
			.class_navtab_inactive {
				color:#A3A3A3;

				border-left-color: #A3A3A3;
				border-left-style: solid;
				border-left-width: 1px;
				border-right-color: #A3A3A3;
				border-right-style: solid;
				border-right-width: 1px;
				border-top-color: #A3A3A3;
				border-top-style: solid;
				border-top-width: 1px;
				border-bottom-color: #A3A3A3;
				border-bottom-style: solid;
				border-bottom-width: 1px;
				padding-bottom: 0.2em;
				padding-left: 0.5em;
				padding-right: 0.5em;
				padding-top: 0.2em;
				position: relative;
				cursor:pointer;
				margin-right:-6px;
			}
			
			.class_navtab_spacer {
				color:#A3A3A3;
				border-bottom-color: #A3A3A3;
				border-bottom-style: solid;
				border-bottom-width: 1px;
				padding-bottom: 0.2em;
				padding-left: 0.5em;
				padding-right: 0.5em;
				padding-top: 0.2em;
				position: relative;
				cursor:pointer;
				width:100%;
			}

			.class_container
			{
				border-color:#ADCCE1;
				border-left-style: solid;
				border-left-width: 1px;
				border-bottom-style: solid;
				border-bottom-width: 1px;
				padding:10px;
			}
			</style>
			<!-- Support for the delete button , we use Javascript here -->
			<script type="text/javascript">
				
				function js_cookie_global_delete(profile_id)
				{
				   if (confirm('Are you sure you want to delete this profile?'))
					 {
					   document.cookie_global_profile.action.value = 'coolie_delete_global_profile';
					   document.cookie_global_profile.profile_id.value = profile_id; 
					   document.cookie_global_profile.submit();
					 }
				} 
				
				function js_cookie_post_delete(profile_id)
				{
				   if (confirm('Are you sure you want to delete this profile?'))
					 {
					   document.cookie_post_profile.action.value = 'cookie_delete_post_profile';
					   document.cookie_post_profile.profile_id.value = profile_id; 
					   document.cookie_post_profile.submit();
					 }
				} 
			
				
				jQuery(document).ready(function() 
				{
				
						<?php
					if ($_GET['container']=='affiliate_profiles')
					{
						echo 'jQuery(\'#id_container_cookie_affiliate_profiles\').show();';
						echo 'jQuery(\'#id_container_cookie_keyword_profiles\').hide();';
						echo 'jQuery(\'#id_container_cookie_post_profiles\').hide();';
						
						echo 'jQuery(\'#id_navtab_cookie_affiliate_profiles\').attr(\'class\',\'class_navtab_active\');';
						echo 'jQuery(\'#id_navtab_cookie_keyword_profiles\').attr(\'class\',\'class_navtab_inactive\');';
						echo 'jQuery(\'#id_navtab_cookie_post_profiles\').attr(\'class\',\'class_navtab_inactive\');';
					}
					else if ($_GET['container']=='keyword_profiles')
					{
						echo 'jQuery(\'#id_container_cookie_affiliate_profiles\').hide();';
						echo 'jQuery(\'#id_container_cookie_keyword_profiles\').show();';
						echo 'jQuery(\'#id_container_cookie_post_profiles\').hide();';
						
						echo 'jQuery(\'#id_navtab_cookie_affiliate_profiles\').attr(\'class\',\'class_navtab_inactive\');';
						echo 'jQuery(\'#id_navtab_cookie_keyword_profiles\').attr(\'class\',\'class_navtab_active\');';
						echo 'jQuery(\'#id_navtab_cookie_post_profiles\').attr(\'class\',\'class_navtab_inactive\');';
					}
					else if ($_GET['container']=='post_profiles')
					{
						echo 'jQuery(\'#id_container_cookie_affiliate_profiles\').hide();';
						echo 'jQuery(\'#id_container_cookie_keyword_profiles\').hide();';
						echo 'jQuery(\'#id_container_cookie_post_profiles\').show();';
						
						echo 'jQuery(\'#id_navtab_cookie_affiliate_profiles\').attr(\'class\',\'class_navtab_inactive\');';
						echo 'jQuery(\'#id_navtab_cookie_keyword_profiles\').attr(\'class\',\'class_navtab_inactive\');';
						echo 'jQuery(\'#id_navtab_cookie_post_profiles\').attr(\'class\',\'class_navtab_active\');';
					
					}
					else 
					{
						echo 'jQuery(\'#id_container_cookie_affiliate_profiles\').show();';
						echo 'jQuery(\'#id_container_cookie_keyword_profiles\').hide();';
						echo 'jQuery(\'#id_container_cookie_post_profiles\').hide();';
						
						echo 'jQuery(\'#id_navtab_cookie_affiliate_profiles\').attr(\'class\',\'class_navtab_active\');';
						echo 'jQuery(\'#id_navtab_cookie_keyword_profiles\').attr(\'class\',\'class_navtab_inactive\');';
						echo 'jQuery(\'#id_navtab_cookie_post_profiles\').attr(\'class\',\'class_navtab_inactive\');';
					}
					?>
					
					jQuery('#id_navtab_cookie_affiliate_profiles').live('click', function() {
						jQuery('#id_container_cookie_affiliate_profiles').show();
						jQuery('#id_container_cookie_keyword_profiles').hide();
						jQuery('#id_container_cookie_post_profiles').hide();
						
						jQuery('#id_navtab_cookie_affiliate_profiles').attr('class','class_navtab_active');
						jQuery('#id_navtab_cookie_keyword_profiles').attr('class','class_navtab_inactive');
						jQuery('#id_navtab_cookie_post_profiles').attr('class','class_navtab_inactive');
					});
					
					jQuery('#id_navtab_cookie_keyword_profiles').live('click', function() {
						jQuery('#id_container_cookie_affiliate_profiles').hide();
						jQuery('#id_container_cookie_keyword_profiles').show();
						jQuery('#id_container_cookie_post_profiles').hide();
						
						jQuery('#id_navtab_cookie_affiliate_profiles').attr('class','class_navtab_inactive');
						jQuery('#id_navtab_cookie_keyword_profiles').attr('class','class_navtab_active');
						jQuery('#id_navtab_cookie_post_profiles').attr('class','class_navtab_inactive');
					});
					
					jQuery('#id_navtab_cookie_post_profiles').live('click', function() {
						jQuery('#id_container_cookie_affiliate_profiles').hide();
						jQuery('#id_container_cookie_keyword_profiles').hide();
						jQuery('#id_container_cookie_post_profiles').show();
						
						jQuery('#id_navtab_cookie_affiliate_profiles').attr('class','class_navtab_inactive');
						jQuery('#id_navtab_cookie_keyword_profiles').attr('class','class_navtab_inactive');
						jQuery('#id_navtab_cookie_post_profiles').attr('class','class_navtab_active');
					});
					
					jQuery('#id_affiliate_form_add_profile').click(function() {
						//alert('hello');
						var html = '<tr><td width=\'20\'><input <?php echo $add; ?> type=hidden name=\'cookie_affiliate_profile_id[]\' value=\'\' style=\'width:200%\'></td><td align=left valign="top"><input <?php echo $add; ?>  name=\'cookie_affiliate_profile_name[]\' value=\'\' /></td><td align="left"><textarea <?php echo $add; ?>  name=\'cookie_affiliate_affiliate_url[]\' rows=2 style=\'width:380px\' wrap=\'off\'></textarea></td><td valign=top><input <?php echo $add; ?>  name="cookie_affiliate_throttle[]" value="30" style="width:25px"><img  onClick="jQuery(this).parent().parent().remove();" src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/remove.png" style="cursor:pointer;"></td></tr>';
						jQuery('#id_cookie_table_affiliate_profiles tr:last').after(html);
					});
					
					jQuery('#id_affiliate_form_save_profile').click(function() {
						//alert('hello');
						jQuery("#id_cookie_affiliate_form").submit();
					});
					
					jQuery('#id_global_form_add_profile').click(function() {
						var marker = jQuery('#id_cookie_global_lid').val();
						marker++;
						var affiliate_profiles = jQuery('#id_select_global_affiliate_profiles').clone().html();
						affiliate_profiles = affiliate_profiles.replace('[x]','['+marker+']');
						var status = jQuery('#id_select_global_status').clone().html();
						status = status.replace('[x]','['+marker+']');
						var html = '<tr><td width=\'20\'></td><td><input <?php echo $add; ?>  name=\'cookie_global_profile_id['+marker+']\'  value=\'x\' type="hidden" style=\'width:350px\'><input <?php echo $add; ?>  name=\'cookie_global_keywords['+marker+']\'  value=\'\' style=\'width:350px\'></td><td align=middle><input <?php echo $add; ?>  type="checkbox" name="cookie_global_search_content['+marker+']" value="1" checked = "true"></td><td align=middle><input <?php echo $add; ?>  type="checkbox" name="cookie_global_search_referrer['+marker+']" value="1" checked = "true">			</td><td><input <?php echo $add; ?>  name=\'cookie_global_exclude_items['+marker+']\' value=\'\' size=10></td><td>'+affiliate_profiles+'</td><td>'+status+'</td></tr>';
						jQuery('#id_cookie_table_global_profiles tr:last').after(html);
						jQuery('#id_cookie_global_lid').attr("value",marker);
					
					});
					
					jQuery('#id_global_form_save_profile').click(function() {
						//alert('hello');
						jQuery("#id_cookie_global_form").submit();
					});
					
					
					jQuery('#id_post_form_add_profile').click(function() {
						var marker = jQuery('#id_cookie_post_lid').val();
						marker++;
						var data = jQuery('#id_select_post_affiliate_profiles').clone().html();
						data = data.replace('[x]','['+marker+']');
						var html = '<tr><td width=\'20\'></td><td><input <?php echo $add; ?>  name=\'cookie_post_profile_id['+marker+']\'  value=\'x\' type="hidden" style=\'width:350px\'><input <?php echo $add; ?>  name=\'cookie_post_post_id['+marker+']\'  value=\'\' style=\'width:50px\'></td><td>'+data+'</td></tr>';
						jQuery('#id_cookie_table_post_profiles tr:last').after(html);
						jQuery('#id_cookie_post_lid').attr("value",marker);
					});
					
					jQuery('#id_post_form_save_profile').click(function() {
						//alert('hello');
						jQuery("#id_cookie_post_form").submit();
					});
				});
				


			</script>
		<?php
	}

	
	function wptt_cookie_settings()
	{
		global $table_prefix;
		global $rp;
		$cookie_affiliate_profile_id = array();
		
		if ($rp[2]!=1)
		{
			$add = "disabled='disabled' ";
		}else{ $add = "";}
		
		$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_post_profiles ORDER BY id ASC";
		$result = mysql_query($query);
		if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
		while ($arr = mysql_fetch_array($result))
		{
			$cookie_post_profile_id[] = $arr['id'];
			$cookie_post_post_id[] = $arr['post_id'];
			$cookie_post_affiliate_profile_id[] = $arr['affiliate_profile_id'];
			$cookie_post_drop_count[] = $arr['drop_count'];
		}
		
		$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_global_profiles ORDER BY id ASC";
		$result = mysql_query($query);
		if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
		while ($arr = mysql_fetch_array($result))
		{
			$cookie_global_profile_id[] = $arr['id'];
			$cookie_global_affiliate_profile_id[] = $arr['affiliate_profile_id'];
			$cookie_global_keywords[] = $arr['keywords'];
			$cookie_global_search_content[] = $arr['search_content'];
			$cookie_global_search_referrer[] = $arr['search_referrer'];
			$cookie_global_status[] = $arr['status'];
			$cookie_global_exclude_items[] = $arr['exclude_items'];
			$cookie_global_drop_count[] = $arr['drop_count'];
		}
		
		$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_affiliate_profiles ORDER BY id ASC";
		$result = mysql_query($query);
		if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
		while ($arr = mysql_fetch_array($result))
		{
			$cookie_affiliate_profile_id[] = $arr['id'];
			$cookie_affiliate_profile_name[] = $arr['profile_name'];
			$cookie_affiliate_affiliate_url[] = $arr['affiliate_url'];
			$cookie_affiliate_throttle[] = $arr['throttle'];
			$cookie_affiliate_throttle_pageviews[] = $arr['throttle_pageviews'];
		}
		
		?>
		
		<br><br><br>
		
		<span class='class_navtab_active' id='id_navtab_cookie_affiliate_profiles'>Manage Affiliates (Cookies)</span>
		<span class='class_navtab_inactive' id='id_navtab_cookie_keyword_profiles'>Keyword Placements</span>
		<span class='class_navtab_inactive' id='id_navtab_cookie_post_profiles'>Post Specific Placements</span>	
		
		<div id='id_container_cookie_affiliate_profiles' class='class_container'>	
		
		<h3>Manage Affiliate Profiles</h3>
		<br>
		<div width='100%' style='font-size:10px;'>
			<i>
			DISCLAIMER: This disclaimer serves to advise you against inappropriate uses of this function. Let it be known that use of WP Traffic Tool's cookie stuffing features have the potential to be used to perform criminal activity along the lines of both fraud and theft, depending on the circumstance; in which WP Traffic Tools, as an entity, and it's developer, as a provider of utilities, condemn any and all criminal activity. Propper use of WP Traffic Tool's cookie stuffing features do, and will always, fall under the guiding forces of personal integrity and persional consceince, as well as the personal awareness of the state of legal affairs governing matters related to issues vicariously related to the use of this plugin. It is up to individual parties using this software to determine the best and most appropriate applications of WP Traffic Tool's features and capabilites.  
			</i>
		</div>
		<br><br>
		<span style='background-color:#1E90FF;border-style:solid;border-width:1px;padding:2px;border-color:#000000;color:#fff;cursor:pointer;' id='id_affiliate_form_add_profile'>Add Profile</span>&nbsp&nbsp;&nbsp&nbsp;
		<span style='background-color:#1E90FF;border-style:solid;border-width:1px;padding:2px;border-color:#000000;color:#fff;cursor:pointer;' id='id_affiliate_form_save_profile'>Save Profile(s)</span>


		
		<form name='cookie_affiliate_profile_add' id='id_cookie_affiliate_form' method="post" action="admin.php?page=wptt_slug_submenu_cookie_profiles">
		<input type='hidden' name='cookie_affiliate_form_nature' value='save_profile'>		
		<table id='id_cookie_table_affiliate_profiles' style='width:95%'>
			
			<tr>
				<td width='20' align='middle'>
					#
				</td>
				<td align='left' width='140'>
						<i>Affiliate Profile Name</i>												
				</td>
				<td align='left'>
						<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Add multiple affiliate URLs, one per line, to rotate."> 											
						<i>Affiliate URL</i>											
				</td>
				<td align='left'>
						<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Setting this input to 5 will prevent the cookie from being loaded on the same visitor more than once within a 5 day span of time. Most affiliate cookies have 30 day lifespans but some have less. For example Amazon cookies last for one day only."> 											
						<i>Throttling (in days)</i>											
				</td>
				<td align='left'>
						<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Leave at 0 to disable minimum pageview requirement. Setting this input to 5 will prevent the cookie from being loaded on a visitor unless they have at least visited 5 pages within one session."> 											
						<small><i>Throttling (required # pageviews)</i>	</small>										
				</td>
			</tr>
			<?php
			if ($cookie_affiliate_profile_id)
			{
				foreach ($cookie_affiliate_profile_id as $k=>$v)
				{
					$i=$k+1;
					?>
					<tr>
						<td width='20' valign="top">
							<input <?php echo $add; ?> type=hidden name='cookie_affiliate_profile_id[<?php echo $k; ?>]' value='<?php echo $v; ?>'><?php echo $i; ?>
						</td>
						<td valign="top">
							<input <?php echo $add; ?>  name='cookie_affiliate_profile_name[<?php echo $k; ?>]' size=45 value='<?php echo $cookie_affiliate_profile_name[$k]; ?>' style='width:200px'>			
						</td>
						<td valign="top">
							<textarea <?php echo $add; ?>  name='cookie_affiliate_affiliate_url[<?php echo $k; ?>]' rows='2' style='width:380px' wrap='off'><?php echo $cookie_affiliate_affiliate_url[$k]; ?></textarea>
						</td >
						<td valign="top">
							<input <?php echo $add; ?>  name='cookie_affiliate_throttle[<?php echo $k; ?>]' value='<?php echo $cookie_affiliate_throttle[$k]; ?>' style='width:130px'> 
						</td>
						<td valign="top">
							<input <?php echo $add; ?> size=1 name='cookie_affiliate_throttle_pageviews[<?php echo $k; ?>]' value='<?php echo $cookie_affiliate_throttle_pageviews[$k]; ?>' > 
							<img  onClick='jQuery(this).parent().parent().remove();' src='<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/remove.png' style='cursor:pointer;'>
						</td>
					</tr>
				<?php
					}
				}
				else
				{
					?>
					<tr id='id_cookie_affiliate_no_rows'>
						<td colspan='5'>
							<hr>
						</td>
					</tr>
			<?php
			}
			?>
		</table>				
		</form>
		</div>
		
		<div id='id_container_cookie_keyword_profiles' class='class_container'>
		<h3>Keyword Detection Profiles</h3>
		<br>
		<div width='100%'  style='font-size:10px;'>
			<i>
			DISCLAIMER: This disclaimer serves to advise you against inappropriate uses of this function. Let it be known that use of WP Traffic Tool's cookie stuffing features have the potential be used to perform criminal activity along the lines of both fraud and theft, depending on the circumstance; in which WP Traffic Tools, as an entity, and it's developer, as a provider of utilities, condemn any and all criminal activity. Propper use of WP Traffic Tool's cookie stuffing features do, and will always, fall under the guiding forces of personal integrity and persional conceince, as well as the personal awareness of the state of legal affairs governing matters related to issues vicariously related to the use of this plugin. It is up to individual parties using this software to determine the best and most appropriate applications of WP Traffic Tool's features and capabilites.  
			</i>
		</div>
		<br><br>
		<span style='background-color:#1E90FF;border-style:solid;border-width:1px;padding:2px;border-color:#000000;color:#fff;cursor:pointer;' id='id_global_form_add_profile'>Add Profile</span>&nbsp&nbsp;&nbsp&nbsp;
		<span style='background-color:#1E90FF;border-style:solid;border-width:1px;padding:2px;border-color:#000000;color:#fff;cursor:pointer;' id='id_global_form_save_profile'>Save Profile(s)</span>
		<br><br>
		<form name='cookie_global_profile_add' id='id_cookie_global_form' method="post" action="admin.php?page=wptt_slug_submenu_cookie_profiles">
		<input type='hidden' name='cookie_global_form_nature' value='save_profile'>		
		<table id='id_cookie_table_global_profiles' style='width:95%'>
			<tr>
				<td width='20' align='middle'>
					#
				</td>
				<td align='left' width='140'>
						<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Seperate keywords with commas. Use -keyword to prevent placements on posts containing that keyword. WP Traffic Tools will check post content for these keywords and if found it will drop the associated cookie. Place a * in the 'keywords' input box to drop a cookie on every page, but this feature can only be used once due to the throttling limitation of a one cookie-drop-per-pageload. Also a * WILL NOT apply to the homepage. The homepage must be setup seperatly in the 'Post Specific Plancements' section using 'h' as the post id.  ">  <i>Global Keywords</i>												
				</td>
				<td align='left'>
						<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="If checked WPTT will search both post title and content to determine matches. ">
						<i>Search Content</i>
				</td>
				<td align='left'>
						<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="If selected WPTT will search the referring url for keyword matches. ">
						<i>Search Referrer</i>
				</td>				
				<td align='left'>
						<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Enter post ID(s) seperated by comma. Exclude these items from cookie dropping. Homepage and archive pages are naturally excluded from all keyword based cookie profiles. ">
						<i>Exclude Items</i>
				</td>
				<td align='left'>
						<i>Affiliate Profile</i>											
				</td>				
				<td align='left'>
						<i>Profile Status</i>
				</td>
			</tr>
			<?php
			if ($cookie_global_profile_id)
			{
				foreach ($cookie_global_profile_id as $k=>$v)
				{
					$i=$k+1;
					$lid = $v;
					?>
					<tr>
						<td width='20'>
							<input <?php echo $add; ?> type=hidden name='cookie_global_profile_id[<?php echo $v; ?>]' value='<?php echo $v; ?>'><?php echo $i; ?>
						</td>
						<td>
							<input <?php echo $add; ?>  name='cookie_global_keywords[<?php echo $v; ?>]' value='<?php echo $cookie_global_keywords[$k]; ?>' style='width:350px'>			
						</td>
						<td align=middle>
							<input <?php echo $add; ?>  type='checkbox' name='cookie_global_search_content[<?php echo $v; ?>]' value='1' <?php if ($cookie_global_search_content[$k]==1){echo "checked=true";} ?>>			
						</td>
						<td align=middle>
							<input <?php echo $add; ?>  type='checkbox' name='cookie_global_search_referrer[<?php echo $v; ?>]' value='1' <?php if ($cookie_global_search_referrer[$k]==1){echo "checked=true";} ?>>			
						</td>
						<td>
							<input <?php echo $add; ?>  name='cookie_global_exclude_items[<?php echo $v; ?>]' value='<?php echo $cookie_global_exclude_items[$k]; ?>' size=10>			
						</td>
						<td >
							<select name='cookie_global_affiliate_profile_id[<?php echo $v; ?>]'>
									<?php
									
									foreach ($cookie_affiliate_profile_id as $a=>$b)
									{
										if ($cookie_global_affiliate_profile_id[$k]==$b)
										{
											//echo 1; exit;
											$selected = 'selected=true';
										}
										else
										{
											$selected = '';
										}
										
										echo "<option value='$b' $selected>$cookie_affiliate_profile_name[$a]</option>";
									}
									
									?>
							</select>
						</td>
						<td >
							<select name='cookie_global_status[<?php echo $v; ?>]'>
								<?php
									if ($cookie_global_status[$k]=='1')
									{
										echo "<option value='1' selected=true>Active</option>";
										echo "<option value='0' >Not Active</option>";
									}
									else
									{
										echo "<option value='1'>Active</option>";
										echo "<option value='0' selected=true>Not Active</option>";
									}	
								?>
							</select>
							<img  onClick='jQuery(this).parent().parent().remove();' src='<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/remove.png' style='cursor:pointer;'>
						</td>
					</tr>
				<?php
				}
				echo "<input type='hidden' id='id_cookie_global_lid' value='$lid'>";
			}
			else
			{
					?>					
					<input <?php echo $add; ?> type='hidden' id='id_cookie_global_lid' value='0'>
			<?php
			}
			?>
			
		</table>				
		</form>
		<table>
			<tr style='display:none'>					
						
						<td id='id_select_global_affiliate_profiles'>
							<select name='cookie_global_affiliate_profile_id[x]'>
									<?php
									
									foreach ($cookie_affiliate_profile_id as $a=>$b)
									{
										if ($cookie_global_affiliate_profile_id[$k]==$b)
										{
											$selected = 'selected=true';
										}
										else
										{
											$selected = '';
										}
										
										echo "<option value='$b' $selected>$cookie_affiliate_profile_name[$a]</option>";
									}
									
									?>
							</select>
						</td>
						<td id='id_select_global_status'>
							<select name='cookie_global_status[x]'>
									<option value='1'>Active</option>
									<option value='0' selected=true>Not Active</option>
							</select>
						</td>
					</tr>
		</table>
		</div>
		
		
		<div id='id_container_cookie_post_profiles' class='class_container'>
		<h3>Post Specific Profiles</h3>
		<br>
		<div width='100%'  style='font-size:10px;'>
			<i>
			DISCLAIMER: This disclaimer serves to advise you against inappropriate uses of this function. Let it be known that use of WP Traffic Tool's cookie stuffing features have the potential be used to perform criminal activity along the lines of both fraud and theft, depending on the circumstance; in which WP Traffic Tools, as an entity, and it's developer, as a provider of utilities, condemn any and all criminal activity. Propper use of WP Traffic Tool's cookie stuffing features do, and will always, fall under the guiding forces of personal integrity and persional conceince, as well as the personal awareness of the state of legal affairs governing matters related to issues vicariously related to the use of this plugin. It is up to individual parties using this software to determine the best and most appropriate applications of WP Traffic Tool's features and capabilites.  
			</i>
		</div>
		<br><br>
		<br>
		<span style='background-color:#1E90FF;border-style:solid;border-width:1px;padding:2px;border-color:#000000;color:#fff;cursor:pointer;' id='id_post_form_add_profile'>Add Profile</span>&nbsp&nbsp;&nbsp&nbsp;
		<span style='background-color:#1E90FF;border-style:solid;border-width:1px;padding:2px;border-color:#000000;color:#fff;cursor:pointer;' id='id_post_form_save_profile'>Save Profile(s)</span>
		<br><br>
		<form name='cookie_post_profile_add' id='id_cookie_post_form' method="post" action="admin.php?page=wptt_slug_submenu_cookie_profiles">
		<input type='hidden' name='cookie_post_form_nature' value='save_profile'>		
		<table id='id_cookie_table_post_profiles' style='width:95%'>
			<tr>
				<td width='20' align='middle'>
					#
				</td>
				<td align='left' width='140'>
						<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Post ID to drop cookie on. If you would like to drop a cookie on the homepage please enter in 'h' as your post_id. Only one profile is currenly allowed to be created on the homepage.">  <i>Post ID</i>												
				</td>
				<td align='left'>
						<i>Affiliate Profile</i>											
				</td>
			</tr>
			<?php
			if ($cookie_post_profile_id)
			{
				$i=0;
				foreach ($cookie_post_profile_id as $k=>$v)
				{
					$i=$i+1;
					$lid = $v;
					
					?>
					<tr> 
						<td width='20'>
							<input type=hidden name='cookie_post_profile_id[<?php echo $v; ?>]' value='<?php echo $v; ?>'><?php echo $i; ?> 
						</td>
						<td>
							<input <?php echo $add; ?>  name='cookie_post_post_id[<?php echo $v; ?>]' size=45 value='<?php echo $cookie_post_post_id[$k]; ?>' style='width:50px'>			
						</td>
						<td >
							<select name='cookie_post_affiliate_profile_id[<?php echo $v; ?>]'>
									<?php
									
									foreach ($cookie_affiliate_profile_id as $a=>$b)
									{
										if ($cookie_post_affiliate_profile_id[$k]==$b)
										{
											$selected = 'selected=true';
										}
										else
										{
											$selected = '';
										}
										
										echo "<option value='$b' $selected>$cookie_affiliate_profile_name[$a]</option>";
									}
									
									?>
							</select>
							
							<img  onClick='jQuery(this).parent().parent().remove();' src='<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/remove.png' style='cursor:pointer;'>
						
						</td>
					</tr>
				<?php
				
				}
				echo "<input type='hidden' id='id_cookie_post_lid' value='{$lid}'>";
			}
			else
			{
				$i=1;
					?>
					
					<input type='hidden' id='id_cookie_post_lid' value='0'>
			<?php
			}
			?>
		</table>				
		</form>
		<table style='display:none'>
			<tr>			
				<td id='id_select_post_affiliate_profiles'>					
					<select name='cookie_post_affiliate_profile_id[x]'>
							<?php
							
							foreach ($cookie_affiliate_profile_id as $a=>$b)
							{
								if ($cookie_post_affiliate_profile_id[$k]==$b)
								{
									$selected = 'selected=true';
								}
								else
								{
									$selected = '';
								}
								
								echo "<option value='$b' $selected>$cookie_affiliate_profile_name[$a]</option>";
							}
							
							?>
					</select>
				</td>
			</tr>
		</table>
		</div>
		<br><br><br>
	<?php
	}
		
	function cookie_update_settings()
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
	
	function wptt_display_cookie_profiles()
	{
		global $global_wptt;
		cookie_update_settings();
		cookie_add_javascript();
		traffic_tools_javascript();
		traffic_tools_update_check();
		
		//if active show rest of page
		if (strlen($global_wptt)>2)
		{
			include('wptt_style.php');
			echo "<img src='".WPTRAFFICTOOLS_URLPATH."images/wptt_logo.png'>";
			
			echo "<div id='id_wptt_display' class='class_wptt_display'>";
		
			echo '<div class="wrap">';

			echo "<h2>Cookie Delivery Profiles</h2>";
			wptt_cookie_settings();
			wptt_display_footer();
			echo '</div>';
			echo '</div>';

		}
		else
		{
			//CSS CONTENT
			include('wptt_style.php');
			traffic_tools_activate_prompt(); 
			wptt_display_footer();
			exit;
		}
		
		

	}
	
    
	function cookie_save_post($postID)
	{
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || wp_is_post_revision($postID)) 
		{
		
		}
		else
		{
			
			global $table_prefix;
			
			$post_id = $_POST['cookie_post_id'];
			//echo $post_id; exit;
			$cookie_url = $_POST['cookie_cookie_url'];
			$cookie_keywords = $_POST['cookie_cookie_keywords'];
			$ignore_spider = $_POST['cookie_ignore_spider'];
			$cookie_type = $_POST['cookie_cookie_type'];
			$blank_referrer = $_POST['cookie_blank_referrer'];
			
			$affiliate_profile_id = $_POST['cookie_profile_id'];
			
			if (trim($cookie_url))
			{
				$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_global_profiles WHERE post_id='{$post_id}'";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); exit;}
				
				if (mysql_num_rows($result)>0)
				{
					$query = "UPDATE {$table_prefix}wptt_wpcookie_profiles SET cookie_url='{$cookie_url}', cookie_keywords ='{$cookie_keywords}', ignore_spider ='{$ignore_spider}', cookie_type ='{$cookie_type}', blank_referrer='$blank_referrer' WHERE post_id='{$post_id}'";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo mysql_error();  exit;}
				}
				else
				{
					$query = "INSERT INTO {$table_prefix}wptt_wpcookie_profiles (`id`,`post_id`,`cookie_url`,`cookie_keywords`,`ignore_spider`,`cookie_type`,`blank_referrer`) VALUES ('','$postID','$cookie_url','$cookie_keywords','$ignore_spider','$cookie_type','$blank_referrer')";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo mysql_error();  exit;}
				}
			}
			
			//echo 1;exit;
			if ($affiliate_profile_id)
			{
				
				$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_post_profiles WHERE post_id = '{$post_id}'";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error();  exit;}
				
				if (mysql_num_rows($result)>0)
				{
					if ($affiliate_profile_id=='x')
					{
						$query = "DELETE FROM {$table_prefix}wptt_wpcookie_post_profiles WHERE post_id='{$post_id}'";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo mysql_error();  exit;}
					}
					else
					{
						$query = "UPDATE {$table_prefix}wptt_wpcookie_post_profiles SET affiliate_profile_id='{$affiliate_profile_id}'  WHERE post_id='{$post_id}'";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo mysql_error();  exit;}
					}
				}
				else
				{
					//echo $affiliate_profile_id;exit;
					if ($affiliate_profile_id!='x')
					{
						$query = "INSERT INTO {$table_prefix}wptt_wpcookie_post_profiles (`affiliate_profile_id`,`post_id`) VALUES ('$affiliate_profile_id', '$post_id')";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo mysql_error();  exit;}
					}
				}
			}
		}
		return $postID;
	}
	
	function cookie_add_spacer($content) 
	{		
		//echo $_SERVER["HTTP_REFERER"];
		global $table_prefix;
		$query = "SELECT COUNT(id) FROM {$table_prefix}wptt_wpcookie_affiliate_profiles ";
		$result = mysql_query($query);
		if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
		$count = mysql_num_rows($result);
		//echo $count;exit;
		if ($count>0)
		{		
			echo "<div class='spacer'></div>";
		}
		
	}
	
	function cookie_add_css() 
	{
		echo "<style type='text/css'> \n";
		echo ".spacer { \n";
		echo " background-image:url('".COOKIE_URLPATH."images/spacer.gif'); \n";
		echo "} \n";
		echo "</style> \n\n";	
		//exit;
		
		//return $content;
	}
	
	

	/*
	//on activation
	register_activation_hook(__FILE__, 'cookie_activate');
	add_action('admin_menu', 'cookie_add_menu');
	*/
	add_action('save_post','cookie_save_post');
	add_filter('get_footer', 'cookie_add_spacer');
	add_action('wp_head', 'cookie_add_css');

	
?>