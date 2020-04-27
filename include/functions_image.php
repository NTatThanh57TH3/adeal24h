<?php
/**
 * @author ngockv@gmail.com
 * @copyright 2013
 */
require_once "define.table.php";
require_once 'crawling/simple_html_dom.php';

if ( check_on_localhost() ){
    if ( $database_name  == 'cmscdbk_cms'){
        define('SERVER_IMAGES', 1);
        define('PG_URL_IMAGE_TEMP', 'https://caodangyduochcm.vn/');
    }elseif ( $database_name  == 'cdngoaingu_eduvn'){
		define('SERVER_IMAGES', 1);
		define('PG_URL_IMAGE_TEMP', 'https://caodangngoainguhn.edu.vn/');
	}else{
		define('SERVER_IMAGES', 0);
	}
	define('TINY_THUMBNAIL', 1);
}else{
	define('SERVER_IMAGES', 0);
	define('TINY_THUMBNAIL', 1);
}

define('GD_Library', 0);
define('TIMTHUMB_SHOW', 1);
define('WTMARSK', 0);

//CDN
define('URL_CDN','http://cdn.baohatay.com.vn');
define('CDN_PATH','/domains/baohatay.com.vn/public_html/cdn/images/');

//Save To CDN
function SaveToCDN($file,$table,$name)
{
    // connect and login to FTP server
    $ftp_server = "123.31.41.32";
    $ftp_conn = ftp_connect($ftp_server,21) or die("Could not connect to $ftp_server");
    $ftp_username="ftp@baohatay.com.vn";
    $ftp_userpass="5JJQNMiX";
    ftp_login($ftp_conn, $ftp_username, $ftp_userpass)  or die("Cannot login");
    ftp_pasv($ftp_conn, true) or die("Cannot switch to passive mode");

    $check_file_exist = ftp_size($ftp_conn,CDN_PATH.$table.$name);
    if(!empty($check_file_exist) && $check_file_exist >=0)
    {
        return false;
    }

    $check_dir_exist = is_dir('ftp://'.$ftp_username.':'.$ftp_userpass.'@'.$ftp_server.CDN_PATH.$table);
    if(!$check_dir_exist)
    {
        ftp_mkdir($ftp_conn,CDN_PATH.$table);
    }

    if (ftp_put($ftp_conn, CDN_PATH.$table.'/'.$name,$file, FTP_BINARY))
    {
        ftp_close($ftp_conn);
        return  CDN_PATH.$table.'/'.$name;
    }
    else
    {
        ftp_close($ftp_conn);
        return false;
    }
}



//Upload Image CDN
function uploadImageCDN($fileName, $tmp_name, $nameTable, $slug, $maxwidth = false){
    if (!is_null($fileName) || !is_null($tmp_name) || !is_null($nameTable)){
        $name_folder = str_replace(prefix_table, "", $nameTable);
        $imagename = get_new_file_name($fileName, $slug."-");

        if (SERVER_IMAGES ){
            if ( !SaveToCDN($tmp_name, $name_folder,$imagename) ) return false;

        }else{
            if ( !SaveToCDN($tmp_name, $name_folder,$imagename) ) return false;
        }
    }
    return $imagename;
}

/* ----------------------------------------End CDN-------------------------------------------------*/
/*
 * Avatar
 */
function showAvatar($mystring, $rootUrl = false, $get_admin = false){
	global $admin, $user, $check_on_localhost;

	if ( !$rootUrl ){
		if ( $admin->admin_exists && $admin->admin_info['admin_avatar_info'] ){
			$rootUrl = $admin->admin_info['admin_avatar_info'];
		}else{
			$rootUrl = PG_URL_HOMEPAGE;
			if ( SERVER_IMAGES ){
				if ( $check_on_localhost ){
					$rootUrl = PG_URL_IMAGE_TEMP;
				}else{
					$rootUrl = PG_URL_IMAGE;
				}
			}
		}
	}
	if ( !$admin && $get_admin ){
		$admin = true;
	}
	$dir = "images/".($admin ? 'admins': 'users')."/";

	if ( $admin ){
		if ($mystring !="")
			$url = $rootUrl . $dir . $mystring;
		else
			$url = $rootUrl . "images/admin/users/no_avatar.png";
		return $url;
	}
}
/*
 * Show image for subject table
 */
