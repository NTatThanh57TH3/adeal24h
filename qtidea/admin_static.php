<?php
$page = "admin_static";
$page_title = "Quản lý nội dung tĩnh";
include "admin_header.php";
include "include/develops/class_static.php";

$objStatic = new PGStatic();

$task = PGRequest::GetCmd('task', 'view');
if ($task == 'cancel') $task = 'view';

$objAcl = new PGAcl();
if (!$objAcl->checkPermission($page, $task)) {
	$objAcl->showErrorPage($smarty);
}

switch($task){
	case 'change':
		break;

	case 'edit':
	case 'add':
		if ($task == 'edit') $page_title = "Cập nhật nội dung tĩnh";
		else $page_title = "Thêm mới nội dung tĩnh";
		
		$static_id	= PGRequest::getInt('static_id', 0, 'GET');
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if ( !$static_id ){
			$static_id = $cid[0];
		}
		
		//get static groups
		$grStatic = $objStatic->groupStatic();
		
		$thisStatic = $objStatic->loadItem($static_id);
		if ( $setting['setting_tab_data'] && $thisStatic ){
			$sql = "SELECT * FROM ".TBL_TAB." WHERE tab_reference_id = " . $thisStatic->data['static_id'] . " AND tab_type = 'static' ORDER BY tab_ordering ASC, tab_id DESC";
			$results = $database->db_query($sql);
			while ( $row = $database->db_fetch_assoc($results) ){
				$thisStatic->dataTabs[] = $row;
			}
		}
		$itemTab->dataTabs = ( isset($thisStatic->dataTabs) && is_array($thisStatic->dataTabs) ) ? $thisStatic->dataTabs : false ;
		
		$smarty->assign('static_id', $static_id);
		$smarty->assign('grStatic', $grStatic);
		$smarty->assign('thisStatic', $thisStatic);
		$smarty->assign('itemTab', $itemTab);
		break;

	case 'pending':
	case 'saveonly':
	case 'save':
		$changetext                 = PGRequest::getInt('changetext', 0, 'POST');
		if ( $changetext ){
			if ( !$admin->admin_super ){
				PGError::set_error('Bạn không đủ quyền thực hiện chức năng này. Chỉ có SUPER ADMIN mới có quyền thực hiện chức năng này!');
				cheader($uri->base().'admin_static.php');
			}
			if ( !isset($admin->admin_site_default['site_id']) || !$admin->admin_site_default['site_id'] ){
				PGError::set_error('Bạn không thể thực hiện chức năng này do chưa cấu hình sử dụng site mặc định!');
				cheader($uri->base().'admin_static.php');
			}

			$text_find = $database->getEscaped(PGRequest::getString('text_find', '', 'POST'));
			$text_find_convert = iconv(mb_detect_encoding($text_find, mb_detect_order(), true), "UTF-8", $text_find);
			$text_replace = $database->getEscaped(PGRequest::getString('text_replace', '', 'POST'));

			if ( !strlen($text_find) || !strlen($text_replace) ){
				PGError::set_error('Không thể thực hiện chức năng này do từ tìm kiếm hoặc từ thay thế đang để rỗng!');
				cheader($uri->base().'admin_static.php');
			}

			$query = "UPDATE ".TBL_STATIC."
					SET static_fulltext = REPLACE(static_fulltext, '".$text_find_convert."', '".$text_replace."')
					WHERE static_site_id = {$admin->admin_site_default['site_id']}";
			$database->db_query($query);

			$sql = "UPDATE ".TBL_STATIC."
						SET static_title = REPLACE(static_title, '".$text_find."', '".$text_replace."'),
						static_short_desc = REPLACE(static_short_desc, '".$text_find."', '".$text_replace."'),
						static_fulltext = REPLACE(static_fulltext, '".$text_find."', '".$text_replace."'),
						static_metatitle = REPLACE(static_metatitle, '".$text_find."', '".$text_replace."'),
						static_metakey = REPLACE(static_metakey, '".$text_find."', '".$text_replace."'),
						static_metadesc = REPLACE(static_metadesc, '".$text_find."', '".$text_replace."')
						WHERE static_site_id = {$admin->admin_site_default['site_id']}";
			if ( !$database->db_query($sql) ){
				PGError::set_error('Có lỗi xảy ra trong quá trình cập nhật. Lỗi:' . $database->db_error());
			}else{
				PGError::set_message('Thay thế thành công từ khóa <b>'.$text_find.'</b> thành <b style="color:red;">'.$text_replace.'</b>!');
			}
			cheader($uri->base().'admin_static.php');
		}

		$static_id				= PGRequest::getInt('static_id', 0, 'POST');
		$static_site_id			= PGRequest::GetInt('static_site_id', 0, 'POST');
		$static_type			= PGRequest::GetInt('static_type', 0, 'POST');
		$static_id_value		= PGRequest::getInt('static_id_value', 0, 'POST');
		$static_title			= $database->getEscaped(PGRequest::getString('static_title', '', 'POST'));
		$static_alias			= $database->getEscaped(PGRequest::getString('static_alias', '', 'POST'));
		$static_style			= $database->getEscaped(PGRequest::getString('static_style', '', 'POST'));
		$static_style_color		= $database->getEscaped(PGRequest::getString('static_style_color', '', 'POST'));
		$static_short_desc		= $filter->_decode(PGRequest::getVar('static_short_desc', '', 'post', 'string', PGREQUEST_ALLOWRAW ));
		$static_fulltext		= $filter->_decode(PGRequest::getVar('static_fulltext', '', 'post', 'string', PGREQUEST_ALLOWRAW ));
		$static_struct_html_h	= PGRequest::getInt('static_struct_html_h', 0, 'POST');
		$static_group			= PGRequest::getInt('static_group', 0, 'POST');
		$static_template_design	= PGRequest::GetInt('static_template_design', 0, 'POST');
		$static_status			= PGRequest::GetInt('static_status', 0, 'POST');

		$static_custom_html      	= PGRequest::GetInt('static_custom_html', 0, 'POST');
		$static_custom_html_mobile 	= PGRequest::GetInt('static_custom_html_mobile', 0, 'POST');
		$static_template_director	= $database->getEscaped(PGRequest::getString('static_template_director', '', 'POST'));

		$changeimage				= PGRequest::getInt('changeimage', 0, 'POST');

		if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
			$static_site_id 	= $admin->admin_site_default['site_id'];
		
		$thisStatic = $objStatic->loadItem($static_id_value);
		if (!$objStatic->is_message){
			$input['static_id']	 				= $static_id_value;
			if ( $static_site_id ){
				$input['static_site_id']		= $static_site_id;
			}
			$input['static_type']				= $static_type;
			$input['static_title']				= $static_title;

			/*
			 * XỬ LÝ KHI THÊM MỚI KHÔNG XỬ LÝ EDIT
			 * Nếu nhập alias thì alias sinh ra bằng nhập
			 * Nếu không nhập alias thì sinh tự động mã hóa
			*/
			if ( !$static_id_value ){ // ADD
				$name_alias						= convertKhongdau($static_title);
				$input['static_alias'] 			= generateSlug($name_alias, strlen($name_alias));
			}

			if ( !$static_id_value ){ // ADD
				$name_alias						= convertKhongdau($static_title);
				$input['static_alias'] 			= generateSlug($name_alias, strlen($name_alias));
			}else{ // EDIT
				if ( $static_alias === $thisStatic->data['static_alias'] )
					$input['static_alias']		= $thisStatic->data['static_alias'];
				else{
					$name_alias					= convertKhongdau($static_alias);
					$input['static_alias'] 		= generateSlug($name_alias, strlen($name_alias));
				}
			}

			$input['static_style']				= $static_style;
			$input['static_style_color']		= $static_style_color;
			$input['static_group']				= $static_group;
			$input['static_short_desc']			= $static_short_desc;
			$input['static_fulltext']			= $static_fulltext;
			$input['static_struct_html_h']		= $static_struct_html_h;
			$input['static_created']			= $datetime->timestampToDateTime();
			$input['static_template_design']	= $static_template_design;
			$input['static_status']				= $static_status;
			if ( $task == 'pending' ){
				$input['static_status']			= 2;
			}

            // Add Meta title, meta keyword, meta description
            $input['static_metatitle']          = $database->getEscaped(PGRequest::getString('static_metatitle', '', 'POST'));
            $input['static_metakey']	        = $database->getEscaped(PGRequest::getString('static_metakey', '', 'POST'));
			if ( !$input['static_metakey'] && $setting['setting_auto_keyword_born'] ){
				$input['static_metakey']		= $logAdmin->auto_keyword_born($input['static_title'], $input['static_short_desc']);
			}
            $input['static_metadesc']	        = $database->getEscaped(PGRequest::getString('static_metadesc', '', 'POST'));

			// Custom template
			if ( $static_custom_html ){
				$input['static_custom_html']       = $static_custom_html;
				$input['static_template_director'] = $static_template_director;
			}else{
				$input['static_custom_html']       = 0;
				$input['static_template_director'] = '';
			}
			if ( $static_custom_html_mobile && $admin->admin_super ){
				$input['static_custom_html_mobile'] = $static_custom_html_mobile;
				$input['static_fulltext_mobile']	= $filter->_decode(PGRequest::getVar('static_fulltext_mobile', '', 'post', 'string', PGREQUEST_ALLOWRAW ));
			}else{
				$input['static_custom_html_mobile'] = 0;
			}

			//Ảnh đại diện
			if ($changeimage == 1){
				if ( $static_id_value ){
					if ($thisStatic->data["static_image_thumbnail"] != "")
						removeImage($thisStatic->data["static_image_thumbnail"], str_replace('admin_', '', $page.'s'));
				}

				if( isset($_FILES['image']) && count($_FILES['image']['error']) == 1 && $_FILES['image']['error'][0] > 0){
				} else if(isset($_FILES['image'])){ //this is just to check if isset($_FILE). Not required.
					//file selected
					$input['static_image_thumbnail'] = uploadImage($_FILES["image"]["name"], $_FILES["image"]["tmp_name"], str_replace('admin_', '', $page.'s'), 'thumbnail-static-'.$input['static_alias']);
				}
			}

			$message = $objStatic->save($thisStatic, $input);
			$db_insert_update_id = ( $static_id_value ? $static_id_value : $database->db_insert_id() );
			$db_insert_id = $db_insert_update_id;

			// Submit DMCA, Submit for SEO
			if ( $static_status ){
				if ( $static_id_value )
					$link_submit = $thisStatic->data['link'];
				else{
					$newStatic = $objStatic->loadItem(FALSE, $db_insert_update_id);
					$link_submit = $newStatic->data['link'];
				}

				auto_call_dmca($link_submit);
				auto_submit_for_seo($link_submit);
			}
		}else{
			$message = $objStatic->is_message;
		}

		if ( $setting['setting_tab_data'] ){
			require_once "admin_tab_form.php";
		}
        if ( $message ){
            $msg_text = ( $task == 'add' ? 'Thêm mới nội dung tĩnh thành công!' : 'Cập nhật nội dung tĩnh thành công!');
            PGError::set_message($msg_text);
        }else{
            $msg_text = 'Lỗi hệ thống! - ' . $database->db_error();
            PGError::set_error($msg_text);
        }
		if ( $task == 'saveonly' ){
			cheader($uri->base().'admin_static.php?task=edit&static_id=' . $db_insert_update_id);
		}
		cheader($uri->base().'admin_static.php');
		break;

	case 'publish':
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if (count($cid)) {
			$message = $objStatic->published($cid, 1);
			PGError::set_message($message);
			cheader($uri->base().'admin_static.php');
		}
		
		break;

	case 'unpublish':
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if (count($cid)) {
			$message = $objStatic->published($cid, 0);
			PGError::set_message($message);
			cheader($uri->base().'admin_static.php');
		}
		break;

	case 'remove':
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if (count($cid)) {
			$message = $objStatic->remove($cid);
			PGError::set_message($message);
			cheader($uri->base().'admin_static.php');
		}
		break;	

    case 'view':
    case 'export':
	default :
		$page_title = "Quản lý nội dung tĩnh";

		if ( $task == 'sync' && !$admin->admin_super ){
			PGError::set_error('Bạn không đủ quyền thực hiện chức năng này. Chỉ có SUPER ADMIN mới có quyền thực hiện chức năng này!');
			cheader($uri->base().'admin_content.php');
		}

		$filter_fulltext= PGRequest::getInt('filter_fulltext', 0, 'POST');
		$filter_type	= PGRequest::getInt('filter_type', 0, 'POST');
		$filter_group	= PGRequest::getInt('filter_group', 0, 'POST');
		$filter_status 	= PGRequest::getInt('filter_status', 1, 'POST');
		$filter_site_id = PGRequest::getInt('filter_site_id', 0, 'POST');
		$search 		= PGRequest::getString('search', '', 'POST');
		
		$p = PGRequest::getInt('p', 1, 'POST');
		$limit = PGRequest::getInt('limit', $setting['setting_list_limit'], 'POST');

		PGTheme::add_css( PG_URL_HOMEPAGE . 'templates/font-awesome-4.7.0/css/font-awesome.min.css');
		
		//get static groups
		$grStatic = $objStatic->groupStatic();
		
		//CONDITION
		if ( !$filter_site_id ){
			if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
				$filter_site_id = $admin->admin_site_default['site_id'];
		}
		if ( $filter_site_id ){
			$where[] = "static_site_id=".$filter_site_id;
		}else{
			$where[] = "static_site_id IN (".implode(",", array_flip($sites)).")";
		}

		if ($search){
			if ($search){
				if ( $filter_fulltext )
					$where[] = "(static_title LIKE'%$search%' OR static_short_desc LIKE'%$search%' OR static_fulltext LIKE'%$search%' OR static_metatitle LIKE'%$search%' OR static_metakey LIKE'%$search%' OR static_metadesc LIKE'%$search%')";
				else
					$where[] = "static_title LIKE'%$search%'";
			}
		}
		if ($filter_group > 0) {	
			$where[] = "static_group=".$filter_group;
		}
		if ($filter_status == 0) {			
			$where[] = "static_status=0";
		}else if ($filter_status == 3){
			$where[] = "static_status>=0";			
		}else{
			$where[] = "static_status=".$filter_status;
		}
		$where = (count($where) ? ' WHERE '.implode(' AND ', $where) : '');
		$order = " ORDER BY static_created DESC";
		// GET THE TOTAL NUMBER OF RECORDS
		$query = "SELECT COUNT(*) AS total FROM ".TBL_STATIC.$where;
		$results = $database->db_fetch_assoc($database->db_query($query));
		// PHAN TRANG
		$pager = new pager($limit, $results['total'], $p);
		$offset = $pager->offset;
		// LAY DANH SACH CHI TIET
		$lsStatic = $objStatic->loadListItems($where, $order, $offset, $limit, $all_field = true, ($filter_fulltext ? $search : false));

        if ( $task == 'export' ){
            $page_title = 'Export danh sách nội dung tĩnh';

            require_once "../include/excel/Classes/PHPExcel/IOFactory.php";
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load("../include/excel/templates/list_link.xls");

            if ($totalRecords > 15000) {
                cheader($uri->base().$page.".php");
            }

            $baseRow = 6;
            foreach($lsStatic as $r => $dataRow) {
                $row = $baseRow + $r;
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $r+1);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dataRow['static_title']);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dataRow['link']);
            }
            $objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);

            $fileName = "danh_sach_noi_dung_tinh_".time().".xls";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $fileName);
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }

		$smarty->assign('filter_fulltext', $filter_fulltext);
		$smarty->assign('grStatic', $grStatic);
		$smarty->assign('filter_type', $filter_type);
		$smarty->assign('filter_group', $filter_group);
		$smarty->assign('filter_status', $filter_status);
		$smarty->assign('filter_site_id', $filter_site_id);
		$smarty->assign('search', $search);
		$smarty->assign('datapage', $pager->page_link());
		$smarty->assign('p', $p);
		$smarty->assign('lsStatic', $lsStatic);
		break;
}

$smarty->assign('sites', $sites);
//create toolbar buttons
if ($task == 'view' || !$task) {
	$toolbar = createToolbarAce('add', 'edit', 'export', 'publish', 'unpublish', 'remove', 'change');
} elseif ($task == 'edit' || $task == 'add') {
	$toolbar = createToolbarAce('pending', 'saveonly', 'save','cancel');
} elseif ($task == 'change') {
	$toolbar = createToolbarAce('save', 'cancel');
}


include "admin_footer.php";
?>