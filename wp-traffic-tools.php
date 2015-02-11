<?php
/*
Plugin Name: WP Traffic Tools
Plugin URI: http://www.wptraffictools.com
Description: Link Masking, Click Tracking, Keyword Linking, Conditional Redirection, Conditional Ad Placement, Cookie Management, Smart 404 Redirections, Searches to Tags, Traffic Management
Version: 7.2
Author: Hudson Atwell
Author URI: http://www.hudsonatwell.co
*/

if (!isset($_SESSION)) {
	session_start();
}
define('WPTRAFFICTOOLS_URLPATH', WP_PLUGIN_URL.'/'.plugin_basename( dirname(__FILE__) ).'/' );
define('WPTRAFFICTOOLS_PATH', WP_PLUGIN_DIR.'/'.plugin_basename( dirname(__FILE__) ).'/' );
define('WPTT_CURRENT_VERSION', '7.2' );
//define("QUICK_CACHE_ALLOWED", false);
//define("DONOTCACHEPAGE", true);
//$_SERVER["QUICK_CACHE_ALLOWED"] = false;



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
	$global_mask_links = $wptt_options['cloak_links'];
	$global_redirect_spiders = $wptt_options['redirect_spiders'];
	$global_nofollow_links = $wptt_options['nofollow_links'];
	$global_wptt = $wptt_options['license_key'];
	$global_wptt_handle = $wptt_options['license_email'];
	$global_permissions = '1.1.1.1.1.1.1';
	
	$wptt_current_version = $wptt_options['current_version'];
	
	$global_mask_link_profiles = $wptt_options['cloak_link_profiles'];
	$global_default_classificatin_prefix = $wptt_options['default_classification_prefix'];
	$global_keyword_affects = $wptt_options['keyword_affects'];
	$global_cloak_comments = $wptt_options['cloak_comments'];
	$global_cloak_commenter_url = $wptt_options['cloak_commenter_url'];
	$global_topsearches = $wptt_options['topsearches'];
	$global_topsearches_nature = $wptt_options['topsearches_nature'];
	$global_topsearches_header= $wptt_options['topsearches_header'];
	$global_topsearches_sort= $wptt_options['topsearches_sort'];
	$global_topsearches_limit = $wptt_options['topsearches_limit'];
	$global_topsearches_link = $wptt_options['topsearches_link'];
	$global_topsearches_display_count = $wptt_options['topsearches_display_count'];
	$global_topsearches_ignore = $wptt_options['topsearches_ignore'];
	$global_topsearches_tags = $wptt_options['topsearches_tags'];
	$global_topsearches_nature_deeplinks = $wptt_options['topsearches_nature_deeplinks'];
	$global_cloak_only_posts = $wptt_options['cloak_links_pages'];
	$global_cloak_text_widgets = $wptt_options['cloak_text_widgets'];
	$global_cloak_header_area = $wptt_options['cloak_header'];	
	$global_cloak_footer_area = $wptt_options['cloak_footer'];	
	$global_cloak_exceptions = $wptt_options['cloak_exceptions'];	
	$global_cloak_patterns = $wptt_options['cloak_patterns'];	
	$global_popups_cookie_timeout = $wptt_options['popups_cookie_timeout'];
	$global_shadowmaker_username = (isset($wptt_options['shadowmaker_username'])) ? $wptt_options['shadowmaker_username'] : '';
	$global_shadowmaker_password = (isset($wptt_options['shadowmaker_password'])) ? $wptt_options['shadowmaker_password'] : '';
	
}
else
{
	//echo $query; echo mysql_error(); exit;
}

$wordpress_url = get_bloginfo('url');
if (substr($wordpress_url, -1, -1)!='/')
{
	$wordpress_url = $wordpress_url."/";
}

//preg_match("/\.([^\/]+)/",  $wordpress_url, $domain_only);
//$domain = $domain_only[1]; 

