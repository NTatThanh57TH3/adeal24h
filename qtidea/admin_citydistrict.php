<?php
$page = "admin_citydistrict";
include "admin_header.php";
require_once "include/globals/class_city_district.php";

$objCityDistrict = new PGCityDistrict();

$task = PGRequest::GetCmd('task', 'view');
if ($task == 'cancel') $task = 'view';

$objAcl = new PGAcl();
if (!$objAcl->checkPermission($page, $task)) {
	$objAcl->showErrorPage($smarty);
}

$action = PGRequest::getCmd('action', 'city');
if ( $action == 'country' ) {
	$table_name = TBL_COUNTRY;
	$text_title = 'Quốc Gia';
}else if ( $action == 'area' ){
	$table_name = TBL_VUNG_MIEN;
	$text_title = 'Vùng/Miền';
}else if ( $action == 'city' ){
	$table_name = TBL_TINH_THANH_PHO;
	$text_title = 'Tỉnh/Thành Phố';
}else if ( $action == 'district' ){
	$table_name = TBL_QUAN_HUYEN;
	$text_title = 'Quận/Huyện';
}else if ( $action == 'province' ){
	$table_name = TBL_XA_PHUONG;
	$text_title = 'Xã/Phường';
}

// LẤY DANH SACH QUỐC GIA
$lsCountry = $objCityDistrict->getListCountry();

