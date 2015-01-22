<?php
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


	function wptt_autolinking_filter($content)
	{

		global $table_prefix;	
		
		//prepare auto-link keyword profiles
		$query = "SELECT id,redriect_url,keywords,keywords_affect,attributes,keywords_limit, keywords_limit_total,keywords_target_page FROM {$table_prefix}wptt_autolinking_profiles WHERE keywords_affect>0";
		$result = mysql_query($query);
		if (!$result){echo $query; echo mysql_error(); exit;}
		$count = mysql_num_rows($result);

		if ($count>0)
		{
			//echo 2;exit;
			$image_count = substr_count($content, "<img");
			for ($i=0;$i<$image_count;$i++)
			{
				$stuff = traffic_get_string_between($content, "<img", ">");	
				$content = str_replace("<img{$stuff}>","Image[{$i}]",$content);
				$img_stuff[] = "$stuff";
			}
			
			//print_r($img_stuff);
			$link_count = substr_count($content, "<a ");
			
			for ($i=0;$i<$link_count;$i++)
			{
				$stuff = traffic_get_string_between($content, "<a ", "</a>");
				$content = str_replace("<a {$stuff}</a>","Link[{$i}]",$content);
				$a_stuff[] = "$stuff";
			}
			
			while ($arr = mysql_fetch_array($result))
			{
				
				$target = $arr['keywords_target_page'];
				$keywords = explode(',',$arr['keywords']);
				$affect = $arr['keywords_affect'];
				$attributes = stripslashes($arr['attributes']);
				$limit = $arr['keywords_limit'];
				$limit_total = $arr['keywords_limit_total'];
				$redirect_url = $arr['redirect_url'];				
				$redirect_url =  preg_split("/[\r\n,]+/", $redirect_url, -1, PREG_SPLIT_NO_EMPTY);
				$keys = array_keys($redirect_url);
				$redirect_url = $redirect_url[$key];
				
				$c = 0;
				$keys = array_keys($keywords);
				$size = sizeOf($keys);
				for ($key=0; $key<$size; $key++)
				{
				
					$i=0;
					$keywords[$key] = trim($keywords[$key]);
					
					if ($c<$limit_total&&$keywords[$key])
					{
											
						if ($affect==1)
						{
							if (stristr($content,$keywords[$key])&&$i<$limit_total)
							{
								//echo 1; exit;
								$content = preg_replace("/(?<!_)(?<!-)(?<!\/)(?<!\.)\b$keywords[$key]\b(?!(.*?)\<\/h\d>)/i"," <a href='{$redirect_url}' target='$target' $attributes >$keywords[$key]</a>", $content , $limit);
								$i++;
								$c++;
							}
						}
						if ($affect==2)
						{
	//echo 1;exit;		
							if (stristr($content,$keywords[$key])&&$i<=$limit_total)
							{
								//echo $keywords[$key];
								//echo "<hr>";
								$content = preg_replace("/(?<!_)(?<!-)(?<!\/)(?<!\>)(?<!')(?<!\.)\b$keywords[$key]\b(?!(.*?)\<\/h\d>)/i","<a href='{$redirect_url}' rel='nofollow' target='$target'  $attributes >$keywords[$key]</a>", $content , $limit);
								$i++;
								$c++;
							}
							else
							{
								//echo "no!: echo $keywords[$key];";
								//echo "<hr>";
							}
						}
						if ($affect==3)
						{
							if (strstr($content,$keywords[$key])&&$i<=$limit_total)
							{
								$content = preg_replace("/(?<!_)(?<!-)(?<!\/)(?<!\>)(?<!')(?<!\.)\b$keywords[$key]\b(?!(.*?)\<\/h\d>)/","<a href='{$redirect_url}' target='$target'  $attributes >$keywords[$key]</a>", $content , $limit);
								$i++;
								$c++;
							}
						}
						if ($affect==4)
						{
							if (strstr($content,$keywords[$key])&&$i<=$limit_total)
							{
								$content = preg_replace("/(?<!_)(?<!-)(?<!\/)(?<!\>)(?<!')(?<!\.)\b$keywords[$key]\b(?!(.*?)\<\/h\d>)/s","<a href='{$redirect_url}' rel='nofollow' target='$target'  $attributes >$keywords[$key]</a>", $content , $limit);
								$i++;
								$c++;
							}
						}
						if ($affect==5)
						{
							if (stristr($content,$keywords[$key])&&$i<=$limit_total)
							{
								$content = preg_replace("/(?<!_)(?<!-)(?<!\/)(?<!\>)(?<!')(?<!\.)(?<!\".)\b$keywords[$key]\b(?!(.*?)\<\/h\d>)/i","<strong>$keywords[$key]</strong>", $content , $limit);
								$i++;
								$c++;
							}
						}
						if ($affect==6)
						{
							if (stristr($content,$keywords[$key])&&$i<=$limit_total)
							{
								$content = preg_replace("/(?<!_)(?<!-)(?<!\/)(?<!\>)(?<!')(?<!\.)\b$keywords[$key]\b(?!(.*?)\<\/h\d>)/i"," <i>$keywords[$key]</i>", $content , $limit);
								$i++;
								$c++;
							}
						}
					}
				}
			}
			
			//re-insert imgs	
			if ($a_stuff)
			{
				foreach ($a_stuff as $key => $value)
				{		
					$content = str_replace("Link[".$key."]", "<a $value </a>", $content);	
				}
			}
			
			if ($img_stuff)
			{
				foreach ($img_stuff as $key => $value)
				{	
					$content = str_replace("Image[$key]", "<img $value >", $content);	
				}
			}
		} 
		
		return $content;
	}
	add_filter('the_content', 'wptt_autolinking_filter', 20 );

	//ADD MENU ITEM AND OPTIONS PAGE
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************	
	
	//echo $addb;exit;
	function autolinking_add_javascript()
	{
		global $rp;
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
				function js_autolinking_delete(profile_id)
				{
				   if (confirm('Are you sure you want to delete this profile?'))
					 {
					   document.autolinking_profile_add.action.value = 'delete';
					   document.autolinking_profile_add.profile_id.value = profile_id; 
					   document.autolinking_profile_add.submit();
					 }
				} 
			
				
				jQuery(document).ready(function() 
				{
					jQuery('.class_profile_save_profile').attr('class','class_autolinking_edit_profile');
					jQuery('#id_autolinking_save_profile').attr('id','id_autolinking_add_profile');
					
					jQuery('.class_profile_save_profile').live("click" ,function() {
						//alert(1);
						jQuery('#id_autolinking_form_nature').val('autolinking_save_profile');
						jQuery("#id_autolinking_autolinking_form").submit();
					});
					
					jQuery('#id_autolinking_save_profile').live("click" ,function() {
						//alert(1);
						jQuery('#id_autolinking_form_nature').val('autolinking_save_profile');
						jQuery("#id_autolinking_autolinking_form").submit();
					});
					
					
					jQuery('#id_autolinking_add_profile').live("click",function() {
						jQuery(".class_tr_row").hide();
						jQuery('.class_profile_save_profile').attr('value','Edit');
						jQuery('.class_profile_save_profile').attr('class','class_autolinking_edit_profile');
						jQuery('#id_row_last_header').show();
						jQuery('#id_row_last').show();						
						jQuery(".class_tr td:eq(2)").html('<br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br>');
						jQuery.get('<?php echo WPTRAFFICTOOLS_URLPATH; ?>ajax.php?mode=links&id=x&nature=new', function(data) {
						   jQuery('#id_row_last').html(data);
						   jQuery('#id_autolinking_add_profile').text('Save');
						   jQuery('#id_autolinking_add_profile').attr('id','id_autolinking_save_profile');
						});						
					});
					
					
					
					jQuery('.class_autolinking_edit_profile').live("click" ,function() {
						var id = this.id.replace('id_autolinking_edit_profile_','');
						
						//hide add new profile
						jQuery("#id_row_last").html('<td></td><td colspan=5><br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
						jQuery("#id_row_last").hide();
						jQuery("#id_row_last_header").hide();
						jQuery('#id_autolinking_save_profile').text('Click Here to Add New Profile');
						jQuery('#id_autolinking_save_profile').attr('id','id_autolinking_add_profile');
						
						//change other editing boxes back to normal
						jQuery('.class_profile_save_profile').attr('value','Edit');
						jQuery('.class_profile_save_profile').attr('class','class_autolinking_edit_profile');
						jQuery(".class_tr_row").html('<td></td><td colspan=5><br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
						jQuery(".class_tr_row").hide();
						
						//change current button 
						jQuery('#id_autolinking_edit_profile_'+id).attr('value','Save');
						jQuery('#id_autolinking_edit_profile_'+id).attr('class','class_profile_save_profile');
						
					
						jQuery("#id_tr_row_"+id).show();
						jQuery.get('<?php echo WPTRAFFICTOOLS_URLPATH; ?>ajax.php?mode=links&nature=edit&id='+id, function(data) {
							jQuery(".class_tr_row").html('<td></td><td colspan=5><br><br><center><img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/ajax-loader.gif"></center><br><br></td>');
							jQuery("#id_tr_row_"+id).html(data);
						});

					});
					
					
					jQuery('.class_autolinking_delete_profile').click(function() {
					
					    if (confirm('Are you sure you want to delete this link profile?'))
						{
							var id = this.id.replace('id_autolinking_delete_profile_','');
							jQuery('#id_autolinking_form_nature').val('autolinking_delete_profile');
							jQuery('#id_autolinking_profile_id').val(id);
							jQuery("#id_autolinking_autolinking_form").submit();
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
					
					
				});
				
				

			</script>
		<?php
	}

	function wptt_autolinking_settings()
	{
		global $table_prefix;
		global $rp;
		global $rp;
		if ($rp[0]==0){
			$add = " disabled='disabled' ";	$addb = " ";
		}
		else if ($rp[0]==2)	{ 
			$add = " ";	$addb = " disabled='disabled' ";
		}
		else {$add = ""; $addb = "";}
		
		/* Retrieve the profile data */ 
		$query = "SELECT * FROM {$table_prefix}wptt_autolinking_profiles WHERE type='affiliate'";
		$result = mysql_query($query);
		while ($arr = mysql_fetch_array($result))
		{
			$autolinking_profile_id[] = $arr['id'];
			$redirect_url = explode("\n",$arr['redirect_url']);
			$autolinking_redirect_url[] = $redirect_url;
			$autolinking_spider_count[] = $arr['spider_count'];
			$autolinking_visitor_count[] = $arr['visitor_count'];
		}
		
	

		?>
		
		
		<br><br>
		<div class='wptt_featurebox'>
			<div style='float:right'>
			<a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>geotarget-test.php' title='Discover GeoTargeting Details About Your Connection.' target='_blank'><img src='<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/ico_geotarget.png' border=0></a>&nbsp;&nbsp;
			</div>
			<form name=autolinking_profile_add id='id_autolinking_autolinking_form' method="post" action="admin.php?page=wptt_slug_submenu_link_profiles">
			<input type=hidden name=this_action value=save >
			<input type=hidden name=nature id='id_autolinking_form_nature' value=autolinking_save_profile >
			<input type=hidden name=profile_id id='id_autolinking_profile_id' value='' >
			
			
			<?php
			
			 echo "<h3>Link Profiles</h3>";
			 
			
			 if ($autolinking_profile_id)
			 { 
				echo "<table class='widefat' style='width:100%' id='id_table_link_profiles'>\n";		 	  
				echo "<tr>Destination URL</th>";
				echo "<th>Human Visits</th>";
				echo "<th>Spider Visits</th>";
				echo "<th>Actions</th>";
				echo "</tr></thead>\n";
			
				$cnt = 1;
				foreach ($autolinking_profile_id as $key=>$val) 
				{				 
					echo '<tr>';
					echo "<td>$cnt";
					echo "</td>";
					
					echo "<td id='id_autolinking_profile_cloaked_url_$key'><a href='$autolinking_cloaked_url[$key]'>{$autolinking_cloaked_url[$key]}</a></td>";
					echo "<td width='260'>";
					foreach ($autolinking_redirect_url[$key] as $k=>$v)
					{
						echo "<a href='{$v}'>{$v}</a><br>";
					}
					echo "</td>";
					echo "<td ><a href='".WPTRAFFICTOOLS_URLPATH."wp-show-logs.php?permalink={$autolinking_permalink[$key]}' target='_blank'> $autolinking_visitor_count[$key]</a></td>";
					echo "<td >$autolinking_spider_count[$key]</td>";
					 
					
					echo "<td><input type=button value=Edit  id='id_autolinking_edit_profile_$val' class='class_autolinking_edit_profile'>";
					echo "<input type=button value=Delete  id='id_autolinking_delete_profile_$val' class='class_autolinking_delete_profile'>";
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
					<button class='button-secondary' type='button' id='id_autolinking_add_profile' style='font-size:10px;'>Click Here to Add New Profile</button>
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
							<button class='button-secondary' type='button' id='id_autolinking_add_profile' >Add Profile</button>
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
		
		
		<?php
		
	}

	
	function autolinking_update_settings()
	{		
		global $table_prefix;
		$wordpress_url = get_bloginfo('url');
		
		if (substr($wordpress_url, -1, -1)!='/')
		{
			$wordpress_url = $wordpress_url."/";
		}
		
		if ($_POST['nature']=='autolinking_delete_profile')
		{
			$profile_id = $_POST['profile_id'] ;
			$query = "DELETE FROM {$table_prefix}wptt_autolinking_profiles  WHERE id='$profile_id'";
			$result = mysql_query($query);
			if (!$result) { echo $query; echo mysql_error(); }
		}
		if ($_POST['nature']=='autolinking_save_profile')
		{
			$profile_id = $_POST['profile_id'];
			$redirect_url = trim($_POST['redirect_url']);
			$redirect_type = $_POST['redirect_type'];
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
				}
				if ($profile_id!='x')
				{
					$query = "UPDATE {$table_prefix}wptt_autolinking_profiles SET link_masking='$link_masking' ,permalink='$permalink', redirect_url='$redirect_url', redirect_type='$redirect_type',  keywords = '$keywords', keywords_affect = '$keywords_affect', attributes = '$attributes', keywords_limit = '$keywords_limit', keywords_limit_total = '$keywords_limit_total', keywords_target_page = '$keywords_target_page' , notes = '$notes' WHERE id='$profile_id'";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo mysql_error(); }
				}
				else
				{
					$query = "INSERT INTO {$table_prefix}wptt_autolinking_profiles (`id`,`redirect_url`,`redirect_type`,`visitor_count`,`spider_count`,`type`,`keywords`,`keywords_affect`,`attributes`,`keywords_limit`,`keywords_limit_total`,`keywords_target_page`,`notes`) VALUES ('','$link_masking','$redirect_url','$redirect_type','0','0','affiliate','$keywords','$keywords_affect','$attributes','$keywords_limit','$keywords_limit_total','$keywords_target_page','$notes')";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo mysql_error(); }
				}
			}
			
			
			
		}
		else if ($_POST['nature']=='autolinking_save_cloaking')
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
					$rules[] = "RewriteRule ^(.*){$v}/(.*)$ ".ABSPATH."wp-content/plugins/wp-traffic-tools/relay.php?permalink=$2 [L,QSA]";
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
		else if ($_POST['nature']=='autolinking_global_save_settings')
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
		autolinking_update_settings();
		autolinking_add_javascript();
	
		//CSS CONTENT
		include('wptt_style.php');
		echo "<img src='".WPTRAFFICTOOLS_URLPATH."images/wptt_logo.png'>";
		
		echo "<div id='id_wptt_display' class='class_wptt_display'>";
	
		echo '<div class="wrap">';

		echo "<h2>Link Profiles</h2>";
			
		/* Show the existing options */
		wptt_autolinking_settings();
			
			
		wptt_display_footer();
		echo "</div>";
		echo '</div>';
		echo "<div style='background-color:#fff;'></div>";
		
	}

 
	
	
?>