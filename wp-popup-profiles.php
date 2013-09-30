<?php
	
	//ADD MENU ITEM AND OPTIONS PAGE
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	function wptt_popups_add_javascript()
	{
		?>
			<style type='text/css'>
			input , textarea
			{
				color:#999999;
			}			
			</style>
			<script type="text/javascript">
				
				jQuery(document).ready(function() 
				{
					jQuery('#id_popups_keywords_add_profile').live("click",function() {
						jQuery(".class_popups_keywords_tr_row").hide();
						/*
						jQuery('.class_profile_save_profile').attr('value','Edit');
						jQuery('.class_profile_save_profile').attr('class','class_cloaking_edit_profile');
						*/
						jQuery('#id_popups_keywords_row_last_header').show();
						jQuery('#id_popups_keywords_row_last').show();						
						jQuery(".class_popups_keywords_tr td:eq(2)").html('<br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br>');
						jQuery.get('<?php echo WPTRAFFICTOOLS_URLPATH; ?>ajax.php?mode=popups&id=x&section=keywords', function(data) {
						   jQuery('#id_popups_keywords_row_last').html(data);
						   jQuery('#id_popups_keywords_add_profile').text('Save');
						   jQuery('#id_popups_keywords_add_profile').attr('id','id_popups_keywords_save_profile');
						});						
					});
					
					jQuery('.class_popups_keywords_save_profile').live("click" ,function() {
						//alert(1);
						jQuery('#id_popups_keywords_form_nature').val('popups_keywords_save_profile');
						jQuery("#id_popups_keywords_form").submit();
					});
					
					jQuery('.class_popups_keywords_edit_profile').live("click" ,function() {
						var id = this.id.replace('id_popups_keywords_edit_profile_','');
						
						//hide add new profile
						jQuery("#id_popups_keywordsrow_last").html('<td></td><td colspan=5><br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
						jQuery("#id_popups_keywordsrow_last").hide();
						jQuery("#id_popups_keywordsrow_last_header").hide();
						jQuery('#id_popups_keywords_save_profile').text('Click Here to Add New Profile');
						jQuery('#id_popups_keywords_save_profile').attr('id','id_popups_keywords_add_profile');
						
						//change other editing boxes back to normal
						jQuery('.class_popups_keywords_save_profile').attr('value','Edit');
						jQuery('.class_popups_keywords_save_profile').attr('class','class_popups_keywords_edit_profile');
						jQuery(".class_popups_keywords_tr_row").html('<td></td><td colspan=5><br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
						jQuery(".class_popups_keywords_tr_row").hide();
						
						//change current button 
						jQuery('#id_popups_keywords_edit_profile_'+id).attr('value','Save');
						jQuery('#id_popups_keywords_edit_profile_'+id).attr('class','class_popups_keywords_save_profile');
						
					
						jQuery("#id_popups_keywords_tr_row_"+id).show();
						jQuery.get('<?php echo WPTRAFFICTOOLS_URLPATH; ?>ajax.php?mode=popups&section=keywords&nature=edit&id='+id, function(data) {
							jQuery(".class_popups_keywords_tr_row").html('<td></td><td colspan=5><br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
							jQuery("#id_popups_keywords_tr_row_"+id).html(data);
						});

					});
					
					jQuery('.class_popups_keywords_delete_profile').click(function() {
					
					    if (confirm('Are you sure you want to delete this popup profile?'))
						{
							var id = this.id.replace('id_popups_keywords_delete_','');
							jQuery('#id_popups_keywords_form_nature').val('popups_keywords_delete_profile');
							jQuery('#id_popups_keywords_profile_id').val(id);
							jQuery("#id_popups_keywords_form").submit();
						}
					});
					
					jQuery('#id_popups_posts_add_profile').live("click",function() {
						jQuery(".class_popups_posts_tr_row").hide();
						/*
						jQuery('.class_profile_save_profile').attr('value','Edit');
						jQuery('.class_profile_save_profile').attr('class','class_cloaking_edit_profile');
						*/
						jQuery('#id_popups_posts_row_last_header').show();
						jQuery('#id_popups_posts_row_last').show();						
						jQuery(".class_popups_posts_tr td:eq(2)").html('<br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br>');
						jQuery.get('<?php echo WPTRAFFICTOOLS_URLPATH; ?>ajax.php?mode=popups&id=x&section=posts', function(data) {
						   jQuery('#id_popups_posts_row_last').html(data);
						   jQuery('#id_popups_posts_add_profile').text('Save');
						   jQuery('#id_popups_posts_add_profile').attr('id','id_popups_posts_save_profile');
						});						
					});
					
					jQuery('.class_popups_posts_save_profile').live("click" ,function() {
						//alert(1);
						jQuery('#id_popups_posts_form_nature').val('popups_posts_save_profile');
						jQuery("#id_popups_posts_form").submit();
					});
					
					jQuery('.class_popups_posts_edit_profile').live("click" ,function() {
						var id = this.id.replace('id_popups_posts_edit_profile_','');
						
						//hide add new profile
						jQuery("#id_popups_postsrow_last").html('<td></td><td colspan=5><br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
						jQuery("#id_popups_postsrow_last").hide();
						jQuery("#id_popups_postsrow_last_header").hide();
						jQuery('#id_popups_posts_save_profile').text('Click Here to Add New Profile');
						jQuery('#id_popups_posts_save_profile').attr('id','id_popups_posts_add_profile');
						
						//change other editing boxes back to normal
						jQuery('.class_popups_posts_save_profile').attr('value','Edit');
						jQuery('.class_popups_posts_save_profile').attr('class','class_popups_posts_edit_profile');
						jQuery(".class_popups_posts_tr_row").html('<td></td><td colspan=5><br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
						jQuery(".class_popups_posts_tr_row").hide();
						
						//change current button 
						jQuery('#id_popups_posts_edit_profile_'+id).attr('value','Save');
						jQuery('#id_popups_posts_edit_profile_'+id).attr('class','class_popups_posts_save_profile');
						
					
						jQuery("#id_popups_posts_tr_row_"+id).show();
						jQuery.get('<?php echo WPTRAFFICTOOLS_URLPATH; ?>ajax.php?mode=popups&section=posts&nature=edit&id='+id, function(data) {
							jQuery(".class_popups_posts_tr_row").html('<td></td><td colspan=5><br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
							jQuery("#id_popups_posts_tr_row_"+id).html(data);
						});

					});
					
					jQuery('.class_popups_posts_delete_profile').click(function() {
					
					    if (confirm('Are you sure you want to delete this popup profile?'))
						{
							var id = this.id.replace('id_popups_posts_delete_','');
							jQuery('#id_popups_posts_form_nature').val('popups_posts_delete_profile');
							jQuery('#id_popups_posts_profile_id').val(id);
							jQuery("#id_popups_posts_form").submit();
						}
					});
					
					
					jQuery('#id_popups_categories_add_profile').live("click",function() {
						jQuery(".class_popups_categories_tr_row").hide();
						/*
						jQuery('.class_profile_save_profile').attr('value','Edit');
						jQuery('.class_profile_save_profile').attr('class','class_cloaking_edit_profile');
						*/
						jQuery('#id_popups_categories_row_last_header').show();
						jQuery('#id_popups_categories_row_last').show();						
						jQuery(".class_popups_categories_tr td:eq(2)").html('<br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br>');
						jQuery.get('<?php echo WPTRAFFICTOOLS_URLPATH; ?>ajax.php?mode=popups&id=x&section=categories', function(data) {
						   jQuery('#id_popups_categories_row_last').html(data);
						   jQuery('#id_popups_categories_add_profile').text('Save');
						   jQuery('#id_popups_categories_add_profile').attr('id','id_popups_categories_save_profile');
						});						
					});
					
					jQuery('.class_popups_categories_save_profile').live("click" ,function() {
						//alert(1);
						jQuery('#id_popups_categories_form_nature').val('popups_categories_save_profile');
						jQuery("#id_popups_categories_form").submit();
					});
					
					jQuery('.class_popups_categories_edit_profile').live("click" ,function() {
						var id = this.id.replace('id_popups_categories_edit_profile_','');
						
						//hide add new profile
						jQuery("#id_popups_categoriesrow_last").html('<td></td><td colspan=5><br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
						jQuery("#id_popups_categoriesrow_last").hide();
						jQuery("#id_popups_categoriesrow_last_header").hide();
						jQuery('#id_popups_categories_save_profile').text('Click Here to Add New Profile');
						jQuery('#id_popups_categories_save_profile').attr('id','id_popups_categories_add_profile');
						
						//change other editing boxes back to normal
						jQuery('.class_popups_categories_save_profile').attr('value','Edit');
						jQuery('.class_popups_categories_save_profile').attr('class','class_popups_categories_edit_profile');
						jQuery(".class_popups_categories_tr_row").html('<td></td><td colspan=5><br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
						jQuery(".class_popups_categories_tr_row").hide();
						
						//change current button 
						jQuery('#id_popups_categories_edit_profile_'+id).attr('value','Save');
						jQuery('#id_popups_categories_edit_profile_'+id).attr('class','class_popups_categories_save_profile');
						
					
						jQuery("#id_popups_categories_tr_row_"+id).show();
						jQuery.get('<?php echo WPTRAFFICTOOLS_URLPATH; ?>ajax.php?mode=popups&section=categories&nature=edit&id='+id, function(data) {
							jQuery(".class_popups_categories_tr_row").html('<td></td><td colspan=5><br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
							jQuery("#id_popups_categories_tr_row_"+id).html(data);
						});

					});
					
					jQuery('.class_popups_categories_delete_profile').click(function() {
					
					    if (confirm('Are you sure you want to delete this popup profile?'))
						{
							var id = this.id.replace('id_popups_categories_delete_','');
							jQuery('#id_popups_categories_form_nature').val('popups_categories_delete_profile');
							jQuery('#id_popups_categories_profile_id').val(id);
							jQuery("#id_popups_categories_form").submit();
						}
					});
					
					
					
					jQuery('.class_popups_content_del').click(function() {
						var cid = this.id.replace('id_popups_content_del_','');
						jQuery('#id_popups_content_h3_'+cid).html('<i>Removed</i>');
						jQuery('#id_popups_content_table_'+cid).remove();
					});
					
				});
				


			</script>
		<?php
	}
	
	function wptt_popups_settings()
	{
		global $table_prefix;
		
		
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
			
			$popups_cookie_timeout = $wptt_options['popups_cookie_timeout'];
		}
		
		$query = "SELECT * FROM {$table_prefix}wptt_popups_profiles";
		$result = mysql_query($query);
		if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
		while ($arr = mysql_fetch_array($result))
		{
			$popups_profile_id[] = $arr['id'];
			$popups_type[] = $arr['type'];
			$popups_nature[] = $arr['nature'];
			$popups_width[] = $arr['width'];
			$popups_height[] = $arr['height'];
			$popups_href[] = explode("\n",$arr['href']);
			$popups_delay[] = $arr['delay'];
			$popups_search_keywords[] = $arr['search_keywords'];
			$popups_search_content[] = $arr['search_content'];
			$popups_search_referrer[] = $arr['search_referrer'];
			$popups_include_ids[] = $arr['include_ids'];
			$popups_exclude_ids[] = $arr['exclude_ids'];
			$popups_drop_count[] = $arr['drop_count'];
			$popups_status[] = $arr['status'];
		}
		
	
		
		?>
		
		

		<br><br>
		<div class='wptt_featurebox'>
		
			<div id='id_container_global_settings' class='class_container'>	
			<h3>Global Settngs</h3>
			
			<br>
			<form name='popups_global_settings' id='id_popups_form_global_settings' method="post" action="admin.php?page=wptt_slug_submenu_popup_profiles">
			<input type='hidden' name='popups_form_nature' value='save_popups_global_settings'>	
			<table id='id_popups_table_global_settings' style='width:100%'>
				<tr>
					<td width='300'>
						<label for=keyword>
						<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="7200 seconds = 2 hours. Whenever a visitor lands on your site it will only be offered a popup one time every x seconds. It does not matter how many popup profiles you have, only one popup per browser session is server. Set to 0 to disable throttling all together."> 
							Popup Cookie Timeout Limit (seconds)
						</label>
					</td>
					<td>
						<input  size=5 name='popups_cookie_timeout' value='<?php echo $popups_cookie_timeout; ?>' > 
					</td>
				</tr>
				<tr>
						<td>
							<input type=submit class='button-secondary' id='id_global_save_settings' name='save_global' value="Save" >
						</td>
				</tr>
			</table>				
			</form>
			</div>
		</div>
		<br><br>
	
		<div class='wptt_featurebox'>
		<div id='id_container_keyword_profiles' class='class_container'>	
			<h3>Keyword Detection Profiles</h3>
			<div>
					<i>Profiles created here will target keywords discovered in the post content. If a match is found then the popup will initiate. We have the option to search either the content (which includes the title of a post and it's post body) or the search referral (which is the URL of the page that referred the traffic). Popups will only fire once per browser session. </i>
			</div>
			<form name=popups_keywords_profile_add id='id_popups_keywords_form' method="post" action="admin.php?page=wptt_slug_submenu_popup_profiles">
			<input type=hidden name=this_action value=save >
			<input type=hidden name=nature id='id_popups_keywords_form_nature' value=popups_keywords_save_profile >
			<input type=hidden name=popups_profile_id id='id_popups_keywords_profile_id'  value=''>
			<?php
			
			if ($popups_profile_id)
			{ 
				echo "<table class='widefat' style='width:100%' id='id_table_popup_keyword_profiles'>\n";		 	  
				echo "<tr><thead><tr><th>#</th>";
				echo "<th>Keywords</th>";
				echo "<th>Content URL(s)</th>";
				echo "<th>Nature</th>";
				echo "<th>Status</th>";
				echo "<th>Dropcount</th>";
				echo "<th>Actions</th>";
				echo "</tr></thead>\n";
			
				$cnt = 1;
				foreach ($popups_profile_id as $key=>$val) 
				{	
					if ($popups_type[$key]=='keywords')
					{
						echo '<tr>';
						echo "<td>$cnt";
						echo "</td>";
						
						echo "<td>$popups_search_keywords[$key]</td>";
						echo "<td width='260'>";
						
						foreach ($popups_href[$key] as $k=>$v)
						{
							echo "<a href='{$v}'>{$v}</a><br>";
						}
						echo "</td>";
						
						echo "<td>$popups_nature[$key]</td>";
						
						echo "<td >";
						if ($popups_status[$key]=='1')
						{
							echo "Active";
						}
						else
						{							
							echo "Inactive";
						}
						echo "</td>";
						echo "<td >$popups_drop_count[$key]</td>";
						
						echo "<td>";
						echo "<input type=button value=Edit  id='id_popups_keywords_edit_profile_$val' class='class_popups_keywords_edit_profile'>";
						echo "<input type=button value=Delete  id='id_popups_keywords_delete_$val' class='class_popups_keywords_delete_profile'>";
						echo "</td>";
						echo "</tr>\n";
						
						echo "<tr id='id_popups_keywords_tr_row_$val' style='display:none;background-color:GhostWhite;' class='class_popups_keywords_tr_row'><td></td><td colspan=4>";
						?>
							<br><br>
							<center><img src='<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif'></center>
							<br><br>
						<?php
						echo '</td></tr>';
						$cnt++;
					}
				
					
				}
				echo '<tr id="id_popups_keywords_row_last_header" style="display:none"><td colspan=6><h4>Add New Profile</h4></td></tr>';
				echo "<tr id='id_popups_keywords_row_last' style='display:none'>
						<td colspan=6>
							<center><img src='".WPTRAFFICTOOLS_URLPATH."images/ajax-loader.gif'></center>
							<br><br>
						</td>
					</tr>
					</table>
					<div align='right'>
					<br>
					<button class='button-secondary' type='button' id='id_popups_keywords_add_profile' style='font-size:10px;'>Click Here to Add New Profile</button>
					<br><br>
					</div>";
			 }
			 else
			 {
				 echo "<p><i>no profiles found</i></p>";
				 $key=0;
				 ?>
				 <table class='widefat' style='width:100%' >
					<tr id="id_popups_keywords_row_last_header" style="display:none">
						<td colspan=6><h4>Add New Profile</h4>
						</td>
					</tr>
					<tr id='id_popups_keywords_row_last' style='display:none'>
						<td colspan=6>
							<center><img src='<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/ajax-loader.gif'></center>
							<br><br>
						</td>
					</tr>
					<tr>
						<td colspan=6 align='center'>
							<button class='button-secondary' type='button' id='id_popups_keywords_add_profile' >Add Profile</button>
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
			<div id='id_container_post_profiles' class='class_container'>	
			<h3>Post Specific Profiles</h3>
			
			<div>
					<i>Profiles created here will target specific posts.  Popups will only fire once per browser session.</i>
			</div>
			<form name=popups_posts_profile_add id='id_popups_posts_form' method="post" action="admin.php?page=wptt_slug_submenu_popup_profiles">
			<input type=hidden name=this_action value=save >
			<input type=hidden name=nature id='id_popups_posts_form_nature' value=popups_posts_save_profile >
			<input type=hidden name=popups_profile_id id='id_popups_posts_profile_id'  value=''>
			<?php
			
			if ($popups_profile_id)
			{ 
				echo "<table class='widefat' style='width:100%' id='id_table_popup_keyword_profiles'>\n";		 	  
				echo "<tr><thead><tr><th>#</th>";
				echo "<th>Include IDs</th>";
				echo "<th>Content URL(s)</th>";
				echo "<th>Nature</th>";
				echo "<th>Status</th>";
				echo "<th>Dropcount</th>";
				echo "<th>Actions</th>";
				echo "</tr></thead>\n";
			
				$cnt = 1;
				foreach ($popups_profile_id as $key=>$val) 
				{	
					if ($popups_type[$key]=='posts')
					{
						echo '<tr>';
						echo "<td>$cnt";
						echo "</td>";
						
						echo "<td style='max-width:25px;'>$popups_include_ids[$key]</td>";
						echo "<td width='260'>";
						
						foreach ($popups_href[$key] as $k=>$v)
						{
							echo "<a href='{$v}'>{$v}</a><br>";
						}
						echo "</td>";
						
						echo "<td>$popups_nature[$key]</td>";
						
						echo "<td >";
						if ($popups_status[$key]=='1')
						{
							echo "Active";
						}
						else
						{							
							echo "Inactive";
						}
						echo "</td>";
						echo "<td >$popups_drop_count[$key]</td>";
						
						echo "<td>";
						echo "<input type=button value=Edit  id='id_popups_posts_edit_profile_$val' class='class_popups_posts_edit_profile'>";
						echo "<input type=button value=Delete  id='id_popups_posts_delete_$val' class='class_popups_posts_delete_profile'>";
						echo "</td>";
						echo "</tr>\n";
						
						echo "<tr id='id_popups_posts_tr_row_$val' style='display:none;background-color:GhostWhite;' class='class_popups_posts_tr_row'><td></td><td colspan=4>";
						?>
							<br><br>
							<center><img src='<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif'></center>
							<br><br>
						<?php
						echo '</td></tr>';
						$cnt++;
					}
				
					
				}
				echo '<tr id="id_popups_posts_row_last_header" style="display:none"><td colspan=6><h4>Add New Profile</h4></td></tr>';
				echo "<tr id='id_popups_posts_row_last' style='display:none'>
						<td colspan=6>
							<center><img src='".WPTRAFFICTOOLS_URLPATH."images/ajax-loader.gif'></center>
							<br><br>
						</td>
					</tr>
					</table>
					<div align='right'>
					<br>
					<button class='button-secondary' type='button' id='id_popups_posts_add_profile' style='font-size:10px;'>Click Here to Add New Profile</button>
					<br><br>
					</div>";
			 }
			 else
			 {
				 echo "<p><i>no profiles found</i></p>";
				 $key=0;
				 ?>
				 <table class='widefat' style='width:100%' >
					<tr id="id_popups_posts_row_last_header" style="display:none">
						<td colspan=6><h4>Add New Profile</h4>
						</td>
					</tr>
					<tr id='id_popups_posts_row_last' style='display:none'>
						<td colspan=6>
							<center><img src='<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/ajax-loader.gif'></center>
							<br><br>
						</td>
					</tr>
					<tr>
						<td colspan=6 align='center'>
							<button class='button-secondary' type='button' id='id_popups_posts_add_profile' >Add Profile</button>
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
			<div id='id_container_category_profiles' class='class_container'>	
				<h3>Category Specific Profiles</h3>
				
				<div>
						<i>Profiles created here will target specific categories.  Popups will only fire once per browser session. </i>
				</div>
				<form name=popups_categories_profile_add id='id_popups_categories_form' method="post" action="admin.php?page=wptt_slug_submenu_popup_profiles">
			<input type=hidden name=this_action value=save >
			<input type=hidden name=nature id='id_popups_categories_form_nature' value=popups_categories_save_profile >
			<input type=hidden name=popups_profile_id id='id_popups_categories_profile_id'  value=''>
			<?php
			
			if ($popups_profile_id)
			{ 
				echo "<table class='widefat' style='width:100%' id='id_table_popup_keyword_profiles'>\n";		 	  
				echo "<tr><thead><tr><th>#</th>";
				echo "<th>Select Category</th>";
				echo "<th>Content URL(s)</th>";
				echo "<th>Nature</th>";
				echo "<th>Status</th>";
				echo "<th>Dropcount</th>";
				echo "<th>Actions</th>";
				echo "</tr></thead>\n";
			
				$cnt = 1;
				foreach ($popups_profile_id as $key=>$val) 
				{	
					if ($popups_type[$key]=='categories')
					{
						echo '<tr>';
						echo "<td>$cnt";
						echo "</td>";
						
						$this_cat = get_cat_name($popups_include_ids[$key]);
						echo "<td>$this_cat</td>";
						echo "<td width='260'>";
						
						foreach ($popups_href[$key] as $k=>$v)
						{
							echo "<a href='{$v}'>{$v}</a><br>";
						}
						echo "</td>";
						
						echo "<td>$popups_nature[$key]</td>";
						
						echo "<td >";
						if ($popups_status[$key]=='1')
						{
							echo "Active";
						}
						else
						{							
							echo "Inactive";
						}
						echo "</td>";
						echo "<td >$popups_drop_count[$key]</td>";
						
						echo "<td>";
						echo "<input type=button value=Edit  id='id_popups_categories_edit_profile_$val' class='class_popups_categories_edit_profile'>";
						echo "<input type=button value=Delete  id='id_popups_categories_delete_$val' class='class_popups_categories_delete_profile'>";
						echo "</td>";
						echo "</tr>\n";
						
						echo "<tr id='id_popups_categories_tr_row_$val' style='display:none;background-color:GhostWhite;' class='class_popups_categories_tr_row'><td></td><td colspan=4>";
						?>
							<br><br>
							<center><img src='<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif'></center>
							<br><br>
						<?php
						echo '</td></tr>';
						$cnt++;
					}
				
					
				}
				echo '<tr id="id_popups_categories_row_last_header" style="display:none"><td colspan=6><h4>Add New Profile</h4></td></tr>';
				echo "<tr id='id_popups_categories_row_last' style='display:none'>
						<td colspan=6>
							<center><img src='".WPTRAFFICTOOLS_URLPATH."images/ajax-loader.gif'></center>
							<br><br>
						</td>
					</tr>
					</table>
					<div align='right'>
					<br>
					<button class='button-secondary' type='button' id='id_popups_categories_add_profile' style='font-size:10px;'>Click Here to Add New Profile</button>
					<br><br>
					</div>";
			 }
			 else
			 {
				 echo "<p><i>no profiles found</i></p>";
				 $key=0;
				 ?>
				 <table class='widefat' style='width:100%' >
					<tr id="id_popups_categories_row_last_header" style="display:none">
						<td colspan=6><h4>Add New Profile</h4>
						</td>
					</tr>
					<tr id='id_popups_categories_row_last' style='display:none'>
						<td colspan=6>
							<center><img src='<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/ajax-loader.gif'></center>
							<br><br>
						</td>
					</tr>
					<tr>
						<td colspan=6 align='center'>
							<button class='button-secondary' type='button' id='id_popups_categories_add_profile' >Add Profile</button>
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
		
		
		
		<br><br><br>
		
	<?php
	}
		
	function wptt_popups_update_settings()
	{
		
		global $table_prefix;
		global $wordpress_url;
		global $wptt_options;
		
		$popups_profile_id = $_POST['popups_profile_id'];
		$popups_type = $_POST['popups_type'];
		$popups_nature = $_POST['popups_nature'];
		$popups_width = $_POST['popups_width'];
		$popups_height = $_POST['popups_height'];
		$popups_href = $_POST['popups_href'];
		$popups_delay = $_POST['popups_delay'];
		$popups_search_keywords = $_POST['popups_search_keywords'];
		$popups_search_content = $_POST['popups_search_content'];
		$popups_search_referrer = $_POST['popups_search_referrer'];
		$popups_include_ids = $_POST['popups_include_ids'];
		$popups_exclude_ids = $_POST['popups_exclude_ids'];
		$popups_status = $_POST['popups_status'];
		$popups_notes = addslashes($_POST['popups_notes']);
		
		//print_r($popups_nature);exit;
		//echo $popups_status;exit;
		if ($_POST['popups_form_nature']=='save_popups_global_settings')
		{
			$wptt_options['popups_cookie_timeout'] = $_POST['popups_cookie_timeout'];
			//echo $wptt_options['popups_cookie_timeout'];exit;
			$wptt_options = json_encode($wptt_options);
			
			$query = "UPDATE {$table_prefix}wptt_wptraffictools_options SET option_value='$wptt_options' WHERE option_name='wptt_options'";
			$result = mysql_query($query);
			if (!$result) { echo $query; echo mysql_error(); }	
		}
		
		if ($_POST['nature']=='popups_keywords_delete_profile')
		{
			$query = "DELETE FROM {$table_prefix}wptt_popups_profiles WHERE id='$popups_profile_id'";
			$result = mysql_query($query);
			if (!$result) { echo $query; echo mysql_error(); }
		}
		
		if ($_POST['nature']=='popups_keywords_save_profile')
		{
			
			if ($popups_profile_id!='x')
			{
				$query = "UPDATE {$table_prefix}wptt_popups_profiles SET type='$popups_type' , nature='$popups_nature' , width='$popups_width', height='$popups_height', href='$popups_href', delay='$popups_delay', search_keywords='$popups_search_keywords', search_content='$popups_search_content', search_referrer='$popups_search_referrer', include_ids='$popups_include_ids', exclude_ids='$popups_exclude_ids', status='$popups_status', notes = '$popups_notes' WHERE id='$popups_profile_id'";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); }
			}
			else
			{
				//echo 2; exit;
				$query = "INSERT INTO {$table_prefix}wptt_popups_profiles (`id`,`type`,`nature`,`width`,`height`,`href`,`delay`,`search_keywords`,`search_content`,`search_referrer`,`include_ids`,`exclude_ids`,`drop_count`,`status`,`notes`)";
				$query .= "VALUES ('','{$popups_type}','{$popups_nature}','{$popups_width}','{$popups_height}','{$popups_href}','{$popups_delay}','{$popups_search_keywords}','{$popups_search_content}','{$popups_search_referrer}','{$popups_include_ids}','{$popups_exclude_ids}','0','{$popups_status}','{$popups_notes}') ";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); }
			}
		}
		
		if ($_POST['nature']=='popups_posts_delete_profile')
		{
			$query = "DELETE FROM {$table_prefix}wptt_popups_profiles WHERE id='$popups_profile_id'";
			$result = mysql_query($query);
			if (!$result) { echo $query; echo mysql_error(); }
		}
		
		if ($_POST['nature']=='popups_posts_save_profile')
		{
			
			if ($popups_profile_id!='x')
			{
				$query = "UPDATE {$table_prefix}wptt_popups_profiles SET type='$popups_type' , nature='$popups_nature' , width='$popups_width', height='$popups_height', href='$popups_href', delay='$popups_delay', search_keywords='$popups_search_keywords', search_content='$popups_search_content', search_referrer='$popups_search_referrer', include_ids='$popups_include_ids', exclude_ids='$popups_exclude_ids', status='$popups_status', notes = '$popups_notes' WHERE id='$popups_profile_id'";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); }
			}
			else
			{
				//echo 2; exit;
				$query = "INSERT INTO {$table_prefix}wptt_popups_profiles (`id`,`type`,`nature`,`width`,`height`,`href`,`delay`,`search_keywords`,`search_content`,`search_referrer`,`include_ids`,`exclude_ids`,`drop_count`,`status`,`notes`)";
				$query .= "VALUES ('','{$popups_type}','{$popups_nature}','{$popups_width}','{$popups_height}','{$popups_href}','{$popups_delay}','{$popups_search_keywords}','{$popups_search_content}','{$popups_search_referrer}','{$popups_include_ids}','{$popups_exclude_ids}','0','{$popups_status}','{$popups_notes}') ";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); }
			}
		}
		
		
		if ($_POST['nature']=='popups_categories_delete_profile')
		{
			$query = "DELETE FROM {$table_prefix}wptt_popups_profiles WHERE id='$popups_profile_id'";
			$result = mysql_query($query);
			if (!$result) { echo $query; echo mysql_error(); }
		}
		
		if ($_POST['nature']=='popups_categories_save_profile')
		{
			
			if ($popups_profile_id!='x')
			{
				$query = "UPDATE {$table_prefix}wptt_popups_profiles SET type='$popups_type' , nature='$popups_nature' , width='$popups_width', height='$popups_height', href='$popups_href', delay='$popups_delay', search_keywords='$popups_search_keywords', search_content='$popups_search_content', search_referrer='$popups_search_referrer', include_ids='$popups_include_ids', exclude_ids='$popups_exclude_ids', status='$popups_status', notes = '$popups_notes' WHERE id='$popups_profile_id'";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); }
			}
			else
			{
				//echo 2; exit;
				$query = "INSERT INTO {$table_prefix}wptt_popups_profiles (`id`,`type`,`nature`,`width`,`height`,`href`,`delay`,`search_keywords`,`search_content`,`search_referrer`,`include_ids`,`exclude_ids`,`drop_count`,`status`,`notes`)";
				$query .= "VALUES ('','{$popups_type}','{$popups_nature}','{$popups_width}','{$popups_height}','{$popups_href}','{$popups_delay}','{$popups_search_keywords}','{$popups_search_content}','{$popups_search_referrer}','{$popups_include_ids}','{$popups_exclude_ids}','0','{$popups_status}','{$popups_notes}') ";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); }
			}
		}

			
	}
	
	function wptt_display_popup_profiles()
	{
		global $global_wptt;
		wptt_popups_update_settings();
		wptt_popups_add_javascript();
		traffic_tools_javascript();
		traffic_tools_update_check();
		traffic_tools_activation_check();
		include('wptt_style.php');
		//if active show rest of page
		if (strlen($global_wptt)>2)
		{
			echo "<img src='".WPTRAFFICTOOLS_URLPATH."images/wptt_logo.png'>";
			
			echo "<div id='id_wptt_display' class='class_wptt_display'>";
		
			echo '<div class="wrap">';

			echo "<h2>Popup Profiles</h2>";
			wptt_popups_settings();
		}
		else
		{
			//CSS CONTENT
			include('wptt_style.php');
			traffic_tools_activate_prompt(); 
		}
		wptt_display_footer();
		echo '</div>';
		echo '</div>';

	}
	
	function wptt_execute_popups()
	{
		global $table_prefix;
		global $current_url;
		global $referral;
		global $wordpress_url;
		global $wptt_options;
		
		$post_id = trim(url_to_postid($current_url));
		$categories= get_the_category($post_id);
		foreach ($categories as $key=>$val)
		{
			$category_id[] =  $categories[$key]->cat_ID;
		}
		
		$referrer = $_SERVER['HTTP_REFERER'];
		$referrer = rawurldecode($referrer);
		

		$popups_cookie_timeout = $wptt_options['popups_cookie_timeout'];
		
		//echo $popups_cookie_timeout;exit;
		
		$query = "SELECT * FROM {$table_prefix}wptt_popups_profiles WHERE status='1'";
		$result = mysql_query($query);
		if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
		
		while ($arr = mysql_fetch_array($result))
		{
			$popups_profile_id[] = $arr['id'];
			$popups_type[] = $arr['type'];
			$popups_nature[] = $arr['nature'];
			$popups_width[] = $arr['width'];
			$popups_height[] = $arr['height'];
			$popups_href[] = $arr['href'];
			$popups_delay[] = $arr['delay'];
			$popups_search_keywords[] = $arr['search_keywords'];
			$popups_search_content[] = $arr['search_content'];
			$popups_search_referrer[] = $arr['search_referrer'];
			$popups_include_ids[] = trim($arr['include_ids']);
			$popups_exclude_ids[] = trim($arr['exclude_ids']);
			$popups_drop_count[] = $arr['drop_count'];
			$popups_status[] = $arr['status'];
		}
		
		//print_r($popups_nature);exit;
		if ($popups_profile_id)
		{
			$i=0;
			
			foreach ($popups_profile_id as $key=>$val)
			{
				//echo $popups_nature[$key];exit;
				$include_ids = $popups_include_ids[$key];

				if ($_COOKIE['wptt_pop_id']&&$_COOKIE['wptt_pop_delay']>0)
				{
					if ($_COOKIE['wptt_pop_nature']!='popover')
					{
						$fire_1 = 1;
					}
					else
					{
						$fire_2 = 1;
					}
				}
				
				if ($fire_1!=1&&$fire_2!=1&&$popups_type[$key]=='posts'&&strstr($popups_include_ids[$key],"$post_id"))
				{
					if ($popups_nature[$key]!='popover')
					{
						$fire_1 = 1;
					}
					else
					{
						$fire_2 = 1;
					}
				}
				
				
				
				if ($fire_1!=1&&$fire_2!=1&&$popups_type[$key]=='posts'&&strstr($popups_include_ids[$key],"h")&&($current_url==$wordpress_url))
				{
						//echo 1; exit;
					if ($popups_nature[$key]!='popover')
					{
						$fire_1 = 1;
					}
					else
					{
						$fire_2 = 1;
					}
				}
				
				
				
				if ($fire_1!=1&&$fire_2!=1&&!$exit&&$popups_type[$key]=='categories'&&$category_id)
				{
					if ($popups_nature[$key]!='popover')
					{
						foreach ($category_id as $k=>$v)
						{
							if (strstr($popups_include_ids[$key],"$v")&&!strstr($popups_exclude_ids[$key],"$post_id"))
							{
								//echo 1;exit;
								$fire_1 = 1;
							}
						}
					}
					else
					{
						foreach ($category_id as $k=>$v)
						{
							if (strstr($popups_include_ids[$key],"$v")&&!strstr($popups_exclude_ids[$key],"$post_id"))
							{
								//echo 1;exit;
								$fire_2 = 1;
							}
						}
					}
				}
				
				if ($fire_1!=1&&$fire_2!=1&&!$exit&&$popups_type[$key]=='keywords'&&!strstr($popups_exclude_ids[$key],$post_id))
				{
					$these_keywords = explode(',',$popups_search_keywords[$key]);
					//echo $i;exit;
					if ($i<1)
					{
						$query = "SELECT post_content,post_title FROM {$table_prefix}posts WHERE ID='{$post_id}'";
						$result = mysql_query($query);
						if (!$result){echo $query; echo mysql_error();}
						$arr = mysql_fetch_array($result);
						$content = $arr['post_content'];
						$title = $arr['post_title'];
					}
					
					foreach ($these_keywords as $k=>$v)
					{
						if ($popups_search_content[$key]==1&&!$go)
						{
							if (stristr($content,$v)||stristr($title,$v))
							{
								$go =1; 
							}
						}
						if ($popups_search_referrer[$key]==1&&!$go)
						{
							if (stristr($referrer,$v))
							{
								$go =1; 
							}
						}
					}
					
					if ($popups_nature[$key]!='popover'&&$go==1)
					{
						$fire_1 = 1;
					}
					if ($popups_nature[$key]=='popover'&&$go==1)
					{
						$fire_2 =  1;
					}	
					$i++;
				}
				
				if ($fire_1==1&&!$exit)
				{
					if ($popups_delay[$key])
					{
						$delay = $popups_delay[$key] * 1000;
					}
					else
					{
						$delay = 0;
					}
				
					if (strstr( $popups_href[$key],'{'))
					{
						$geo_array = unserialize(traffic_tools_remote_connect('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
						
						$popups_href_array =  preg_split("/[\r\n,]+/",  $popups_href[$key], -1, PREG_SPLIT_NO_EMPTY);
						foreach ( $popups_href_array as $k=>$v )
						{
							if (!$check)
							{
								preg_match('/{(.*?)}/i',$v,$match);
								
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
									
										$v = explode("{",$v);
										$v = $v[0];
										 $popups_href[$key] = $v;
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
							$popups_href[$key] = $new_rotate_urls[$rand_key];
							
						}
					}
					else
					{	
						 $popups_href_array =  preg_split("/[\r\n,]+/",  $popups_href[$key], -1, PREG_SPLIT_NO_EMPTY);
					     $rand_key = array_rand( $popups_href_array);
						 $popups_href[$key] =  $popups_href_array[$rand_key];					
					}


					?>
					<script type='text/javascript'>      var pshow = false;      var PopFocus = 1;      var _Top = null;      var wptt = 0;        function GetWindowHeight() {       var myHeight = 0;       if( typeof( _Top.window.innerHeight ) == 'number' ) {       myHeight = _Top.window.innerHeight;       } else if( _Top.document.documentElement && _Top.document.documentElement.clientHeight ) {       myHeight = _Top.document.documentElement.clientHeight;       } else if( _Top.document.body && _Top.document.body.clientHeight ) {       myHeight = _Top.document.body.clientHeight;       }       return myHeight;      }       function GetWindowWidth() {       var myWidth = 0;       if( typeof( _Top.window.innerWidth ) == 'number' ) {       myWidth = _Top.window.innerWidth;       } else if( _Top.document.documentElement && _Top.document.documentElement.clientWidth ) {       myWidth = _Top.document.documentElement.clientWidth;       } else if( _Top.document.body && _Top.document.body.clientWidth ) {       myWidth = _Top.document.body.clientWidth;       }       return myWidth;      }       function GetWindowTop() {       return (_Top.window.screenTop != undefined) ? _Top.window.screenTop : _Top.window.screenY;      }       function GetWindowLeft() {       return (_Top.window.screenLeft != undefined) ? _Top.window.screenLeft : _Top.window.screenX;      }       function openp(url,type)      {              setCookie('wptt_pop_delay', 0, <?php echo $popups_cookie_timeout; ?>);        setCookie('wptt_pop', 1, <?php echo $popups_cookie_timeout; ?>);              var popURL = "about:blank";       var popID = "ad_" + Math.floor(89999999*Math.random()+10000000);       var pxLeft = 0;       var pxTop = 0;       pxLeft = (GetWindowLeft() + (GetWindowWidth() / 2) - (<?php echo $popups_width[$key]; ?> / 2));       pxTop = (GetWindowTop() + (GetWindowHeight() / 2) - (<?php echo $popups_height[$key]; ?> / 2));        if ( pshow == true )       {             return true;       }               var PopWin=_Top.window.open(popURL,popID,'toolbar=0,scrollbars=1,location=1,statusbar=1,menubar=0,resizable=1,top=' + pxTop + ',left=' + pxLeft + ',width= <?php echo $popups_width[$key]; ?> ,height= <?php echo $popups_height[$key]; ?>');        if (PopWin)       {        pshow = true;                if (PopFocus == 0)        {         PopWin.blur();          if (navigator.userAgent.toLowerCase().indexOf("applewebkit") > -1)         {          _Top.window.blur();          _Top.window.focus();         }        }         PopWin.Init = function(e) {          with (e)          {           Params = e.Params;          Main = function(){                      <?php if (strstr($popups_nature[$key],'popup'))           	{           ?>           var popURL = Params.PopURL;            PopWin.Params = {PopURL: url };            if (typeof window.mozPaintCount != "undefined") {             var x = window.open(popURL); } window.location = popURL;           <?php           } else       {           ?> 					var popURL = Params.PopURL;if (typeof window.mozPaintCount != "undefined") { var x = window.open("about:blank");x.close(); }if (navigator.appName != 'Microsoft Internet Explorer'){var x = window.open("about:blank");x.close();} else {} try { opener.window.focus(); } catch (err) { } window.location = popURL;<?php           }           ?>                      };           Main();         }        };         PopWin.Params = {PopURL: url};         PopWin.Init(PopWin);       }        return PopWin;      }       function setCookie(name, value, time)      {       time = time * 1000;       var expires = new Date();       expires.setTime( expires.getTime() + time );       document.cookie = (name + '=' + value + ';path=/; expires=' + expires.toGMTString() +';');      }       function getCookie(name)       {       var cookies = document.cookie.toString().split('; ');       var cookie, c_name, c_value;        for (var n=0; n<cookies.length; n++)        {        cookie  = cookies[n].split('=');        c_name  = cookie[0];        c_value = cookie[1];         if ( c_name == name ) {         return c_value;        }       }        return null;      }       function wpttgopop()      {       var delay = <?php echo $delay; ?>;       _Top = self;        if (top != self)       {        try        {        if (top.document.location.toString())        _Top = top;        }        catch(err) { }       }              <?php        if ($popups_nature[$key]=='popunder_unblockable'||$popups_nature[$key]=='popup_unblockable')       {          ?>           if (delay>1)           {         if (getCookie('wptt_pop_delay') > 1)         {          delay = delay / 2;             setCookie('wptt_pop_delay', delay, <?php echo $popups_cookie_timeout; ?>);           setTimeout("addListeners()",delay);         }         else         {            setCookie('wptt_pop_delay', delay, <?php echo $popups_cookie_timeout; ?>);           setTimeout("addListeners()",delay);         }        }        else        {                  if ( document.attachEvent )         {                    document.attachEvent( 'onclick', checkTarget );         }         else if ( document.addEventListener )         {                 document.addEventListener( 'click', checkTarget, false );         }                         }        <?php       }       else       {       ?>        if ( !getCookie('wptt_pop') || wptt==1 || getCookie('wptt_p_wait') > 1)         {                 if (getCookie('wptt_pop_delay') > 1)         {          delay = delay / 2;          var e = e || window.event;          setCookie('wptt_pop_id', <?php echo $val; ?>, <?php echo $popups_cookie_timeout; ?>);           setCookie('wptt_pop_nature', '<?php echo $popups_nature[$key]; ?>', <?php echo $popups_cookie_timeout; ?>);           setCookie('wptt_pop_delay', delay, <?php echo $popups_cookie_timeout; ?>);           if (delay>0)          {           setTimeout("openp('<?php echo $popups_href[$key]; ?>',2)",delay);          }          else          {           openp('<?php echo $popups_href[$key]; ?>',1)          }         }         else         {          var e = e || window.event;          setCookie('wptt_pop_id', <?php echo $val; ?>, <?php echo $popups_cookie_timeout; ?>);           setCookie('wptt_pop_nature', '<?php echo $popups_nature[$key]; ?>', <?php echo $popups_cookie_timeout; ?>);           setCookie('wptt_pop_delay', delay, <?php echo $popups_cookie_timeout; ?>);           if (delay>0)          {           setTimeout("openp('<?php echo $popups_href[$key]; ?>',2)",delay);          }          else          {           openp('<?php echo $popups_href[$key]; ?>',1)          }         }                }       <?php       }       ?>      }      function addListeners()      {              if ( document.attachEvent )       {               document.attachEvent( 'onclick', checkTargetFire );       }       else if ( document.addEventListener )       {              document.addEventListener( 'click', checkTargetFire, false );       }          }      function checkTarget(e)      {    if ( !getCookie('wptt_pop') || wptt ==1 || getCookie('wptt_pop_delay') > 1) {        var delay = <?php echo $delay; ?>;        if (getCookie('wptt_pop_delay') > 1)        {         delay = delay / 2;         var e = e || window.event;         setCookie('wptt_pop_id', <?php echo $val; ?>, <?php echo $popups_cookie_timeout; ?>);          setCookie('wptt_pop_nature', '<?php echo $popups_nature[$key]; ?>', <?php echo $popups_cookie_timeout; ?>);          setCookie('wptt_pop_delay', delay, <?php echo $popups_cookie_timeout; ?>);          if (delay>0)         {          setTimeout("openp('<?php echo $popups_href[$key]; ?>',2)",delay);         }         else         {          openp('<?php echo $popups_href[$key]; ?>',1)         }        }        else        {               var e = e || window.event;         setCookie('wptt_pop_id', <?php echo $val; ?>, <?php echo $popups_cookie_timeout; ?>);          setCookie('wptt_pop_nature', '<?php echo $popups_nature[$key]; ?>', <?php echo $popups_cookie_timeout; ?>);          setCookie('wptt_pop_delay', delay, <?php echo $popups_cookie_timeout; ?>);          if (delay>0)         {          setTimeout("openp('<?php echo $popups_href[$key]; ?>',2)",delay);         }         else         {          openp('<?php echo $popups_href[$key]; ?>',1)         }        }       }      }            function checkTargetFire(e)      {       var delay = getCookie('wptt_pop_delay');       if ( !getCookie('wptt_pop') || getCookie('wptt_pop_delay') > 1)       {            var e = e || window.event;        setCookie('wptt_pop_id', <?php echo $val; ?>, <?php echo $popups_cookie_timeout; ?>);         setCookie('wptt_pop_nature', '<?php echo $popups_nature[$key]; ?>', <?php echo $popups_cookie_timeout; ?>);         setCookie('wptt_pop_delay', delay, <?php echo $popups_cookie_timeout; ?>);                 openp('<?php echo $popups_href[$key]; ?>',1);        }                    }       	wpttgopop();      </script>
					<?php
					$exit=1;
					$query = "UPDATE {$table_prefix}wptt_popups_profiles SET drop_count = drop_count+1  WHERE id='{$popups_profile_id[$key]}'";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo mysql_error(); }
				}
				
				if ($fire_2==1&&!$exit)
				{
					if (strstr( $popups_href[$key],'{'))
					{
						$geo_array = unserialize(traffic_tools_remote_connect('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
						
						$popups_href_array =  preg_split("/[\r\n,]+/",  $popups_href[$key], -1, PREG_SPLIT_NO_EMPTY);
						foreach ( $popups_href_array as $k=>$v)
						{
							if (!$check)
							{
								preg_match('/{(.*?)}/i',$v,$match);
								
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
									
										$v = explode("{",$v);
										$v = $v[0];
										 $popups_href[$key] = $v;
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
							 $popups_href[$key] = $new_rotate_urls[$rand_key];
							
						}
					}
					else
					{	
						 $popups_href_array =  preg_split("/[\r\n,]+/",  $popups_href[$key], -1, PREG_SPLIT_NO_EMPTY);
					     $rand_key = array_rand( $popups_href_array);
						 $popups_href[$key] =  $popups_href_array[$rand_key];					
					}
					
					define("POPUP_SRC", $popups_href[$key] );
					define("POPUP_WIDTH", $popups_width[$key] );
					define("POPUP_HEIGHT", $popups_height[$key]);
						
					if ($popups_delay[$key])
					{
						$delay = $popups_delay[$key] * 1000;
					}
					else
					{
						$delay = 0;
					}
					//echo 2;exit;
					?>
					
					<?php
					include_once(WPTRAFFICTOOLS_PATH.'fancyzoom/fancyzoom.php');
					?>
					<style type='text/css'>
					.close-window
					{
						position:relative;
						width:32px;
						height:32px;
						right:-32px;
						top:-32px;
						background:transparent url('<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/close_button.gif') no-repeat scroll right top;
						text-indent:-99999px;
						//overflow:hidden;
						cursor:pointer;
						//opacity:.5;
						//filter: alpha(opacity=50);
						//-moz-opacity: 0.5;
					}
					</style>
							
					<script type='text/javascript'>
					function setCookie(name, value, time)
					{
						time = time * 1000;
						var expires = new Date();
						expires.setTime( expires.getTime() + time );
						document.cookie = (name + '=' + value + ';path=/; expires=' + expires.toGMTString() +';');
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
					function wptt_open_modal()
					{
						//alert(1);
						modalWindow.windowId = "myModal";
						modalWindow.width = <?php echo $popups_width[$key]; ?>;
						modalWindow.height = <?php echo $popups_height[$key]; ?>;
						modalWindow.content = "<iframe width='"+modalWindow.width+"' height='"+modalWindow.height+"' scrolling='no' allowtransparency='true' src='<?php echo $popups_src[$key]; ?>'></iframe>";
						modalWindow.open();
					}
					function fancyzoom_open_modal()
					{
						
						jQuery('#open_frame').fancyZoom();
						jQuery('#open_frame').trigger('click');
						setCookie('wptt_pop_delay', 0, <?php echo $popups_cookie_timeout; ?>); 
						setCookie('wptt_pop', 1, <?php echo $popups_cookie_timeout; ?>);

					}
					jQuery(document).ready(function() 
					{
						var wptt = 0;
						
						if ( !getCookie('wptt_pop') || wptt==1 || getCookie('wptt_p_wait') > 1 ) 
						{
							var delay = <?php echo $delay; ?>;
							if (getCookie('wptt_pop_delay') > 1)
							{
								delay = delay / 2;
								var e = e || window.event;
								setCookie('wptt_pop_delay', delay, <?php echo $popups_cookie_timeout; ?>); 
								setTimeout("fancyzoom_open_modal()",delay);
								//setCookie('wptt_pop', 1, <?php echo $popups_cookie_timeout; ?>); 
								<?php
									$query = "UPDATE {$table_prefix}wptt_popups_profiles SET drop_count = drop_count+1  WHERE id='{$popups_profile_id[$key]}'";
									$result = mysql_query($query);
									if (!$result) { echo $query; echo mysql_error(); }
								?>
							}
							else
							{
								var e = e || window.event;
								
								setCookie('wptt_pop_id', <?php echo $val; ?>, <?php echo $popups_cookie_timeout; ?>); 
								setCookie('wptt_pop_nature', '<?php echo $popups_nature[$key]; ?>', <?php echo $popups_cookie_timeout; ?>); 
								setCookie('wptt_pop_delay', delay, <?php echo $popups_cookie_timeout; ?>); 
								setTimeout("fancyzoom_open_modal()",delay);								 
								<?php
									$query = "UPDATE {$table_prefix}wptt_popups_profiles SET drop_count = drop_count+1  WHERE id='{$popups_profile_id[$key]}'";
									$result = mysql_query($query);
									if (!$result) { echo $query; echo mysql_error(); }
								?>
							}
						}
					});

					</script>
					
					<?php
					$exit=1;
				}
			}
		}
	}
	
	function wptt_popup_append_div($content)
	{
		echo '<a href="#frame" id="open_frame" style="display:none">.</a>';
		if (defined("POPUP_SRC"))
		{
			echo "<div id='frame' style='display:none;'><iframe width=". POPUP_WIDTH ." height=".POPUP_HEIGHT." scrolling='auto' allowtransparency='true' src=".POPUP_SRC."></iframe></div>";
		}
	}
	
	if (!is_admin())
	{
		add_action('wp_head','wptt_execute_popups');
		add_filter('get_footer','wptt_popup_append_div');
	}
?>