//$wordpress_url = str_replace('www.','',$wordpress_url);
$current_url = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]."";
unset($referrer);
$referrer= (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '' ;
$referrer= str_replace("+",' ',$referrer);
$referrer= str_replace("-",' ',$referrer);
$referrer = str_replace('%20', ' ', $referrer);
//echo $referrer;exit;
function wptt_gather_search_data()
{	
	$original_referrer = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '' ;
	global $referrer;
	global $current_url;
	global $table_prefix;
	global $global_topsearches_tags;
	
	if (!is_admin())
	{
		//now check if google
		if (strstr($referrer,'google.com')||strstr($referrer,'bing.com')||strstr($referrer,'yahoo.com')||strstr($referrer,'q='))
		{
			setcookie('wptt_referrer', $original_referrer,time()+3600,"/");
			preg_match('/q=(.*?)(&|\z)/', $referrer,$matches);
			$google_query = $matches[1];
			//echo $pid;exit;
			//echo 1;
			//echo $google_query;
			if ($google_query)
			{
				$search_visitor = 1;

				if (strlen($google_query)>2)
				{
					if (!strstr($google_query,'site%3A')||!strstr($google_query,'%22')||!strstr($google_query,'http')||!strstr($google_query,'www'))
					{
						$google_query = str_replace('site%3Ahttp%3A%2F%2F','',$google_query);
						$google_query = str_replace('%2F','/',$google_query);
						$google_query = str_replace('n/a','',$google_query);
						$google_query = str_replace('site:','',$google_query);						
						$google_query = wptt_decode_unicode_url($google_query);						
					
					
						if (strpos($referrer,'google'))
						{
							setcookie('keywords_nature', 'google',time()+3600,"/");
						}
						else if (strpos($referrer,'bing'))
						{
							setcookie('keywords_nature', 'bing',time()+3600,"/");
						}
						else if (strpos($referrer,'yahoo'))
						{
							setcookie('keywords_nature', 'yahoo',time()+3600,"/");
						}
						else
						{
							$parsed = parse_url($referrer);
							$domain = $parsed['host'];
							setcookie('keywords_nature', $domain,time()+3600,"/");
						}
						
						//store keyword in database
						$this_google_query = urldecode($google_query);
						$this_google_query = addslashes($google_query);					
						$this_google_query = str_replace('+',' ',$this_google_query);
						//echo $current_url;
						$pid = @url_to_postid($current_url);
						if (!$pid){	$pid = wptt_url_to_postid($this_referrer); }
						if (!$pid){	$pid = wptt_url_to_postid_final($this_referrer); }
						$this_url = $current_url;
						$query= "INSERT INTO {$table_prefix}wptt_wptraffictools_google (`post_id`,`permalink`,`keyword`,`count`) VALUES ('{$pid}','{$current_url}','{$this_google_query}','1')  on duplicate key update count=count+1 , permalink='$this_permalink'";
						$result = mysql_query($query);
						if (!$result){echo $query; echo mysql_error(); exit;}
						//echo $_COOKIE['keywords_query'];
						//$_COOKIE['keywords_query'] = "hello";
						setcookie('keywords_query', $google_query,0,"/");
						$_SESSION['keywords_query'] = $google_query;
						//print_r($_COOKIE);
						//exit;
						//echo 1;exit;
						if ($global_topsearches_tags==1)
						{
							$google_query = str_replace('+',' ',$google_query);
					
							$return = wp_insert_term( $google_query, 'post_tag', $args = array() );
							if (is_array($return))
							{
								$tag_ids = $return[0];
								wp_set_object_terms( $pid, $tag_ids, 'post_tag');
							}
						}
					}
				}
			}
		}
		else
		{
			global $spacer;
			if(isset($original_referrer)&&!$spacer)
			{
				setcookie('wptt_referrer', $original_referrer,time()+3600,"/");
			}
			//echo ".$domain";exit;
			//echo 1; exit;
			//echo $referrer;exit;
		}
	}

}


#########################################################

# these are core functions to get values from wordpress
# for the title, meta keywords, tags, or from search
# engine queries (referer).
#########################################################
function wpt_title_as_keyword() 
{
    $keywords = the_title("", "", false);
	$string= strtolower($keywords);
	$array = explode(' ' , $string);
	$trash ="-,:,released,world,can,get,?,longer,stock,met,seen,content,can't,plus,got,go,no,review,added,new,we,all,check,our,be,hire,night,file,incredible,list,mostly,finally,detail,|,of,add,minus,subtract,table,about,above,acid,across,actually,after,again,against,almost,already,also,alter,although,always,among,angry,another,anyway,appropriate,around,automatic,available,awake,aware,away,back,basic,beautiful,because,been,before,being,bent,better,between,bitter,black,blue,boiling,both,bright,broken,brown,came,cause,central,certain,certainly,cheap,chemical,chief,clean,clear,clearly,close,cold,come,common,complete,complex,concerned,conscious,could,cruel,current,dark,dead,dear,deep,delicate,dependent,different,difficult,dirty,down,each,early,east,easy,economic,either,elastic,electric,else,enough,equal,especially,even,ever,every,exactly,feeble,female,fertile,final,finalty,financial,fine,first,fixed,flat,following,foolish,foreign,form,former,forward,free,frequent,from,full,further,future,general,generality,give,good,great,green,grey/gray,half,hanging,happy,hard,have,healthy,heavy,help,here,high,himself,hollow,home,however,human,important,indeed,individual,industrial,instead,international,into,just,keep,kind,labor,large,last,late,later,least,left,legal,less,like,likely,line,little,living,local,long,loose,loud,main,major,make,male,many,married,material,maybe,mean,medical,might,military,mixed,modern,more,most,much,must,name,narrow,national,natural,near,nearly,necessary,never,next,nice,normal,north,obviously,often,okay,once,only,open,opposite,original,other,over,parallel,particular,particularly,past,perhaps,personal,physical,please,political,poor,popular,possible,present,previous,prime,private,probable,probably,professional,public,quick,quickly,quiet,quite,rather,ready,real,really,recent,recently,regular,responsible,right,rough,round,royal,safe,said,same,second,secret,seem,send,separate,serious,several,shall,sharp,short,should,shut,significant,similar,simple,simply,since,single,slow,small,smooth,social,soft,solid,some,sometimes,soon,sorry,south,special,specific,sticky,stiff,still,straight,strange,strong,successful,such,sudden,suddenly,sure,sweet,take,tall,than,that,their,them,then,there,therefore,these,they,thick,thin,think,this,those,though,through,thus,tight,till,tired,today,together,tomorrow,total,turn,under,unless,until,upon,used,useful,usually,various,very,violent,waiting,warm,well,were,west,what,whatever,when,where,whether,which,while,white,whole,whose,wide,will,wise,with,within,without,would,wrong,yeah,yellow,yesterday,young,your,anyone,builds,tried,after,before,when,while,since,until,although,though,even,while,if,unless,only,case,that,this,because,since,now,as,in,on,around,to,I,he,she,it,they,them,both,either,and,top,most,best,&,inside,for,their,from,one,two,three,four,five,six,seven,eight,nine,ten,1,2,3, 'edit_pages',5,6,7,8,9,0,user,inc,is,isn't,are,aren't,do,don't,does,anyone,really,too,over,under,into,the,a,an,my,mine,against,inbetween,me,~,*,was,you,with,your,will,win,by";
	$trash = explode(",", $trash);
	
	foreach	($array  as $key => $value)
	{
		if (strlen($value)<3)
		{
			unset($array[$key]);
		}
		else
		{			
			if (in_array($value, $trash))
			{
				unset($array[$key]);
			}
		}
	}
	$string = implode(' ', $array);
	$string = preg_replace('/\W/u', ' ', $string);
	return $string;
}


function wpt_tag_as_keyword($num="all") {
    $tags = get_the_tags();
    if ($tags) {
        $keywords = "";
        $x = 1;
        if (is_numeric($num)) {$num = intval($num);}
        foreach($tags as $tag) {

            $keywords .= $tag->name . " ";
            if ((is_numeric($num)) && ($x >= $num)) {break;}
            $x++;
        }
    }
    $keywords = trim($keywords);
    return $keywords;
}

function wpt_custom_field_keyword($num="all") {
    $data = get_post_custom_values("keywords");
    $keywords = $data[0];
    $words = explode(",", $keywords);

    if (!is_numeric($num)) {$num = count($words);}
    $num = intval($num);
    $keywords = "";
    for ($x = 0;$x <= $num;$x++) {
        $keywords .= $words[$x] . " ";
    }
    $keywords = trim($keywords);

    return $keywords;
}

/* Post URLs to IDs function, supports custom post types - borrowed and modified from url_to_postid() in wp-includes/rewrite.php */
function wptt_url_to_postid($url)
{
	global $wp_rewrite;

	$url = apply_filters('url_to_postid', $url);

	// First, check to see if there is a 'p=N' or 'page_id=N' to match against
	if ( preg_match('#[?&](p|page_id|attachment_id)=(\d+)#', $url, $values) )	{
		$id = absint($values[2]);
		if ( $id )
			return $id;
	}

	// Check to see if we are using rewrite rules
	$rewrite = $wp_rewrite->wp_rewrite_rules();

	// Not using rewrite rules, and 'p=N' and 'page_id=N' methods failed, so we're out of options
	if ( empty($rewrite) )
		return 0;

	// Get rid of the #anchor
	$url_split = explode('#', $url);
	$url = $url_split[0];

	// Get rid of URL ?query=string
	$url_split = explode('?', $url);
	$url = $url_split[0];

	// Add 'www.' if it is absent and should be there
	if ( false !== strpos(home_url(), '://www.') && false === strpos($url, '://www.') )
		$url = str_replace('://', '://www.', $url);

	// Strip 'www.' if it is present and shouldn't be
	if ( false === strpos(home_url(), '://www.') )
		$url = str_replace('://www.', '://', $url);

	// Strip 'index.php/' if we're not using path info permalinks
	if ( !$wp_rewrite->using_index_permalinks() )
		$url = str_replace('index.php/', '', $url);

	if ( false !== strpos($url, home_url()) ) {
		// Chop off http://domain.com
		$url = str_replace(home_url(), '', $url);
	} else {
		// Chop off /path/to/blog
		$home_path = parse_url(home_url());
		$home_path = isset( $home_path['path'] ) ? $home_path['path'] : '' ;
		$url = str_replace($home_path, '', $url);
	}

	// Trim leading and lagging slashes
	$url = trim($url, '/');

	$request = $url;
	// Look for matches.
	$request_match = $request;
	foreach ( (array)$rewrite as $match => $query) {
		// If the requesting file is the anchor of the match, prepend it
		// to the path info.
		if ( !empty($url) && ($url != $request) && (strpos($match, $url) === 0) )
			$request_match = $url . '/' . $request;

		if ( preg_match("!^$match!", $request_match, $matches) ) {
			// Got a match.
			// Trim the query of everything up to the '?'.
			$query = preg_replace("!^.+\?!", '', $query);

			// Substitute the substring matches into the query.
			$query = addslashes(WP_MatchesMapRegex::apply($query, $matches));

			// Filter out non-public query vars
			global $wp;
			parse_str($query, $query_vars);
			$query = array();
			foreach ( (array) $query_vars as $key => $value ) {
				if ( in_array($key, $wp->public_query_vars) )
					$query[$key] = $value;
			}

		// Taken from class-wp.php
		foreach ( $GLOBALS['wp_post_types'] as $post_type => $t )
			if ( $t->query_var )
				$post_type_query_vars[$t->query_var] = $post_type;

		foreach ( $wp->public_query_vars as $wpvar ) {
			if ( isset( $wp->extra_query_vars[$wpvar] ) )
				$query[$wpvar] = $wp->extra_query_vars[$wpvar];
			elseif ( isset( $_POST[$wpvar] ) )
				$query[$wpvar] = $_POST[$wpvar];
			elseif ( isset( $_GET[$wpvar] ) )
				$query[$wpvar] = $_GET[$wpvar];
			elseif ( isset( $query_vars[$wpvar] ) )
				$query[$wpvar] = $query_vars[$wpvar];

			if ( !empty( $query[$wpvar] ) ) {
				if ( ! is_array( $query[$wpvar] ) ) {
					$query[$wpvar] = (string) $query[$wpvar];
				} else {
					foreach ( $query[$wpvar] as $vkey => $v ) {
						if ( !is_object( $v ) ) {
							$query[$wpvar][$vkey] = (string) $v;
						}
					}
				}

				if ( isset($post_type_query_vars[$wpvar] ) ) {
					$query['post_type'] = $post_type_query_vars[$wpvar];
					$query['name'] = $query[$wpvar];
				}
			}
		}

			// Do the query
			$query = new WP_Query($query);
			if ( !empty($query->posts) && $query->is_singular )
				return $query->post->ID;
			else
				return 0;
		}
	}
	return 0;
}

function wptt_url_to_postid_final($url)
{
	global $wpdb;
	$parsed = parse_url($url);
	$url = $parsed['path'];
	
	$parts = explode('/',$url);
	
	$count = count($parts);
	$count = $count -1; 

	if (empty($parts[$count]))
	{
		$i = $count-1;
		$slug = $parts[$i];
	}
	else
	{
		$slug = $parts[$count];
	}
	//echo $slug;
	$my_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '$slug'");
	
	if ($my_id)
	{
		return $my_id;
	}
	else
	{
		return 0;
	}
}

function traffic_tools_activate()
{
	global $wpdb;

	
	$sql = "CREATE TABLE IF NOT EXISTS wpt_classification_prefixes (
					id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					option_name VARCHAR(255) NOT NULL,
					option_value TEXT NOT NULL,
					status INT(2) NOT NULL
					) {$charset_collate};";
	$result = $wpdb->get_results($sql, ARRAY_A);
	
	$sql = "CREATE TABLE IF NOT EXISTS wptt_ip_addresses (
					id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
					string VARCHAR(255) NOT NULL
					) {$charset_collate};";
	$result = $wpdb->get_results($sql, ARRAY_A);
	
	$sql = "INSERT  INTO wpt_classification_prefixes (
			`id`,`option_name`,`option_value`,`status`)
			VALUES ('1','classification_prefix','go','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);
	
	if ( ! function_exists( 'is_plugin_active_for_network' ) )
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
    // Makes sure the plugin is defined before trying to use it
 
	if ( is_plugin_active_for_network( 'wp-traffic-tools/wp-traffic-tools.php') ) {
		if (function_exists('is_multisite') && is_multisite()) {       
				$old_blog = $wpdb->blogid;
				$blogids = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
				$multisite = 1;        
		}
	}
	
	//print_r($blogids);exit;
		
	if (count($blogids)>1)
	{
		$count = count($blogids);
	}
	else
	{
		$count=1;
	}
	
	for ($i=0;$i<$count;$i++)
	{
		if ($multisite==1)
		{
			 switch_to_blog($blogids[$i]);
		}
		//echo $wpdb->prefix;
		//echo "<br>";
		$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wptt_wptraffictools_options (
				id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				option_name VARCHAR(225) NOT NULL,
				option_value TEXT NOT NULL,
				status INT(2) NOT NULL
				) {$charset_collate};";
			
		$result = $wpdb->get_results($sql, ARRAY_A);	
		
		$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wptt_wptraffictools_google (
				id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				permalink VARCHAR(225) NOT NULL,
				post_id INT(15) NOT NULL,
				keyword VARCHAR(225) NOT NULL UNIQUE,
				count INT(20)
				) {$charset_collate};";
			
		$result = $wpdb->get_results($sql, ARRAY_A);	
		
		$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wptt_wptraffictools_cloaking (
				id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				ref VARCHAR(225) NOT NULL,
				url VARCHAR(225) NOT NULL
				) {$charset_collate};";
			
		$result = $wpdb->get_results($sql, ARRAY_A);
		
		$default_useragents = "msie;firefox;safari;webkit;opera;netscape;konqueror;gecko;chrome;songbird;seamonkey;flock;AppleWebKit;Android";
		
		$wptt_options['useragents'] = $default_useragents;
		$wptt_options['ip_addresses'] = "";
		$wptt_options['cloak_links'] = 0;
		$wptt_options['redirect_spiders'] = 0;
		$wptt_options['nofollow_links'] = 0;
		$wptt_options['license_key'] = "";
		$wptt_options['license_email'] = "";
		$wptt_options['current_version'] = WPTT_CURRENT_VERSION;
		$wptt_options['permissions'] = "1.1.1.1.1.1.1";
		$wptt_options['cloak_link_profiles'] = 1;
		$wptt_options['default_classification_prefix'] = "go";
		$wptt_options['keyword_affects'] = 0;
		$wptt_options['cloak_comments'] = 1;
		$wptt_options['cloak_commenter_url'] = 1;
		$wptt_options['topsearches'] = 0;
		$wptt_options['topsearches_nature'] = "single";
		$wptt_options['topsearches_header'] = "Top Searches";
		$wptt_options['topsearches_sort'] = "DESC";
		$wptt_options['topsearches_limit'] = 5;
		$wptt_options['topsearches_link'] = 0;
		$wptt_options['topsearches_display_count'] = 0;
		$wptt_options['topsearches_ignore'] = "";
		$wptt_options['topsearches_tags'] = 0;
		$wptt_options['topsearches_nature_deeplinks'] = 0;
		$wptt_options['cloak_links_pages'] = 0;
		$wptt_options['cloak_text_widgets'] = 0;
		$wptt_options['cloak_header'] = 0;
		$wptt_options['cloak_footer'] = 0;	
		$wptt_options['cloak_exceptions'] = "";
		$wptt_options['cloak_patterns'] = "";
		$wptt_options['popups_cookie_timeout'] = 7200;

		
		$wptt_options = json_encode($wptt_options);
		$sql = "INSERT  INTO {$wpdb->prefix}wptt_wptraffictools_options (
		`id`,`option_name`,`option_value`,`status`)
		VALUES ('31','wptt_options','$wptt_options','1')";
		$result = $wpdb->get_results($sql, ARRAY_A);
		//if ($result) { echo $query; echo mysql_error();}
	}
	//exit;
	
	//generate the new htaccess code
	$htaccess = "RewriteEngine On \n
