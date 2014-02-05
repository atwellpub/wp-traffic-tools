<?php
include_once('./../../../wp-config.php');
$method = $_GET['method'];
$wordpress_url = get_bloginfo('url');

if (substr($wordpress_url, -1)!='/')
{
	$wordpress_url = $wordpress_url."/";
}

if ( !is_user_logged_in() ) 
	EXIT;

$permalink = $_GET['permalink'];

$query = "SELECT * FROM {$table_prefix}wptt_cloakme_profiles WHERE permalink='$permalink' LIMIT 1";
$result = mysql_query($query);
$arr = mysql_fetch_array($result);
if (!$result){echo $query; echo mysql_error(); exit;}
	
$cloaking_cloaked_url = $arr['cloaked_url'];

$query = "SELECT * FROM {$table_prefix}wptt_cloakme_logs WHERE permalink='$permalink' ORDER BY date DESC";
$result = mysql_query($query);
if (!$result){echo $query; echo mysql_error(); exit;}

$target = array();
$referrer = array();
$keywords_nature = array();
$keywords_query = array();
$date = array();
$count = array();

while ($arr = mysql_fetch_array($result, MYSQL_BOTH))
{

	$target[] = trim($arr['target']);
	$referrer[] = $arr['referrer'];
	$keywords_nature[] = $arr['keywords_nature'];
	$keywords_query[] = $arr['keywords_query'];
	$date[] = $arr['date'];
	$count[] = $arr['count'];

}

$timezone_format = _x('Y-m-d', 'timezone date format');
$wordpress_date_time =  date_i18n($timezone_format);
$today = date("Y-m-d", strtotime($wordpress_date_time));
?>
<html>
  <head>
	<title>Clickthrough Logs - <?php echo $cloaking_cloaked_url; ?></title>
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
      google.load('visualization', '1', {packages:['table']});
      google.setOnLoadCallback(drawTable);
      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Date');
        data.addColumn('string', 'Referring URL');
        data.addColumn('string', 'Target URL');
        data.addColumn('string', 'Related Search Engine');
        data.addColumn('string', 'Related Search Keywords');
        data.addColumn('number', 'Visitor Count');
        data.addRows(<?php echo count($referrer); ?>);
		<?php
		foreach ($referrer as $key=>$val)
		{
			if (!$date[$key])
			{
				$date[$key] = "n/a";
			}
			else
			{
				if ($date[$key]==$today)
				{
					$date[$key] = "Today";
				}
				else if ($date[$key]==date("Y-m-d",strtotime("$today - 1 day")))
				{
					$date[$key] = "Yesterday";
				}
				else
				{
					$date[$key] = date("F j, Y",strtotime($date[$key]));
				}
			}
			
			echo "data.setCell($key, 0, '{$date[$key]}');\n";
			echo "data.setCell($key, 1, '{$referrer[$key]}');\n";
			echo "data.setCell($key, 2, '{$target[$key]}');\n";
			echo "data.setCell($key, 3, '{$keywords_nature[$key]}');\n";
			echo "data.setCell($key, 4, '{$keywords_query[$key]}');\n";
			echo "data.setCell($key, 5, {$count[$key]}, '{$count[$key]}');";
        }
		?>

        var table = new google.visualization.Table(document.getElementById('table_div'));
        table.draw(data, {showRowNumber: false});
      }
    </script>
  </head>

  <body>
	<h2>WP Traffic Tools - Link Traffic Report<h2>
	<h3><a href="<?php echo $cloaking_cloaked_url; ?>" target="_blank"><?php echo $cloaking_cloaked_url; ?></a></h3>
    <div id='table_div' style="font-size:10px;"></div>
  </body>
</html>