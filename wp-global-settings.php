<?php

add_action( 'widgets_init', 'wptt_topsearches_load_widgets' );

function wptt_topsearches_load_widgets() {
	register_widget( 'wpt_widgets_topsearches' );
}
class wpt_widgets_topsearches extends WP_Widget 
{
	/**
	 * Widget setup.
	 */
	function wpt_widgets_topsearches() 
	{
		$widget_ops = array( 'classname' => 'class_widget_topsearches', 'description' => 'This widget calls the top searches queries in a variety of ways. ');

		$this->WP_Widget( 'wpt_widgets_topsearches', 'WPTT: Topsearches','wpt_topsearhces', $widget_ops );
	}

	function widget( $args, $instance ) 
	{
		global $global_topsearches_nature_deeplinks;
		extract( $args );
		echo $before_widget;
		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
					
		$limit = $instance['limit'];
		$display_count = $instance['display_count'];
		$nature = $instance['nature'];
		$sort = $instance['sort'];
		$link = $instance['link'];
		$ignore = $instance['ignore'];
		if ($display_count!=1){$display_count=0;}
		
		$content =  wpt_top_searches("[wpttopsearches:$nature:$global_topsearches_nature_deeplinks:$sort:$limit:$link:$display_count:$ignore]",'widget');
		
		if (strlen($content)>50)
		{
			if ( $title ) echo $before_title . $title . $after_title;
			echo $content;
		}
		echo $after_widget;
	}


	function update( $new_instance, $old_instance ) 
	{
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['limit'] =  $new_instance['limit'] ;
		$instance['display_count'] = $new_instance['display_count'];
		$instance['nature'] = $new_instance['nature'];
		$instance['sort'] = $new_instance['sort'];
		$instance['link'] = $new_instance['link'];
		$instance['ignore'] = $new_instance['ignore'];
		
		return $instance;
	}

	function form( $instance ) 
	{
		
		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Recent Searches', 'limit' => '5', 'nature' => 'global', 'sort' => 'DESC', 'link' => '1',  'display_count' => '1' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		$title = strip_tags($instance['title']);
		$limit = $instance['limit'];
		$nature = $instance['nature'];
		$sort = $instance['sort'];
		$link = $instance['link'];
		$display_count = $instance['display_count'];
		$ignore = $instance['ignore'];
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'nature' ); ?>">Widget Nature:</label> 
			<select id="<?php echo $this->get_field_id( 'nature' ); ?>" name="<?php echo $this->get_field_name( 'nature' ); ?>" class="widefat" style="width:100%;">
				<option value='single' <?php if ( 'single' == $instance['nature'] ) echo 'selected="selected"'; ?>>Top Page Queries</option>
				<option value='global' <?php if ( 'global' == $instance['nature'] ) echo 'selected="selected"'; ?>>Top Global Queries</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'sort' ); ?>">Sorting:</label> 
			<select id="<?php echo $this->get_field_id( 'sort' ); ?>" name="<?php echo $this->get_field_name( 'sort' ); ?>" class="widefat" style="width:100%;">
				<option value='ASC' <?php if ( 'ASC' == $instance['sort'] ) echo 'selected="selected"'; ?>>By Search Count: ASC</option>
				<option value='DESC' <?php if ( 'DESC' == $instance['sort'] ) echo 'selected="selected"'; ?>>By Search Count: DESC</option>
				<option value='RAND' <?php if ( 'RAND' == $instance['sort'] ) echo 'selected="selected"'; ?>>Randomize</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>">Limit:</label>
			<input name="<?php echo $this->get_field_name('limit'); ?>" id="<?php echo $this->get_field_id('limit'); ?>" value="<?php echo $instance['limit']; ?>" style="width:30px;" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('link'); ?>">Link to Post:</label>
			<input  id="<?php echo $this->get_field_id('link'); ?>"  name="<?php echo $this->get_field_name('link'); ?>" class="checkbox" type="checkbox" <?php checked( $instance['link'], true ); ?> value='1'  /> 
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('display_count'); ?>">Display Search Count:</label>
			<input  id="<?php echo $this->get_field_id('display_count'); ?>"  name="<?php echo $this->get_field_name('display_count'); ?>" class="checkbox" type="checkbox" <?php checked( $instance['display_count'], true ); ?> value='1'  /> 
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('ignore'); ?>">Ignore the Following Post IDs:</label>
			<input name="<?php echo $this->get_field_name('ignore'); ?>" id="<?php echo $this->get_field_id('ignore'); ?>" value="<?php echo $instance['ignore']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}
	
function global_add_javascript()
{
	global $global_topsearches;
?>
	<script type="text/javascript">				
		jQuery(document).ready(function() 
		{


			jQuery("#id_select_topsearches_nature").live("change", function(){	
				//alert('hi');
			   var input = jQuery(this).val();
			   if (input=='global')
			   {
				  jQuery("#id_global_topsearches_nature_global_deeplinks").show();
				   
			   }
			   else 
			   {
				   jQuery("#id_global_topsearches_nature_global_deeplinks").hide();
			   }
			});
			

		});
	</script>
<?php
}

function global_update_topsearches_settings()
{
	global $table_prefix; 
	global $wptt_options;
	
	//echo 1; exit;
	if ($_POST['nature']=='global_save_topsearches_settings')
	{
		
		$wptt_options['topsearches'] = $_POST['global_topsearches'];
		$wptt_options['topsearches_nature'] = $_POST['global_topsearches_nature'];
		$wptt_options['topsearches_header'] = $_POST['global_topsearches_header'];
		$wptt_options['topsearches_footer'] = $_POST['global_topsearches_footer'];
		$wptt_options['topsearches_sort'] = $_POST['global_topsearches_sort'];
		$wptt_options['topsearches_limit'] = $_POST['global_topsearches_limit'];
		$wptt_options['topsearches_link'] =$_POST['global_topsearches_link'];
		$wptt_options['topsearches_display_count'] = $_POST['global_topsearches_display_count'];
		$wptt_options['topsearches_ignore'] = $_POST['global_topsearches_ignore'];
		$wptt_options['topsearches_tags'] = $_POST['global_topsearches_tags'];
		$wptt_options['topsearches_nature_deeplinks'] = $_POST['global_topsearches_nature_links'];

		
		$wptt_options = json_encode($wptt_options);
		//echo $global_default_classification_prefix;
		$query = "UPDATE {$table_prefix}wptt_wptraffictools_options SET option_value='$wptt_options' WHERE option_name='wptt_options'";
		$result = mysql_query($query);
		if (!$result) { echo $query; echo mysql_error(); }			

	}

}

if ($global_shadowmaker_username)
{
	//echo wp_next_scheduled('wptt_shadowmaker_update_cron');exit;
	if (!wp_next_scheduled('wptt_shadowmaker_update_cron')) {
		wp_schedule_event(time(), 'hourly', 'wptt_shadowmaker_update_cron' );
	}

	add_action('wptt_shadowmaker_update_cron', 'wptt_shadowmaker_update_execute');
	
	if (isset($_GET['update_iplist'])) {        
	    add_action('admin_init', 'wptt_shadowmaker_update_execute');
	}
}

