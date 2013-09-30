<?php
include_once('./../../../wp-config.php');	

		//CLOAKING PROFILE FIELDS
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles ADD visitor_count INT( 10 )";	
		$result = mysql_query($sql);	
		
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles ADD spider_count INT( 10 )";	
		$result = mysql_query($sql);	
		
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles ADD blank_referrer INT( 10 )";	
		$result = mysql_query($sql);
		
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles ADD classification INT( 10 )";	
		$result = mysql_query($sql);
		
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles ADD classification INT( 10 )";	
		$result = mysql_query($sql);
		
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles ADD cloak_target INT( 10 )";	
		$result = mysql_query($sql);
		
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles ADD redirect_url VARCHAR( 225 )";	
		$result = mysql_query($sql);
		
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles ADD redirect_spider INT( 10 )";	
		$result = mysql_query($sql);
		
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles ADD redirect_method VARCHAR( 10 )";	
		$result = mysql_query($sql);
		
		$sql = "ALTER TABLE {$table_prefix}wptt_cloakme_profiles ADD redirect_type VARCHAR( 10 )";	
		$result = mysql_query($sql);
		
		//REDIRECT CONTROLLER UPDATES
		//alter content block table due to mistake in old version
		$sql = "ALTER TABLE `".$table_prefix."wpredirect_profiles` MODIFY post_id VARCHAR(20)";
		$result = mysql_query($sql);
?>