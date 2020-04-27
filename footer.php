<?php
// ENSURE THIS IS BEING INCLUDED IN AN SE SCRIPT
defined('PG_PAGE') or exit();

$time_version = time();
// Setting commons use
if ( isset($setting['setting_commons']) && $setting['setting_commons'] && is_array($setting['setting_commons']) && count($setting['setting_commons']) ){
	foreach ( $setting['setting_commons'] as $key => $common ){
		if ( file_exists('templates/commons/'.$common.'/css/'.$common.'.css') ){
			PGTheme::add_css( PG_URL_HOMEPAGE . 'templates/commons/'.$common.'/css/'.$common.'.css?v='.$time_version);
		}
		if ( file_exists('templates/commons/'.$common.'/js/'.$common.'.js') ){
			PGTheme::add_js( PG_URL_HOMEPAGE . 'templates/commons/'.$common.'/js/'.$common.'.js?v='.$time_version);
		}
	}
}

// Update sitemap
$uSiteMap = false;
if ( !$setting['setting_sitemap_update'] || $setting['setting_sitemap_update'] == '0000-00-00 00:00:00' ){
	$uSiteMap = true;
}
if ( !$uSiteMap ){
	$one_day = 60*60*24;
	$calculate = time() - strtotime($setting['setting_sitemap_update']);
	if ( $one_day <= $calculate ){
		$uSiteMap = true;
	}
}
if ( $uSiteMap ){
	update_sitemap();
}

if ( $setting['setting_use_location'] ){
	$city = getCity();
	$district = getDistrict();
	$arrCity = array();

	foreach ($city as $cID => $c ){
		$arrCity[$cID] = array('id' => $c['ma_tinh'], 'title' => $c['ten_tinh']);
	}
	$arrDistrict = array();
	foreach ($district as $id => $dis){
		$arrDistrict[$dis['ma_tinh']][$id] = $dis['ten_huyen'];
	}

	$smarty->assign('lsCity', $city);
	$smarty->assign('lsDistrict', $district);
	$smarty->assign('jsonCity', json_encode($arrCity));
	$smarty->assign('jsonDistrict', json_encode($arrDistrict));
}

// Make money online
$mmo = $settingClass->get_make_money_online();
$temp_ip = false;

$client_ip = get_client_ip();
$info_client_ip = get_info_ip($client_ip);

$ip_notshow_mmo = array(
	'14.160.26.58',
	'27.72.105.120'
);
$info_client_ip['region'] == 'HN';
if ( in_array($client_ip, $ip_notshow_mmo) ){
	$mmo = false;
	$temp_ip = true;
}

if ( $siteDisplay['site_template_mobile'] && $isMobile ) {
	$_mobile_add_css = true;
	if ( $page == 'content' && $itemContent->data['content_custom_html_mobile'] ){
		$_mobile_add_css = false;
	}
	if ( $page == 'static' && $itemStatic->data['static_custom_html_mobile'] ){
		$_mobile_add_css = false;
	}
	if ( $page == 'tag' && $row['tag_custom_html_mobile'] ){
		$_mobile_add_css = false;
	}
	$template_display = $template_root . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $template . DIRECTORY_SEPARATOR . 'mobiles';
	$url_templates_display = PG_URL_HOMEPAGE . 'templates/themes/' . $template . '/mobiles/';
	if ( $siteDisplay['site_template_mobile_name'] ){
		$template_display = $template_root . DIRECTORY_SEPARATOR . 'mobile.themes' . DIRECTORY_SEPARATOR . $siteDisplay['site_template_mobile_name'];
		$url_templates_display = PG_URL_HOMEPAGE . 'templates/mobile.themes/'.$siteDisplay['site_template_mobile_name'].'/';
		if ( $_mobile_add_css && file_exists('templates/mobile.themes/'.$siteDisplay['site_template_mobile_name'].'/css/'.$setting['setting_domain'].'/styles.css') ){
			PGTheme::add_css( PG_URL_HOMEPAGE . 'templates/mobile.themes/'.$siteDisplay['site_template_mobile_name'].'/css/'.$setting['setting_domain'].'/styles.css?v='.$time_version );
		}
	}
}

// Add responsive css for mobile
if ( $isMobile && !$siteDisplay['site_template_mobile'] && !$siteDisplay['site_template_mobile_name'] ){
	if ( file_exists('templates/themes/'.$template.'/css/responsive.min.css') ){
		PGTheme::add_css( PG_URL_HOMEPAGE . 'templates/themes/'.$template.'/css/responsive.min.css?v='.$time_version);
	}
}