function showImageSubject($mystring, $nameTable, $image_params = false){
	global $setting, $check_on_localhost, $site_access, $domain;

	$aryString = explode("/", $mystring);
	if ( is_array($aryString) && (count($aryString) > 1) && ($nameTable != 'photos') ){
		$endString = end($aryString);
		return showImageSubjectDomain($mystring, $nameTable, $endString, $image_params);
	}

	$check_is_url = false;
	if ( filter_var($mystring, FILTER_VALIDATE_URL) !== FALSE || ( strpos($mystring, 'http') !== false )) {
		$check_is_url = true;
	}


	if ( !$mystring && $nameTable == 'favicons' ){
		$favicion = PG_URL_HOMEPAGE . "images/icon-refresh.png";
		return $favicion;
	}
	
	if ( !$mystring || !$nameTable){
		if (file_exists('images/'.$setting['setting_domain'].'.png'))
			return PG_URL_HOMEPAGE . "images/".$setting['setting_domain'].".png";
		else
			return PG_URL_IMAGE . "images/no_image.png";
	}

	$folder = str_replace("tbl_", "", $nameTable);
	if ( $folder == 'categories' ){
		$folder = 'categorys';
	}
	$dir = "images/".$folder."/";

	if ( $nameTable == "photos" ){
		$dir = "";
	}

	if ( !SERVER_IMAGES ){
		if ($mystring !="")
			$url = PG_URL_HOMEPAGE . $dir . $mystring;
		else{
			$url = PG_URL_HOMEPAGE . "images/no_image.png";
			if ( $nameTable == 'favicons' ){
				$favicion = PG_URL_HOMEPAGE . "images/icon-refresh.png";
				return $favicion;
			}
			if (file_exists('images/'.$setting['setting_domain'].'.png')){
				$url = PG_URL_HOMEPAGE . "images/".$setting['setting_domain'].".png";
			}
		}
	}else{
		if ( $check_on_localhost ){
			if ($mystring !="")
				$url = PG_URL_IMAGE_TEMP . $dir . $mystring;
			else{
				$url = PG_URL_IMAGE_TEMP . "images/no_image.png";
				if ( $nameTable == 'favicons' ){
					$favicion = PG_URL_HOMEPAGE . "images/icon-refresh.png";
					return $favicion;
				}
				if (file_exists('images/'.$setting['setting_domain'].'.png')){
					$url = PG_URL_HOMEPAGE . "images/".$setting['setting_domain'].".png";
				}
			}
		}else{
			if ($mystring !="")
				$url = PG_URL_IMAGE . $dir . $mystring;
			else{
				$url = PG_URL_IMAGE . "images/no_image.png";
				if ( $nameTable == 'favicons' ){
					$favicion = PG_URL_HOMEPAGE . "images/icon-refresh.png";
					return $favicion;
				}
				if (file_exists('images/'.$setting['setting_domain'].'.png')){
					$url = PG_URL_HOMEPAGE . "images/".$setting['setting_domain'].".png";
				}
			}
		}
	}

	if ( $check_is_url ){
		$url = $mystring;
		return $url;
	}

	if ( !TINY_THUMBNAIL ){
		return $url;
	}
	if ( !$setting['use_resize_image'] ){
		return $url;
	}
	$site_is_product = false;
	foreach ($site_access as $key_ac => $access) {
		if ( $access == SITE_PRODUCT ){
			$site_is_product = true;
		}
	}
	if ( $site_is_product && !$setting['use_resize_image_product'] ){
		return $url;
	}

	// timthumb image
	$width = 68;
	$height = 68;
	if ( $image_params && $image_params == 'banner' ) {
		return $url;
	}else if ( $image_params && $image_params == 'tiny' ){
		if ( $nameTable == TBL_PRODUCT  ){
			$width = $setting['resize_image_tiny'];
			$height = $setting['resize_image_tiny_height'];
		}else{
			$width = $setting['resize_news_image_tiny'];
			$height = $setting['resize_news_image_tiny_height'];
		}
	}else if ( $image_params && $image_params == 'thumbnail' ){
		if ( $nameTable == TBL_PRODUCT  ){
			$width = $setting['resize_image_min'];
			$height = $setting['resize_image_min_height'];
		}else{
			$width = $setting['resize_news_image_thumbnail'];
			$height = $setting['resize_news_image_thumbnail_height'];
		}
	}else if ( $image_params && $image_params == 'normal' ){
		if ( $nameTable == TBL_PRODUCT  ){
			$width = $setting['resize_image_normal'];
			$height = $setting['resize_image_normal_height'];
		}else{
			$width = $setting['resize_news_image_normal'];
			$height = $setting['resize_news_image_normal_height'];
		}
	}else if ( $image_params && $image_params == 'large' ){
		if ( $nameTable == TBL_PRODUCT  ){
			$width = $setting['resize_image_max'];
			$height = $setting['resize_image_max_height'];
		}else{
			$width = $setting['resize_news_image_large'];
			$height = $setting['resize_news_image_large_height'];
		}
	}else if ( $image_params && is_array($image_params) ){
		$width 	= ( isset($image_params['width']) && $image_params['width'] ) ? $image_params['width'] : ( $setting['resize_image_max'] ? $setting['resize_image_max'] : $setting['resize_news_image_large']);
		$height = ( isset($image_params['height']) && $image_params['height'] ) ? $image_params['height'] : ( $setting['resize_image_max_height'] ? $setting['resize_image_max_height'] : $setting['resize_news_image_large_height']);
	}else{
		$width 	= $setting['resize_image_normal'] ? $setting['resize_image_normal'] : $setting['resize_news_image_normal'];
		$height = $width;
	}
	if ( !$width && !$height ){
		$width = 68;
		$height = 68;
	}else if ( $width && !$height ){
		$height = $width;
	}else if ( $height && !$width ){
		$width = $height;
	}

	if ( $check_is_url ){
		$aryString = explode("/", $mystring);
		$mystring = array_values(array_slice($aryString, -1))[0];
	}

	if ( GD_Library ){
		$namefileUrl = explode("/", $url);
		$filenameImage = explode(".", (end($namefileUrl)));
		$namefile = $filenameImage[0];
		$ext = $filenameImage[1];

		$ImageMaker =   new ImageFactory();
		$destination    = $namefile.'-'.$width.'-'.$height . '.' . $ext;
		$ImageMaker->Thumbnailer($url,$width,$height,$destination);
		$gd_thumbnail = $url;
		return $gd_thumbnail;
	}

	if ( WTMARSK && $setting['setting_show_logo_to_image'] ){
        // Sau timthumb url bắt buộc phải là tên domain
        if ( $check_on_localhost ){
            global $domain;
            $http = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") ? "https://" : "http://";
            $url_domain = $http.$domain . '/';
        }else{
            $url_domain = PG_URL_HOMEPAGE;
        }
	    $wtmarsk_url = PG_URL_HOMEPAGE . 'timthumb.php?h='.$height.'&w='.$width.'&src='.$url_domain.'wtmarsk.php?src=' . $url;
        return $wtmarsk_url;
    }

	if ( TIMTHUMB_SHOW ){
		$timthumb_url = ( $check_on_localhost ? ( PG_URL_IMAGE_TEMP ? PG_URL_IMAGE_TEMP : PG_URL_HOMEPAGE ) : (PG_URL_IMAGE ? PG_URL_IMAGE : PG_URL_HOMEPAGE) )  . 'timthumb.php?src=' . $url . '&h='.$height.'&w='.$width;
		return $timthumb_url;
	}

	if ( $check_on_localhost )
		$timthumb_url = ( PG_URL_IMAGE_TEMP ? PG_URL_IMAGE_TEMP : PG_URL_HOMEPAGE ) . 'include/wideimage-11.02.19/image.php?image='.$mystring.'&url='.$url.'&colors=255&dither=1&match_palette=1&typeresize=resize&width='.$width.'&height='.$height;
	else
		$timthumb_url = ( PG_URL_IMAGE ? PG_URL_IMAGE : PG_URL_HOMEPAGE ) . 'include/wideimage-11.02.19/image.php?image='.$mystring.'&url='.$url.'&colors=255&dither=1&match_palette=1&typeresize=resize&width='.$width.'&height='.$height;

	return $timthumb_url;

}