RewriteRule ^(.*)spacer\.gif$ ".WPTRAFFICTOOLS_URLPATH."images/spacer.php [L]";
	//echo $htaccess;
	//fopen .htacess
	$targetFile = ABSPATH."wp-content/plugins/wp-traffic-tools/images/.htaccess"; 
	//echo $targetFile;exit;
	$handle1 = fopen($targetFile, "w");  	
	fwrite($handle1, $htaccess);
	fclose($handle1);
	
	if ($multisite==1)
	{
		switch_to_blog($old_blog);
	}
}

function cloakme_activate() 
{
	global $wpdb;	
   
	
	if ( !empty($wpdb->charset) )
		$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
	
	if ( ! function_exists( 'is_plugin_active_for_network' ) )
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
    // Makes sure the plugin is defined before trying to use it
 
	if ( is_plugin_active_for_network( 'wp-traffic-tools/wp-traffic-tools.php') ) {
		if (function_exists('is_multisite') && is_multisite()) {       
				$old_blog = $wpdb->blogid;
				$blogids = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
				$multisite = 1;        
		}
	}
	
	//print_r($blogids);exit;
		
	if (count($blogids)>1)
	{
		$count = count($blogids);
	}
	else
	{
		$count=1;
	}
	
	for ($i=0;$i<$count;$i++)
	{
		if ($multisite==1)
		{
			 switch_to_blog($blogids[$i]);
		}
	
		$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wptt_cloakme_profiles (
			id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			link_masking INT(1) NOT NULL,
			classification_prefix VARCHAR(255) NOT NULL,
			permalink VARCHAR(255) NOT NULL UNIQUE,
			cloaked_url VARCHAR(255) NOT NULL,
			redirect_url TEXT NOT NULL,			
			rotate_urls INT(1) NOT NULL,		
			rotate_urls_count INT(9) NOT NULL,		
			rotate_marker INT(3) NOT NULL,			
			redirect_spider INT(10) NOT NULL,
			redirect_method VARCHAR(10) NOT NULL,
			redirect_method_url VARCHAR(225) NOT NULL,
			redirect_type VARCHAR(10) NOT NULL,
			blank_referrer INT(10) NOT NULL,
			spoof_referrer_url TEXT NOT NULL,
			cloak_target INT(10) NOT NULL,
			stuff_cookie VARCHAR(255) NOT NULL,
			visitor_count INT(10) NOT NULL,
			spider_count INT(10) NOT NULL,
			keywords MEDIUMTEXT NOT NULL,
			keywords_affect INT(1) NOT NULL,
			attributes VARCHAR(225) NOT NULL,
			keywords_limit INT(2) NOT NULL,
			keywords_limit_total INT(2) NOT NULL,
			keywords_target_page VARCHAR(7) NOT NULL,
			type VARCHAR(20) NOT NULL,
			notes TEXT NOT NULL
			) {$charset_collate};";

		$result = mysql_query($sql);
		if (!$result){ echo $sql; echo mysql_error();exit;}
		
		$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wptt_cloakme_logs (
				id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				permalink VARCHAR(225) NOT NULL,
				target TEXT NOT NULL ,
				referrer TEXT NOT NULL ,
				keywords_nature TEXT NOT NULL ,
				keywords_query TEXT NOT NULL ,
				date DATE  ,
				count INT(10) NOT NULL
				) {$charset_collate};";

		$result = $wpdb->get_results($sql, ARRAY_A);
		
		
		$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wptt_cloakme_options (
			id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			option_name VARCHAR(255) NOT NULL,
			option_value TEXT NOT NULL,
			status INT(2) NOT NULL
			) {$charset_collate};";
		
		$result = $wpdb->get_results($sql, ARRAY_A);	
	}
	
	if ($multisite==1)
	{
		switch_to_blog($old_blog);
	}
		
	//generate the new htaccess code
	$newcode = "#wp-traffic-tools-start
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule ^(.*)images/special-(.*)\.gif$ $1drop_insurance.php?url=$2 [R=301,L]
RewriteRule ^(.*)images/special-blank-(.*)\.gif$ $1drop_insurance.php?blank=1&url=$2 [R=301,L]  \n
RewriteRule ^(.*)go/(.*)$ ".ABSPATH."/wp-content/plugins/wp-traffic-tools/relay.php?permalink=$2 [L,QSA] \n
</IfModule> \n
#wp-traffic-tools-end

";

		
	//fopen .htacess
	$targetFile = ABSPATH.".htaccess"; 
	$handle = fopen($targetFile, "a+"); 
	$data = fread($handle,filesize($targetFile)); 
	fclose($handle);
	
	if (!strstr($data,'#wp-traffic-tools-start'))
	{
		if (strstr($data, '# BEGIN WordPress'))
		{
			$data = str_replace('# BEGIN WordPress', $newcode."\n\n # BEGIN WordPres", $data);
			$handle = fopen($targetFile, "w");
			$htaccess = $data;
			fwrite($handle, $htaccess);
			fclose($handle);
		}
		else
		{
			$handle = fopen($targetFile, "w");
			$htaccess = "$data \n $newcode";
			fwrite($handle, $htaccess);
			fclose($handle);
		}
	}
		
}