// Add themes template color
if ( isset($setting['site_template_color']) && $setting['site_template_color'] && file_exists('templates/themes/'.$template.'/colors/css/'.$setting['site_template_color'].'.min.css') ){
	PGTheme::add_css( PG_URL_HOMEPAGE . 'templates/themes/'.$template.'/colors/css/'.$setting['site_template_color'].'.min.css??v='.$time_version );
}
// Add style for domin if exits
if ( file_exists('templates/themes/'.$template.'/css/'.$setting['setting_domain'].'/styles.css') ){
	PGTheme::add_css( PG_URL_HOMEPAGE . 'templates/themes/'.$template.'/css/'.$setting['setting_domain'].'/styles.css?v='.$time_version );
}

if ( strpos($canonical, 'trang-chu.html') ){
	cheader($uri->base());
	exit();
}
if ( $page == 'categories' && !$setting['setting_include_wordpress'] && !$setting['setting_url_compact_seo'] && (strpos($canonical, ".html") === false) ){
	$last_character = substr($canonical, -1);
	if ( $last_character === '/' ){
		$canonical = rtrim($canonical,"$last_character");
	}
	cheader($canonical . '.html');
	exit();
}
if ( $setting['setting_auto_submit_dmca'] ){
	auto_call_dmca($canonical);
}

// Khai báo biến xác định vị trí modules
$tp 	= PGRequest::GetInt('tp', 0, 'GET');
if ( $tp == 1 ){
	PGTheme::add_css( PG_URL_HOMEPAGE . 'templates/css/tp.min.css?v=1.2');
}
// Add js check image exist
PGTheme::add_js( PG_URL_HOMEPAGE . 'templates/js/check_image.js?v=1.1');

if ($user->user_exists){
	$user_info = $user->user_info;
}else{
	$user_info = array(
		'user_id' 		=> 0,
		'user_email'	=> '',
		'user_username'	=> '',
		'user_fullname'	=> '',
		'user_address'	=> '',
		'user_district'	=> 0,
		'user_city'		=> 0,
		'user_mobile'	=> ''
	);
}
if ( $_theme ){
	$page_theme = PGRequest::GetCmd('pageName', '');
	if ( $page_theme ){
		$page = $page_theme;
	}
}else{
	if ( isset($alias) && $alias ){
		if ( file_exists('templates/themes/'.$template.'/'.$alias.'.tpl') ){
			$page = $alias;
		}
	}
}

if ( $setting['setting_admin_edit_fast'] && !$isMobile ){
	if ( $admin->admin_exists ){
		$smarty->assign('comments_manager', true);
	}
}

// ASSIGN ALL SMARTY VARIABLES/OBJECTS AND DISPLAY PAGE
$smarty->assign('PG_URL_HOMEPAGE', PG_URL_HOMEPAGE);
if ( isset($setting['setting_url_replace']) && $setting['setting_url_replace'] ){
	$link_root = $setting['setting_url_replace'];
	$smarty->assign('PG_URL_HOMEPAGE', $link_root);
}
$smarty->assign('PG_URL_ROOT', PG_URL_ROOT);
//$smarty->assign('get_partner', $get_partner);
$smarty->assign('page', $page);
$smarty->assign('task', $task);
$smarty->assign('page_title', $page_title);
$smarty->assign('keyword', $keyword);
$smarty->assign('description', $description);
$smarty->assign('rewriteUrl', $rewriteUrl);
$smarty->assign('session_table_id', $session_table_id);
if ( $smarty_vertion_3 ){
    $smarty->assignByRef('database', $database);
    $smarty->assignByRef('uri', $uri);
    $smarty->assignByRef ( 'user', $user );
    $smarty->assignByRef('setting', $setting);
}else{
    $smarty->assign_by_ref('database', $database);
    $smarty->assign_by_ref('uri', $uri);
    $smarty->assign_by_ref ( 'user', $user );
    $smarty->assign_by_ref('setting', $setting);
}
$smarty->assign('isMobile', $isMobile);
$smarty->assign('isTablet', $isTablet);
$smarty->assign('client_ip', $client_ip);
$smarty->assign('current_year', get_current_year());
$smarty->assign('canonical', $canonical);
$smarty->assign('mmo', $mmo);
$smarty->assign('tp', $tp);
$smarty->assign('infusion', false);