function showImageSubjectDomain($mystring, $nameTable, $name_file, $image_params = false){
	global $setting, $check_on_localhost, $site_access;

	$check_is_url = false;
	if ( filter_var($mystring, FILTER_VALIDATE_URL) !== FALSE || ( strpos($mystring, 'http') !== false )) {
		$check_is_url = true;
	}
	if ( $check_is_url ){
		$url = $mystring;
		return $url;
	}

	$url = ( $check_on_localhost ? ( PG_URL_IMAGE_TEMP ? PG_URL_IMAGE_TEMP : PG_URL_HOMEPAGE ) : (PG_URL_IMAGE ? PG_URL_IMAGE : PG_URL_HOMEPAGE) ) . "images/".$mystring;
	if ( !TINY_THUMBNAIL ){
		return $url;
	}
	if ( !$setting['use_resize_image'] ){
		return $url;
	}
	$site_is_product = false;
	foreach ($site_access as $key_ac => $access) {
		if ( $access == SITE_PRODUCT ){
			$site_is_product = true;
		}
	}
	if ( $site_is_product && !$setting['use_resize_image_product'] ){
		return $url;
	}

	// timthumb image
	$width = 68;
	$height = 68;
	if ( $image_params && $image_params == 'banner' ) {
		return $url;
	}else if ( $image_params && $image_params == 'tiny' ){
		if ( $nameTable == TBL_PRODUCT  ){
			$width = $setting['resize_image_tiny'];
			$height = $setting['resize_image_tiny_height'];
		}else{
			$width = $setting['resize_news_image_tiny'];
			$height = $setting['resize_news_image_tiny_height'];
		}
	}else if ( $image_params && $image_params == 'thumbnail' ){
		if ( $nameTable == TBL_PRODUCT  ){
			$width = $setting['resize_image_min'];
			$height = $setting['resize_image_min_height'];
		}else{
			$width = $setting['resize_news_image_thumbnail'];
			$height = $setting['resize_news_image_thumbnail_height'];
		}
	}else if ( $image_params && $image_params == 'normal' ){
		if ( $nameTable == TBL_PRODUCT  ){
			$width = $setting['resize_image_normal'];
			$height = $setting['resize_image_normal_height'];
		}else{
			$width = $setting['resize_news_image_normal'];
			$height = $setting['resize_news_image_normal_height'];
		}
	}else if ( $image_params && $image_params == 'large' ){
		if ( $nameTable == TBL_PRODUCT  ){
			$width = $setting['resize_image_max'];
			$height = $setting['resize_image_max_height'];
		}else{
			$width = $setting['resize_news_image_large'];
			$height = $setting['resize_news_image_large_height'];
		}
	}else if ( $image_params && is_array($image_params) ){
		$width 	= ( isset($image_params['width']) && $image_params['width'] ) ? $image_params['width'] : ( $setting['resize_image_max'] ? $setting['resize_image_max'] : $setting['resize_news_image_large']);
		$height = ( isset($image_params['height']) && $image_params['height'] ) ? $image_params['height'] : ( $setting['resize_image_max_height'] ? $setting['resize_image_max_height'] : $setting['resize_news_image_large_height']);
	}else{
		$width 	= $setting['resize_image_normal'] ? $setting['resize_image_normal'] : $setting['resize_news_image_normal'];
		$height = $width;
	}
	if ( !$width && !$height ){
		$width = 68;
		$height = 68;
	}else if ( $width && !$height ){
		$height = $width;
	}else if ( $height && !$width ){
		$width = $height;
	}

	if ( GD_Library ){
		$namefileUrl = explode("/", $url);
		$filenameImage = explode(".", (end($namefileUrl)));
		$namefile = $filenameImage[0];
		$ext = $filenameImage[1];

		$ImageMaker =   new ImageFactory();
		$destination    = $namefile.'-'.$width.'-'.$height . '.' . $ext;
		$ImageMaker->Thumbnailer($url,$width,$height,$destination);
		$gd_thumbnail = $url;
		return $gd_thumbnail;
	}

	if ( TIMTHUMB_SHOW ){
		$timthumb_url = ( $check_on_localhost ? ( PG_URL_IMAGE_TEMP ? PG_URL_IMAGE_TEMP : PG_URL_HOMEPAGE ) : (PG_URL_IMAGE ? PG_URL_IMAGE : PG_URL_HOMEPAGE) )  . 'timthumb.php?src=' . $url . '&h='.$height.'&w='.$width;
		return $timthumb_url;
	}

	if ( $check_on_localhost )
		$timthumb_url = ( PG_URL_IMAGE_TEMP ? PG_URL_IMAGE_TEMP : PG_URL_HOMEPAGE ) . 'include/wideimage-11.02.19/image.php?image='.$name_file.'&url='.$url.'&colors=255&dither=1&match_palette=1&typeresize=resize&width='.$width.'&height='.$height;
	else
		$timthumb_url = ( PG_URL_IMAGE ? PG_URL_IMAGE : PG_URL_HOMEPAGE ) . 'include/wideimage-11.02.19/image.php?image='.$name_file.'&url='.$url.'&colors=255&dither=1&match_palette=1&typeresize=resize&width='.$width.'&height='.$height;

	return $timthumb_url;
}