function redirect_activate() 
{
	global $wpdb;	   
	
	if ( !empty($wpdb->charset) )
		$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
	
	if ( ! function_exists( 'is_plugin_active_for_network' ) )
    require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
    // Makes sure the plugin is defined before trying to use it
 
	if ( is_plugin_active_for_network( 'wp-traffic-tools/wp-traffic-tools.php') ) {
		if (function_exists('is_multisite') && is_multisite()) {       
				$old_blog = $wpdb->blogid;
				$blogids = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
				$multisite = 1;        
		}
	}
	
	//print_r($blogids);exit;
		
	if (count($blogids)>1)
	{
		$count = count($blogids);
	}
	else
	{
		$count=1;
	}
	
	for ($i=0;$i<$count;$i++)
	{
		if ($multisite==1)
		{
			 switch_to_blog($blogids[$i]);
		}
	
		$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wptt_wpredirect_profiles (
			id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			post_id VARCHAR(225) NOT NULL,
			category_id VARCHAR(225) NOT NULL,
			redirect_url TEXT NOT NULL,
			rotate_marker INT(3) NULL,
			redirect_keywords TEXT NOT NULL,
			blank_referrer INT(1) NOT NULL,
			ignore_spider INT(1) NOT NULL,
			require_referrer INT(1) NOT NULL,
			redirect_type INT(1) NOT NULL,
			iframe_target INT(1) NOT NULL,
			iframe_target_title TEXT NOT NULL,
			human_redirect_count INT(10) NOT NULL,
			spider_redirect_count INT(10) NOT NULL,
			redirect_delay INT(11) NOT NULL,
			exclude_items VARCHAR(225) NOT NULL,
			throttle INT(10) NOT NULL,
			throttle_check INT(10) NOT NULL,
			status INT(1) NOT NULL,
			priority INT(5) NOT NULL,
			notes TEXT NOT NULL
			) {$charset_collate};";

		$result = $wpdb->get_results($sql, ARRAY_A);

		$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}wptt_wpredirect_regex_profiles (
			id INT(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			regex_referrer TEXT NOT NULL,
			regex_landing_page TEXT NOT NULL,
			redirect TEXT NOT NULL,
			nature INT(1) NOT NULL,
			notes TEXT NOT NULL,
			spider_management INT(1) NOT NULL,
			status INT(1) NOT NULL
			) {$charset_collate};";

		$result = $wpdb->get_results($sql, ARRAY_A);			
	}
	
	if ($multisite==1)
	{
		switch_to_blog($old_blog);
	}
}

