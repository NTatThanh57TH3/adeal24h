<?php
$page = "admin_custom";
$page_title = "Quản lý dữ liệu tùy chỉnh";
include "admin_header.php";
include "include/develops/class_custom.php";

$objCustom = new PGCustom();

$task = PGRequest::GetCmd('task', 'view');
if ($task == 'cancel') $task = 'view';

$objAcl = new PGAcl();
if (!$objAcl->checkPermission($page, $task)) {
	$objAcl->showErrorPage($smarty);
}

switch($task){
	case 'edit':
	case 'add':
		if ($task == 'edit') {
			$page_title = "Cập nhật tùy chỉnh";
			
			$custom_id	= PGRequest::getInt('custom_id', 0, 'GET');
			$cid = PGRequest::getVar('cid', array(), 'post', 'array');
			if (!$custom_id) {
				$custom_id = $cid[0];
			}
			$thisCustom = $objCustom->loadItem($custom_id);
			
			$smarty->assign('thisCustom', $thisCustom);
		}
		else {
			$page_title = "Thêm mới tùy chỉnh";
			$custom_id = 0;
		}
		
		
		//Load position banner
		$lsPosition = $objCustom->loadPosition();
		
		$smarty->assign('custom_id', $custom_id);
		$smarty->assign('lsPosition', $lsPosition);
		break;
		
	case 'save':
		$custom_site_id			= PGRequest::getInt('custom_site_id', 0, 'POST');
		$custom_id				= PGRequest::getInt('custom_id', 0, 'POST');
		$custom_id_value		= PGRequest::getInt('custom_id_value', 0, 'POST');
		$data_type				= PGRequest::getInt('data_type', 0, 'POST');
		$custom_title			= $database->getEscaped(PGRequest::getString('custom_title', '', 'POST'));
		$custom_set_url			= PGRequest::getString('custom_set_url', '', 'POST');
		$custom_content			= $filter->_decode(PGRequest::getVar('custom_content', '', 'post', 'string', PGREQUEST_ALLOWRAW ));
		$custom_position		= $database->getEscaped(PGRequest::getString('custom_position', '', 'POST'));
		$custom_created			= $database->getEscaped(PGRequest::getString('custom_created', ''));
		$custom_ordering		= PGRequest::GetInt('custom_ordering', 0, 'POST');
		$custom_status			= PGRequest::GetInt('custom_status', 0, 'POST');

		if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
			$custom_site_id 	= $admin->admin_site_default['site_id'];
		
		$thisCustom = $objCustom->loadItem($custom_id_value);
		if (!$objCustom->is_message){
			$input['custom_id']	 				= $custom_id_value;
			if ($custom_site_id && !$custom_id_value){
				$input['custom_site_id']		= $custom_site_id;
			}
			$input['custom_title']				= $custom_title;
			$name_alias							= convertKhongdau($custom_title);
			$input['custom_alias'] 				= generateSlug($name_alias, strlen($name_alias));
			$input['custom_set_url']			= $custom_set_url;
			$input['custom_content']			= $custom_content;
			$input['custom_position']			= $custom_position;
			$input['custom_created']			= $datetime->convertDate($custom_created, "dd/mm/yyyy");
			$input['custom_ordering']			= $custom_ordering;
			$input['custom_status'] 			= $custom_status;
			
			$message = $objCustom->save($thisCustom, $input);
		}else{
			$message = $objCustom->is_message;
		}
		PGError::set_message($message);
		cheader($uri->base().'admin_custom.php');
		break;

	case 'publish':
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if (count($cid)) {
			$message = $objCustom->published($cid, 1);
			PGError::set_message($message);
			cheader($uri->base().'admin_custom.php');
		}
		break;

	case 'unpublish':
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if (count($cid)) {
			$message = $objCustom->published($cid, 0);
			PGError::set_message($message);
			cheader($uri->base().'admin_custom.php');
		}
		break;

	case 'remove':
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if (count($cid)) {
			$message = $objCustom->remove($cid);
			PGError::set_message($message);
			cheader($uri->base().'admin_custom.php');
		}
		break;	
	
	default :
		$page_title = "Quản lý dữ liệu tùy chỉnh";
		
		$filter_site_id = PGRequest::getInt('filter_site_id', 0, 'POST');
		$filter_status 	= PGRequest::getInt('filter_status', 1, 'POST');
		$search 		= PGRequest::getString('search', '', 'POST');
		
		$p = PGRequest::getInt('p', 1, 'POST');
		$limit = PGRequest::getInt('limit', $setting['setting_list_limit'], 'POST');
		
		//CONDITION
		if ( !$filter_site_id ){
			if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
				$filter_site_id = $admin->admin_site_default['site_id'];
		}
		if ( $filter_site_id ){
			$where[] = "custom_site_id=".$filter_site_id;
		}else{
			$where[] = "custom_site_id IN (".implode(",", array_flip($sites)).")";
		}

		if ($search){
			$where[] = " custom_title LIKE'%$search%'";
		}
		if ($filter_status == 0) {			
			$where[] = " custom_status=0";
		}else if ($filter_status == 3){
			$where[] = " custom_status>=0";			
		}else{
			$where[] = " custom_status=".$filter_status;
		}
		$where = (count($where) ? ' WHERE '.implode(' AND ', $where) : '');
		$order = " ORDER BY custom_position, custom_ordering ASC, custom_id DESC";
		// GET THE TOTAL NUMBER OF RECORDS
		$totalRecords = $objCustom->totalRecords($where);
		// PHAN TRANG
		$pager = new pager($limit, $totalRecords, $p);
		$offset = $pager->offset;
		// LAY DANH SACH CHI TIET
		$lsCustom = $objCustom->loadListItems($where, $order, $offset, $limit);
		
		$smarty->assign('filter_site_id', $filter_site_id);
		$smarty->assign('filter_status', $filter_status);
		$smarty->assign('search', $search);
		$smarty->assign('datapage', $pager->page_link());
		$smarty->assign('p', $p);
		$smarty->assign('totalRecords', $totalRecords);
		$smarty->assign('lsCustom', $lsCustom);
		break;
}

$smarty->assign('sites', $sites);
//create toolbar buttons
if ($task == 'view' || !$task) {
	$toolbar = createToolbarAce('add', 'edit', 'publish', 'unpublish', 'remove');
} elseif ($task == 'edit' || $task == 'add') {
	$toolbar = createToolbarAce('save','cancel');
}

include "admin_footer.php";
?>