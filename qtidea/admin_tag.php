<?php
/**
 * Created by PhpStorm.
 * User: Ngọc Kiều
 * Date: 11/27/2017
 * Time: 2:08 PM
 */
$page = "admin_tag";
$page_title = "Quản lý hashtag";
include "admin_header.php";
include "include/develops/class_hashtag.php";

$objTag = new PGtag();

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
        if ($task == 'edit') $page_title = "Cập nhật hashtag";
        else $page_title = "Thêm mới hashtag";

        $tag_id	= PGRequest::getInt('tag_id', 0, 'GET');
        $cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
        if ( !$tag_id ){
            $tag_id = $cid[0];
        }

        $thisTag = $objTag->loadItem($tag_id);

        if ( $setting['setting_tab_data'] && $thisTag ){
            $sql = "SELECT * FROM ".TBL_TAB." WHERE tab_reference_id = " . $thisTag->data['tag_id'] . " AND tab_type = 'tag' ORDER BY tab_ordering ASC, tab_id DESC";
            $results = $database->db_query($sql);
            while ( $row = $database->db_fetch_assoc($results) ){
                $thisTag->dataTabs[] = $row;
            }
        }
        $itemTab->dataTabs = ( isset($thisTag->dataTabs) && is_array($thisTag->dataTabs) ) ? $thisTag->dataTabs : false ;

        $smarty->assign('tag_id', $tag_id);
        $smarty->assign('thisTag', $thisTag);
        $smarty->assign('itemTab', $itemTab);
        break;

    case 'pending':
    case 'save':
    case 'saveonly':
        $changetext                 = PGRequest::getInt('changetext', 0, 'POST');
        if ( $changetext ){
            if ( !$admin->admin_super ){
                PGError::set_error('Bạn không đủ quyền thực hiện chức năng này. Chỉ có SUPER ADMIN mới có quyền thực hiện chức năng này!');
                cheader($uri->base().'admin_tag.php');
            }
            if ( !isset($admin->admin_site_default['site_id']) || !$admin->admin_site_default['site_id'] ){
                PGError::set_error('Bạn không thể thực hiện chức năng này do chưa cấu hình sử dụng site mặc định!');
                cheader($uri->base().'admin_tag.php');
            }

            $text_find = $database->getEscaped(PGRequest::getString('text_find', '', 'POST'));
            $text_find_convert = iconv(mb_detect_encoding($text_find, mb_detect_order(), true), "UTF-8", $text_find);
            $text_replace = $database->getEscaped(PGRequest::getString('text_replace', '', 'POST'));

            if ( !strlen($text_find) || !strlen($text_replace) ){
                PGError::set_error('Không thể thực hiện chức năng này do từ tìm kiếm hoặc từ thay thế đang để rỗng!');
                cheader($uri->base().'admin_tag.php');
            }

            $query = "UPDATE ".TBL_TAG."
					SET tag_fulltext = REPLACE(tag_fulltext, '".$text_find_convert."', '".$text_replace."')
					WHERE tag_site_id = {$admin->admin_site_default['site_id']}";
            $database->db_query($query);

            $sql = "UPDATE ".TBL_TAG."
                        SET tag_name = REPLACE(tag_name, '".$text_find."', '".$text_replace."'),
                        tag_short_desc = REPLACE(tag_short_desc, '".$text_find."', '".$text_replace."'),
                        tag_fulltext = REPLACE(tag_fulltext, '".$text_find."', '".$text_replace."'),
                        tag_metatitle = REPLACE(tag_metatitle, '".$text_find."', '".$text_replace."'),
                        tag_metakey = REPLACE(tag_metakey, '".$text_find."', '".$text_replace."'),
                        tag_metadesc = REPLACE(tag_metadesc, '".$text_find."', '".$text_replace."')
                        WHERE tag_site_id = {$admin->admin_site_default['site_id']}";
            if ( !$database->db_query($sql) ){
                PGError::set_error('Có lỗi xảy ra trong quá trình cập nhật. Lỗi:' . $database->db_error());
            }else{
                PGError::set_message('Thay thế thành công từ khóa <b>'.$text_find.'</b> thành <b style="color:red;">'.$text_replace.'</b>!');
            }
            cheader($uri->base().'admin_tag.php');
        }

        $tag_id				    = PGRequest::getInt('tag_id', 0, 'POST');
        $tag_site_id			= PGRequest::GetInt('tag_site_id', 0, 'POST');
        $tag_id_value		    = PGRequest::getInt('tag_id_value', 0, 'POST');
        $tag_name			    = $database->getEscaped(PGRequest::getString('tag_name', '', 'POST'));
        $tag_directory          = $database->getEscaped(PGRequest::getString('tag_directory', '', 'POST'));
        $tag_link_redirect      = $database->getEscaped(PGRequest::getString('tag_link_redirect', '', 'POST'));
        $tag_short_desc         = $filter->_decode(PGRequest::getVar('tag_short_desc', '', 'post', 'string', PGREQUEST_ALLOWRAW ));
        $tag_fulltext		    = $filter->_decode(PGRequest::getVar('tag_fulltext', '', 'post', 'string', PGREQUEST_ALLOWRAW ));
        $tag_special            = PGRequest::getInt('tag_special', 0, 'POST');
        $tag_ordering			= PGRequest::GetInt('tag_ordering', 0, 'POST');
        $tag_status			    = PGRequest::GetInt('tag_status', 0, 'POST');
        $tag_struct_html_h		= PGRequest::getInt('tag_struct_html_h', 0, 'POST');
        $tag_custom_html        = PGRequest::GetInt('tag_custom_html', 0, 'POST');
        $tag_custom_html_mobile = PGRequest::GetInt('tag_custom_html_mobile', 0, 'POST');
        $tag_template_director  = $database->getEscaped(PGRequest::getString('tag_template_director', '', 'POST'));

        // SEO
        $tag_metatitle          = $database->getEscaped(PGRequest::getString('tag_metatitle', '', 'POST'));
        $tag_metakey            = $filter->_decode(PGRequest::getVar('tag_metakey', '', 'post', 'string', PGREQUEST_ALLOWRAW ));
        $tag_metadesc           = $filter->_decode(PGRequest::getVar('tag_metadesc', '', 'post', 'string', PGREQUEST_ALLOWRAW ));

        if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
            $tag_site_id 	= $admin->admin_site_default['site_id'];

        $thisTag = $objTag->loadItem($tag_id_value);
        if (!$objTag->is_message){
            $processReturn = 0;
            $input['tag_id']	 				= $tag_id_value;
            if ( $tag_site_id ){
                $input['tag_site_id']		    = $tag_site_id;
            }
            $input['tag_name']				    = $tag_name;

            /*
			 * XỬ LÝ KHI THÊM MỚI KHÔNG XỬ LÝ EDIT
			 * Nếu nhập alias thì alias sinh ra bằng nhập
			 * Nếu không nhập alias thì sinh tự động mã hóa
			*/
            if ( !$tag_id_value ){ // ADD
                $name_alias						= convertKhongdau($tag_name);
                $input['tag_alias'] 			= generateSlug($name_alias, strlen($name_alias));
            }

            if ( !$tag_id_value ){
                $input['tag_created']			= $datetime->timestampToDateTime();
            }else{
                $input['tag_modified']		    = $datetime->timestampToDateTime();
            }

            $tag_directory                      = convertKhongdau($tag_directory);
            $directory                          = generateSlugNotSpace($tag_directory, strlen($tag_directory));
            $input['tag_directory']			    = $directory;
            $input['tag_link_redirect']         = $tag_link_redirect;
            $input['tag_short_desc']			= $tag_short_desc;
            $input['tag_fulltext']			    = $tag_fulltext;
            $input['tag_special']               = $tag_special;
            $input['tag_ordering']			    = $tag_ordering;
            $input['tag_status']				= $tag_status;
            if ( $task == 'pending' ){
                $input['tag_status'] 			= 2;
            }
            // SEO
            $input['tag_metatitle']             = $tag_metatitle;
            $input['tag_metakey']               = $tag_metakey;
            $input['tag_metadesc']              = $tag_metadesc;

            $input['tag_struct_html_h']        = $tag_struct_html_h;

            // Custom template
            if ( $tag_custom_html ){
                $input['tag_custom_html']       = $tag_custom_html;
                $input['tag_template_director'] = $tag_template_director;
            }else{
                $input['tag_custom_html']       = 0;
                $input['tag_template_director'] = '';
            }
            if ( $tag_custom_html_mobile && ( $admin->admin_super || ($admin->admin_info['admin_group'] == 1)) ){
                $input['tag_custom_html_mobile'] = $tag_custom_html_mobile;
                $input['tag_fulltext_mobile']    = $filter->_decode(PGRequest::getVar('tag_fulltext_mobile', '', 'post', 'string', PGREQUEST_ALLOWRAW ));;
            }else{
                $input['tag_custom_html_mobile'] = 0;
            }

            //print_r($input); die;

            // Image
            if( isset($_FILES['image']) && count($_FILES['image']['error']) == 1 && $_FILES['image']['error'][0] > 0){
                //file not selected
            } else if(isset($_FILES['image']) && $_FILES['image']['name']){ //this is just to check if isset($_FILE). Not required.
                //file selected
                if ( $tag_id_value ){
                    if ($thisTag->data["tag_image"] != "")
                        removeImage($thisTag->data["tag_image"], str_replace('admin_', '', $page.'s'));
                }
                $input['tag_image'] = uploadImage($_FILES["image"]["name"], $_FILES["image"]["tmp_name"], str_replace('admin_', '', $page.'s'), 'thumbnail-'.$input['tag_alias']);
            }

            $processReturn = $objTag->save($thisTag, $input);
            $db_insert_update_id = ($tag_id_value ? $tag_id_value : $database->db_insert_id() );
            $db_insert_id = $db_insert_update_id;

            // Submit DMCA, Submit for SEO
            if ( $tag_status ){
                if ( $tag_id_value )
                    $link_submit = $thisTag->data['link'];
                else{
                    $newTag = $objTag->loadItem(FALSE, $db_insert_update_id);
                    $link_submit = $newTag->data['link'];
                }

                auto_call_dmca($link_submit);
                auto_submit_for_seo($link_submit);
            }
        }else{
            $processReturn = $objTag->is_message;
        }

        if ( $setting['setting_tab_data'] ){
            require_once "admin_tab_form.php";
        }

        if ( !$processReturn ){
            $message = 'Lỗi hệ thống! - ' . $database->db_error();
            PGError::set_error($message);
        }else{
            if ( $processReturn == 'add' ){
                $message = 'Thêm mới tag thành công!';
            }else if ( $processReturn == 'edit' ){
                $message = 'Cập nhật tag thành công!';
            }
            PGError::set_message($message);
        }

        if ( $task == 'saveonly' || $task == 'pending' ){
            cheader($uri->base().'admin_tag.php?task=edit&tag_id=' . $db_insert_update_id);
        }
        cheader($uri->base().'admin_tag.php');
        break;

    case 'publish':
        $cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
        if (count($cid)) {
            $message = $objTag->published($cid, 1);
            PGError::set_message($message);
            cheader($uri->base().'admin_tag.php');
        }
        break;

    case 'unpublish':
        $cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
        if (count($cid)) {
            $message = $objTag->published($cid, 0);
            PGError::set_message($message);
            cheader($uri->base().'admin_tag.php');
        }
        break;

    case 'remove':
        $cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
        if (count($cid)) {
            $message = $objTag->remove($cid);
            PGError::set_message($message);
            cheader($uri->base().'admin_tag.php');
        }
        break;

    case 'view':
    case 'export':
    case 'sync':
    default :
        $page_title = "Quản lý hashtag";

        if ( $task == 'sync' && !$admin->admin_super ){
            PGError::set_error('Bạn không đủ quyền thực hiện chức năng này. Chỉ có SUPER ADMIN mới có quyền thực hiện chức năng này!');
            cheader($uri->base().'admin_tag.php');
        }

        $filter_fulltext= PGRequest::getInt('filter_fulltext', 0, 'POST');
        $filter_status 	= PGRequest::getInt('filter_status', 1, 'POST');
        $filter_site_id = PGRequest::getInt('filter_site_id', 0, 'POST');
        $search 		= PGRequest::getString('search', '', 'POST');

        $p = PGRequest::getInt('p', 1, 'POST');
        $limit = PGRequest::getInt('limit', $setting['setting_list_limit'], 'POST');

        //CONDITION
        if ( !$filter_site_id ){
            if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
                $filter_site_id = $admin->admin_site_default['site_id'];
        }
        if ( $filter_site_id ){
            $where[] = "tag_site_id=".$filter_site_id;
        }else{
            $where[] = "tag_site_id IN (".implode(",", array_flip($sites)).")";
        }

        if ($search){
            if ( $filter_fulltext )
                $where[] = "(tag_name LIKE'%$search%' OR tag_short_desc LIKE'%$search%' OR tag_fulltext LIKE'%$search%' OR tag_metatitle LIKE'%$search%' OR tag_metakey LIKE'%$search%' OR tag_metadesc LIKE'%$search%')";
            else
                $where[] = "tag_name LIKE'%$search%'";
        }

        if ($filter_status == 0) {
            $where[] = "tag_status=0";
        }else if ($filter_status == 3){
            $where[] = "tag_status>=0";
        }else{
            $where[] = "tag_status=".$filter_status;
        }
        $where = (count($where) ? ' WHERE '.implode(' AND ', $where) : '');
        $order = " ORDER BY tag_ordering, tag_name ASC, tag_created DESC";
        // GET THE TOTAL NUMBER OF RECORDS
        $query = "SELECT COUNT(*) AS total FROM ".TBL_TAG.$where;
        $results = $database->db_fetch_assoc($database->db_query($query));
        // PHAN TRANG
        $pager = new pager($limit, $results['total'], $p);
        $offset = $pager->offset;
        // LAY DANH SACH CHI TIET
        $lstag = $objTag->loadListItems($where, $order, $offset, $limit, $all_field = true, ($filter_fulltext ? $search : false) );

        $arrId = array();
        foreach ( $lstag as $tag){
            if ( !in_array($tag['tag_id'], $arrId) ){
                array_push($arrId, $tag['tag_id']);
            }
        }
        foreach ( $lstag as $tag){
            $list_tags[$tag['tag_id']] = $tag;
        }

        if ( is_array($arrId) && count($arrId) ) {
            $_query = "SELECT c.content_id, c.content_title, tc.tag_id FROM " . TBL_CONTENT . " AS c LEFT JOIN " . TBL_TAG_CONTENT . " AS tc ON c.content_id = tc.content_id WHERE tc.tag_id IN(" . implode(",", $arrId) . ") ORDER BY c.content_id DESC";
            $_results = $database->db_query($_query);
            while ($_row = $database->db_fetch_assoc($_results)) {
                $list_tags[$_row['tag_id']]['data_content'][] = $_row;
            }
        }

        if ( $task == 'export' ){
            $page_title = 'Export danh sách landing page';

            require_once "../include/excel/Classes/PHPExcel/IOFactory.php";
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load("../include/excel/templates/list_link.xls");

            if ($totalRecords > 15000) {
                cheader($uri->base().$page.".php");
            }

            $baseRow = 6;
            foreach(array_values($list_tags) as $r => $dataRow) {
                $row = $baseRow + $r;
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $r+1);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dataRow['tag_name']);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dataRow['link']);
            }
            $objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);

            $fileName = "danh_sach_landingpage_".time().".xls";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $fileName);
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }

        if ( $task == 'sync' ){
            $count_resize = 0;
            foreach($list_tags as $r => $dataRow) {
                if ( isset($dataRow['tag_image']) && $dataRow['tag_image'] ){
                    $url_thumbnail = PG_URL_HOMEPAGE . 'images/tags/' . $dataRow['tag_image'];

                    $path_info = pathinfo($url_thumbnail);
                    $set_name = $path_info['basename'];
                    $director_path = pathinfo($path_info['dirname']);
                    $set_path = $director_path['basename'];

                    if ( resize_image_from_url_and_save($url_thumbnail, $set_name, $set_path, false, false) )
                        $count_resize++;
                }
            }
            PGError::set_message('Resize thành công <b style="color:red;">'.$count_resize.'</b> ảnh!');
            cheader($uri->base().'admin_tag.php');
        }

        $smarty->assign('filter_fulltext', $filter_fulltext);
        $smarty->assign('filter_status', $filter_status);
        $smarty->assign('filter_site_id', $filter_site_id);
        $smarty->assign('search', $search);
        $smarty->assign('datapage', $pager->page_link());
        $smarty->assign('p', $p);
        $smarty->assign('lstag', array_values($list_tags));
        break;
}

$smarty->assign('sites', $sites);
//create toolbar buttons
if ($task == 'view' || !$task) {
    if ( $admin->admin_super )
        $toolbar = createToolbarAce('add', 'edit', 'export', 'publish', 'unpublish', 'remove', 'change', 'sync');
    else
        $toolbar = createToolbarAce('add', 'edit', 'export', 'publish', 'unpublish', 'remove');
} elseif ($task == 'edit' || $task == 'add') {
    $toolbar = createToolbarAce('pending', 'saveonly', 'save', 'cancel');
} elseif ($task == 'change') {
    $toolbar = createToolbarAce('save', 'cancel');
}

include "admin_footer.php";
?>