function traffic_tools_javascript()
{
	//echo var_export(unserialize(traffic_tools_remote_connect('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR'])));
	?>
		<script type="text/javascript">
			
			jQuery(document).ready(function() 
			{
				//var cc = geoplugin_countryCode();
				//alert (cc);
				
				jQuery('#id_button_activate_wptraffictools').click(function() {
					jQuery("#id_form_activate_wptraffictools").submit();
				});
				
				jQuery('#id_button_update_wptraffictools').click(function() {
					if (confirm('Are you sure you want to update?'))
					{
						alert('Download & Extracting Software. This may take a minute. Please leave your browser open until the page reloads.');
						jQuery.get('./../wp-content/plugins/wp-traffic-tools/update.php', function(data) {
							if (data==1)
							{
								 location.reload();
							}
							else
							{
								alert('update failed! Uh oh.');
							}
						});	
					}
				});
				
			});
		</script>
	<?php
}




function traffic_update_files($new_version)
{
	global $table_prefix;
	global $wpdb;
	
	global $global_wptt;
	global $global_wptt_handle;
	
	global $wptt_options;
	
	$url = "http://www.wptraffictools.com/members/download.php?key=$licence_key";

	$temp_file = tempnam('/tmp','WPTRAFFICTOOLS');
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$file = curl_exec($ch);
	curl_close($ch);
	
	$handle = fopen($temp_file, "w");
	fwrite($handle, $file);
	fclose($handle);
	
	$path = get_bloginfo( '' );
	$get = zip_extract($temp_file, "../wp-content/plugins/");
	
	unlink($temp_file);
	
	if ($get==1)
	{	
		
		include_once("update_sql.php");
		
		echo 1;
	}
	else
	{
		include_once('update_sql.php');
		
		echo "update failed... sorry, we'll figure it out.";
	}
	
	
	
}


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
		curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
		curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
		$string = curl_exec($ch);
	}
	else
	{
		$string = @file_get_contents($url);
	}
	
	return $string;
}

