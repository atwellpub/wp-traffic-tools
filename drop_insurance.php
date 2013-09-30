<?php

$blank = $_GET['blank'];
$url = $_GET['url'];

if ($blank==1)
{
	header("Location: redirect.php?url=$url");
}
else
{
	$url = urldecode($_GET['url']);
	header("Location: http://$url");
}
?>