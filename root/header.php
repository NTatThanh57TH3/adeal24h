<?php
require dirname(__FILE__) . '/include/config.php';
// SET ERROR REPORTING
if ( $debug ){
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
}else{
    error_reporting(0);
    ini_set('display_errors', FALSE);
}

// CHECK FOR PAGE VARIABLE
if(!isset($page)) { $page = ""; }

// DEFINE SE PAGE CONSTANT
define('PG_BIGPIPE', TRUE);
define('PG_DEBUG', TRUE);
define('PG_PAGE', TRUE);
define('PG_ROOT', realpath(dirname(__FILE__)));
define('PG_HEADER', TRUE);
define('PG_ADMIN_SAFE_MODE', false);
define('DIR_IMAGE', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR);

$webroot=str_replace('\\','/','http://'.$_SERVER['HTTP_HOST']);
$webroot.=$webroot[strlen($webroot)-1]!='/'?'/':'';
define('WEB_ROOT',$webroot);
define('PG_URL_ROOT', WEB_ROOT . implode('/', array_slice(explode('/', $_SERVER['PHP_SELF']), 1, -1)));

// SET ERROR REPORTING
if( PG_DEBUG )
{
    if( file_exists('include/globals/class_firephp.php') )
    {
        include "include/globals/class_firephp.php";
        $fb =& FirePHP::getInstance();
        $fb->registerErrorHandler();
    }
}
else
{
    ini_set('display_errors', FALSE);
    error_reporting(E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_USER_ERROR);
}

// INIT MOBILE
include "include/Mobile_Detect.php";
$detect = new Mobile_Detect();
$isMobile = $detect->isMobile();
$isTablet = $detect->isTablet();

// INCLUDE INFORMATION
include "include/database_config.php";
include "include/define.table.php";
include "include/functions_email.php";
include "include/functions_general.php";
include "include/functions_sites.php";
include "include/functions_image.php";
include "include/functions_upload.php";
include "include/object.php";
include "include/cake/config.php";
include "include/environment/request.php";
include "include/environment/uri.php";
include "include/filter/filterinput.php";

// CACHE & MEMCACHE
require_once 'include/cache/memcache.config.php';
require_once 'include/cache/CGlobal.php';
require_once 'include/cache/CacheLib.php';
if(MEMCACHE_ON){
    CGlobal::$memcache_server=$memcache_server;
    require_once 'include/cache/memcache.class.php';
}
if(REDIS_ON){
    $Redis = new Redis();
    $Redis->connect($redis_server['host'], $redis_server['port']);
    require_once 'include/cache/RedisLib.php';
}

// INCLUDE CORE GLOBALS
include "include/globals/class_database.php";
include "include/globals/class_datetime.php";
include "include/globals/class_error.php";
include "include/globals/class_navigation.php";
include "include/globals/class_rewrite.php";
include "include/globals/class_settings.php";
include "include/globals/class_smarty.php";
include "include/globals/class_theme.php";
include "include/globals/class_validate.php";
include "include/users/class_user.php";

// INITIATE DATABASE CONNECTION
$database =& PGDatabase::getInstance();

// SET LANGUAGE CHARSET
$database->db_set_charset('utf8');

$langCode = "VN";

// OBJECT
$object = new PGObject();

// CREATE DATETIME CLASS
$datetime = new PGDatetime();

// CREATE URL CLASS
$uri = PGURI::getInstance();

// CREATE PGFilterInput
$filter	= new PGFilterInput();

// CREATE PGValidation
$validate = new PGValidation();

// GET REWRITE
$rewriteClass 	= new PGRewrite();
$rewriteUrl		= $rewriteClass->getRewrite();

// Check on localhost
$check_on_localhost = check_on_localhost();

// GET SETTINGS
$settingClass = new PGSettings();
$setting = $settingClass->getSettings();

if ( $setting['setting_debug_page'] ){
    include "include/globals/class_benchmark.php";
    // BENCHMARK
    $_benchmark = PGBenchmark::getInstance('default');

    PG_DEBUG ? $_benchmark->start('total') : NULL;
    PG_DEBUG ? $_benchmark->start('include') : NULL;
}

// CREATE SESSION
$session_options = @unserialize($setting['setting_session_options']);
if( !empty($session_options) )
{
    if( !empty($session_options['storage']) ) Configure::write('Session.save', $session_options['storage']);
    if( !empty($session_options['name']) ) Configure::write('Session.cookie', $session_options['name']);
    if( !empty($session_options['expire']) ) Configure::write('Session.timeout', $session_options['expire']);
}

$session =& PGSession::getInstance(null, true);
$session->engine(@$session_options['storage'], $session_options);

if( defined('PG_SESSION_RESUME') && PG_SESSION_RESUME && isset($session_id) )
{
    $session->_userAgent = md5(env('HTTP_USER_AGENT') . Configure::read('Security.salt'));
    $session->id($session_id);
}
$session->start();

if ( $setting['setting_page_user'] ){
    // CREATE USER OBJECT AND ATTEMPT TO LOG USER IN
    $user = new PGUser();
    $user->user_checkCookies();

    $session->checkSession();
    $session_table_id = $session->getSessionTable();
}