function traffic_tools_options_buffer_page()
{
	global $table_prefix;
	global $global_wptt;
	
	//PHP SAVE SETTINGS
	traffic_tools_javascript();
	
	//CSS CONTENT
	//include('wptt_style.php');
	traffic_tools_update_check();
	traffic_tools_options_page();
	define('wptt_options_page', '1' );

}

function traffic_tools_update_check() 
{
	
}


function wptt_display_footer()
{
	echo "<div class='wptt_footer'><a href='http://www.wptraffictools.com/members/download.php' target='_blank'>WP Traffic Tools Download</a> &nbsp;|&nbsp;";
	echo " <a href='".WPTRAFFICTOOLS_URLPATH."update_sql.php?debug=1&all=1' target='_blank'>Repair Tables</a> &nbsp;|&nbsp;";
	echo " <a href='".WPTRAFFICTOOLS_URLPATH."update.php' target='_blank'>Force Update</a> &nbsp;|&nbsp;";
	echo " <a href='https://www.twitter.com/' target='_blank'>@atwellpub</a></div>";
	

}

function traffic_tools_options_page()
{
	
	?>
	
	
	<?php
}

if (is_admin())
{
	setcookie('wptt_prices', '1.1.1.1.1.1' ,time()+1800,"/");
	$rp = "1.1.1.1.1.1";
	$rp = explode(".",$rp);
}
	