/*
 * Upload for image
 */
function uploadImage($fileName, $tmp_name, $nameTable, $slug, $maxwidth = false){
	if (!is_null($fileName) || !is_null($tmp_name) || !is_null($nameTable)){
		$name_folder = str_replace(prefix_table, "", $nameTable);
		$imagename = get_new_file_name($fileName, $slug."-");

        $cdn = false;
		if($cdn)
        {
            return uploadImageCDN($fileName, $tmp_name, $nameTable, $slug, $maxwidth = false);
        }

		
		if ( SERVER_IMAGES ){
			$src = "http://images.trogia24h.com/images/partners/large-sochi-drink-1430219067.jpg";
			$dest = PATH_SERVER_IMAGES . "images/" . basename($src);
			file_put_contents($dest, file_get_contents($src));
		}else{
			$dir=PG_ROOT."/images/".$name_folder."/";
			if(!is_dir($dir)){
	        	mkdir($dir,0777,true);
	        }
			if(file_exists(PG_ROOT."/images/".$name_folder."/".$imagename)){return false;}
			if ( !move_uploaded_file($tmp_name, $dir.$imagename) ) return false;
			if ($maxwidth)
				Resize_File($imagename, PG_ROOT."/images/".$name_folder."/", $maxwidth);
			else{
				$url = PG_URL_HOMEPAGE . "images/".$name_folder.$imagename;
				$path_info = pathinfo($url);

				$set_name = $path_info['basename'];
				$director_path = pathinfo($path_info['dirname']);
				$set_path = $director_path['basename'];

				resize_image_from_url_and_save($url, $set_name, $set_path, false, false);
			}
		}
	}
	return $imagename;
}

