<?php

define('REDIRECT_URLPATH', WP_PLUGIN_URL.'/'.plugin_basename( dirname(__FILE__) ).'/' );
	
	
	//ADD SETTINGS TO POST EDITING AREA
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	
	
	function redirect_add_meta_box()
	{
		global $rp;
		if ($rp[1]==1)
		{
			add_meta_box( 'wp-traffic-tools', 'Advanced Redirection Options', 'redirect_meta_box' , 'post', 'advanced', 'high' );
			add_meta_box( 'wp-traffic-tools', 'Advanced Redirection Options', 'redirect_meta_box' , 'page', 'advanced', 'high' );
		}
	}
	
	add_action('admin_menu', 'redirect_add_meta_box');
	
	function redirect_meta_box()
	{
		global $post;
		global $table_prefix;


		
		$post_id = $post->ID;
		//echo $post_id;exit;
		
		
		$query = "SELECT * FROM {$table_prefix}wptt_wpredirect_profiles WHERE post_id='{$post_id}'";
		$result = mysql_query($query);
		if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
		while ($arr = mysql_fetch_array($result))
		{
			$redirecting_profile_id = $arr['id'];
			$redirecting_redirect_url = $arr['redirect_url'];
			$redirecting_redirect_keywords = $arr['redirect_keywords'];
			$redirecting_redirect_type = $arr['redirect_type'];
			$redirecting_redirect_spider = $arr['ignore_spider'];
			$redirecting_blank_referrer = $arr['blank_referrer'];
			$redirecting_require_referrer = $arr['require_referrer'];
			$redirecting_redirect_count = $arr['redirect_count'];
			$redirecting_redirect_delay = $arr['redirect_delay'];
		}
		?>
		<div class=" " id="trackbacksdiv">
			<div class="inside">
					<table>
						<tr>
							<td>
								<label for=keyword>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Redirect URL here."> 
									Redirect URL
								</label>
							</td>
							<td>
								<input type=hidden   size=67 name='redirecting_post_id' value='<?php echo $post_id; ?>'>
								<input type=hidden   size=67 name='redirecting_require_referrer' value='0'>
								<input type=text  id='id_redirecting_redirect_url' size=67 name='redirecting_redirect_url' value='<?php echo $redirecting_redirect_url; ?>'>
							</td>
						</tr>
						<tr>
							<td valign=top>
								<label for=keyword>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/tip.png" style="cursor:pointer;" border=0 title="Please seperate keywords with commas. How this works: If the the url of the page that referrered the traffic contains any of these keywords then the visitor will be redirected. Otherwise no redirection will take place unless a * wildcard is placed into this field."> 	
									Redirect Keywords
								</label>
							</td>
							<td>
								<input type=text  id='id_redirecting_redirect_keywords' size=67 name='redirecting_redirect_keywords'  value='<?php if ($redirecting_redirect_keywords){echo $redirecting_redirect_keywords;} else {echo "*";} ?>' >
							</td>
						</tr>
						<tr>
							<td>
								<label for=keyword>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="This will prevent traget URL from tracking the source of the referrer, which in this case will be the post that contains the masked link.">
									Referrer Blanking
								</label>
							</td>
							<td>
								<input type=radio size=67 id='id_redirecting_radio_blank_referrer_off' name='redirecting_blank_referrer' value='0' <?php if ($redirecting_blank_referrer==0){echo "checked='true'";} ?>> off  &nbsp;&nbsp;&nbsp;
								<input type=radio size=67 id='id_redirecting_radio_blank_referrer_on' name='redirecting_blank_referrer' value='1' <?php if ($redirecting_blank_referrer==1){echo 'checked="true"';}?> > on
							</td>
						</tr>
						<tr>
							<td>
								<label for=keyword>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Enabling this to on will require arriving traffic to have a referring URL or else it will assume it is a direct connection and will not redirect the traffic to the specified redirect URL. It will instead allow the traffic to continue on to the original page.">
									Require Referrer?
								</label>
							</td>
							<td>
								<input type=radio size=67 id='id_redirecting_radio_require_referrer_off' name='redirecting_require_referrer' value='0' <?php if ($redirecting_require_referrer==0||!$redirecting_require_referrer){echo "checked='true'";} ?>> off  &nbsp;&nbsp;&nbsp;
								<input type=radio size=67 id='id_redirecting_radio_require_referrer_on' name='redirecting_require_referrer' value='1' <?php if ($redirecting_require_referrer==1){echo 'checked="true"';}?> > on
							</td>
						</tr>
						<tr>
							<td valign='top' width='230'>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Setting this to yes will tell WPTT to treat spiders like humans and redirect them to the redirect url if they meet the redirection criteria.?">
									Redirect Spiders with Humans
							</td>
							<td>
									<input type=radio id='id_redirecting_radio_redirect_spider_off'  name='redirecting_redirect_spider' value='0' <?php if ($redirecting_redirect_spider==0){echo "checked='true'";} ?>> no &nbsp;&nbsp;&nbsp;
									<input type=radio id='id_redirecting_radio_redirect_spider_on' name='redirecting_redirect_spider' value='1' <?php if ($redirecting_redirect_spider==1){echo "checked='true'";} ?>> yes &nbsp;&nbsp;&nbsp;
							</td>
						</tr>
						<tr>
							<td valign='top' width='230'>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="301 = Moved permantely; 302 = Temporary Location; 303 = Other; 307 = External Redirect;."> 
									Redirection Type
							</td>
							<td>
									<input type=radio id='id_redirecting_radio_redirect_type_301' name='redirecting_redirect_type' value='301' <?php if ($redirecting_redirect_type=='301'){echo "checked='true'";} ?>> 301 &nbsp;&nbsp;&nbsp;
									<input type=radio id='id_redirecting_radio_redirect_type_302'  name='redirecting_redirect_type' value='302' <?php if ($redirecting_redirect_type=='302'){echo "checked='true'";} ?>> 302 &nbsp;&nbsp;&nbsp;
									<input type=radio id='id_redirecting_radio_redirect_type_303'  name='redirecting_redirect_type' value='303' <?php if ($redirecting_redirect_type=='303'){echo "checked='true'";} ?>> 303 &nbsp;&nbsp;&nbsp;
									<input type=radio id='id_redirecting_radio_redirect_type_307'  name='redirecting_redirect_type' value='307' <?php if ($redirecting_redirect_type=='307'||!$redirecting_redirect_type){echo "checked='true'";} ?>> 307 &nbsp;&nbsp;&nbsp;
							</td>
						</tr>
						<tr>
							<td valign='top' width='230'>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Wait until the user has waiting the following amount of time before redirecting. Leave at 0 for no delay. "> 
									Redirect Delay
							</td>
							<td>
									<input id='id_redirecting_radio_redirect_delay' name='redirecting_redirect_delay' value='<?php if (!$redirecting_redirect_delay){echo 0;} else {echo $redirecting_redirect_delay;} ?>'>
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
	function redirect_add_javascript()
	{
		?>
			<!-- Support for the delete button , we use Javascript here -->
			<script type="text/javascript">
				
				
				function js_redirect_delete(profile_id)
				{
				   if (confirm('Are you sure you want to delete this profile?'))
					 {
					   document.redirect_profile_add.action.value = 'delete';
					   document.redirect_profile_add.profile_id.value = profile_id; 
					   document.redirect_profile_add.submit();
					 }
				} 
			
				 
				jQuery(document).ready(function() 
				{
					jQuery('.class_profile_save_profile').attr('class','class_redirecting_edit_profile');
					jQuery('#id_redirecting_save_profile').attr('id','id_redirecting_add_profile');
					
					jQuery('.class_profile_save_profile').live("click" ,function() {
						//alert(1);
						jQuery('#id_redirecting_form_nature').val('redirecting_save_profile');
						jQuery("#id_redirecting_redirect_form").submit();
					});
					
					jQuery('#id_redirecting_save_profile').live("click" ,function() {
						//alert(1);
						jQuery('#id_redirecting_form_nature').val('redirecting_save_profile');
						jQuery("#id_redirecting_redirect_form").submit();
					});
					
					jQuery('.class_redirecting_delete_profile').click(function() {
					
					    if (confirm('Are you sure you want to delete this redirection profile?'))
						{
							var id = this.id.replace('id_redirecting_delete_profile_','');
							jQuery('#id_redirecting_form_nature').val('redirecting_delete_profile');
							jQuery('#id_redirecting_profile_id').val(id);
							jQuery("#id_redirecting_redirect_form").submit();
						}
					});

					
					jQuery('.class_redirecting_edit_profile').live("click" ,function() {
						var id = this.id.replace('id_redirecting_edit_profile_','');
						//alert(id);
						//hide add new profile
						jQuery("#id_row_last").html('<td></td><td colspan=5><br><br><center><img src="<?php echo REDIRECT_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
						jQuery("#id_row_last").hide();
						jQuery("#id_row_last_header").hide();
						jQuery('#id_redirecting_save_profile').text('Click Here to Add New Profile');
						jQuery('#id_redirecting_save_profile').attr('id','id_redirecting_add_profile');
						
						//change other editing boxes back to normal
						jQuery('.class_profile_save_profile').attr('value','Edit');
						jQuery('.class_profile_save_profile').attr('class','class_redirecting_edit_profile');
						jQuery(".class_tr_row").html('<td></td><td colspan=5><br><br><center><img src="<?php echo REDIRECT_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
						jQuery(".class_tr_row").hide();
						
						//change current button 
						jQuery('#id_redirecting_edit_profile_'+id).attr('value','Save');
						jQuery('#id_redirecting_edit_profile_'+id).attr('class','class_profile_save_profile');
					
						jQuery("#id_tr_row_"+id).show();
						jQuery.get('<?php echo REDIRECT_URLPATH; ?>ajax.php?mode=redirect&nature=edit&id='+id, function(data) {
							jQuery(".class_tr_row").html('<td></td><td colspan=5><br><br><center><img src="<?php echo REDIRECT_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
							jQuery("#id_tr_row_"+id).html(data);
						});

					});
					
					jQuery('#id_redirecting_add_profile').live("click",function() {
						jQuery(".class_tr_row").hide();
						jQuery('.class_profile_save_profile').attr('value','Edit');
						jQuery('.class_profile_save_profile').attr('class','class_redirecting_edit_profile');
						jQuery('#id_row_last_header').show();
						jQuery('#id_row_last').show();						
						jQuery(".class_tr td:eq(2)").html('<br><br><center><img src="<?php echo REDIRECT_URLPATH;?>images/ajax-loader.gif"></center><br><br>');
						jQuery.get('<?php echo REDIRECT_URLPATH; ?>ajax.php?mode=redirect&id=x&nature=new', function(data) {
						   jQuery('#id_row_last').html(data);
						   jQuery('#id_redirecting_add_profile').text('Save');
						   jQuery('#id_redirecting_add_profile').attr('id','id_redirecting_save_profile');
						});						
					});
					
					jQuery('.class_delete_profile').click(function() {
						var id = this.id.replace('id_redirecting_delete_profile_','');
						var profile_id = jQuery('#id_redirecting_profile_id_'+id).val();
						jQuery('#id_redirecting_form_nature').val('redirecting_delete_profile');
						jQuery('#id_redirecting_profile_id').val(profile_id);
						jQuery("#id_redirecting_redirect_form").submit();
					});
					
					
					jQuery('.class_regex_save_profile').live("click" ,function() {
						//alert(1);
						jQuery('#id_regex_form_nature').val('regex_save_profile');
						jQuery("#id_regex_form").submit();
					});
					
					jQuery('.class_regex_delete_profile').click(function() {
					
					    if (confirm('Are you sure you want to delete this advanced regex based redirection profile?'))
						{
							var id = this.id.replace('id_regex_delete_profile_','');
							jQuery('#id_regex_form_nature').val('regex_delete_profile');
							jQuery('#id_regex_profile_id').val(id);
							jQuery("#id_regex_form").submit();
						}
					});

					
					jQuery('.class_regex_edit_profile').live("click" ,function() {
						var id = this.id.replace('id_regex_edit_profile_','');
						//alert(id);
						//hide add new profile
						jQuery("#id_regex_row_last").html('<td></td><td colspan=5><br><br><center><img src="<?php echo REDIRECT_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
						jQuery("#id_regex_row_last").hide();
						jQuery("#id_regex_row_last_header").hide();
						jQuery('#id_regex_save_profile').text('Click Here to Add New Profile');
						jQuery('#id_regex_save_profile').attr('id','id_regex_add_profile');
						
						//change other editing boxes back to normal
						jQuery('.class_regex_save_profile').attr('value','Edit');
						jQuery('.class_regex_save_profile').attr('class','class_regex_edit_profile');
						jQuery(".class_regex_tr_row").html('<td></td><td colspan=5><br><br><center><img src="<?php echo REDIRECT_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
						jQuery(".class_regex_tr_row").hide();
						
						//change current button 
						jQuery('#id_regex_edit_profile_'+id).attr('value','Save');
						jQuery('#id_regex_edit_profile_'+id).attr('class','class_regex_save_profile');
					
						jQuery("#id_regex_tr_row_"+id).show();
						jQuery.get('<?php echo REDIRECT_URLPATH; ?>ajax.php?mode=regex&nature=edit&id='+id, function(data) {
							jQuery(".class_regex_tr_row").html('<td></td><td colspan=5><br><br><center><img src="<?php echo REDIRECT_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
							jQuery("#id_regex_tr_row_"+id).html(data);
						});

					});
					
					jQuery('#id_regex_add_profile').live("click",function() {
						jQuery(".class_regex_tr_row").hide();
						jQuery('.class_regex_save_profile').attr('value','Edit');
						jQuery('.class_regex_save_profile').attr('class','class_regex_edit_profile');
						jQuery('#id_regex_row_last_header').show();
						jQuery('#id_regex_row_last').show();						
						jQuery(".class_regex_tr td:eq(2)").html('<br><br><center><img src="<?php echo REDIRECT_URLPATH;?>images/ajax-loader.gif"></center><br><br>');
						jQuery.get('<?php echo REDIRECT_URLPATH; ?>ajax.php?mode=regex&id=x&nature=new', function(data) {
						   jQuery('#id_regex_row_last').html(data);
						   jQuery('#id_regex_add_profile').text('Save');
						   jQuery('#id_regex_add_profile').attr('id','id_regex_save_profile');
						});						
					});
					
					jQuery('.class_delete_profile').click(function() {
						var id = this.id.replace('id_regex_delete_profile_','');
						var profile_id = jQuery('#id_regex_profile_id_'+id).val();
						jQuery('#id_regex_form_nature').val('regex_delete_profile');
						jQuery('#id_regex_profile_id').val(profile_id);
						jQuery("#id_regex_redirect_form").submit();
					});
					
					jQuery("#id_select_referrer_management").live("change", function(){	
					   var input = jQuery(this).val();
					   if (input==1)
					   {
						  jQuery("#redirect_iframe_target").hide();
						  jQuery("#redirect_iframe_target_title").hide();
						   
					   }					  
					   else
					   {
						  jQuery("#redirect_iframe_target").show();
						  jQuery("#redirect_iframe_target_title").show();
					   }
					});
					
				});
				


			</script>
		<?php
	}
	
	function wptt_redirect_settings()
	{
		global $table_prefix;
		
		/* Retrieve the profile data */ 
		$query = "SELECT * FROM {$table_prefix}wptt_wpredirect_profiles";
		$result = mysql_query($query);
		if ($result)
		{
			while ($arr = mysql_fetch_array($result))
			{
				$redirecting_profile_id[] = $arr['id'];
				$redirecting_post_id[] = $arr['post_id'];				
				$redirect_url =  preg_split("/[\r\n,]+/", $arr['redirect_url'], -1, PREG_SPLIT_NO_EMPTY);
				//print_r($redirect_url);exit;
				$redirecting_redirect_url[] = $redirect_url;
				$redirecting_redirect_keywords[] = $arr['redirect_keywords'];
				$redirecting_redirect_type[] = $arr['redirect_type'];
				$redirecting_redirect_spider[] = $arr['ignore_spider'];
				$redirecting_blank_referrer[] = $arr['blank_referrer'];
				$redirecting_human_redirect_count[] = $arr['human_redirect_count'];
				$redirecting_spider_redirect_count[] = $arr['spider_redirect_count'];
				$redirecting_redirect_delay[] = $arr['redirect_delay'];
				$redirecting_exclude_items[] = $arr['exclude_items'];
				$redirecting_require_referrer[] = $arr['require_referrer'];
				$redirecting_status[] = $arr['status'];
			}
		}
		
		/* Retrieve the regex profile data */ 
		$query = "SELECT * FROM {$table_prefix}wptt_wpredirect_regex_profiles";
		$result = mysql_query($query);
		if ($result)
		{
			while ($arr = mysql_fetch_array($result))
			{
				$regex_profile_id[]  = $arr['id'];
				$regex_regex_referrer[]  = $arr['regex_referrer'];
				$regex_regex_landing_page[]  = $arr['regex_landing_page'];
				$regex_redirect[]  = $arr['redirect'];
				$regex_status[]  = $arr['status'];
				$regex_notes[]  = $arr['notes'];
			}
		}
		
		?>
		<br><br><br>
		<div class='wptt_featurebox'>
			<div style='float:right'>
			<a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>geotarget-test.php' title='Discover GeoTargeting Details About Your Connection.' target='_blank'><img src='<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/ico_geotarget.png' border=0></a>&nbsp;
			<a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>settings_export.php?m=2' title='Export Redirect Profiles'><img src='<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/ico_save.png' border=0></a>&nbsp;
			<a target=_blank href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>settings_import.php?m=2' title='Import Link Profiles'><img src='<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/ico_import.png' border=0></a>
			</div>
			<form name=redirect_profile_add id='id_redirecting_redirect_form' method="post" action="admin.php?page=wptt_slug_submenu_redirection_profiles">
			<input type=hidden name=this_action value=save >
			<input type=hidden name=nature id='id_redirecting_form_nature' value=redirecting_save_profile >
			<input type=hidden name=profile_id id='id_redirecting_profile_id' value='' >
		<?php
		
		 echo "<h3>Referrer Based Redirect Profiles</h3>";
		 ?>
			<table>
				<tr>
					<td colspan='7'>
							<i>This module checks the referring URL for keyword matches. If a keyword match is found the user will be redirected to a target page, if not found the user will continue on to whatever page it was originaly destined for. We can also use these profiles to perform normal redirection. Just place a * in the keywords input box and all traffic will be redirected to the new location, regardless of it's referrer. 
							<br>
							<h4>What is a referrer?</h4>
							A referring URL is the URL of the page the visitor was at prior to arriving. We can use referring URLs to detect which keywords a user searched to find your page, and then redirect them accorgingly. We can also target traffic from specific locations such as Twitter.com, or Facebook.com.</i>
							<br><br>
					</td>
				</tr>
			</table>
		 <?php
		 if ($redirecting_profile_id)
		 { 
			echo "<table class='widefat'>\n";	
			echo "<tr><thead><tr><th>#</th>";			
			echo "<th>Post ID</th>";
			echo "<th>Redirect URL</th>";
			echo "<th>Redirect Keywords</th>";
			echo "<th>Human Redirects</th>";
			echo "<th>Spider Redirects</th>";
			echo "<th>Status</th>";
			echo "<th>Actions</th></tr></thead>\n";
		
			$cnt = 1;
			foreach ($redirecting_profile_id as $key=>$val) 
			{				 
				echo '<tr>';
				echo "<td>$cnt";
				echo "</td>";
				$this_permalink = get_permalink($redirecting_post_id[$key]);
				
				echo "<td >";
				echo "<a href='{$this_permalink}' targte=_blank>$redirecting_post_id[$key]</a>";
				echo "</td>";
				echo "<td >";
				//print_r($redirecting_redirect_url[$key]);
				foreach ($redirecting_redirect_url[$key] as $k=>$v)
				{
					echo "<a href='{$v}'>{$v}</a><br>";
				}
				echo "</td>";
				echo "<td >{$redirecting_redirect_keywords[$key]}</td>";
				echo "<td >{$redirecting_human_redirect_count[$key]}</td>";
				echo "<td >{$redirecting_spider_redirect_count[$key]}</td>";
				if ($redirecting_status[$key]==1)
				{
					$this_status = "Active";
				}
				else
				{
					$this_status = "Inactive";
				}
				echo "<td >{$this_status}</td>";
				
				 
				
				echo "<td><input type=button value=Edit  id='id_redirecting_edit_profile_$val' class='class_redirecting_edit_profile'>";
				echo "<input type=button value=Delete  id='id_redirecting_delete_profile_$val' class='class_redirecting_delete_profile'>";
				echo "</td></tr>\n";
				echo "<tr id='id_tr_row_$val' style='display:none;background-color:GhostWhite;' class='class_tr_row'><td></td><td colspan=4>";
				?>
					<br><br>
					<center><img src='<?php echo REDIRECT_URLPATH;?>images/ajax-loader.gif'></center>
					<br><br>
				<?php
				echo '</td></tr>';
				$cnt++;
				
			}
			echo '<tr id="id_row_last_header" style="display:none"><td colspan=6><h4>Add New Profile</h4></td></tr>';
			echo "<tr id='id_row_last' style='display:none'>
					<td colspan=6>
						<center><img src='".REDIRECT_URLPATH."images/ajax-loader.gif'></center>
						<br><br>
					</td>
				</tr>
				</table>
				<div align='right'>
				<br>
				<button class='button-secondary' type='button' id='id_redirecting_add_profile' style='font-size:10px;'>Click Here to Add New Profile</button>
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
							<center><img src='<?php echo REDIRECT_URLPATH; ?>images/ajax-loader.gif'></center>
							<br><br>
						</td>
					</tr>
					<tr>
						<td colspan=6 align='center'>
							<button class='button-secondary' type='button' id='id_redirecting_add_profile' >Add Profile</button>
							<br>
						</td>
					</tr>
				 </table>
			<?php
		 } 
		
		?>
		
		</div>
		</form>
		<br><br>
		
		
		<div class='wptt_featurebox'>
	
			<form name=regex_profile_add id='id_regex_form' method="post" action="admin.php?page=wptt_slug_submenu_redirection_profiles">
			<input type=hidden name=this_action value=save >
			<input type=hidden name=nature id='id_regex_form_nature' value=regex_save_profile >
			<input type=hidden name=profile_id id='id_regex_profile_id' value='' >
		<?php
		
		 echo "<h3>Regular Expression Rules Based Redirection</h3>";
		 
		 echo '<div>This module checks the referring URL & landing page URL for unique characteristics. If the both qualify as a match then we will redirect the traffic to a new URL. If you use wildcards eg: (.*?) in your rule expression then their content can be used in the redirect rule creation by calling $r1,$r2,$r3,etc. to represent the wildcards of the referrer regex rule, and $lp1,$lp2,$lp3,etc. to represent the wildcards of the landingpage regex rule<br><small><strong>Note:</strong> <i><a href=\'http://www.spaweditor.com/scripts/regex/index.php\' target=_blank>This resource</a> is a good source for testing & debugging regular expressions.</i></small><br><br>';
		 echo "";
		 echo " ";
		 
		 
		 if ($regex_profile_id)
		 { 
			echo "<table class='widefat'>\n";	
			echo "<tr><thead><tr><th>#</th>";			
			echo "<th>Referrer Regex Rule</th>";
			echo "<th>Landing Page Regex Rule</th>";
			echo "<th>Redirect Rule</th>";
			echo "<th>Status</th>";
			echo "<th>Actions</th></tr></thead>\n";
		
			$cnt = 1;
			foreach ($regex_profile_id as $key=>$val) 
			{				 
				echo '<tr>';
				echo "<td>$cnt</td>";
				echo "<td>$regex_regex_referrer[$key]</td>";
				echo "<td>$regex_regex_landing_page[$key]</td>";
				echo "<td>$regex_redirect[$key]</td>";				
				if ($regex_status[$key]==1)
				{
					$this_status = "Active";
				}
				else
				{
					$this_status = "Inactive";
				}
				echo "<td >{$this_status}</td>";
				
				 
				
				echo "<td><input type=button value=Edit  id='id_regex_edit_profile_$val' class='class_regex_edit_profile'>";
				echo "<input type=button value=Delete  id='id_regex_delete_profile_$val' class='class_regex_delete_profile'>";
				echo "</td></tr>\n";
				echo "<tr id='id_regex_tr_row_$val' style='display:none;background-color:GhostWhite;' class='class_regex_tr_row'><td></td><td colspan=4>";
				?>
					<br><br>
					<center><img src='<?php echo REDIRECT_URLPATH;?>images/ajax-loader.gif'></center>
					<br><br>
				<?php
				echo '</td></tr>';
				$cnt++;
				
			}
			echo '<tr id="id_regex_row_last_header" style="display:none"><td colspan=6><h4>Add New Profile</h4></td></tr>';
			echo "<tr id='id_regex_row_last' style='display:none'>
					<td colspan=6>
						<center><img src='".REDIRECT_URLPATH."images/ajax-loader.gif'></center>
						<br><br>
					</td>
				</tr>
				</table>
				<div align='right'>
				<br>
				<button class='button-secondary' type='button' id='id_regex_add_profile' style='font-size:10px;'>Click Here to Add New Profile</button>
				<br><br>
				</div>";
		 }
		 else
		 {
		 	 echo "<p><i>no profiles found</i></p>";
				 $key=0;
				 ?>
				 <table class='widefat' style='width:100%' id='id_table_link_profiles'>
					<tr id="id_regex_row_last_header" style="display:none">
						<td colspan=6><h4>Add New Profile</h4>
						</td>
					</tr>
					<tr id='id_regex_row_last' style='display:none'>
						<td colspan=6>
							<center><img src='<?php echo REDIRECT_URLPATH; ?>images/ajax-loader.gif'></center>
							<br><br>
						</td>
					</tr>
					<tr>
						<td colspan=6 align='center'>
							<button class='button-secondary' type='button' id='id_regex_add_profile' >Add Profile</button>
							<br>
						</td>
					</tr>
				 </table>
			<?php
		 } 
		
		?>
		
		</div>
		</form>
		<br><br>
		<?php
	}

	
	function redirect_update_settings()
	{
		
		global $table_prefix;
		global $wordpress_url;
		
		//echo $_POST['nature'];exit;
		if ($_POST['nature']=='redirecting_delete_profile')
		{
			$profile_id = $_POST['profile_id'] ;
			$query = "DELETE FROM {$table_prefix}wptt_wpredirect_profiles  WHERE id='$profile_id'";
			$result = mysql_query($query);
			if (!$result) { echo $query; echo mysql_error(); }
		}
		if ($_POST['nature']=='redirecting_save_profile')
		{
			$notes = addslashes($_POST['notes']) ;
			$profile_id = $_POST['profile_id'] ;
			$post_id = $_POST['post_id'] ;
			$category_id = $_POST['category_id'] ;
			$redirect_url = $_POST['redirect_url'] ;
			$redirect_keywords = addslashes($_POST['redirect_keywords']) ;
			$blank_referrer = $_POST['blank_referrer'] ;
			$redirect_spiders = $_POST['redirect_spiders'] ;
			$require_referrer = $_POST['require_referrer'] ;
			$redirect_type = $_POST['redirect_type'] ;
			$iframe_target = $_POST['iframe_target'] ;
			$iframe_target_title = $_POST['iframe_target_title'] ;
			$redirect_delay = $_POST['redirect_delay'] ;
			$exclude_items = $_POST['exclude_items'] ;
			$throttle = $_POST['redirect_throttle'] ;
			$status = $_POST['status'] ;
			$priority = $_POST['priority'] ;
			
			if ($blank_referrer==1)
			{
				$iframe_target=0;
			}
			
			if ($profile_id)
			{
				//echo 1;exit;
				$query = "UPDATE {$table_prefix}wptt_wpredirect_profiles SET redirect_url='$redirect_url', post_id='$post_id', category_id='$category_id', redirect_keywords ='$redirect_keywords', blank_referrer='$blank_referrer',  ignore_spider='$redirect_spiders', require_referrer='$require_referrer',  redirect_type='$redirect_type', iframe_target='$iframe_target',iframe_target_title='$iframe_target_title', redirect_delay='$redirect_delay', exclude_items='$exclude_items' , notes='$notes', throttle='$throttle', throttle_check='0',priority='$priority', status='$status' WHERE id='$profile_id'";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); }
			}
			else
			{ 
				//echo 2;exit;
				$query = "INSERT INTO {$table_prefix}wptt_wpredirect_profiles (`id`,`post_id`,`category_id`,`redirect_url`,`redirect_keywords`,`blank_referrer`,`ignore_spider`,`require_referrer`,`redirect_type`,`iframe_target`,`iframe_target_title`,`redirect_delay`,`human_redirect_count`,`spider_redirect_count`,`exclude_items`,`notes`,`throttle`,`throttle_check`,`priority`,`status`)";
				$query .= "VALUES ('','$post_id','$category_id','$redirect_url','$redirect_keywords','$blank_referrer','$redirect_spiders','$require_referrer','$redirect_type','$iframe_target','$iframe_target_title','$redirect_delay','0','0','$exclude_items','$notes','$throttle','0','$priority','$status')";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); }	
			}	
		}
		
		if ($_POST['nature']=='regex_delete_profile')
		{
			$profile_id = $_POST['profile_id'] ;
			$query = "DELETE FROM {$table_prefix}wptt_wpredirect_regex_profiles  WHERE id='$profile_id'";
			$result = mysql_query($query);
			if (!$result) { echo $query; echo mysql_error(); }
		}
		if ($_POST['nature']=='regex_save_profile')
		{
			$notes = addslashes($_POST['notes']) ;
			$profile_id = $_POST['profile_id'] ;
			$regex_referrer = $_POST['regex_referrer'] ;
			$regex_landing_page = $_POST['regex_landing_page'] ;
			$spider_management = $_POST['spider_management'] ;
			$redirect = $_POST['redirect'] ;			
			$nature = $_POST['regex_nature'] ;			
			$status = $_POST['status'] ;
			
			if ($profile_id)
			{
				//echo 1;exit;
				$query = "UPDATE {$table_prefix}wptt_wpredirect_regex_profiles SET regex_referrer='$regex_referrer', regex_landing_page='$regex_landing_page', redirect='$redirect', spider_management = '$spider_management', nature='$nature', notes ='$notes', status='$status'WHERE id='$profile_id'";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); exit; }
			}
			else
			{ 
				//echo 2;exit;
				$query = "INSERT INTO {$table_prefix}wptt_wpredirect_regex_profiles (`regex_referrer`,`regex_landing_page`,`redirect`,`nature`,`spider_management`,`notes`,`status`) VALUES ('$regex_referrer','$regex_landing_page','$redirect','$nature','$spider_management','$notes','$status')";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); exit;}	
			}	
		}
	}
	
	function wptt_display_redirection_profiles()
	{
		global $global_wptt;
		redirect_update_settings();
		redirect_add_javascript();
		traffic_tools_javascript();
		traffic_tools_update_check();
		
			traffic_tools_activation_check();
	
		//if active show rest of page
		if (strlen($global_wptt)>2)
		{
			include('wptt_style.php');
			echo "<img src='".WPTRAFFICTOOLS_URLPATH."images/wptt_logo.png'>";
			
			echo "<div id='id_wptt_display' class='class_wptt_display'>";
		
			echo '<div class="wrap">';

			echo "<h2>Redirection Profiles</h2>";
			wptt_redirect_settings();
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
	

	 
	function redirect_execute($profile_id, $blank_referrer, $redirect_type, $redirect_url,$rotate_marker, $redirect_delay, $is_human, $throttle, $throttle_check, $iframe_target, $iframe_target_title=null)
	{
		global $table_prefix;
		global $wordpress_url;
		//echo $profile_id;exit;
		//echo $iframe_target_title;exit;
		$go = 1; 
		//echo $throttle;exit;
		if ($throttle>1)
		{
			if ($throttle_check>=$throttle)
			{
				//echo 1;exit;
				$query = "UPDATE {$table_prefix}wptt_wpredirect_profiles SET throttle_check='0' WHERE id='$profile_id'";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); exit;}
			}
			else
			{
				$go = 0;
				$query = "UPDATE {$table_prefix}wptt_wpredirect_profiles SET throttle_check=throttle_check+1 WHERE id='$profile_id'";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); exit;}
			}
		}
		
		if ($go==0)
		{
			return;
		}
		
		//update count 
		if ($is_human==1)
		{
			$query = "UPDATE {$table_prefix}wptt_wpredirect_profiles SET human_redirect_count=human_redirect_count+1 WHERE id='$profile_id'";
			$result = mysql_query($query);
			if (!$result) { echo $query; echo mysql_error(); exit;}
		}
		else if ($is_human==0)
		{
			$query = "UPDATE {$table_prefix}wptt_wpredirect_profiles SET spider_redirect_count=spider_redirect_count+1 WHERE id='$profile_id'";
			$result = mysql_query($query);
			if (!$result) { echo $query; echo mysql_error(); exit;}
		}
		
		//generate right redirect url
		if (strstr($redirect_url,'{'))
		{
			$geo_array = unserialize(traffic_tools_remote_connect('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
			
			$redirect_url =  preg_split("/[\r\n,]+/", $redirect_url, -1, PREG_SPLIT_NO_EMPTY);
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
				$count = count($new_rotate_urls);
				if (count($new_rotate_urls)>0)
				{
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
			
					$redirect_url = $new_rotate_urls[$rotate_marker];
					$query = "UPDATE {$table_prefix}wptt_wpredirect_profiles SET rotate_marker='{$next_key}' WHERE id='$profile_id'";
					$result = mysql_query($query);
					if (!$result){echo $query; echo mysql_error(); exit;}
				}
				else
				{
					return;
				}
				
			}
		}
		else
		{	
			//echo $profile_id;
			//echo $rotate_marker;
			$redirect_url =  preg_split("/[\r\n,]+/", $redirect_url, -1, PREG_SPLIT_NO_EMPTY);
			$count = count($redirect_url);
			if ($count>1)
			{
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
	
				$redirect_url = $redirect_url[$rotate_marker];

				$query = "UPDATE {$table_prefix}wptt_wpredirect_profiles SET rotate_marker='{$next_key}' WHERE id='$profile_id'";
				$result = mysql_query($query);
				if (!$result){echo $query; echo mysql_error(); exit;}
			}
			else
			{			
				$redirect_url = $redirect_url[0];	
			}
			//echo $redirect_url; exit;
		}
		
		//echo $redirect_url;exit;
		//echo $redirect_delay;exit;
		if ($blank_referrer=='yes'||$redirect_delay>0)
		{
			//echo 1;exit;
			
			if ($blank_referrer=='yes')
			{
				$redirect_url = urlencode($redirect_url);
				$blank_referrer_url = $wordpress_url."wp-content/plugins/wp-traffic-tools/redirect.php?url=$redirect_url";	
				echo "<meta http-equiv='refresh' content='{$redirect_delay};url={$blank_referrer_url}'>";
			}
			else
			{
				echo "<meta http-equiv='refresh' content='{$redirect_delay};url={$redirect_url}'>";
			}
			//exit;
		}
		else
		{
			if ($iframe_target==1)
			{
				?>
				<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
				<html lang="en">
				 <head>
				  <title><?php echo $iframe_target_title; ?></title>
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
				  </div>				 
				 </body>
				</html>
			<?php
			exit;
			}
			else
			{
				header("HTTP/1.1 $redirect_type ");
				header("Location: $redirect_url");
				exit;
			}
		}
	}	
	
	function wptt_cparedirect($value)
	{
	  $currentUrl =  "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]."";
	  $startHtml   = "<html>\n<head>\n</head>\n<body>\n";      
	  $formCode    = "<form action=\"$currentUrl\" method=\"post\" id=\"form\">\n<input type=\"hidden\" name=\"wptt_rnow\" value=\"$value\" /></form>\n";      
	  $javaScript  = "<script language=\"JavaScript\">\ndocument.getElementById('form').submit();\n</script>\n"; 
	  $endHtml     = "</body>\n</html>";
	  
	  return $startHtml . $formCode . $javaScript . $endHtml;  
	}

	function redirect_redirect()
	{
		if (is_admin())
			return;
			
		global $post;
		global $table_prefix;
		global $wordpress_url;
		global $current_url;
		
		$blog_url = $wordpress_url;
		$referrer = $_SERVER['HTTP_REFERER'];
		//echo $referrer;
		//echo "<br>";
		//exit;
		$referrer = rawurldecode($referrer);
		$referrer = explode('&url=',$referrer);
		$referrer = $referrer[0];
		$referrer = str_replace('http:','',$referrer);
		//echo $current_url;exit;
		$post_id = url_to_postid($current_url);
		if (!$post_id){	$post_id = wptt_url_to_postid_final($current_url); }
		if (!$post_id){	$post_id = wptt_url_to_postid($current_url); }
		
		$cat = get_category_by_path(get_query_var('category_name'),false);
		$category_id = $cat->cat_ID;
		
		//echo 1;
		//echo $_SERVER['HTTP_REFERER'];exit;
		//echo $referrer;exit;
		//echo $post_id;exit;
		//echo "<br>";
		//first check post id
		
		//cpa-redirection check
		if ($_POST['wptt_rnow']) { 
			$url = $_POST['wptt_rnow'];
			header("Location: $url"); 
			exit;
		} 

		if (!strstr($current_url,'wp-login.php') && !strstr($current_url,'wp-admin') && ($post_id || strstr($current_url,'tag/') || strstr($current_url,'page/') || ($current_url==$wordpress_url)))
		{
			//echo 1;
			$query = "SELECT * FROM {$table_prefix}wptt_wpredirect_regex_profiles WHERE status='1'";
			$result = mysql_query($query);
			if (!$result){echo $query; echo mysql_error(); }
			$count = mysql_num_rows($result);
			if ($count>0)
			{
				while($array = mysql_fetch_array($result))
				{
					$profile_id = $array['id'];
					$regex_referrer = $array['regex_referrer'];
					$regex_landing_page = $array['regex_landing_page'];
					$redirect = $array['redirect'];
					$regex_nature = $array['nature'];
					$spider_management = $array['spider_management'];
					
					//echo $regex;
					//echo "<br>";
					//echo  $referrer;exit;
						
					if (@preg_match_all($regex_referrer,$referrer,$this_match))
					{
						array_shift($this_match);
						//echo $regex;
						//echo "<br>";
						//print_r($this_match); exit;
						//echo "<br>";
						//echo 1; exit;
						//$this_array = $this_match[1];
						$i = 0;
						foreach ($this_match as $k=>$v)
						{
							$i = $k + 1;						
							$redirect = str_replace('$r'.$i,$v[0],$redirect);
							if ($redirect_nature==1)
							{
								$redirect = str_replace('-','+',$redirect);
							}
						}
					
						if (@preg_match_all($regex_landing_page,$current_url,$this_match))
						{
							array_shift($this_match);							
							$i=0;
							//echo $current_url;exit;
							
							foreach ($this_match as $k=>$v)
							{
								$i = $k + 1;						
								$redirect = str_replace('$lp'.$i,$v[0],$redirect);
								if ($redirect_nature==1)
								{
									$redirect = str_replace('-','+',$redirect);
								}
							}							

							if (isset($spider_management)&&$spider_management==0)
							{
								$visitor_nature = wptt_filter_spiders();
								//prevent spider redirection
								if ($visitor_nature==0)
								{
									continue;
								}
							}							
							else if (isset($spider_management)&&$spider_management==2)
							{
								$visitor_nature = wptt_filter_spiders();
								//prevent human redirection
								if ($visitor_nature==1)
								{
									continue;
								}
							}
							
							 
							if ($regex_nature==0)
							{
								echo wptt_cparedirect($redirect);
								exit;
							}
							
							else if ($regex_nature==2)
							{
								//echo 1; exit;
								header("HTTP/1.1 301 ");
								header("Location: $redirect");
								exit;
							}
							else if ($regex_nature==3)
							{
							    /*
							     echo "profile id:".$profile_id;
							    echo "<br>";
								echo "regex_nature:".$regex_nature;
								echo "<br>";
							    echo "spider management:".$spider_management;
							    echo "<br>";
							    echo "visitor:".$visitor_nature;
						    	echo "<hr>";
						    	exit;
						    	*/
						    	
								?>
								<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
								<html lang="en">
								 <head>
								  <title><?php echo $iframe_target_title; ?></title>
								  <style type="text/css">
								   html, body, div, iframe { margin:0; padding:0; height:100%; }
								   iframe { display:block; width:100%; border:none; }
								   background { display:none;}
								  </style>
								 </head>
								 <body>
								  <div>
								   <iframe src="<?php echo  $redirect;?>" height="100%" width="100%">
								   </iframe>
								  </div>				 
								 </body>
								</html>
								
								<?php
								exit;
							}
							else if ($regex_nature==1)
							{
								//echo here;exit;
								$_SESSION['wptt_regex_redirect']= $redirect;
								
								function wptt_regex_popunder()
								{
									$redirect = $_SESSION['wptt_regex_redirect'];
									$popups_nature="popunder";
									$popups_cookie_timeout = 0;
									$popups_height = 900;
									$popups_width = 1100;
									//echo $redirect;exit;
									
									?>
									<script>
									var pshow = false;
									var PopFocus = 1;
									var _Top = null;
									var wptt = 0;

									function GetWindowHeight() {
										var myHeight = 0;
										if( typeof( _Top.window.innerHeight ) == 'number' ) {
										myHeight = _Top.window.innerHeight;
										} else if( _Top.document.documentElement && _Top.document.documentElement.clientHeight ) {
										myHeight = _Top.document.documentElement.clientHeight;
										} else if( _Top.document.body && _Top.document.body.clientHeight ) {
										myHeight = _Top.document.body.clientHeight;
										}
										return myHeight;
									}

									function GetWindowWidth() {
										var myWidth = 0;
										if( typeof( _Top.window.innerWidth ) == 'number' ) {
										myWidth = _Top.window.innerWidth;
										} else if( _Top.document.documentElement && _Top.document.documentElement.clientWidth ) {
										myWidth = _Top.document.documentElement.clientWidth;
										} else if( _Top.document.body && _Top.document.body.clientWidth ) {
										myWidth = _Top.document.body.clientWidth;
										}
										return myWidth;
									}

									function GetWindowTop() {
										return (_Top.window.screenTop != undefined) ? _Top.window.screenTop : _Top.window.screenY;
									}

									function GetWindowLeft() {
										return (_Top.window.screenLeft != undefined) ? _Top.window.screenLeft : _Top.window.screenX;
									}

									function openp(url)
									{
										var popURL = "about:blank";
										var popID = "ad_" + Math.floor(89999999*Math.random()+10000000);
										var pxLeft = 0;
										var pxTop = 0;
										pxLeft = (GetWindowLeft() + (GetWindowWidth() / 2) - (<?php echo $popups_width; ?> / 2));
										pxTop = (GetWindowTop() + (GetWindowHeight() / 2) - (<?php echo $popups_height; ?> / 2));

										if ( pshow == true )
										{
										return true;
										}

										var PopWin=_Top.window.open(popURL,popID,'toolbar=0,scrollbars=1,location=1,statusbar=1,menubar=0,resizable=1,top=' + pxTop + ',left=' + pxLeft + ',width= <?php echo $popups_width; ?> ,height= <?php echo $popups_height; ?>');

										if (PopWin)
										{
											pshow = true;
											
											
											if (PopFocus == 0)
											{
												PopWin.blur();

												if (navigator.userAgent.toLowerCase().indexOf("applewebkit") > -1)
												{
													_Top.window.blur();
													_Top.window.focus();
												}
											}

											PopWin.Init = function(e) {

												with (e) 
												{

													Params = e.Params;
													Main = function(){
														
														<?php if (strstr($popups_nature[$key],'popup'))
														{
														?>
															var popURL = Params.PopURL;
															PopWin.Params = {PopURL: url };
															if (typeof window.mozPaintCount != "undefined") {
																var x = window.open(popURL);
																//x.close();
																
																}
															

															window.location = popURL;
														<?php
														}
														else
														{
														?>
															var popURL = Params.PopURL;
															if (typeof window.mozPaintCount != "undefined") {
																var x = window.open("about:blank");
																x.close();
																

															}
															try { opener.window.focus(); }
															catch (err) { }

															window.location = popURL;

															
														<?php
														}
														?>
															
													};

													Main();
												}
											};

											PopWin.Params = {PopURL: url};

											PopWin.Init(PopWin);
										}

										return PopWin;
									}

									function setCookie(name, value, time)
									{
										var expires = new Date();

										expires.setTime( expires.getTime() + time );

										document.cookie = name + '=' + value + '; path=/;' + '; expires=' + expires.toGMTString() ;
									}

									function getCookie(name) 
									{
										var cookies = document.cookie.toString().split('; ');
										var cookie, c_name, c_value;

										for (var n=0; n<cookies.length; n++) 
										{
											cookie  = cookies[n].split('=');
											c_name  = cookie[0];
											c_value = cookie[1];

											if ( c_name == name ) {
												return c_value;
											}
										}

										return null;
									}

									function wpttgopop()
									{
										_Top = self;

										if (top != self)
										{
											try
											{
											if (top.document.location.toString())
											_Top = top;
											}
											catch(err) { }
										}
										
										if ( document.attachEvent )
										{
											document.attachEvent( 'onclick', checkTarget );
										}
										else if ( document.addEventListener )
										{
											document.addEventListener( 'click', checkTarget, false );
										}										
									}

									function checkTarget(e)
									{
										//alert(wptt);
										if ( !getCookie('wptt_pop') || wptt ==1) {
											var e = e || window.event;
											openp('<?php echo $redirect; ?>');
											setCookie('wptt_pop', 1, 60*60*2);
										}
									}

									wpttgopop();
									</script>
									<?php
								}
								
								add_action('wp_head','wptt_regex_popunder');							
								
								//exit;
							}
						}
						
					}
				}
			}
		}
		
		if (($post_id!=0 || $category_id) && str_replace('/','',$current_url)!=str_replace('/','',$blog_url))
		{
			//echo $category_id;
			$query = "SELECT * FROM {$table_prefix}wptt_wpredirect_profiles WHERE post_id='$post_id' && status='1' OR category_id='$category_id' && status='1' ORDER BY priority ASC";
			$result = mysql_query($query);
			if (!$result){echo $query; echo mysql_error(); }
		
			while($array = mysql_fetch_array($result))
			{
				$profile_id = $array['id'];
				$redirect_url = $array['redirect_url'];
				$rotate_marker = $array['rotate_marker'];
				$blank_referrer = $array['blank_referrer'];
				$redirect_spider = $array['ignore_spider'];
				$require_referrer = $array['require_referrer'];
				$redirect_type = $array['redirect_type'];
				$iframe_target = $array['iframe_target'];
				$iframe_target_title = $array['iframe_target_title'];
				$redirect_delay = $array['redirect_delay'];
				$throttle = $array['throttle'];
				$throttle_check = $array['throttle_check'];
				$exclude_items = $array['exclude_items'];
				$exclude_items = explode(',',$exclude_items);
				$redirect_keywords = $array['redirect_keywords'];
				$redirect_keywords = explode(',', $redirect_keywords);
				$redirect_keywords = array_filter($redirect_keywords);
				
				$redirect_url = trim($redirect_url);
				//echo $redirect_delay;exit;
				if (!in_array($post_id,$exclude_items)&&$current_url!=$redirect_url)
				{
					
					
					if ($require_referrer==1&&!$referrer)
					{
						$redirect = 0;
					}
					else
					{
						$redirect=1;
					}
					
					//prevent spider redirect
					if ($redirect_spider==0&&$redirect==1)
					{
						$is_human = wptt_filter_spiders();
						$redirect = $is_human;
					}
					//prevent human redirection
					else if ($redirect_spider==2&&$redirect==1)
					{
						$is_human = wptt_filter_spiders();

						if ($is_human==0)
						{
							$redirect = 0;
							$is_human = 1;
						}
					}
					else
					{
						$is_human = wptt_filter_spiders();
					}
					
					//redirect posts with profiles here
					if ($redirect==1)
					{
						//find out if our referrer has out keywords
						$this_count=0;
						foreach ($redirect_keywords as $k =>$v)
						{
							$v = trim($v);
							$v = str_replace(' ', '+', $v);
	
							if (stristr($referrer, $v)||$v=='*')
							{
								redirect_execute($profile_id,$blank_referrer,$redirect_type,$redirect_url,$rotate_marker,$redirect_delay,$is_human,$throttle,$throttle_check,$iframe_target, $iframe_target_title);
							}
							else
							{
								if (stristr($v[0],'!')&&!stristr($referrer, substr($v,1)))
								{
									$this_count++;
								}								
							}
						}
						
						if ($this_count==count($redirect_keywords))
						{
							redirect_execute($profile_id,$blank_referrer,$redirect_type,$redirect_url,$rotate_marker,$redirect_delay,$is_human,$throttle,$throttle_check,$iframe_target, $iframe_target_title);
							$stop = 1;
						}
					}
				}
			}
		}
		
		if (strstr($current_url,'?gclid'))
		{
			$current_url = explode('?gclid',$current_url);
			$current_url = $current_url[0];
		}
		
		//check if homepage and if there is redirect profile setup for homepage
		if (str_replace('/','',$current_url)==str_replace('/','',$blog_url))
		{
			
			//echo 1; exit;
			$post_id='h';
			$query = "SELECT * FROM {$table_prefix}wptt_wpredirect_profiles WHERE post_id='h'  && status='1' ORDER BY priority ASC";
			$result = mysql_query($query);
			if (!$result){echo $query; echo mysql_error(); }
			
			if (mysql_num_rows($result)>0)
			{
				while($array = mysql_fetch_array($result))
				{
					
					$profile_id = $array['id'];
					$redirect_url = $array['redirect_url'];
					$rotate_marker = $array['rotate_marker'];
					$blank_referrer = $array['blank_referrer'];
					$redirect_spider = $array['ignore_spider'];
					$require_referrer = $array['require_referrer'];
					$redirect_type = $array['redirect_type'];
					$iframe_target = $array['iframe_target'];
					$iframe_target_title = $array['iframe_target_title'];
					$redirect_delay = $array['redirect_delay'];
					$throttle = $array['throttle'];
					$throttle_check = $array['throttle_check'];
					$exclude_items = $array['exclude_items'];
					$exclude_items = explode(',',$exclude_items);
					$redirect_keywords = $array['redirect_keywords'];
					$redirect_keywords = explode(',', $redirect_keywords);
				
					//echo $redirect_spider;exit;
					
					if (!in_array($post_id,$exclude_items)&&$current_url!=$redirect_url)
					{
						
						if ($require_referrer==1&&!$referrer)
						{
							$redirect = 0;
						}						
						else
						{
							//echo 2; exit;
							$redirect=1;
						}
						
						//prevent spider redirect
						if ($redirect_spider==0&&$redirect==1)
						{
							$is_human = wptt_filter_spiders();
							
							//echo "here $is_human";
							//exit;
							
							$redirect = $is_human;
						}
						//prevent human redirect
						else if ($redirect_spider==2&&$redirect==1)
						{
							$is_human = wptt_filter_spiders();

							if ($is_human)
							{
								$redirect = 0;
							}
						}
						else
						{
							$is_human = wptt_filter_spiders();
						}
						
						//echo $is_human;
						//echo $redirect;exit;
						if ($redirect==1)
						{
							//find out if our referrer has out keywords
							//echo $redirect;exit;
							$this_count=0;
							foreach ($redirect_keywords as $k =>$v)
							{
								$v = trim($v);
								$v = str_replace(' ', '+', $v);
								if (stristr($referrer, $v)||$v=='*')
								{
									redirect_execute($profile_id,$blank_referrer,$redirect_type,$redirect_url,$rotate_marker,$redirect_delay,$is_human,$throttle,$throttle_check,$iframe_target, $iframe_target_title);
								}
								else
								{
									if (stristr($v[0],'!')&&!stristr($referrer, substr($v,1)))
									{
										$this_count++;
									}
								}
							}
							
							if ($this_count==count($redirect_keywords))
							{
								redirect_execute($profile_id,$blank_referrer,$redirect_type,$redirect_url,$rotate_marker,$redirect_delay,$is_human,$throttle,$throttle_check,$iframe_target, $iframe_target_title);
								$stop = 1;
							}
						}
					}
				}
			}
		}
		
		if (!strstr($current_url,'wp-login.php') && !strstr($current_url,'wp-admin') && ($post_id || strstr($current_url,'tag/') || strstr($current_url,'page/')))
		{
			//echo 1; exit;
			//echo is_admin(); exit;
			//then check the global redirects
			$query = "SELECT * FROM {$table_prefix}wptt_wpredirect_profiles WHERE post_id='*' && redirect_keywords!='*' && status='1' ORDER BY priority ASC";
			$result = mysql_query($query);
			if (!$result){echo $query; echo mysql_error();}
			$count = mysql_num_rows($result);
			
			$profile_id = array();
			$status= array();
			$redirect_profile_id = array();
			$redirect_keywords = array();
			$redirect_url = array();
			$rotate_marker = array();
			$redirect_type = array();
			$redirect_delay = array();
			$throttle = array();
			$throttle_check = array();
			$redirect_spider = array();
			$require_referrer = array();
			$blank_referrer = array();
			$exclude_items = array();
					
			if ($count>0)
			{
				
				
				while ($array = mysql_fetch_array($result))
				{
					$profile_id[] = $array['id'];
					$redirect_keywords[] = $array['redirect_keywords'];
					$redirect_url[] = $array['redirect_url'];
					$rotate_marker[] = $array['rotate_marker'];
					$blank_referrer[] = $array['blank_referrer'];
					$redirect_type[] = $array['redirect_type'];
					$redirect_delay[] = $array['redirect_delay'];
					$throttle[] = $array['throttle'];
					$throttle_check[] = $array['throttle_check'];
					$iframe_target[] = $array['iframe_target'];
					$iframe_target_title[] = $array['iframe_target_title'];
					$redirect_spider[] = $array['ignore_spider'];
					$exclude_items[] = $array['exclude_items'];
					$require_referrer[] = $array['require_referrer'];
				}
			
				$propper = str_replace(array('%2F','-','_','%20'), ' ',$referrer);
				
				//echo $propper;
				//echo "<hr>";
				//echo $stop;
				foreach ($redirect_keywords as $key =>$val)
				{
					
					//echo $val."<br>";
					 //echo $stop;
					 //echo "<hr>";
					 
					 
					if (!$stop)
					{
						$exclude_items[$key] = explode(',',$exclude_items[$key]);
						$exclude_items[$key] = array_filter($exclude_items[$key]);
						if (!in_array($post_id,$exclude_items[$key]))
						{
							$these_keywords = explode(',',$val);
							$this_count = 0;
							foreach ($these_keywords as $k=>$v)
							{
								
								$v = trim($v);
								if (stristr($propper, $v)||$v=='*'&&!$stop)
								{		
									//echo "here";exit;
									//echo $referrer."<br>";
									//echo $wordpress_url."<br>";
									//echo $current_url."<br>";
									//echo $redirect_url[$key];exit;
									if ($v!='*'&&!strstr($referrer,$wordpress_url)&&$current_url!=$redirect_url[$key])
									{
										//echo 7;exit;
										if ($require_referrer[$key]==1&&!$referrer)
										{
											$redirect = 0;
										}
										else
										{
											$redirect=1;
										}
										
										//print_r($redirect_spider);
										//echo $redirect_spider[$key];
										
										//prevent spider redirect
										if ($redirect_spider[$key]==0&&$redirect==1)
										{
											$is_human = wptt_filter_spiders();
											$redirect = $is_human;
										}
										//prevent human redirect
										else if ($redirect_spider[$key]==2&&$redirect==1)
										{
											$is_human = wptt_filter_spiders();

											if ($is_human)
											{
												$redirect = 0;
											}
										}
										else
										{
											$is_human= wptt_filter_spiders();
										}
										
										//echo $redirect;exit;
										if ($redirect==1)
										{
											
											redirect_execute($profile_id[$key],$blank_referrer[$key],$redirect_type[$key],$redirect_url[$key],$rotate_marker[$key],$redirect_delay[$key],$is_human,$throttle[$key],$throttle_check[$key],$iframe_target[$key],$iframe_target_title[$key]);
											$stop = 1;
										}
									}
								}
								else
								{
									if (stristr($v[0],'!')&&!stristr($propper, substr($v,1)))
									{	
										$this_count++;										
									}
								}
							}
							
							if ($this_count==count($these_keywords))
							{
								//echo 7;exit;
								if ($require_referrer[$key]==1&&!$referrer)
								{
									$redirect = 0;
								}
								else
								{
									$redirect=1;
								}
										
										//print_r($redirect_spider);
										//echo $redirect_spider[$key];
								
								//prevent spider redirect
								if ($redirect_spider[$key]==0&&$redirect==1)
								{
									$is_human = wptt_filter_spiders();
									$redirect = $is_human;
								}
								//prevent human redirect
								else if ($redirect_spider[$key]==2&&$redirect==1)
								{
									$is_human = wptt_filter_spiders();

									if ($is_human)
									{
										$redirect = 0;
									}
								}
								else
								{
									$is_human= wptt_filter_spiders();
								}
								
								//echo $redirect;exit;
								if ($redirect==1)
								{
									
									redirect_execute($profile_id[$key],$blank_referrer[$key],$redirect_type[$key],$redirect_url[$key],$rotate_marker[$key],$redirect_delay[$key],$is_human,$throttle[$key],$throttle_check[$key],$iframe_target[$key],$iframe_target_title[$key]);
									$stop = 1;
								}
							}
						}
					}
				}
			}
			
			
			//now check for global redirects that have a wildcard for keywords
			$query = "SELECT * FROM {$table_prefix}wptt_wpredirect_profiles WHERE post_id='*' && redirect_keywords='*' && status='1' ORDER BY priority ASC";
			$result = mysql_query($query);
			if (!$result){echo $query; echo mysql_error();}
			$count = mysql_num_rows($result);
					
			$redirect_profile_id = array();
			$redirect_keywords = array();
			$redirect_url = array();
			$rotate_marker = array();
			$redirect_type = array();
			$throttle = array();
			$throttle_check = array();
			$redirect_spider = array();
			$require_referrer = array();
			$blank_referrer = array();
			$exclude_items = array();
					
			if ($count>0)
			{
				
				//echo 1; exit;
				while ($array = mysql_fetch_array($result))
				{
					$profile_id[] = $array['id'];
					$redirect_keywords[] = $array['redirect_keywords'];
					$redirect_url[] = $array['redirect_url'];
					$rotate_marker[] = $array['rotate_marker'];
					$blank_referrer[] = $array['blank_referrer'];
					$redirect_type[] = $array['redirect_type'];
					$iframe_target[] = $array['iframe_target'];
					$iframe_target_title[] = $array['iframe_target_title'];
					$redirect_delay[] = $array['redirect_delay'];
					$throttle[] = $array['throttle'];
					$throttle_check[] = $array['throttle_check'];
					$redirect_spider[] = $array['ignore_spider'];
					$require_referrer[] = $array['require_referrer'];
					$exclude_items[] = $array['exclude_items'];
				}
				
				if (!$stop)
				{
					foreach ($redirect_keywords as $key =>$val)
					{
						//echo $val; exit;
					
						if (str_replace('/','',$current_url)!=str_replace('/','',$redirect_url[$key])&&!$stop)
						{
							//echo $current_url;
							//echo "<br>";
							//echo $redirect_url[$key];							
							$exclude_items[$key] = explode(',',$exclude_items[$key]);
							$exclude_items[$key] = array_filter($exclude_items[$key]);
							
							if (!in_array($post_id,$exclude_items[$key]))
							{
								if ($require_referrer[$key]==1&&!$referrer)
								{
									$redirect = 0;
								}
								else
								{
									$redirect=1;
								}
							
							    //prevent spider redirection
								if ($redirect_spider[$key]==0&&$redirect==1)
								{
									//$redirect = wptt_filter_spiders();
									$is_human = wptt_filter_spiders();
									$redirect = $is_human;
								}
								//prevent human redirection
								else if ($redirect_spider[$key]==2&&$redirect==1)
								{
									$is_human = wptt_filter_spiders();

									if ($is_human)
									{
										$redirect = 0;
									}
								}
								else
								{
									$is_human= wptt_filter_spiders();
								}
								
								//echo $redirect;exit;
								if ($redirect==1)
								{
									redirect_execute($profile_id[$key],$blank_referrer[$key],$redirect_type[$key],$redirect_url[$key],$rotate_marker[$key],$redirect_delay[$key], $is_human, $throttle[$key],$throttle_check[$key],$iframe_target[$key],$iframe_target_title[$key]);
									$stop =1;
								}
							}
						}
					}
				}
			}
		}	
		
	}
    
	function redirect_save_post($postID)
	{
		//echo 1;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE || wp_is_post_revision($postID)) 
		{
		
		}
		else
		{
			
			global $table_prefix;
		
			$post_id =  $_POST['redirecting_post_id'];
			$redirect_url = $_POST['redirecting_redirect_url'];
			$redirect_keywords = $_POST['redirecting_redirect_keywords'];
			$redirect_spider = $_POST['redirecting_redirect_spider'];
			$require_referrer = $_POST['redirecting_require_referrer'];
			$redirect_type = $_POST['redirecting_redirect_type'];
			$redirect_delay = $_POST['redirecting_redirect_delay'];
			$blank_referrer = $_POST['redirecting_blank_referrer'];
			$redirect_priority = $_POST['priority'];
			//echo $redirect_priority;exit;
			if (trim($redirect_url))
			{
				$query = "SELECT * FROM {$table_prefix}wptt_wpredirect_profiles WHERE post_id='{$post_id}'";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); }
				
				if (mysql_num_rows($result)>0)
				{
					$query = "UPDATE {$table_prefix}wptt_wpredirect_profiles SET redirect_url='{$redirect_url}', redirect_keywords ='{$redirect_keywords}', ignore_spider ='{$redirect_spider}', require_referrer ='{$require_referrer}', redirect_type ='{$redirect_type}',  redirect_delay ='{$redirect_delay}', priority ='{$redirect_priority}', blank_referrer='$blank_referrer' WHERE post_id='{$post_id}'";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo mysql_error();  }
				}
				else
				{
					$query = "INSERT INTO {$table_prefix}wptt_wpredirect_profiles (`id`,`post_id`,`redirect_url`,`redirect_keywords`,`ignore_spider`,`require_referrer`,`redirect_type`,`redirect_delay`,`priority`,`blank_referrer`,`status`,`human_redirect_count`,`spider_redirect_count`) VALUES ('','$postID','$redirect_url','$redirect_keywords','$redirect_spider','$require_referrer','$redirect_type','$redirect_delay','$redirect_priority','$blank_referrer','1','0','0')";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo mysql_error(); }
				}
			}
		}
		return $postID;
	}
	
	

	/*
	//on activation
	register_activation_hook(__FILE__, 'redirect_activate');
	add_action('admin_menu', 'redirect_add_menu');
	*/
	add_action('init','redirect_redirect');
	add_action('save_post','redirect_save_post');
	
?>