function wptt_shadowmaker_update_execute()
{

    
	global $global_shadowmaker_username;
	global $global_shadowmaker_password;
	global $wptt_options; 
	global $table_prefix;
	//echo $global_shadowmaker_password;
	$url = "http://bseolized.com/ipgrabber/getlist.cgi?list=ips&format=json?";
	//echo $url;
	$ch=curl_init(); 
	curl_setopt($ch, CURLOPT_URL,$url); 
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "$global_shadowmaker_username:$global_shadowmaker_password");  
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch); 
	curl_close($ch);
	//echo 1; exit;
	//echo $data;exit;

	if (trim($data)>10)
	{			
		$date = date('m/d/Y h:i:s a', time());
		$query = "TRUNCATE wptt_ip_addresses";
		$result = mysql_query($query);
		if (!$result) { echo $query; echo mysql_error(); exit;}	
	
		$data = nl2br($data);			
		$data = explode('<br />', $data);
		$i = 0;
		$query = "INSERT INTO wptt_ip_addresses (`id`,`string`) VALUES ";
		foreach ($data as $val)
		{
			$val = trim($val);
			if (!$val) {
			    continue;
			}
			
			$query .= "('','$val'),";
			
			$i++;
			//$ip_addresses = "Shadowmaker enabled & populated with $i IP Addresses. Last Updated $date .";
			//echo $ip_addresses
		}
		$query = substr( $query , 0 , -1 );
		
		$result = mysql_query($query);
		if (!$result) { echo $query; echo mysql_error(); exit;}	
		
		//print_r($ip_addresses);exit;
		$ip_addresses_array = explode(';',  $wptt_options['ip_addresses']);

		if (is_array($ip_addresses_array))
		{
			foreach ($ip_addresses_array as $val)
			{
				$val = trim($val);
				$query = "INSERT INTO wptt_ip_addresses (`id`,`string`) VALUES ('','$val') ";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); exit;}						
			}
		}
	}


}
//wptt_shadowmaker_update_execute();exit;

function retrieve_shadowmaker_ips($username,$password)
{
	$url = "http://bseolized.com/ipgrabber/getlist.cgi?list=ips&format=json?";
	$ch=curl_init(); 
	curl_setopt($ch, CURLOPT_URL,$url); 
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");  
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
	curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch); 
	curl_close($ch);
	//echo 1; exit;
	return $data;

}

function global_update_spider_settings()
{
	global $table_prefix; 
	global $wptt_options; 
	
	function wptt_empty_test($val) {
		$val - trim($val);
		$val - strip_tags($val);
		if (strlen($val)>5)
			echo $val."<br>";;
	}

	if ($_POST['nature']=='global_save_spider_settings')
	{
		//echo 1; exit;
		$shadowmaker_username = $_POST['shadowmaker_username'];
		$shadowmaker_password = $_POST['shadowmaker_password'];
		
		
		
		$ip_addresses = $_POST['ip_addresses'];
		$ip_addresses = nl2br($ip_addresses);

		$ip_addresses = explode('<br />', $ip_addresses);
		foreach ($ip_addresses as $key=>$val)
		{
			if (strlen($val)<5)
			{
				unset($ip_addresses[$key]);
			}
		}
		//print_r($ip_addresses);exit;
		$ip_addresses_array = $ip_addresses;
		$ip_addresses = implode(';', $ip_addresses);
		
		$useragents = $_POST['useragents'];
		if (!$useragents)
		{
			$useragents = "msie;firefox;safari;webkit;opera;netscape;konqueror;gecko;chrome;songbird;seamonkey;flock;AppleWebKit;Android";
		}
		else
		{
			$useragents =  preg_split("/[\r\n,]+/", $useragents, -1, PREG_SPLIT_NO_EMPTY);
			$useragents = implode(';', $useragents);
		}
		
		if ($shadowmaker_username)
		{
			$query = "TRUNCATE wptt_ip_addresses";
			$result = mysql_query($query);
			if (!$result) { echo $query; echo mysql_error(); exit;}	
			
			$data = retrieve_shadowmaker_ips($shadowmaker_username,$shadowmaker_password);
			if (trim($data)>10)
			{				
				$query = "TRUNCATE wptt_ip_addresses";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); exit;}	
				
				$data = nl2br($data);			
				$data = explode('<br />', $data);
				$i = 0;
				
				$query = "INSERT INTO wptt_ip_addresses (`id`,`string`) VALUES ";
				foreach ($data as $val)
				{
					$val = trim($val);
					if (!$val) {
						continue;
					}					
					$query .= "('','$val'),";
					
					$i++;
				}
				$query = substr( $query , 0 , -1 );	
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); exit;}					
			}
			
			
		}
		
		if (is_array($ip_addresses_array))
		{
			foreach ($ip_addresses_array as $val)
			{
				$val = trim($val);
				$query = "INSERT INTO wptt_ip_addresses (`id`,`string`) VALUES ('','$val') ON DUPLICATE KEY UPDATE string='$val'";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); exit;}						
			}
		}
			
		$wptt_options['useragents'] = $useragents;
		$wptt_options['ip_addresses'] = $ip_addresses;		
		$wptt_options['shadowmaker_username'] = $shadowmaker_username;		
		$wptt_options['shadowmaker_password'] = $shadowmaker_password;		
		
		$wptt_options = json_encode($wptt_options);
		//echo $wptt_options;exit;
		//echo $global_default_classification_prefix;
		$query = "UPDATE {$table_prefix}wptt_wptraffictools_options SET option_value='$wptt_options' WHERE option_name='wptt_options'";
		$result = mysql_query($query);
		if (!$result) { echo $query; echo mysql_error(); exit;}	

	}
}

