<?php
include_once('./../../../wp-config.php');

if ($_GET['data']=='affiliate_profiles')
{
	if ($_GET['type']=='global')
	{
		$input_name = "global";
	}
	else
	{
		$input_name = "post";
	}
	
	$query = "SELECT * FROM {$table_prefix}wptt_wpcookie_affiliate_profiles ";
	$result = mysql_query($query);
	if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
	while ($arr = mysql_fetch_array($result))
	{
		$cookie_affiliate_profile_id[] = $arr['id'];
		$cookie_affiliate_profile_name[] = $arr['profile_name'];
		$cookie_affiliate_affiliate_url[] = $arr['affiliate_url'];
	}
	
	echo "<select name='cookie_{$input_name}_affiliate_profile_id[]'>";
	foreach ($cookie_affiliate_profile_id as $a=>$b)
	{
		
		echo "<option value='$b' $selected>$cookie_affiliate_profile_name[$a]</option>";
	}
	echo "</select>";
}
?>