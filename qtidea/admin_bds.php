<?php
/**
 * Created by PhpStorm.
 * User: Ngọc Kiều
 * Date: 9/2/2017
 * Time: 11:21 AM
 */
$page = "admin_bds";
$page_title = "Quản lý bất động sản";
include "admin_header.php";

if ( !$admin->admin_site_default ){
    PGError::set_error('Bạn phải cài đặt site mặc định thao tác dữ liệu để có thể thao tác modules cài đặt!');
    cheader('admin_setting.php');
}

$folder = str_replace('admin_', '', $page);
if ( file_exists(PG_ROOT . '/include/develops/services/'.$folder.'/'.$folder.'.php') )
    include PG_ROOT . '/include/develops/services/'.$folder.'/'.$folder.'.php';

$objBds = new PG_SERVICES_BDS();

// Get City, District
$listCity = getCity();
$listDistrict = getDistrict();

$task = PGRequest::getCmd('task', 'view');
if ($task=='cancel') $task='view';

$action = PGRequest::getCmd('action', 'bds');
if ( $admin->admin_info['admin_id'] == 28 || $admin->admin_info['admin_id'] == 9){
    $action = PGRequest::getCmd('action', 'construction'); // Sỹ
}
if ( $action == 'section' ) {
    $table_name = TBL_BDS_SECTION;
    $text_title = 'nhu cầu';
    $type_keyword = 'bds_section';
}else if ( $action == 'bds' ){
    $table_name = TBL_BDS;
    $text_title = 'bất động sản';
    $type_keyword = 'bds';
}else if ( $action == 'project' ){
    $table_name = TBL_BDS_PROJECT;
    $text_title = 'dự án';
    $type_keyword = 'bds_project';
}else if ( $action == 'construction' ){
    $table_name = TBL_CONSTRUCTION;
    $text_title = 'thiết kế - thi công';
    $type_keyword = 'construction_design';
}else if ( $action == 'company' ){
    $table_name = TBL_BDS_COMPANY;
    $text_title = 'đối tác/đơn vị hợp tác';
}

include "include/develops/class_category.php";
$objCategory	= new PGCategory();

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