function wptt_spider_settings()
{
	global $table_prefix; 

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
		$shadowmaker_password = $wptt_options['shadowmaker_password'];
	}
	else
	{
		echo $query; echo mysql_error(); exit;
	}



	//echo $classification_prefix;exit;
	$ip_addresses = explode(';',$ip_addresses);
	$ip_addresses = implode("\r",$ip_addresses);
	$useragents = explode(';',$useragents);
	$useragents = implode("\n",$useragents);

	$query = "SELECT id FROM  wptt_ip_addresses";
	$result = mysql_query($query);
	$count = mysql_num_rows($result);
	//echo $count;exit;
	$shadowmaker_details = "Shadowmaker enabled & populated with $count IP Addresses.";
	?>
	<div class="wrap">
		<div class='wptt_featurebox'>
			<h3>Spider Settings</h3>
				<form name=global id='id_global_form' method="post" action="admin.php?page=wptt_slug_submenu_spider_settings">
				<input type=hidden name='nature' id='id_global_form_nature' value='global_save_spider_settings' >
				<table class='class_global_settings_td'>
					<tr>
						<td colspan=3>
						<i>WP Traffic Tools checks the useragent of each visitor to determine if the visitor is using an acceptible browser. Please define acceptible useragent strings below. In addition to user-agent detection, WP Traffic Tools also checks for browser feature capabilities. If a visitor does not support certain DOM Reading features or AJAX, then WP Traffic Tools will auto-assume it is a spider. This auto-detection service provides greater accuracy in detecting bots. If you want to manually block IP addresses you can do that too.
						</td>
					</tr>
					<tr>
						<td valign=top style='width:332px;'>
							<label for=keyword>
								<div>
									<img src="<?php echo WPTRAFFICTOOLS_URLPATH;; ?>images/tip.png" style="cursor:pointer;" border=0 title="WP Redirect will only redirect traffic containing these keywords in their useragent string. To redirect ALL traffic containing the propper keywords in their referrer then clear this list and add a *.">
									Permissable Useragents
									<br>
									<i> <font style='font-size:9px'>1 per line</font></i>
								</div>
								<br>
								<textarea name='useragents' rows='12' cols='40'><?php echo $useragents; ?></textarea>
							</label>
						</td>
						<td  valign='top'>	
														
										<img src="<?php echo WPTRAFFICTOOLS_URLPATH;; ?>images/tip.png" style="cursor:pointer;" border=0 title="WP Redirect will not redirect any of these IP Addresses. To block ip ranges use wildcards (eg: 156.201.*.*)">
										Additional Spider IP Definitions
										<br>
										<i> <font style='font-size:9px'>1 per line</font></i>
									
									<br><br>
									<textarea name='ip_addresses' rows=12 cols=40><?php echo $ip_addresses; ?></textarea>
									
						</td>
						<td valign='top'>
							<table>
									<tr>
										<td colspan=2>
											<img src="<?php echo WPTRAFFICTOOLS_URLPATH;; ?>images/tip.png" style="cursor:pointer;" border=0 title="Spider IP Detection & Delivery Service provided by http://bseolized.com/. IP list is updated daily. ">
											Shadowmaker IP Delivery Service &nbsp;&nbsp; <br>
											[<small><em><a href='http://bseolized.com/affiliate/idevaffiliate.php?id=102_1' target='_blank' title='WP Traffic Tools customers are provided with 30.00 off the yearly subscription costs. If you are already a member of the Shadow Maker service please contact the administrator for credentials that will work with WP Traffic tools.'>Register Here</a></em></small>]
											<br><br>
										</td>
									</tr>
									<tr>
										<td >
											Username:
										</td>
										<td>
											<input name='shadowmaker_username' value='<?php echo $shadowmaker_username; ?>'>
										</td>
									</tr>
									<tr>
										<td >
											Password:
										</td>
										<td>
											<input type='password' name='shadowmaker_password' value='<?php echo $shadowmaker_password; ?>'>
										</td>
									</tr>
									<tr>
										<td colspan=2>
											<em><?php echo $shadowmaker_details; ?></em>
										</td>
									</tr>
								</table>
						</td>
					</tr>
					<tr>
						<td>
							<button type=submit class='button-secondary' id='id_global_save_settings' name='save_global' value="Save" >Save Spider Settings</button>
						</td>
					</tr>
				</table>
				</form>
			</div>
		</div>
	<?php
}

function wptt_display_spider_settings()
{
	global_update_spider_settings();
	include('wptt_style.php');
	echo "<img src='".WPTRAFFICTOOLS_URLPATH."images/wptt_logo.png'>";
	
	echo "<div id='id_wptt_display' class='class_wptt_display'>";

	echo '<div class="wrap">';

	wptt_spider_settings();
	wptt_display_footer();
	echo '</div>';
	echo '</div>';
}

function wptt_topsearches_settings()
{
	global $table_prefix; 
	
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
		
		$global_topsearches = $wptt_options['topsearches'];
		$global_topsearches_nature = $wptt_options['topsearches_nature'];
		$global_topsearches_header= $wptt_options['topsearches_header'];
		$global_topsearches_footer = $wptt_options['topsearches_footer'];
		$global_topsearches_sort= $wptt_options['topsearches_sort'];
		$global_topsearches_limit = $wptt_options['topsearches_limit'];
		$global_topsearches_link = $wptt_options['topsearches_link'];
		$global_topsearches_display_count = $wptt_options['topsearches_display_count'];
		$global_topsearches_ignore = $wptt_options['topsearches_ignore'];
		$global_topsearches_tags = $wptt_options['topsearches_tags'];
		$global_topsearches_nature_deeplinks = $wptt_options['topsearches_nature_deeplinks'];
	}
	else
	{
		echo $query; echo mysql_error(); exit;
	}


	



	?>
	<div class="wrap">
		<div class='wptt_featurebox'>
			<h3>TopSearches Settings</h3>
				<form name=global id='id_global_form' method="post" action="admin.php?page=wptt_slug_submenu_topsearches">
				<input type=hidden name=nature id='id_global_form_nature' value=global_save_topsearches_settings >
				<table class='class_global_settings_td'>
					<tr>
						<td colspan=2>
						<i>WP Traffic Tools collects keyword data related to organic search engine traffic. We can use the feature settings below to display information related to search engine traffic within our posts. Such as: The last 5 search phrases that were used to find a post, or the top 10 most search keyphrases for the whole site. Use the variable settings below to determine what and how data will be displayed. 
						</td>
					</tr>
					<tr>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="WP Traffic Tools collects incomming search data from google. Use this feature to make incomming search terms to tags. "> 
								Automatically turn searches into tags? 
							</label>
						</td>
						<td>
							<input type=radio  size=67 name='global_topsearches_tags' <?php if ($global_topsearches_tags==1){ echo 'checked="checked"'; } ?> value=1 > Yes &nbsp;&nbsp;&nbsp;&nbsp;
							<input type=radio size=67 name='global_topsearches_tags' <?php if ($global_topsearches_tags!=1){ echo 'checked="checked"'; } ?> value=0 > No 
						</td>
					</tr>
					<tr>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="WP Traffic Tools collects incomming search data from google. Use this feature to add a listing of the top incomming searches to the bottom of your posts. This may help boost performance for these keywords. "> 
								Display TopSearches at bottom of posts?
							</label>
						</td>
						<td>
							<input type=radio  size=67 name='global_topsearches' id='id_ts_1' <?php if ($global_topsearches==1){ echo 'checked="checked"'; } ?> value=1 > Yes &nbsp;&nbsp;&nbsp;&nbsp;
							<input type=radio class='class_select_topsearches' id='id_ts_0' size=67 name='global_topsearches' <?php if ($global_topsearches!=1){ echo 'checked="checked"'; } ?> value=0 > No 
						</td>
					</tr>
					<tr class='class_tr_topsearches_display'>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="Select Top Page Queries to show searches for the opened post, and select Global Queries to display site-wide queries."> 
								Topsearches Nature
							</label>
						</td>
						<td>
							<select type=text  name='global_topsearches_nature' id='id_select_topsearches_nature'>
								<option value='single' <?php if ($global_topsearches_nature=='single'){echo "selected='true'";}?>>Top Page Queries</option>
								<option value='global' <?php if ($global_topsearches_nature=='global'){echo "selected='true'";}?>>Global Queries</option>
							</select>
						</td>	
					</tr>
					<tr class='class_tr_topsearches_display' id='id_global_topsearches_nature_global_deeplinks' style='<?php if ($global_topsearches_nature!='global'){echo "display:none;";}?>'>
						<td>
							
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="Setting this to yes will prevent organic keywords that are associated with the blog's homepage from being included in the list, allowing only links to posts to be included."> 
								Only allow deep links?
							</label>
						</td>
						<td>
							<select type=text  name='global_topsearches_nature_deeplinks' >
								<option value='1' <?php if ($global_topsearches_nature_deeplinks=='1'){echo "selected='true'";}?>>Yes</option>
								<option value='0' <?php if ($global_topsearches_nature_deeplinks=='0'){echo "selected='true'";}?>>No</option>
							</select>
						</td>	
					</tr>
					<tr  class='class_tr_topsearches_display'>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="This content will appear above the listing of topsearches."> 
								Display Header
							</label>
						</td>
						<td>
							<input  class='class_select_topsearches' size=40 name='global_topsearches_header' value='<?php echo $global_topsearches_header; ?>' > 
						</td>
					</tr>
					<tr class='class_tr_topsearches_display'>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="Select Top Page Queries to show searches for the opened post, and select Global Queries to display site-wide queries."> 
								Sorting
							</label>
						</td>
						<td>
							<select type=text  name='global_topsearches_sort'>
								<option value='DESC' <?php if ($global_topsearches_sort=='DESC'){echo "selected='true'";}?>>By Search Count: DESC</option>
								<option value='ASC' <?php if ($global_topsearches_sort=='ASC'){echo "selected='true'";}?>>By Search Count: ASC</option>
								<option value='RAND' <?php if ($global_topsearches_sort=='RAND'){echo "selected='true'";}?>>Randomize</option>
						</select>
						</td>	
					</tr>
					<tr class='class_tr_topsearches_display'>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="Control the number of keywords displayed."> 
								Keyword Limit
							</label>
						</td>
						<td>
							<input class='class_select_topsearches' size=5 name='global_topsearches_limit' value='<?php echo $global_topsearches_limit; ?>' > 
						</td>
					</tr>
					<tr class='class_tr_topsearches_display'>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="Toggle this to yes to turn keywords into links to respective posts. "> 
								Auto-Link Keywords
							</label>
						</td>
						<td>
							<input type=radio size=67 name='global_topsearches_link' <?php if ($global_topsearches_link!=1){ echo 'checked="checked"'; } ?> value=0 > Off &nbsp;&nbsp;&nbsp;&nbsp;
							<input type=radio  size=67 name='global_topsearches_link'  <?php if ($global_topsearches_link==1){ echo 'checked="checked"'; } ?> value=1 > On
						</td>
					</tr>
					<tr class='class_tr_topsearches_display'>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="Toggle this to yes to display # of times each keyword as been searched. "> 
								Display Search Count
							</label>
						</td>
						<td>
							<input type=radio size=67 name='global_topsearches_display_count' <?php if ($global_topsearches_display_count!=1){ echo 'checked="checked"'; } ?> value=0 > Off &nbsp;&nbsp;&nbsp;&nbsp;
							<input type=radio  size=67 name='global_topsearches_display_count'  <?php if ($global_topsearches_display_count==1){ echo 'checked="checked"'; } ?> value=1 > On
						</td>
					</tr>
					<tr class='class_tr_topsearches_display'>
						<td>
							<label for=keyword>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH ?>images/tip.png" style="cursor:pointer;" border=0 title="Insert Post IDs to ignore the placement of the Top Searches Feature. Separate Ids with commas."> 
								Ignore the following Post IDs
							</label>
						</td>
						<td>
						<input class='class_select_topsearches' size=5 name='global_topsearches_ignore' value='<?php echo $global_topsearches_ignore; ?>' > 
						</td>
					</tr>
					<tr>
						<td>
							<button type=submit class='button-secondary' id='id_global_save_settings' name='save_global' value="Save" >Save TopSearches Settings</button>
						</td>
					</tr>
				</table>
				</form>
		</div>
	</div>
	<?php
}

