<?php
$page = "admin_banner";
include "admin_header.php";

require_once "include/develops/class_category.php";
require_once "include/develops/class_static.php";
require_once "include/develops/class_banner.php";

$objCategory 	= new PGCategory();
$objStatic		= new PGStatic();
$objBanner 		= new PGBanner();

$task = PGRequest::GetCmd('task', 'view');
if ($task == 'cancel') $task = 'view';

$objAcl = new PGAcl();
if (!$objAcl->checkPermission($page, $task)) {
	$objAcl->showErrorPage($smarty);
}

// LẤY TẤT CẢ DANH SÁCH CATEGORY
$filter_site_id = PGRequest::getInt('filter_site_id', 0, 'POST');
if ( !$filter_site_id ){
	if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
		$filter_site_id = $admin->admin_site_default['site_id'];
}

$whereCatItem[] = "category_status=1";
if ( $filter_site_id ){
	$whereCatItem[] = "category_site_id = " . $filter_site_id;
}else{
	$whereCatItem[] = "category_site_id IN (".implode(",", array_flip($sites)).")";
}
$listCatItems 	= $objCategory->loadListItems(FALSE, $whereCatItem, " ORDER BY category_ordering ASC, category_id DESC");

//get static groups
$grStatic = $objStatic->groupStatic();