// GET SITE DISPLAY END DATA TEST SITE
$canonical = ( (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" : "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
$parse_canonical = parse_url($canonical);
$domain = $parse_canonical['host'];
$domain = 'daotaochungchi24h.edu.vn';
// Find version AMP
$check_amp = strpos($canonical, ".amp");
if ( $check_amp !== false ){
    $isMobile = true;
}

$siteDisplay = false;
if ( $setting['setting_cache_on'] ){
    $cache_key_st_domain    = 'get_setting_domain:'.$domain;
    $cacheTimeDomain		= 86400*30; // 1 day
    $siteDisplay = CacheLib::get($cache_key_st_domain, $cacheTimeDomain);
}
if ( !$siteDisplay ){
    $siteDisplay = get_site_display($domain);
    if ( $setting['setting_cache_on'] ) {
        CacheLib::set($cache_key_st_domain, $siteDisplay, $cacheTimeDomain);
    }
}

$original_site_id = false;
$site_id = (isset($siteDisplay['site_id']) && $siteDisplay['site_id'] ) ? $siteDisplay['site_id'] : 0;
if ( $site_id ){
    $original_site_id = $site_id;
}

$test_data_site_id = (isset($siteDisplay['test_data_site_id']) && $siteDisplay['test_data_site_id'] ) ? $siteDisplay['test_data_site_id'] : 0;
$site_id = $test_data_site_id ? $test_data_site_id : $site_id;
if ( !$site_id ){
    cheader($uri->base() . 'website-dang-nang-cap.html');
    exit();
}

$site_access = false;
if ( isset($siteDisplay['site_access']) && $siteDisplay['site_access'] ){
    $site_access = explode("|", $siteDisplay['site_access']);
}
if ( !isset($siteDisplay['template_code']) || !$siteDisplay['template_code'] ){
    $template = 'default';
}else{
    $template = ( isset($siteDisplay['template_code']) && $siteDisplay['template_code'] ) ? $siteDisplay['template_code'] : '';
}
$_theme = PGRequest::GetCmd('test_theme', '');
if ( $_theme ){
    $template = $_theme;
}
//$template = 'accesstrade';

// GET SETTING SITE
get_setting_site($site_id, $original_site_id);

if ( $setting['setting_domain_exclude'] && is_array($setting['setting_domain_exclude']) ){
    PGTheme::add_js( PG_URL_HOMEPAGE .'templates/js/seo_follow.js?v=1.13');
}
if ( $setting['setting_admin_edit_fast'] && !$isMobile ){
    // CREATE ADMIN OBJECT AND ATTEMPT TO LOG ADMIN IN
    $not_updaeTime = true;
    include "include/admins/class_admin.php";
    $admin = new PGAdmin();
    $admin->admin_checkCookies();
    if ( $admin->admin_exists ){
        PGTheme::add_css( PG_URL_HOMEPAGE .'templates/css/admin_quick_edit.css');
        PGTheme::add_js( PG_URL_HOMEPAGE .'templates/js/admin_quick_edit.js');
    }
}

// INITIATE SMARTY
if ( $smarty_vertion_3 ){
    $smarty  = new Smarty(); // Smarty version 3.1.34
    //$smarty->testInstall();
} else{
    $smarty =& PGSmarty::getInstance();
}

if ( $template ){
    $smarty->template_dir = PG_ROOT.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'themes'.DIRECTORY_SEPARATOR.$template;
    $pathTemp = PG_ROOT.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'smarty'.DIRECTORY_SEPARATOR.'templates_c'.DIRECTORY_SEPARATOR.$template;
    $template_dir = $smarty->template_dir;
    $pathTemp_dir = $pathTemp;

    if ( $siteDisplay['site_template_mobile'] && $isMobile ){
        $smarty->template_dir = $template_dir . DIRECTORY_SEPARATOR.'mobiles';
        $pathTemp = $pathTemp_dir.DIRECTORY_SEPARATOR.'mobiles';
        if ( $siteDisplay['site_template_mobile_name'] ){
            $smarty->template_dir = PG_ROOT.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'mobile.themes'.DIRECTORY_SEPARATOR.$siteDisplay['site_template_mobile_name'];
            $pathTemp = PG_ROOT.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'smarty'.DIRECTORY_SEPARATOR.'templates_c'.DIRECTORY_SEPARATOR.'mobile.themes'.DIRECTORY_SEPARATOR.$siteDisplay['site_template_mobile_name'];
        }
    }
    if ( $siteDisplay['site_template_tablet'] && $isTablet ){
        $smarty->template_dir = $template_dir . DIRECTORY_SEPARATOR.'tablets';
        $pathTemp = $pathTemp_dir.DIRECTORY_SEPARATOR.'tablets';
    }
    if(!is_dir($pathTemp)){
        mkdir($pathTemp,0777,true);
    }
    $smarty->compile_dir = $pathTemp;
}
// Redirect 404 => domain
if ( isset($_REQUEST['id']) && $_REQUEST['id'] == '404' ){
    cheader($uri->base());
    exit();
}
?>