function wptt_display_topsearches()
{
	global_update_topsearches_settings();
	traffic_tools_javascript();
	traffic_tools_update_check();
	global_add_javascript();
	include('wptt_style.php');
	echo "<img src='".WPTRAFFICTOOLS_URLPATH."images/wptt_logo.png'>";
	
	echo "<div id='id_wptt_display' class='class_wptt_display'>";

	echo '<div class="wrap">';

	wptt_topsearches_settings();
	wptt_display_footer();
	echo '</div>';
	echo '</div>';
}

function traffic_str_replace_once($remove , $replace , $string)
{
    //$remove = str_replace('/','\/',$remove);
    $return = preg_replace('/'.preg_quote($remove,'/').'/', $replace, $string, 1); 
	if (!$return)
	{
		echo "traffic_str_replace_once fail"; exit;
		echo "<br><br> Here is the string:<br><br>$string";  EXIT;
	}
    return $return;
}  

function traffic_get_string_between($string, $start, $end) 
{
	if (strstr($start,'%wildcard%'))
	{
		$start = str_replace("%wildcard%", ".*?", preg_quote($start, "/"));
	}
	else
	{
		$start = preg_quote($start, "/");
	}
	if (strstr($end,'%wildcard%'))
	{
		$end = str_replace("%wildcard%", ".*?", preg_quote($end, "/"));
	}
	else
	{
		//echo $end;exit;
		$end = preg_quote($end, "/");
		//echo $end; exit;
	}
    $regex = "/$start(.*?)$end/si";

	
    if (preg_match($regex, $string, $matches))
        return $matches[1];
    else
        return false;
}

