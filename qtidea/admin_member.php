<?php
/**
 * Logic xu ly cua module user
 */
$page = "admin_member";
include "admin_header.php";

$task = PGRequest::getCmd('task', 'view');
if ($task=='cancel') $task='view';

$objAcl = new PGAcl();
if (!$objAcl->checkPermission($page, $task)) {
  $objAcl->showErrorPage($smarty);
}

$adminGroup = $admin->admin_info["admin_group"];

switch ($task) {
  case "view":
  case "export":
    $page_title = "Quản lý thành viên";
    $filter_usertype = PGRequest::getInt('filter_usertype', 0, 'POST');
    $filter_statusemail = PGRequest::getInt('filter_statusemail', -1, 'POST');
    $filter_statusmobile = PGRequest::getInt('filter_statusmobile', -1, 'POST');
    $filter_status = PGRequest::getInt('filter_status', -1, 'POST');
    $search  = PGRequest::getFilter('membersearch', 'search', '');
    
    $p = PGRequest::getInt('p', 1, 'POST');
    $limit = PGRequest::getInt('limit', $setting['setting_list_limit'], 'POST');
    
    $adminId = $admin->admin_info['admin_id'];
    
    //CHON TAT CA USER TRANG THAI KICH HOAT
    $where[] = " user_code !=''";

    if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
        $where[] = "user_site_id=".$admin->admin_site_default['site_id'];

    if ($filter_status != -1) {      
      	$where[] = " user_enabled=".$filter_status;
    }
    if ($filter_statusemail != -1) {      
      	$where[] = " user_verified=".$filter_statusemail;
    }
    if ($filter_statusmobile != -1) {      
      	$where[] = " user_verified_mobile=".$filter_statusmobile;
    }
    if ($filter_usertype) {      
      	$where[] = " user_type=".($filter_usertype);
    }
    if ($search) {
      	$strSearch = $database->getEscaped($search);
      	$where[] = "(user_code LIKE'%".$strSearch."%' OR user_email LIKE '%".$strSearch."%' OR user_fullname LIKE '%".$strSearch."%' OR user_mobile LIKE '%".$strSearch."%')";
    }

    // BUILD THE WHERE CLAUSE OF THE CONTENT RECORD QUERY
    $where = (count($where) ? ' WHERE '.implode(' AND ', $where) : '');
    
    // GET THE TOTAL NUMBER OF RECORDS
    $query = "SELECT COUNT(*) AS total FROM ".TBL_USER." $where";

    $results = $database->db_fetch_assoc($database->db_query($query));
    $totalRecords = $results['total'];
    
    // PHAN TRANG
    $pager = new pager($limit, $results['total'], $p);
    $offset = $pager->offset;
    
    // ORDER
    $order = "ORDER BY user_id DESC";
    
    // LAY DANH SACH CHI TIET
    $query = "SELECT * FROM ".TBL_USER." $where $order LIMIT $offset, $limit";
    $results = $database->db_query($query);
    
    $district = getDistrict(false, false, true); // group ma_huyen
    $city = getCity(false, true); // group ma_tinh

    $typeUser = PGSettings::getTypeUser();
    while ($row = $database->db_fetch_assoc($results)){
      $row['user_district'] = $district[$row['user_district']]['ten_huyen'];
      $row['user_city']  = $city[$row['user_city']]['ten_tinh'];
      $row['user_type']  = $typeUser[$row['user_type']];
      $row['user_lastlogindate'] = $datetime->timestampToDateTime($row['user_lastlogindate']);
      $users[] = $row;
    }
    
	//Export Excel
	if ($task == "export") {
		require_once "../include/excel/Classes/PHPExcel/IOFactory.php";
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        $objPHPExcel = $objReader->load("../include/excel/templates/emails.xls");
        
        if ($totalRecords > 15000) {
        	cheader($uri->base().$page.".php");
        }

        $baseRow = 6;
        foreach($users as $r => $dataRow) {
			$row = $baseRow + $r;
            $objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $r+1);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dataRow['user_fullname']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dataRow['user_email']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $dataRow['user_mobile']);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $dataRow['user_address'] . ', ' . $dataRow['user_district'] . ', ' . $dataRow['user_city']);
		}
        $objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);

        $fileName = "thong_tin_khach_hang_".time().".xls";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $fileName);
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
	}

    if (isset($users)) $smarty->assign('member', $users);
    $smarty->assign('typeUser', $typeUser);
    $smarty->assign('type_user', $filter_usertype);
    $smarty->assign('filter_status', $filter_status);
    $smarty->assign('filter_statusmobile', $filter_statusmobile);
    $smarty->assign('filter_statusemail', $filter_statusemail);
    $smarty->assign('search', $search);
    $smarty->assign('totalRecords', $totalRecords);
    $smarty->assign('datapage', $pager->page_link());
    $smarty->assign('p', $p);
    break;

  case "detail":
    $page_title = "Chi tiết - Lịch sử mua hàng của thành viên";
    $user_id	= PGRequest::GetInt('id', 0, 'GET');
    
    include "core/orders/class_order.php";
	$objOrder = new PGOrder();

    PGTheme::add_css('../templates/admin/css/printer.css');
    
    $query = 'SELECT u.user_id, u.user_code, u.user_email, u.user_mobile, u.user_fullname, u.user_address, u.user_district, u.user_city'
    		. ', o.order_id, o.order_code, o.order_total_amount, o.order_add_discount, o.order_add_discount_value, o.order_total_amount_discount'
    		. ', o.order_description, o.order_payment_method, o.order_payment_properties, o.order_cost_ship, o.order_status, o.order_created'
    		. ' FROM '.TBL_USER.' u'
    		. ' LEFT JOIN '.TBL_ORDER.' o ON u.user_id = o.order_user_id'
    		. ' WHERE u.user_id = '.$user_id
    		;
    $results = $database->db_query($query);
    $aryOrderId = array();
    $userInfo = array();
    while ( $row = $database->db_fetch_assoc($results) ){
    	if ( !in_array($row['order_id'], $aryOrderId) ){
    		array_push($aryOrderId, $row['order_id']);
    	}
    	$userInfo['user_code'] = $row['user_code'];
    	$userInfo['user_email'] = $row['user_email'];
    	$userInfo['user_mobile'] = $row['user_mobile'];
    	$userInfo['user_fullname'] = $row['user_fullname'];
    	$userInfo['user_address'] = $row['user_address'];
    	$userInfo['user_district'] = getDistrict(null, $row['user_district']);
    	$userInfo['district'] = array_values($userInfo['user_district']);
    	$userInfo['district'] = $userInfo['district'][0];
    	$userInfo['user_city'] = getCity(null, $row['user_city']);
    	$userInfo['city'] = array_values($userInfo['user_city']);
    	$userInfo['city'] = $userInfo['city'][0];
    	
    	$row['payment_method'] = $objOrder->get_payment_method($row['order_payment_method']);
		$row['payment_properties'] = $objOrder->get_payment_properies($row['order_payment_properties']);
		$row['status'] = $objOrder->get_status_orders($row['order_status']);
		$row['status_show'] = $objOrder->get_status_show($row['order_status']);
    	$items[$row['order_id']] = $row;
    }
    
    // Get info orders
    if ( count($aryOrderId) ){
	    $query = 'SELECT op.order_id, op.price, op.number, op.totals'
	    		. ', p.product_code, p.product_name'
	    		. ' FROM '.TBL_ORDER_PRODUCT.' op'
	    		. ' LEFT JOIN '.TBL_PRODUCT.' p ON op.product_id = p.product_id'
	    		. ' WHERE op.order_id IN('.implode(",", $aryOrderId).')'
	    		;
	    $results = $database->db_query($query);
	    while ( $row = $database->db_fetch_assoc($results) ){
	    	$items[$row['order_id']]['order_info'][] = $row;
	    }
	    $items = array_values($items);
	    $smarty->assign('list', $items);
	    $smarty->assign('userInfo', $userInfo);
    }
  break;
  
  case "add":
    $page_title = "Thêm mới thành viên";
    
    $userId = PGRequest::getInt('id', 0);
    
    $typeUser = PGSettings::getTypeUser();
    
    $ajax = PGRequest::getInt('ajax', 0);
    if ($ajax) {
        $aryInput['user_email'] = PGRequest::getVar('user_email', '', 'POST');
        $aryInput['user_fullname'] = PGRequest::getVar('user_fullname', '', 'POST');
        $aryInput['user_mobile'] = PGRequest::getVar('user_mobile', '', 'POST');
        $aryInput['user_address'] = PGRequest::getVar('user_address', '', 'POST');
        $aryInput['user_district'] = PGRequest::getInt('user_district', 0, 'POST');
        $aryInput['user_city'] = PGRequest::getInt('user_city', 0, 'POST');
        $aryInput['user_verified'] = PGRequest::getInt('user_verified', 0, 'POST');
        $aryInput['user_verified_mobile'] = PGRequest::getInt('user_verified_mobile', 0, 'POST');
        $aryInput['user_special'] = PGRequest::getInt('user_special', 0, 'POST');
        $aryInput['user_enabled'] = PGRequest::getInt('user_enabled', 0, 'POST');
        $aryInput['user_type'] = PGRequest::getInt('user_type', 0, 'POST');
        $aryInput['user_group'] = PGRequest::getInt('user_group', 1, 'POST');
        $aryInput['user_signupdate'] = ($aryInput['user_lastlogindate'] = ($aryInput['user_lastactive'] = time()));
        $aryInput['user_ip_signup'] = ($aryInput['user_ip_lastactive'] = $_SERVER['REMOTE_ADDR']);

        $aryInput['user_username'] = PGRequest::getVar('user_username', '', 'POST');
        $aryInput['user_password'] = PGRequest::getVar('user_password', '', 'POST');

        $aryInput['user_twitter'] = PGRequest::getVar('user_twitter', '', 'POST');
        $aryInput['user_facebook'] = PGRequest::getVar('user_facebook', '', 'POST');
        $aryInput['user_pinterest'] = PGRequest::getVar('user_pinterest', '', 'POST');
        $aryInput['user_instagram'] = PGRequest::getVar('user_instagram', '', 'POST');
        $aryInput['user_google_plus'] = PGRequest::getVar('user_google_plus', '', 'POST');

        if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
            $aryInput['user_site_id'] = $admin->admin_site_default['site_id'];
        
        $aryOutput = array();
        $aryOutput['intOK'] = 1;

        include "../include/users/class_user.php";
        $new_user = new PGUser();

        switch ($aryInput['user_type']) {
            case 1:
                //THUC HIEN CHECK THONG TIN INPUT
                check_member_input($aryInput, $aryError);

                if (!$aryError) {
                    $signup_password = ($setting['setting_signup_randpass']) ? randomcode(10) : $aryInput['user_password'];
                    $aryInput['user_password'] = $new_user->user_password_crypt($signup_password);
                    $aryInput['user_code'] = $new_user->user_salt;

                    if (!$uid = $database->insert(TBL_USER, $aryInput)) {
                        $aryOutput['strError'] = "Lỗi hệ thống";
                        $aryOutput['intOK'] = 0;
                    }else{
                        $aryOutput['uID'] = $uid;
                    }
                } else {
                    $aryOutput['strError'] = (is_array($aryError))?join("<br>", $aryError):"";
                    $aryOutput['intOK'] = 0;
                }
                break;
        }

        echo json_encode($aryOutput);
        exit();
    }else{
        if( isset($_FILES['image']) && count($_FILES['image']['error']) == 1 && $_FILES['image']['error'][0] > 0){
            //file not selected
        } else if(isset($_FILES['image'])){ //this is just to check if isset($_FILE). Not required.
            //file selected
            $uID = PGRequest::GetInt('uID', 0, 'POST');
            $user_username = PGRequest::getVar('user_username', '', 'POST');

            $inputUpdateAvatar = array();
            $inputUpdateAvatar['user_avatar'] = uploadImage($_FILES["image"]["name"], $_FILES["image"]["tmp_name"], str_replace('admin_', '', $page.'s'), 'avatar-'.$user_username);
            $database->update(TBL_USER, $inputUpdateAvatar, "user_id={$uID}");
            cheader($uri->base().'admin_member.php');
        }
    }

    $district = getDistrict();
    $city = getCity();
    $smarty->assign('city', $city);
    $smarty->assign('json_district', json_encode($district));
    $smarty->assign('userId', $userId);
    $smarty->assign('typeUser', $typeUser);
    
    break;
    
  case "edit":
    $page_title = "Sửa thông tin thành viên";
    
    //ARRAY GROUP USERS
    
    $userId = PGRequest::getInt('id', 0);
    $cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
    if ( !$userId ){
        $userId = $cid[0];
    }
    $ajax = PGRequest::getInt('ajax', 0);
    
    $typeUser = PGSettings::getTypeUser();

    $query = "SELECT * FROM ".TBL_USER." WHERE user_id={$userId} LIMIT 1";
    
    $aryUser = $database->getRow($database->db_query($query));
    if (!$aryUser) cheader($uri->base().'admin_member.php');
    $aryUser['avatar'] = showImageSubject($aryUser['user_avatar'], "members", $image_params = "banner");
    
    $aryUser['user_signupdate'] = $datetime->timestampToDateTime($aryUser['user_signupdate']);
    $aryUser['user_lastlogindate'] = $datetime->timestampToDateTime($aryUser['user_lastlogindate']);
    
    if ($ajax) {
    	$aryInput['user_id'] = $userId;
      	$aryInput['user_email'] = PGRequest::getVar('user_email', '', 'POST');
      	$aryInput['user_fullname'] = PGRequest::getVar('user_fullname', '', 'POST');
      	$aryInput['user_mobile'] = PGRequest::getVar('user_mobile', '', 'POST');
      	$aryInput['user_address'] = PGRequest::getVar('user_address', '', 'POST');
      	$aryInput['user_district'] = PGRequest::getInt('user_district', 0, 'POST');
      	$aryInput['user_city'] = PGRequest::getInt('user_city', 0, 'POST');
      	$aryInput['user_verified'] = PGRequest::getInt('user_verified', 0, 'POST');
      	$aryInput['user_verified_mobile'] = PGRequest::getInt('user_verified_mobile', 0, 'POST');
        $aryInput['user_special'] = PGRequest::getInt('user_special', 0, 'POST');
      	$aryInput['user_enabled'] = PGRequest::getInt('user_enabled', 0, 'POST');
      	$aryInput['user_type'] = PGRequest::getInt('user_type', 0, 'POST');

        $aryInput['user_username'] = PGRequest::getVar('user_username', '', 'POST');
        $aryInput['user_password'] = PGRequest::getVar('user_password', '', 'POST');

        $aryInput['user_twitter'] = PGRequest::getVar('user_twitter', '', 'POST');
        $aryInput['user_facebook'] = PGRequest::getVar('user_facebook', '', 'POST');
        $aryInput['user_pinterest'] = PGRequest::getVar('user_pinterest', '', 'POST');
        $aryInput['user_instagram'] = PGRequest::getVar('user_instagram', '', 'POST');
        $aryInput['user_google_plus'] = PGRequest::getVar('user_google_plus', '', 'POST');

      	$aryOutput = array();
      	$aryOutput['intOK'] = 1;
      
      	//THUC HIEN CHECK THONG TIN INPUT
      	check_member_input($aryInput, $aryError, true);
      
      	if (!$aryError) {
	        unset($aryInput['user_id']);
	        if (!$aryInput['user_password']) {
	          unset($aryInput['user_password']);
	        }
	        else {
	          include "../include/users/class_user.php";
	          $new_user = new PGUser(array($userId, '', ''));
	          //$signup_password = ($setting['setting_signup_randpass']) ? randomcode(10) : $aryInput['user_password'];
	          $signup_password = $aryInput['user_password'];
	          $aryInput['user_password'] = $new_user->user_password_crypt($signup_password);
	          $aryInput['user_code'] = $new_user->user_salt;
	        }
	        if (!$database->update(TBL_USER, $aryInput, "user_id={$userId}")) {
	          $aryOutput['strError'] = "Lỗi hệ thống";
	          $aryOutput['intOK'] = 0;
	        }else{
                $aryOutput['uID'] = $userId;
            }
      	}else {
          	$aryOutput['strError'] = (is_array($aryError))?join("<br>", $aryError):"";
          	$aryOutput['intOK'] = 0;
      	}
      	echo json_encode($aryOutput);
      	exit();
    }else{
        if( isset($_FILES['image']) && count($_FILES['image']['error']) == 1 && $_FILES['image']['error'][0] > 0){
            //file not selected
        } else if(isset($_FILES['image'])){ //this is just to check if isset($_FILE). Not required.
            //file selected
            $uID = PGRequest::GetInt('uID', 0, 'POST');
            $user_username = PGRequest::getVar('user_username', '', 'POST');

            // Remove old avatar
            if ($aryUser["user_avatar"] != "")
                removeImage($aryUser["user_avatar"], str_replace('admin_', '', $page.'s'));

            $inputUpdateAvatar = array();
            $inputUpdateAvatar['user_avatar'] = uploadImage($_FILES["image"]["name"], $_FILES["image"]["tmp_name"], str_replace('admin_', '', $page.'s'), 'avatar-'.$user_username);
            $database->update(TBL_USER, $inputUpdateAvatar, "user_id={$uID}");
            cheader($uri->base().'admin_member.php');
        }
    }

    $district_edit = getDistrict($aryUser['user_city']);
    $district = getDistrict();
    $city = getCity();
    $smarty->assign('district_edit', $district_edit);
    $smarty->assign('district', $district);
    $smarty->assign('city', $city);
    $smarty->assign('json_district', json_encode($district));
    $smarty->assign('userId', $userId);
    $smarty->assign('aryUser', $aryUser);
    $smarty->assign('typeUser', $typeUser);
    
    break;
    
  case "remove":
    $cid = PGRequest::getVar('cid', array(), '', 'array');
    if (count($cid)) {
		$results = $database->db_query("SELECT user_avatar FROM ".TBL_USER." WHERE user_id IN(".implode(",", $cid).")");
		while ($row = $database->db_fetch_assoc($results)){
			removeImage($deal["user_avatar"], 'users');
		}
        $database->db_query("DELETE FROM ".TBL_USER." WHERE user_id IN(".implode(",", $cid).")");
    }
    
    cheader($uri->base().'admin_member.php');
    
    break;
    
  case "unpublish":
  case "publish":
    $status = ($task == 'unpublish') ? 0 : 1;
    $cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
    
    if (count($cid)) {
      $query = "UPDATE ".TBL_USER." SET user_enabled={$status} WHERE user_id IN(".implode(",", $cid).")";
      $results = $database->db_query($query);
    }
    cheader($uri->base().'admin_member.php');
    break;
}