add_action('init', 'wptt_gather_search_data');
$pm = explode(".",$wptt_options['permissions']);
//print_r($pm);exit;
include_once('wptt-setup.php');
include_once('wp-global-settings.php');

if ($pm[0]==1)
{
	include_once('wp-cloakme.php');
}
if ($pm[1]==1)
{
	include_once('wp-redirect-controller.php');
}


register_activation_hook(__FILE__, 'cloakme_activate');
register_activation_hook(__FILE__, 'redirect_activate');
register_activation_hook(__FILE__, 'traffic_tools_activate');

//exit;
function traffic_tools_add_menu()
{
	global $menu;
	global $table_prefix;
	global $pm;

	if (current_user_can('manage_options')) 
	{
		add_menu_page( "WP Traffic Tools", "Traffic Tools", 'edit_pages', __FILE__, 'traffic_tools_options_buffer_page', plugins_url('wp-traffic-tools/images/wordpress.png'), '300');
		add_submenu_page(__FILE__,'Module Setup', 'Module Setup',  'edit_pages', __FILE__, 'wptt_display_setup');

		add_submenu_page(__FILE__,'Link Profiles', 'Link Profiles',  'edit_pages',"wptt_slug_submenu_link_profiles", 'wptt_display_link_profiles');		

		add_submenu_page(__FILE__,'Redirection Profiles', 'Redirection Profiles',  'edit_pages', 'wptt_slug_submenu_redirection_profiles', 'wptt_display_redirection_profiles');
		
		add_submenu_page(__FILE__,'Spider Definitions', 'Spider Definitions',  'edit_pages', 'wptt_slug_submenu_spider_settings', 'wptt_display_spider_settings');
		
		    
	}
	//print_r($menu);
}

