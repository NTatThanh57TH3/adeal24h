<?php
$page = "admin_manager_menu";
include "admin_header.php";
include "include/develops/class_menu.php";

$task = PGRequest::GetCmd('task', 'view');
if ($task == 'cancel') $task = 'view';

$objMenu = new PGMenu();
$lsMenuType = $objMenu->setMenuType();

$objAcl = new PGAcl();
if (!$objAcl->checkPermission($page, $task)) {
	$objAcl->showErrorPage($smarty);
}

switch($task){
	case 'edit':
	case 'add':
	case 'showTypeMenu':
		if ($task == 'edit') $page_title = "Cập nhật menu";
		else $page_title = "Thêm mới menu";
		
		$menu_id	= PGRequest::getInt('menu_id', 0, 'GET');
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if ( !$menu_id ) {
			$menu_id = $cid[0];
		}

		if ( $menu_id ){
			$thisMenu = $objMenu->load($menu_id);
		}
		
		$where[] = "status=1";
		if ( $task == 'edit' ){
			$where[] = "menutype=".$thisMenu->menutype;
		}
		if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] ){
			$where[] = "menu_site_id=".$admin->admin_site_default['site_id'];
		}
		$where = (count($where) ? ' WHERE '.implode(' AND ', $where) : '');
		$order = " ORDER BY ordering ASC, menu_id DESC";
		// LẤY TẤT CẢ DANH SÁCH
		$items 	= $objMenu->loadListItems($where, $order);
		
		$option = $objMenu->getOptionItems($items, $parentid=0,$thisMenu->parent_id, $insert_text="--");
		