/*
 * Copy images resize
 */
function copyImageResize($fileName, $nameTable, $newwidth = NULL, $newheight = NULL){
	if (!is_null($fileName) || !is_null($nameTable)){
		$name_folder = str_replace(prefix_table, "", $nameTable);
		if(file_exists(PG_ROOT."/images/".$name_folder."/".$fileName)) {
			//$name='newpicfile';
			$url=PG_ROOT."/images/".$name_folder."/".$fileName;
			// create the context
			set_time_limit(-1);
			$img = file_get_contents($url);
			//////// GET IMAGE NAME
			
			$url_arr = explode ('/', $url);
			$ct = count($url_arr);
			$name = $url_arr[$ct-1];
			$name_div = explode('.', $name);
			$ct_dot = count($name_div);
			$img_type = $name_div[$ct_dot -1];
			$name='thumbnail-'.$name;
			/////// GET IMAGE NAME END
			
			$im = imagecreatefromstring($img);
			$width = imagesx($im);
			$height = imagesy($im);
			if ($newwidth && $newheight){
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			}else{
				$thumb = imagecreatetruecolor($width, $height);
			}
			imagejpeg($thumb,PG_ROOT."/images/".$name_folder."/".$name); //save image as jpg
		}
	}
	return $name;
}

/*
 * Remove image
 */
function removeImage($fileName, $nameTable){
	if (!is_null($fileName) && !is_null($nameTable)){
		$name_folder = str_replace(prefix_table, "", $nameTable);
		if(file_exists(PG_ROOT."/images/".$name_folder."/".$fileName)) {
			@unlink(PG_ROOT."/images/".$name_folder."/".$fileName);
		}
	}
	return;
}

/*
 * Change files name
 */
function get_new_file_name($old_name,$prefix)
{
	$ext=strstr($old_name,".");
	return $prefix.time().$ext;
}

function get_new_file_name_no_plus_time($old_name,$prefix){
	$ext=strstr($old_name,".");
	return $prefix.$ext;
}

/*
 * Resize files Image
 */
function Resize_File($file, $directory, $max_width = 0, $max_height = 0)
{
	global $config;
	
	$full_file = $directory.$file;
	
	$size = getimagesize($full_file);

	//determine the MIME type
	switch($size["mime"])
	{
		case 'image/gif':
			//image is a gif
			$img = imagecreatefromgif($full_file);
			break;
		case 'image/jpeg':
		case 'image/jpg':
			//image is a jpeg
			$img = imagecreatefromjpeg($full_file);
			break;
		case 'image/png':
			//image is a png
			$img = imagecreatefrompng($full_file);
			break;
	}
	
	/*
	if (preg_match("/.png$/", $full_file))
	{
	$img = imagecreatefrompng($full_file);
	}
	
	if (preg_match("/.(jpg|jpeg)$/", $full_file))
	{
	$img = imagecreatefromjpeg($full_file);
	}
	
	if (preg_match("/.gif$/", $full_file))
	{
	$img = imagecreatefromgif($full_file);
	}
	*/
	
	$FullImage_width = imagesx($img);
	$FullImage_height = imagesy($img);
	
	if (isset($max_width) && isset($max_height) && $max_width != 0 && $max_height != 0)
	{
	$new_width = $max_width;
	$new_height = $max_height;
	}
	elseif (isset($max_width) && $max_width != 0)
	{
	$new_width = $max_width;
	$new_height = ((int)($new_width * $FullImage_height) / $FullImage_width);
	}
	elseif (isset($max_height) && $max_height != 0)
	{
	$new_height = $max_height;
	$new_width = ((int)($new_height * $FullImage_width) / $FullImage_height);
	}
	else
	{
	$new_height = $FullImage_height;
	$new_width = $FullImage_width;
	}
	
	$full_id = imagecreatetruecolor($new_width, $new_height);
	imagecopyresampled($full_id, $img, 0, 0, 0, 0, $new_width, $new_height, $FullImage_width, $FullImage_height);
	
	
	switch($size["mime"])
	{
		case 'image/gif':
			//image is a gif
			$full = imagegif($full_id, $full_file);
			break;
		case 'image/jpeg':
		case 'image/jpg':
			//image is a jpeg
			$full = imagejpeg($full_id, $full_file, 100);
			break;
		case 'image/png':
			//image is a png
			$full = imagepng($full_id, $full_file);
			break;
	}
	
	imagedestroy($full_id);
	unset($max_width);
	unset($max_height);
}