$smarty->assign('rootUrl', PG_URL_ROOT);
$smarty->assign('sites', $sites);
$smarty->assign('task', $task);

////////////////////////
if ($task == 'view') {  
  $toolbar = createToolbarAce('export', 'add', 'edit', 'remove', 'publish', 'unpublish');
}
elseif ($task == 'edit' || $task == 'add') {
  $toolbar = createToolbarAce('save','cancel');
}
elseif ($task == 'detail') {
  $toolbar = createToolbarAce('cancel');
}


function check_banks_input($input, &$aryError, $isUpdate=false) {  
	global $database;
	//CHECK BANK ACCOUNT
	if (trim($input['userbank_account_number']) == "") {
		$aryError[] = 'Hãy nhập số tài khoản';
	}

	if (trim($input['userbank_branch']) == "") {
		$aryError[] = 'Chi nhánh không được để trống';
	}
}


function check_member_input($input, &$aryError, $isUpdate=false) {
    global $database, $validate, $site_id;

    //CHECK EMAIL
    if ($input['user_email'] == '') {
      $aryError[] = 'Hãy nhập Email';
    }
    else if ($input['user_email'] !='') {
        if (!$validate->isEmail($input['user_email'])) {
            $aryError[] = 'Email không đúng định dạng';
        }
        else {
            $email = strtolower($input['user_email']);
            $sql = "SELECT user_id FROM ".TBL_USER." WHERE LOWER(user_email)='{$email}' AND user_site_id=".$site_id;
            if ($isUpdate) {
                $sql .= " AND user_id <>".$input['user_id'];
            }
            if ($database->db_num_rows($database->db_query($sql))) {
                $aryError[] = 'Email này đã có trong hệ thống. Hãy chọn 1 email khác.';
            }
        }
    }
    //CHECK ADMIN NAME
    if (strlen($input['user_fullname']) < 6) {
      $aryError[] = 'Họ tên phải ít nhất 6 ký tự';
    }
    //CHECK PASSWORDS
      if (($isUpdate && trim($input['user_password'])!= '' && strlen($input['user_password']) < 6) || (!$isUpdate && strlen($input['user_password']) < 6)) {
          $aryError[] = 'Mật khẩu phải tối thiểu 6 ký tự.';
      }
      //CHECK MOBILE
    if (strlen($input['user_mobile']) < 6) {
      $aryError[] = 'Hãy nhập số điện thoại';
    }
    //CHECK ADDRESS
    if (trim($input['user_address']) == '' || (int)$input['user_district'] == 0 || (int)$input['user_city'] == 0) {
      $aryError[] = 'Địa chỉ, Quận/Huyện/Thị xã, Tỉnh/Thành phố phải có';
    }

  return true;
}

include "admin_footer.php";
?>