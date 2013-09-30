<?php

function traffic_tools_remote_connect($url)
{
	$method1 = ini_get('allow_url_fopen') ? "Enabled" : "Disabled";
	if ($method1 == 'Disabled')
	{
		//do curl
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "$url");
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 60);
		$string = curl_exec($ch);
	}
	else
	{
		$string = file_get_contents($url);
	}
	
	return $string;
}

$geo_array = unserialize(traffic_tools_remote_connect('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
print_r($geo_array);
echo "<br>";
exit;
?>