function global_cloak_links($content, $nofollow, $redirect_spider, $global_mask_links, $global_mask_link_profiles)
{
	global $table_prefix;
	global $wordpress_url;
	$short_wordpress_url = str_replace('http://www.','',$wordpress_url);	
	global $global_default_classificatin_prefix;
	global $global_cloak_exceptions;
	global $global_cloak_patterns;
	
	$exceptions =  preg_split("/[\r\n,]+/", $global_cloak_exceptions, -1, PREG_SPLIT_NO_EMPTY);
	
	if ($nofollow==1)
	{
		$nofollow = 'rel="nofollow"';
	}
	else
	{
		$nofollow = "";
	}
	
	if ($global_mask_links==2)
	{
		if ($_COOKIE['wpttcheck']==1)
		{
			$global_mask_links=1;
		}
		else
		{
			//check to see if this is a spider
			/* Retrieve the global settings */ 
			$query = "SELECT `option_value` FROM {$table_prefix}wptt_wptraffictools_options  ORDER BY id ASC";
			$result = mysql_query($query);
			if (!$result){echo $query; echo mysql_error(); exit;}
			$count = mysql_num_rows($result);

			for ($i=0;$i<$count;$i++)
			{
			  $arr = mysql_fetch_array($result);
			  if ($i==0){$useragents =$arr['option_value'];}
			  if ($i==1){$ip_addresses =$arr['option_value'];}
			}

			$useragents = explode(';', $useragents);
			$ip_addresses = explode(';', $ip_addresses);

			$visitor_useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
			$visitor_ip = $_SERVER['REMOTE_ADDR'];
			
			$global_mask_links=1;
			//check to make sure useragent is present
			foreach ($useragents as $k=>$v)
			{
				
				$v = trim($v);
				if(strstr($visitor_useragent, $v))
				{
					$global_mask_links=2;
				}
				
			}
		}
	}

	if ($global_mask_links==1)
	{
	
		$url_count = substr_count($content, "<a ");
		$urls = array();
		$anchors = array();
		$replacement_urls = array();
		
		$content  = str_replace('= "','="',$content);
		$content  = str_replace("= '","='",$content);
		
		for ($ic = 0; $ic < $url_count; $ic++) 
		{
			$link_html = traffic_get_string_between($content, '<a ', '</a>');
			//echo $link_html;exit;
			//determine urls
			if (!strstr($link_html, 'href="'))
			{		
				//echo '8'.$content; exit;	
			   $url_start = "href='";
			   $url_end = "'";
			}
			else
			{
				//echo '9'.$content; exit;	
				$url_start = 'href="';
				$url_end = '"';
			}
			
			
			$url = traffic_get_string_between($link_html, $url_start, $url_end);
			$remove = "$url_start$url$url_end";				
			$content = traffic_str_replace_once("<a {$link_html}</a>", "url[$ic]", $content);	
			$anchor = traffic_get_string_between($link_html.'</a>', '>', '</a>');
			$anchors[$ic] = $anchor;
			
			
			$link_html  = str_replace($remove,' ',$link_html);
			$link_html = explode('>',$link_html);
			$link_extras[$ic] = $link_html[0];
			
			
			//echo $url;
			//echo "<br>";
			$stop=0;
			foreach ($exceptions as $k=>$v)
			{
				//echo $v;
				if (strstr($url,$v))
				{
					$stop=1;
				}
			}
			
			if (strlen($global_cloak_patterns)>3)
			{
				$i = 0;
				$patterns =  preg_split("/[\r\n,]+/", $global_cloak_patterns, -1, PREG_SPLIT_NO_EMPTY);
				$total_lines = count($patterns);
					
				foreach ($patterns as $k=>$v)
				{
					
					if (!strstr($url,$v))
					{
						$i++;
					}
				}
				
				if ($i==$total_lines)
				{
					$stop=1;
				}	
			}
			
			if (($url&&!strstr($url,$short_wordpress_url)&&$stop!=1)||($url&&strstr($url,'wp-content')&&$stop!=1))
			{
				//echo $anchor;exit;
				$url = str_replace(array('&amp;','&#38;','&#038;'), '&', $url);
				//set original url into array
				$urls[] = $url;
				
				//determine if there is a pretty link for this url
				//get affiliate url
				
				//echo $url;exit;
				$query = "SELECT * FROM {$table_prefix}wptt_cloakme_profiles WHERE redirect_url='".addslashes($url)."' LIMIT 1";
				$result = mysql_query($query);
				if (!$result){echo $query; echo mysql_error(); exit;}
				$count = mysql_num_rows($result);
				
				if ($count>0)
				{					
					$arr = mysql_fetch_array($result);
					$cloaked_url = $arr['cloaked_url'];
					$permalink = $arr['permalink'];
					$replacement_urls[] = $cloaked_url;
					//echo $cloaked_url;exit;
				}
				else
				{	
					
					if (strstr($anchor, 'alt='))
					{
						$anchor =str_replace("'",'"',$anchor);
						$anchor = traffic_get_string_between($anchor,'alt="', '"');
						$anchor = sanitize_title_with_dashes($anchor);
						$secret_phrase ="0123456789";
						$ref = str_shuffle($secret_phrase);
						$ref = substr($ref, 0, 4);							
						$anchor =  $anchor.'-'.$ref;
					}
					else if (strstr($anchor, '<img'))
					{
						$secret_phrase ="0123456789";
						$ref = str_shuffle($secret_phrase);
						$ref = substr($ref, 0, 4);
						$anchor = $url;
						$anchor = str_replace('http://','',$anchor);
						$anchor = str_replace('www.','',$anchor);
						$anchor = explode('.',$anchor);						
						$anchor =  $anchor[0].'-'.$ref;
					}
					else
					{					
						$anchor = sanitize_title_with_dashes( $anchor );
					}
					if (strstr($anchor, 'http'))
					{
						$secret_phrase ="0123456789";
						$ref = str_shuffle($secret_phrase);
						$ref = substr($ref, 0, 4);
						$anchor = str_replace('http-','',$anchor);
						$anchor = str_replace('httpwww-','',$anchor);
						$anchor = str_replace('http','',$anchor);
						$anchor = explode('-',$anchor);
						$anchor =  $anchor[0].'-'.$ref;
					}
					if (!$anchor)
					{
						$secret_phrase ="linkcloakingwptraffictools0123456789";
						$ref = str_shuffle($secret_phrase);
						$anchor = substr($ref, 0, 7);
					}
					$anchor = addslashes($anchor);
					$replacement_urls[$ic] = $wordpress_url."$global_default_classificatin_prefix/$anchor";
					$cloaked_link = $wordpress_url."$global_default_classificatin_prefix/$anchor";
					$url = addslashes($url);
					
					//set cloaking data into tables
					$query = "INSERT INTO {$table_prefix}wptt_cloakme_profiles (`id`,`classification_prefix`,`permalink`,`cloaked_url`,`redirect_url`,`blank_referrer`,`redirect_spider`,`redirect_method`,`redirect_type`,`cloak_target`,`visitor_count`,`spider_count`,`type`)";
					$query .= "VALUES ('','$global_default_classificatin_prefix','$anchor','$cloaked_link','$url','0','$redirect_spider','none','307','0','0','0','global')";
					$result = mysql_query($query);
					if (!$result) 
					{
						//echo 2;exit;				//create unique reference id
						$secret_phrase ="abcsdefghijklmnopqrstuvwxyz0123456789";
						$ref = str_shuffle($secret_phrase);
						$ref = substr($ref, 0, 4);
						$replacement_urls[$ic] = $wordpress_url."$global_default_classificatin_prefix/{$ref}-{$anchor}";
						
						$cloaked_link = $wordpress_url."$global_default_classificatin_prefix/{$ref}-{$anchor}";
						//set cloaking data into tables
						$query = "INSERT INTO {$table_prefix}wptt_cloakme_profiles (`id`,`classification_prefix`,`permalink`,`cloaked_url`,`redirect_url`,`blank_referrer`,`redirect_spider`,`redirect_method`,`redirect_type`,`cloak_target`,`visitor_count`,`spider_count`,`type`)";
						$query .= "VALUES ('','$global_default_classificatin_prefix','{$ref}-{$anchor}','$cloaked_link','$url','0','$redirect_spider','none','307','0','0','0','global')";
						$result = mysql_query($query);
						if (!$result){ echo $query; echo mysql_error(); exit;}
					}
					
				}	
				$replcacement_is_exception[] = 0;
			}
			else
			{
				$replacement_urls[] = $url;
				$replcacement_is_exception[] = 1;
				
			}			
		}
		
		///exit;
		if ($replacement_urls)
		{
			foreach($replacement_urls as $key =>$value) 
			{
				if (post_permalink($value)||$replcacement_is_exception[$key] == 1)
				{
					$this_nofollow = "";
					$this_target = "";
				}
				else
				{
					$this_nofollow = $nofollow;
					$this_target = "target='_blank'";
				}
				//replace url with cloaked url
				$content = traffic_str_replace_once("url[$key]", "<a href='$value' $this_nofollow $this_target $link_extras[$key]>$anchors[$key]</a>", $content);
			}
		}
	}
	
	if ($global_mask_link_profiles==1&&$global_mask_links!=1)
	{
		//echo 1; exit;
		$url_count = substr_count($content, "<a");
		$urls = array();
		$replacement_urls = array();
		
		for ($ic = 0; $ic < $url_count; $ic++) 
		{
			//echo $content; exit;		
			//determine urls
			if (!strstr($content, 'href="'))
			{		
			   $start = "href='";
			   $end = "'";
			}
			else
			{
				$start = 'href="';
				$end = '"';
			}
		
			$url = traffic_get_string_between($content, $start, $end);
			$remove = "$start$url$end";
			//replace with temp marker					
			$content = traffic_str_replace_once($remove, "url[$ic]", $content);		
						
			//set original url into array
			$urls[] = $url;
			
			$stop=0;
			foreach ($exceptions as $k=>$v)
			{
				if (strstr($url,$v))
				{
					$stop=1;
				}
			}
			
			if (strlen($global_cloak_patterns)>3)
			{
				$i = 0;
				$patterns =  preg_split("/[\r\n,]+/", $global_cloak_patterns, -1, PREG_SPLIT_NO_EMPTY);
				$total_lines = count($patterns);
					
				foreach ($patterns as $k=>$v)
				{
					
					if (!strstr($url,$v))
					{
						$i++;
					}
				}
				
				if ($i==$total_lines)
				{
					$stop=1;
				}	
			}
			
			if ($url&&!strstr($url,$short_wordpress_url)&&$stop!=1)
			{
				
				
				$query = "SELECT * FROM {$table_prefix}wptt_cloakme_profiles WHERE redirect_url='".addslashes($url)."' AND type='affiliate' LIMIT 1";
				$result = mysql_query($query);
				if (!$result){echo $query; echo mysql_error(); exit;}
				$count = mysql_num_rows($result);
				
				if ($count>0)
				{

					$arr = mysql_fetch_array($result);
					$cloaked_url = $arr['cloaked_url'];
					$permalink = $arr['permalink'];
					$replacement_urls[] = $cloaked_url;
					//echo $cloaked_url;exit;
				}
				else
				{	
					//echo 2;exit;				//create unique reference id
					$secret_phrase ="linkcloakingwptraffictools1234567890";
					$ref = str_shuffle($secret_phrase);
					$ref = substr($ref, 0, 9);
					$replacement_urls[] = $url;					
				}	
				$replcacement_is_exception[] = 0;
			}
			else
			{
				$replacement_urls[] = $url;	
				$replcacement_is_exception[] = 1;
			}
		}
		
		if ($replacement_urls)
		{
			foreach($replacement_urls as $key =>$value) 
			{
				if (post_permalink($value)||$replcacement_is_exception[$key] == 1)
				{
					$this_nofollow = "";
				}
				else
				{
					$this_nofollow = $nofollow;
				}
				//replace url with cloaked url
				$content = traffic_str_replace_once("url[$key]", "href='$value' $this_nofollow", $content);
			}
		}
	}
	//echo 1;exit;
    //echo $content; exit;
    return $content;

}