/*
 * Resize image
 * Method:
 * * resize_image('crop','penguin.jpg','penguin_crop.jpg',100,100);
 * * resize_image('max','penguin.jpg','penguin_max.jpg',100,100);
 * * resize_image('force','penguin.jpg','penguin_force.jpg',100,100);
 */
function resize_image($method,$image_loc,$new_loc,$width,$height) {
	if (!is_array(@$GLOBALS['errors'])) { $GLOBALS['errors'] = array(); }

	if (!in_array($method,array('force','max','crop'))) { $GLOBALS['errors'][] = 'Invalid method selected.'; }

	if (!$image_loc) { $GLOBALS['errors'][] = 'No source image location specified.'; }
	else {
		if ((substr(strtolower($image_loc),0,7) == 'http://') || (substr(strtolower($image_loc),0,7) == 'https://')) { /*don't check to see if file exists since it's not local*/ }
		elseif (!file_exists($image_loc)) { $GLOBALS['errors'][] = 'Image source file does not exist.'; }
		$extension = strtolower(substr($image_loc,strrpos($image_loc,'.')));
		if (!in_array($extension,array('.jpg','.jpeg','.png','.gif','.bmp'))) { $GLOBALS['errors'][] = 'Invalid source file extension!'; }
	}

	if (!$new_loc) { $GLOBALS['errors'][] = 'No destination image location specified.'; }
	else {
		$new_extension = strtolower(substr($new_loc,strrpos($new_loc,'.')));
		if (!in_array($new_extension,array('.jpg','.jpeg','.png','.gif','.bmp'))) { $GLOBALS['errors'][] = 'Invalid destination file extension!'; }
	}

	$width = abs(intval($width));
	if (!$width) { $GLOBALS['errors'][] = 'No width specified!'; }

	$height = abs(intval($height));
	if (!$height) { $GLOBALS['errors'][] = 'No height specified!'; }

	if (count($GLOBALS['errors']) > 0) { echo_errors(); return false; }

	if (in_array($extension,array('.jpg','.jpeg'))) { $image = @imagecreatefromjpeg($image_loc); }
	elseif ($extension == '.png') { $image = @imagecreatefrompng($image_loc); }
	elseif ($extension == '.gif') { $image = @imagecreatefromgif($image_loc); }
	elseif ($extension == '.bmp') { $image = @imagecreatefromwbmp($image_loc); }

	if (!$image) { $GLOBALS['errors'][] = 'Image could not be generated!'; }
	else {
		$current_width = imagesx($image);
		$current_height = imagesy($image);
		if ((!$current_width) || (!$current_height)) { $GLOBALS['errors'][] = 'Generated image has invalid dimensions!'; }
	}
	if (count($GLOBALS['errors']) > 0) { @imagedestroy($image); echo_errors(); return false; }

	if ($method == 'force') { $new_image = resize_image_force($image,$width,$height); }
	elseif ($method == 'max') { $new_image = resize_image_max($image,$width,$height); }
	elseif ($method == 'crop') { $new_image = resize_image_crop($image,$width,$height); }

	if ((!$new_image) && (count($GLOBALS['errors'] == 0))) { $GLOBALS['errors'][] = 'New image could not be generated!'; }
	if (count($GLOBALS['errors']) > 0) { @imagedestroy($image); echo_errors(); return false; }

	$save_error = false;
	if (in_array($extension,array('.jpg','.jpeg'))) { imagejpeg($new_image,$new_loc) or ($save_error = true); }
	elseif ($extension == '.png') { imagepng($new_image,$new_loc) or ($save_error = true); }
	elseif ($extension == '.gif') { imagegif($new_image,$new_loc) or ($save_error = true); }
	elseif ($extension == '.bmp') { imagewbmp($new_image,$new_loc) or ($save_error = true); }
	if ($save_error) { $GLOBALS['errors'][] = 'New image could not be saved!'; }
	if (count($GLOBALS['errors']) > 0) { @imagedestroy($image); @imagedestroy($new_image); echo_errors(); return false; }

	imagedestroy($image);
	imagedestroy($new_image);

	return true;
}

/*
 * Upload files
 */
function uploadFiles($fileName, $tmp_name, $nameTable, $slug){
	if (!is_null($fileName) || !is_null($tmp_name) || !is_null($nameTable)){
		$name_folder = showNameFolder($nameTable);
		$files = get_new_file_name($fileName, $slug."-");
		$dir=PG_ROOT."/images/".$name_folder."/";
		if(!is_dir($dir)){
        	mkdir($dir,0777,true);
        }
		if(file_exists(PG_ROOT."/images/".$name_folder."/".$files)){return false;}
		move_uploaded_file($tmp_name, $dir.$files);
	}
	return $files;
}

/*
 * Remove files
 */
function removeFiles($fileName, $nameTable) {
	removeImage($fileName, $nameTable);
}

/*
 * Remove folder
 */