switch ( $task ) {
    case 'add':
    case 'edit':
        $alias_join = "";
        $filed_join = "";
        $left_join = "";
        if ($action == 'section') {
            $alias_join = "s";
            $filed_join = "";
            $left_join = "";

            $_c_field = 'bds_section_id';
        } else if ($action == 'bds') {
            $alias_join = "b";
            $filed_join = "";
            $left_join = "";

            PGTheme::add_css(PG_URL_HOMEPAGE . 'templates/admin/css/autosuggest.css');
            $_c_field = 'bds_id';
        } else if ($action == 'project') {
            $alias_join = "p";
            $filed_join = "";
            $left_join = "";

            $_c_field = 'bds_project_id';
        } else if ($action == 'construction') {
            $alias_join = "d";
            $filed_join = ", cat.category_name, cat.category_alias";
            $left_join = " LEFT JOIN ".TBL_CATEGORY." AS cat ON cat.category_id = ".$alias_join.".construction_design_category_id";

            $_c_field = 'construction_design_id';
        } else if ($action == 'company') {
            $alias_join = "c";
            $filed_join = "";
            $left_join = "";

            $_c_field = 'company_id';
        }

        if ($task == 'edit') $page_title = "Cập nhật " . $text_title;
        else $page_title = "Thêm mới " . $text_title;

        $id = PGRequest::GetInt('id', 0, 'GET');
        $cid = PGRequest::getVar('cid', array(), 'post', 'array');
        if (!$id) {
            $id = $cid[0];
        }
        if ($task == 'edit') {
            $query = "SELECT ".$alias_join.".* ".$filed_join." FROM " . $table_name . " AS ".$alias_join.$left_join." WHERE " . $alias_join . "." . $_c_field . "=" . $id;
            $result = $database->db_query($query);
            if ($row = $database->db_fetch_assoc($result)) {
                if ($action == 'section') {
                    // Section
                    // Get price range follow
                    $_query = "SELECT bds_section_price_text, bds_section_price_value_min, bds_section_price_value_max FROM ".TBL_BDS_SECTION_PRICE." WHERE bds_section_id = ".$id.($row['bds_section_site_id'] ? " AND site_id=".$row['bds_section_site_id'] : "")." ORDER BY bds_section_price_value_min ASC";
                    $_result = $database->db_query($_query);
                    while ( $_row = $database->db_fetch_assoc($_result) ){
                        $row['priceValueText'][] = $_row;
                    }
                }else if ($action == 'project') {
                    if ( $row['bds_project_types'] ){
                        $row['bds_project_types'] = array_values(explode("|", $row['bds_project_types']));
                        if ( $row['bds_project_types'] ){
                            $row['bds_project_types'] = array_values(explode("|", $row['bds_project_types']));
                            if ( is_array($row['bds_project_types']) && count($row['bds_project_types']) && !empty($row['bds_project_types']) ){
                                $_query = "SELECT category_id, category_name, category_alias, category_level FROM ".TBL_CATEGORY." WHERE category_id IN(".implode(",", $row['bds_project_types']).")";
                                $_results = $database->db_query($_query);
                                while ( $_row = $database->db_fetch_assoc($_results) ){
                                    $_row['link'] = $rewriteClass->rewriteUrlCategory($_row['category_id'],$_row['category_alias'], $_row['category_level']);
                                    $row['dataCat'][] = $_row;
                                }
                            }
                        }
                    }
                    if ( $row['bds_project_number_blocks'] ){
                        $row['bds_project_number_blocks'] = (array) (json_decode($row['bds_project_number_blocks']));
                    }
                    //print_r($row); die;
                } else if ($action == 'bds') {
                    $row['bds_option'] = json_decode($row['bds_option']);
                    $row['bds_utilities'] = json_decode($row['bds_utilities']);

                    $row['bds_furniture'] = json_decode($row['bds_furniture']);
                    if (is_object($row['bds_furniture'])) {
                        $row['bds_furniture'] = (array)$row['bds_furniture'];
                    }
                    $row['bds_cozy'] = json_decode($row['bds_cozy']);

                    $row['bds_image'] = json_decode($row['bds_image']);
                    if (is_object($row['bds_image'])) {
                        $row['bds_image'] = (array)$row['bds_image'];
                        $row['bds_image'] = array_values($row['bds_image']);
                    }

                    $row['bds_image_thumbnail'] = array();
                    if (isset($row['bds_image']) && is_array($row['bds_image']) && count($row['bds_image'])) {
                        foreach ($row['bds_image'] as $key => $value) {
                            $row['bds_image_thumbnail'][$key] = showImageSubject($value, TBL_BDS, 'normal');
                        }
                    }

                    $_bds_price_ranges_selected = $_bds_price_ranges[$row['bds_section']];
                    $listDistrictSelected = getDistrict($row['bds_city_id']);

                    $smarty->assign('_bds_price_ranges_selected', $_bds_price_ranges_selected);
                } else if ($action == 'project') {
                    $row['bds_project_option'] = json_decode($row['bds_project_option']);
                    $row['bds_project_utilities'] = json_decode($row['bds_project_utilities']);

                    $row['bds_project_image'] = json_decode($row['bds_project_image']);
                    if (is_object($row['bds_project_image'])) {
                        $row['bds_project_image'] = (array)$row['bds_project_image'];
                        $row['bds_project_image'] = array_values($row['bds_project_image']);
                    }

                    if (isset($row['bds_project_image']) && is_array($row['bds_project_image']) && count($row['bds_project_image'])) {
                        foreach ($row['bds_project_image'] as $key => $value) {
                            $row['bds_project_image_thumbnail'][$key] = showImageSubject($value, TBL_BDS, 'normal');
                        }
                    }

                    $listDistrictSelected = getDistrict($row['bds_project_city_id']);
                } else if ($action == 'construction') {
                    $row['desc_floor_script'] = $row['construction_design_desc_number_floors'] ? $row['construction_design_desc_number_floors'] : false;
                    $row['construction_design_desc_number_floors'] = json_decode($row['construction_design_desc_number_floors']);
                    if ($row['construction_design_desc_number_floors']) {
                        $row['construction_design_desc_number_floors'] = (array)$row['construction_design_desc_number_floors'];
                    }
                    $row['construction_design_image'] = json_decode($row['construction_design_image']);
                    if (is_object($row['construction_design_image'])) {
                        $row['construction_design_image'] = (array)$row['construction_design_image'];
                        $row['construction_design_image'] = array_values($row['construction_design_image']);
                    }

                    if (isset($row['construction_design_image']) && is_array($row['construction_design_image']) && count($row['construction_design_image'])) {
                        foreach ($row['construction_design_image'] as $key => $value) {
                            $row['construction_design_image_thumbnail'][$key] = showImageSubject($value, TBL_BDS, 'normal');
                        }
                    }
                    $row['link'] = $rewriteClass->rewriteUrlPage($pageName = 'construction_design', $row['construction_design_id'], $row['construction_design_alias'], $row["category_alias"]);

                    $listDistrictSelected = getDistrict($row['construction_design_city_id']);
                } else if ($action == 'company') {
                    $row['logo'] = showImageSubject($row['company_logo'], 'logos', 'normal');
                    $listDistrictSelected = getDistrict($row['company_city_id']);
                }
                $item->data = $row;

                $aryKeywordId = $database->getCol($database->db_query("SELECT keyword_id FROM ".TBL_KEYWORD_INTEGRATED." WHERE integrated_type = '{$type_keyword}' AND integrated_id=".$id));

                $smarty->assign('listDistrictSelected', $listDistrictSelected);
                $smarty->assign('item', $item);
                $smarty->assign('aryKeywordId', $aryKeywordId);
            } else {
                PGError::set_error('Không tồn tại ' . $text_title . ' có id: ' . $id);
                cheader('admin_bds.php?action=' . $action);
            }
        }

        if ($action == 'bds') {
            // Get list projects
            $filter_site_id = PGRequest::getInt('filter_site_id', 0, 'POST');
            if (!$filter_site_id) {
                if (is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'])
                    $filter_site_id = $admin->admin_site_default['site_id'];
            }

            $_p_where[] = "bds_project_status=1";
            if ($filter_site_id) {
                $_p_where[] = "bds_project_site_id=" . $filter_site_id;
            } else {
                $_p_where[] = "bds_project_site_id IN (" . implode(",", array_flip($sites)) . ")";
            }
            $_p_where = (count($_p_where) ? ' WHERE ' . implode(' AND ', $_p_where) : '');

            $_p_order = " ORDER BY bds_project_ordering ASC, bds_project_id DESC";

            $_p_query = "SELECT bds_project_id, bds_project_name FROM " . TBL_BDS_PROJECT . $_p_where . $_p_order;
            $_p_results = $database->db_query($_p_query);
            while ($_p_row = $database->db_fetch_assoc($_p_results)) {
                $_p_list[] = $_p_row;
            }
            if (isset($_p_list) && $_p_list) {
                $smarty->assign('_p_list', $_p_list);
            }
        }
        //Get categories
        $listItems = $objCategory->getOptionItems($listCatItems, 0, ($action == 'bds' ? ($row['bds_category_id'] ? $row['bds_category_id'] : 0) : ($action == 'project' ? ($row['bds_project_category_id'] ? $row['bds_project_category_id'] : 0) : ($row['construction_design_category_id'] ? $row['construction_design_category_id'] : 0))));

        $smarty->assign('listItems', $listItems);

        $smarty->assign('id', $id);
        break;

    case 'change_option_utilities':
        $ajax = PGRequest::GetInt('ajax', 0, 'POST');
        $output['isOk'] = false;
        if ($ajax) {
            $project_id = PGRequest::GetInt('project_id', 0, 'POST');
            if ($project_id) {
                $_query = "SELECT bds_project_option, bds_project_utilities FROM " . TBL_BDS_PROJECT . " WHERE bds_project_id = " . $project_id;
                $_results = $database->db_query($_query);
                if ($_row = $database->db_fetch_assoc($_results)) {
                    $output['isOk'] = true;
                    $output['option'] = json_decode($_row['bds_project_option']);
                    $output['utilities'] = json_decode($_row['bds_project_utilities']);
                }
            }
        }
        echo json_encode($output);
        exit();
        break;

    case 'save':
        $aryKeyword 				= PGRequest::getVar( 'cbo_keyword', array(), 'post', 'array' );
        if ($action == 'section') {
            $bds_section_id = PGRequest::GetInt('bds_section_id', 0, 'POST');

            $input['bds_section_name'] = $database->getEscaped(PGRequest::getString('bds_section_name', '', 'POST'));
            $name_alias = convertKhongdau($input['bds_section_name']);
            $input['bds_section_alias'] = generateSlug($name_alias, strlen($name_alias));

            $input['bds_section_style'] = $database->getEscaped(PGRequest::getString('bds_section_style', '', 'POST'));

            // Add Meta title, meta keyword, meta description
            $input['bds_section_metatitle']         = $database->getEscaped(PGRequest::getString('bds_section_metatitle', '', 'POST'));
            $input['bds_section_metakey']	        = $database->getEscaped(PGRequest::getString('bds_section_metakey', '', 'POST'));

            if ( !$input['bds_section_metakey'] && $aryKeyword && is_array($aryKeyword) && count($aryKeyword) && !empty($aryKeyword) ){
                $input['bds_section_metakey']   	= get_keyword_integrated($aryKeyword);
            }
            if ( !$input['bds_section_metakey'] && $setting['setting_auto_keyword_born'] ){
                $input['bds_section_metakey']	    = $logAdmin->auto_keyword_born($input['bds_section_name']);
            }
            $input['bds_section_metadesc']	        = $database->getEscaped(PGRequest::getString('bds_section_metadesc', '', 'POST'));

            if (!$bds_section_id) {
                $input['bds_section_created'] = $datetime->timestampToDateTime();
                $input['bds_section_created_by'] = $admin->admin_info['admin_id'];
                $input['bds_section_site_id'] = PGRequest::GetInt('bds_section_site_id', 0, 'POST');
                if (is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'])
                    $input['bds_section_site_id'] = $admin->admin_site_default['site_id'];

            } else {
                $input['bds_section_modified'] = $datetime->timestampToDateTime();
                $input['bds_section_modified_by'] = $admin->admin_info['admin_id'];
            }

            $input['bds_section_ordering'] = PGRequest::GetInt('bds_section_ordering', 0, 'POST');
            $input['bds_section_status'] = PGRequest::GetInt('bds_section_status', 0, 'POST');

            $db_insert_section_id = 0;
            if ($bds_section_id) {
                $_c_field = 'bds_section_id';
                if ($database->update($table_name, $input, "$_c_field=" . $bds_section_id)) {
                    $is_error = false;
                    $message = 'Cập nhật ' . $text_title . ' thành công!';
                } else {
                    $is_error = true;
                    $message = 'Lỗi không chỉnh sửa được vì lý do: ' . $database->db_error();
                }
            } else {
                if ($database->insert($table_name, $input)) {
                    $is_error = false;
                    $message = 'Thêm mới ' . $text_title . ' thành công!';
                } else {
                    $is_error = true;
                    $message = 'Lỗi không thêm được vì lý do: ' . $database->db_error();
                }
            }

            $db_insert_section_id = ( $bds_section_id ? $bds_section_id : $database->db_insert_id());

            // Process price range
            $bds_section_price_text = PGRequest::getVar('bds_section_price_text', array(), 'post', 'array');
            $bds_section_price_value_min = PGRequest::getVar('bds_section_price_value_min', array(), 'post', 'array');
            $bds_section_price_value_max = PGRequest::getVar('bds_section_price_value_max', array(), 'post', 'array');

            if ( is_array($bds_section_price_text) && count($bds_section_price_text) && !empty($bds_section_price_text) && is_array($bds_section_price_value_min) && count($bds_section_price_value_min) && !empty($bds_section_price_value_min) && is_array($bds_section_price_value_max) && count($bds_section_price_value_max) && !empty($bds_section_price_value_max) ){
                $input_prices = array();
                foreach ($bds_section_price_text as $keyPrice => $valueTextPrice ){
                    $input_prices['site_id'] = $input['bds_section_site_id'];
                    $input_prices['bds_section_id'] = $db_insert_section_id;
                    $input_prices['bds_section_price_text'] = $valueTextPrice;
                    $input_prices['bds_section_price_value_min'] = intval(str_replace(",", "", $bds_section_price_value_min[$keyPrice]));
                    $input_prices['bds_section_price_value_max'] = intval(str_replace(",", "", $bds_section_price_value_max[$keyPrice]));
                    if ( $input_prices['bds_section_price_value_min'] > $input_prices['bds_section_price_value_max'] ){
                        $max = $input_prices['bds_section_price_value_min'];
                        $min = $input_prices['bds_section_price_value_max'];
                        $input_prices['bds_section_price_value_max'] = $max;
                        $input_prices['bds_section_price_value_min'] = $min;
                    }

                    if ( is_array($input_prices) && count($input_prices) && !empty($input_prices) && $input_prices['bds_section_price_text'] && $input_prices['bds_section_price_value_min'] && $input_prices['bds_section_price_value_max'] ){
                        end($input_prices);
                        $key_end = key($input_prices);

                        $string_key_insert = "(";
                        $string_value_insert = '';
                        $string_duplicate = '';
                        foreach( $input_prices as $key => $value ){
                            $string_key_insert .= $key .(($key == $key_end) ? "": ", ");
                            $string_value_insert[] = $value;
                            $string_duplicate .= " ". $key ."='".$value."'" . (($key == $key_end) ? "": ",");
                        }
                        $string_key_insert .= ')';

                        $query = "INSERT INTO ".TBL_BDS_SECTION_PRICE.$string_key_insert."
                        VALUES ('".implode("','", $string_value_insert)."')
                        ON DUPLICATE KEY UPDATE ".$string_duplicate;
                        $database->db_query($query);
                    }
                }
            }

            // Keywords
            if ( is_array($aryKeyword) && count($aryKeyword) && !empty($aryKeyword) ){
                keyword_integrated($aryKeyword, $db_insert_section_id, 'bds_section');
            }
        } else if ($action == 'project') {
            $bds_project_id = PGRequest::GetInt('bds_project_id', 0, 'POST');

            $bds_project_types          = PGRequest::getVar('bds_project_types', array(), 'post', 'array');
            $bds_project_number_blocks  = PGRequest::getVar('bds_project_number_blocks', array(), 'post', 'array');

            $input['bds_project_id'] = PGRequest::GetInt('bds_project_id', 0, 'POST');

            $input['bds_project_name'] = $database->getEscaped(PGRequest::getString('bds_project_name', '', 'POST'));
            $name_alias = convertKhongdau($input['bds_project_name']);
            $input['bds_project_alias'] = generateSlug($name_alias, strlen($name_alias));

            // Add Meta title, meta keyword, meta description
            $input['bds_project_metatitle']         = $database->getEscaped(PGRequest::getString('bds_project_metatitle', '', 'POST'));
            $input['bds_project_metakey']	        = $database->getEscaped(PGRequest::getString('bds_project_metakey', '', 'POST'));
            $input['bds_project_metadesc']	        = $database->getEscaped(PGRequest::getString('bds_project_metadesc', '', 'POST'));

            if ( !$input['bds_project_metakey'] && $aryKeyword && is_array($aryKeyword) && count($aryKeyword) && !empty($aryKeyword) ){
                $input['bds_project_metakey']		= get_keyword_integrated($aryKeyword);
            }
            if ( !$input['bds_project_metakey'] && $setting['setting_auto_keyword_born'] ){
                $input['bds_project_metakey']	    = $logAdmin->auto_keyword_born($input['bds_project_name']);
            }

            $input['bds_project_investor']          = $database->getEscaped(PGRequest::getString('bds_project_investor', '', 'POST'));
            $input['bds_project_architect']         = PGRequest::getInt('bds_project_architect', 0, 'POST');
            $input['bds_project_landscape_designer']= PGRequest::getInt('bds_project_landscape_designer', 0, 'POST');
            $input['bds_project_interior_designer'] = PGRequest::getInt('bds_project_interior_designer', 0, 'POST');
            $input['bds_project_builder']           = PGRequest::getInt('bds_project_builder', 0, 'POST');
            $input['bds_project_managed_by']        = PGRequest::getInt('bds_project_managed_by', 0, 'POST');
            $input['bds_project_commencement_year'] = PGRequest::getInt('bds_project_commencement_year', 0, 'POST');
            $input['bds_project_completion_year']   = PGRequest::getInt('bds_project_completion_year', 0, 'POST');

            $input['bds_project_date_hand_over']    = $database->getEscaped(PGRequest::getString('bds_project_date_hand_over', '', 'POST'));
            if ( is_array($bds_project_types) && count($bds_project_types) && !empty($bds_project_types) ){
                $input['bds_project_types'] = implode("|", $bds_project_types);
            }
            if ( is_array($bds_project_number_blocks) && count($bds_project_number_blocks) && !empty($bds_project_number_blocks) ){
                $input['bds_project_number_blocks'] = json_encode($bds_project_number_blocks);
            }
            $input['bds_project_floor_sizes']       = 'test';
            $input['bds_project_starting_price']    = 'test';

            $input['bds_project_investment']        = $database->getEscaped(PGRequest::getString('bds_project_investment', '', 'POST'));
            $input['bds_project_parkland_wetland']  = $database->getEscaped(PGRequest::getString('bds_project_parkland_wetland', '', 'POST'));
            $input['bds_project_density']           = $database->getEscaped(PGRequest::getString('bds_project_density', '', 'POST'));
            $input['bds_project_associated_bank']   = $database->getEscaped(PGRequest::getString('bds_project_associated_bank', '', 'POST'));
            $input['bds_project_handedover']        = PGRequest::getInt('bds_project_handedover', 0, 'POST');
            $input['bds_project_date_hand_over']    = PGRequest::getString('bds_project_date_hand_over', '', 'POST');
            if (  $input['bds_project_date_hand_over'] ){
                // Xử lý update neu qua time
            }

            $input['bds_project_address']           = $database->getEscaped(PGRequest::getString('bds_project_address', '', 'POST'));
            $input['bds_project_suburb_id']         = PGRequest::GetInt('bds_project_suburb_id', 0, 'POST');
            $input['bds_project_district_id']       = PGRequest::GetInt('bds_project_district_id', 0, 'POST');
            $input['bds_project_city_id']           = PGRequest::GetInt('bds_project_city_id', 0, 'POST');

            $input['bds_project_total_area']        = $database->getEscaped(PGRequest::getString('bds_project_total_area', '', 'POST'));
            $input['bds_project_construction_area'] = $database->getEscaped(PGRequest::getString('bds_project_construction_area', '', 'POST'));
            $input['bds_project_scale']             = $database->getEscaped(PGRequest::getString('bds_project_scale', '', 'POST'));
            $input['bds_projectunit_area_scale_unit'] = $database->getEscaped(PGRequest::getString('bds_projectunit_area_scale_unit', '', 'POST'));

            $input['bds_project_info']              = $filter->_decode(PGRequest::getVar('bds_project_info', '', 'post', 'string', PGREQUEST_ALLOWRAW));
            $input['bds_project_location_lat']      = PGRequest::getVar('bds_project_location_lat', '', 'POST');
            $input['bds_project_location_long']     = PGRequest::getVar('bds_project_location_long', '', 'POST');
            $input['bds_project_location_corner']   = PGRequest::GetInt('bds_project_location_corner', 0, 'POST');

            $input['bds_project_location_parkside'] = PGRequest::GetInt('bds_project_location_parkside', 0, 'POST');
            $bds_project_location_parkside_name     = PGRequest::getVar('bds_project_location_parkside_name', array(), 'post', 'array');
            if ( is_array($bds_project_location_parkside_name) && count($bds_project_location_parkside_name) && !empty($bds_project_location_parkside_name) ){
                $input['bds_project_location_parkside_name'] = json_encode($bds_project_location_parkside_name);
            }

            $input['bds_project_location_lakeside'] = PGRequest::GetInt('bds_project_location_lakeside', 0, 'POST');
            $bds_project_location_lakeside_name     = PGRequest::getVar('bds_project_location_lakeside_name', array(), 'post', 'array');
            if ( is_array($bds_project_location_lakeside_name) && count($bds_project_location_lakeside_name) && !empty($bds_project_location_lakeside_name) ){
                $input['bds_project_location_lakeside_name'] = json_encode($bds_project_location_lakeside_name);
            }

            $input['bds_project_location_riverside']= PGRequest::GetInt('bds_project_location_riverside', 0, 'POST');
            $bds_project_location_riverside_name    = PGRequest::getVar('bds_project_location_riverside_name', array(), 'post', 'array');
            if ( is_array($bds_project_location_riverside_name) && count($bds_project_location_riverside_name) && !empty($bds_project_location_riverside_name) ){
                $input['bds_project_location_riverside_name'] = json_encode($bds_project_location_riverside_name);
            }

            $bds_project_close_to_school            = PGRequest::getVar('bds_project_close_to_school', array(), 'post', 'array');
            if ( is_array($bds_project_close_to_school) && count($bds_project_close_to_school) && !empty($bds_project_close_to_school) ){
                $input['bds_project_close_to_school'] = json_encode($bds_project_close_to_school);
            }

            $input['bds_project_close_to_hospital'] = PGRequest::GetInt('bds_project_close_to_hospital', 0, 'POST');
            $bds_project_close_to_hospital_name     = PGRequest::getVar('bds_project_close_to_hospital_name', array(), 'post', 'array');
            if ( is_array($bds_project_close_to_hospital_name) && count($bds_project_close_to_hospital_name) && !empty($bds_project_close_to_hospital_name) ){
                $input['bds_project_close_to_hospital_name'] = json_encode($bds_project_close_to_hospital_name);
            }

            $input['bds_project_close_to_shopping_center'] = PGRequest::GetInt('bds_project_close_to_shopping_center', 0, 'POST');
            $bds_project_close_to_shopping_center_name = PGRequest::getVar('bds_project_close_to_shopping_center_name', array(), 'post', 'array');
            if ( is_array($bds_project_close_to_shopping_center_name) && count($bds_project_close_to_shopping_center_name) && !empty($bds_project_close_to_shopping_center_name) ){
                $input['bds_project_close_to_shopping_center_name'] = json_encode($bds_project_close_to_shopping_center_name);
            }

            $input['bds_project_close_to_ecreation_center'] = PGRequest::GetInt('bds_project_close_to_ecreation_center', 0, 'POST');
            $bds_project_close_to_ecreation_center_name = PGRequest::getVar('bds_project_close_to_ecreation_center_name', array(), 'post', 'array');
            if ( is_array($bds_project_close_to_ecreation_center_name) && count($bds_project_close_to_ecreation_center_name) && !empty($bds_project_close_to_ecreation_center_name) ){
                $input['bds_project_close_to_ecreation_center_name'] = json_encode($bds_project_close_to_ecreation_center_name);
            }

            $input['bds_project_close_to_sports_center'] = PGRequest::GetInt('bds_project_close_to_sports_center', 0, 'POST');
            $bds_project_close_to_sports_center_name = PGRequest::getVar('bds_project_close_to_sports_center_name', array(), 'post', 'array');
            if ( is_array($bds_project_close_to_sports_center_name) && count($bds_project_close_to_sports_center_name) && !empty($bds_project_close_to_sports_center_name) ){
                $input['bds_project_close_to_sports_center_name'] = json_encode($bds_project_close_to_sports_center_name);
            }


            $bds_project_option = PGRequest::getVar('bds_project_option', array(), 'post', 'array');
            $bds_project_utilities = PGRequest::getVar('bds_project_utilities', array(), 'post', 'array');
            $bds_project_features = PGRequest::getVar('bds_project_features', array(), 'post', 'array');
            $bds_project_prices = PGRequest::getVar('bds_project_prices', array(), 'post', 'array');
            $bds_project_fees   = PGRequest::getVar('bds_project_fees', array(), 'post', 'array');

            if ( is_array($bds_project_option) && count($bds_project_option) && !empty($bds_project_option) ){
                $input['bds_project_option'] = json_encode($bds_project_option);
            }
            if ( is_array($bds_project_utilities) && count($bds_project_utilities) && !empty($bds_project_utilities) ){
                $input['bds_project_utilities'] = json_encode($bds_project_utilities);
            }
            if ( is_array($bds_project_features) && count($bds_project_features) && !empty($bds_project_features) ){
                $input['bds_project_features'] = json_encode($bds_project_features);
            }
            if ( is_array($bds_project_prices) && count($bds_project_prices) && !empty($bds_project_prices) ){
                $input['bds_project_prices'] = json_encode($bds_project_prices);
            }
            if ( is_array($bds_project_fees) && count($bds_project_fees) && !empty($bds_project_fees) ){
                $input['bds_project_fees'] = json_encode($bds_project_fees);
            }

            $input['bds_project_hot'] = PGRequest::GetInt('bds_project_hot', 0, 'POST');
            $input['bds_project_new'] = PGRequest::GetInt('bds_project_new', 0, 'POST');
            $input['bds_project_is_open_for_sale'] = PGRequest::GetInt('bds_project_is_open_for_sale', 0, 'POST');
            $input['bds_project_about_to_for_sale'] = PGRequest::GetInt('bds_project_about_to_for_sale', 0, 'POST');
            $input['bds_project_being_traded'] = PGRequest::GetInt('bds_project_being_traded', 0, 'POST');
            $input['bds_project_high_level'] = PGRequest::GetInt('bds_project_high_level', 0, 'POST');
            if (!$bds_project_id) {
                $input['bds_project_created'] = $datetime->timestampToDateTime();
                $input['bds_project_site_id'] = PGRequest::GetInt('bds_project_site_id', 0, 'POST');
                if (is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'])
                    $input['bds_project_site_id'] = $admin->admin_site_default['site_id'];
            }else
                $input['bds_project_lastupdate'] = $datetime->timestampToDateTime();

            $input['bds_project_ordering']  = PGRequest::GetInt('bds_project_ordering', 0, 'POST');
            $input['bds_project_status']    = PGRequest::GetInt('bds_project_status', 0, 'POST');

            // Ảnh đại diện
            if (isset($_FILES['image']) && !empty($_FILES['image']['name']) && count($_FILES['image']['name'])) {
                if ($bds_project_id) {
                    $_s_query = "SELECT bds_project_image FROM " . TBL_BDS_PROJECT . " WHERE bds_project_id=" . $bds_project_id;
                    $_s_result = $database->db_query($_s_query);
                    if ($_s_row = $database->db_fetch_assoc($_s_result)) {
                        $item->data['image'] = json_decode($_s_row['bds_project_image']);
                        if (is_object($item->data['image'])) {
                            $item->data['image'] = (array)$item->data['image'];
                            $item->data['image'] = array_values($item->data['image']);
                        }
                    }
                }

                $params_image = array();
                for ($i = 0; $i < count($_FILES['image']['name']); $i++) {
                    if (isset($_FILES['image']) && count($_FILES['image']['error']) == 1 && $_FILES['image']['error'][$i] > 0) {
                        //file not selected
                        if (isset($item) && is_object($item) && is_array($item->data['image']) && isset($item->data['image'][$i]) && $item->data['image'][$i]) {
                            $params_image[$i] = $item->data['image'][$i];
                        }
                    } else if (isset($_FILES["image"]["name"][$i]) && $_FILES["image"]["name"][$i]) { //this is just to check if isset($_FILE). Not required.
                        //file selected
                        if (isset($item) && is_object($item) && is_array($item->data['image']) && isset($item->data['image'][$i]) && $item->data['image'][$i]) {
                            if ($item->data["image"][$i] != "")
                                removeImage($item->data["image"][$i], str_replace('admin_', '', $page));
                        }
                        $params_image[$i] = uploadImage($_FILES["image"]["name"][$i], $_FILES["image"]["tmp_name"][$i], str_replace('admin_', '', $page), $input['bds_project_alias'] . '-' . $i);
                    } else {
                        if (isset($item) && is_object($item) && is_array($item->data['image']) && isset($item->data['image'][$i]) && $item->data['image'][$i]) {
                            $params_image[$i] = $item->data['image'][$i];
                        }
                    }
                }
                $params_image = array_unique(array_filter($params_image));
                if (!empty($params_image) && count($params_image)) {
                    $input['bds_project_image'] = json_encode($params_image);
                }
            }

            if ($bds_project_id) {
                $_c_field = 'bds_project_id';
                if ($database->update($table_name, $input, "$_c_field=" . $bds_project_id)) {
                    $is_error = false;
                    $message = 'Cập nhật ' . $text_title . ' thành công!';
                } else {
                    $is_error = true;
                    $message = 'Lỗi không chỉnh sửa được vì lý do: ' . $database->db_error();
                }
            } else {
                if ($database->insert($table_name, $input)) {
                    $is_error = false;
                    $message = 'Thêm mới ' . $text_title . ' thành công!';
                } else {
                    $is_error = true;
                    $message = 'Lỗi không thêm được vì lý do: ' . $database->db_error();
                }
            }

            // Keywords
            if ( is_array($aryKeyword) && count($aryKeyword) && !empty($aryKeyword) ){
                keyword_integrated($aryKeyword, ($bds_project_id ? $bds_project_id : $database->db_insert_id()), 'bds_project');
            }
        } else if ($action == 'bds') {
            $bds_id = PGRequest::GetInt('bds_id', 0, 'POST');
            $input['bds_project_id'] = PGRequest::GetInt('bds_project_id', 0, 'POST');
            $input['bds_section'] = PGRequest::GetInt('bds_section', 0, 'POST');
            $input['bds_category_id'] = PGRequest::GetInt('bds_category_id', 0, 'POST');
            $input['bds_number_bedroom'] = PGRequest::GetInt('bds_number_bedroom', 0, 'POST');
            $input['bds_number_bathroom'] = PGRequest::GetInt('bds_number_bathroom', 0, 'POST');
            $input['bds_price_range'] = intval(str_replace(",", "", PGRequest::getVar('bds_price_range', '', 'POST')));
            $input['bds_area'] = intval(str_replace(",", "", PGRequest::getVar('bds_area', '', 'POST')));
            $input['bds_view'] = $database->getEscaped(PGRequest::getString('bds_view', '', 'POST'));

            $input['bds_title'] = $database->getEscaped(PGRequest::getString('bds_title', '', 'POST'));
            $name_alias = convertKhongdau($input['bds_title']);
            $input['bds_alias'] = generateSlug($name_alias, strlen($name_alias));
            $input['bds_address'] = $database->getEscaped(PGRequest::getString('bds_address', '', 'POST'));
            $input['bds_info'] = $filter->_decode(PGRequest::getVar('bds_info', '', 'post', 'string', PGREQUEST_ALLOWRAW));
            $input['bds_city_id'] = PGRequest::GetInt('bds_city_id', 0, 'POST');
            $input['bds_district_id'] = PGRequest::GetInt('bds_district_id', 0, 'POST');
            $input['bds_location_lat'] = PGRequest::getVar('bds_location_lat', '', 'POST');
            $input['bds_location_long'] = PGRequest::getVar('bds_location_long', '', 'POST');

            $input['bds_address_show']   = PGRequest::GetInt('bds_address_show', 0, 'POST');
            $input['bds_district_show']  = PGRequest::GetInt('bds_district_show', 0, 'POST');
            $input['bds_city_show']      = PGRequest::GetInt('bds_city_show', 0, 'POST');

            $input['bds_user_id'] = PGRequest::GetInt('bds_user_id', 0, 'POST');
            $bds_user_date_created = PGRequest::getVar('bds_user_date_created', array(), 'post', 'array');
            $bds_user_date_expired = PGRequest::getVar('bds_user_date_expired', array(), 'post', 'array');
            $input['bds_user_date_created'] = $datetime->convertDate($bds_user_date_created[0], "dd/mm/yyyy") . ' ' . $bds_user_date_created[1];
            $input['bds_user_date_expired'] = $datetime->convertDate($bds_user_date_expired[0], "dd/mm/yyyy") . ' ' . $bds_user_date_created[1];

            if (!$bds_id) {
                $input['bds_code'] = generate_code(array('name' => TBL_BDS, 'key' => 'bds_code'));
                $input['bds_created'] = $datetime->timestampToDateTime();
                $input['bds_site_id'] = PGRequest::GetInt('bds_site_id', 0, 'POST');
                if (is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'])
                    $input['bds_site_id'] = $admin->admin_site_default['site_id'];
            } else
                $input['bds_lastupdate'] = $datetime->timestampToDateTime();

            $input['bds_corner'] = PGRequest::GetInt('bds_corner', 0, 'POST');

            $input['bds_vip'] = PGRequest::GetInt('bds_vip', 0, 'POST');
            $input['bds_special'] = PGRequest::GetInt('bds_special', 0, 'POST');
            $input['bds_hot'] = PGRequest::GetInt('bds_hot', 0, 'POST');
            $input['bds_care'] = PGRequest::GetInt('bds_care', 0, 'POST');

            $input['bds_option'] = PGRequest::getVar('bds_option', array(), 'post', 'array');
            $input['bds_utilities'] = PGRequest::getVar('bds_utilities', array(), 'post', 'array');

            $input['bds_option'] = json_encode($input['bds_option']);
            $input['bds_utilities'] = json_encode($input['bds_utilities']);

            $inpuit['bds_furniture'] = PGRequest::getVar('bds_furniture', array(), 'post', 'array');
            $arr = array();
            $key = false;
            foreach ($inpuit['bds_furniture'] as $value) {
                if (intval($value) == 0) {
                    $key = $value;
                    $arr[$key] = array();
                    continue;
                }
                if (intval($value) > 0) {
                    array_push($arr[$key], $value);
                }
            }
            //print_r($arr); die;
            $input['bds_furniture'] = json_encode($arr);

            $input['bds_cozy'] = PGRequest::getVar('bds_cozy', array(), 'post', 'array');
            $input['bds_cozy'] = json_encode($input['bds_cozy']);

            $input['bds_ordering'] = PGRequest::GetInt('bds_ordering', 0, 'POST');
            $input['bds_status'] = PGRequest::GetInt('bds_status', 0, 'POST');

            // Add Meta title, meta keyword, meta description
            $input['bds_metatitle']         = $database->getEscaped(PGRequest::getString('bds_metatitle', '', 'POST'));
            $input['bds_metakey']	        = $database->getEscaped(PGRequest::getString('bds_metakey', '', 'POST'));

            if ( !$input['bds_metakey'] && $aryKeyword && is_array($aryKeyword) && count($aryKeyword) && !empty($aryKeyword) ){
                $input['bds_metakey']		= get_keyword_integrated($aryKeyword);
            }
            if ( !$input['bds_metakey'] && $setting['setting_auto_keyword_born'] ){
                $input['bds_metakey']	    = $logAdmin->auto_keyword_born($input['bds_title']);
            }
            $input['bds_metadesc']	        = $database->getEscaped(PGRequest::getString('bds_metadesc', '', 'POST'));

            // Ảnh đại diện
            if (isset($_FILES['image']) && !empty($_FILES['image']['name']) && count($_FILES['image']['name'])) {
                if ($bds_id) {
                    $_s_query = "SELECT bds_image FROM " . TBL_BDS . " WHERE bds_id=" . $bds_id;
                    $_s_result = $database->db_query($_s_query);
                    if ($_s_row = $database->db_fetch_assoc($_s_result)) {
                        $item->data['image'] = json_decode($_s_row['bds_image']);
                        if (is_object($item->data['image'])) {
                            $item->data['image'] = (array)$item->data['image'];
                            $item->data['image'] = array_values($item->data['image']);
                        }
                    }
                }

                $params_image = array();
                for ($i = 0; $i < count($_FILES['image']['name']); $i++) {
                    if (isset($_FILES['image']) && count($_FILES['image']['error']) == 1 && $_FILES['image']['error'][$i] > 0) {
                        //file not selected
                        if (isset($item) && is_object($item) && is_array($item->data['image']) && isset($item->data['image'][$i]) && $item->data['image'][$i]) {
                            $params_image[$i] = $item->data['image'][$i];
                        }
                    } else if (isset($_FILES["image"]["name"][$i]) && $_FILES["image"]["name"][$i]) { //this is just to check if isset($_FILE). Not required.
                        //file selected
                        if (isset($item) && is_object($item) && is_array($item->data['image']) && isset($item->data['image'][$i]) && $item->data['image'][$i]) {
                            if ($item->data["image"][$i] != "")
                                removeImage($item->data["image"][$i], str_replace('admin_', '', $page));
                        }
                        $params_image[$i] = uploadImage($_FILES["image"]["name"][$i], $_FILES["image"]["tmp_name"][$i], str_replace('admin_', '', $page), $input['bds_alias'] . '-' . $i);
                    } else {
                        if (isset($item) && is_object($item) && is_array($item->data['image']) && isset($item->data['image'][$i]) && $item->data['image'][$i]) {
                            $params_image[$i] = $item->data['image'][$i];
                        }
                    }
                }
                $params_image = array_unique(array_filter($params_image));
                if (!empty($params_image) && count($params_image)) {
                    $input['bds_image'] = json_encode($params_image);
                }
            }

            if ($bds_id) {
                $_c_field = 'bds_id';
                if ($database->update($table_name, $input, "$_c_field=" . $bds_id)) {
                    $is_error = false;
                    $message = 'Cập nhật ' . $text_title . ' thành công!';
                } else {
                    $is_error = true;
                    $message = 'Lỗi không chỉnh sửa được vì lý do: ' . $database->db_error();
                }
            } else {
                if ($database->insert($table_name, $input)) {
                    $is_error = false;
                    $message = 'Thêm mới ' . $text_title . ' thành công!';
                } else {
                    $is_error = true;
                    $message = 'Lỗi không thêm được vì lý do: ' . $database->db_error();
                }
            }

            // Keywords
            if ( is_array($aryKeyword) && count($aryKeyword) && !empty($aryKeyword) ){
                keyword_integrated($aryKeyword, ($bds_id ? $bds_id : $database->db_insert_id()), 'bds');
            }
        } else if ($action == 'construction') {
            $construction_design_id = PGRequest::GetInt('construction_design_id', 0, 'POST');
            $input['construction_design_category_id'] = PGRequest::GetInt('construction_design_category_id', 0, 'POST');

            $input['construction_design_name'] = $database->getEscaped(PGRequest::getString('construction_design_name', '', 'POST'));
            $name_alias = convertKhongdau($input['construction_design_name']);
            $input['construction_design_alias'] = generateSlug($name_alias, strlen($name_alias));

            $input['construction_design_style'] = $database->getEscaped(PGRequest::getString('construction_design_style', '', 'POST'));
            $input['construction_design_number_floors'] = PGRequest::getInt('construction_design_number_floors', 0, 'POST');
            $input['construction_design_investor'] = $database->getEscaped(PGRequest::getString('construction_design_investor', '', 'POST'));
            $input['construction_design_facade'] = $database->getEscaped(PGRequest::getString('construction_design_facade', '', 'POST'));
            $input['construction_design_depth'] = $database->getEscaped(PGRequest::getString('construction_design_depth', '', 'POST'));
            $input['construction_design_architect'] = $database->getEscaped(PGRequest::getString('construction_design_architect', '', 'POST'));
            $input['construction_design_years_of_construction'] = $database->getEscaped(PGRequest::getString('construction_design_years_of_construction', '', 'POST'));

            $input['construction_design_address'] = $database->getEscaped(PGRequest::getString('construction_design_address', '', 'POST'));
            $input['construction_design_info'] = $filter->_decode(PGRequest::getVar('construction_design_info', '', 'post', 'string', PGREQUEST_ALLOWRAW));
            $input['construction_design_short_desc'] = $filter->_decode(PGRequest::getVar('construction_design_short_desc', '', 'post', 'string', PGREQUEST_ALLOWRAW));
            $input['construction_design_city_id'] = PGRequest::GetInt('construction_design_city_id', 0, 'POST');
            $input['construction_design_district_id'] = PGRequest::GetInt('construction_design_district_id', 0, 'POST');

            $input['construction_design_code'] = $database->getEscaped(PGRequest::getString('construction_design_code', '', 'POST'));
            if (!$input['construction_design_code']) {
                $input['construction_design_code'] = generate_code(array('name' => TBL_CONSTRUCTION, 'key' => 'construction_design_code'));
            }
            if (!$construction_design_id) {
                $input['construction_design_created'] = $datetime->timestampToDateTime();
                $input['construction_design_created_by'] = $admin->admin_info['admin_id'];
                $input['construction_design_site_id'] = PGRequest::GetInt('construction_design_site_id', 0, 'POST');
                if (is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'])
                    $input['construction_design_site_id'] = $admin->admin_site_default['site_id'];
            } else{
                $input['construction_design_lastupdate'] = $datetime->timestampToDateTime();
                $input['construction_design_modified_by'] = $admin->admin_info['admin_id'];
            }

            $input['construction_design_ordering'] = PGRequest::GetInt('construction_design_ordering', 0, 'POST');
            $input['construction_design_hot'] = PGRequest::GetInt('construction_design_hot', 0, 'POST');
            $input['construction_design_status'] = PGRequest::GetInt('construction_design_status', 0, 'POST');

            $construction_design_desc_number_floors = PGRequest::getVar('construction_design_desc_number_floors', array(), 'post', 'array');
            $input['construction_design_desc_number_floors'] = json_encode($construction_design_desc_number_floors);

            // Add Meta title, meta keyword, meta description
            $input['construction_design_metatitle']         = $database->getEscaped(PGRequest::getString('construction_design_metatitle', '', 'POST'));
            $input['construction_design_metakey']	        = $database->getEscaped(PGRequest::getString('construction_design_metakey', '', 'POST'));

            if ( !$input['construction_design_metakey'] && $aryKeyword && is_array($aryKeyword) && count($aryKeyword) && !empty($aryKeyword) ){
                $input['construction_design_metakey']		= get_keyword_integrated($aryKeyword);
            }
            if ( !$input['construction_design_metakey'] && $setting['setting_auto_keyword_born'] ){
                $input['construction_design_metakey']	    = $logAdmin->auto_keyword_born($input['construction_design_name']);
            }
            $input['construction_design_metadesc']	        = $database->getEscaped(PGRequest::getString('construction_design_metadesc', '', 'POST'));

            // Ảnh đại diện
            if (isset($_FILES['image']) && !empty($_FILES['image']['name']) && count($_FILES['image']['name'])) {
                if ($construction_design_id) {
                    $_s_query = "SELECT construction_design_image FROM " . TBL_CONSTRUCTION . " WHERE construction_design_id=" . $construction_design_id;
                    $_s_result = $database->db_query($_s_query);
                    if ($_s_row = $database->db_fetch_assoc($_s_result)) {
                        $item->data['image'] = json_decode($_s_row['construction_design_image']);
                        if (is_object($item->data['image'])) {
                            $item->data['image'] = (array)$item->data['image'];
                            $item->data['image'] = array_values($item->data['image']);
                        }
                    }
                }

                $params_image = array();
                for ($i = 0; $i < count($_FILES['image']['name']); $i++) {
                    if (isset($_FILES['image']) && count($_FILES['image']['error']) == 1 && $_FILES['image']['error'][$i] > 0) {
                        //file not selected
                        if (isset($item) && is_object($item) && is_array($item->data['image']) && isset($item->data['image'][$i]) && $item->data['image'][$i]) {
                            $params_image[$i] = $item->data['image'][$i];
                        }
                    } else if (isset($_FILES["image"]["name"][$i]) && $_FILES["image"]["name"][$i]) { //this is just to check if isset($_FILE). Not required.
                        //file selected
                        if (isset($item) && is_object($item) && is_array($item->data['image']) && isset($item->data['image'][$i]) && $item->data['image'][$i]) {
                            if ($item->data["image"][$i] != "")
                                removeImage($item->data["image"][$i], str_replace('admin_', '', $page));
                        }
                        $params_image[$i] = uploadImage($_FILES["image"]["name"][$i], $_FILES["image"]["tmp_name"][$i], str_replace('admin_', '', $page), $input['construction_design_alias'] . '-' . $i);
                    } else {
                        if (isset($item) && is_object($item) && is_array($item->data['image']) && isset($item->data['image'][$i]) && $item->data['image'][$i]) {
                            $params_image[$i] = $item->data['image'][$i];
                        }
                    }
                }
                $params_image = array_unique(array_filter($params_image));
                if (!empty($params_image) && count($params_image)) {
                    $input['construction_design_image'] = json_encode($params_image);
                }
            }

            if ($construction_design_id) {
                $_c_field = 'construction_design_id';
                if ($database->update($table_name, $input, "$_c_field=" . $construction_design_id)) {
                    $is_error = false;
                    $message = 'Cập nhật ' . $text_title . ' thành công!';
                } else {
                    $is_error = true;
                    $message = 'Lỗi không chỉnh sửa được vì lý do: ' . $database->db_error();
                }
            } else {
                if ($database->insert($table_name, $input)) {
                    $is_error = false;
                    $message = 'Thêm mới ' . $text_title . ' thành công!';
                } else {
                    $is_error = true;
                    $message = 'Lỗi không thêm được vì lý do: ' . $database->db_error();
                }
            }

            // Keywords
            if ( is_array($aryKeyword) && count($aryKeyword) && !empty($aryKeyword) ){
                keyword_integrated($aryKeyword, ($construction_design_id ? $construction_design_id : $database->db_insert_id()), 'construction_design');
            }
        } else if ($action == 'company') {
            $company_id = PGRequest::GetInt('company_id', 0, 'POST');
            $input['company_name'] = $database->getEscaped(PGRequest::getString('company_name', '', 'POST'));

            $name_alias = convertKhongdau($input['company_name']);
            $input['company_alias'] = generateSlug($name_alias, strlen($name_alias));

            $input['company_city_id'] = PGRequest::GetInt('company_city_id', 0, 'POST');
            $input['company_district_id'] = PGRequest::GetInt('company_district_id', 0, 'POST');
            $input['company_address'] = $database->getEscaped(PGRequest::getString('company_address', '', 'POST'));
            $input['company_telephone'] = $database->getEscaped(PGRequest::getString('company_telephone', '', 'POST'));
            $input['company_website'] = $database->getEscaped(PGRequest::getString('company_website', '', 'POST'));
            $input['company_career_name'] = $database->getEscaped(PGRequest::getString('company_career_name', '', 'POST'));

            // Ảnh đại diện
            if (isset($_FILES['image']) && !empty($_FILES['image']['name']) && count($_FILES['image']['name'])) {
                if ($company_id) {
                    $_s_query = "SELECT company_logo FROM " . TBL_BDS_COMPANY . " WHERE company_id=" . $company_id;
                    $_s_result = $database->db_query($_s_query);
                    if ($_s_row = $database->db_fetch_assoc($_s_result)) {
                        $item->data['image'] = $_s_row['company_logo'];
                    }
                }
                //file selected
                if ($item->data["image"] != "")
                    removeImage($item->data["image"], 'logos');

                $input['company_logo'] = uploadImage($_FILES["image"]["name"], $_FILES["image"]["tmp_name"], 'logos', $input['company_alias']);
            }

            if (!$company_id) {
                $input['company_career_code'] = generate_code(array('name' => TBL_BDS_COMPANY, 'key' => 'company_career_code'));
                $input['company_created'] = $datetime->timestampToDateTime();
                if (is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'])
                    $input['company_site_id'] = $admin->admin_site_default['site_id'];
            } else
                $input['company_lastupdate'] = $datetime->timestampToDateTime();

            $input['company_ordering'] = PGRequest::GetInt('company_ordering', 0, 'POST');
            $input['company_status'] = PGRequest::GetInt('company_status', 0, 'POST');

            if ($company_id) {
                $_c_field = 'company_id';
                if ($database->update($table_name, $input, "$_c_field=" . $company_id)) {
                    $is_error = false;
                    $message = 'Cập nhật ' . $text_title . ' thành công!';
                } else {
                    $is_error = true;
                    $message = 'Lỗi không chỉnh sửa được vì lý do: ' . $database->db_error();
                }
            } else {
                if ($database->insert($table_name, $input)) {
                    $is_error = false;
                    $message = 'Thêm mới ' . $text_title . ' thành công!';
                } else {
                    $is_error = true;
                    $message = 'Lỗi không thêm được vì lý do: ' . $database->db_error();
                }
            }
        }

        if ($is_error)
            PGError::set_error($message);
        else
            PGError::set_message($message);

        cheader('admin_bds.php?action=' . $action);

        break;

    case 'publish':
    case 'unpublish':
        $status = ($task == 'publish' ? 1 : 0);
        $cid = PGRequest::getVar('cid', array(), 'post', 'array');
        if (count($cid) < 1) {
            $action = $published == 1 ? 'hiển thị' : 'Ẩn đi';
            echo "<script> alert('Chọn một $text_title để $action'); window.history.go(-1);</script>\n";
            exit;
        }

        mosArrayToInts($cid);
        $total = count($cid);

        if ($action == 'section') {
            $cids = 'bds_section_id=' . implode(' OR bds_section_id=', $cid);
            $_u_field = 'bds_section_status';
        } else if ($action == 'bds') {
            $cids = 'bds_id=' . implode(' OR bds_id=', $cid);
            $_u_field = 'bds_status';
        } else if ($action == 'project') {
            $cids = 'bds_project_id=' . implode(' OR bds_project_id=', $cid);
            $_u_field = 'bds_project_status';
        } else if ($action == 'construction') {
            $cids = 'construction_design_id=' . implode(' OR construction_design_id=', $cid);
            $_u_field = 'construction_design_status';
        } else if ($action == 'company') {
            $cids = 'company_id=' . implode(' OR company_id=', $cid);
            $_u_field = 'company_status';
        }

        $database->db_query("UPDATE " . $table_name . " SET " . $_u_field . "=" . (int)$status . " WHERE ( $cids )");

        switch ($status) {
            case 1:
                $message = $total . ' ' . $text_title . ' đã hiển thị thành công!';
                break;

            case 0:
            default:
                $message = $total . ' ' . $text_title . ' đã ẩn đi thành công!';
                break;
        }
        PGError::set_message($message);
        cheader('admin_bds.php?action=' . $action);
        break;

    case 'remove':
        $cid = PGRequest::getVar('cid', array(), 'post', 'array');
        if (count($cid)) {
            $total = count($cid);
            mosArrayToInts($cid);

            if ($action == 'section') {
                $cids = 'bds_section_id=' . implode(' OR bds_section_id=', $cid);
            } else if ($action == 'bds') {
                $field = 'bds_image';
                $cids = 'bds_id=' . implode(' OR bds_id=', $cid);
            } else if ($action == 'project') {
                $field = 'bds_project_image';
                $cids = 'bds_project_id=' . implode(' OR bds_project_id=', $cid);
            } else if ($action == 'construction') {
                $field = 'construction_design_image';
                $cids = 'construction_design_id=' . implode(' OR construction_design_id=', $cid);
            } else if ($action == 'company') {
                $field = 'company_logo';
                $cids = 'company_id=' . implode(' OR company_id=', $cid);
            }

            if ($action == 'bds' || $action == 'project' || $action == 'construction') {
                // Remove images
                $_query = "SELECT " . $field . " FROM " . $table_name . " WHERE ( $cids )";
                $_results = $database->db_query($_query);
                while ($_row = $database->db_fetch_assoc($_results)) {
                    $item->data['image'] = json_decode($_row[$field]);
                    if (is_object($item->data['image'])) {
                        $item->data['image'] = (array)$item->data['image'];
                        $item->data['image'] = array_values($item->data['image']);
                    }

                    if (isset($item) && is_array($item->data['image']) && count($item->data['image'])) {
                        for ($i = 0; $i < count($item->data['image']); $i++) {
                            if ($item->data["image"][$i] != "")
                                removeImage($item->data["image"][$i], str_replace('admin_', '', $page));
                        }
                    }
                }
            } else if ($action == 'company') {
                // Remove logo
                $_query = "SELECT " . $field . " FROM " . $table_name . " WHERE ( $cids )";
                $_results = $database->db_query($_query);
                while ($_row = $database->db_fetch_assoc($_results)) {
                    removeImage($_row['company_logo'], 'logos');
                }
            }

            // Remove field
            $sql = "DELETE FROM " . $table_name . " WHERE ( $cids )";
            $database->db_query($sql);

            $message = 'Đã xóa ' . $total . ' ' . $text_title . ' thành công !';
            PGError::set_message($message);
            cheader('admin_bds.php?action=' . $action);
        } else {
            echo "<script> alert('Lựa chọn một '.$text_title.' để xóa !'); window.history.go(-1);</script>\n";
            exit;
        }
        break;

    case 'view':
    default:
        $search = PGRequest::getString('search', '', 'POST');
        $filter_site_id = PGRequest::getInt('filter_site_id', 0, 'POST');
        if ( $admin->admin_site_default['site_id'] ){
            $filter_site_id = $admin->admin_site_default['site_id'];
        }
        $filter_status = PGRequest::getInt('filter_status', 3, 'POST');
        $filter_catid = PGRequest::getInt('filter_catid', 0, 'POST');
        $filter_section = PGRequest::getInt('filter_section', 0, 'POST');

        $p = PGRequest::getInt('p', 1, 'POST');
        $limit = PGRequest::getInt('limit', $setting['setting_list_limit'], 'POST');

        $option = $objCategory->getOptionItems($listCatItems, 0, $filter_catid, "");

        if ($action == 'section') {
            $page_title = "Quản lý các " . $text_title;
            $key_search_text = array('s.bds_section_name');
            $as_alias = "s";
        } else if ($action == 'bds') {
            $page_title = "Quản lý các " . $text_title;
            $key_search_text = array('bds.bds_code', 'bds.bds_title');
            $as_alias = "bds";
        } else if ($action == 'project') {
            $page_title = "Quản lý " . $text_title;
            $key_search_text = 'p.bds_project_name';
            $as_alias = "p";
        } else if ($action == 'construction') {
            $page_title = "Quản lý " . $text_title;
            $key_search_text = array('d.construction_design_code', 'd.construction_design_name');
            $as_alias = "d";
        } else if ($action == 'company') {
            $page_title = "Quản lý " . $text_title;
            $key_search_text = 'com.company_name';
            $as_alias = "com";
        }

        //CONDITION
        if ($search) {
            if (is_array($key_search_text)) {
                $where[] = (count($key_search_text) ? '(' . implode(' LIKE "%' . $search . '%" OR ', $key_search_text) . ' LIKE "%' . $search . '%")' : '');
            } else
                $where[] = "{$key_search_text} LIKE'%$search%'";
        }

        if (!$filter_site_id) {
            if (is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'])
                $filter_site_id = $admin->admin_site_default['site_id'];
        }

        if ($action == 'section') {
            if ($filter_site_id) {
                $where[] = "s.bds_section_site_id=" . $filter_site_id;
            } else {
                $where[] = "s.bds_section_site_id IN (" . implode(",", array_flip($sites)) . ")";
            }

            if ($filter_status == 0) {
                $where[] = "s.bds_section_status=0";
            } else if ($filter_status == 3) {
                $where[] = "s.bds_section_status>=0";
            } else {
                $where[] = "s.bds_section_status=" . $filter_status;
            }

            // Ge fields, join, order
            $field_select = "s.*";

            $order = " ORDER BY s.bds_section_ordering ASC, s.bds_section_id DESC";
        }else if ($action == 'bds') {
            if ($filter_site_id) {
                $where[] = "bds.bds_site_id=" . $filter_site_id;
            } else {
                $where[] = "bds.bds_site_id IN (" . implode(",", array_flip($sites)) . ")";
            }

            if ($filter_status == 0) {
                $where[] = "bds.bds_status=0";
            } else if ($filter_status == 3) {
                $where[] = "bds.bds_status>=0";
            } else {
                $where[] = "bds.bds_status=" . $filter_status;
            }

            if ($filter_catid) {
                $all_under_catid = $objCategory->get_all_whole_under_id($filter_catid);
                $where[] = "bds.bds_category_id IN(" . implode(",", $all_under_catid) . ")";
            }
            if ($filter_section){
                $where[] = "bds.bds_section=".$filter_section;
            }

            // Ge fields, join, order
            $field_select = "
                            bds.bds_id,
                            bds.bds_site_id,
                            bds.bds_project_id,
                            bds.bds_section,
                            bds.bds_category_id,
                            bds.bds_city_id,
                            bds.bds_district_id,
                            bds.bds_number_bedroom,
                            bds.bds_number_bathroom,
                            bds.bds_price_range,
                            bds.bds_area,
                            bds.bds_code,
                            bds.bds_title,
                            bds.bds_user_date_created,
                            bds.bds_user_date_created,
                            bds.bds_user_date_expired,
                            bds.bds_image,
                            bds.bds_ordering,
                            bds.bds_status,
                            c.category_name,
                            p.bds_project_name,
                            tp.ten_tinh,
                            qh.ten_huyen
            ";
            $join = " LEFT JOIN " . TBL_CATEGORY . " c ON bds.bds_category_id = c.category_id";
            $join .= " LEFT JOIN " . TBL_BDS_PROJECT . " p ON bds.bds_project_id = p.bds_project_id";
            $join .= " LEFT JOIN " . TBL_TINH_THANH_PHO . " tp ON bds.bds_city_id = tp.ma_tinh";
            $join .= " LEFT JOIN " . TBL_QUAN_HUYEN . " qh ON bds.bds_district_id = qh.ma_huyen";

            $order = " ORDER BY bds.bds_ordering ASC, bds.bds_id DESC";
        } else if ($action == 'project') {
            if ($filter_site_id) {
                $where[] = "p.bds_project_site_id=" . $filter_site_id;
            } else {
                $where[] = "p.bds_project_site_id IN (" . implode(",", array_flip($sites)) . ")";
            }

            if ($filter_status == 0) {
                $where[] = "p.bds_project_status=0";
            } else if ($filter_status == 3) {
                $where[] = "p.bds_project_status>=0";
            } else {
                $where[] = "p.bds_project_status=" . $filter_status;
            }

//            if ($filter_catid){
//                $all_under_catid = $objCategory->get_all_whole_under_id($filter_catid);
//                $where[] = "p.bds_category_id IN(".implode(",", $all_under_catid).")";
//            }

            // Ge fields, join, order
            $field_select = "p.*, tp.ten_tinh, qh.ten_huyen";
            $join = " LEFT JOIN " . TBL_TINH_THANH_PHO . " tp ON p.bds_project_city_id = tp.ma_tinh";
            $join .= " LEFT JOIN " . TBL_QUAN_HUYEN . " qh ON p.bds_project_district_id = qh.ma_huyen";

            $order = " ORDER BY p.bds_project_ordering ASC, p.bds_project_id DESC";
        } else if ($action == 'construction') {
            if ($filter_site_id) {
                $where[] = "d.construction_design_site_id=" . $filter_site_id;
            } else {
                $where[] = "d.construction_design_site_id IN (" . implode(",", array_flip($sites)) . ")";
            }

            if ($filter_status == 0) {
                $where[] = "d.construction_design_status=0";
            } else if ($filter_status == 3) {
                $where[] = "d.construction_design_status>=0";
            } else {
                $where[] = "d.construction_design_status=" . $filter_status;
            }

            if ($filter_catid) {
                $all_under_catid = $objCategory->get_all_whole_under_id($filter_catid);
                $where[] = "d.construction_design_category_id IN(" . implode(",", $all_under_catid) . ")";
            }

            // Ge fields, join, order
            $field_select = "d.*, c.category_name, c.category_alias, tp.ten_tinh, qh.ten_huyen";
            $join = " LEFT JOIN " . TBL_CATEGORY . " c ON d.construction_design_category_id = c.category_id";
            $join .= " LEFT JOIN " . TBL_TINH_THANH_PHO . " tp ON d.construction_design_city_id = tp.ma_tinh";
            $join .= " LEFT JOIN " . TBL_QUAN_HUYEN . " qh ON d.construction_design_district_id = qh.ma_huyen";

            $order = " ORDER BY d.construction_design_ordering ASC, d.construction_design_id DESC";
        } else if ($action == 'company') {
            if ( $filter_site_id ){
                $where[] = "com.company_site_id=" . $filter_site_id;
            }
            // Ge fields, join, order
            $field_select = "com.*, tp.ten_tinh, qh.ten_huyen";
            //$join = " LEFT JOIN " . TBL_CATEGORY . " c ON d.construction_design_category_id = c.category_id";
            $join .= " LEFT JOIN " . TBL_TINH_THANH_PHO . " tp ON com.company_city_id = tp.ma_tinh";
            $join .= " LEFT JOIN " . TBL_QUAN_HUYEN . " qh ON com.company_district_id = qh.ma_huyen";
        }

        $where = (count($where) ? ' WHERE ' . implode(' AND ', $where) : '');

        // GET THE TOTAL NUMBER OF RECORDS
        $totalRecords = 0;
        $c_query = "SELECT COUNT(*) AS total FROM " . $table_name . " AS " . $as_alias . $where;
        $c_result = $database->db_query($c_query);
        if ($c_row = $database->db_fetch_assoc($c_result)) {
            $totalRecords = $c_row['total'];
        }

        // PHAN TRANG
        $pager = new pager($limit, $totalRecords, $p);
        $offset = $pager->offset;

        if ( $action == 'section' ) {
            $query = "SELECT " . $field_select . " FROM " . $table_name . " AS " . $as_alias . $join . $where . " GROUP BY s.bds_section_id " . $order . " LIMIT " . $offset . ", " . $limit;
        }else if ( $action == 'bds' ) {
            $query = "SELECT " . $field_select . " FROM " . $table_name . " AS " . $as_alias . $join . $where . " GROUP BY bds.bds_id " . $order . " LIMIT " . $offset . ", " . $limit;
        }else if ( $action == 'project' ){
            $query = "SELECT " . $field_select . " FROM " . $table_name . " AS " . $as_alias . $join . $where . " GROUP BY p.bds_project_id " . $order . " LIMIT " . $offset . ", " . $limit;
        }else if ( $action == 'construction' ){
            $query = "SELECT " . $field_select . " FROM " . $table_name . " AS " . $as_alias . $join . $where . " GROUP BY d.construction_design_id " . $order . " LIMIT " . $offset . ", " . $limit;
        }else if ( $action == 'company' ){
            $query = "SELECT " . $field_select . " FROM " . $table_name . " AS " . $as_alias . $join . $where . " GROUP BY com.company_id " . $order . " LIMIT " . $offset . ", " . $limit;
        }
        $results = $database->db_query($query);
        while ( $row = $database->db_fetch_assoc($results) ){
            if ( $action == 'section' ) {
                $row['site'] = $sites[$row['bds_section_site_id']];
            }else if ( $action == 'bds' ) {
                $row['site'] = $sites[$row['bds_site_id']];
                $row['section'] = $_bds_sections[$row['bds_section']];
                if ( isset($_bds_category_ids[$row['bds_category_id']]) && $_bds_category_ids[$row['bds_category_id']] ){
                    foreach ( $_bds_category_ids[$row['bds_category_id']] as $key => $value ){
                        $row['type'] = $value;
                    }
                }
                $row['room'] = $_bds_bedrooms[$row['bds_number_bedroom']];
                $row['bathroom'] = $_bds_bathrooms[$row['bds_number_bathroom']];
                $row['price'] = $_bds_price_ranges[$row['bds_section']][$row['bds_price_range']];
                $row['area'] = $_bds_areas[$row['bds_area']];

                // Get image thumbnail
                $row['bds_image'] = json_decode($row['bds_image']);
                if ( is_object($row['bds_image']) ){
                    $row['bds_image'] =  (array) $row['bds_image'];
                    $row['bds_image'] = array_values($row['bds_image']);
                }

                $row['tiny_thumbnail'] = array();
                if ( isset($row['bds_image']) && is_array($row['bds_image']) && count($row['bds_image']) ){
                    foreach ( $row['bds_image'] as $key => $value ){
                        if ( $key == 0 ){
                            $row['tiny_thumbnail'] = showImageSubject($value, TBL_BDS, 'tiny');
                        }
                    }
                }
            }else if ( $action == 'project' ){
                $row['site'] = $sites[$row['bds_project_site_id']];
            }else if ( $action == 'construction' ){
                $row['site'] = $sites[$row['construction_design_site_id']];
                $row['link'] = $rewriteClass->rewriteUrlPage($pageName = 'construction_design', $row['construction_design_id'], $row['construction_design_alias'], $row["category_alias"]);
            }else if ( $action == 'company' ){
                $row['site'] = $sites[$row['company_site_id']];
            }
            $list[] = $row;
        }

        //print_r($list); die;
        if ( isset($list) && $list ){
            $smarty->assign('list', $list);
        }

        $smarty->assign('filter_status', $filter_status);
        $smarty->assign('filter_catid', $filter_catid);
        $smarty->assign('filter_section', $filter_section);
        $smarty->assign('filter_site_id', $filter_site_id);
        $smarty->assign('search', $search);
        $smarty->assign('datapage', $pager->page_link());
        $smarty->assign('limit', $limit);
        $smarty->assign('p', $p);
        $smarty->assign('option', $option);
        break;
}

if ( $action == 'bds' ){
    $list_sections = $objBds->_bds_section();
    $smarty->assign('list_sections', $list_sections);
}

$smarty->assign('listCity', $listCity);
$smarty->assign('listDistrict', $listDistrict);

$smarty->assign('sites', $sites);
$smarty->assign('action', $action);
$smarty->assign('text_title', $text_title);

//create toolbar buttons
if ($task == 'view' || !$task) {
    $toolbar = createToolbarAce('add', 'edit', 'publish', 'unpublish', 'remove');
} elseif ($task == 'edit' || $task == 'add') {
    $toolbar = createToolbarAce('save', 'cancel');
}

include "admin_footer.php";