function global_cloak_links_filter($content)
{

	global $table_prefix;
	global $useragents;
	global $ip_addresses;
	global $global_mask_links;
	global $global_mask_links_pages;
	global $global_redirect_spiders;
	global $global_nofollow_links;
	global $global_mask_link_profiles;
	global $global_keyword_affects;
	
	
	
	
	
	//echo is_page();exit;
	//echo $global_mask_links_pages;exit;
	if ((is_page())&&$global_mask_links_pages==1)
	{
		//echo 1; exit;
	}
	else
	{
		//echo 1;exit;
		//echo $global_mask_link_profiles;exit;
		if ($global_mask_links==1||$global_mask_link_profiles==1)
		{
			//echo 1;exit;
			$content = global_cloak_links($content, $global_nofollow_links, $global_redirect_spiders, $global_mask_links,$global_mask_link_profiles);
			
		}
		
		if ($global_keyword_affects!=1)
		{
			
			//prepare auto-link keyword profiles
			$query = "SELECT id,cloaked_url,redirect_url,keywords,keywords_affect,attributes,keywords_limit, keywords_limit_total,keywords_target_page,link_masking FROM {$table_prefix}wptt_cloakme_profiles WHERE keywords_affect>0";
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
					$cloaked_url = $arr['cloaked_url'];
					$link_masking = $arr['link_masking'];
					if ($link_masking==0)
					{
						$cloaked_url = $arr['redirect_url'];
					}
					
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
									$content = preg_replace("/(?<!_)(?<!-)(?<!\/)(?<!\.)\b$keywords[$key]\b(?!(.*?)\<\/h\d>)/i"," <a href='{$cloaked_url}' target='$target' $attributes >$keywords[$key]</a>", $content , $limit);
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
									$content = preg_replace("/(?<!_)(?<!-)(?<!\/)(?<!\>)(?<!')(?<!\.)\b$keywords[$key]\b(?!(.*?)\<\/h\d>)/i","<a href='{$cloaked_url}' rel='nofollow' target='$target'  $attributes >$keywords[$key]</a>", $content , $limit);
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
									$content = preg_replace("/(?<!_)(?<!-)(?<!\/)(?<!\>)(?<!')(?<!\.)\b$keywords[$key]\b(?!(.*?)\<\/h\d>)/","<a href='{$cloaked_url}' target='$target'  $attributes >$keywords[$key]</a>", $content , $limit);
									$i++;
									$c++;
								}
							}
							if ($affect==4)
							{
								if (strstr($content,$keywords[$key])&&$i<=$limit_total)
								{
									$content = preg_replace("/(?<!_)(?<!-)(?<!\/)(?<!\>)(?<!')(?<!\.)\b$keywords[$key]\b(?!(.*?)\<\/h\d>)/s","<a href='{$cloaked_url}' rel='nofollow' target='$target'  $attributes >$keywords[$key]</a>", $content , $limit);
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
			
			
			
		}
		
		
	}
	
	//echo $content;exit;
	//re-insert imgs	
	
	//echo $content;exit;
	
	
	//echo $content;exit;
	
	return $content;
}