add_action('admin_menu', 'traffic_tools_add_menu');
//echo 1; exit;

function wptt_checkuser()
{
	echo "
	<script>
		
		jQuery.cookie('wpttcheck', '1',{ path: '/' });
		jQuery(document).one('mousemove',function(){
			jQuery.cookie('wpttcheck','0', { path: '/' });
			}
		);
		jQuery(document).one('scroll',function(){
			jQuery.cookie('wpttcheck','0', { path: '/' });
			}
		);
	</script>
	";
}


//register jquery files
function wptt_init_enqueue() {
    if (is_admin()) {
        wp_enqueue_script( 'jquery' );
		if (isset($_GET['page']) && $_GET['page']=='wptt_slug_submenu_advertisement_profiles')
		{
			wp_deregister_script( 'jquery-ui-core');
			wp_register_script( 'jquery-ui-core', 'http://code.jquery.com/ui/1.10.3/jquery-ui.js' );			
			wp_enqueue_script( 'jquery-wptt-core' , 'http://code.jquery.com/ui/1.10.3/jquery-ui.js');
		}
		wp_enqueue_script( 'jquery-ui-core' );
		wp_register_style( 'custom_jquery_ui_css', ''.WPTRAFFICTOOLS_URLPATH.'jquery-ui-1.7.2.custom.css' );
		wp_enqueue_style( 'custom_jquery_ui_css' );
    }
	else
	{
		 wp_enqueue_script( 'jquery' );		 
		 wp_register_script( 'jquery-cookie', ''.WPTRAFFICTOOLS_URLPATH.'jquery-cookie.js' );
		 wp_enqueue_script( 'jquery-cookie' ); 
		 //wp_register_script( 'geo-location', 'http://www.geoplugin.net/javascript.gps' );
		 // wp_enqueue_script( 'geo-location' );
		 //wp_register_script( 'topup', ''.WPTRAFFICTOOLS_URLPATH.'jqtopup.js' );
		 //wp_enqueue_script( 'topup' );
	}
}    
 

add_action('init', 'wptt_init_enqueue');
add_filter('wp_head', 'wptt_checkuser');


function wptt_decode_unicode_url($str)
{
  $res = '';

  $i = 0;
  $max = strlen($str) - 6;
  while ($i <= $max)
  {
    $character = $str[$i];
    if ($character == '%' && $str[$i + 1] == 'u')
    {
      $value = hexdec(substr($str, $i + 2, 4));
      $i += 6;

      if ($value < 0x0080) // 1 byte: 0xxxxxxx
        $character = chr($value);
      else if ($value < 0x0800) // 2 bytes: 110xxxxx 10xxxxxx
        $character =
            chr((($value & 0x07c0) >> 6) | 0xc0)
          . chr(($value & 0x3f) | 0x80);
      else // 3 bytes: 1110xxxx 10xxxxxx 10xxxxxx
        $character =
            chr((($value & 0xf000) >> 12) | 0xe0)
          . chr((($value & 0x0fc0) >> 6) | 0x80)
          . chr(($value & 0x3f) | 0x80);
    }
    else
      $i++;

    $res .= $character;
  }

  return $res . substr($str, $i);
}


function wptt_filter_spiders()
{
	global $table_prefix;
	
	do_action('wptt_spider_check_hook');
	
	if (isset($_SERVER))
	{
		$visitor_useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
		$visitor_ip = $_SERVER['REMOTE_ADDR'];
		$referrer = $_SERVER['HTTP_REFERER'];
	}

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
		$useragents = explode(';', $useragents);
	}
			
	//check to make sure useragent is present

	foreach ($useragents as $k=>$v)
	{
		$v = trim($v);
		 
		if(stristr($visitor_useragent, $v)||$v=='*')
		{	
				     
			$query = "SELECT * FROM wptt_ip_addresses WHERE string = '$visitor_ip' LIMIT 1";
			$result = mysql_query($query);
			if (!$result) { echo $query; echo mysql_error(); exit;}	
			$count = mysql_num_rows($result);
			if ($count>0)
			{
				//is spider cause ip is in db
				return 0;
			} else {
			    //is human because passed useragent check and ip check
			   return 1;
			   
			}
		}			
	}
	

	//return 1 if human
	return 1;
}
?>