<?php
$page = "admin_report_user";
include "admin_header.php";
include "include/develops/class_content.php";

$page_title = "Thống kê nội dung";

include "include/develops/class_export_excel.php";

/*
 * GOI AJAX
include "include/services/gapi-google-analytics/gapi.class.php";
$ga = new gapi($setting['setting_ga_account'], $setting['setting_ga_password']);
$ga_profile_id = intval($setting['setting_ga_profile_id']);

if ( $ga_profile_id ){
    $filter = 'country == United States && browser == Firefox || browser == Chrome';

    $ga->requestReportData($ga_profile_id,array('browser','browserVersion'),array('pageviews','visits'),'-visits',$filter);
    $smarty->assign('ga', $ga);
}
*/

$exportExcel = new PGExportExcel();
$objContent = new PGContent();

$task = PGRequest::GetCmd('task', 'view');
if ($task == 'cancel') $task = 'view';

$objAcl = new PGAcl();
if (!$objAcl->checkPermission($page, $task)) {
    $objAcl->showErrorPage($smarty);
}

// LẤY TẤT CẢ DANH SÁCH CATEGORY
$filter_site_id = PGRequest::getInt('filter_site_id', 0, 'POST');
if ( !$filter_site_id ){
    if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
        $filter_site_id = $admin->admin_site_default['site_id'];
}

