<?php
	define(CLOAKME_PROFILES,'cloakme_profiles');
	define(CLOAKME_GLOBALS,'cloakme_options');
	if ($current_blog)
	{
		define('WPTRAFFICTOOLS_URLPATH', 'http://'.$current_blog->domain.$current_blog->path.'wp-content/plugins/'.plugin_basename( dirname(__FILE__) ).'/' );
		//echo WPTRAFFICTOOLS_URLPATH;EXIT;
	}
	else
	{
		define('WPTRAFFICTOOLS_URLPATH', WP_PLUGIN_URL.'/'.plugin_basename( dirname(__FILE__) ).'/' );
	}
	if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

	
	//ADD BUTTON TO TINYMCE
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	class cloakme_post_shortcode_button 
	{
		var $pluginname = "cloakme";

		function cloakme_post_shortcode_button()  {
			// Modify the version when tinyMCE plugins are changed.
			add_filter('tiny_mce_version', array (&$this, 'change_tinymce_version') );
			
			// init process for button control
			add_action('init', array (&$this, 'add_buttons') );
		}

		function add_buttons() {
			// Don't bother doing this stuff if the current user lacks permissions
			if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) return;
			
			// Add only in Rich Editor mode
			if ( get_user_option('rich_editing') == 'true') {
				// add the button for wp2.5 in a new way
				add_filter("mce_external_plugins", array (&$this, "add_tinymce_plugin" ), 5);
				add_filter('mce_buttons', array (&$this, 'register_button' ), 5);
			}
		}
		
		// used to insert button in wordpress 2.5x editor
		function register_button($buttons) {
			array_push($buttons, "separator", $this->pluginname );
			return $buttons;
		}
		
		// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
		function add_tinymce_plugin($plugin_array) {    
			$plugin_array[$this->pluginname] =  WPTRAFFICTOOLS_URLPATH.'tinymce/editor_plugin.js';
			return $plugin_array;
		}
		
		function change_tinymce_version($version) {
			return ++$version;
		}
	}
	
	$tinymce_button = new cloakme_post_shortcode_button();	
	
	//ADD MENU ITEM AND OPTIONS PAGE
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************	
	
	//echo $addb;exit;
	function cloakme_add_javascript()
	{
		global $rp;
		if ($rp[0]==0){
			$add = " disabled='disabled' ";	$addb = " ";
		}
		else if ($rp[0]==2)	{ 
			$add = " ";	$addb = " disabled='disabled' ";
		}
		else {$add = ""; $addb = "";}
		
		$add = str_replace("'",'"',$add);
		$addb = str_replace("'",'"',$addb);
		?>
			<!-- Support for the delete button , we use Javascript here -->
			
			<script type="text/javascript">
				function js_cloakme_delete(profile_id)
				{
				   if (confirm('Are you sure you want to delete this profile?'))
					 {
					   document.cloakme_profile_add.action.value = 'delete';
					   document.cloakme_profile_add.profile_id.value = profile_id; 
					   document.cloakme_profile_add.submit();
					 }
				} 
			
				
				jQuery(document).ready(function() 
				{
					jQuery('.class_profile_save_profile').attr('class','class_cloaking_edit_profile');
					jQuery('#id_cloaking_save_profile').attr('id','id_cloaking_add_profile');
					
					jQuery('.class_profile_save_profile').live("click" ,function() {
						//alert(1);
						jQuery('#id_cloaking_form_nature').val('cloaking_save_profile');
						jQuery("#id_cloaking_cloakme_form").submit();
					});
					
					jQuery('#id_cloaking_save_profile').live("click" ,function() {
						//alert(1);
						jQuery('#id_cloaking_form_nature').val('cloaking_save_profile');
						jQuery("#id_cloaking_cloakme_form").submit();
					});
					
					
					jQuery('#id_cloaking_add_profile').live("click",function() {
						jQuery(".class_tr_row").hide();
						jQuery('.class_profile_save_profile').attr('value','Edit');
						jQuery('.class_profile_save_profile').attr('class','class_cloaking_edit_profile');
						jQuery('#id_row_last_header').show();
						jQuery('#id_row_last').show();						
						jQuery(".class_tr td:eq(2)").html('<br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br>');
						jQuery.get('<?php echo WPTRAFFICTOOLS_URLPATH; ?>ajax.php?mode=links&id=x&nature=new', function(data) {
						   jQuery('#id_row_last').html(data);
						   jQuery('#id_cloaking_add_profile').text('Save');
						   jQuery('#id_cloaking_add_profile').attr('id','id_cloaking_save_profile');
						});						
					});
					
					
					
					jQuery('.class_cloaking_edit_profile').live("click" ,function() {
						var id = this.id.replace('id_cloaking_edit_profile_','');
						
						//hide add new profile
						jQuery("#id_row_last").html('<td></td><td colspan=5><br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
						jQuery("#id_row_last").hide();
						jQuery("#id_row_last_header").hide();
						jQuery('#id_cloaking_save_profile').text('Click Here to Add New Profile');
						jQuery('#id_cloaking_save_profile').attr('id','id_cloaking_add_profile');
						
						//change other editing boxes back to normal
						jQuery('.class_profile_save_profile').attr('value','Edit');
						jQuery('.class_profile_save_profile').attr('class','class_cloaking_edit_profile');
						jQuery(".class_tr_row").html('<td></td><td colspan=5><br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
						jQuery(".class_tr_row").hide();
						
						//change current button 
						jQuery('#id_cloaking_edit_profile_'+id).attr('value','Save');
						jQuery('#id_cloaking_edit_profile_'+id).attr('class','class_profile_save_profile');
						
					
						jQuery("#id_tr_row_"+id).show();
						jQuery.get('<?php echo WPTRAFFICTOOLS_URLPATH; ?>ajax.php?mode=links&nature=edit&id='+id, function(data) {
							jQuery(".class_tr_row").html('<td></td><td colspan=5><br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
							jQuery("#id_tr_row_"+id).html(data);
						});

					});
					
					
					jQuery('#id_cloaking_save_cloaking').click(function() {
						jQuery('#id_classifications_form_nature').val('cloaking_save_cloaking');
						jQuery("#id_form_classifications").submit();
					});
					
					jQuery('#id_cloaking_add_classification_prefix').click(function() {
						var html = '<tr><td><label for=keyword>Redirect Classification</label></td><td><input <?php echo $add; ?> name="classification_prefix[]" value="" /> <img  onClick=\'jQuery(this).parent().parent().remove();\' src=\'<?php echo WPTRAFFICTOOLS_URLPATH; ?>remove.png\' style=\'cursor:pointer;\'></td></tr>';
						jQuery("#id_cloaking_classification_prefixes tr:last").after(html);
	
					});

					jQuery('.class_cloaking_delete_profile').click(function() {
					
					    if (confirm('Are you sure you want to delete this link profile?'))
						{
							var id = this.id.replace('id_cloaking_delete_profile_','');
							jQuery('#id_cloaking_form_nature').val('cloaking_delete_profile');
							jQuery('#id_cloaking_profile_id').val(id);
							jQuery("#id_cloaking_cloakme_form").submit();
						}
					});
					
					jQuery("#id_select_link_masking").live("change", function(){	
					   var input = jQuery(this).val();
					   if (input==1)
					   {
						  jQuery(".class_tr_link_masking").show();
						   
					   }
					   else if (input==2)
					   {
						  jQuery(".class_tr_link_masking").show();
						   
					   }
					   else
					   {
						  jQuery(".class_tr_link_masking").hide();
					   }
					});
					
					jQuery("#id_select_keywords_affect").live("change", function(){	
					   var input = jQuery(this).val();
					   if (input==1||input==2||input==3||input==4)
					   {
							jQuery(".class_tr_html_attributes").show();
						   
					   }					 
					   else
					   {
							jQuery(".class_tr_html_attributes").hide();
					   }
					});
					
					jQuery("#id_select_referrer_management").live("change", function(){	
					   var input = jQuery(this).val();
					   if (input>0)
					   {
						  jQuery(".class_tr_spoof_referrer").show();
						  jQuery("#id_tr_additional_cookie").hide();
						  jQuery("#id_tr_iframe_content").hide();
						   
					   }
					   else
					   {
						  jQuery(".class_tr_spoof_referrer").hide();
						   jQuery("#id_tr_additional_cookie").show();
						   jQuery("#id_tr_iframe_content").show();
					   }
					});
					
					jQuery("#id_select_redirect_method").live("change", function(){	
						//alert('hi');
					   var input = jQuery(this).val();
					   if (input=='custom')
					   {
						  jQuery(".class_tr_redirect_method_url").show();						   
					   }
					   else
					   {
						  jQuery(".class_tr_redirect_method_url").hide();
					   }
					});
				});
				
				

			</script>
		<?php
	}

	function wptt_cloakme_settings()
	{
		global $table_prefix;
		global $rp;
		if ($rp[0]==0){
			$add = " disabled='disabled' ";	$addb = " ";
		}
		else if ($rp[0]==2)	{ 
			$add = " ";	$addb = " disabled='disabled' ";
		}
		else {$add = ""; $addb = "";}
		
		/* Retrieve the profile data */ 
		$query = "SELECT * FROM {$table_prefix}wptt_cloakme_profiles WHERE type='affiliate'";
		$result = mysql_query($query);
		while ($arr = mysql_fetch_array($result))
		{
			$cloaking_profile_id[] = $arr['id'];
			$cloaking_classification[] = $arr['classification_prefix'];
			$cloaking_permalink[] = $arr['permalink'];			
			$cloaking_cloaked_url[] = $arr['cloaked_url'];
			$redirect_url = explode("\n",$arr['redirect_url']);
			$cloaking_redirect_url[] = $redirect_url;
			$cloaking_spider_count[] = $arr['spider_count'];
			$cloaking_visitor_count[] = $arr['visitor_count'];
		}
		
		/* Retrieve the global classification prefixes */ 
		$query = "SELECT `option_value` FROM wpt_classification_prefixes  WHERE option_name='classification_prefix'";
		$result = mysql_query($query);
		if (!$result){echo $query; echo mysql_error(); exit;}
		$arr = mysql_fetch_array($result);
		$cloaking_classification_prefix =$arr[option_value];
		$cloaking_classification_prefix = explode(';',$cloaking_classification_prefix);
		//echo $classification_prefix;exit;		
		
		if ($_GET['purge_links'])
		{
			$sql = "DELETE FROM {$table_prefix}wptt_cloakme_profiles  WHERE type = 'global'";
			$result = mysql_query($sql);
			
			echo "<br><br><center><font style='color:green;'><i>Global Links Purged From Database!</font></center>";
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
			
			$global_mask_links = $wptt_options['cloak_links'];
			$global_redirect_spiders = $wptt_options['redirect_spiders'];
			$global_nofollow_links = $wptt_options['nofollow_links'];
			$global_mask_link_profiles = $wptt_options['cloak_link_profiles'];
			$global_default_classification_prefix = $wptt_options['default_classification_prefix'];
			$global_keyword_affects = $wptt_options['keyword_affects'];
			$global_cloak_comments = $wptt_options['cloak_comments'];
			$global_cloak_commenter_url = $wptt_options['cloak_commenter_url'];
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
			echo $query; echo mysql_error(); exit;
		}

		/* Retrieve the global settings */ 

		?>
		<br>
		<div class='wptt_featurebox'>
		<h3>Classification Categories</h3>
 		<a name="keywordeditor"></a>		
		
		<form name=cloakme_classification id='id_form_classifications' method="post" action="admin.php?page=wptt_slug_submenu_link_profiles">
		<input type=hidden name=this_action value=save >
		<input type=hidden name=nature id='id_classifications_form_nature' value='cloaking_save_classification' >
		<table>
			
			<tr>
				<td colspan=2>
						<table id='id_cloaking_classification_prefixes'>
							
							<?php
								if (count($cloaking_classification_prefix)>1)
								{
									foreach ($cloaking_classification_prefix as $k=>$v)
									{
										$i=$k+1;
								?>
										<tr>
											<td width='230'>
													Redirect Classification <?php echo $i; ?>
											</td>
											<td>
													<input <?php echo $add; echo $addb; ?> name='classification_prefix[]' <?php echo "value='$cloaking_classification_prefix[$k]'"; ?> />
													<?php
														if ($rp[0]>0)
														{
															if ($k==0||$rp[0]==2)
															{
																?>
																<img src='<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/add.png' style='cursor:pointer' id='id_cloaking_add_classification_prefix' title='add more classifications'><i><font style='font-size:9px;'>eg; http://www.myblog.com/<b>go</b>/custom-permalink</font></i>
																<?php
															}
															else
															{
																?>
																<img  onClick='jQuery(this).parent().parent().remove();' src='<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/remove.png' style='cursor:pointer;'>
																<?php
															}
														}
													?>
													
											</td>
										</tr>
								<?php
									}
								}
								else
								{
									?>
									<tr>
										<td width='230'>
												Redirect Classification 1:
										</td>
										<td>
												<input <?php echo $add; echo $addb; ?>  name='classification_prefix[]' <?php if (!$cloaking_classification_prefix[0]){ echo 'value="Go"'; } else { echo "value='$cloaking_classification_prefix[0]'"; }?> /> <img src='<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/add.png' style='cursor:pointer' id='id_cloaking_add_classification_prefix' title='add more classifications'>
													<i><font style='font-size:9px;'>eg; http://www.myblog.com/<b>go</b>/custom-permalink</font></i>
								
												
										</td>
									</tr>
							<?php
							}
							?>
						</table>
				
				</td>
			</tr>
			<tr>
				<td valign=top colspan=2>
					<br>
				</td>
			</tr>
			<tr>
				<td>
					<button class='button-secondary'  type=submit id='id_cloaking_save_cloaking' name='save_cloaking' value="Save" >Save Settings</button>
				</td>
			</tr>
		</table>
		</form>
		</div>
		
		
		<br><br>
		<div class='wptt_featurebox'>
			<div style='float:right'>
			<a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>geotarget-test.php' title='Discover GeoTargeting Details About Your Connection.' target='_blank'><img src='<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/ico_geotarget.png' border=0></a>&nbsp;&nbsp;
			<a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>settings_export.php?m=1' title='Export Link Profiles'><img src='<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/ico_save.png' border=0></a>&nbsp;
			<a target=_blank href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>settings_import.php?m=1' title='Import Link Profiles'><img src='<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/ico_import.png' border=0></a>
			</div>
			<form name=cloakme_profile_add id='id_cloaking_cloakme_form' method="post" action="admin.php?page=wptt_slug_submenu_link_profiles">
			<input type=hidden name=this_action value=save >
			<input type=hidden name=nature id='id_cloaking_form_nature' value=cloaking_save_profile >
			<input type=hidden name=profile_id id='id_cloaking_profile_id' value='' >
			
			
			<?php
			
			 echo "<h3>Link Profiles</h3>";
			 
			
			 if ($cloaking_profile_id)
			 { 
				echo "<table class='widefat' style='width:100%' id='id_table_link_profiles'>\n";		 	  
				echo "<tr><thead><tr><th>#</th>";
				echo "<th>Cloaked URL</th>";
				echo "<th>Affiliate URL</th>";
				echo "<th>Human Visits</th>";
				echo "<th>Spider Visits</th>";
				echo "<th>Actions</th>";
				echo "</tr></thead>\n";
			
				$cnt = 1;
				foreach ($cloaking_profile_id as $key=>$val) 
				{				 
					echo '<tr>';
					echo "<td>$cnt";
					echo "</td>";
					
					echo "<td id='id_cloaking_profile_cloaked_url_$key'><a href='$cloaking_cloaked_url[$key]'>{$cloaking_cloaked_url[$key]}</a></td>";
					echo "<td width='260'>";
					foreach ($cloaking_redirect_url[$key] as $k=>$v)
					{
						echo "<a href='{$v}'>{$v}</a><br>";
					}
					echo "</td>";
					echo "<td ><a href='".WPTRAFFICTOOLS_URLPATH."wp-show-logs.php?permalink={$cloaking_permalink[$key]}' target='_blank'> $cloaking_visitor_count[$key]</a></td>";
					echo "<td >$cloaking_spider_count[$key]</td>";
					 
					
					echo "<td><input type=button value=Edit  id='id_cloaking_edit_profile_$val' class='class_cloaking_edit_profile'>";
					echo "<input type=button value=Delete  id='id_cloaking_delete_profile_$val' class='class_cloaking_delete_profile'>";
					echo "</td></tr>\n";
					
					echo "<tr id='id_tr_row_$val' style='display:none;background-color:GhostWhite;' class='class_tr_row'><td></td><td colspan=4>";
					?>
						<br><br>
						<center><img src='<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif'></center>
						<br><br>
					<?php
					echo '</td></tr>';
					$cnt++;
					
				}
				echo '<tr id="id_row_last_header" style="display:none"><td colspan=6><h4>Add New Profile</h4></td></tr>';
				echo "<tr id='id_row_last' style='display:none'>
						<td colspan=6>
							<center><img src='".WPTRAFFICTOOLS_URLPATH."images/ajax-loader.gif'></center>
							<br><br>
						</td>
					</tr>
					</table>
					<div align='right'>
					<br>
					<button class='button-secondary' type='button' id='id_cloaking_add_profile' style='font-size:10px;'>Click Here to Add New Profile</button>
					<br><br>
					</div>";
			 }
			 else
			 {
				 echo "<p><i>no profiles found</i></p>";
				 $key=0;
				 ?>
				 <table class='widefat' style='width:100%' id='id_table_link_profiles'>
					<tr id="id_row_last_header" style="display:none">
						<td colspan=6><h4>Add New Profile</h4>
						</td>
					</tr>
					<tr id='id_row_last' style='display:none'>
						<td colspan=6>
							<center><img src='<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/ajax-loader.gif'></center>
							<br><br>
						</td>
					</tr>
					<tr>
						<td colspan=6 align='center'>
							<button class='button-secondary' type='button' id='id_cloaking_add_profile' >Add Profile</button>
							<br>
						</td>
					</tr>
				 </table>
				<?php
			 } 
			?>
			
			</form>
		</div>
		
		
		<br><br>
		
		<div class='wptt_featurebox'>
			<h3>Global Settings</h3>
			
				<a name="keywordeditor"></a>
				<div align='right' style='width:100%;'>
				<a href="admin.php?page=wptt_slug_submenu_link_profiles&purge_links=1" title="This will remove all generated global masked links. Purging will not delete manually created link profiles."><i>[Purge Global Links]</i></a>
				</div>
				<form name=global id='id_global_form' method="post" action="admin.php?page=wptt_slug_submenu_link_profiles">
				<input type=hidden name=nature id='id_global_form_nature' value=cloaking_global_save_settings >
				<table class='class_global_settings_td'>
					<tr>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="Turning this setting on will auto-detect occurences of links that we have link profiles set-up on, and convert those links to their custom-permalink format. Typically we would leave this on. These settings are applied to our RSS feeds as well as post/page content. "> 
								Auto-mask our link profiles?
							</label>
						</td>
						<td>
							<input <?php echo $add; echo $addb; ?> type=radio  size=67 name='global_cloak_link_profiles'  value=1 <?php if ($global_mask_link_profiles==1){ echo 'checked="checked"'; } ?>> Yes &nbsp;&nbsp;&nbsp;&nbsp;
							<input <?php echo $add; echo $addb; ?> type=radio  size=67 name='global_cloak_link_profiles'  value=0 <?php if ($global_mask_link_profiles!=1){ echo 'checked="checked"'; } ?>> No
						</td>
					</tr>
					<tr>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="Disabling this setting will prevent keword affects from taking place in your content. This can be used for troubleshooting. THIS FEATURE SETTING IS BEST TURNED ON WHEN USED ALONG SIDE A CACHING PLUGIN."> 
								Disable all keyword modification affects?
							</label>
						</td>
						<td>
							<input <?php echo $add; ?> type=radio  size=67 name='global_keyword_affects' <?php if ($global_keyword_affects==1){ echo 'checked="checked"'; } ?> value=1 > Yes &nbsp;&nbsp;&nbsp;&nbsp;
							<input <?php echo $add;  ?> type=radio  size=67 name='global_keyword_affects' <?php if ($global_keyword_affects!=1){ echo 'checked="checked"'; } ?> value=0 > No 
						</td>
					</tr>
					<tr>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="Turning this setting on will auto-cloak ALL links including (both) user-created link profiles and links that do not have user-created profiles. This feature will not cloak links pointing to internal pages. These settings are applied to our RSS feeds as well as post/page content. "> 
								Turn on sitewide link masking?
							</label>
						</td>
						<td>
							<select <?php echo $add; ?>  <?php echo $addb; ?> type=text id='id_select_link_masking' name='global_cloak_links'>
							
								<option value='0' <?php if ($global_mask_links=='0'){echo "selected=true"; } ?>>Disabled</option>
								<option value='1' <?php if ($global_mask_links=='1'){echo "selected=true"; } ?>>Enabled</option>
								<option value='2' <?php if ($global_mask_links=='2'){echo "selected=true"; } ?>>Enabled for Spiders Only</option>
							
							</select>
						</td>
					</tr>
					<tr  class='class_tr_link_masking'>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="This feature will enable or disable global link cloaking and keyword affects for pages and the homepage, leaving them only enabled for posts. Sitewide llink cloaking and keyword affects must be enabled for this setting to have any affect."> 
								Enable sitewide link masking & keyword affects on posts only?
							</label>
						</td>
						<td>
							<input <?php echo $add; echo $addb; ?> type=radio  size=67 name='global_cloak_only_posts' <?php if ($global_cloak_only_posts==1){ echo 'checked="checked"'; } ?> value=1 > Yes &nbsp;&nbsp;&nbsp;&nbsp;
							<input <?php echo $add; echo $addb; ?> type=radio  size=67 name='global_cloak_only_posts' <?php if ($global_cloak_only_posts!=1){ echo 'checked="checked"'; } ?> value=0 > No 
						</td>
					</tr>
					<tr  class='class_tr_link_masking'>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="This feature will cloak any live links found in the commenter's comment. THIS FEATURE SETTING IS BEST TURNED ON WHEN USED ALONG SIDE A CACHING PLUGIN."> 
								Mask links in comments?
							</label>
						</td>
						<td>
							<input <?php echo $add; echo $addb; ?> type=radio  size=67 name='global_cloak_comments' <?php if ($global_cloak_comments==1){ echo 'checked="checked"'; } ?> value=1 > Yes &nbsp;&nbsp;&nbsp;&nbsp;
							<input <?php echo $add; echo $addb; ?> type=radio  size=67 name='global_cloak_comments' <?php if ($global_cloak_comments!=1){ echo 'checked="checked"'; } ?> value=0 > No 
							
						</td>
					</tr>
					<tr  class='class_tr_link_masking'>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="Some commenters will leave a url to be associated with their name. THIS FEATURE SETTING IS BEST TURNED ON WHEN USED ALONG SIDE A CACHING PLUGIN."> 
								Mask commenter's url?
							</label>
						</td>
						<td>
							<input <?php echo $add; echo $addb; ?> type=radio  size=67 name='global_cloak_commenter_url' <?php if ($global_cloak_commenter_url==1){ echo 'checked="checked"'; } ?> value=1 > Yes &nbsp;&nbsp;&nbsp;&nbsp;
							<input <?php echo $add; echo $addb; ?> type=radio  size=67 name='global_cloak_commenter_url' <?php if ($global_cloak_commenter_url!=1){ echo 'checked="checked"'; } ?> value=0 > No
							
						</td>
					</tr>
					<tr  class='class_tr_link_masking'>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="This feature will cloak any live links found in text widgets."> 
								Mask links in text widgets?
							</label>
						</td>
						<td>
							<input <?php echo $add; echo $addb; ?> type=radio  size=67 name='global_cloak_text_widgets' <?php if ($global_cloak_text_widgets==1){ echo 'checked="checked"'; } ?> value=1 > Yes &nbsp;&nbsp;&nbsp;&nbsp;
							<input <?php echo $add; echo $addb; ?> type=radio  size=67 name='global_cloak_text_widgets' <?php if ($global_cloak_text_widgets!=1){ echo 'checked="checked"'; } ?> value=0 > No 
							
						</td>
					</tr>
					<tr  class='class_tr_link_masking'>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="This feature will cloak any live links found in your theme's header.php."> 
								Mask links in header area?
							</label>
						</td>
						<td>
							<input <?php echo $add; echo $addb; ?> type=radio  size=67 name='global_cloak_header' <?php if ($global_cloak_header_area==1){ echo 'checked="checked"'; } ?> value=1 > Yes &nbsp;&nbsp;&nbsp;&nbsp;
							<input <?php echo $add; echo $addb; ?> type=radio  size=67 name='global_cloak_header' <?php if ($global_cloak_header_area!=1){ echo 'checked="checked"'; } ?> value=0 > No 
						</td>
					</tr>
					<tr  class='class_tr_link_masking'>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="This feature will cloak any live links found in your theme's header.php."> 
								Mask links in footer area?
							</label>
						</td>
						<td>
							<input <?php echo $add; echo $addb; ?> type=radio  size=67 name='global_cloak_footer' <?php if ($global_cloak_footer_area==1){ echo 'checked="checked"'; } ?> value=1 > Yes &nbsp;&nbsp;&nbsp;&nbsp;
							<input <?php echo $add; echo $addb; ?> type=radio  size=67 name='global_cloak_footer' <?php if ($global_cloak_footer_area!=1){ echo 'checked="checked"'; } ?> value=0 > No 
						</td>
					</tr>
					<tr  class='class_tr_link_masking'>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="Adds rel='nofollow' to all outbound links."> 
								Nofollow sitewide masked links?
							</label>
						</td>
						<td>
							<input <?php echo $add; echo $addb; ?> type=radio  size=67 name='global_nofollow_links' <?php if ($global_nofollow_links==1){ echo 'checked="checked"'; } ?> value=1 > Yes &nbsp;&nbsp;&nbsp;&nbsp;
							<input <?php echo $add; echo $addb; ?> type=radio  size=67 name='global_nofollow_links' <?php if ($global_nofollow_links!=1){ echo 'checked="checked"'; } ?> value=0 > No 
							
						</td>
					</tr>
					<tr  class='class_tr_link_masking'>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="If sitewide link cloaking is enabled, then this will be the default classification prefix for all auto-generated masked links."> 
								Default Classification Prefix
							</label>
						</td>
						<td>
							<select <?php echo $add; ?>  <?php echo $addb; ?> type=text  name='global_default_classification_prefix'> 
							<?php
								foreach ($cloaking_classification_prefix as $k=>$v)
								{
									if ($global_default_classification_prefix==$v)
									{
										$selected = "selected='true'";
									}
									else
									{
										$selected = '';
									}
									echo "<option value='$v' $selected>$v</option>";
								}
							?>
							</select>
						</td>
					</tr>				
					<tr  class='class_tr_link_masking'>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="Only applicable if sitewide cloaking is turned on. This feature, if toggled on, will prevent non-human visitors from following outbound links."> 
								Filter and redirect spiders for sitewide link masking?
							</label>
						</td>
						<td>
							<input <?php echo $add; echo $addb; ?>type=radio  size=67 name='global_redirect_spiders' <?php if ($global_redirect_spiders==1){ echo 'checked="checked"'; } ?> value=1 > Yes &nbsp;&nbsp;&nbsp;&nbsp;
							<input <?php echo $add; echo $addb; ?>type=radio  size=67 name='global_redirect_spiders' <?php if ($global_redirect_spiders!=1){ echo 'checked="checked"'; } ?> value=0 > No
						</td>
					</tr>
					<tr  class='class_tr_link_masking'>
						<td  colspan=2>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="One per line, add search strings to check a URL for. If the string is found the WPTT will mask these links and only these links. Leave blank otherwise."> 
								Only mask URLs containing the folllowing strings:
							</label>
						</td>
					</tr>
					<tr class='class_tr_link_masking'>
						<td  colspan=2>
							<textarea   <?php echo $add; ?>  <?php echo $addb; ?> name='global_cloak_patterns' rows=3 cols=75><?php echo $global_cloak_patterns; ?></textarea>
						</td>
					</tr>
					<tr class='class_tr_link_masking'>
						<td  colspan=2>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="One per line, add search strings to check a URL for. If the string is found the WPTT will not mask the link."> 
								Prevent external URLs with these strings from being masked:
							</label>
						</td>
					</tr>
					<tr class='class_tr_link_masking'>
						<td  colspan=2>
							<textarea  <?php echo $add; ?>  <?php echo $addb; ?> name='global_cloak_exceptions' rows=3 cols=75><?php echo $global_cloak_exceptions; ?></textarea>
						</td>
					</tr>
					<tr>
						<td colspan=2>
							<br><br>
						</td>
					</tr>
					<tr >
						<td>
							<button <?php echo $add; ?> type=submit  class='button-secondary' id='id_global_save_settings' name='save_global' value="Save" >Save Global Settings</button>
						</td>
					</tr>
				</table>
				</form>
		</div>
		<br><br>
		
		<?php
		
	}

	
	function cloakme_update_settings()
	{		
		global $table_prefix;
		global $rp;
		if ($rp[0]==2)	{ 
			$nogeo=1;
		}
		
		
		$wordpress_url = get_bloginfo('url');
		
		if (substr($wordpress_url, -1, -1)!='/')
		{
			$wordpress_url = $wordpress_url."/";
		}
		
		if ($_POST['nature']=='cloaking_delete_profile')
		{
			$profile_id = $_POST['profile_id'] ;
			$query = "DELETE FROM {$table_prefix}wptt_cloakme_profiles  WHERE id='$profile_id'";
			$result = mysql_query($query);
			if (!$result) { echo $query; echo mysql_error(); }
		}
		if ($_POST['nature']=='cloaking_save_profile')
		{
			$profile_id = $_POST['profile_id'];
			$link_masking = $_POST['link_masking'];
			$classification_prefix = $_POST['classification'];
			$permalink = $_POST['permalink'];
			$redirect_url = trim($_POST['redirect_url']);
			$redirect_url = addslashes($redirect_url);
			if ($nogeo==1)
			{
				$redirect_url = preg_replace('/{(.*?)}/s','',$redirect_url);
			}
			
			$rotate_urls = $_POST['rotate_urls'];
			$rotate_urls_count = $_POST['rotate_urls_count'];
			$blank_referrer = $_POST['blank_referrer'];
			$spoof_referrer_url = $_POST['spoof_referrer_url'];
			$redirect_spider = $_POST['redirect_spider'];
			$redirect_method = $_POST['redirect_method'];
			$redirect_method_url = $_POST['redirect_method_url'];
			$redirect_type = $_POST['redirect_type'];
			$cloak_target = $_POST['cloak_target'];
			$stuff_cookie = $_POST['stuff_cookie'];
			$keywords = addslashes($_POST['keywords']);
			$keywords =  preg_split("/[\r\n,]+/",  $keywords, -1, PREG_SPLIT_NO_EMPTY);			
			$keywords = implode(',',$keywords);
			$keywords_affect = $_POST['keywords_affect'];
			$attributes = addslashes($_POST['attributes']);
			$keywords_limit = $_POST['keywords_limit'];
			$keywords_limit_total = $_POST['keywords_limit_total'];
			$keywords_target_page = $_POST['keywords_target_page'];
			$notes = $_POST['notes'];
			
			//print_r($profile_id);exit;
			if ($profile_id)
			{	
				if ($link_masking==1)
				{
					$permalink = str_replace(' ','-',$permalink);
					$permalink = str_replace('--','-',$permalink);
					$permalink = str_replace('?','+',$permalink);
					$permalink = str_replace('&','+',$permalink);
					$permalink = str_replace('%','%25',$permalink);
					$permalink = str_replace('%2525','%25',$permalink);
					$cloaked_link = $wordpress_url.$classification_prefix."/".$permalink;
				}
				else
				{
					$cloaked_link = "none";
					$permalink = $redirect_url;
				}
				if ($profile_id!='x')
				{
					$query = "UPDATE {$table_prefix}wptt_cloakme_profiles SET link_masking='$link_masking' ,permalink='$permalink' , classification_prefix='$classification_prefix', cloaked_url='$cloaked_link', redirect_url='$redirect_url', rotate_urls='$rotate_urls', rotate_urls_count='$rotate_urls_count', blank_referrer='$blank_referrer', spoof_referrer_url='$spoof_referrer_url', redirect_spider='$redirect_spider', redirect_method='$redirect_method', redirect_method_url='$redirect_method_url', redirect_type='$redirect_type', cloak_target='$cloak_target', stuff_cookie='$stuff_cookie', keywords = '$keywords', keywords_affect = '$keywords_affect', attributes = '$attributes', keywords_limit = '$keywords_limit', keywords_limit_total = '$keywords_limit_total', keywords_target_page = '$keywords_target_page' , notes = '$notes' WHERE id='$profile_id'";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo mysql_error(); }
				}
				else
				{
					$query = "INSERT INTO {$table_prefix}wptt_cloakme_profiles (`id`,`link_masking`,`classification_prefix`,`permalink`,`cloaked_url`,`redirect_url`,`rotate_urls`,`rotate_urls_count`,`blank_referrer`,`spoof_referrer_url`,`redirect_spider`,`redirect_method`,`redirect_method_url`,`redirect_type`,`cloak_target`,`stuff_cookie`,`visitor_count`,`spider_count`,`type`,`keywords`,`keywords_affect`,`attributes`,`keywords_limit`,`keywords_limit_total`,`keywords_target_page`,`notes`) VALUES ('','$link_masking','$classification_prefix','$permalink','$cloaked_link','$redirect_url','$rotate_urls','$rotate_urls_count','$blank_referrer','$spoof_referrer_url','$redirect_spider','$redirect_method','$redirect_method_url','$redirect_type','$cloak_target','$stuff_cookie','0','0','affiliate','$keywords','$keywords_affect','$attributes','$keywords_limit','$keywords_limit_total','$keywords_target_page','$notes')";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo mysql_error(); }
				}
			}
			
			
			
		}
		else if ($_POST['nature']=='cloaking_save_cloaking')
		{
			$classification_prefix = $_POST['classification_prefix'];
			$classification_prefix = implode(';',$classification_prefix);
			$classification_prefix = strtolower($classification_prefix);
			
			$query = "UPDATE wpt_classification_prefixes SET option_value='$classification_prefix' WHERE option_name='classification_prefix'";
			$result = mysql_query($query);
			if (!$result) { echo $query; echo mysql_error();exit;}
			//rebuild htaccess
			
			// Adding a new rule
			global $wp_rewrite;
			$classification_prefix = explode(';',$classification_prefix);
			$rules = "";
			foreach ($classification_prefix as $k=>$v)
			{
				$v = trim($v);
				if ($v)
				{
					$rules[] = "RewriteCond %{QUERY_STRING} ^(.*)$";
					$rules[] = "RewriteRule ^(.*){$v}/(.*)$ ".ABSPATH."wp-content/plugins/wp-traffic-tools/relay.php?permalink=$2?%1 [L,QSA,B]";
				}
			}

			
			//generate the new htaccess code
			$wp_rewrite->non_wp_rules = $array;
			$newcode_start = "#wp-traffic-tools-start \n
<IfModule mod_rewrite.c> 
RewriteEngine On
RewriteRule ^(.*)images/special-(.*)\.gif$ $1drop_insurance.php?url=$2 [R=301,L]  \n
RewriteRule ^(.*)images/special-blank-(.*)\.gif$ $1drop_insurance.php?blank=1&url=$2 [R=301,L]  \n";
			foreach($rules as $k=>$v)
			{
				$newcode .= "$v \n";
			}
			$newcode_end = "</IfModule> \n
#wp-traffic-tools-end";

			$newcode = $newcode_start.$newcode.$newcode_end;
			//echo $newcode;
			
			//fopen .htacess
			$targetFile = ABSPATH.".htaccess"; 
			$handle1 = fopen($targetFile, 'a+');  	
			$data = @fread($handle1,filesize($targetFile)); 
			fclose($handle1);
			$handle2 = fopen($targetFile, "w");
			//echo $data;exit;
			if (strstr($data,'#wp-traffic-tools-start'))
			{
			   
			   $data = preg_replace('/#wp-traffic-tools-start(.+)#wp-traffic-tools-end/msi', '***wptt***' , $data );
			   $data = str_replace('***wptt***',$newcode,$data);

			}
			else
			{
				if (strstr($data, '# BEGIN WordPress'))
				{
					$data = str_replace('# BEGIN WordPress', $newcode."\n\n # BEGIN WordPress", $data);
				}
				else
				{
					$data = $data."\n $newcode";
				}
				
			}
			
			
			
			fwrite($handle2, $data);
			fclose($handle2);
			//echo $data;exit;

			//generate the new htaccess code
			$htaccess = "RewriteEngine On \n
RewriteRule ^(.*)spacer\.gif$ ".WPTRAFFICTOOLS_URLPATH."images/spacer.php [L]";
			//echo $htaccess;
			//fopen .htacess
			$targetFile = ABSPATH."wp-content/plugins/wp-traffic-tools/images/.htaccess"; 
		//echo $handle_1;
			//echo $targetFile;exit;
			$handle1 = fopen($targetFile, "w");  
			//echo $handle_1;			
			fwrite($handle1, $htaccess);
			fclose($handle1);
			//echo $handle_1; exit;

		}
		else if ($_POST['nature']=='cloaking_global_save_settings')
		{
			global $wptt_options;
			//echo 1; exit;
			$wptt_options['cloak_links'] = $_POST['global_cloak_links'];
			$wptt_options['redirect_spiders'] = $_POST['global_redirect_spiders'];
			$wptt_options['nofollow_links'] = $_POST['global_nofollow_links'];
			$wptt_options['cloak_link_profiles'] =  $_POST['global_cloak_link_profiles'];
			$wptt_options['default_classification_prefix'] = $_POST['global_default_classification_prefix'];
			$wptt_options['keyword_affects'] = $_POST['global_keyword_affects'];
			$wptt_options['cloak_comments'] = $_POST['global_cloak_comments'];
			$wptt_options['cloak_commenter_url'] =  $_POST['global_cloak_commenter_url'];			
			$wptt_options['cloak_links_pages'] =  $_POST['global_cloak_only_posts'];
			$wptt_options['cloak_text_widgets'] = $_POST['global_cloak_text_widgets'];
			$wptt_options['cloak_header'] = $_POST['global_cloak_header'];
			$wptt_options['cloak_footer'] = $_POST['global_cloak_footer'];
			$wptt_options['cloak_exceptions'] = $_POST['global_cloak_exceptions'];
			$wptt_options['cloak_patterns'] = $_POST['global_cloak_patterns'];	
			
			$wptt_options = json_encode($wptt_options);
			//echo $global_default_classification_prefix;
			$query = "UPDATE {$table_prefix}wptt_wptraffictools_options SET option_value='$wptt_options' WHERE option_name='wptt_options'";
			$result = mysql_query($query);
			if (!$result) { echo $query; echo mysql_error(); }			
			
		}
	}
		
	function wptt_display_link_profiles()
	{		
		global $global_wptt;
		traffic_tools_javascript();
		cloakme_update_settings();
		cloakme_add_javascript();
		
		traffic_tools_activation_check();
		traffic_tools_update_check();
		
		//CSS CONTENT
		include('wptt_style.php');
		//if active show rest of page
		if (strlen($global_wptt)>2)
		{			
			echo "<img src='".WPTRAFFICTOOLS_URLPATH."images/wptt_logo.png'>";
			
			echo "<div id='id_wptt_display' class='class_wptt_display'>";
		
			echo '<div class="wrap">';

			echo "<h2>Link Profiles</h2>";
				
			/* Show the existing options */
			wptt_cloakme_settings();
		}
		else
		{
			//CSS CONTENT
			include('wptt_style.php');
			traffic_tools_activate_prompt(); 
		}
			
		wptt_display_footer();
		echo "</div>";
		echo '</div>';
		echo "<div style='background-color:#fff;'></div>";
		
	}

 
	
?>