function global_cloak_comments_filter($content)
{
	global $table_prefix;
	global $wordpress_url;
	$short_wordpress_url = str_replace('http://www.','',$wordpress_url);
	global $useragents;
	global $ip_addresses;
	global $global_redirect_spiders;
	global $global_nofollow_links;
	global $global_mask_link_profiles;
	global $global_keyword_affects;
	
	$url_count = substr_count($content, "<a");
	$urls = array();
	$replacement_urls = array();
	
	for ($ic = 0; $ic < $url_count; $ic++) 
	{
		//echo $content; exit;		
		//determine urls
		if (!strstr($content, 'href="'))
		{		
		   $start = "href='";
		   $end = "'";
		}
		else
		{
			$start = 'href="';
			$end = '"';
		}
	
		$url = traffic_get_string_between($content, $start, $end);
		$remove = "$start$url$end";
		
		if ($url&&!strstr($url,$short_wordpress_url))
		{
			//replace with temp marker					
			$content = traffic_str_replace_once($remove, "url[$ic]", $content);		
						
			//set original url into array
			$urls[] = $url;
			
			//determine if there is a pretty link for this url
			//get affiliate url
			
			
			$query = "SELECT * FROM {$table_prefix}wptt_cloakme_profiles WHERE redirect_url='$url' LIMIT 1";
			$result = mysql_query($query);
			if (!$result){echo $query; echo mysql_error(); exit;}
			$count = mysql_num_rows($result);
			
			if ($count>0)
			{

				$arr = mysql_fetch_array($result);
				$cloaked_url = $arr['cloaked_url'];
				$permalink = $arr['permalink'];
				$replacement_urls[] = $cloaked_url;
				//echo $cloaked_url;exit;
			}
			else
			{	
				
				//echo 2;exit;				//create unique reference id
				$secret_phrase ="linkcloakingwptraffictools1234567890";
				$ref = str_shuffle($secret_phrase);
				$ref = substr($ref, 0, 9);
				$replacement_urls[] = $wordpress_url."go/$ref";
				$cloaked_link = $wordpress_url."go/$ref";
				
				//set cloaking data into tables
				$query = "INSERT INTO {$table_prefix}wptt_cloakme_profiles (`id`,`classification_prefix`,`permalink`,`cloaked_url`,`redirect_url`,`blank_referrer`,`redirect_spider`,`redirect_method`,`redirect_type`,`cloak_target`,`visitor_count`,`spider_count`,`type`)";
				$query .= "VALUES ('','go','$ref','$cloaked_link','$url','0','$redirect_spider','none','301','0','0','0','global')";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); }
				
			}			
		}	
	}
	
	if ($replacement_urls)
	{
		foreach($replacement_urls as $key =>$value) 
		{
			if (post_permalink($value))
			{
				$this_nofollow = "";
			}
			else
			{
				$this_nofollow = $nofollow;
			}
			
			//replace url with cloaked url
			$content = traffic_str_replace_once("url[$key]", "href='$value' $this_nofollow", $content);
		}
	}
	return $content;
}

function global_cloak_commenter_filter($url)
{
	global $table_prefix;
	global $useragents;
	global $ip_addresses;
	global $global_mask_links;
	global $global_redirect_spiders;
	global $global_nofollow_links;
	global $global_mask_link_profiles;
	global $global_keyword_affects;
	global $global_cloak_comments;
	global $wordpress_url;
	$short_wordpress_url = str_replace('http://www.','',$wordpress_url);
	
		
	$query = "SELECT * FROM {$table_prefix}wptt_cloakme_profiles WHERE redirect_url='$url' LIMIT 1";
	$result = mysql_query($query);
	if (!$result){echo $query; echo mysql_error(); exit;}
	$count = mysql_num_rows($result);
			
	if ($count>0)
	{

		$arr = mysql_fetch_array($result);
		$cloaked_url = $arr['cloaked_url'];
		$permalink = $arr['permalink'];
		//echo $cloaked_url;exit;
	}
	else
	{	
		//echo 2;exit;				//create unique reference id
		$secret_phrase ="linkcloakingwptraffictools1234567890";
		$ref = str_shuffle($secret_phrase);
		$ref = substr($ref, 0, 9);
		$cloaked_url = $wordpress_url."go/$ref";
		
		//set cloaking data into tables
		$query = "INSERT INTO {$table_prefix}wptt_cloakme_profiles (`id`,`classification_prefix`,`permalink`,`cloaked_url`,`redirect_url`,`blank_referrer`,`redirect_spider`,`redirect_method`,`redirect_type`,`cloak_target`,`visitor_count`,`spider_count`,`type`)";
		$query .= "VALUES ('','go','$ref','$cloaked_url','$url','0','$redirect_spider','none','301','0','0','0','global')";
		$result = mysql_query($query);
		if (!$result) { echo $query; echo mysql_error(); }
		
	}	
	$url = $cloaked_url;
		
	return $url;
}

function wpt_add_top_searches($content)
{

	global $global_topsearches_nature;
	global $global_topsearches_nature_deeplinks;
	global $global_topsearches_header;
	global $global_topsearches_sort;
	global $global_topsearches_limit;
	global $global_topsearches_link;
	global $global_topsearches_display_count;
	global $global_topsearches_ignore;
	//echo 1;
	//echo $global_topsearches_link;exit;
	$topsearches = "[wpttopsearches:$global_topsearches_nature:$global_topsearches_nature_deeplinks:$global_topsearches_sort:$global_topsearches_limit:$global_topsearches_link:$global_topsearches_display_count:$global_topsearches_ignore]";
	$content = $content."<br><br>$topsearches";
	return $content;
}

function wptt_display_top_searches()
{

	global $global_topsearches_nature;
	global $global_topsearches_nature_deeplinks;
	global $global_topsearches_header;
	global $global_topsearches_sort;
	global $global_topsearches_limit;
	global $global_topsearches_link;
	global $global_topsearches_display_count;
	global $global_topsearches_ignore;
	//echo 1;
	

	$ignore = $global_topsearches_ignore;
	$ignore_array = explode(',',$ignore);
	
	//echo $ignore;exit;
	//echo $global_topsearches_link;exit;
	
	switch ($global_topsearches_sort){
	case 'ASC':
		$sort = 'count ASC';
		break;
	case 'DESC':
		$sort = 'count DESC';
		break;
	case 'RAND':
		$sort = 'RAND()';
		break;
	}
	
	//echo $sort;exit;
	if ($global_topsearches_nature=='single'&&!in_array($post_id,$ignore_array))
	{
		$query = "SELECT * FROM  {$table_prefix}wptt_wptraffictools_google WHERE post_id='$post_id' AND keyword NOT LIKE '%\"%'  AND keyword NOT LIKE '%22' ORDER BY $sort LIMIT $global_topsearches_limit";
		$result = mysql_query($query);
		$i=0;
		
		
		
		if (mysql_num_rows($result)>0)
		{
			if ($header_nature=='widget'){$global_topsearches_header =''; }
			$content = "$global_topsearches_header <ul class='topsearches'>";
		
			while(($arr = mysql_fetch_array($result))&&$i<$global_topsearches_limit)
			{
				$keyword = $arr['keyword'];
				$keyword = urldecode($keyword);	
				
				$count = $arr['count'];
				
				if ($global_topsearches_display_count==1&&$global_topsearches_link==1)
				{
					$content .="<li><a href='$current_url'>$keyword ($count)</a></li>";
				}
				else if ($global_topsearches_display_count==1&&$global_topsearches_link!=1)
				{
					$content .="<li>$keyword ($count)</li>";
				}
				else if ($global_topsearches_display_count!=1&&$global_topsearches_link==1)
				{
					$content .="<li><a href='$current_url'>$keyword</a></li>";
				}
				else 
				{
					$keyword = str_replace("'", '"',$keyword);							
					$content .="<li>$keyword</li>";
				}
				
				$i++;
			}
			$content .="</ul>";
		}
	}
	
	if ($global_topsearches_nature=='global'&&!in_array($post_id,$ignore_array))
	{
		//echo 1; exit;
		if ($global_topsearches_nature_deeplinks==1)
		{
			$query = "SELECT * FROM  {$table_prefix}wptt_wptraffictools_google WHERE permalink!='' AND keyword NOT LIKE '%\"' AND keyword NOT LIKE '%22' ORDER BY $sort LIMIT $global_topsearches_limit";
		}
		else
		{
			$query = "SELECT * FROM  {$table_prefix}wptt_wptraffictools_google WHERE permalink!='' && permalink!='{$wordpress_url}' && permalink NOT LIKE'{$wordpress_url}?%' && keyword NOT LIKE '%\"' ORDER BY $sort LIMIT $global_topsearches_limit";
		}
		$result = mysql_query($query);
		$i=0;
		
		if (mysql_num_rows($result)>0)
		{
			if ($header_nature=='widget'){$global_topsearches_header =''; }
			$content = "$global_topsearches_header <ul class='topsearches'>";
		
			while(($arr = mysql_fetch_array($result))&&$i<$global_topsearches_limit)
			{
				$keyword = $arr['keyword'];
				$keyword = urldecode($keyword);	
				$count = $arr['count'];
				$permalink = $arr['permalink'];
				
				if ($global_topsearches_display_count==1&&$global_topsearches_link==1)
				{
					$content .="<li><a href='$permalink' target='self'>$keyword ($count)</a></li>";
				}
				else if ($global_topsearches_display_count==1&&$global_topsearches_link!=1)
				{
					$content .="<li>$keyword ($count)</li>";
				}
				else if ($global_topsearches_display_count!=1&&$global_topsearches_link==1)
				{
					$content .="<li><a href='$permalink' target='self'>$keyword</a></li>";
				}
				else 
				{
					$content .="<li>$keyword</li>";
				}
				
				$i++;
			}
			$content .="</ul>";
		}
	}

	//echo $content;exit;
	return $content;
}


