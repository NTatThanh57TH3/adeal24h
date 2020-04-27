<?php
$page = "admin_category";
$page_title = "Quản lý danh mục dữ liệu";
include "admin_header.php";
include "include/develops/class_category.php";
include "include/develops/class_position.php";

$objCategory = new PGCategory();
$objPosition = new PGPosition();

$task = PGRequest::GetCmd('task', 'view');
if ($task == 'cancel') $task = 'view';

$objAcl = new PGAcl();
if (!$objAcl->checkPermission($page, $task)) {
	$objAcl->showErrorPage($smarty);
}

// Get list all position
$list_position = $objPosition->define_position();

// Get all type access site
$all_type_access_sites = all_type_access_sites();
if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] ){
	$account_access_site = explode("|", $admin->admin_site_default['site_access']);
	$arrAccess = array();
	foreach ( $account_access_site as $key_access => $value_access ){
		if ( array_key_exists($value_access, $all_type_access_sites) ){
			$arrAccess[$value_access] = $all_type_access_sites[$value_access];
		}
	}
	$all_type_access_sites = $arrAccess;

	// Get multi country
	if ( $setting['setting_multi_country'] ){
		$_ct_query = "SELECT country_code, country_name FROM ".TBL_COUNTRY." WHERE country_status=1 ORDER BY country_name";
		$_ct_results = $database->db_query($_ct_query);
		while ( $_ct_row = $database->db_fetch_assoc($_ct_results) ){
			$list_countrys[] = $_ct_row;
		}
		if ( isset($list_countrys) && $list_countrys ){
			$smarty->assign('list_countrys', $list_countrys);
		}
	}
}

$site_bds = false;
if ( isset($list_modules['bds']) && is_array($list_modules['bds']) ){
	require_once 'include/develops/services/bds/bds.php';
	$objBds = new PG_SERVICES_BDS();
	$site_bds = true;
}

