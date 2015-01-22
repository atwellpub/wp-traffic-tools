<?php
session_start();

if ( file_exists ( './../../../wp-config.php' ) )
{
	include_once ( './../../../wp-config.php' );
}
else if ( file_exists ( './../../../../wp-config.php' ) )
{
	include_once ( './../../../../wp-config.php' );
}

$mode = $_GET['mode'];
$id = $_GET['id'];
$nature = $_GET['nature'];
//$nature = 'edit';


$return = stripslashes($_COOKIE['wptt_prices']);
$return = json_decode($return, true);

$rp = "1.1.1.1.1.1";
$rp = explode(".",$rp);

if ($mode=='links')
{
		$query = "SELECT `option_value` FROM wpt_classification_prefixes  WHERE option_name='classification_prefix'";
		$result = mysql_query($query);
		if (!$result){echo $query; echo mysql_error(); exit;}
		$arr = mysql_fetch_array($result);
		$cloaking_classification_prefix =$arr[option_value];
		$cloaking_classification_prefix = explode(';',$cloaking_classification_prefix);
		//echo $classification_prefix;exit;
		$c=$rp[0];

		$query = "SELECT * FROM {$table_prefix}wptt_cloakme_profiles WHERE id='$id' LIMIT 1";
		$result = mysql_query($query);
		$arr = mysql_fetch_array($result);
		if (!$result){echo $query; echo mysql_error(); exit;}

		$cloaking_profile_id = $arr['id'];
		$cloaking_link_masking = $arr['link_masking'];
		$cloaking_classification = $arr['classification_prefix'];
		$cloaking_permalink = $arr['permalink'];
		$cloaking_cloaked_url = $arr['cloaked_url'];
		$cloaking_cloak_target = $arr['cloak_target'];
		$cloaking_stuff_cookie = $arr['stuff_cookie'];
		$cloaking_redirect_method = $arr['redirect_method'];
		$cloaking_redirect_method_url = $arr['redirect_method_url'];
		$cloaking_redirect_type = $arr['redirect_type'];
		$cloaking_redirect_url = $arr['redirect_url'];
		$cloaking_rotate_urls = $arr['rotate_urls'];
		$cloaking_rotate_urls_count = $arr['rotate_urls_count'];
		($cloaking_rotate_urls_count) ? $cloaking_rotate_urls_count = $cloaking_rotate_urls_count : $cloaking_rotate_urls_count = 1;
		$cloaking_redirect_spider = $arr['redirect_spider'];
		$cloaking_blank_referrer = $arr['blank_referrer'];
		$cloaking_spoof_referrer_url = $arr['spoof_referrer_url'];
		$cloaking_spider_count = $arr['spider_count'];
		$cloaking_visitor_count = $arr['visitor_count'];
		$cloaking_keywords = stripslashes($arr['keywords']);
		$cloaking_keywords = str_replace(",","\r\n",$cloaking_keywords);
		$cloaking_keywords_affect = $arr['keywords_affect'];
		$cloaking_attributes = stripslashes($arr['attributes']);
		$cloaking_attributes = str_replace('"',"'",$cloaking_attributes);
		$cloaking_keywords_limit = $arr['keywords_limit'];
		$cloaking_keywords_limit_total = $arr['keywords_limit_total'];
		$cloaking_keywords_target_page = $arr['keywords_target_page'];
		$notes = $arr['notes'];

		if ($c==0)
		{
			$add = "disabled='disabled' ";
		}
		else if ($c==2)
		{
			$addb = "disabled='disabled' ";
			$add = "";
		}
		else
		{
			$add = "";
			$addb = "";
		}

		?>
				<td>
				</td>
				<td colspan=5>
					<table class='none'>
						<tr>
							<td style='border:0' colspan=2>

								<label for=keyword>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Use this area to store information about this link profile that might help you in your organizational efforts.">
									Profile Notes:
								</label><br>
								<textarea <?php echo $add; ?>  name='notes' style='width:100%;heigh:200px;' ><?php echo $notes; ?></textarea><br>
							</td>

						</tr>
						<tr>
							<td style='border:0'>
								<label for=keyword>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Determine whether whether or not we will mask the redirect URL, if this option is turned off then any redirect URL(s) will not be masked if keyword linking affects are applied.">
									Mask Links
								</label>
							</td>
							<td style='border:0'>
								<select <?php echo $add; ?>  type='checkbox' name='link_masking' id='id_select_link_masking'>
									<option value='1' <?php if ($cloaking_link_masking==1){ echo "selected='true'"; } ?>>Yes</option>
									<option value='0' <?php if ($cloaking_link_masking==0&&$nature!='new'){ echo "selected='true'"; } ?>>No</option>
								</select>
							</td>
						</tr>
						<tr class='class_tr_link_masking' <?php if ($cloaking_link_masking==0&&$nature=='edit'){echo "style='display:none;'";}?>>
							<td style='border:0'>
								<label for=keyword>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Example: http://www.myblog.com/CLASSIFICATION/permalink-name/.">
									Classification Prefix
								</label>
							</td>
							<td style='border:0'>
								<input <?php echo $add; ?> type=hidden name='profile_id' value='<?php echo $id; ?>'>
								<select <?php echo $add; ?>  type=text id='id_cloaking_classification' name='classification'>
									<?php
										foreach ($cloaking_classification_prefix as $k=>$v)
										{
											if ($cloaking_classification_prefix[$k] == $cloaking_classification)
											{
												$selected = 'selected="true"';
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
						<tr class='class_tr_link_masking' <?php if ($cloaking_link_masking==0&&$nature=='edit'){echo "style='display:none;'";}?>>
							<td style='border:0'>
								<label for=keyword>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Example: http://www.myblog.com/go/permalink-name/. You can also append _GET paramaerts that will pass over to the redirect url. eg: http://www.myblog.com/go/permalink-name?param=1&go=2. You can also attempt to append any organic keyword associated with a visitor's browsing session using the %keyword_query% token, eg: http://www.myblog.com/go/permalink-name?query=%keyword_query%">
									Permalink Name
								</label>
							</td>
							<td style='border:0'>
								<input <?php echo $add; ?> type=text  id='id_cloaking_permalink' size=67 name='permalink' value='<?php echo $cloaking_permalink; ?>'>
							</td>
						</tr>
						<tr>
							<td style='border:0'>
								<label for=keyword>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="One per line. This is the URL that the visitor will be redirected to. If you plan to geotarget use the syntax below and WPTT will select the first available match from the list of URLs. If no match is detected it will redirect the user to a URL in the list that has no geo-routing syntax.">
									Redirect URL(s)
								</label>
								<br>
								<div style='margin-top:-21px;padding-bottom:10px;'>
									<small>

									<?php
									if  ($addb)
									{
										echo "<br><br>NOTE: Geotargeting is disabled for free version of WP Traffic Tools<br><br>";
									}
									?>
									<br>
									<i>Geo-Routing Syntax:</i><br>
									<a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>/includes/country-codes.txt' target=_blank><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/link.gif" style="cursor:pointer;" border=0 title="Click here to see a list of available country codes."></a> http://www.targetsite.com{countrycode:us}<br>
									<a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>/includes/region-codes.txt' target=_blank><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/link.gif" style="cursor:pointer;" border=0 title="Click here to see a list of available region codes."></a> http://www.targetsite.com{regioncode:al} <br>
									http://www.targetsite.com{areacode:334}<br>
									http://www.targetsite.com{city:birmingham}<br>

									</small>
								</div>
							</td>
							<td style='border:0'>


								<textarea <?php echo $add; ?>  name='redirect_url' cols=63  rows=7 wrap='off'><?php echo $cloaking_redirect_url; ?></textarea>

							</td>
						</tr>
						<tr <?php if ($cloaking_link_masking==0&&$nature=='edit'){echo "style='display:none;'";}?>>
							<td style='border:0'>
								<label for=keyword>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Turning this to on will tell WPTT to rotate through the URL(s) above if more than one is detected. If this feature is off then WPTT will always use the first URL on the first line of the textarea above.">
									Rotate URLs
								</label>
							</td>
							<td style='border:0'>
								<select <?php echo $add; ?>  name='rotate_urls'>
									<option value='0' <?php if ($cloaking_rotate_urls==0){ echo "selected='true'"; } ?>>No</option>
									<option value='1' <?php if ($cloaking_rotate_urls==1){ echo "selected='true'"; } ?>>Yes</option>
								</select>
							</td>
						</tr>
						<tr <?php if ($cloaking_link_masking==0&&$nature=='edit'){echo "style='display:none;'";}?>>
							<td style='border:0'>
								<label for=keyword>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Set this value to determine how many times a URL will be shown to a visitor before it is rotated. ">
									Rotate URLs - Show Count
								</label>
							</td>
							<td style='border:0'>
								<input type='text' name='rotate_urls' value = '<?php echo $cloaking_rotate_urls_count; ?>'>

							</td>
						</tr>
						<tr class='class_tr_link_masking' <?php if ($cloaking_link_masking==0&&$nature=='edit'){echo "style='display:none;'";}?>>
							<td valign='top' width='230' style='border:0'>
									<a href='http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html' target='_blank'><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Click Me to open http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html for redirect definitions" border=0> </a>
									Redirection Type
							</td>
							<td style='border:0'>
								<select <?php echo $add; ?>  name='redirect_type'>
									<option value='301' <?php if ($cloaking_redirect_type==301){ echo "selected='true'"; } ?>>301</option>
									<option value='302' <?php if ($cloaking_redirect_type==302||!$cloaking_redirect_type){ echo "selected='true'"; } ?>>302</option>
									<option value='303' <?php if ($cloaking_redirect_type==303){ echo "selected='true'"; } ?>>303</option>
									<option value='307' <?php if ($cloaking_redirect_type==307){ echo "selected='true'"; } ?>>307</option>
								</select>
							</td>
						</tr>
						<tr class='class_tr_link_masking' id='id_tr_iframe_content' <?php if ($cloaking_link_masking==0&&$nature=='edit'){echo "style='display:none;'";}?>>
							<td style='border:0'>
								<label for=keyword>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="This will load the traget page in an iframe, keeping the masked URL in the address bar.">
									Iframe Content
								</label>
							</td>
							<td style='border:0'>
								<select <?php echo $add; ?>  name='cloak_target'>
									<option value='0' <?php if ($cloaking_cloak_target==0){ echo "selected='true'"; } ?>>No</option>
									<option value='1' <?php if ($cloaking_cloak_target==1){ echo "selected='true'"; } ?>>Yes</option>
								</select>
							</td>
						</tr>
						<tr    class='class_tr_link_masking' <?php if ($cloaking_link_masking==0&&$nature=='edit'){echo "style='display:none;'";}?>>
							<td style='border:0'>
								<label for=keyword >
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="We use the double-meta-refresh method for referrer blanking, which does not work for Chrome browsers. If WpTrafficTools is unable to blank the referrer while referrer blanking is enabled then the traffic will not poss on to the target location and instead be redirected to the Blog's homepage. If referrer spoofing is enabled then WpTrafficTools will fake the referrer using the user indicated URL as the referrer data.">
									Referrer Management
								</label>
							</td>
							<td style='border:0'>
								<select <?php echo $add; ?> <?php echo $addb; ?>  name='blank_referrer' id='id_select_referrer_management'>
									<option value='0' <?php if ($cloaking_blank_referrer==0){ echo "selected='true'"; } ?>>Leave Referrer Intact</option>
									<option value='1' <?php if ($cloaking_blank_referrer==1){ echo "selected='true'"; } ?>>Blank Referrer</option>
									<option value='2' <?php if ($cloaking_blank_referrer==2){ echo "selected='true'"; } ?>>Spoof Referrer</option>
								</select>
							</td>
						</tr>
						<tr class='class_tr_spoof_referrer' <?php if ($cloaking_blank_referrer!=2||$nature!='edit'){echo "style='display:none;'";}?>>
							<td style='border:0'>
								<label for=keyword>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="We will send the target location this referrer URL instead of the true landing page's URL. You can add additional URLs (one per line) to enable URL rotation.">
									Set Referrer URL:
								</label>
							</td>
							<td style='border:0'>
								<textarea <?php echo $add; ?> <?php echo $addb; ?> type=text  id='id_cloaking_spoof_referrer_url' name='spoof_referrer_url' rows=2 cols=50 wrap="off"><?php echo $cloaking_spoof_referrer_url; ?></textarea>
							</td>
						</tr>
						<tr class='class_tr_link_masking' <?php if ($cloaking_link_masking==0&&$nature=='edit'){echo "style='display:none;'";}?>>
							<td valign='top' width='230' style='border:0'>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Should we detect, prevent, & then redirect spiders somewhere else or should we allow them to pass through to the specified redirect url? Set to yes to prevent spiders from continuing.">
									Spider Deflecting
							</td>
							<td style='border:0'>
								<select <?php echo $add; ?> <?php echo $addb; ?> name='redirect_spider'>
									<option value='0' <?php if ($cloaking_redirect_spider==0){ echo "selected='true'"; } ?>>No</option>
									<option value='1' <?php if ($cloaking_redirect_spider==1){ echo "selected='true'"; } ?>>Yes</option>
								</select>
							</td>
						</tr>
						<tr class='class_tr_link_masking' <?php if ($cloaking_link_masking==0&&$nature=='edit'){echo "style='display:none;'";}?>>
							<td valign='top' width='230' style='border:0'>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="If spider filtering is on; determine how to redirect the spider for this link profile.">
									Spider Deflection Method
							</td>
							<td style='border:0'>
								<select <?php echo $add; ?> <?php echo $addb; ?> name='redirect_method' id='id_select_redirect_method'>
									<option value='random' <?php if ($cloaking_redirect_method=='random'){ echo "selected='true'"; } ?>>Redirect to Random Page</option>
									<option value='home' <?php if ($cloaking_redirect_method=='home'){ echo "selected='true'"; } ?>>Redirect to Homepage</option>
									<option value='custom' <?php if ($cloaking_redirect_method=='custom'){ echo "selected='true'"; } ?>>Redirect to Custom Page</option>
									<option value='none' <?php if ($cloaking_redirect_method=='none'){ echo "selected='true'"; } ?>>Redirect to Same Page</option>
								</select>
							</td>
						</tr>
						<tr class='class_tr_redirect_method_url' <?php if ($cloaking_redirect_method!="custom") { echo "style='display:none'"; } ?> >
							<td valign='top' width='230' style='border:0'>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Set your redirect URL here.">
									Redirection URL
							</td>
							<td style='border:0'>
								<input <?php echo $add; ?> <?php echo $addb; ?> size=67 id='id_attributes' name='redirect_method_url'  value="<?php echo $cloaking_redirect_method_url; ?>" >
							</td>
						</tr>
						<tr >
							<td valign='top' width='230' style='border:0'>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Special affects will be applied to these keywords. Serparate multiple keywords with commas. ">
									Keywords
							</td>
							<td style='border:0'>
								<textarea <?php echo $add; ?>  name='keywords' cols=50><?php echo $cloaking_keywords; ?></textarea>
							</td>
						</tr>
						<tr >
							<td valign='top' width='230' style='border:0'>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="How should we treat these keywords?">
									Keyword Affect
							</td>
							<td style='border:0'>
								<select <?php echo $add; ?> id='id_select_keywords_affect' name='keywords_affect'>
									<option value='0' <?php if ($cloaking_keywords_affect=='0'){ echo "selected='true'"; } ?>>None applied</option>
									<option value='1' <?php if ($cloaking_keywords_affect=='1'){ echo "selected='true'"; } ?>>Convert to link (ignore case)</option>
									<option value='2' <?php if ($cloaking_keywords_affect=='2'){ echo "selected='true'"; } ?>>Convert to link (ignore case, nofollow)</option>
									<option value='3' <?php if ($cloaking_keywords_affect=='3'){ echo "selected='true'"; } ?>>Convert to link (honor case)</option>
									<option value='4' <?php if ($cloaking_keywords_affect=='4'){ echo "selected='true'"; } ?>>Convert to link (honor case, nofollow)</option>
									<option value='5' <?php if ($cloaking_keywords_affect=='5'){ echo "selected='true'"; } ?>>Bold</option>
									<option value='6' <?php if ($cloaking_keywords_affect=='6'){ echo "selected='true'"; } ?>>Italicize</option>
								</select>
							</td>
						</tr>
						<tr class='class_tr_html_attributes' <?php if ($cloaking_keywords_affect==0||$cloaking_keywords_affect==5||$cloaking_keywords_affect==6) { echo "style='display:none'"; } ?> >
							<td valign='top' width='230' style='border:0'>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Use this area to add custom title, class, id, and styling attributes to link occurences found within post content. EG: title='this title' or class='classname'">
									HTML Appendages
							</td>
							<td style='border:0'>
								<input <?php echo $add; ?> <?php echo $addb; ?> size=67 id='id_attributes' name='attributes'  value="<?php echo $cloaking_attributes; ?>" >
							</td>
						</tr>
						<tr>
							<td valign='top' width='230' style='border:0'>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Limits the keyword affects when multiple instances are found (of each keyword).">
									Limit Individual Occurances
							</td>
							<td style='border:0'>
								<select <?php echo $add; ?>  name='keywords_limit'>
									<option value='90' <?php if ($cloaking_keywords_limit=='90'){ echo "selected='true'"; } ?>>No limit</option>
									<option value='1' <?php if ($cloaking_keywords_limit=='1'){ echo "selected='true'"; } ?>>First instance only</option>
									<option value='2' <?php if ($cloaking_keywords_limit=='2'){ echo "selected='true'"; } ?>>2 instances</option>
									<option value='3' <?php if ($cloaking_keywords_limit=='3'){ echo "selected='true'"; } ?>>3 instances</option>
									<option value='4' <?php if ($cloaking_keywords_limit=='4'){ echo "selected='true'"; } ?>>4 instances</option>
									<option value='5' <?php if ($cloaking_keywords_limit=='5'){ echo "selected='true'"; } ?>>5 instances</option>
								</select>
							</td>
						</tr>
						<tr>
							<td valign='top' width='230' style='border:0'>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Limits the keyword affects when multiple instances are found (of all keywords in this profile set).">
									Limit Total Occurances
							</td>
							<td style='border:0'>
								<select <?php echo $add; ?>  name='keywords_limit_total'>
									<option value='90' <?php if ($cloaking_keywords_limit_total=='90'){ echo "selected='true'"; } ?>>No limit</option>
									<option value='1' <?php if ($cloaking_keywords_limit_total=='1'){ echo "selected='true'"; } ?>>1 alteration only.</option>
									<option value='2' <?php if ($cloaking_keywords_limit_total=='2'){ echo "selected='true'"; } ?>>2 alterations only.</option>
									<option value='3' <?php if ($cloaking_keywords_limit_total=='3'){ echo "selected='true'"; } ?>>3 alterations only.</option>
									<option value='4' <?php if ($cloaking_keywords_limit_total=='4'){ echo "selected='true'"; } ?>>4 alterations only.</option>
									<option value='5' <?php if ($cloaking_keywords_limit_total=='5'){ echo "selected='true'"; } ?>>5 alterations only.</option>
								</select>
							</td>
						</tr>
						<tr>
							<td valign='top' width='230' style='border:0'>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Open target link in same page or new tab?">
									Target Page
							</td>
							<td style='border:0'>
								<select <?php echo $add; ?>  name='keywords_target_page'>
									<option value='_self' <?php if ($cloaking_keywords_target_page=='_self'){ echo "selected='true'"; } ?>>Same page</option>
									<option value='_blank' <?php if ($cloaking_keywords_target_page=='_blank'){ echo "selected='true'"; } ?>>New Tab</option>
								</select>
							</td>
						</tr>
						<tr class='class_tr_link_masking' id='id_tr_additional_cookie' <?php if ($cloaking_link_masking==0&&$nature=='edit'){echo "style='display:none;'";}?>>
							<td style='border:0'>
								<label for=keyword>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Prior to redirect, cookies will be loaded from this URL.">
									Additionaly stuff this cookie on redirects
								</label>
							</td>
							<td style='border:0'>
								<input <?php echo $add; ?> <?php echo $addb; ?> type=text size=67 id='id_cloaking_stuff_cookie' name='stuff_cookie'  value='<?php echo $cloaking_stuff_cookie; ?>' >

							</td>
						</tr>
						<tr>
							<td valign='top' width='230' style='border:0'>

							</td>
							<td style='border:0' align='right'>
								<?php
								if ($cloaking_profile_id)
								{
									echo "<input  $add type='button' class='class_profile_save_profile' id='id_cloaking_edit_profile_{$cloaking_profile_id}' value='Save Profile'>";
								}
								else
								{
									echo "<input  $add  type='button' id='id_cloaking_save_profile' value='Save Profile'>";
								}
								?>
							</td>
						</tr>
					</table>
				</td>
		<?php

}
if ($mode=='redirect')
{

		$query = "SELECT * FROM {$table_prefix}wptt_wpredirect_profiles WHERE id='$id' LIMIT 1";
		$result = mysql_query($query);
		$arr = mysql_fetch_array($result);
		if (!$result){echo $query; echo mysql_error(); exit;}
		$c=$rp[1];

		$redirecting_profile_id  = $arr['id'];
		$redirecting_priority  = $arr['priority'];
		$redirecting_post_id  = $arr['post_id'];
		$redirecting_category_id  = $arr['category_id'];
		$redirecting_redirect_url  = $arr['redirect_url'];
		$redirecting_redirect_keywords  = $arr['redirect_keywords'];
		$redirecting_redirect_type  = $arr['redirect_type'];
		$redirecting_redirect_spider  = $arr['ignore_spider'];
		$redirecting_blank_referrer  = $arr['blank_referrer'];
		$redirecting_iframe_target  = $arr['iframe_target'];
		$redirecting_iframe_target_title  = $arr['iframe_target_title'];
		$redirecting_redirect_count  = $arr['redirect_count'];
		$redirecting_redirect_delay  = $arr['redirect_delay'];
		$redirecting_exclude_items  = $arr['exclude_items'];
		$redirecting_require_referrer  = $arr['require_referrer'];
		$redirecting_throttle  = $arr['throttle'];
		$redirecting_status  = $arr['status'];
		$notes = $arr['notes'];

		if ($id=='x')
		{
			$redirecting_redirect_delay = 0;
		}
		if ($c!=1)
		{
			$add = "disabled='disabled' ";
		}
		else
		{
			$add = "";
		}
		//echo $redirecting_status;exit;
		?>
				<td>
				</td>
				<td colspan=5>
					<table>
					<tr>
						<td style='border:0' colspan=2>
							<input <?php echo $add; ?> type=hidden size=3 name=profile_id value='<?php echo $redirecting_profile_id ?>' >

							<label for=keyword>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Use this area to store information about this profile that might help you in your organizational efforts.">
								Profile Notes:
							</label><br>
							<textarea <?php echo $add; ?>  name='notes' style='width:100%;heigh:200px;' ><?php echo $notes; ?></textarea><br>
						</td>
					</tr>
					<tr>
						<td valign='top' width='230'>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Enables or disables redirection profile without having to delete or recreate profile.">
								Profile Status
						</td>
						<td valign=top>
							<select <?php echo $add; ?>  name='status' >
								<option value='1' <?php if ($redirecting_status==1){ echo "selected='true'"; } ?>>Active</option>
								<option value='0' <?php if ($redirecting_status==0&&$id!='x'){ echo "selected='true'"; } ?>>Inactive</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<label for=keyword>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/tip.png" style="cursor:pointer;" border=0 title="Post ID # here. Place a * as the id to redirect globaly or 'h' as the id to represent a homepage redirect.">
								Post ID
							</label>
						</td>
						<td>
							<input <?php echo $add; ?> type=text  id='id_redirecting_post_id' size=5 name=post_id value='<?php echo $redirecting_post_id ?>' >
						</td>
					</tr>
					<tr>
						<td>
							<label for=keyword>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/tip.png" style="cursor:pointer;" border=0 title="Category ID # here. Leave blank to ignore. WPTT checks for category matches before Post ID matches.">
								Category ID
							</label>
						</td>
						<td>
							<input <?php echo $add; ?> type=text  id='id_redirecting_category_id' size=5 name=category_id value='<?php echo $redirecting_category_id ?>' >
						</td>
					</tr>
					<tr>
						<td style='border:0'>
							<label for=keyword>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="One per line. This is the URL that the visitor will be redirected to. If you plan to geotarget use the syntax below and WPTT will select the first available match from the list of URLs. If no match is detected it will redirect the user to a URL in the list that has no geo-routing syntax.">
								Redirect URL(s)
							</label>
							<br>
							<div style='margin-top:-21px;padding-bottom:10px;'>
								<small>

								<br>
								<i>Geo-Routing Syntax:</i><br>
								<a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>/includes/country-codes.txt' target=_blank><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/link.gif" style="cursor:pointer;" border=0 title="Click here to see a list of available country codes."></a> http://www.targetsite.com{countrycode:us}<br>
								<a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>/includes/region-codes.txt' target=_blank><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/link.gif" style="cursor:pointer;" border=0 title="Click here to see a list of available region codes."></a> http://www.targetsite.com{regioncode:al} <br>
								http://www.targetsite.com{areacode:334}<br>
								http://www.targetsite.com{city:birmingham}<br>

								</small>
							</div>
						</td>
						<td style='border:0'>
							<textarea <?php echo $add; ?>  name='redirect_url' cols=63  rows=7 wrap='off'  id='id_redirecting_redirect_url'><?php echo $redirecting_redirect_url; ?></textarea>
						</td>
					</tr>
					<tr>
						<td valign=top>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/tip.png" style="cursor:pointer;" border=0 title="Please seperate keywords with commas. How this works: If the the url of the page that referrered the traffic contains any of these keywords then the visitor will be redirected. Otherwise no redirection will take place unless a * wildcard is placed into this field. Use an exclamation mark before 1 keyword to create the condition that everything that DOES NOT CONTAIN that keyword is redirected; eg: !google or !google,!bing,!yahoo">
								Redirect Keywords
							</label>
						</td>
						<td>
							<input <?php echo $add; ?> type=text  id='id_redirecting_redirect_keywords' size=67 name=redirect_keywords  value='<?php echo $redirecting_redirect_keywords ?>'  >
						</td>
					</tr>
					<tr>
						<td>
							<label for=keyword>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="This will prevent traget URL from tracking the source of the referrer, which in this case will be the post that contains the masked link. If the referrer cannot be blanked then the redirect will be abandoned and the visitor redirected to the blog's homepage.">
								Referrer Management
							</label>
						</td>
						<td>
							<select <?php echo $add; ?>  name='blank_referrer' id='id_select_referrer_management'>
									<option value='0' <?php if ($redirecting_blank_referrer==0){ echo "selected='true'"; } ?>>Leave Referrer Intact</option>
									<option value='1' <?php if ($redirecting_blank_referrer==1){ echo "selected='true'"; } ?>>Blank Referrer</option>
							</select>
						</td>
					</tr>
					<tr>
						<td valign='top' width='230'>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Setting this option to no will tell WPTT to disable the redirect profile for spiders. If this is set to yes, then we will treat spiders as humans and redirect them to the set location if they meet the profile's redirect requirements.">
								Spider Management
						</td>
						<td>
							<select <?php echo $add; ?>  name='spider_management'>
								<option value='1' <?php if ($redirecting_redirect_spider==1){ echo "selected='true'"; } ?>>Redirect Spiders With Humans</option>
								<option value='0' <?php if ($redirecting_redirect_spider==0&&$id!='x'){ echo "selected='true'"; } ?>>Prevent Spider Redirection</option>
								<option value='2' <?php if ($redirecting_redirect_spider==2){ echo "selected='true'"; } ?>>Prevent Human Redirection</option>
							</select>
						</td>
					</tr>
					<tr>
						<td valign='top' width='230'>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="301 = Moved permantely; 302 = Temporary Location; 303 = Other; 307 = External Redirect.">
								Redirection Type
						</td>
						<td>
								<input <?php echo $add; ?> type=radio id='id_redirecting_radio_redirect_type_301' name='redirect_type' value='301' <?php if ($redirecting_redirect_type=='301'){ echo "checked='yes'"; } ?> > 301 &nbsp;&nbsp;&nbsp;
								<input <?php echo $add; ?> type=radio id='id_redirecting_radio_redirect_type_302'  name='redirect_type' value='302' <?php if ($redirecting_redirect_type=='302'){ echo "checked='yes'"; } ?> > 302 &nbsp;&nbsp;&nbsp;
								<input <?php echo $add; ?> type=radio id='id_redirecting_radio_redirect_type_303'  name='redirect_type' value='303' <?php if ($redirecting_redirect_type=='303'){ echo "checked='yes'"; } ?>> 303 &nbsp;&nbsp;&nbsp;
								<input <?php echo $add; ?> type=radio id='id_redirecting_radio_redirect_type_307'  name='redirect_type' value='307' <?php if ($redirecting_redirect_type=='307'||$id=='x'){ echo "checked='yes'"; } ?> > 307 &nbsp;&nbsp;&nbsp;

						</td>
					</tr>
					<tr id='redirect_iframe_target' <?php if ($redirecting_blank_referrer==1) { echo 'style="display:none"'; } ?>>
						<td valign='top' width='230'>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="If this setting is toggled to on then the final redirect URL will be printed within the page, keeping the doorway page's URL as the URL in the address bar. This setting CAN NOT be used when a redirect delay is implemented.">
								Iframe Target:
						</td>
						<td>
								<select <?php echo $add; ?>  name='iframe_target' id=''>
								<option value='0' <?php if ($redirecting_iframe_target==0){ echo "selected='true'"; } ?>>No</option>
								<option value='1' <?php if ($redirecting_iframe_target==1){ echo "selected='true'"; } ?>>Yes</option>

							</select>
						</td>
					</tr>
					<tr id='redirect_iframe_target_title' <?php if ($redirecting_blank_referrer==1) { echo 'style="display:none"'; } ?>>
						<td valign='top' width='230'>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="If this setting is toggled to on then the final redirect URL will be printed within the page, keeping the doorway page's URL as the URL in the address bar. This setting CAN NOT be used when a redirect delay is implemented.">
								Iframe title:
						</td>
						<td>
								<input <?php echo $add; ?> type=text  size=67 name='iframe_target_title'  value='<?php echo str_replace("'","\'",$redirecting_iframe_target_title); ?>'  >

						</td>
					</tr>
					<tr>
						<td valign='top' width='230'>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="In seconds. Leave at 0 for instant redirects. If any number > 0 is entered into this field then WPTT will wait that ammount of time in seconds before redirecting a visitor.">
								Redirect Delay:
						</td>
						<td>
								<input <?php echo $add; ?> size=1 id='id_redirecting_redirect_delay' name='redirect_delay'  value='<?php echo $redirecting_redirect_delay; ?>'> <small>seconds</small>
						</td>
					</tr>
					<tr>
						<td valign='top' width='230'>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Keep at zero to prevent throttling. With this setting we can limit redirects to every Nth occurance (every nth time the profile conditions are met we will redirect the visitor).">
								Redirect Throttle:
						</td>
						<td>
							<input <?php echo $add; ?> size=1 id='id_redirecting_redirect_throttle' name='redirect_throttle'  value='<?php echo $redirecting_throttle; ?>'> <small>Limit profile execution to every <b>n</b>th occurance.</small>
						</td>
					</tr>
					<tr>
						<td valign='top' width='230'>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Exclude these pages from this rule (Usually only applicable if * is used for profile post id). Place post/page id's in comma delimited format. eg: 555,777,999">
								Exclude These Posts:
						</td>
						<td>
								<input <?php echo $add; ?> size=10 id='id_redirecting_exclude_items' name='exclude_items'  value='<?php echo $redirecting_exclude_items ?>'>

						</td>
					</tr>
					<tr>
						<td valign='top' width='230'>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="If set it 'yes', WPTT will prevent redirection if a referring URL is not detected. For most cases a referrer is required keyword detection to work. This feature exists for those who are using a wildcard in their keywords box. ">
								Require Referrer?
						</td>
						<td valign=top>
							<select <?php echo $add; ?>  name='require_referrer' id='id_select_referrer_management'>
								<option value='0' <?php if ($redirecting_require_referrer==0){ echo "selected='true'"; } ?>>No</option>
								<option value='1' <?php if ($redirecting_require_referrer==1){ echo "selected='true'"; } ?>>Yes</option>
							</select>
						</td>
					</tr>
					<tr>
						<td valign='top' width='230' style='border:0'>

						</td>
						<td style='border:0' align='right'>
							<?php
							if ($redirecting_profile_id)
							{
								echo "<input  $add  type='button' class='class_profile_save_profile' id='id_redirecting_edit_profile_{$redirecting_profile_id}' value='Save Profile'>";
							}
							else
							{
								echo "<input  $add  type='button' id='id_redirecting_save_profile' value='Save Profile'>";
							}
							?>
						</td>
					</tr>
					<tr>
						<td>
							<label for=keyword>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/tip.png" style="cursor:pointer;" border=0 title="This setting is only for redirect profiles that have * as a post ID in case a post contains multiple matches. Use the piority system to decide which profile has priority over the other. Otherwise no worries! Leave this as whatever it is or even blank and it will not affect anything. ">
								Execution Priority
							</label>
						</td>
						<td>
							<input <?php echo $add; ?> type=text  id='id_redirecting_piority' size=5 name=priority value='<?php echo $redirecting_priority ?>' >
						</td>
					</tr>
				</table>
			</td>
		<?php
}
if ($mode=='regex')
{
		$c=$rp[1];
		$query = "SELECT * FROM {$table_prefix}wptt_wpredirect_regex_profiles WHERE id='$id' LIMIT 1";
		$result = mysql_query($query);
		$arr = mysql_fetch_array($result);
		if (!$result){echo $query; echo mysql_error(); exit;}

		$regex_profile_id  = $arr['id'];
		$regex_regex_referrer  = $arr['regex_referrer'];
		$regex_regex_landing_page  = $arr['regex_landing_page'];
		$regex_spider_management  = $arr['spider_management'];
		$regex_redirect  = $arr['redirect'];
		$regex_status  = $arr['status'];
		$regex_nature  = $arr['nature'];
		$regex_notes  = $arr['notes'];

		if ($id=='x')
		{
			$regex_status = 1;
			$regex_regex_landing_page = "/(.*?)/";
		}

		if ($c!=1)
		{
			$add = "disabled='disabled' ";
		}
		else
		{
			$add = "";
		}
		//echo $redirecting_status;exit;
		?>
				<td>
				</td>
				<td colspan=5>
					<table>
					<tr>
						<td style='border:0' colspan=2>
							<input <?php echo $add; ?> type=hidden size=3 name=profile_id value='<?php echo $regex_profile_id ?>' >

							<label for=keyword>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Use this area to store information about this profile that might help you in your organizational efforts.">
								Profile Notes:
							</label><br>
							<textarea <?php echo $add; ?>  name='notes' style='width:100%;heigh:200px;' ><?php echo $regex_notes; ?></textarea><br>
						</td>
					</tr>
					<tr>
						<td valign='top' width='230'>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Enables or disables redirection profile without having to delete or recreate profile.">
								Profile Status
						</td>
						<td valign=top>
							<select <?php echo $add; ?>  name='status'>
								<option value='1' <?php if ($regex_status==1){ echo "selected='true'"; } ?>>Active</option>
								<option value='0' <?php if ($regex_status==0&&$id!='x'){ echo "selected='true'"; } ?>>Inactive</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<label for=keyword>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/tip.png" style="cursor:pointer;" border=0 title="Use PHP Regex to check the referring URL for a match. If you use (.*?) pattern widlcards then you can use $r1 & $r2 to respectively represent the contents of the matched pattern when creating your redirect rule. All regex expressions must be enclosed in fordshashes eg: /expresson/, expression modifiers can be used such as /expression/i (i=ignore case). Use php regular expression rules to format your regex expression. Entering in a mal-formatted regex expression can break the php of your website. Be careful! ">
								Referrer 'Must Contain' Regex Rule
							</label>
						</td>
						<td>
							<input <?php echo $add; ?> type=text  size=40 name=regex_referrer value='<?php echo $regex_regex_referrer ?>' >
						</td>
					</tr>
					<tr>
						<td>
							<label for=keyword>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/tip.png" style="cursor:pointer;" border=0 title="Use PHP Regex to check the landing page URL for a match.  If you use (.*?) pattern widlcards then you can use $lp1 & $lp2 to respectively represent the contents of the matched pattern when creating your redirect rule. All regex expressions must be enclosed in fordshashes eg: /expresson/, expression modifiers can be used such as /expression/i (i=ignore case). Use php regular expression rules to format your regex expression. Entering in a mal-formatted regex expression can break the php of your website. Be careful! ">
								Landing Page 'Must Contain' Regex Rule
							</label>
						</td>
						<td>
							<input <?php echo $add; ?> type=text  size=40 name=regex_landing_page value='<?php echo $regex_regex_landing_page ?>' >
						</td>
					</tr>
					<tr>
						<td>
							<label for=keyword>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH;?>images/tip.png" style="cursor:pointer;" border=0 title="Example redirect rule: http://www.amazon.com/s/$lp1. This will redirect matches to amazon.com with $lp1 redpresenting the first matched pattern in your regular(regex) landing page expression. We could also simply use http://www.amazon.com/ as our redirect rule if we are not attempting anything fancy. ">
								Redirect Rule
							</label>
						</td>
						<td>
							<input <?php echo $add; ?> type=text  size=40 name=redirect value='<?php echo $regex_redirect ?>' >
						</td>
					</tr>
					<tr>
						<td valign='top' width='230'>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Note: A visitor must click at least one item on the page to initiate a popunder. Same page redirects will instantly redirect the visitor to the final location without the visitor ever seeing the landing page.">
								Redirect Nature
						</td>
						<td valign=top>
							<select <?php echo $add; ?>  name='regex_nature'>
								<option value='2' <?php if ($regex_nature==2||!isset($regex_nature)){ echo "selected='true'"; } ?>>Redirect - Leave Referrer Intact</option>
								<option value='0' <?php if ($regex_nature==0&&isset($regex_nature)){ echo "selected='true'"; } ?>>Redirect - Reset Referrer</option>
								<option value='3' <?php if ($regex_nature==3||!isset($regex_nature)){ echo "selected='true'"; } ?>>Redirect - Iframe Target</option>
								<option value='1' <?php if ($regex_nature==1){ echo "selected='true'"; } ?>>Open as Popunder</option>
						</td>
					</tr>
					<tr>
						<td valign='top' width='230'>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Setting this option to no will tell WPTT to disable the redirect profile for spiders. If this is set to yes, then we will treat spiders as humans and redirect them to the set location if they meet the profile's redirect requirements.">
								Spider Management
						</td>
						<td>
							<select <?php echo $add; ?>  name='spider_management'>
								<option value='1' <?php if ($regex_spider_management==1){ echo "selected='true'"; } ?>>Redirect Spiders With Humans</option>
								<option value='0' <?php if ($regex_spider_management==0&&$id!='x'){ echo "selected='true'"; } ?>>Prevent Spider Redirection</option>
								<option value='2' <?php if ($regex_spider_management==2){ echo "selected='true'"; } ?>>Prevent Human Redirection</option>
							</select>
						</td>
					</tr>
					<tr>
						<td valign='top' width='230' style='border:0'>

						</td>
						<td style='border:0' align='right'>
							<input <?php echo $add; ?> type='button' id='id_regex_save_profile' class='class_regex_save_profile' value='Save Profile'>
						</td>
						</tr>
				</table>
			</td>
		<?php
}
if ($mode=='popups')
{

	$section = $_GET['section'];
	$query = "SELECT * FROM {$table_prefix}wptt_popups_profiles WHERE id='$id'";
	$result = mysql_query($query);
	$c=$rp[5];

	if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
	$arr = mysql_fetch_array($result);
	//print_r($arr);exit;
	$popups_profile_id = $arr['id'];
	$popups_type = $arr['type'];
	$popups_nature = $arr['nature'];
	$popups_width = $arr['width'];
	$popups_height = $arr['height'];
	$popups_href = $arr['href'];
	$popups_delay = $arr['delay'];
	$popups_search_keywords = $arr['search_keywords'];
	$popups_search_content = $arr['search_content'];
	$popups_search_referrer = $arr['search_referrer'];
	$popups_include_ids = $arr['include_ids'];
	$popups_exclude_ids = $arr['exclude_ids'];
	$popups_drop_count = $arr['drop_count'];
	$popups_status = $arr['status'];

	$popups_notes = $arr['notes'];

	if ($id=='x')
	{

		$popups_delay = 0;
		$popups_status = 1;
		$popups_search_content = 1;
		$popups_search_referrer = 1;
		$popups_profile_id = 'x';
	}

	if ($c!=1)
	{
		$add = "disabled='disabled' ";
	}
	else
	{
		$add = "";
	}

	//echo $redirecting_status;exit;
	if ($section=='keywords')
	{
	?>
			<td>
			</td>
			<td colspan=5>
				<table>
				<tr>
					<td style='border:0' colspan=2>
						<input <?php echo $add; ?> type=hidden size=3 name=popups_profile_id value='<?php echo $popups_profile_id; ?>' >
						<input <?php echo $add; ?> type=hidden size=3 name=popups_type value='<?php echo $section; ?>' >

						<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Use this area to store information about this profile that might help you in your organizational efforts.">
							Profile Notes:
						</label><br>
						<textarea <?php echo $add; ?>  name='popups_notes' style='width:100%;heigh:200px;' ><?php echo $popups_notes; ?></textarea><br>
					</td>
				</tr>
				<tr>
					<td valign='top' width='230'>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Enables or disables redirection profile without having to delete or recreate profile.">
							Profile Status
					</td>
					<td valign=top>
						<select <?php echo $add; ?>  name='popups_status'>
							<option value='1' <?php if ($popups_status==1){ echo "selected='true'"; } ?>>Active</option>
							<option value='0' <?php if ($popups_status==0){ echo "selected='true'"; } ?>>Inactive</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Separate keywords with commas. WP Traffic Tools will check post content for these keywords and if they are found then the popup will initiate.">
							<i>Keywords</i>
						</label>
					</td>
					<td>
						<input <?php echo $add; ?> type=text  id='id_popups_search_keywords' size=67 name=popups_search_keywords value='<?php echo $popups_search_keywords; ?>' >
					</td>
				</tr>
				<tr>
					<td style='border:0'>
						<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="One per line. This is the URL that the visitor will be redirected to. If you plan to geotarget use the syntax below and WPTT will select the first available match from the list of URLs. If no match is detected it will redirect the user to a URL in the list that has no geo-routing syntax.">
							Popup Conent URL(s)
						</label>
						<br>
						<div style='margin-top:-21px;padding-bottom:10px;'>
							<small>

							<br><br>
							<i>Geo-Routing Syntax:</i><br>
							<a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>/includes/country-codes.txt' target=_blank><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/link.gif" style="cursor:pointer;" border=0 title="Click here to see a list of available country codes."></a> http://www.targetsite.com{countrycode:us}<br>
							<a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>/includes/region-codes.txt' target=_blank><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/link.gif" style="cursor:pointer;" border=0 title="Click here to see a list of available region codes."></a> http://www.targetsite.com{regioncode:al} <br>
							http://www.targetsite.com{areacode:334}<br>
							http://www.targetsite.com{city:birmingham}<br>

							</small>
						</div>
					</td>
					<td style='border:0'>
						<textarea <?php echo $add; ?>  name='popups_href' cols=63  rows=7 wrap='off'  id='id_popups_redirect_url'><?php echo $popups_href; ?></textarea>
					</td>
				</tr>
				<tr>
					<td valign=top>
						<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Popunder - Pops up behind the current broswer in new window; Popup - This is your traditional popup. ; Popover - Uses a jquery modal box to open external content. ; Unblockable popups require the user to make a click action before the popup is initiated.">
							<i>Nature</i>
						</label>
					</td>
					<td>
						<select <?php echo $add; ?>  name='popups_nature' >
							<option value='popover' <?php if ($popups_nature=='popover'){echo "selected='true'";} ?>>Popover (JQuery)</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Width of screen in pixels.">
							<i>Width</i>
						</label>
					</td>
					<td>
						<input <?php echo $add; ?>  name='popups_width' value='<?php echo $popups_width; ?>'  size='4'>	<small>px</small>
					</td>
				</tr>
				<tr>
					<td valign='top' width='230'>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Height of screen in pixels.">
							<i>Height</i>
					</td>
					<td>
						<input <?php echo $add; ?>  name='popups_height' value='<?php echo $popups_height; ?>'  size='4'> <small>px</small>
					</td>
				</tr>
				<tr>
					<td valign='top' width='230'>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Delay (in seconds). Delays will not work for unblockable popups. Ammount of time that should pass before opening popup. ">
							<i>Delay</i>
					</td>
					<td>
							<input <?php echo $add; ?> size=1 id='id_popups_redirect_delay' name='popups_delay'  value='<?php echo $popups_delay; ?>'> <small>seconds</small>
					</td>
				</tr>
				<tr>
					<td valign='top' width='230'>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="If enabled: will search the post title and post content for keyword matches.">
							<i>Search Content</i>
					</td>
					<td>
						<input <?php echo $add; ?> type='checkbox' id='id_popups_search_content' name='popups_search_content' value=1 <?php if ($popups_search_content==1){echo "checked='true'";} ?>>

					</td>
				</tr>
				<tr>
					<td valign='top' width='230'>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="If enabled: will search the referring url for keyword matches; including any search query paramaters.(WPTT auto decodes query paramaters for accurate keyphrase matching)">
							<i>Search Referrer</i>
					</td>
					<td>
						<input <?php echo $add; ?> type='checkbox' id='id_popups_search_referrer' name='popups_search_referrer' value=1 <?php if ($popups_search_referrer==1){echo "checked='true'";} ?>>
					</td>
				</tr>
				<tr>
					<td valign='top' width='230'>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Exclude these pages from this rule (Usually only applicable if * is used for profile post id). Place post/page id's in comma delimited format. eg: 555,777,999">
							Exclude These Posts:
					</td>
					<td>
							<input <?php echo $add; ?> size=10 id='id_popups_exclude_items' name='popups_exclude_ids'  value='<?php echo $popups_exclude_ids; ?>'>

					</td>
				</tr>
				<tr>
					<td valign='top' width='230' style='border:0'>

					</td>
					<td style='border:0' align='right'>
						<?php
						if ($popups_profile_id)
						{
							echo "<input  $add  type='button' class='class_popups_keywords_save_profile' id='id_popups_keywords_edit_profile_{$popups_profile_id}' value='Save Profile'>";
						}
						else
						{
							echo "<input  $add  type='button' class='class_popups_keywords_save_profile' id='id_popups_save_profile' value='Save Profile'>";
						}
						?>
					</td>
					</tr>
			</table>
		</td>
	<?php
	}
	if ($section=='posts')
	{
	?>
			<td>
			</td>
			<td colspan=5>
				<table>
				<tr>
					<td style='border:0' colspan=2>
						<input <?php echo $add; ?> type=hidden size=3 name=popups_profile_id value='<?php echo $popups_profile_id; ?>' >
						<input <?php echo $add; ?> type=hidden size=3 name=popups_type value='<?php echo $section; ?>' >

						<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Use this area to store information about this profile that might help you in your organizational efforts.">
							Profile Notes:
						</label><br>
						<textarea <?php echo $add; ?>  name='popups_notes' style='width:100%;heigh:200px;' ><?php echo $popups_notes; ?></textarea><br>
					</td>
				</tr>
				<tr>
					<td valign='top' width='230'>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Enables or disables redirection profile without having to delete or recreate profile.">
							Profile Status
					</td>
					<td valign=top>
						<select <?php echo $add; ?>  name='popups_status' id='id_select_referrer_management'>
							<option value='1' <?php if ($popups_status==1){ echo "selected='true'"; } ?>>Active</option>
							<option value='0' <?php if ($popups_status==0){ echo "selected='true'"; } ?>>Inactive</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Separate keywords with commas. WP Traffic Tools will check post content for these keywords and if they are found then the popup will initiate.">
							<i>Include IDs</i>
						</label>
					</td>
					<td>
						<input <?php echo $add; ?> type=text  id='id_popups_include_ids' size=67 name=popups_include_ids value='<?php echo $popups_include_ids; ?>' >
					</td>
				</tr>
				<tr>
					<td style='border:0'>
						<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="One per line. This is the URL that the visitor will be redirected to. If you plan to geotarget use the syntax below and WPTT will select the first available match from the list of URLs. If no match is detected it will redirect the user to a URL in the list that has no geo-routing syntax.">
							Popup Conent URL(s)
						</label>
						<br>
						<div style='margin-top:-21px;padding-bottom:10px;'>
							<small>

							<br><br>
							<i>Geo-Routing Syntax:</i><br>
							<a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>/includes/country-codes.txt' target=_blank><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/link.gif" style="cursor:pointer;" border=0 title="Click here to see a list of available country codes."></a> http://www.targetsite.com{countrycode:us}<br>
							<a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>/includes/region-codes.txt' target=_blank><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/link.gif" style="cursor:pointer;" border=0 title="Click here to see a list of available region codes."></a> http://www.targetsite.com{regioncode:al} <br>
							http://www.targetsite.com{areacode:334}<br>
							http://www.targetsite.com{city:birmingham}<br>

							</small>
						</div>
					</td>
					<td style='border:0'>
						<textarea <?php echo $add; ?>  name='popups_href' cols=63  rows=7 wrap='off'  id='id_popups_redirect_url'><?php echo $popups_href; ?></textarea>
					</td>
				</tr>
				<tr>
					<td valign=top>
						<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Popunder - Pops up behind the current broswer in new window; Popup - This is your traditional popup. ; Popover - Uses a jquery modal box to open external content. ; Unblockable popups require the user to make a click action before the popup is initiated.">
							<i>Nature</i>
						</label>
					</td>
					<td>
						<select <?php echo $add; ?>  name='popups_nature' >
							<option value='popup_normal' <?php if ($popups_nature=='popup_normal'){echo "selected='true'";} ?>>Popup</option>
							<option value='popup_unblockable' <?php if ($popups_nature=='popup_unblockable'){echo "selected='true'";} ?>>Popup - Unblockable</option>
							<option value='popunder_normal' <?php if ($popups_nature=='popunder_normal'){echo "selected='true'";} ?>>Popunder</option>
							<option value='popunder_unblockable' <?php if ($popups_nature=='popunder_unblockable'){echo "selected='true'";} ?>>Popunder - Unblockable</option>
							<option value='popover' <?php if ($popups_nature=='popover'){echo "selected='true'";} ?>>Popover (JQuery)</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Width of screen in pixels.">
							<i>Width</i>
						</label>
					</td>
					<td>
						<input <?php echo $add; ?>  name='popups_width' value='<?php echo $popups_width; ?>'  size='4'>	<small>px</small>
					</td>
				</tr>
				<tr>
					<td valign='top' width='230'>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Height of screen in pixels.">
							<i>Height</i>
					</td>
					<td>
						<input <?php echo $add; ?>  name='popups_height' value='<?php echo $popups_height; ?>'  size='4'> <small>px</small>
					</td>
				</tr>
				<tr>
					<td valign='top' width='230'>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Delay (in seconds). Delays will not work for unblockable popups. Ammount of time that should pass before opening popup. ">
							<i>Delay</i>
					</td>
					<td>
							<input <?php echo $add; ?> size=1 id='id_popups_redirect_delay' name='popups_delay'  value='<?php echo $popups_delay; ?>'> <small>seconds</small>
					</td>
				</tr>
				<tr>
					<td valign='top' width='230' style='border:0'>

					</td>
					<td style='border:0' align='right'>
						<?php
						if ($popups_profile_id)
						{
							echo "<input  $add  type='button' class='class_popups_posts_save_profile' id='id_popups_keywords_edit_profile_{$popups_profile_id}' value='Save Profile'>";
						}
						else
						{
							echo "<input  $add  type='button' class='class_popups_posts_save_profile' id='id_popups_save_profile' value='Save Profile'>";
						}
						?>
					</td>
					</tr>
			</table>
		</td>
	<?php
	}
	if ($section=='categories')
	{
	?>
			<td>
			</td>
			<td colspan=5>
				<table>
				<tr>
					<td style='border:0' colspan=2>
						<input <?php echo $add; ?> type=hidden size=3 name=popups_profile_id value='<?php echo $popups_profile_id; ?>' >
						<input <?php echo $add; ?> type=hidden size=3 name=popups_type value='<?php echo $section; ?>' >

						<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Use this area to store information about this profile that might help you in your organizational efforts.">
							Profile Notes:
						</label><br>
						<textarea <?php echo $add; ?>  name='popups_notes' style='width:100%;heigh:200px;' ><?php echo $popups_notes; ?></textarea><br>
					</td>
				</tr>
				<tr>
					<td valign='top' width='230'>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Enables or disables redirection profile without having to delete or recreate profile.">
							Profile Status
					</td>
					<td valign=top>
						<select <?php echo $add; ?>  name='popups_status' id='id_select_referrer_management'>
							<option value='1' <?php if ($popups_status==1){ echo "selected='true'"; } ?>>Active</option>
							<option value='0' <?php if ($popups_status==0){ echo "selected='true'"; } ?>>Inactive</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Separate keywords with commas. WP Traffic Tools will check post content for these keywords and if they are found then the popup will initiate.">
							<i>Category</i>
						</label>
					</td>
					<td>
						<?php
							$args = array('name'=>'popups_include_ids','selected'=>"$popups_include_ids",'hide_empty' => 0);
							wp_dropdown_categories( $args );
						?>
					</td>
				</tr>
				<tr>
					<td valign='top' width='230'>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Exclude these pages from this rule (Usually only applicable if * is used for profile post id). Place post/page id's in comma delimited format. eg: 555,777,999">
							Exclude These Posts:
					</td>
					<td>
							<input <?php echo $add; ?> size=10 id='id_popups_exclude_items' name='popups_exclude_ids'  value='<?php echo $popups_exclude_ids; ?>'>

					</td>
				</tr>
				<tr>
					<td style='border:0'>
						<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="One per line. This is the URL that the visitor will be redirected to. If you plan to geotarget use the syntax below and WPTT will select the first available match from the list of URLs. If no match is detected it will redirect the user to a URL in the list that has no geo-routing syntax.">
							Popup Conent URL(s)
						</label>
						<br>
						<div style='margin-top:-21px;padding-bottom:10px;'>
							<small>

							<br><br>
							<i>Geo-Routing Syntax:</i><br>
							<a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>/includes/country-codes.txt' target=_blank><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/link.gif" style="cursor:pointer;" border=0 title="Click here to see a list of available country codes."></a> http://www.targetsite.com{countrycode:us}<br>
							<a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>/includes/region-codes.txt' target=_blank><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/link.gif" style="cursor:pointer;" border=0 title="Click here to see a list of available country codes."></a> http://www.targetsite.com{regioncode:al} <br>
							http://www.targetsite.com{areacode:334}<br>
							http://www.targetsite.com{city:birmingham}<br>

							</small>
						</div>
					</td>
					<td style='border:0'>
						<textarea <?php echo $add; ?>  name='popups_href' cols=63  rows=7 wrap='off'  id='id_popups_redirect_url'><?php echo $popups_href; ?></textarea>
					</td>
				</tr>
				<tr>
					<td valign=top>
						<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Popunder - Pops up behind the current broswer in new window; Popup - This is your traditional popup. ; Popover - Uses a jquery modal box to open external content. ; Unblockable popups require the user to make a click action before the popup is initiated.">
							<i>Nature</i>
						</label>
					</td>
					<td>
						<select <?php echo $add; ?>  name='popups_nature' >
							<option value='popup_normal' <?php if ($popups_nature=='popup_normal'){echo "selected='true'";} ?>>Popup</option>
							<option value='popup_unblockable' <?php if ($popups_nature=='popup_unblockable'){echo "selected='true'";} ?>>Popup - Unblockable</option>
							<option value='popunder_normal' <?php if ($popups_nature=='popunder_normal'){echo "selected='true'";} ?>>Popunder</option>
							<option value='popunder_unblockable' <?php if ($popups_nature=='popunder_unblockable'){echo "selected='true'";} ?>>Popunder - Unblockable</option>
							<option value='popover' <?php if ($popups_nature=='popover'){echo "selected='true'";} ?>>Popover (JQuery)</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Width of screen in pixels.">
							<i>Width</i>
						</label>
					</td>
					<td>
						<input <?php echo $add; ?>  name='popups_width' value='<?php echo $popups_width; ?>'  size='4'>	<small>px</small>
					</td>
				</tr>
				<tr>
					<td valign='top' width='230'>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Height of screen in pixels.">
							<i>Height</i>
					</td>
					<td>
						<input <?php echo $add; ?>  name='popups_height' value='<?php echo $popups_height; ?>'  size='4'> <small>px</small>
					</td>
				</tr>
				<tr>
					<td valign='top' width='230'>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Delay (in seconds). Delays will not work for unblockable popups. Ammount of time that should pass before opening popup. ">
							<i>Delay</i>
					</td>
					<td>
							<input <?php echo $add; ?> size=1 id='id_popups_redirect_delay' name='popups_delay'  value='<?php echo $popups_delay; ?>'> <small>seconds</small>
					</td>
				</tr>
				<tr>
					<td valign='top' width='230' style='border:0'>

					</td>
					<td style='border:0' align='right'>
						<?php
						if ($popups_profile_id)
						{
							echo "<input  $add  type='button' class='class_popups_categories_save_profile' id='id_popups_keywords_edit_profile_{$popups_profile_id}' value='Save Profile'>";
						}
						else
						{
							echo "<input  $add  type='button' class='class_popups_categories_save_profile' id='id_popups_save_profile' value='Save Profile'>";
						}
						?>
					</td>
					</tr>
			</table>
		</td>
	<?php
	}
}
?>