switch($task){
    case 'view' :
        $page_title = "Quản lý nhóm tin";

        $filter_site_id = PGRequest::getInt('filter_site_id', $admin->admin_site_default['site_id'], 'POST');
        $filter_admin_created = PGRequest::getInt('filter_admin_created', 0, 'POST');
        $datepicker 	= PGRequest::GetVar('date-range-picker', '', 'POST');

        $p = PGRequest::getInt('p', 1, 'POST');
        $limit = PGRequest::getInt('limit', 20, 'POST');

        //CONDITION
        if ( !$filter_site_id ){
            if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
                $filter_site_id = $admin->admin_site_default['site_id'];

        }
        if ( $filter_site_id ){
            $where1[] = " admin_site_default =".$filter_site_id;
            $where[] = " content_site_id   = ".$filter_site_id;
        }else{
            $where[] = " admin_site_default IN (".implode(",", array_flip($sites)).")";
        }

        if ( $filter_admin_created ){
            $where[] = " content_created_by   = ".$filter_admin_created;
        }

        if ( $datepicker ){
            $aryDate = explode("-", $datepicker);
            if ( strtotime($aryDate[0]) == strtotime($aryDate[1]) ){
                $where[] = "UNIX_TIMESTAMP(content_created) >= ".strtotime($aryDate[0]);
            }else{
                $where[] = "UNIX_TIMESTAMP(content_created) >=".strtotime($aryDate[0]);
                $where[] = "UNIX_TIMESTAMP(content_created) <=".strtotime($aryDate[1]);
            }
        }
        $where = (count($where) ? ' WHERE '.implode(' AND ', $where) : '');
        $where1 = (count($where1) ? ' WHERE '.implode(' AND ', $where1) : '');
        //echo $where1; die;
        $order = " ORDER BY content_id DESC";

        /*----------------Report----------------------*/
        // Total Cate
        $_cate_query = "SELECT COUNT(*) AS total FROM ".TBL_CATEGORY." WHERE category_status=1 AND category_site_id = " . $filter_site_id;
        $_cate_results = $database->db_fetch_assoc($database->db_query($_cate_query));
        $smarty->assign('total_cates', $_cate_results['total']);

        // Total Tags
        $_tag_query = "SELECT COUNT(*) AS total FROM ".TBL_TAG." WHERE tag_status=1 AND tag_site_id = " . $filter_site_id;
        $_tag_results = $database->db_fetch_assoc($database->db_query($_tag_query));
        $smarty->assign('total_tags', $_tag_results['total']);

        // Total static
        $_static_query = "SELECT COUNT(*) AS total FROM ".TBL_STATIC." WHERE static_status=1 AND static_site_id = " . $filter_site_id;
        $_static_results = $database->db_fetch_assoc($database->db_query($_static_query));
        $smarty->assign('total_statics', $_static_results['total']);

        // Total custom
        $_custom_query = "SELECT COUNT(*) AS total FROM ".TBL_CUSTOM." WHERE custom_status=1 AND custom_site_id = " . $filter_site_id;
        $_custom_results = $database->db_fetch_assoc($database->db_query($_custom_query));
        $smarty->assign('total_customs', $_custom_results['total']);

        // Total Admin
        $query = "SELECT COUNT(*) AS total FROM ".TBL_ADMIN." $where1";
        $results = $database->db_fetch_assoc($database->db_query($query));
        $smarty->assign('total_admins', $results['total']);

        $query = 'SELECT admin_id, admin_name FROM '.TBL_ADMIN.$where1.' AND admin_enabled=1 ' . ( $admin->admin_super ? "" : " AND admin_type >=".$admin->admin_info['admin_type']);
        $radmins = $database->db_query($query);
        while ($list = $database->db_fetch_assoc($radmins)){
            $list_admins[$list['admin_id']] = $list;
        }
        if ( isset($list_admins) && $list_admins ){
            $smarty->assign('list_admins', $list_admins);
        }

        // Total content
        $queryc = 'SELECT  COUNT(*) AS total FROM '.TBL_CONTENT.$where;
        $totalc = $database->db_fetch_assoc($database->db_query($queryc));
        // PHAN TRANG
        $pager = new pager($limit, $totalc['total'], $p);
        $offset = $pager->offset;

        //Total active content
        $queryc = 'SELECT  COUNT(*) AS total FROM '.TBL_CONTENT.$where.' AND content_status=1';
        $c_active = $database->db_fetch_assoc($database->db_query($queryc));

        // Total disable content
        $queryuc = 'SELECT  COUNT(*) AS total FROM '.TBL_CONTENT.$where.' AND content_status=0';
        $c_disable = $database->db_fetch_assoc($database->db_query($queryuc));

        // List Contents
        $cquery = 'SELECT content_id,content_title,content_alias,content_created,content_created_by,content_status FROM '.TBL_CONTENT.$where.$order.' LIMIT '.$offset.',' . $limit;

        $ls = $database->db_query($cquery);
        while ($list = $database->db_fetch_assoc($ls)){
            $list['name_created'] = isset($list_admins[$list['content_created_by']])?$list_admins[$list['content_created_by']]['admin_name']:'Khác';
            $lsContent[] = $list;

        }
        if ( isset($lsContent) && !empty($lsContent) ){
            $smarty->assign('lsContent', $lsContent);
        }

        // Get all Admin in site
        $list_admins = $admin->get_admin_in_sites();
        //print_r($list_admins); die;
        if ( isset($list_admins) && $list_admins ){
            $smarty->assign('list_admins', $list_admins);
        }


        $_pt_show_content = intval(($c_active['total'] * 100)/$totalc['total']);
        $_pt_show_disable = intval(($c_disable['total'] * 100)/$totalc['total']);
        $_pt_show_pending = (100 - $_pt_show_content) - $_pt_show_disable;

        $smarty->assign('admin_id', $admin->admin_info['admin_id']);
        $smarty->assign('filter_site_id', $filter_site_id);
        $smarty->assign('filter_admin_created', $filter_admin_created);
        $smarty->assign('datepicker', $datepicker);
        $smarty->assign('datapage', $pager->page_link());
        $smarty->assign('total_contents', $totalc['total']);
        $smarty->assign('total_contents_active', $c_active['total']);
        $smarty->assign('total_contents_disable', $c_disable['total']);
        $smarty->assign('total_contents_pedding', (($totalc['total'] - $c_active['total']) -  $c_disable['total']));
        $smarty->assign('_pt_show_content', $_pt_show_content);
        $smarty->assign('_pt_show_disable', $_pt_show_disable);
        $smarty->assign('_pt_show_pending', $_pt_show_pending);
        $smarty->assign('limit', $limit);
        $smarty->assign('p', $p);
        $smarty->assign('option', $option);
        break;

    case 'export':
        $filter_site_id = PGRequest::getInt('filter_site_id', $admin->admin_site_default['site_id'], 'POST');
        $filter_admin_created = PGRequest::getInt('filter_admin_created', 0, 'POST');
        $datepicker 	= PGRequest::GetVar('date-range-picker', '', 'POST');

        $p = PGRequest::getInt('p', 1, 'POST');
        $limit = PGRequest::getInt('limit', $setting['setting_list_limit'], 'POST');

        //CONDITION
        if ( !$filter_site_id ){
            if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
                $filter_site_id = $admin->admin_site_default['site_id'];

        }
        if ( $filter_site_id ){
            $where1[] = " admin_site_default =".$filter_site_id;
            $where[] = " content_site_id   = ".$filter_site_id;
        }else{
            $where[] = " admin_site_default IN (".implode(",", array_flip($sites)).")";
        }

        if ( $filter_admin_created ){
            $where[] = " content_created_by = ".$filter_admin_created;
        }

        if ( $datepicker ){
            $aryDate = explode("-", $datepicker);
            if ( strtotime($aryDate[0]) == strtotime($aryDate[1]) ){
                $where[] = "UNIX_TIMESTAMP(content_created) >= ".strtotime($aryDate[0]);
            }else{
                $where[] = "UNIX_TIMESTAMP(content_created) >=".strtotime($aryDate[0]);
                $where[] = "UNIX_TIMESTAMP(content_created) <=".strtotime($aryDate[1]);
            }
        }
        $where = (count($where) ? ' WHERE '.implode(' AND ', $where) : '');
        $where1 = (count($where1) ? ' WHERE '.implode(' AND ', $where1) : '');
        $order = " ORDER BY content_id DESC";

        /*----------------Report----------------------*/
        // Total Report Admins
        $query = "SELECT COUNT(*) AS total FROM ".TBL_ADMIN." $where1";
        $results = $database->db_fetch_assoc($database->db_query($query));
        $total_report['admins'] = $results['total'];


        $query = 'SELECT admin_id, admin_name FROM '.TBL_ADMIN.$where1.' AND admin_enabled=1 ' . ( $admin->admin_super ? "" : " AND admin_type >=".$admin->admin_info['admin_type']);
        $radmins = $database->db_query($query);
        while ($list = $database->db_fetch_assoc($radmins)){
            $list_admins[$list['admin_id']] = $list;
        }

        $total_report['admins_active']  = count($list_admins);
        $total_report['admins_hide']    = $total_report['admins'] - $results['total'];

        // Total Report content
        $queryc = 'SELECT  COUNT(*) AS total FROM '.TBL_CONTENT.$where;
        $totalc = $database->db_fetch_assoc($database->db_query($queryc));
        $total_report['contents']  = $totalc['total'];

        // Total active content
        $queryc = 'SELECT  COUNT(*) AS total FROM '.TBL_CONTENT.$where.' AND content_status=1';
        $c_active = $database->db_fetch_assoc($database->db_query($queryc));
        $total_report['contents_active']  = $c_active['total'];
        $total_report['contents_hide']    = $total_report['contents'] - $total_report['contents_active'];

        // List Contents
        $cquery = 'SELECT content_id,content_site_id,content_title,content_alias,content_created,content_created_by,content_status FROM '.TBL_CONTENT.$where.$order;
        $ls = $database->db_query($cquery);
        while ($list = $database->db_fetch_assoc($ls)){
        $list['site_name'] = $sites[$list['content_site_id']];
        $list['name_created'] = isset($list_admins[$list['content_created_by']])?$list_admins[$list['content_created_by']]['admin_name']:'Khác';
        $lsContent[] = $list;

        }
        if ( isset($lsContent) && !empty($lsContent) ){
            $exportExcel->data_acounts_to_excel($lsContent,$total_report, 'report_user','Thong_ke_noi_dung');
            $task = 'view';
        }
        break;
}
$smarty->assign('sites', $sites);
//create toolbar buttons
if ($task == 'view' || !$task) {
    $toolbar = createToolbarAce('export');
}
include "admin_footer.php";
?>