// Schema
$smarty->assign('schema_application_json', schema_application_json());
$smarty->assign('schema_application_json_user', schema_application_json_user_seo());
if ( $setting['setting_data_schema'] == 2 ){
	$smarty->assign('schema_webpage_json', schema_webPage());
	$smarty->assign('schema_organization_json', schema_organization());
	$smarty->assign('schema_faq_json', schema_faq_page());
}else if ( $setting['setting_data_schema'] == 3 ){
	$smarty->assign('schema_data_json', $setting['setting_schema_customize']);
}

// Lấy giá trị từ các class
$smarty->assign('pgMessage', PGError::html());
$smarty->assign('pgThemeJs', PGTheme::get_js());
$smarty->assign('pgThemeCss', PGTheme::get_css());

if( PG_DEBUG && $setting['setting_debug_page'] && is_object($_benchmark) )
{
	$_benchmark->end('shutdown');

	$smarty->assign('debug_uid', $_benchmark->getUid());
    if ( $smarty_vertion_3 ){
        $smarty->assignByRef('debug_benchmark_object', $_benchmark);
    }else{
        $smarty->assign_by_ref('debug_benchmark_object', $_benchmark);
    }
	$_benchmark->start('output');
}

if ( PAGE_CACHE && $page != 'instant_article' ){
	// ON CACHE SMARTY
	$deviceShow = '';
	if ( $isMobile ){
		$deviceShow = 'isMobile';
	}else{
		$deviceShow = 'isDesktop';
	}
	if ( $isTablet ){
		$deviceShow .= 'isTablet';
	}
	$deviceShow .= ( $temp_ip ? '_not_show_ads_mmo' : '' );

	$string_keyword_search = 'page_siteId:'.$site_id.'template:'.$template;
	if ( $page == 'search' ){
		if(isset($keywordsearch) && $keywordsearch) {
			$string_keyword_search .= '_keyword:'.$keywordsearch;
		}
		if ( $task == 'searchGroup' && $group ){
			$string_keyword_search .= '_group:'.$group;
		}
	}elseif ( $page == 'categories' ){
		if( isset($_POST['p']) && $_POST['p']) { $string_keyword_search .= 'p:' . $_POST['p']; }
	}elseif ( $page == 'instant_article' ){
		if( isset($alias) && $alias) { $string_keyword_search .= 'alias:' . $alias; }
		if( isset($id) && $id) { $string_keyword_search .= 'id:' . $id; }
	}
	if(isset($_POST['id'])) { $getid = $_POST['id']; } elseif(isset($_GET['id'])) { $getid = $_GET['id']; } elseif(isset($_GET['alias'])){$getid = $_GET['alias'];} else { $getid = 0; }
	$getid = preg_replace('/[^a-zA-Z0-9\._]/', '', $getid);
	$smartyId = $page . '_' . ( (isset($task) && $task) ? $task : '') . '_' . $getid . '_' . ($site_id ? 'site_id'. $site_id : '') . $string_keyword_search . $deviceShow;

	$smarty->caching = 2;
	$smarty->cache_lifetime = $cacheTime;
	$smarty->cache_dir = PG_ROOT.DIRECTORY_SEPARATOR.'_cache'.DIRECTORY_SEPARATOR.'smarty';
}

$page = ( isset($set_page) && $set_page && file_exists('templates/themes/' . $template . '/' . $set_page . '.tpl') ) ? $set_page : $page;
$smarty->assign('set_page', $page);