switch($task){
	case 'edit':
	case 'add':
		if ($task == 'edit') {
			$page_title = "Cập nhật danh mục dữ liệu";

			$category_id	= PGRequest::GetInt('category_id', 0, 'GET');
			$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
			if ($category_id == FALSE){
				$category_id = $cid[0];
			}

			$thisCategory = $objCategory->loadItem($field_all = TRUE, $category_id);
			if ( $setting['setting_tab_data'] && $thisCategory ){
				$sql = "SELECT * FROM ".TBL_TAB." WHERE tab_reference_id = " . $thisCategory->data['category_id'] . " AND tab_type = 'category' ORDER BY tab_ordering ASC, tab_id DESC";
				$results = $database->db_query($sql);
				while ( $row = $database->db_fetch_assoc($results) ){
					$thisCategory->dataTabs[] = $row;
				}
			}
			$itemTab->dataTabs = ( isset($thisCategory->dataTabs) && is_array($thisCategory->dataTabs) ) ? $thisCategory->dataTabs : false ;
			$selected = $thisCategory->category_parent_id;

			$smarty->assign('itemTab', $itemTab);
			$smarty->assign('thisCategory', $thisCategory);
		}else {
			$page_title = "Thêm mới danh mục dữ liệu";
			$category_id = 0;
			$selected = 0;
		}

		// LẤY TẤT CẢ DANH SÁCH CATEGORY
		$whereCate[] = "category_status=1";
		if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
			$whereCate[] = "category_site_id=".$admin->admin_site_default['site_id'];
		else
			$whereCate[] = "category_site_id IN (".implode(",", array_flip($sites)).")";

		$listCatItems 	= $objCategory->loadListItems(FALSE, $whereCate, " ORDER BY category_type DESC, category_ordering ASC, category_id DESC");
		if ( $task == 'edit' ){
			foreach( $listCatItems as $key => $itemCat ){
				if ( $itemCat['category_id'] == $thisCategory->data['category_id'] ){
					unset($listCatItems[$key]);
				}
			}
		}
		$listItems = $objCategory->getOptionItems($listCatItems, 0, $selected);

		// LẤY TẤT CẢ DANH SÁCH CATEGORY DẠNG CHECKBOX
		if ( $category_id ) {
			$query = 'SELECT category_parent_id FROM ' . TBL_CATEGORY_PARENT . ' WHERE category_id=' . $category_id;
			$results = $database->db_query($query);
			while ($row = $database->db_fetch_assoc($results)) {
				$aryChecbox[] = $row['category_parent_id'];
			}
		}
		$listOptions = $objCategory->getCheckboxItems($listCatItems, 0, (isset($aryChecbox) && is_array($aryChecbox)) ? $aryChecbox : array(), 'categoryParentId');

		if ( $task == 'edit' && $admin->admin_super && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id']){
			$aryNotDomain = array();
			array_push($aryNotDomain, $admin->admin_site_default['site_domain']);

			// Get site_domin not same site_access
			$same_query = "SELECT site_domain FROM ".TBL_SITE." WHERE site_status=1 AND site_access <> '".$admin->admin_site_default['site_access']."'";
			$same_results = $database->db_query($same_query);
			while ( $same_row = $database->db_fetch_assoc($same_results) ){
				if ( $same_row['site_domain'] ){
					array_push($aryNotDomain, $same_row['site_domain']);
				}
			}
			$aryNotDomain = array_unique($aryNotDomain);

			$list_sites = get_list_sites(false, $aryNotDomain);

			// Get list categories other site
			$o_query = "SELECT category_id, category_name, category_site_id FROM ".TBL_CATEGORY." WHERE category_status=1 AND category_site_id <> ".$admin->admin_site_default['site_id']." ORDER BY category_ordering ASC, category_id DESC";
			$o_results = $database->db_query($o_query);
			while ( $o_row = $database->db_fetch_assoc($o_results) ){
				$list_cates[$o_row['category_id']] = $o_row;
			}

			$arrSite = array();
			$arrCate = array();

			foreach ($list_sites as $cID => $c ){
				$arrSite[$cID] = array('id' => $cID, 'title' => $c);
			}
			foreach ($list_cates as $id => $cate){
				$arrCate[$cate['category_site_id']][$id] = $cate['category_name'];
			}
			$smarty->assign('jsonSite', json_encode($arrSite));
			$smarty->assign('jsonCate', json_encode($arrCate));
		}

		if ( $site_bds ){
			$_bds_list_sections = $objBds->_bds_section();
			$smarty->assign('_bds_list_sections', $_bds_list_sections);
		}
		
		$smarty->assign('category_id', $category_id);
		$smarty->assign('listItems', $listItems);
		$smarty->assign('listOptions', $listOptions);

		break;

	case 'importdata':
		if ( $admin->admin_super && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] ){
			$import_to_siteId			= $admin->admin_site_default['site_id'];
			$import_to_cateId			= PGRequest::GetInt('import_to_cateId', 0, 'POST');
			$import_site_id				= PGRequest::GetInt('import_site_id', 0, 'POST');
			$import_cate_id				= PGRequest::GetInt('import_cate_id', 0, 'POST');

			if ( $import_to_cateId && $import_site_id && $import_cate_id ){
				$query = "
                  INSERT INTO ".TBL_CATEGORY_IMPORT."
                    (site_id, category_id, import_site_id, import_category_id)
                    VALUES (
                      '{$import_to_siteId}',
                      '{$import_to_cateId}',
                      '{$import_site_id}',
                      '{$import_cate_id}'
                    )ON DUPLICATE KEY UPDATE
                      site_id='{$import_to_siteId}',
                      category_id='{$import_to_cateId}',
                      import_site_id='{$import_site_id}',
                      import_category_id='{$import_cate_id}'
                   ";
				if ( $database->db_query($query) ){
					echo json_encode(array('isOk' => true, 'message' => 'Import dữ liệu thành công!'));
					exit();
				}else{
					echo json_encode(array('isOk' => false, 'error' => 'Không thể thực hiện truy vấn import!'));
					exit();
				}
			}else{
				echo json_encode(array('isOk' => false, 'error' => 'Không đủ dữ liệu đầu vào!'));
				exit();
			}
		}else{
			echo json_encode(array('isOk' => false, 'error' => 'Bạn không đủ quyền import dữ liệu hoặc bạn chưa chọn thao tác trên site mặc định!'));
			exit();
		}
		break;

	case 'show_import_data':
		if ( $admin->admin_super && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] ){
			$cateId						= PGRequest::GetInt('cateId', 0, 'POST');
			$list_sites 				= get_list_sites();
			if ( $cateId ){
				$query = "SELECT import_site_id, import_category_id FROM ".TBL_CATEGORY_IMPORT." WHERE category_id = ".$cateId;
				$results = $database->db_query($query);
				while ( $row = $database->db_fetch_assoc($results) ){
					$list_site_id[] = $row['import_site_id'];
					$list_cate_id[] = $row['import_category_id'];
				}
				if ( isset($list_site_id) && $list_site_id && isset($list_cate_id) && $list_cate_id ){
					$sql = "SELECT category_id, category_name, category_site_id FROM ".TBL_CATEGORY." WHERE category_id IN(".implode(",", $list_cate_id).") AND category_site_id IN(".implode(",", $list_site_id).") ORDER BY category_site_id ASC, category_ordering ASC, category_id DESC";
					$results = $database->db_query($sql);
					while ( $row = $database->db_fetch_assoc($results) ){
						$row['site_domain'] = $list_sites[$row['category_site_id']];
						unset($row['category_site_id']);
						$list_datas[] 		= $row;
					}
					if ( isset($list_datas) && $list_datas ){
						echo json_encode(array('isOk' => true, 'data' => $list_datas));
						exit();
					}else{
						echo json_encode(array('isOk' => false, 'error' => 'Không có dữ liệu danh mục trả về!'));
						exit();
					}
				}else{
					echo json_encode(array('isOk' => false, 'error' => 'Hiện tại chưa có dữ liệu import!'));
					exit();
				}
			}else{
				echo json_encode(array('isOk' => false, 'error' => 'Không tồn tại tham số đầu vào: Id danh mục!'));
				exit();
			}
		}else{
			echo json_encode(array('isOk' => false, 'error' => 'Bạn không đủ quyền xem dữ liệu import hoặc bạn chưa chọn thao tác trên site mặc định!'));
			exit();
		}
		break;

	case 'remove_import':
		if ( $admin->admin_super && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] ){
			$cateId						= PGRequest::GetInt('cateId', 0, 'POST');

			if ( $cateId ){
				$query = "DELETE FROM ".TBL_CATEGORY_IMPORT." WHERE import_category_id = " . $cateId;
				if ( $database->db_query($query) ){
					echo json_encode(array('isOk' => true, 'message' => 'Xóa dữ liệu import thành công!'));
					exit();
				}else{
					echo json_encode(array('isOk' => false, 'error' => 'Không thể thực hiện xóa import dữ liệu!'));
					exit();
				}
			}else{
				echo json_encode(array('isOk' => false, 'error' => 'Không tồn tại tham số đầu vào: Id danh mục!'));
				exit();
			}
		}else{
			echo json_encode(array('isOk' => false, 'error' => 'Bạn không đủ quyền xóa dữ liệu import hoặc bạn chưa chọn thao tác trên site mặc định!'));
			exit();
		}
		break;

	case 'saveonly':
	case 'save':
	case 'save2add':
		$category_site_id			= PGRequest::GetInt('category_site_id', 0, 'POST');
		$category_parent_id			= PGRequest::getInt('category_parent_id', 0, 'POST');
		$category_id_value			= PGRequest::getInt('category_id_value', 0, 'POST');
		$category_name				= $database->getEscaped(PGRequest::getString('category_name', '', 'POST'));
		$category_alias				= $database->getEscaped(PGRequest::getString('category_alias', '', 'POST'));
		$category_description		= $filter->_decode(PGRequest::getVar('category_description', '', 'post', 'string', PGREQUEST_ALLOWRAW ));
		$category_short_desc		= $filter->_decode(PGRequest::getVar('category_short_desc', '', 'post', 'string', PGREQUEST_ALLOWRAW ));
		$category_struct_html_h		= PGRequest::getInt('category_struct_html_h', 0, 'POST');
		$category_created			= $database->getEscaped(PGRequest::getString('category_created', ''));
		$category_style				= $database->getEscaped(PGRequest::getString('category_style', ''));
		$category_link				= $database->getEscaped(PGRequest::getString('category_link', ''));
		$category_create_box		= PGRequest::GetInt('category_create_box', 0, 'POST');
		$category_show_home			= PGRequest::GetInt('category_show_home', 0, 'POST');
		$category_get_sub			= PGRequest::GetInt('category_get_sub', 0, 'POST');
		$category_type				= PGRequest::GetInt('category_type', 0, 'POST');
		$category_position			= PGRequest::getVar('category_position', '', 'POST');
		$category_status			= PGRequest::GetInt('category_status', 0, 'POST');
		$category_ordering			= PGRequest::GetInt('category_ordering', 0, 'POST');
		$changeimage				= PGRequest::getInt('changeimage', 0, 'POST');
		$changeimagesocial			= PGRequest::getInt('changeimagesocial', 0, 'POST');

		$category_custom_html      	= PGRequest::GetInt('category_custom_html', 0, 'POST');
		$category_template_director = $database->getEscaped(PGRequest::getString('category_template_director', '', 'POST'));

		if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
			$category_site_id		= $admin->admin_site_default['site_id'];

		$thisCategory = $objCategory->loadItem(TRUE, $category_id_value);
		
		if (is_object($objCategory)){
			if ( $site_bds ){
				$input['category_bds_section_id'] = PGRequest::GetInt('category_bds_section_id', 0, 'POST');
			}
			$input['category_id'] 				= $category_id_value;
			$input['category_name']				= $category_name;

			if ( !$category_id_value ){
				if ( $category_site_id ){
					$input['category_site_id']	= $category_site_id;
				}

				$name_alias						= convertKhongdau($category_name);
				$input['category_alias']	 	= generateSlug($name_alias, strlen($name_alias));
			}else{
				if ( $admin->admin_super ){
					if ( $category_alias != "" )
						$name_alias				= convertKhongdau($category_alias);
					else
						$name_alias				= convertKhongdau($category_name);

					$input['category_alias']	= generateSlug($name_alias, strlen($name_alias));
				}else{
					$input['category_alias']	= $thisCategory->data["category_alias"];
				}
			}
			$input['category_description']		= $category_description;
			$input['category_short_desc']		= $category_short_desc;
			$input['category_struct_html_h']	= $category_struct_html_h;
			$input['category_style']			= $category_style;
			$input['category_link']				= $category_link;
			if ( $admin->admin_super ){
				$input['category_create_box']	= $category_create_box;
			}
			$input['category_show_home']		= $category_show_home;
			$input['category_get_sub']			= $category_get_sub;
			$input['category_type']				= ($category_type ? $category_type : SITE_NEWS );
			$input['category_position']			= $category_position;
			$input['category_status']			= $category_status;

			if ($category_id_value == 0){
				$input['category_created']			= $datetime->timestampToDateTime();
				$input['category_created_by']		= $admin->admin_info["admin_id"];
			}else{
				$input['category_modified']			= $datetime->timestampToDateTime();
				$input['category_modified_by']		= $admin->admin_info["admin_id"];
			}

			$input['category_ordering']			= $category_ordering;
			$input['category_parent_id']		= $category_parent_id;
			
			$input['category_root_id'] = 0;
			if ( $input['category_parent_id'] ){
				$rootCat = $objCategory->getRootItem(false, $input['category_parent_id']);
				if ( is_object($rootCat) ){
					$input['category_root_id']		= $rootCat->category_id;
				}
			}
			
			// Add Meta title, meta keyword, meta description
            $input['category_metatitle']= $database->getEscaped(PGRequest::getString('category_metatitle', '', 'POST'));
            $input['category_metakey']	= $database->getEscaped(PGRequest::getString('category_metakey', '', 'POST'));
			if ( !$input['category_metakey'] && $setting['setting_auto_keyword_born'] ){
				$input['category_metakey']	= $logAdmin->auto_keyword_born($input['category_metatitle'], $input['category_short_desc']);
			}
            $input['category_metadesc']	= $database->getEscaped(PGRequest::getString('category_metadesc', '', 'POST'));

			// Custom template
			if ( $category_custom_html ){
				$input['category_custom_html']       = $category_custom_html;
				$input['category_template_director'] = $category_template_director;
			}else{
				$input['category_custom_html']       = 0;
				$input['category_template_director'] = '';
			}

			if ( $setting['setting_multi_country'] ){
				$input['category_country_code']	= PGRequest::getString('category_country_code', '', 'POST');
			}
			 
			if ($changeimage == 1){
				if (is_object($thisCategory) && $thisCategory->category_id){
					if ($thisCategory->data["category_images"] != "") removeImage($thisCategory->data["category_images"], str_replace('admin_', '', $page.'s'));
				}
				$input['category_images']		= uploadImage($_FILES["image"]["name"], $_FILES["image"]["tmp_name"], str_replace('admin_', '', $page.'s'), $input['category_alias'] . '-' . $input['category_site_id'] );
			}
			if ($changeimagesocial == 1){
				if (is_object($thisCategory) && $thisCategory->category_id){
					if ($thisCategory->data["category_social_images"] != "") removeImage($thisCategory->data["category_social_images"], str_replace('admin_', '', $page.'s'));
				}
				$input['category_social_images']= uploadImage($_FILES["image_social"]["name"], $_FILES["image_social"]["tmp_name"], str_replace('admin_', '', $page.'s'), $input['category_alias'] . '-social-' . $input['category_site_id'] );
			}
			$objCategory->save($thisCategory, $input);
			
			/* update level for this category */
			if ($category_id_value == 0){
				$db_insert_id = $db_insert_id = $database->db_insert_id();
			}else{
				$db_insert_id = $category_id_value;
			}
            $aryID = $objCategory->get_all_whole_under_id($db_insert_id);
            $inputLevel['category_under_id'] = implode(",", $aryID);

			$thisCategoryLevel = $objCategory->loadItem(TRUE, $db_insert_id);
			$inputLevel['category_level'] = $objCategory->getLevelItem($db_insert_id);
			if ( $inputLevel['category_level'] && $inputLevel['category_show_home'] ){
				$inputLevel['category_show_home'] = 0;
			}

			//optimize URL
			if ( $category_id_value ){
				$database->db_query("DELETE FROM ".TBL_OPTIMIZE." WHERE post_id={$db_insert_id} AND post_site_id ={$category_site_id} AND post_type = 0");
			}
			$optimize_insert = 'INSERT INTO '.TBL_OPTIMIZE.' (optimize_url, post_site_id, post_id, post_type)
                                VALUES("'.$input['category_alias'].'",'.$category_site_id.','.$db_insert_id.',0)';
			$database->db_query($optimize_insert);

			// Info category parent
			$categoryParentId 				= PGRequest::getVar( 'categoryParentId', array(), 'post', 'array' );
			if ( count($categoryParentId) ) {
				$sql = array();
				if ( $category_id_value ){
					// Delete old
					$delete = "DELETE FROM ".TBL_CATEGORY_PARENT." WHERE category_id={$category_id_value}";
					$database->db_query($delete);
					foreach ($categoryParentId as $catid) {
						if ( $catid != $input['category_id'] && $catid != $input['category_parent_id'] )
							$sql[] = '('.$category_id_value.', '.$catid.', '.$input['category_site_id'].')';
					}
				}else{
					foreach ($categoryParentId as $catid) {
						if ( $catid != $input['category_id'] && $catid != $input['category_parent_id'] )
							$sql[] = '('.$db_insert_id.', '.$catid.', '.$input['category_site_id'].')';
					}
				}
				$insert = 'INSERT INTO '.TBL_CATEGORY_PARENT.' (category_id, category_parent_id, site_id) VALUES '.implode(',', $sql);
				$database->db_query($insert);
			}else{
				if ( $category_id_value ){
					// Delete old
					$delete = "DELETE FROM ".TBL_CATEGORY_PARENT." WHERE category_id={$category_id_value}";
					$database->db_query($delete);
				}
			}
			
			$message = $objCategory->save($thisCategoryLevel, $inputLevel);
			if ( $setting['setting_tab_data'] ){
				require_once "admin_tab_form.php";
			}
		}else{
			$message = $objCategory->is_message;
		}
		if ( $message ){
		    $msg_text = ( $task == 'add' ? 'Thêm mới danh mục thành công!' : 'Cập nhật danh mục thành công!');
            PGError::set_message($msg_text);
        }else{
            $msg_text = 'Lỗi hệ thống! - ' . $database->db_error();
            PGError::set_error($msg_text);
        }
		if ( $task == 'saveonly' ){
			cheader($uri->base().'admin_category.php?task=edit&category_id=' . $db_insert_id);
		}else if ($task == 'save'){
			/* Redirect to page list */
			cheader($uri->base().'admin_category.php');
		}else{
			cheader($uri->base().'admin_category.php?task=add&filter_site_id=' . $input['category_site_id']);
		}
		break;

	case 'publish':
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if (count($cid)) {
			$message = $objCategory->published($cid, 1);
			PGError::set_message($message);
			cheader($uri->base().'admin_category.php');
		}
		break;

	case 'unpublish':
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if (count($cid)) {
			$message = $objCategory->published($cid, 0);

			// Remove in table tbl_categories_imports
			$cid_imports = 'import_category_id=' . implode( ' OR import_category_id=', $cid );
			$query = "DELETE FROM ".TBL_CATEGORY_IMPORT." WHERE ( $cid_imports )";
			$database->db_query($query);

			PGError::set_message($message);
			cheader($uri->base().'admin_category.php');
		}	
		break;

	case 'remove':
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if (count($cid)) {
			$message = $objCategory->remove($cid);

			// Remove in table tbl_categories_imports
			$cid_imports = 'import_category_id=' . implode( ' OR import_category_id=', $cid );
			$query_imports = "DELETE FROM ".TBL_CATEGORY_IMPORT." WHERE ( $cid_imports )";
			$database->db_query($query_imports);

			// Remove in table tbl_categories_parents
			$cid_parents = 'category_id=' . implode( ' OR category_id=', $cid );
			$query_parents = "DELETE FROM ".TBL_CATEGORY_PARENT." WHERE ( $cid_parents )";
			$database->db_query($query_parents);

			if ( $setting['setting_tab_data'] ){
				$cids = 'tab_reference_id=' . implode( ' OR tab_reference_id=', $cid );
				$tab_sql = "DELETE FROM ".TBL_TAB." WHERE tab_type = 'category' AND ( $cids )";
				$database->db_query($tab_sql);
			}

			// Xóa dữ liệu bảng tbl_optimize_url, post_id, post_type = 0
			$postids = 'post_id=' . implode( ' OR post_id=', $cid );
			$database->db_query("DELETE FROM ".TBL_OPTIMIZE." WHERE ( $postids ) AND post_site_id=".$site_id." AND post_type=0");

			PGError::set_message($message);
			cheader($uri->base().'admin_category.php');
		}
		break;	

    case 'view':
    case 'export':
	default :
		$page_title = "Quản lý danh mục dữ liệu";
		
		$filter_status 	= PGRequest::getInt('filter_status', 1, 'POST');
		$filter_catid 	= PGRequest::getInt('filter_catid', 0, 'POST');
		$filter_type	= PGRequest::getInt('filter_type', 0, 'POST');
		$filter_position= PGRequest::getVar('filter_position', '', 'POST');
		$filter_site_id = PGRequest::getInt('filter_site_id', 0, 'REQUEST');
		$search 		= PGRequest::getString('search', '', 'POST');
		
		$p = PGRequest::getInt('p', 1, 'POST');
		$limit = PGRequest::getInt('limit', $setting['setting_list_limit'], 'POST');
		$limit = 100;
		
		//CONDITION
		if ($search){
			$where[] = "category_name LIKE'%$search%'";
		}
		if ($filter_catid){
			$where[] = "category_parent_id=".$filter_catid;
		}
		if ($filter_type){
			$where[] = "category_type=".$filter_type;
		}
		if ($filter_position){
			$where[] = "category_position='{$filter_position}'";
		}

		if ( !$filter_site_id ){
			if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
				$filter_site_id = $admin->admin_site_default['site_id'];
		}
		if ( $filter_site_id ){
			$where[] = "category_site_id=".$filter_site_id;
		}else{
			$where[] = "category_site_id IN (".implode(",", array_flip($sites)).")";
		}

		if ($filter_status == 0) {			
			$where[] = "category_status=0";
		}else if ($filter_status == 3){
			$where[] = "category_status>=0";			
		}else{
			$where[] = "category_status=".$filter_status;
		}
		$where = (count($where) ? ' WHERE '.implode(' AND ', $where) : '');
		$order = " ORDER BY category_type DESC, category_parent_id, category_ordering ASC, category_id DESC";
		
		// GET THE TOTAL NUMBER OF RECORDS
		$totalRecords = $objCategory->TotalRecords($where);
		// PHAN TRANG
		$pager = new pager($limit, $totalRecords, $p);
		$offset = $pager->offset;
		
		// LẤY TẤT CẢ DANH SÁCH
		$items 	= $objCategory->loadListItems(TRUE, $where, $order, $offset, $limit);
        if ( $task == 'export' ){
            $page_title = 'Export danh sách danh mục';

            require_once "../include/excel/Classes/PHPExcel/IOFactory.php";
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load("../include/excel/templates/list_link.xls");

            if ($totalRecords > 15000) {
                cheader($uri->base().$page.".php");
            }

            $baseRow = 6;
            foreach($items as $r => $dataRow) {
                $row = $baseRow + $r;
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $r+1);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dataRow['category_name']);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dataRow['link']);
            }
            $objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);

            $fileName = "danh_sach_danh_muc_".time().".xls";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $fileName);
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }

		// LẤY DANH SÁCH CÁC DANH MỤC CHA KHÁC
		$aryDataParent = array();
		$whereParent = array();
		if ( $filter_catid ){
			$whereParent[] = "category_id = " . $filter_catid;
		}
		if ( $filter_site_id ){
			$whereParent[] = "site_id = " . $filter_site_id;
		}
		$whereParent = (count($whereParent) ? ' WHERE '.implode(' AND ', $whereParent) : '');
		$_query = "SELECT category_id FROM " . TBL_CATEGORY_PARENT . $whereParent;
		$_results = $database->db_query($_query);
		while ( $_row = $database->db_fetch_assoc($_results) ){
			$aryDataParent[] = $_row['category_id'];
		}
		
		// LAY DANH SACH CHI TIET
		$list_category = $objCategory->getListItems($items, 0, $text = "", $offset, $limit, $aryDataParent);
		
		// LIST ALL ITEMS
		$listItems = $objCategory->getOptionItems($items, 0, $filter_catid);
		
		$smarty->assign('filter_status', $filter_status);
		$smarty->assign('filter_catid', $filter_catid);
		$smarty->assign('filter_type', $filter_type);
		$smarty->assign('filter_position', $filter_position);
		$smarty->assign('filter_site_id', $filter_site_id);
		$smarty->assign('search', $search);
		$smarty->assign('datapage', $pager->page_link());
		$smarty->assign('p', $p);
		$smarty->assign('totalRecords', $totalRecords);
		$smarty->assign('list_category', $list_category);
		$smarty->assign('listItems', $listItems);
		break;
}

$smarty->assign('sites', $sites);
$smarty->assign('list_position', $list_position);
$smarty->assign('all_type_access_sites', $all_type_access_sites);
$smarty->assign('site_bds', $site_bds);

//create toolbar buttons
if ($task == 'view' || !$task) {
	$toolbar = createToolbarAce('add', 'edit', 'export', 'publish', 'unpublish', 'remove');
} elseif ($task == 'edit' || $task == 'add') {
	$toolbar = createToolbarAce('saveonly', 'save', 'save2add', 'cancel');
}

include "admin_footer.php";
?>