<?php
/**
 * Created by PhpStorm.
 * User: Ngọc Kiều
 * Date: 4/2/2016
 * Time: 8:10 PM
 */
$debug = 0;
$smarty_vertion_3 = 1;

define('PG_URL_HOMEPAGE', 'http://localhost/idea/');
define('ROOT_URL', "http://localhost/idea/");
define('DIR_ROOT', 'F:/wamp/www/idea/');
define('DOMAIN', 'trangchuchuatinh');


// CAODANGNGOAINGU
$database_host = 'localhost';
$database_username = 'database_user';
$database_password = 'password';
$database_name = 'database_name';


define('MEMCACHE_ON', 0);
define('REDIS_ON', 0);
define('PAGE_CACHE', 0); // Cache cho smarty
define('CACHE_ON', 0);
define('CACHE_DB', 0);
define('CACHE_SERVER_NAME', 'localhost/idea/');

define('SETTING_DEBUG_PAPGE', 1);
define('REWRITE_ON', 1);
echo 1;
if( ! ini_get('date.timezone') )
{
    date_default_timezone_set('UTC');
}