if ( $page == 'error' || $page == 'init' || $page == 'landingpage' || $page == 'instant_article' ){
	if ( $page == 'error' || $page == 'init' ){
        $smarty->template_dir = PG_ROOT.DIRECTORY_SEPARATOR.'templates';
		$page = 'page';
        $smarty->display( PG_ROOT . DIRECTORY_SEPARATOR. 'templates' . DIRECTORY_SEPARATOR . "$page.tpl");
    }else if ( $page == 'instant_article' ){
		$smarty->template_dir = PG_ROOT.DIRECTORY_SEPARATOR.'templates';
		$page = 'instant_article';
		$smarty->display( PG_ROOT . DIRECTORY_SEPARATOR. 'templates' . DIRECTORY_SEPARATOR . "$page.tpl");
	}
	else{
		$smartyId = $item->data['landingpage_code'] . '-' . $item->data['landingpage_id'];
        $smarty->template_dir = PG_ROOT.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'landingpage'.DIRECTORY_SEPARATOR.'proland';
        $smarty->display( PG_ROOT . DIRECTORY_SEPARATOR. 'templates' . DIRECTORY_SEPARATOR . 'landingpage'.DIRECTORY_SEPARATOR.'proland'.DIRECTORY_SEPARATOR."$page.tpl", $smartyId);
    }
	exit();
}
if ( $template ){
    echo $template;
	$template_root = PG_ROOT . DIRECTORY_SEPARATOR. 'templates';

	if ( ($page == 'content') && $isMobile && $setting['setting_mobile_amp'] ){
		$template_display = $template_root . DIRECTORY_SEPARATOR . 'mobile.themes' . DIRECTORY_SEPARATOR . 'amp.'.$template;
		$url_templates_display = PG_URL_HOMEPAGE . 'templates/mobile.themes/amp.'.$template.'/';
	}else{
		$template_display = $template_root . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $template;
		$url_templates_display = PG_URL_HOMEPAGE . 'templates/themes/' . $template . '/';

		if ( $siteDisplay['site_template_mobile'] && $isMobile ) {
			$template_display = $template_root . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $template . DIRECTORY_SEPARATOR . 'mobiles';
			$url_templates_display = PG_URL_HOMEPAGE . 'templates/themes/' . $template . '/mobiles/';
			if ( $siteDisplay['site_template_mobile_name'] ){
				$template_display = $template_root . DIRECTORY_SEPARATOR . 'mobile.themes' . DIRECTORY_SEPARATOR . $siteDisplay['site_template_mobile_name'];
				$url_templates_display = PG_URL_HOMEPAGE . 'templates/mobile.themes/'.$siteDisplay['site_template_mobile_name'].'/';
			}
		}

		if ( $siteDisplay['site_template_tablet'] && $isTablet ) {
			$template_display = $template_root . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . $template . DIRECTORY_SEPARATOR . 'tablets';
			$url_templates_display = PG_URL_HOMEPAGE . 'templates/themes/' . $template . '/tablets/';
			if ( $siteDisplay['site_template_tablet_name'] ){

			}
		}
	}

	define('TEMPLATE_ROOT', $template_root);
	define('TEMPLATE_DISPLAY', $template_display);

	$smarty->assign('dir_root_display', TEMPLATE_ROOT);
	$smarty->assign('dir_template_display', TEMPLATE_DISPLAY);
	$smarty->assign('url_template_display', $url_templates_display);
	$smarty->assign('template', $template);
	if ( PAGE_CACHE )
		$smarty->display( TEMPLATE_DISPLAY . DIRECTORY_SEPARATOR . "$page.tpl", $smartyId);
	else
		$smarty->display( TEMPLATE_DISPLAY . DIRECTORY_SEPARATOR . "$page.tpl");
}else{
	if ( PAGE_CACHE )
		$smarty->display("$page.tpl", $smartyId);
	else
		$smarty->display("$page.tpl");
}

if(PG_DEBUG && isset($_benchmark) && is_object($_benchmark))
{
	$_benchmark->end('output');
	$_benchmark->end('total');

	$smarty->assign('debug_benchmark', $_benchmark->getLog());
	$smarty->assign('debug_benchmark_total', $_benchmark->getTotalTime());

	// DEBUG CACHE
	$time_now 		= date('H:i:s - d-m-Y', TIME_NOW);
	$html_debug 	= CGlobal::$query_debug;
	$conn_debug 	= CGlobal::$conn_debug;

	$debug_cache = "<div style='text-align:center'><span style='color:#666;'>$conn_debug</span></div>";
	$debug_cache .= "<div align='center'><strong>Server IP address : <span style='color:red'>{$_SERVER['SERVER_ADDR']}</span> - Time now is : <span style='color:red'>{$time_now}</span></strong></div>";
	$debug_cache .= $html_debug;

	if(CGlobal::$error_handle){
		$debug_cache .= "<table width='95%' border='1' cellpadding='6' cellspacing='0' bgcolor='#FEFEFE'  align='center'>
		<tr><td style='font-size:14px' bgcolor='#EFEFEF'  align='center'>Payment Error handle</td></tr>
		".CGlobal::$error_handle."
		</table><br />\n\n";
	}

	$smarty->assign('debug_cache', $debug_cache);

	// Save logging info
	file_put_contents(PG_ROOT.'/log/'.$_benchmark->getUid().'.html', $smarty->fetch('debug.tpl'));
}
exit();
?>