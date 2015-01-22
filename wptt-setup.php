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

		include('wptt_style.php');
		echo "<img src='".WPTRAFFICTOOLS_URLPATH."images/wptt_logo.png'>";
		
		echo "<div id='id_wptt_display' class='class_wptt_display'>";
	
		echo '<div class="wrap">';

		echo "<h2>Module Activation & Optimization</h2>";
		wptt_setup_settings();			
		wptt_display_footer();
		echo '</div>';
		echo '</div>';
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

			//echo $return;exit;
			$return = json_decode($return,true);
			//print_r($return);
			$rp = '1.1.1.1.1.1.1';
			//echo $rp;exit;
			$rp = explode(".",$rp);
		
		}
		else
		{
			echo $query; echo mysql_error(); exit;
		}
 
		?>

		<div class='wptt_featurebox'>
		
			<div width='100%' style='font-size:10px;'>
			<i>				
				Disabling unused modules will save bandwidth and resources! You can also use this section to purchase our additional modules. Each module has it's very own specialty and can help you to monetize your traffic. Module privledges are internet wide and can be used on all your blogs.
			</i>
			</div>
			<br>
			
			<form method="post" action="?page=wp-traffic-tools/wp-traffic-tools.php&tab_display=1">
			<input type="hidden" name="this_action" value="wptt_permissions_update" />
			
			
			<table class="form-table">
			
				<tr valign="top">
					<th scope="row">Enable Links Module?<br/></th>
					<td valign=top>   
					<?php
					   
					   if ($rp[0]==1)
					   {
							?>
							<input type="checkbox" name="wptt_link_module" value='1' <?php if ($pm[0]==1){ echo "checked='true'"; }?> > &nbsp;<font color='green'><b>AVAILABLE</b></font>
							<?php
						}
						else if ($rp[0]==2)
					    {
							?>
							<input type="checkbox" name="wptt_link_module" value='1' <?php if ($pm[0]==1){ echo "checked='true'"; }?> > &nbsp;<font color='#ED9A47'><b>LIMITED</b></font>
							&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;<a href="http://www.hatnohat.com/api/wp-traffic-tools/upgrade.php?module=1&key=<?php echo $global_wptt; ?>" target='blank' title='Purchase this module for $<?php echo $return['1']; ?>'><img src='<?php echo  WPTRAFFICTOOLS_URLPATH; ?>images/paypal-transparent-logo.png' align='ABSMIDDLE' border=0></a>
							
							<?php
						}
						else
						{
							?>
							<input type="checkbox" name="wptt_link_module" value='1' <?php if ($pm[0]==1){ echo "checked='true'"; }?> > &nbsp;<font color='RED'><b>DISABLED</b></font>
							&nbsp; &nbsp;<a href="http://www.hatnohat.com/api/wp-traffic-tools/upgrade.php?module=1&key=<?php echo $global_wptt; ?>" target='blank' title='Purchase this module for $<?php echo $return['1']; ?>'><img src='<?php echo  WPTRAFFICTOOLS_URLPATH; ?>images/paypal-transparent-logo.png' align='ABSMIDDLE' border=0></a>	
							<?php
						}
						?>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row">Enable Redirection Module?<br/></th>
					<td>   
					<?php
					   
					   if ($rp[1]==1)
					   {
							?>
							<input type="checkbox" name="wptt_redirection_module" value='1' <?php if ($pm[1]==1){ echo "checked='true'"; }?> >  &nbsp;<font color='green'><b>AVAILABLE</b></font>
							<?php
						}
						else
						{
							?><input type="checkbox" name="wptt_redirection_module" value='1' <?php if ($pm[1]==1){ echo "checked='true'"; }?> > &nbsp;<font color='RED'><b>DISABLED</b></font>
							&nbsp; &nbsp;<a href="http://www.hatnohat.com/api/wp-traffic-tools/upgrade.php?module=2&key=<?php echo $global_wptt; ?>" target='blank' title='Purchase this module for $<?php echo $return['2']; ?>'><img src='<?php echo  WPTRAFFICTOOLS_URLPATH; ?>images/paypal-transparent-logo.png' align='ABSMIDDLE' border=0></a>
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
	
?>