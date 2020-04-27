<?php
/**
 * Created by PhpStorm.
 * User: Ngọc Kiều
 * Date: 11/3/2016
 * Time: 10:27 AM
 */
$page = "admin_cache";
include "admin_header.php";

$task = PGRequest::getCmd('task', 'view');
$page_title = "Quản lý cache lưu trữ";
if ($task=='cancel') $task='view';

$objAcl = new PGAcl();
if (!$objAcl->checkPermission($page, $task)) {
    $objAcl->showErrorPage($smarty);
}

if ( !$admin->admin_super ){
    PGError::set_error('Bạn không đủ thẩm quyền để truy cập trang này!');
    cheader($uri->base().'admin_quiz.php');
}

switch ( $task ){
    case 'remove':
        $cid = PGRequest::getVar( 'cid', array(), 'post', 'array' );
        if (count($cid)) {
            foreach ($cid as $item){
                if ( !CacheLib::delete($item) ){
                    PGError::set_error('Không thể xóa key cache: '.$item);
                    cheader($uri->base().$page.'.php');
                }
            }
            PGError::set_message('Xóa '.count($cid).' key cache thành công!');
            cheader($uri->base().$page.'.php');
        }
        break;

    case 'view':
    default:
        $search = $database->getEscaped(PGRequest::getString('search', '', 'POST'));

        if ( $search ){
            $dataCache = CacheLib::getKeys($search);
        }else{
            $dataCache = CacheLib::getAllKeys();
        }

        $smarty->assign('search', $search);
        $smarty->assign('list', $dataCache);
        break;
}

$toolbar = createToolbarAce('remove');
include "admin_footer.php";