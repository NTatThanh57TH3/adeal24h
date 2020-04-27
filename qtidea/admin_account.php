<?php
$page = "admin_account";
include "admin_header.php";

$task = PGRequest::getCmd('task', 'view');
$page_title = "Thông tin tài khoản";
if ($task=='cancel') $task='view';

$objAcl = new PGAcl();
if (!$objAcl->checkPermission($page, $task)) {
	$objAcl->showErrorPage($smarty);
}

switch ($task) {
	case "view":
	case "save":
		
		$errFlag = 0;
		$query = "SELECT * FROM ".TBL_ADMIN." WHERE admin_id=".$admin->admin_info['admin_id'];
		$aryAdmin = $database->getRow($database->db_query($query));
		
		// DANH SACH QUYEN ADMIN
		$objAcl = new PGAcl();
		$arrGroup = $objAcl->apl;
		$arrPermiss = $objAcl->atl;
		
		$aryAdmin['admin_registerDate'] = $datetime->datetimeDisplay($aryAdmin['admin_registerDate']);
		$aryAdmin['admin_lastvisitDate']	= $datetime->datetimeDisplay($aryAdmin['admin_lastvisitDate']);
		$aryAdmin['admin_group']	= $arrGroup[$aryAdmin['admin_group']];
		$aryAdmin['avatar'] = showAvatar($aryAdmin['admin_avatar'], $aryAdmin['admin_avatar_info']);
		if ($aryAdmin['admin_access']) {
			foreach ($arrPermiss as $key=>$perm) {
				$aryAdmin['admin_access'] = str_replace((string)$key, $perm, $aryAdmin['admin_access']);
			}
		}
		
		$adminId = PGRequest::getInt('adminId', 0, 'POST');
		if ($adminId) {
			$aryInput['admin_name'] = PGRequest::getVar('admin_name', '', 'POST');
            $aryInput['admin_nickname'] = PGRequest::getVar('admin_nickname', '', 'POST');
			$aryInput['admin_email'] = PGRequest::getVar('admin_email', '', 'POST');
			$aryInput['admin_password_old'] = PGRequest::getVar('admin_password_old', '', 'POST');
			$aryInput['admin_password_new'] = PGRequest::getVar('admin_password_new', '', 'POST');
			$aryInput['admin_password_conf'] = PGRequest::getVar('admin_password_conf', '', 'POST');
			$aryInput['admin_group'] = PGRequest::getVar('admin_group', '', 'POST');
			$aryInput['admin_username'] = PGRequest::getVar('admin_username', '', 'POST');
			$aryInput['admin_registerDate'] = PGRequest::getVar('admin_registerDate', '', 'POST');
			$aryInput['admin_lastvisitDate'] = PGRequest::getVar('admin_lastvisitDate', '', 'POST');

			// Ảnh đại diện
			if( isset($_FILES['image']) && count($_FILES['image']['error']) == 1 && $_FILES['image']['error'][0] > 0){
				//file not selected
			} else if(isset($_FILES['image'])){ //this is just to check if isset($_FILE). Not required.
				//file selected
				if ( $aryAdmin['admin_avatar'] ){
					removeImage($aryInput['admin_avatar'], 'admins');
				}
				$admin_avatar = uploadImage($_FILES["image"]["name"], $_FILES["image"]["tmp_name"], 'admins', 'avatar-'.$aryInput['admin_username']);
			}
			
			//THUC HIEN CHECK THONG TIN INPUT
			$admin->check_account_input($aryInput);
			
			if (!$admin->is_error) {
				$name = $database->db_real_escape_string($aryInput['admin_name']);
				$nickname = $database->db_real_escape_string($aryInput['admin_nickname']);
				$email = $database->db_real_escape_string($aryInput['admin_email']);
				$password = $aryInput['admin_password_new'];
				
		    	if (!$admin->admin_edit($username, $password, $name, $nickname, $email, $admin_avatar)) {
		    		$errFlag = 1;
		    		$errorTxt = "Lỗi hệ thống !";
		    	}
		    	else {
		    		$errorTxt = "Sửa thành công. Bạn cần đăng nhập lại để cập nhật được thông tin của mình";
		    	}
		  	}
		  	else {
		    	$errFlag = 1;
		  		$errorTxt = (is_array($admin->is_error))?join("<br>", $admin->is_error):"";
		  	}
		}else{
			$errorTxt = "";
		}
		if ($errFlag) $aryUser = $aryInput;
		else $aryUser = $aryAdmin;
		$smarty->assign('users', $aryUser);
		$smarty->assign('adminId', $admin->admin_info['admin_id']);
		break;
}

$smarty->assign('errorTxt', $errorTxt);
$smarty->assign('errFlag', $errFlag);

$toolbar = createToolbarAce('save');

include "admin_footer.php";
?>