<?php
/* Finding the path to the wp-admin folder */
$iswin = preg_match('/:\\\/', dirname(__file__));
$slash = ($iswin) ? "\\" : "/";

$wp_path = preg_split('/(?=((\\\|\/)wp-content)).*/', dirname(__file__));
$wp_path = (isset($wp_path[0]) && $wp_path[0] != "") ? $wp_path[0] : $_SERVER["DOCUMENT_ROOT"];

/** Load WordPress Administration Bootstrap */
require_once($wp_path . $slash . 'wp-load.php');
require_once($wp_path . $slash . 'wp-admin' . $slash . 'admin.php');

// check for rights
if ( !is_user_logged_in() || !current_user_can('edit_posts') ) 
	wp_die(__( "You are not allowed to be here", 'post-snippets' ));
	
//pull profiles
$query = "SELECT * FROM {$table_prefix}wptt_cloakme_profiles";
$result = mysql_query($query);
while ($arr = mysql_fetch_array($result))
{
	$profile_id[] = $arr['id'];
	$profile_permalink[] = $arr['permalink'];
}

/* Retrieve the global settings */ 
$query = "SELECT `option_value` FROM wpt_classification_prefixes  WHERE option_name='classification_prefix'";
$result = mysql_query($query);
if (!$result){echo $query; echo mysql_error(); exit;}
$arr = mysql_fetch_array($result);
$cloaking_classification_prefix =$arr[option_value];
$cloaking_classification_prefix = explode(';',$cloaking_classification_prefix);
//echo $classification_prefix;exit;		


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>WP Traffic Tools: Link Masking & Cloaking </title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	
	<script language="javascript" type="text/javascript">
	
	$(document).ready(function() 
	{
		$('#ps_tab2').click(function() {
			mcTabs.displayTab('ps_tab2','ps_panel2');
			$('#ps_tab1').removeClass('current');
			$('#hidden').val('insert_old');
		});
		
		$('#ps_tab1').click(function() {
			mcTabs.displayTab('ps_tab1','ps_panel1');
			$('#ps_tab2').removeClass('current');
			$('#hidden').val('insert_new');
		});
		
		
	});
    

	function goNothing()
	{
	}
	
	function insertOld(method,var1,var2,var3,var4)
	{
		var xmlhttp =  new XMLHttpRequest();
		xmlhttp.open('GET', 'ajax.php?method=none&var1='+var1, false);
	
		xmlhttp.send();
		result =  xmlhttp.responseText;
		return xmlhttp.responseText;
	}	
	
	function insertNew(method,var1,var2,var3,var4,var5,var6,var7,var8)
	{
		var xmlhttp =  new XMLHttpRequest();
		xmlhttp.open('GET', 'ajax.php?method=create_new&var1='+var1+'&var2='+var2+'&var3='+var3+'&var4='+var4+'&var5='+var5+'&var6='+var6+'&var7='+var7+'&var8='+var8, false);
	
		xmlhttp.send();
		result =  xmlhttp.responseText;
		return xmlhttp.responseText;
	}	


	
	function init() {
		tinyMCEPopup.resizeToInnerSize();
	}
	
	
	function addslashes(str) {
		str=str.replace(/\\/g,'\\\\');
		str=str.replace(/\'/g,'\\\'');
		str=str.replace(/\"/g,'\\"');
		str=str.replace(/\0/g,'\\0');
		return str;
	}
	function stripslashes(str) {
		str=str.replace(/\\'/g,'\'');
		str=str.replace(/\\"/g,'"');
		str=str.replace(/\\0/g,'\0');
		str=str.replace(/\\\\/g,'\\');
		return str;
	}
	function insertCloakMeShortcode() {

		var insertString;
		var  nature = document.getElementById('hidden').value;
        var anchor = tinyMCE.activeEditor.selection.getContent();
		//anchor = addslashes(anchor);
        
		if (nature=='insert_old')
		{
			var profile_id = document.getElementById('profile_id').value;
			var target = document.getElementById('target_2').value;
			var result = insertOld('', profile_id, target, anchor);
			insertString = '<a href="' + result + '" target="' + target + '">'+anchor+'</a>';
		}
		else
		{
			
			var classification_prefix = document.getElementById('id_classification').value;
			var permalink = document.getElementById('id_permalink').value;
			var redirect_url = document.getElementById('id_redirect_url').value;
			redirect_url =  encodeURIComponent(redirect_url);
			
			if (document.getElementById('id_radio_cloak_target_off').checked)
			{
				var cloak_target = '0';
			}
			else
			{
				var cloak_target = '1';
			}
			
			if (document.getElementById('id_radio_blank_referrer_off').checked)
			{
				var blank_reffer = '0';
			}
			else
			{
				var blank_referrer = '1';
			}
			
			if (document.getElementById('id_radio_redirect_spider_off').checked)
			{
				var redirect_spider = '0';
			}
			else
			{
				var redirect_spider = '1';
			}
			
			if (document.getElementById('id_radio_redirect_method_random').checked)
			{
				var redirect_method = 'random';
			}
			else if (document.getElementById('id_radio_redirect_method_home').checked)
			{
				var redirect_method = 'home';
			}
			else
			{
				var redirect_method = 'none';
			}
			
			if (document.getElementById('id_radio_redirect_type_301').checked)
			{
				var redirect_type = '301';
			}
			else if (document.getElementById('id_radio_redirect_type_302').checked)
			{
				var redirect_type = '302';
			}
			else
			{
				var redirect_type = '303';
			}
			
			if (document.getElementById('id_radio_target_window_new').checked)
			{
				var target_window = '_blank';
			}
			else
			{
				var target_window = '_self';
			}
			
			//alert(referrer);
			//use ajax to create url
			var result = insertNew('create_new',classification_prefix,permalink,redirect_url,blank_referrer,redirect_spider,redirect_method,redirect_type,cloak_target);
			insertString = '<a href="' + result + '" target="' + target_window + '">'+anchor+'</a>';
		}
		
		if(window.tinyMCE) {
			//window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, insertString);
			tinyMCEPopup.execCommand("mceBeginUndoLevel");
			tinyMCEPopup.execCommand('mceReplaceContent', false, insertString);
			tinyMCEPopup.execCommand("mceEndUndoLevel");
			//Peforms a clean up of the current editor HTML. 
			//tinyMCEPopup.editor.execCommand('mceCleanup');
			//Repaints the editor. Sometimes the browser has graphic glitches. 
			tinyMCEPopup.editor.execCommand('mceRepaint');
			tinyMCEPopup.close();
		}
		
		return;
		
	}
	</script>
	<base target="_self" />
</head>
<body id="link" onload="tinyMCEPopup.executeOnLoad('init();');document.body.style.display='';" style="display: none">

	<form name="post_snippets" action="#">
    <input id='hidden' type='hidden' value='insert_new'>
	<div class="tabs">
		<ul>
			<li id="ps_tab1" class="current" style='cursor:pointer'><span>Create Cloaked Link</span></li>
		</ul>
		<ul>
			<li id="ps_tab2" class="" style='cursor:pointer'><span>Use Created Profile</span></li>
		</ul>
	</div>
	
	<div class="panel_wrapper" style="overflow:auto;height:421px;">
	
        <div id="ps_panel1" class="panel current" style="height:421px;">
			<br />
			<table border="0" cellpadding="4" cellspacing="0">
				<tr>
					<td>
						<label for=keyword>
							<img src="./../images/tip.png" style="cursor:pointer;" border=0 title="Example: http://www.myblog.com/CLASSIFICATION/permalink-name/.">
							Classification Prefix
						</label>
					</td>
					<td>
						<select type=text id='id_classification' name='classification'>
							<?php
								foreach ($cloaking_classification_prefix as $k=>$v)
								{
									echo "<option value='$v'>$v</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for=keyword>
							<img src="./../images/tip.png" style="cursor:pointer;" border=0 title="Example: http://www.myblog.com/go/permalink-name/.">
							Permalink Name
						</label>
					</td>
					<td>
						<input type=text  id='id_permalink' size=67 name='permalink' >
					</td>
				</tr>
				<tr>
					<td>
						<label for=keyword>
							<img src="./../images/tip.png" style="cursor:pointer;" border=0 title="This is the URL that the visitor will be redirected to.">
							Redirect URL
						</label>
					</td>
					<td>
						<input type=text size=67 id='id_redirect_url' name=redirect_url >
					</td>
				</tr>
				<tr>
					<td>
						<label for=keyword>
							<img src="./../images/tip.png" style="cursor:pointer;" border=0 title="This will load the traget page in an iframe, keeping the masked URL in the address bar.">
							Target Cloaking
						</label>
					</td>
					<td>
						<input type=radio size=67 id='id_radio_cloak_target_off' name='cloak_target' value='0' checked='yes'> off  &nbsp;&nbsp;&nbsp;
						<input type=radio size=67 id='id_radio_cloak_target_on' name='cloak_target' value='1' > on
					</td>
				</tr>
				<tr>
					<td>
						<label for=keyword>
							<img src="./../images/tip.png" style="cursor:pointer;" border=0 title="This will prevent traget URL from tracking the source of the referrer, which in this case will be the post that contains the masked link.">
							Referrer Blanking
						</label>
					</td>
					<td>
						<input type=radio size=67 id='id_radio_blank_referrer_off' name='blank_referrer' value='0' checked='yes'> off  &nbsp;&nbsp;&nbsp;
						<input type=radio size=67 id='id_radio_blank_referrer_on' name='blank_referrer' value='1' > on
					</td>
				</tr>
				<tr>
					<td valign='top' width='230'>
							<img src="./../images/tip.png" style="cursor:pointer;" border=0 title="301 = Moved permantely; 302 = Temporary Location; 303 = Other;.">
							Spider Redirecting
					</td>
					<td>
							<input type=radio id='id_radio_redirect_spider_off'  name='redirect_spider' value='0' checked='yes'> off &nbsp;&nbsp;&nbsp;
							<input type=radio id='id_radio_redirect_spider_on' name='redirect_spider' value='1' > on &nbsp;&nbsp;&nbsp;
					</td>
				</tr>
				<tr>
					<td valign='top' width='230'>
							<img src="./../images/tip.png" style="cursor:pointer;" border=0 title="If spider filtering is on; determine how to redirect the spider for this link profile.">
							Redirection Method
					</td>
					<td>
							<input type=radio id='id_radio_redirect_method_random' name='redirect_method' value='random' checked='yes'> Random Post &nbsp;&nbsp;&nbsp;
							<input type=radio id='id_radio_redirect_method_home'  name='redirect_method' value='home'> Blog Homepage &nbsp;&nbsp;&nbsp;
							<input type=radio id='id_radio_redirect_method_none'  name='redirect_method' value='none'> Same Page &nbsp;&nbsp;&nbsp;
					</td>
				</tr>
				<tr>
					<td valign='top' width='230'>
							<img src="./../images/tip.png" style="cursor:pointer;" border=0 title="301 = Moved permantely; 302 = Temporary Location; 303 = Other;."> 
							Redirection Type
					</td>
					<td>
							<input type=radio id='id_radio_redirect_type_301' name='redirect_type' value='301'> 301 &nbsp;&nbsp;&nbsp;
							<input type=radio id='id_radio_redirect_type_302'  name='redirect_type' value='302' checked='yes'> 302 &nbsp;&nbsp;&nbsp;
							<input type=radio id='id_radio_redirect_type_303'  name='redirect_type' value='303'> 303 &nbsp;&nbsp;&nbsp;
					</td>
				</tr>
				<tr>
					<td>
						<label for=keyword>
							<img src="./../images/tip.png" style="cursor:pointer;" border=0 title="This will load the traget page in an iframe, keeping the masked URL in the address bar.">
							Target Window
						</label>
					</td>
					<td>
						<input type=radio size=67 id='id_radio_target_window_new' name='target_window'  value='new' checked='yes'> New Window  &nbsp;&nbsp;&nbsp;
						<input type=radio size=67 id='id_radio_target_window_self' name='target_window'  value='self' > Same Window
					</td>
				</tr>
			</table>
			<p>If no permalink name is provided then a random number will be generated.</p>
        </div>
		 <div id="ps_panel2" class="panel" style="height:165px;">
        <br />
        <table border="0" cellpadding="4" cellspacing="0">

			 <tr>
				<td nowrap="nowrap"><label for="target">Cloaked Link Profile:</label></td>
				<td>
					<select id="profile_id" name="target">
					<option value='' selected>None Selected</option>
					<?php
						if ($profile_id)
						{
							foreach ($profile_id as $key=>$val)
							{
								echo "<option value='{$profile_id[$key]}' >{$profile_permalink[$key]}</option>";
							}
						}
					?>
					</select>
				</td>
			  </tr>	
			  <tr>
				<td nowrap="nowrap"><label for="target">Target:</label></td>
				<td>
					<select id="target_2" name="target">
					<option value='_blank'>New</option>
					<option value='_self'>Self</option>
					</select>
				</td>
			  </tr>
				
        </table>
		
        </div>

	</div>

	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="<?php _e( 'Cancel', 'post-snippets' ); ?>" onclick="tinyMCEPopup.close();" />
		</div>

		<div style="float: right">
			<input type="submit" id="insert" name="insert" value="<?php _e( 'Insert', 'post-snippets' ); ?>" onclick="insertCloakMeShortcode();" />
		</div>
	</div>
</form>
</body>
</html>