function wpt_top_searches($content,$header_nature=NULL)
{

	global $global_topsearches_header;
	global $wordpress_url;
	
	if (strpos($content, 'wpttopsearches:'))
	{
		global $current_url;
		global $table_prefix;
		$post_id = url_to_postid($current_url);
		if (!$post_id){	$post_id = wptt_url_to_postid($this_referrer); }
		
		//echo $content;exit;
		
		preg_match_all('/wpttopsearches:(.*?)\]/',$content, $matches);
		$params  = explode(':',$matches[1][0]);
		//print_r($params);
		//print_r($params);exit;
		$nature = $params[0];
		$nature_deeplinks = $params[1];
		$sort = $params[2];
		$limit = $params[3];
		$link = $params[4];
		$count_display = $params[5];
		$ignore = $params[6];
		$ignore_array = explode(',',$ignore);
		
		//echo $ignore;exit;
		//echo $link;exit;
		
		switch ($sort){
		case 'ASC':
			$sort = 'count ASC';
			break;
		case 'DESC':
			$sort = 'count DESC';
			break;
		case 'RAND':
			$sort = 'RAND()';
			break;
		}
		
		//echo $sort;exit;
		if ($nature=='single'&&!in_array($post_id,$ignore_array))
		{
			$query = "SELECT * FROM  {$table_prefix}wptt_wptraffictools_google WHERE post_id='$post_id' AND keyword NOT LIKE '%\"%'  AND keyword NOT LIKE '%22' ORDER BY $sort LIMIT $limit";
			$result = mysql_query($query);
			$i=0;
			
			
			
			if (mysql_num_rows($result)>0)
			{
				if ($header_nature=='widget'){$global_topsearches_header =''; }
				$replace = "$global_topsearches_header <ul class='topsearches'>";
			
				while(($arr = mysql_fetch_array($result))&&$i<$limit)
				{
					$keyword = $arr['keyword'];
					$keyword = urldecode($keyword);	
					
					$count = $arr['count'];
					
					if ($count_display==1&&$link==1)
					{
						$replace .="<li><a href='$current_url'>$keyword ($count)</a></li>";
					}
					else if ($count_display==1&&$link!=1)
					{
						$replace .="<li>$keyword ($count)</li>";
					}
					else if ($count_display!=1&&$link==1)
					{
						$replace .="<li><a href='$current_url'>$keyword</a></li>";
					}
					else 
					{
						$keyword = str_replace("'", '"',$keyword);							
						$replace .="<li>$keyword</li>";
					}
					
					$i++;
				}
				$replace .="</ul>";
			}
		}
		
		if ($nature=='global'&&!in_array($post_id,$ignore_array))
		{
			//echo 1; exit;
			if ($nature_deeplinks==1)
			{
				$query = "SELECT * FROM  {$table_prefix}wptt_wptraffictools_google WHERE permalink!='' AND keyword NOT LIKE '%\"' AND keyword NOT LIKE '%22' ORDER BY $sort LIMIT $limit";
			}
			else
			{
				$query = "SELECT * FROM  {$table_prefix}wptt_wptraffictools_google WHERE permalink!='' && permalink!='{$wordpress_url}' && permalink NOT LIKE'{$wordpress_url}?%' && keyword NOT LIKE '%\"' ORDER BY $sort LIMIT $limit";
			}
			$result = mysql_query($query);
			$i=0;
			
			if (mysql_num_rows($result)>0)
			{
				if ($header_nature=='widget'){$global_topsearches_header =''; }
				$replace = "$global_topsearches_header <ul class='topsearches'>";
			
				while(($arr = mysql_fetch_array($result))&&$i<$limit)
				{
					$keyword = $arr['keyword'];
					$keyword = urldecode($keyword);	
					$count = $arr['count'];
					$permalink = $arr['permalink'];
					
					if ($count_display==1&&$link==1)
					{
						$replace .="<li><a href='$permalink' target='self'>$keyword ($count)</a></li>";
					}
					else if ($count_display==1&&$link!=1)
					{
						$replace .="<li>$keyword ($count)</li>";
					}
					else if ($count_display!=1&&$link==1)
					{
						$replace .="<li><a href='$permalink' target='self'>$keyword</a></li>";
					}
					else 
					{
						$replace .="<li>$keyword</li>";
					}
					
					$i++;
				}
				$replace .="</ul>";
			}
		}
		//echo $replace;exit;
		//echo $content;exit;
		$content =  preg_replace('/\[wpttopsearches:(.*?)\]/',$replace, $content);
		//echo $content;exit;
	}
	return $content;
}

if ($global_topsearches==1)
{
	add_filter('the_content','wpt_add_top_searches');
}

add_filter('the_content', 'wpt_top_searches');
add_filter('widget_text', 'wpt_top_searches');


if ($pm[0]==1)
{
	add_filter('the_excerpt', 'global_cloak_links_filter', 20 );
	add_filter('the_content', 'global_cloak_links_filter', 20 );
	add_filter('the_content_rss', 'global_cloak_links_filter', 10);

	if ($global_cloak_text_widgets==1)
	{
		add_filter('widget_text', 'global_cloak_links_filter', 20 );
	}
	if ($global_cloak_header_area==1)
	{
		add_filter('wp_head', 'global_cloak_links_filter', 20 );
	}
	if ($global_cloak_footer_area==1)
	{
		add_filter('wp_footer', 'global_cloak_links_filter', 20 );
	}
	if ($global_cloak_commenter_url==1)
	{
		add_filter('get_comment_author_url_link', 'global_cloak_commenter_filter');
	}

	if ($global_cloak_comments==1)
	{
		add_filter('comment_text', 'global_cloak_comments_filter');
		add_filter('comment_text_rss', 'global_cloak_comments_filter');
	}
}
?>