switch($task){
	case 'edit':
	case 'add':
		if ($task == 'edit') $page_title = "Cập nhật quảng cáo";
		else $page_title = "Thêm mới quảng cáo";
		
		$banner_id			= PGRequest::GetInt('banner_id', 0, 'GET');
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if ( !$banner_id ){
			$banner_id = $cid[0];
		}
		$filter_groups 		= PGRequest::getInt('filter_groups', 0, 'POST');
		$filter_category	= PGRequest::getInt('filter_category', 0, 'POST');
		$filter_position 	= PGRequest::getVar('filter_position', '', 'POST');
		
		$thisBanner = $objBanner->load($banner_id);
		if ( $task == 'edit' ){
			$filter_category = $thisBanner->data['banner_category_id'];
		}
		
		$where[] = " category_status=1";
		$where = (count($where) ? ' WHERE '.implode(' AND ', $where) : '');
		$list_option_category = $objCategory->getOptionItems($listCatItems, 0, $filter_category);
		
		//Load position banner
		$lsPosition = $objBanner->loadPosition();
		
		$smarty->assign('list_option_category', $list_option_category);
		$smarty->assign('lsPosition', $lsPosition);
		$smarty->assign('banner_id', $banner_id);
		$smarty->assign('thisBanner', $thisBanner);
		$smarty->assign('filter_groups', $filter_groups);
		$smarty->assign('filter_category', $filter_category);
		$smarty->assign('filter_position', $filter_position);
		break;
		
	case 'save':
		$banner_id_value	= PGRequest::GetInt('banner_id_value', 0, 'POST');
		$banner_site_id 	= PGRequest::GetInt('banner_site_id', 0, 'POST');
		$banner_category_id	= PGRequest::getvar('banner_category_id', '', 'POST');
		$banner_title		= $database->getEscaped(PGRequest::getString('banner_title', '', 'POST'));
		$banner_url			= $database->getEscaped(PGRequest::getString('banner_url', '', 'POST'));
		$banner_position	= $database->getEscaped(PGRequest::getString('banner_position', '', 'POST'));
        $banner_background	= $database->getEscaped(PGRequest::getString('banner_background', '', 'POST'));
		$banner_ordering	= PGRequest::GetInt('banner_ordering', 0, 'POST');
		$banner_status		= PGRequest::GetInt('banner_status', 0, 'POST');
		$is_logo			= PGRequest::GetInt('is_logo', 0, 'POST');
		$banner_description	= $filter->_decode(PGRequest::getVar('banner_description', '', 'post', 'string', PGREQUEST_ALLOWRAW ));
		$banner_created		= $database->getEscaped(PGRequest::getString('banner_created', ''));
		$banner_start_date	= $database->getEscaped(PGRequest::getString('banner_start_date', ''));
		$banner_end_date	= $database->getEscaped(PGRequest::getString('banner_end_date', ''));
		$changeimage		= PGRequest::getInt('changeimage', 0, 'POST');
		$changeimageicon	= PGRequest::getInt('changeimageicon', 0, 'POST');

		if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
			$banner_site_id	= $admin->admin_site_default['site_id'];
		
		if ( $banner_category_id =="homepage" || $banner_category_id =="contact" || $banner_category_id =="partner" ){
			$banner_fix = $banner_category_id;
			$banner_category_id = 0;
			$banner_static_id = 0;
		}else if ( strpos($banner_category_id, "static") !== false ){
			$idStatic = explode("-", $banner_category_id);
			$banner_static_id = $idStatic[1];
			$banner_category_id = 0;
			$banner_fix = "";
		}else{
			$banner_category_id = intval($banner_category_id);
			$banner_static_id = 0;
			$banner_fix = "";
		}
		
		$thisBanner = $objBanner->load($banner_id_value);
		
		if (!$objBanner->is_message){
			$input['banner_category_id']		= $banner_category_id;
			$input['banner_static_id']			= $banner_static_id;
			$input['banner_fix']				= $banner_fix;
			$input['banner_title']				= $banner_title;
			$name_alias							= convertKhongdau($banner_title);
			$input['banner_alias']	 			= generateSlug($name_alias, strlen($name_alias));
			$input['banner_position']			= $banner_position;
			$input['banner_url']				= $banner_url;
			$input['banner_description']		= $banner_description;
			$input['banner_status']				= $banner_status;
			$input['banner_background']         = $banner_background;
			$input['banner_ordering']			= $banner_ordering;
			$input['is_logo']					= $is_logo;
			if (is_null($banner_created))
				$input['banner_created']		= $datetime->timestampToDateTime();
			else
				$input['banner_created']		= $datetime->convertDate($banner_created, "dd/mm/yyyy");
				
			if (is_null($banner_start_date))
				$input['banner_start_date']		= $datetime->timestampToDateTime();
			else
				$input['banner_start_date']		= $datetime->convertDate($banner_start_date, "dd/mm/yyyy");
				
			if (is_null($banner_end_date))
				$input['banner_end_date']		= $datetime->timestampToDateTime();
			else
				$input['banner_end_date']		= $datetime->convertDate($banner_end_date, "dd/mm/yyyy");
				
			if ( $banner_site_id && !$banner_id_value ){
				$input['banner_site_id']		= $banner_site_id;
			}
				
			if ($changeimage == 1){
				//Check file là swf
				if ((($_FILES["image"]["type"] == "application/x-shockwave-flash"))){
					if ($thisBanner->data["banner_id"] > 0){
						if ($thisBanner->data["banner_swf_dir"] != "") removeFiles($thisBanner->data["banner_swf_dir"], str_replace('admin_', '', $page.'s'));
					}
					$input['banner_swf']	= uploadImage($_FILES["image"]["name"], $_FILES["image"]["tmp_name"], str_replace('admin_', '', $page.'s'), $input['banner_alias']);
					$input['banner_images']	= '';
				}else{//Ngược lại là ảnh
					if ($banner_id_value){
						if ($thisBanner->data["banner_images_dir"] != "") removeImage($thisBanner->data["banner_images_dir"], str_replace('admin_', '', $page.'s'));
					}

					$input['banner_images']	= uploadImage($_FILES["image"]["name"], $_FILES["image"]["tmp_name"], str_replace('admin_', '', $page.'s'), $input['banner_alias']);
					$input['banner_swf'] 	= '';
				}
			}
			if ( $changeimageicon ){
				if ($banner_id_value){
					if ($thisBanner->data["banner_icon_dir"] != "") removeImage($thisBanner->data["banner_icon_dir"], str_replace('admin_', '', $page.'s'));
				}
				$input['banner_icon']	= uploadImage($_FILES["imageicon"]["name"], $_FILES["imageicon"]["tmp_name"], str_replace('admin_', '', $page.'s'), 'icon-' . $input['banner_alias']);
                //$input['banner_icon']	= uploadImageCDN($_FILES["imageicon"]["name"], $_FILES["imageicon"]["tmp_name"], str_replace('admin_', '', $page.'s'), 'icon-' . $input['banner_alias']);
			}
			//var_dump($input); die;
			$message = $objBanner->save($thisBanner, $input);
		}else{
			$message = $objBanner->is_message;
		}
		PGError::set_message($message);
		cheader('admin_banner.php');
		break;

	case 'publish':
		$filter_groups 		= PGRequest::getCmd('filter_groups', 0);
		$filter_category	= PGRequest::getCmd('filter_category', 0);
		
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if (count($cid)) {
			$message = $objBanner->published($cid, 1);
			PGError::set_message($message);
			cheader('admin_banner.php?filter_groups='.$filter_groups.'&filter_category='.$filter_category);
		}
		break;

	case 'unpublish':
		$filter_groups 		= PGRequest::getCmd('filter_groups', 0);
		$filter_category	= PGRequest::getCmd('filter_category', 0);
		
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if (count($cid)) {
			$message = $objBanner->published($cid, 0);
			PGError::set_message($message);
			cheader('admin_banner.php?filter_groups='.$filter_groups.'&filter_category='.$filter_category);
		}
		break;

	case 'remove':
		$filter_groups 		= PGRequest::getCmd('filter_groups', 0);
		$filter_category	= PGRequest::getCmd('filter_category', 0);
		
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if (count($cid)) {
			$message = $objBanner->remove($cid);
			PGError::set_message($message);
			cheader('admin_banner.php?filter_groups='.$filter_groups.'&filter_category='.$filter_category);
		}
		break;	

	case 'view':
	default :
		$page_title = "Quản lý quảng cáo";
		
		$search 			= $database->getEscaped(PGRequest::getString('search', '', 'POST'));
		$filter_groups 		= PGRequest::getCmd('filter_groups', 0);
		$filter_site_id 	= PGRequest::getInt('filter_site_id', 0, 'POST');
		$filter_category	= PGRequest::getCmd('filter_category', '');
		if ($filter_category == "homepage" || $filter_category == "contact"){
			$filter_fix = $filter_category;
			$filter_category = 0;
			$filter_static = 0;
		}else if ( strpos($filter_category, "static") !== false ){
			$idStatic = explode("-", $filter_category);
			$filter_static = $idStatic[1];
			$filter_category = 0;
			$filter_fix = "";
		}else{
			$filter_category = intval($filter_category);
			$filter_static = 0;
			$filter_fix = "";
		}
		$filter_position	= $database->getEscaped(PGRequest::getString('filter_position', '', 'POST'));
		$filter_status 		= PGRequest::getInt('filter_status', 3, 'POST');
		
		$p = PGRequest::getInt('p', 1, 'POST');
		$limit = PGRequest::getInt('limit', $setting['setting_list_limit'], 'POST');
		
		$option = $objCategory->getOptionItems($listCatItems, 0, $filter_category, "");
		//Load position banner
		$lsPosition = $objBanner->loadPosition();
		
		//CONDITION
		if ( !$filter_site_id ){
			if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
				$filter_site_id = $admin->admin_site_default['site_id'];
		}
		if ( $filter_site_id ){
			$where[] = "banner_site_id=".$filter_site_id;
		}else{
			$where[] = "banner_site_id IN (".implode(",", array_flip($sites)).")";
		}

		if ($search){
			$where[] = "banner_title LIKE'%$search%'";
		}
		if ($filter_category > 0) {	
			$where[] = "banner_category_id=".$filter_category;
		}
		if ( $filter_static ){
			$where[] = "banner_static_id=".$filter_static;
		}
		if ( $filter_fix ){
			$where[] = "banner_fix ='$filter_fix'";
		}
		if ($filter_position != "") {	
			$where[] = "banner_position ='$filter_position'";
		}
		if ($filter_status == 0) {			
			$where[] = "banner_status=0";
		}else if ($filter_status == 3){
			$where[] = "banner_status>=0";
		}else{
			$where[] = "banner_status=".$filter_status;
		}
		$where = (count($where) ? ' WHERE '.implode(' AND ', $where) : '');
		// GET THE TOTAL NUMBER OF RECORDS
		$totalRecords = $objBanner->totalRecords($where);
		// PHAN TRANG
		$pager = new pager($limit, $totalRecords, $p);
		$offset = $pager->offset;

		$order = " ORDER BY banner_position, banner_ordering ASC, banner_id DESC";
		// LAY DANH SACH CHI TIET
		$lsBanner = $objBanner->loadListItems($where, $order, $offset, $limit);
		
		$smarty->assign('option', $option);
		$smarty->assign('lsPosition', $lsPosition);
		$smarty->assign('filter_status', $filter_status);
		$smarty->assign('filter_site_id', $filter_site_id);
		$smarty->assign('filter_groups', $filter_groups);
		$smarty->assign('filter_category', $filter_category);
		$smarty->assign('filter_static', $filter_static);
		$smarty->assign('filter_position', $filter_position);
		$smarty->assign('search', $search);
		$smarty->assign('datapage', $pager->page_link());
		$smarty->assign('p', $p);
		$smarty->assign('totalRecords', $totalRecords);
		$smarty->assign('lsBanner', $lsBanner);
		break;
}

$smarty->assign('sites', $sites);
$smarty->assign('grStatic', $grStatic);

//create toolbar buttons
if ($task == 'view' || !$task) {
	$toolbar = createToolbarAce('add', 'edit', 'publish', 'unpublish', 'remove');
} elseif ($task == 'edit' || $task == 'add') {
	$toolbar = createToolbarAce('save','cancel');
}

include "admin_footer.php";
?>