function DeleteFolder($path)
{
    if (is_dir($path) === true)
    {
        $files = array_diff(scandir($path), array('.', '..'));

        foreach ($files as $file)
        {
            DeleteFolder(realpath($path) . '/' . $file);
        }

        return rmdir($path);
    }

    else if (is_file($path) === true)
    {
        return unlink($path);
    }

    return false;
}

/**
 * Upload ftp server
 */
function PutFilesonFTPServer($host, $user, $pass, $folder, $newfilename,$existingfilename){
	$uploaded = false;
	
	// set up basic connection
	$conn_id = ftp_connect($host);
	
	// login with username and password
	$login_result = ftp_login($conn_id, $user, $pass);
	 
	// get contents of the current directory
	//$contents = ftp_nlist($conn_id, ".");
	 
	 // check connection
	if ((!$conn_id) || (!$login_result)) { 
	   return false;
	}
	$path = PATH_SERVER_IMAGES.'images/'.$folder.'/';
	if(!is_dir($path)){
		mkdir($path,0777,true);
	}
	
	//echo $path.$newfilename; die;
	// upload the file
	if(!@ftp_put($conn_id, $path.$newfilename, $existingfilename, FTP_BINARY)){
		//$uploaded = false;
		echo 'khong thanh cong';
	 }else{
		//$uploaded = true;
		echo 'thanh cong';
	 }
	
	// close the FTP stream 
	ftp_close($conn_id); 
}

function makeThumbnails($updir, $img, $id)
{
    $thumbnail_width = 134;
    $thumbnail_height = 189;
    $thumb_beforeword = "thumb";
    $arr_image_details = getimagesize("$updir" . $id . '_' . "$img"); // pass id to thumb name
    $original_width = $arr_image_details[0];
    $original_height = $arr_image_details[1];
    if ($original_width > $original_height) {
        $new_width = $thumbnail_width;
        $new_height = intval($original_height * $new_width / $original_width);
    } else {
        $new_height = $thumbnail_height;
        $new_width = intval($original_width * $new_height / $original_height);
    }
    $dest_x = intval(($thumbnail_width - $new_width) / 2);
    $dest_y = intval(($thumbnail_height - $new_height) / 2);
    if ($arr_image_details[2] == 1) {
        $imgt = "ImageGIF";
        $imgcreatefrom = "ImageCreateFromGIF";
    }
    if ($arr_image_details[2] == 2) {
        $imgt = "ImageJPEG";
        $imgcreatefrom = "ImageCreateFromJPEG";
    }
    if ($arr_image_details[2] == 3) {
        $imgt = "ImagePNG";
        $imgcreatefrom = "ImageCreateFromPNG";
    }
    if ($imgt) {
        $old_image = $imgcreatefrom("$updir" . $id . '_' . "$img");
        $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
        imagecopyresized($new_image, $old_image, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $original_width, $original_height);
        $imgt($new_image, "$updir" . $id . '_' . "$thumb_beforeword" . "$img");
    }
}

/*
 * resize image from url and save
 */
function resize_image_from_url_and_save( $url_image, $name_image, $path_image, $newwidth = false, $newheight = false ){
	if ( !$url_image || !$name_image || !$path_image )
		return false;

	$img = file_get_contents($url_image);

	$im = imagecreatefromstring($img);

	$get_width = imagesx($im);

	$get_height = imagesy($im);

	if ( !$newwidth )
		$newwidth = $get_width;

	if ( !$newheight )
		$newheight = $get_height;

	$thumb = imagecreatetruecolor($newwidth, $newheight);

	imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $get_width, $get_height);

	imagejpeg($thumb, DIR_ROOT . 'images/' . $path_image . '/' . $name_image); //save image as jpg

	imagedestroy($thumb);

	imagedestroy($im);

	return true;
}

/**
 * Resize and crop image
 */