switch($task){
	case 'edit':
	case 'add':
		if ($task == 'edit') $page_title = "Cập nhật " . $text_title;
		else $page_title = "Thêm mới " . $text_title;
		
		$id					= PGRequest::GetInt('id', 0, 'GET');
		$thisItem 			= $objCityDistrict->load($table_name, $id);

		if ( $action == 'district' || $action == 'province' ) {
			// LẤY DANH SÁCH THÀNH PHỐ/TỈNH
			$lsCity = $objCityDistrict->getListCity();
			$smarty->assign('lsCity', $lsCity);
		}
		if ( $action == 'province' ) {
			// LẤY DANH SÁCH THÀNH PHỐ/TỈNH
			$lsDistrict = $objCityDistrict->getListDistrict();
			$smarty->assign('lsDistrict', $lsDistrict);
		}

		$smarty->assign('text_title', $text_title);
		$smarty->assign('id', $id);
		$smarty->assign('thisItem', $thisItem);
		break;
		
	case 'save':
		if ( !$admin->admin_super ){
			$error = 'Bạn không đủ thẩm quyền để thay đổi nội dung này. Nội dung này chỉ có Super Admin mới có thẩm quyền thay đổi';
			PGError::set_error($error);
			cheader($uri->base().'admin_citydistrict.php');
		}
		$id						= PGRequest::GetInt('id', 0, 'POST');
		$thisCityDistrict = $objCityDistrict->load($table_name, $id);

		if ( $action == 'area' ) {
			$input['ma_quoc_gia'] = $database->getEscaped(PGRequest::getString('country_code', '', 'POST'));
			$input['ma_vung'] 	= $database->getEscaped(PGRequest::getString('ma_vung', '', 'POST'));
			$input['ten_vung'] 	= $database->getEscaped(PGRequest::getString('ten_vung', '', 'POST'));
		}else if ( $action == 'city' ){
			$input['country_code'] = $database->getEscaped(PGRequest::getString('country_code', '', 'POST'));
			$input['ma_tinh'] 	= $database->getEscaped(PGRequest::getString('ma_tinh', '', 'POST'));
			if ( !$input['ma_tinh'] ){
				$input['ma_tinh'] = generate_code(array('name' => TBL_TINH_THANH_PHO, 'ma_tinh'), false, true);
			}
			$input['ma_tinh'] = intval($input['ma_tinh']);
			$input['ten_tinh'] 	= $database->getEscaped(PGRequest::getString('ten_tinh', '', 'POST'));
		}else if ( $action == 'district' ){
			$input['ma_tinh'] 	= $database->getEscaped(PGRequest::getString('ma_tinh', '', 'POST'));
			$input['ma_huyen'] 	= $database->getEscaped(PGRequest::getString('ma_huyen', '', 'POST'));
			if ( !$input['ma_huyen'] ){
				$input['ma_huyen'] = generate_code(array('name' => TBL_QUAN_HUYEN, 'ma_huyen'), false, true);
			}
			$input['ma_tinh'] = intval($input['ma_tinh']);
			$input['ma_huyen'] = intval($input['ma_huyen']);
			$input['ten_huyen']	= $database->getEscaped(PGRequest::getString('ten_huyen', '', 'POST'));
		}else if ( $action == 'province' ){
			$input['ma_huyen'] 	= $database->getEscaped(PGRequest::getString('ma_huyen', '', 'POST'));
			$input['ma_xa'] 	= $database->getEscaped(PGRequest::getString('ma_xa', '', 'POST'));
			if ( !$input['ma_xa'] ){
				$input['ma_xa'] = generate_code(array('name' => TBL_XA_PHUONG, 'ma_xa'), false, true);
			}
			$input['ma_huyen'] = intval($input['ma_huyen']);
			$input['ma_xa'] = intval($input['ma_xa']);
			$input['ten_xa']	= $database->getEscaped(PGRequest::getString('ten_xa', '', 'POST'));
		}

		$dataReturn = $objCityDistrict->save($table_name, $thisCityDistrict, $input);

		$message = $dataReturn->message;
		if ( $dataReturn['isOk'] ){
			PGError::set_message($message);
		}else{
			PGError::set_error($message);
		}
		cheader($uri->base().'admin_citydistrict.php?filter_country='.$country_code);
		break;

	default :
		$page_title = "Quản lý tỉnh/thành phố - Quận/huyện";
		
		$search 			= $database->getEscaped(PGRequest::getString('search', '', 'POST'));
		$filter_country		= $database->getEscaped(PGRequest::getString('filter_country', '', 'POST'));
		
		$p = PGRequest::getInt('p', 1, 'POST');
		$limit = PGRequest::getInt('limit', $setting['setting_list_limit'], 'POST');

		if ( $action == 'district' || $action == 'province' ) {
			$filter_city		= $database->getEscaped(PGRequest::getString('filter_city', '', 'POST'));
			if ( $filter_city && $action == 'district' ){
				$where[] = "ma_tinh='{$filter_city}'";
			}
			$smarty->assign('filter_city', $filter_city);

			// LẤY DANH SÁCH THÀNH PHỐ/TỈNH
			$lsCity = $objCityDistrict->getListCity();
			$smarty->assign('lsCity', $lsCity);
		}
		if ( $action == 'province' ) {
			$filter_district	= $database->getEscaped(PGRequest::getString('filter_district', '', 'POST'));
			if ( $filter_district ){
				$where[] = "ma_huyen='{$filter_district}'";
			}
			$smarty->assign('filter_district', $filter_district);

			// LẤY DANH SÁCH THÀNH PHỐ/TỈNH
			$lsDistrict = $objCityDistrict->getListDistrict();
			$smarty->assign('lsDistrict', $lsDistrict);
		}
		
		//CONDITION
		if ( $action == 'area' ) {
			if ($search){
				$where[] = "(ma_vung LIKE'%$search%' OR ten_vung LIKE'%$search%')";
			}
			if ($filter_country) {
				$where[] = "ma_quoc_gia='{$filter_country}'";
			}
		}else if ( $action == 'city' ){
			if ($search){
				$where[] = "(ma_tinh LIKE'%$search%' OR ten_tinh LIKE'%$search%')";
			}
			if ($filter_country) {
				$where[] = "country_code='{$filter_country}'";
			}
		}else if ( $action == 'country' ){
			if ($search){
				$where[] = "(country_code LIKE'%$search%' OR country_name LIKE'%$search%')";
			}
		}else if ( $action == 'district' ){
			if ($search){
				$where[] = "(ma_huyen LIKE'%$search%' OR ten_huyen LIKE'%$search%')";
			}
			if ($filter_country) {
				$where[] = "country_code='{$filter_country}'";
			}
		}else if ( $action == 'province' ){
			if ($search){
				$where[] = "(ma_xa LIKE'%$search%' OR ten_xa LIKE'%$search%')";
			}
			if ($filter_country) {
				$where[] = "country_code='{$filter_country}'";
			}
		}
		$where = (count($where) ? ' WHERE '.implode(' AND ', $where) : '');

		// GET THE TOTAL NUMBER OF RECORDS
		$query = "SELECT COUNT(*) AS total FROM ".$table_name.$where;
		$results = $database->db_fetch_assoc($database->db_query($query));
		$total_record = $results['total'];
		// PHAN TRANG
		$pager = new pager($limit, $total_record, $p);
		$offset = $pager->offset;
		// LAY DANH SACH CHI TIET
		$list_datas = $objCityDistrict->loadList($table_name, $where, $offset, $limit);
		
		$smarty->assign('filter_country', $filter_country);
		$smarty->assign('search', $search);
		$smarty->assign('datapage', $pager->page_link());
		$smarty->assign('p', $p);
		$smarty->assign('total_record', $total_record);
		$smarty->assign('list_datas', $list_datas);
		$smarty->assign('error', $error);
		break;
}
$smarty->assign('action', $action);
$smarty->assign('lsCountry', $lsCountry);

//create toolbar buttons
if ( $action != 'country' && $admin->admin_super ) {
	if ($task == 'view' || !$task) {
		$toolbar = createToolbarAce('add', 'edit');
	} elseif ($task == 'edit' || $task == 'add') {
		$toolbar = createToolbarAce('save', 'cancel');
	}
}
include "admin_footer.php";
?>