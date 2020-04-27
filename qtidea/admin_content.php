<?php
include "admin_header.php";
require_once "ajax_multi_uploader.php";
include "include/develops/class_category.php";
include "include/develops/class_content.php";
require_once "include/globals/class_city_district.php";

$page = "admin_content";
$page_title = "Quản lý danh mục tin";

$objCategory= new PGCategory();
$objContent = new PGContent();
$objCityDistrict = new PGCityDistrict();

$task = PGRequest::GetCmd('task', 'view');
if ($task == 'cancel') $task = 'view';

$objAcl = new PGAcl();
if (!$objAcl->checkPermission($page, $task)) {
	$objAcl->showErrorPage($smarty);
}

if ( isset($list_modules['tuyensinhso']) && is_array($list_modules['tuyensinhso']) ){
	require_once 'include/develops/services/tuyensinhso/tuyensinhso.php';
	$objTSS = new PG_Tuyen_sinh_so();
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

switch($task){
	case 'change':
		break;

	case 'edit':
	case 'add':
		if ($task == 'edit') $page_title = "Cập nhật tin tức";
		else $page_title = "Thêm mới tin tức";
		
		$content_id	= PGRequest::getInt('content_id', 0, 'GET');
		$filter_catid 	= PGRequest::getInt('filter_catid', 0, 'POST');
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if ( !$content_id ){
			$content_id = $cid[0];
		}

		// Get keyword in site
		$_sql_all_kw = "SELECT keyword_id, keyword_code, keyword, link_in_site, link_out_site, keyword_type FROM ".TBL_KEYWORD." WHERE keyword_status=1".( $filter_site_id ? " AND site_id=".$filter_site_id : "")." ORDER BY keyword_code";
		$_result_all_kws = $database->db_query($_sql_all_kw);
		while ( $_row_all_kw = $database->db_fetch_assoc($_result_all_kws) ){
			$list_all_keywords[$_row_all_kw['keyword_code']] = $_row_all_kw;
			if ( $_row_all_kw['keyword_type'] && $_row_all_kw['keyword_type'] < 3 ){
				$_list_develop_keywords[$_row_all_kw['keyword_code']] = $_row_all_kw;
			}
		}

		$aryKeywordId = array();
		if ( $content_id ){
			$thisContent = $objContent->loadItem(TRUE, $content_id);
			$aryKeywordId = $database->getCol($database->db_query("SELECT keyword_id FROM ".TBL_KEYWORD_INTEGRATED." WHERE integrated_type = 'content' AND integrated_id=".$content_id));
		}

		//check bài viết có đang được thao tác bởi người khác không?
		if(!empty($thisContent->data['content_opening']) && ($thisContent->data['content_opening'] != $admin->admin_info['admin_id']))
		{
			PGError::set_error('Bài viết này đang được thao tác bởi 1 người khác, vui lòng thử lại sau');
			cheader($uri->base().'admin_content.php');
		}
		//set opening cho user khi field opening rỗng
		if(empty($thisContent->data['content_opening']) && !empty($content_id))
		{
			$objContent->Opening($content_id,$admin->admin_info['admin_id']);
		}

		if ( $setting['setting_tab_data'] && $thisContent ){
			$sql = "SELECT * FROM ".TBL_TAB." WHERE tab_reference_id = " . $thisContent->data['content_id'] . " AND tab_type = 'content' ORDER BY tab_ordering ASC, tab_id DESC";
			$results = $database->db_query($sql);
			while ( $row = $database->db_fetch_assoc($results) ){
				$thisContent->dataTabs[] = $row;
			}
		}
		$itemTab->dataTabs = ( isset($thisContent->dataTabs) && is_array($thisContent->dataTabs) ) ? $thisContent->dataTabs : false ;
		$selected = ($thisContent->data['content_catid']) ? $thisContent->data['content_catid'] : 0;

		$listItems = $objCategory->getOptionItems($listCatItems, 0, $selected);

		if ( $content_id ) {
			$query = 'SELECT category_id FROM ' . TBL_CONTENT_CATEGORY . ' WHERE content_id=' . $content_id;
			$results = $database->db_query($query);
			while ($row = $database->db_fetch_assoc($results)) {
				$aryChecbox[] = $row['category_id'];
			}
		}
        $listItemCheckboxs = $objCategory->getCheckboxItems($listCatItems, 0, ( isset($aryChecbox) && is_array($aryChecbox)) ? $aryChecbox : array(), 'content_category');

		$list_countrys = $objCityDistrict->getListCountry();

		// Get all contents show
		$_asql = "SELECT content_id, content_title FROM ".TBL_CONTENT." WHERE content_status=1".($filter_site_id ? " AND content_site_id=".$filter_site_id : "").(($task == 'edit') ? " AND content_id <> " . $content_id : "")." ORDER BY content_ordering ASC, content_id DESC";
		$_aresults = $database->db_query($_asql);
		while ( $_arow = $database->db_fetch_assoc($_aresults) ){
			$_alist[] = $_arow;
		}
		if ( isset($_alist) && $_alist ){
			$smarty->assign('_alist', $_alist);
		}

		// Get list hashtags
		$_h_query = "SELECT tag_id, tag_name FROM ".TBL_TAG." WHERE tag_status=1 ".($filter_site_id ? ' AND tag_site_id='.$filter_site_id : '')." ORDER BY tag_ordering, tag_name ASC, tag_id DESC";
		$_h_results = $database->db_query($_h_query);
		while ( $_h_row = $database->db_fetch_assoc($_h_results) ){
			$_list_hashtags[] = $_h_row;
		}
		if ( isset($_list_hashtags) && $_list_hashtags ){
			$smarty->assign('_list_hashtags', $_list_hashtags);
		}
		// Get list hashtag, content follow selected
		if ( $task == 'edit' ){
			$_sh_query = "SELECT tag_id FROM ".TBL_TAG_CONTENT." WHERE content_id = ".$content_id.($filter_site_id ? ' AND site_id='.$filter_site_id : '');
			$_sh_results = $database->db_query($_sh_query);
			while ( $_sh_row = $database->db_fetch_assoc($_sh_results) ){
				$_sh_list[] = $_sh_row['tag_id'];
			}
			if ( isset($_sh_list) && $_sh_list ){
				$smarty->assign('_sh_list', $_sh_list);
			}

			$_sa_query = "SELECT content_follow_id FROM ".TBL_CONTENT_FOLLOW." WHERE content_id=".$content_id.($filter_site_id ? " AND site_id=".$filter_site_id : "");
			$_sa_results = $database->db_query($_sa_query);
			while ( $_sa_row = $database->db_fetch_assoc($_sa_results) ){
				$_sa_list[] = $_sa_row['content_follow_id'];
			}
			if ( isset($_sa_list) && $_sa_list ){
				$smarty->assign('_sa_list', $_sa_list);
			}
		}

		// Get nickname
        $nickname = $admin->admin_info['admin_nickname'] ? $admin->admin_info['admin_nickname'] : $admin->admin_info['admin_name'];
		if ( isset($thisContent->data['content_nickname']) && $thisContent->data['content_nickname'] ){
            $nickname = $thisContent->data['content_nickname'];
        }
        $thisContent->data['images_list'] = array_reverse($thisContent->data['images_list']);
		//Assign variables
		$smarty->assign('content_id', $content_id);
		$smarty->assign('filter_catid', $filter_catid);
		$smarty->assign('thisContent', $thisContent);
		$smarty->assign('itemTab', $itemTab);
		$smarty->assign('listItems', $listItems);
        $smarty->assign('listItemCheckboxs', $listItemCheckboxs);
		$smarty->assign('list_countrys', $list_countrys);
		$smarty->assign('aryKeywordId', $aryKeywordId);
		$smarty->assign('_list_develop_keywords', $_list_develop_keywords);
        $smarty->assign('nickname', $nickname);
		$smarty->assign('admin_super', $admin->admin_super);
		break;

	case 'pending':
	case 'save':
	case 'save2add':
    case 'saveonly':
		$changetext                 = PGRequest::getInt('changetext', 0, 'POST');
		if ( $changetext ){
			if ( !$admin->admin_super ){
				PGError::set_error('Bạn không đủ quyền thực hiện chức năng này. Chỉ có SUPER ADMIN mới có quyền thực hiện chức năng này!');
				cheader($uri->base().'admin_content.php');
			}
			if ( !isset($admin->admin_site_default['site_id']) || !$admin->admin_site_default['site_id'] ){
				PGError::set_error('Bạn không thể thực hiện chức năng này do chưa cấu hình sử dụng site mặc định!');
				cheader($uri->base().'admin_content.php');
			}

			$text_find = $database->getEscaped(PGRequest::getString('text_find', '', 'POST'));
			$text_find_convert = iconv(mb_detect_encoding($text_find, mb_detect_order(), true), "UTF-8", $text_find);
			$text_replace = $database->getEscaped(PGRequest::getString('text_replace', '', 'POST'));

			if ( !strlen($text_find) || !strlen($text_replace) ){
				PGError::set_error('Không thể thực hiện chức năng này do từ tìm kiếm hoặc từ thay thế đang để rỗng!');
				cheader($uri->base().'admin_content.php');
			}

			$sql = "UPDATE ".TBL_CONTENT."
					SET content_title = REPLACE(content_title, '".$text_find."', '".$text_replace."'),
					content_introtext = REPLACE(content_introtext, '".$text_find."', '".$text_replace."'),
					content_fulltext = REPLACE(content_fulltext, '".$text_find."', '".$text_replace."'),
					content_fulltext_mobile = REPLACE(content_fulltext_mobile, '".$text_find."', '".$text_replace."'),
					content_fulltext_instant_article = REPLACE(content_fulltext_instant_article, '".$text_find."', '".$text_replace."'),
					content_metatitle = REPLACE(content_metatitle, '".$text_find."', '".$text_replace."'),
					content_metakey = REPLACE(content_metakey, '".$text_find."', '".$text_replace."'),
					content_metadesc = REPLACE(content_metadesc, '".$text_find."', '".$text_replace."')
					WHERE content_site_id = {$admin->admin_site_default['site_id']}";
			$database->db_query($sql);

			$query = "UPDATE ".TBL_CONTENT."
					SET content_fulltext = REPLACE(content_fulltext, '".$text_find_convert."', '".$text_replace."'),
						content_fulltext_mobile = REPLACE(content_fulltext_mobile, '".$text_find."', '".$text_replace."'),
						content_fulltext_instant_article = REPLACE(content_fulltext_instant_article, '".$text_find."', '".$text_replace."')
					WHERE content_site_id = {$admin->admin_site_default['site_id']}";
			$database->db_query($query);

			if ( !$database->db_query($sql) ){
				PGError::set_error('Có lỗi xảy ra trong quá trình cập nhật. Lỗi:' . $database->db_error());
			}else{
				PGError::set_message('Thay thế thành công từ khóa <b>'.$text_find.'</b> thành <b style="color:red;">'.$text_replace.'</b>!');
			}
			cheader($uri->base().'admin_content.php');
		}

		$content_id					= PGRequest::getInt('content_id', 0, 'POST');
		$content_site_id			= PGRequest::GetInt('content_site_id', 0, 'POST');
		$content_catid				= PGRequest::getInt('content_catid', 0, 'POST');
		$content_id_value			= PGRequest::getInt('content_id_value', 0, 'POST');
		$tick_title_special			= PGRequest::getInt('tick_title_special', 0, 'POST');
		$integrated_extend			= PGRequest::getInt('integrated_extend', 0, 'POST');
		$content_title				= $database->getEscaped(PGRequest::getString('content_title', '', 'POST'));
        $content_introtext			= $filter->_decode(PGRequest::getVar('content_introtext', '', 'post', 'string', PGREQUEST_ALLOWRAW ));
        $content_fulltext			= $filter->_decode(PGRequest::getVar('content_fulltext', '', 'post', 'string', PGREQUEST_ALLOWRAW ));
		if ( $tick_title_special ){
			$content_title			= $_POST['content_title'];
			if($admin->admin_info['admin_group'] == 1)
            {
                $content_introtext =  html_entity_decode($_POST['content_introtext']);
                $content_fulltext  =   html_entity_decode($_POST['content_fulltext']);
            }
		}

		$content_alias				= $database->getEscaped(PGRequest::getString('content_alias', '', 'POST'));
		$content_add_link			= $database->getEscaped(PGRequest::getString('content_add_link', '', 'POST'));
		$content_introtext_html		= PGRequest::getInt('content_introtext_html', 0, 'POST');

        $content_metatitle			= $database->getEscaped(PGRequest::getString('content_metatitle', ''));
		$content_metakey			= $database->getEscaped(PGRequest::getString('content_metakey', ''));
		$content_metadesc			= $database->getEscaped(PGRequest::getString('content_metadesc', ''));
		$content_hot				= PGRequest::getInt('content_hot', 0, 'POST');
		$content_special			= PGRequest::getInt('content_special', 0, 'POST');
		$content_photos				= PGRequest::getInt('content_photos', 0, 'POST');
		$content_ordering			= PGRequest::GetInt('content_ordering', 0, 'POST');
		$content_country_code       = PGRequest::getVar('content_country_code', '', 'POST');
		$content_struct_html_h		= PGRequest::getInt('content_struct_html_h', 0, 'POST');
		$content_plain				= PGRequest::getInt('content_plain', 0, 'POST');
        $content_nickname           = $database->getEscaped(PGRequest::getString('content_nickname', '', 'POST'));
		$content_tag_show_position  = PGRequest::getVar('content_tag_show_position', '', 'POST');
		$content_status				= PGRequest::GetInt('content_status', 0, 'POST');
		$content_allow_show			= PGRequest::GetInt('content_allow_show', 0, 'POST');
		$changeimage				= PGRequest::getInt('changeimage', 0, 'POST');
		$changeimagelarge			= PGRequest::getInt('changeimagelarge', 0, 'POST');
		$changeimagesocial			= PGRequest::getInt('changeimagesocial', 0, 'POST');
		$listFileName				= PGRequest::GetVar('listFileName', '');
		$content_video_code			= $database->getEscaped(PGRequest::getString('content_video_code', ''));
		$cbo_tag_content			= PGRequest::getVar( 'cbo_tag_content', array(), 'post', 'array' );
		$cbo_relate_content			= PGRequest::getVar( 'cbo_relate_content', array(), 'post', 'array' );

		$content_timer              = PGRequest::getInt('content_timer', 0, 'POST');
        $content_timer_published	= PGRequest::getVar('content_timer_published', array(), 'post', 'array' );
        $content_end_published      = PGRequest::getVar('content_end_published', array(), 'post', 'array' );

		$content_live_id			= PGRequest::getInt('content_live_id', 0, 'POST');

		$content_custom_html      	= PGRequest::GetInt('content_custom_html', 0, 'POST');
		$content_custom_html_mobile = PGRequest::GetInt('content_custom_html_mobile', 0, 'POST');
		$content_template_director	= $database->getEscaped(PGRequest::getString('content_template_director', '', 'POST'));

		$content_signature_on		= PGRequest::GetInt('content_signature_on', 0, 'POST');

		$aryKeyword 				= PGRequest::getVar( 'cbo_keyword', array(), 'post', 'array' );

		if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
			$content_site_id		= $admin->admin_site_default['site_id'];
		
		$thisContent = $objContent->loadItem(FALSE, $content_id_value);
		if (!$objContent->is_message){
			$input['content_id']	 				= $content_id_value;
			$input['content_catid']					= $content_catid;
			$input['content_title']					= $content_title;
			/*
			 * XỬ LÝ KHI EDIT:
			 * Nếu nhập alias ( alias mới khác với alias cũ ) thì cập nhật alias
			 * Nếu không nhập alias thì giữ nguyên alias cũ để vẫn giữ link cũ
			 * XỬ LÝ KHI THÊM MỚI
			 * Nếu nhập alias thì alias sinh ra bằng nhập
			 * Nếu không nhập alias thì sinh tự động mã hóa
			*/
			if ( !$content_id_value ){ // ADD
				if ( $content_site_id ){
					$input['content_site_id']			= $content_site_id;
				}
				if ( $content_alias != "" )
					$name_alias						= convertKhongdau($content_alias);
				else
					$name_alias						= convertKhongdau($content_title);

				$input['content_alias'] 			= generateSlug($name_alias, strlen($name_alias));
			}else{ // EDIT
				if ( $content_alias === $thisContent->data['content_alias'] )
					$input['content_alias']			= $thisContent->data['content_alias'];
				else{
					$name_alias						= convertKhongdau($content_alias);
					$input['content_alias'] 		= generateSlug($name_alias, strlen($name_alias));
				}
			}

			$input['content_tick_special']			= $tick_title_special;
			$input['content_integrated_extend']		= $integrated_extend;
			$input['content_add_link']				= $content_add_link;
			$input['content_introtext_html']		= $content_introtext_html;

			if ( $content_introtext_html )
				$input['content_introtext']			= $content_introtext;
			else
				$input['content_introtext']			= strip_tags($content_introtext);

			$input['content_fulltext']				= $content_fulltext;
            $input['content_metatitle']				= $content_metatitle;

			if ( $content_metakey && $content_metakey != $thisContent->data["content_metakey"] ){
				$input['content_metakey_edit_count']= intval($thisContent->data["content_metakey_edit_count"])+1;
			}
			if ( !$content_metakey && $aryKeyword && is_array($aryKeyword) && count($aryKeyword) && !empty($aryKeyword) ){
				$content_metakey					= get_keyword_integrated($aryKeyword);
			}
			if ( !$content_metakey && $setting['setting_auto_keyword_born'] ){
				$content_metakey					= $logAdmin->auto_keyword_born($content_title, $content_introtext);
			}
			$input['content_metakey']				= $content_metakey;

			$input['content_metadesc']				= $content_metadesc;
			$input['content_ordering']				= $content_ordering;
			$input['content_status']				= $content_status;
			if ( $task == 'pending' ){
				$input['content_status'] 			= 2;
			}
			$input['content_struct_html_h']			= $content_struct_html_h;
			$input['content_plain']					= $content_plain;
			$input['content_hot']					= $content_hot;
			$input['content_special']				= $content_special;
			$input['content_photos'] 				= $content_photos;
			$input['content_allow_show']			= $content_allow_show;
			$input['content_country_code']          = $content_country_code;
			$input['content_nickname']              = $content_nickname;

            $input['content_timer']                 = $content_timer;
            $input['content_timer_published']       = '(NULL)';
            $input['content_end_published']         = '(NULL)';
			if ( $content_timer ){
                if ( $content_timer_published[0] && !is_null($content_timer_published[0]) ){
                    $input['content_timer_published']	= $datetime->convertDate($content_timer_published[0], "dd/mm/yyyy").' '.$content_timer_published[1];
                }
                if ( $content_end_published[0] && !is_null($content_end_published[0]) ) {
                    $input['content_end_published'] = $datetime->convertDate($content_end_published[0], "dd/mm/yyyy") . ' ' . $content_end_published[1];
                }
            }
            //echo $input['content_end_published']; die;

			$input['content_live_id']				= $content_live_id;

			if ( $content_tag_show_position ){
				$input['content_tag_show_position']	= $content_tag_show_position;
			}

			// Custom template
			if ( $content_custom_html ){
				$input['content_custom_html']       = $content_custom_html;
				$input['content_template_director'] = $content_template_director;
			}else{
				$input['content_custom_html']       = 0;
				$input['content_template_director'] = '';
			}

			if ( $content_custom_html_mobile && $admin->admin_super ){
				$input['content_custom_html_mobile'] = $content_custom_html_mobile;
				$input['content_fulltext_mobile']    = $filter->_decode(PGRequest::getVar('content_fulltext_mobile', '', 'post', 'string', PGREQUEST_ALLOWRAW ));;
			}else{
				$input['content_custom_html_mobile'] = 0;
			}

			// Bật sử dụng mẫu chữ ký
			if ( $setting['setting_signature_on'] ){
				$input['content_signature_on']		= $content_signature_on;
			}

			// Instant Article
			if ( $setting['setting_facebook_instant_article'] && ($input['content_status'] == 1) ){
				// Xử lý từ fulltext
				/*-- Remove all style --*/
				$_instant_article = removeStyle($input['content_fulltext']);
				/*-- Remove style fonts --*/
				$_instant_article = preg_replace('/font-family.+?;/', "", $_instant_article);
				/*-- Remove class --*/
				$_instant_article = preg_replace('/class=".*?"/', '', $_instant_article);
				/*-- Remove div in content --*/
				$_instant_article = preg_replace("/<\/?div[^>]*\>/i", "", $_instant_article);

				/*-- Replace image --*/
				$text_p				= str_replace('<p >', '<p>', $_instant_article);
				$text_image 		= str_replace('<p><img ', '<figure><img ', $text_p);
				$_instant_article 	= str_replace('/></p>', '/></figure>', $text_image);

				// Tuyensinhso bị
				$_instant_article 	= str_replace('<p><strong><img', '<figure><img', $_instant_article);
				$_instant_article 	= str_replace('/></strong></p>', '/></figure>', $_instant_article);

				/*-- Xóa các thẻ khác ngoại trừ các thẻ khai báo --*/
				$_instant_article	= strip_tags($_instant_article, "<p><figure><span><i><strong><b><img>");

				$input['content_fulltext_instant_article'] = $_instant_article;
			}

			// Ảnh đại diện
			if ($changeimage == 1){
				if ( $content_id_value ){
					if ($thisContent->data["content_image_thumbnail"] != "")
					removeImage($thisContent->data["content_image_thumbnail"], str_replace('admin_', '', $page.'s'));
				}
				
				if( isset($_FILES['image']) && count($_FILES['image']['error']) == 1 && $_FILES['image']['error'][0] > 0){
				    //file not selected
					$url_image_large = showImageSubject($input['content_image_large'], TBL_CONTENT);
					list($width, $height) = getimagesize($url_image_large);
				    if ( $width < $setting['resize_image_min'] )
				    	$input['content_image_thumbnail'] = copyImageResize($input['content_image_large'], str_replace('admin_', '', $page.'s'));
				    else{
				    	$input['content_image_thumbnail'] = copyImageResize($input['content_image_large'], str_replace('admin_', '', $page.'s'), $setting['resize_image_normal'], $setting['resize_image_normal']);
				    }
				} else if(isset($_FILES['image'])){ //this is just to check if isset($_FILE). Not required.
				    //file selected
					$input['content_image_thumbnail'] = uploadImage($_FILES["image"]["name"], $_FILES["image"]["tmp_name"], str_replace('admin_', '', $page.'s'), 'thumbnail-'.$input['content_alias']);
				}
			}

			// Ảnh chi tiết
			if ( $changeimagelarge == 1 && isset($_FILES["image_large"]["name"]) ){
				if ( $content_id_value ){
					if ($thisContent->data["content_image_large"] != "")
						removeImage($thisContent->data["content_image_large"], str_replace('admin_', '', $page.'s'));
				}
				$input['content_image_large']	= uploadImage($_FILES["image_large"]["name"], $_FILES["image_large"]["tmp_name"], str_replace('admin_', '', $page.'s'), 'large-'.$input['content_alias']);
			}

			// Ảnh social
			if ($changeimagesocial && isset($_FILES["image_social"]["name"])){
				if ( $content_id_value ){
					if ($thisContent->data["content_image_social"] != "")
						removeImage($thisContent->data["content_image_social"], str_replace('admin_', '', $page.'s'));
				}
				$input['content_image_social']	= uploadImage($_FILES["image_social"]["name"], $_FILES["image_social"]["tmp_name"], str_replace('admin_', '', $page.'s'), 'share-'.$input['content_alias']);
			}

			// Ảnh list product
			if ( isset($_FILES['list_image']) && !empty($_FILES['list_image']['name']) && count($_FILES['list_image']['name'])){
				$params_image = array();
				for ( $i = 0; $i < count($_FILES['list_image']['name']); $i++ ) {
					if (isset($_FILES['list_image']) && count($_FILES['list_image']['error']) == 1 && $_FILES['list_image']['error'][$i] > 0) {
						//file not selected
						if (isset($thisContent) && is_object($thisContent) && is_array($thisContent->data['content_list_images']) && isset($thisContent->data['content_list_images'][$i]) && $thisContent->data['content_list_images'][$i]) {
							$params_image[$i] = $thisContent->data['content_list_images'][$i];
						}
					} else if (isset($_FILES["list_image"]["name"][$i]) && $_FILES["list_image"]["name"][$i]) { //this is just to check if isset($_FILE). Not required.
						//file selected
						if (isset($thisContent) && is_object($thisContent) && is_array($thisContent->data['content_list_images']) && isset($thisContent->data['content_list_images'][$i]) && $thisContent->data['content_list_images'][$i]) {
							if ($thisContent->data["content_list_images"][$i] != "")
								removeImage($thisContent->data["content_list_images"][$i], str_replace('admin_', '', $page.'s'));
						}
						$params_image[$i] = uploadImage($_FILES["list_image"]["name"][$i], $_FILES["list_image"]["tmp_name"][$i], str_replace('admin_', '', $page.'s'), 'list-' . $input['product_alias'] . '-' . $i);
					}else{
						if (isset($thisContent) && is_object($thisContent) && is_array($thisContent->data['content_list_images']) && isset($thisContent->data['content_list_images'][$i]) && $thisContent->data['content_list_images'][$i]) {
							$params_image[$i] = $thisContent->data['content_list_images'][$i];
						}
					}
				}
				$params_image = array_unique(array_filter($params_image));
				if ( !empty($params_image) && count($params_image) ){
					$input['content_list_images'] = json_encode($params_image);
				}
			}
			
			if ( $listFileName ){
				$input['content_photos'] = 1;
			}

			if ( $content_video_code ){
				$input['content_videos'] = 1;
				$input['content_video_code'] = $content_video_code;
			}

			$content_category 				= PGRequest::getVar( 'content_category', array(), 'post', 'array' );
			if ( !$input['content_catid'] && count($content_category) ){
				$input['content_catid'] = array_shift(array_values($content_category)); // first element array
			}
			$message = $objContent->save($thisContent, $input);
			
			$db_insert_id = 0;
			if ( !$content_id_value )
				$db_insert_id = $database->db_insert_id();
			else{
				$db_insert_id = $content_id_value;
				if ( $setting['setting_save_log'] ){
					// Save log
					$logAdmin->saveLog(TBL_CONTENT, $content_id_value, $thisContent->data['content_fulltext'], $content_fulltext, $task);
				}
			}

			//optimize URL
			if ( $content_id_value ){
				$database->db_query("DELETE FROM ".TBL_OPTIMIZE." WHERE post_id={$db_insert_id} AND post_site_id ={$content_site_id} AND post_type = 1");
			}
			$optimize_insert = 'INSERT INTO '.TBL_OPTIMIZE.' (optimize_url, post_site_id, post_id, post_type)
                                VALUES("'.$input['content_alias'].'",'.$content_site_id.','.$db_insert_id.',1)';
			$database->db_query($optimize_insert);

			// Tag content
			if ( is_array($cbo_tag_content)){
				$_h_query = array();
				foreach ( $cbo_tag_content as $_h_value ){
					if ( $content_site_id ){
						$_h_query[] = '('.$_h_value.', '.($content_id_value ? $content_id_value: $db_insert_id).', '.$content_site_id.')';
					}
				}
				if ( $content_id_value ){
					$database->db_query("DELETE FROM ".TBL_TAG_CONTENT." WHERE content_id={$content_id_value}");
				}
				if ( count($_h_query) && !empty($_h_query) ){
					$_h_insert = 'INSERT INTO '.TBL_TAG_CONTENT.' (tag_id, content_id, site_id) VALUES '.implode(',', $_h_query);
					$database->db_query($_h_insert);
				}
			}

			// Follow content
			if ( is_array($cbo_relate_content)){
				$_a_query = array();
				foreach ( $cbo_relate_content as $_a_value ){
					if ( $content_site_id ){
						$_a_query[] = '('.$_a_value.', '.($content_id_value ? $content_id_value: $db_insert_id).', '.$content_site_id.')';
					}
				}
				if ( $content_id_value ){
					$database->db_query("DELETE FROM ".TBL_CONTENT_FOLLOW." WHERE content_id={$content_id_value}");
				}
				if ( count($_a_query) && !empty($_a_query) ){
					$_a_insert = 'INSERT INTO '.TBL_CONTENT_FOLLOW.' (content_follow_id, content_id, site_id) VALUES '.implode(',', $_a_query);
					$database->db_query($_a_insert);
				}
			}

            // Info category content
            if ( count($content_category) ) {
                $sql = array();
                if ( !$db_insert_id ){
                    // Delete old
                    $delete = "DELETE FROM ".TBL_CONTENT_CATEGORY." WHERE content_id={$content_id_value}";
                    $database->db_query($delete);
                    foreach ($content_category as $catid) {
                        if ( $catid != $input['content_catid'] && $content_site_id )
                            $sql[] = '('.$content_id_value.', '.$catid.', '.$content_site_id.')';
                    }
                }else{
                    foreach ($content_category as $catid) {
                        if ( $catid != $input['content_catid'] && $content_site_id )
                            $sql[] = '('.$db_insert_id.', '.$catid.', '.$content_site_id.')';
                    }
                }
				if ( count($sql) ){
					$insert = 'INSERT INTO '.TBL_CONTENT_CATEGORY.' (content_id, category_id, site_id) VALUES '.implode(',', $sql);
					$database->db_query($insert);
				}
            }else if ( $content_id_value ){
                // Delete old
                $delete = "DELETE FROM ".TBL_CONTENT_CATEGORY." WHERE content_id={$content_id_value}";
                $database->db_query($delete);
            }

			// Keywords
			if ( is_array($aryKeyword) && count($aryKeyword) && !empty($aryKeyword) ){
				keyword_integrated($aryKeyword, ($content_id_value ? $content_id_value : $db_insert_id), 'content');
			}


            //img Album
            $list_image_album		= PGRequest::GetVar('list_image_album', '', 'POST');
            $input_photos['photo_images']	=ltrim($list_image_album,'|');
			if ( $input_photos['photo_images'] ){
				if ( !$content_id_value ){
					$input_photos['photo_content_id'] = $db_insert_id;
					$database->insert(TBL_PHOTO, $input_photos);
				}else{
					$database->delete(TBL_PHOTO, "photo_content_id=" . $content_id_value);
					$input_photos['photo_content_id'] = $content_id_value;
					$database->insert(TBL_PHOTO, $input_photos);
				}
			}
		}else{
			$message = $objContent->is_message;
		}

		// Submit DMCA, Submit for SEO
		if ( $content_status ){
			if ( $content_id_value )
				$link_submit = $thisContent->data['link'];
			else{
				$newContent = $objContent->loadItem(FALSE, $db_insert_id);
				$link_submit = $newContent->data['link'];
			}

			auto_call_dmca($link_submit);
			auto_submit_for_seo($link_submit);
		}

		if ( $setting['setting_tab_data'] ){
			require_once "admin_tab_form.php";
		}
        if ( $message ){
            $msg_text = ( $task == 'add' ? 'Thêm mới tin tức thành công!' : ($task == 'pending' ? 'Bài viết đã được chuyển sang chế độ chờ duyệt!' : 'Cập nhật tin tức thành công!'));
            PGError::set_message($msg_text);
        }else{
            $msg_text = 'Lỗi hệ thống! - ' . $database->db_error();
            PGError::set_error($msg_text);
        }
		if ( $task == 'save2add' || $task == 'save' || $task == 'pending' ){
			//đóng open khi content_id != 0
			if(!empty($content_id_value))
			{
				$objContent->Opening($content_id_value);
			}
		}
		if ( $task == 'saveonly' ){
			cheader($uri->base().'admin_content.php?task=edit&content_id=' . ($content_id_value ? $content_id_value : $db_insert_id ));
		}
        if ($task == 'save' || $task == 'pending'){
            /* Redirect to page list */
            cheader($uri->base().'admin_content.php?task=view'.($task == 'save' ? '&filter_catid='.$content_catid : ''));
        }else{
            cheader($uri->base().'admin_content.php?task=add');
        }
		break;

	case 'publish':
		$filter_catid 	= PGRequest::getCmd('filter_catid', 0);
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if (count($cid)) {
			$message = $objContent->published($cid, 1);
			PGError::set_message($message);
			cheader($uri->base().'admin_content.php?task=view&filter_catid='.$filter_catid);
		}
		break;

	case 'unpublish':
		$filter_catid 	= PGRequest::getCmd('filter_catid', 0);
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if (count($cid)) {
			$message = $objContent->published($cid, 0);
			PGError::set_message($message);
			cheader($uri->base().'admin_content.php?task=view&filter_catid='.$filter_catid);
		}
		break;

	case 'remove':
		$filter_catid 	= PGRequest::getCmd('filter_catid', 0);
		$cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
		if (count($cid)) {
			$message = $objContent->remove($cid);
			PGError::set_message($message);
			cheader($uri->base().'admin_content.php?task=view&filter_catid='.$filter_catid);
		}
		break;

    case 'view':
    case 'export':
	case 'sync':
	default :
		$page_title = "Quản lý nhóm tin";

		if ( $task == 'sync' && !$admin->admin_super ){
			PGError::set_error('Bạn không đủ quyền thực hiện chức năng này. Chỉ có SUPER ADMIN mới có quyền thực hiện chức năng này!');
			cheader($uri->base().'admin_content.php');
		}

		$filter_fulltext= PGRequest::getInt('filter_fulltext', 0, 'POST');
		$filter_status 	= PGRequest::getInt('filter_status', 1, 'POST');
		$filter_catid 	= PGRequest::getInt('filter_catid', 0, 'POST');
		if ( !$filter_catid ){
			$filter_catid 	= PGRequest::getInt('filter_catid', 0, 'GET');
		}
		$filter_site_id = PGRequest::getInt('filter_site_id', 0, 'POST');
		$filter_special = PGRequest::getInt('filter_special', 3, 'POST');
		$filter_hot		= PGRequest::getInt('filter_hot', 3, 'POST');
		$filter_admin_created = PGRequest::getInt('filter_admin_created', 0, 'POST');
		$datepicker 	= PGRequest::GetVar('date-range-picker', '', 'POST');
		$search 		= PGRequest::getString('search', '', 'POST');
		
		$p = PGRequest::getInt('p', 1, 'POST');
		$limit = PGRequest::getInt('limit', $setting['setting_list_limit'], 'POST');
		
		$option = $objCategory->getOptionItems($listCatItems, 0, $filter_catid, "");
		
		// FIELDS
		$fields[] = 'c.content_id';
		$fields[] = 'c.content_site_id';
		$fields[] = 'c.content_title';
		$fields[] = 'c.content_alias';
		$fields[] = 'c.content_created';
		$fields[] = 'c.content_created_by';
		$fields[] = 'c.content_modified';
		$fields[] = 'c.content_modified_by';
        $fields[] = 'c.content_timer';
		$fields[] = 'c.content_special';
		$fields[] = 'c.content_hot';
		$fields[] = 'c.content_hits';
		$fields[] = 'c.content_status';
		$fields[] = 'c.content_metakey';
		$fields[] = 'c.content_metakey_edit_count';
		$fields[] = 'c.content_opening';
		$fields[] = 'cat.category_name';
		$fields[] = 'cat.category_alias';
		$fields[] = 'cat.category_level';
		$fields[] = 'cat.category_id';

		if ( $filter_fulltext ){
			$fields[] = 'c.content_introtext';
			$fields[] = 'c.content_fulltext';
			$fields[] = 'c.content_metatitle';
			$fields[] = 'c.content_metakey';
			$fields[] = 'c.content_metadesc';
		}

		if ( $task == 'sync' ){
			$fields[] = 'c.content_image_thumbnail';
			$fields[] = 'c.content_image_large';
		}
		
		//CONDITION
		if ( !$filter_site_id ){
			if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
				$filter_site_id = $admin->admin_site_default['site_id'];
		}
		if ( $filter_site_id ){
			$where[] = "c.content_site_id=".$filter_site_id;
		}else{
			$where[] = "c.content_site_id IN (".implode(",", array_flip($sites)).")";
		}

		if ($search){
			if ( $filter_fulltext )
				$where[] = "(c.content_title LIKE'%$search%' OR c.content_introtext LIKE'%$search%' OR c.content_fulltext LIKE'%$search%' OR c.content_metatitle LIKE'%$search%' OR c.content_metakey LIKE'%$search%' OR c.content_metadesc LIKE'%$search%')";
			else
				$where[] = "c.content_title LIKE'%$search%'";
		}
		if ($filter_catid){
            $all_under_catid = $objCategory->get_all_whole_under_id($filter_catid);
            // Query list content_id follow category_id of table tbl_content_categories
            $_query = "SELECT content_id FROM ".TBL_CONTENT_CATEGORY." WHERE category_id=".$filter_catid . ($filter_site_id ? " AND site_id=".$filter_site_id : "");
            $_results = $database->db_query($_query);
            while ( $_row = $database->db_fetch_assoc($_results) ){
                $_listIds[] = $_row['content_id'];
            }
            if ( isset($_listIds) && $_listIds ){
                $where[] = "( c.content_catid IN(".implode(",", $all_under_catid).") OR c.content_id IN(".implode(",", $_listIds).") )";
            }else{
                $where[] = "c.content_catid IN(".implode(",", $all_under_catid).")";
            }
		}
		if ($filter_status == 0) {			
			$where[] = "c.content_status=0";
		}else if ($filter_status == 3){
			$where[] = "c.content_status>=0";			
		}else{
			$where[] = "c.content_status=".$filter_status;
		}
		if ($filter_hot == 0) {			
			$where[] = "c.content_hot=0";
		}else if ($filter_hot == 3){
			$where[] = "c.content_hot>=0";			
		}else{
			$where[] = "c.content_hot=".$filter_hot;
		}
		if ($filter_special == 0) {			
			$where[] = "c.content_special=0";
		}else if ($filter_special == 3){
			$where[] = "c.content_special>=0";			
		}else{
			$where[] = "c.content_special=".$filter_special;
		}
		if ( $filter_admin_created ){
			$where[] = "c.content_created_by=" . $filter_admin_created;
		}
		if ( $datepicker ){
			$aryDate = explode("-", $datepicker);
			if ( strtotime($aryDate[0]) == strtotime($aryDate[1]) ){
				$where[] = "UNIX_TIMESTAMP(c.content_created) >= ".strtotime($aryDate[0]);
			}else{
				$where[] = "UNIX_TIMESTAMP(c.content_created) >=".strtotime($aryDate[0]);
				$where[] = "UNIX_TIMESTAMP(c.content_created) <=".strtotime($aryDate[1]);
			}
		}
		$where = (count($where) ? ' WHERE '.implode(' AND ', $where) : '');
		$order = " ORDER BY c.content_ordering ASC, c.content_id DESC";
		// GET THE TOTAL NUMBER OF RECORDS
		$totalRecords = $objContent->TotalRecords($where);
		// PHAN TRANG
		$pager = new pager($limit, $totalRecords, $p);
		$offset = $pager->offset;
		// LAY DANH SACH CHI TIET
		$lsContent = $objContent->loadListItems($fields, $where, $order, $offset, $limit, ($filter_fulltext ? $search : false) );

		// get list admins
		$sql_join_admin = '';
		$where_join_admin = '';
		if ( $admin->admin_site_default['site_id'] ){
			$sql_join_admin = ' LEFT JOIN '.TBL_ADMIN_SITE.' AS asi ON a.admin_id = asi.admin_id';
			$where_join_admin = ' AND asi.site_id=' . $admin->admin_site_default['site_id'];
		}
		$query = 'SELECT a.admin_id, a.admin_name FROM '.TBL_ADMIN.' AS a '.$sql_join_admin.' WHERE a.admin_enabled=1' . ( $admin->admin_super ? "" : " AND a.admin_type=".$admin->admin_info['admin_type']) . $where_join_admin;
		$radmins = $database->db_query($query);
		while ($list = $database->db_fetch_assoc($radmins)){
			$list_admins[$list['admin_id']] = $list;
		}
		if ( isset($list_admins) && $list_admins ){
			$smarty->assign('list_admins', $list_admins);
		}

        if ( $task == 'export' ){
            $page_title = 'Export danh sách tin tức';

            require_once "../include/excel/Classes/PHPExcel/IOFactory.php";
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load("../include/excel/templates/list_link.xls");

            if ($totalRecords > 15000) {
                cheader($uri->base().$page.".php");
            }

            $baseRow = 6;
            foreach($lsContent as $r => $dataRow) {
                $row = $baseRow + $r;
                $objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $r+1);
                $objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $dataRow['content_title']);
                $objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $dataRow['link']);
            }
            $objPHPExcel->getActiveSheet()->removeRow($baseRow-1,1);

            $fileName = "danh_sach_bai_viet_".time().".xls";
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'. $fileName);
            header('Cache-Control: max-age=0');

            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
		if ( $task == 'sync' ){
			$path_dir = DIR_ROOT . 'images/'.$admin->admin_site_default['site_name'].'/';
			if(!is_dir($path_dir)){
				mkdir($path_dir, 0777, true);
			}

			$count_resize = 0;
			foreach($lsContent as $r => $dataRow) {
				if ( isset($dataRow['content_image_thumbnail']) && $dataRow['content_image_thumbnail'] ){
					$url_thumbnail = PG_URL_HOMEPAGE . 'images/contents/' . $dataRow['content_image_thumbnail'];

					$path_info = pathinfo($url_thumbnail);
					$set_name = $path_info['basename'];
					$director_path = pathinfo($path_info['dirname']);
					$set_path = $director_path['basename'];

					// Save Image from url to domain
					$dir_file_save = $path_dir . $set_name;
					file_put_contents($dir_file_save, file_get_contents($url_thumbnail));

					if ( resize_image_from_url_and_save($url_thumbnail, $set_name, $set_path, false, false) )
						$count_resize++;
				}
				if ( isset($dataRow['content_image_large']) && $dataRow['content_image_large'] ) {
					$url_large = PG_URL_HOMEPAGE . 'images/contents/' . $dataRow['content_image_large'];

					$path_info = pathinfo($url_large);
					$set_name = $path_info['basename'];
					$director_path = pathinfo($path_info['dirname']);
					$set_path = $director_path['basename'];

					// Save Image from url to domain
					$dir_file_save = $path_dir . $set_name;
					file_put_contents($dir_file_save, file_get_contents($url_large));

					if ( resize_image_from_url_and_save($url_large, $set_name, $set_path, false, false) )
						$count_resize++;
				}
			}
			PGError::set_message('Resize thành công <b style="color:red;">'.$count_resize.'</b> ảnh!');
			cheader($uri->base().'admin_content.php');
		}


		$smarty->assign('admin_super', $admin->admin_super);
		$smarty->assign('admin_id', $admin->admin_info['admin_id']);
		$smarty->assign('filter_fulltext', $filter_fulltext);
		$smarty->assign('filter_status', $filter_status);
		$smarty->assign('filter_catid', $filter_catid);
		$smarty->assign('filter_site_id', $filter_site_id);
		$smarty->assign('filter_special', $filter_special);
		$smarty->assign('filter_hot', $filter_hot);
		$smarty->assign('filter_admin_created', $filter_admin_created);
		$smarty->assign('datepicker', $datepicker);
		$smarty->assign('search', $search);
		$smarty->assign('datapage', $pager->page_link());
		$smarty->assign('limit', $limit);
		$smarty->assign('p', $p);
		$smarty->assign('lsContent', $lsContent);
		$smarty->assign('option', $option);
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
	$toolbar = createToolbarAce('pending', 'saveonly' , 'save2add', 'save', 'cancel');
} elseif ($task == 'change') {
	$toolbar = createToolbarAce('save', 'cancel');
}

include "admin_footer.php";
?>