//		if ($task == 'edit'){
//			$smarty->assign('list_option', $list_option);
//		}
		if ($task == 'showTypeMenu'){
			exit();
		}

		if ( isset($admin->admin_site_default) && $admin->admin_site_default['site_access'] ){
			$access_admin = explode("|", $admin->admin_site_default['site_access']);
			if ( in_array(SITE_PRODUCT, $access_admin) ){
				$_p_query = "SELECT product_id, product_name FROM ".TBL_PRODUCT." WHERE product_status=1 AND product_site_id = ".$admin->admin_site_default['site_id']." ORDER BY product_name";
				$_p_results = $database->db_query($_p_query);
				while ( $_prow = $database->db_fetch_assoc($_p_results) ){
					$_p_list[] = $_prow;
				}
				if ( isset($_p_list) && $_p_list ){
					$smarty->assign('_p_list', $_p_list);
				}
			}

			if ($menu_id) {
				$aryProudctId = $database->getCol($database->db_query("SELECT product_id FROM ".TBL_MENU_PRODUCT." WHERE site_id = ".$admin->admin_site_default['site_id']." AND menu_id=".$menu_id));
				$smarty->assign('aryProudctId', $aryProudctId);
			}
		}

		// Check exist module in project
		$path = DIR_ROOT .'/include/develops/services';
		$dir = new DirectoryIterator($path);
		$counter = 0;
		foreach ($dir as $fileinfo) {
			if ($fileinfo->isDir() && !$fileinfo->isDot()) {
				if ( $list_modules[$fileinfo->getFilename()] ){
					$list_modules[$fileinfo->getFilename()]['exist'] = true;
				}
				$counter++;
			}
		}
		//print_r($list_modules); die;

		$smarty->assign('list_modules', $list_modules);
		$smarty->assign('site_id', $site_id);
		$smarty->assign('menu_id', $menu_id);
		$smarty->assign('thisMenu', $thisMenu);
		$smarty->assign('option', $option);
		break;
		
	case 'save':
	case 'save2add':
		$menu_id			= PGRequest::getInt('menu_id', 0, 'POST');
		$menu_site_id		= PGRequest::getInt('menu_site_id', 0, 'POST');
		$menu_id_value		= PGRequest::getInt('menu_id_value', 0, 'POST');
		$menutype			= PGRequest::getInt('menutype', 0, 'POST');
		$name				= $database->getEscaped(PGRequest::getString('name', '', 'POST'));
		$alias				= $database->getEscaped(PGRequest::getString('alias', '', 'POST'));
		$class				= $database->getEscaped(PGRequest::getString('class', '', 'POST'));
		$link				= $database->getEscaped(PGRequest::getString('link', '', 'POST'));
		$status				= PGRequest::GetInt('status', 0, 'POST');
		$ordering			= PGRequest::GetInt('ordering', 0, 'POST');
		$show_web			= PGRequest::GetInt('show_web', 0, 'POST');
		$show_app			= PGRequest::GetInt('show_app', 0, 'POST');
		$parent_id			= PGRequest::GetInt('parent_id', 0, 'POST');
		$choose_type		= PGRequest::GetCmd('choose_type', '');
		$link_value			= PGRequest::GetInt('link_value', 0, 'POST');
		$set_url			= PGRequest::GetInt('seturl', 0, 'POST');
		$get_url			= $database->getEscaped(PGRequest::getString('geturl', '', 'POST'));
		$description		= $database->getEscaped(PGRequest::getString('description', '', 'POST'));
		$changeimage		= PGRequest::getInt('changeimage', 0, 'POST');

		if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
			$menu_site_id	= $admin->admin_site_default['site_id'];
		
		$aryParams = $objMenu->urlMenu($choose_type, $link_value);

		$thisMenu = $objMenu->load($menu_id_value);
		if (!$objMenu->is_message){
            $objMenu->link_rewrite_compact = "";
			$objMenu->menutype 		= $menutype;
			$objMenu->name			= $name;
			
			if ($menu_site_id && !$menu_id_value){
				$objMenu->menu_site_id	= (($menu_site_id <> 55555) ? $menu_site_id : 0);
			}
			if ($alias != ""){
				$objMenu->alias 	= $alias;
			}else{
				$name_alias			= convertKhongdau($name);
				$name_alias			= generateSlug($name_alias, strlen($name_alias));
				$objMenu->alias 	= $name_alias;
			}
			
			$objMenu->class			= $class;
			if ( $set_url && strlen($get_url) ){
				$objMenu->seturl 		= $set_url;
				$objMenu->link 			= $get_url;
				$objMenu->link_rewrite	= $get_url;
			}else{
				$objMenu->link 			= $aryParams["url"];
				$objMenu->link_rewrite	= $aryParams["seo"];
				if ( isset($aryParams["seo_compact"]) && $aryParams["seo_compact"] ){
                    $objMenu->link_rewrite_compact	= $aryParams["seo_compact"];
                }
			}
			$objMenu->type 			= $choose_type;
			$objMenu->link_value	= $link_value;

			$objMenu->status		= $status;
			$objMenu->ordering		= $ordering;
			$objMenu->show_web		= $show_web;
			$objMenu->show_app		= $show_app;
			$objMenu->parent_id		= $parent_id;
			$objMenu->description	= $description;
			if ($changeimage == 1){
				if ($menu_id_value){
					if ($thisMenu->url_image != "") removeImage($thisMenu->image, str_replace('admin_manager_', '', $page.'s'));
					if ($thisMenu->url_image_small_v1 != "") removeImage($thisMenu->image_small_v1, str_replace('admin_manager_', '', $page.'s'));
					if ($thisMenu->url_image_small_v2 != "") removeImage($thisMenu->image_small_v2, str_replace('admin_manager_', '', $page.'s'));
					if ($thisMenu->url_image_small_v3 != "") removeImage($thisMenu->image_small_v3, str_replace('admin_manager_', '', $page.'s'));
				}
				if ( isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] ){
					$objMenu->image				= uploadImage($_FILES["image"]["name"], $_FILES["image"]["tmp_name"], str_replace('admin_manager_', '', $page.'s'), $objMenu->alias, null);
					$objMenu->link_image		= $database->getEscaped(PGRequest::getString('link_image', '', 'POST'));
				}
				if ( isset($_FILES["image_small_v1"]["name"]) && $_FILES["image_small_v1"]["name"] ){
					$objMenu->image_small_v1		= uploadImage($_FILES["image_small_v1"]["name"], $_FILES["image_small_v1"]["tmp_name"], str_replace('admin_manager_', '', $page.'s'), $objMenu->alias . '-small-v1', null);
					$objMenu->link_image_small_v1 	= $database->getEscaped(PGRequest::getString('link_image_small_v1', '', 'POST'));
				}
				if ( isset($_FILES["image_small_v2"]["name"]) && $_FILES["image_small_v2"]["name"] ){
					$objMenu->image_small_v2		= uploadImage($_FILES["image_small_v2"]["name"], $_FILES["image_small_v2"]["tmp_name"], str_replace('admin_manager_', '', $page.'s'), $objMenu->alias . '-small-v2', null);
					$objMenu->link_image_small_v2 	= $database->getEscaped(PGRequest::getString('link_image_small_v2', '', 'POST'));
				}
				if ( isset($_FILES["image_small_v3"]["name"]) && $_FILES["image_small_v3"]["name"] ){
					$objMenu->image_small_v3		= uploadImage($_FILES["image_small_v3"]["name"], $_FILES["image_small_v3"]["tmp_name"], str_replace('admin_manager_', '', $page.'s'), $objMenu->alias . '-small-v3', null);
					$objMenu->link_image_small_v3 	= $database->getEscaped(PGRequest::getString('link_image_small_v3', '', 'POST'));
				}
			}
			$message = $objMenu->save($thisMenu);
			
			$db_insert_id = 0;
			if ( !$menu_id_value )
				$db_insert_id = $database->db_insert_id();

			$idSet = $menu_id_value ? $menu_id_value : $db_insert_id;
			
			// Attack product_id
			$cbo_product = PGRequest::getVar('cbo_product', '', 'POST');
			if ( isset($cbo_product) && is_array($cbo_product) && count($cbo_product) && !empty($cbo_product) ){
				if ( $menu_id_value ){
					$database->db_query("DELETE FROM ".TBL_MENU_PRODUCT." WHERE menu_id='{$menu_id_value}' AND site_id='{$admin->admin_site_default['site_id']}'");
				}
				foreach ($cbo_product as $key=>$productId) {
					$aryValue[] = "('{$idSet}', '{$admin->admin_site_default['site_id']}', '{$productId}')";
				}
				if ( is_array($aryValue) && count($aryValue) && !empty($aryValue) ){
					$result = $database->db_query("INSERT INTO ".TBL_MENU_PRODUCT." (menu_id, site_id, product_id) VALUES " . join(",", $aryValue));
				}
			}
		}else{
			$message = $objMenu->is_message;
		}
		PGError::set_message($message);
		if ($task == 'save'){
			/* Redirect to page list */
			cheader($uri->base().'admin_manager_menu.php' . ( (($menu_site_id > 0) && ($menu_site_id <> 55555)) ? '?filter_site_id='.$menu_site_id : '?filter_site_id=55555'));
		}else{
			cheader($uri->base().'admin_manager_menu.php?task=add' . ( (($menu_site_id > 0) && ($menu_site_id <> 55555)) ? '&filter_site_id='.$menu_site_id : '&filter_site_id=55555'));
		}
		break;

	case 'publish':
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		$message = $objMenu->published($cid, 1);
		PGError::set_message($message);
		cheader($uri->base().'admin_manager_menu.php');
		break;

	case 'unpublish':
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		$message = $objMenu->published($cid, 0);
		PGError::set_message($message);
		cheader($uri->base().'admin_manager_menu.php');
		break;

	case 'remove':
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		$message = $objMenu->remove($cid);
		PGError::set_message($message);
		cheader($uri->base().'admin_manager_menu.php');
		break;
		
	default :
		$page_title = "Quản lý menu";
		
		$filter_site_id = PGRequest::getInt('filter_site_id', 0, 'REQUEST');
		$filter_menutype = PGRequest::getInt('filter_menutype', 0, '');
		$filter_status = PGRequest::getInt('filter_status', 1, 'POST');
		$search = strtolower( PGRequest::getVar('search', '', 'POST') );
		
		$p = PGRequest::getInt('p', 1, 'POST');
		$limit = PGRequest::getInt('limit', $setting['setting_list_limit'], 'POST');
		
		//LẤY DANH SÁCH KIỂU MENU
		$lsMenuType = $objMenu->setMenuType();
		
		//CONDITION
		if ( $filter_site_id == '55555' || $filter_site_id == 55555 ){
			$filter_site_id = 0;
		}
		if ( !$filter_site_id ){
			if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
				$filter_site_id = $admin->admin_site_default['site_id'];
		}
		if ( $filter_site_id ){
			$where[] = "menu_site_id=".$filter_site_id;
		}else{
			$where[] = "menu_site_id IN (".implode(",", array_flip($sites)).")";
		}

		if ($search){
			$where[] = "name LIKE'%$search%'";
		}
		if ($filter_menutype > 0){
			$where[] = "menutype=".$filter_menutype;
		}
		if ($filter_status == 0) {			
			$where[] = "status=0";
		}else if ($filter_status == 3){
			$where[] = "status>=0";			
		}else{
			$where[] = " status=".$filter_status;
		}
		$where = (count($where) ? ' WHERE '.implode(' AND ', $where) : '');
		$order = " ORDER BY menutype, ordering ASC, menu_id DESC";
		
		// GET THE TOTAL NUMBER OF RECORDS
		$query = "SELECT COUNT(*) AS total FROM ".TBL_MENU.$where;
		$results = $database->db_fetch_assoc($database->db_query($query));
		// PHAN TRANG
		$pager = new pager($limit, $results['total'], $p);
		$offset = $pager->offset;
		
		// LẤY TẤT CẢ DANH SÁCH
		$items 	= $objMenu->loadListItems($where, $order);
		
		// LAY DANH SACH CHI TIET
		$list_menu = $objMenu->getListItems($items, 0, $text = "", $offset, $limit);
		
		// LIST ALL ITEMS
		$listItems = $objMenu->getOptionItems($items, 0);
		
		$smarty->assign('filter_site_id', $filter_site_id);
		$smarty->assign('filter_menutype', $filter_menutype);
		$smarty->assign('filter_status', $filter_status);
		$smarty->assign('search', $search);
		$smarty->assign('datapage', $pager->page_link());
		$smarty->assign('p', $p);
		$smarty->assign('list_menu', $list_menu);
		$smarty->assign('listItems', $listItems);
		break;
}

$smarty->assign('sites', $sites);
$smarty->assign('lsMenuType', $lsMenuType);

//create toolbar buttons
if ($task == 'view' || !$task) {
	$toolbar = createToolbarAce('add', 'edit', 'publish', 'unpublish', 'remove');
} elseif ($task == 'edit' || $task == 'add') {
	$toolbar = createToolbarAce('save', 'save2add', 'cancel');
}

include "admin_footer.php";
?>