function resize_and_crop($original_image_url, $thumb_image_url, $thumb_w, $thumb_h, $quality=75)
{
	// ACQUIRE THE ORIGINAL IMAGE: http://php.net/manual/en/function.imagecreatefromjpeg.php
	$original = imagecreatefromjpeg($original_image_url);
	if (!$original) return FALSE;

	// GET ORIGINAL IMAGE DIMENSIONS
	list($original_w, $original_h) = getimagesize($original_image_url);

	// RESIZE IMAGE AND PRESERVE PROPORTIONS
	$thumb_w_resize = $thumb_w;
	$thumb_h_resize = $thumb_h;
	if ($original_w > $original_h)
	{
		$thumb_h_ratio  = $thumb_h / $original_h;
		$thumb_w_resize = (int)round($original_w * $thumb_h_ratio);
	}
	else
	{
		$thumb_w_ratio  = $thumb_w / $original_w;
		$thumb_h_resize = (int)round($original_h * $thumb_w_ratio);
	}
	if ($thumb_w_resize < $thumb_w)
	{
		$thumb_h_ratio  = $thumb_w / $thumb_w_resize;
		$thumb_h_resize = (int)round($thumb_h * $thumb_h_ratio);
		$thumb_w_resize = $thumb_w;
	}

	// CREATE THE PROPORTIONAL IMAGE RESOURCE
	$thumb = imagecreatetruecolor($thumb_w_resize, $thumb_h_resize);
	if (!imagecopyresampled($thumb, $original, 0,0,0,0, $thumb_w_resize, $thumb_h_resize, $original_w, $original_h)) return FALSE;

	// ACTIVATE THIS TO STORE THE INTERMEDIATE IMAGE
	// imagejpeg($thumb, 'thumbs/temp_' . $thumb_w_resize . 'x' . $thumb_h_resize . '.jpg', 100);

	// CREATE THE CENTERED CROPPED IMAGE TO THE SPECIFIED DIMENSIONS
	$final = imagecreatetruecolor($thumb_w, $thumb_h);

	$thumb_w_offset = 0;
	$thumb_h_offset = 0;
	if ($thumb_w < $thumb_w_resize)
	{
		$thumb_w_offset = (int)round(($thumb_w_resize - $thumb_w) / 2);
	}
	else
	{
		$thumb_h_offset = (int)round(($thumb_h_resize - $thumb_h) / 2);
	}

	if (!imagecopy($final, $thumb, 0,0, $thumb_w_offset, $thumb_h_offset, $thumb_w_resize, $thumb_h_resize)) return FALSE;

	// STORE THE FINAL IMAGE - WILL OVERWRITE $thumb_image_url
	if (!imagejpeg($final, $thumb_image_url, $quality)) return FALSE;
	return TRUE;
}

function getimg($url) {
	$headers[] = 'Accept: image/gif, image/x-bitmap, image/jpeg, image/pjpeg';
	$headers[] = 'Connection: Keep-Alive';
	$headers[] = 'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
	$user_agent = 'php';
	$process = curl_init($url);
	curl_setopt($process, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($process, CURLOPT_HEADER, 0);
	curl_setopt($process, CURLOPT_USERAGENT, $user_agent);
	curl_setopt($process, CURLOPT_TIMEOUT, 30);
	curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
	$return = curl_exec($process);
	curl_close($process);
	return $return;
}

/*
 * Crop/Resize Image Function using GD Library
 */
class ImageFactory
{
	protected   $original;
	public      $destination;

	public  function FetchOriginal($file)
	{
		$size                       =   getimagesize($file);
		$this->original['width']    =   $size[0];
		$this->original['height']   =   $size[1];
		$this->original['type']     =   $size['mime'];
		return $this;
	}

	public  function Thumbnailer($thumb_target = '', $width = 60,$height = 60,$SetFileName = false, $quality = 80)
	{
		// Set original file settings
		$this->FetchOriginal($thumb_target);
		// Determine kind to extract from
		if($this->original['type'] == 'image/gif')
			$thumb_img  =   imagecreatefromgif($thumb_target);
		elseif($this->original['type'] == 'image/png') {
			$thumb_img  =   imagecreatefrompng($thumb_target);
			$quality    =   7;
		}
		elseif($this->original['type'] == 'image/jpeg')
			$thumb_img  =   imagecreatefromjpeg($thumb_target);
		else
			return false;
		// Assign variables for calculations
		$w  =   $this->original['width'];
		$h  =   $this->original['height'];
		// Calculate proportional height/width
		if($w > $h) {
			$new_height =   $height;
			$new_width  =   floor($w * ($new_height / $h));
			$crop_x     =   ceil(($w - $h) / 2);
			$crop_y     =   0;
		}
		else {
			$new_width  =   $width;
			$new_height =   floor( $h * ( $new_width / $w ));
			$crop_x     =   0;
			$crop_y     =   ceil(($h - $w) / 2);
		}
		// New image
		$tmp_img = imagecreatetruecolor($width,$height);
		// Copy/crop action
		imagecopyresampled($tmp_img, $thumb_img, 0, 0, $crop_x, $crop_y, $new_width, $new_height, $w, $h);
		// If false, send browser header for output to browser window
		if($SetFileName == false)
			header('Content-Type: '.$this->original['type']);
		// Output proper image type
		if($this->original['type'] == 'image/gif')
			imagegif($tmp_img);
		elseif($this->original['type'] == 'image/png')
			($SetFileName !== false)? imagepng($tmp_img, $SetFileName, $quality) : imagepng($tmp_img);
		elseif($this->original['type'] == 'image/jpeg')
			($SetFileName !== false)? imagejpeg($tmp_img, $SetFileName, $quality) : imagejpeg($tmp_img);
		// Destroy set images
		if(isset($thumb_img))
			imagedestroy($thumb_img);
		// Destroy image
		if(isset($tmp_img))
			imagedestroy($tmp_img);
	}
}
?>