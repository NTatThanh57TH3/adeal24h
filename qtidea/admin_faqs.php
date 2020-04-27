<?php
/**
 * Created by PhpStorm.
 * User: Kiều Văn Ngọc
 * Date: 2/29/2016
 * Time: 1:15 PM
 */
$page = "admin_faqs";
$page_title = "Quản lý hỏi đáp";
include "admin_header.php";

$task = PGRequest::GetCmd('task', 'view');
if ($task == 'cancel') $task = 'view';
$objAcl = new PGAcl();
if (!$objAcl->checkPermission($page, $task)) {
    $objAcl->showErrorPage($smarty);
}

switch ($task) {
    case 'add':
    case 'edit':
        if ($task == 'edit') $page_title = "Cập nhật hỏi đáp";
        else $page_title = "Thêm mới hỏi đáp";

        $id = PGRequest::GetInt('answer_id', 0, 'GET');

        $sql = 'SELECT * FROM ' . TBL_ANSWER . ' WHERE answer_id=' . $id . ' LIMIT 1';
        $result = $database->db_query($sql);
        if ($row = $database->db_fetch_assoc($result)) {
            $item->data = $row;
        }

        $smarty->assign('id', $id);
        $smarty->assign('item', $item);
        break;

    case 'save':
        $id = PGRequest::getInt('id', 0, 'POST');
        $input_answer['id'] = $id;

        $input_answer['answer_site_id'] = PGRequest::getInt('answer_site_id', 0, 'POST');
        if ( is_array($admin->admin_site_default) && isset($admin->admin_site_default['site_id']) && $admin->admin_site_default['site_id'] )
            $input_answer['answer_site_id'] = $admin->admin_site_default['site_id'];

        $input_answer['answer_question'] = trim(PGRequest::getVar('answer_question', '', 'POST'));
        $input_answer['answer_reply'] = $filter->_decode(PGRequest::getVar('answer_reply', '', 'post', 'string', PGREQUEST_ALLOWRAW ));
        $input_answer['answer_ordering'] = PGRequest::getInt('answer_ordering', 0, 'POST');
        $input_answer['answer_status'] = PGRequest::getInt('answer_status', 0, 'POST');

        $input_answer['answer_fullname'] = $database->getEscaped(PGRequest::getString('answer_fullname', '', 'POST'));
        $input_answer['answer_email'] = $database->getEscaped(PGRequest::getString('answer_email', '', 'POST'));
        $input_answer['answer_mobile'] = $database->getEscaped(PGRequest::getString('answer_mobile', '', 'POST'));

        // Submmit and check error
        $aryOutput = array();
        $aryOutput['intOK'] = 1;


        //THUC HIEN CHECK THONG TIN INPUT
        $isUpdate = ($id ? true : false);
        $aryError = array();

        if($input_answer['answer_question']==''){
            array_push($aryError,'Bạn vui lòng nhập vào câu hỏi!');
        }else if(strlen($input_answer['answer_question'])<6){
            array_push($aryError,'Câu hỏi phải ít nhất là 6 ký tự!');
        }

        if (empty($aryError)) {
            // Update
            if ($isUpdate) {
                $old_reply = '';
                $_query = "SELECT answer_reply FROM ".TBL_ANSWER." WHERE answer_id=" . $id;
                $_result = $database->db_query($_query);
                if ( $_row = $database->db_fetch_assoc($_result) ){
                    $old_reply = $_row['answer_reply'];
                }

                unset($input_answer['id']);
                if ( $input_answer['answer_reply'] && $old_reply && ($input_answer['answer_reply'] !== $old_reply ) ){
                    $input_answer['answer_reply_time'] = $datetime->timestampToDateTime();
                    $input_answer['answer_modified_by'] = $admin->admin_info['admin_id'];
                }
                if (!$database->update(TBL_ANSWER, $input_answer, "answer_id={$id}")) {
                    $aryOutput['strError'] = "Lỗi hệ thống";
                    $aryOutput['intOK'] = 0;
                }
            } else { // Insert
                unset($input_answer['id']);
                $input_answer['answer_question_time'] = $datetime->timestampToDateTime();
                if ( $input_answer['answer_reply'] ){
                    $input_answer['answer_reply_time'] = $datetime->timestampToDateTime();
                }
                $input_answer['answer_created_by'] = $admin->admin_info['admin_id'];
                if (!$uid = $database->insert(TBL_ANSWER, $input_answer)) {
                    $aryOutput['strError'] = "Lỗi hệ thống";
                    $aryOutput['intOK'] = 0;
                }
            }
            PGError::set_message(($id ? 'Cập nhật' : 'Thêm mới') . ' câu hỏi thành công!');
        } else {
            $aryOutput['strError'] = (is_array($aryError)) ? join("<br>", $aryError) : "";
            $aryOutput['intOK'] = 0;
        }
        echo json_encode($aryOutput);
        exit();
        break;

    case 'publish':
        $cid = PGRequest::getVar('cid', array(), 'post', 'array');
        if (count($cid)) {
            if (!is_array($cid)) {
                $message = 'Tham số truyền vào không tồn tại!';
            } else {
                $total = count($cid);
                if ($total < 1) {
                    echo "<script> alert('Lựa chọn ít nhất một câu hỏi để kích hoạt!'); window.history.go(-1);</script>\n";
                    exit;
                }
                mosArrayToInts($cid);
                $cids = 'answer_id=' . implode(' OR answer_id=', $cid);
                $sql = "UPDATE ".TBL_ANSWER." SET answer_status=1, answer_reply_time='".$datetime->timestampToDateTime()."' WHERE ( $cids )";
                $database->db_query($sql);
                $message = 'Tổng số ' . $total . ' câu hỏi được kích hoạt!';
            }
            PGError::set_message($message);
            cheader($uri->base() . $page . '.php');
        }
        break;
    case 'unpublish':
        $cid = PGRequest::getVar('cid', array(), 'post', 'array');
        if (count($cid)) {
            if (!is_array($cid)) {
                $message = 'Tham số truyền vào không tồn tại!';
            } else {
                $total = count($cid);
                if ($total < 1) {
                    echo "<script> alert('Lựa chọn ít nhất một câu hỏi để ẩn!'); window.history.go(-1);</script>\n";
                    exit;
                }
                mosArrayToInts($cid);
                $cids = 'answer_id=' . implode(' OR answer_id=', $cid);
                $sql = "UPDATE ".TBL_ANSWER." SET answer_status=0, answer_reply_time='".$datetime->timestampToDateTime()."' WHERE ( $cids )";
                $database->db_query($sql);
                $message = 'Tổng số ' . $total . ' câu hỏi được ẩn!';
            }
            PGError::set_message($message);
            cheader($uri->base() . $page . '.php');
        }
        break;
    case 'remove':
        $cid = PGRequest::getVar('cid', array(), 'post', 'array');
        if (count($cid)) {
            if (!is_array($cid)) {
                $message = 'Tham số truyền vào không tồn tại!';
            } else {
                $total = count($cid);
                if ($total < 1) {
                    echo "<script> alert('Lựa chọn một câu hỏi  để xóa!'); window.history.go(-1);</script>\n";
                    exit;
                }
                mosArrayToInts($cid);
                $cids = 'answer_id=' . implode(' OR answer_id=', $cid);
                $sql = "DELETE FROM " . TBL_ANSWER . " WHERE ( $cids )";
                $database->db_query($sql);
                $message = 'Đã xóa ' . $total . ' câu hỏi thành công!';
            }
            PGError::set_message($message);
            cheader($uri->base() . $page . '.php');
        }
        break;
    case 'view':
    default:
        $page_title = "Danh sách các câu hỏi";

        $p = PGRequest::getInt('p', 1, 'POST');
        $limit = PGRequest::getInt('limit', $setting['setting_list_limit'], 'POST');

        require_once('admin_filter_faqs.php');

        // GET THE TOTAL NUMBER OF RECORDS
        $query = 'SELECT COUNT(*) AS total FROM ' . TBL_ANSWER . $where;
        $results = $database->db_fetch_assoc($database->db_query($query));
        $totalRecords = $results['total'];

        // PHAN TRANG
        $pager = new pager($limit, $totalRecords, $p);
        $offset = $pager->offset;

        $query = 'SELECT * FROM ' . TBL_ANSWER . $where . ' ORDER BY answer_question_time DESC LIMIT ' . $offset . ',' . $limit;
        $results = $database->db_query($query);
        while ($row = $database->db_fetch_assoc($results)) {
            $list[] = $row;
        }

        // ASSIGN AVAILABLES
        if (isset($list) && $list) {
            $smarty->assign('list', $list);
        }
        $smarty->assign('totalRecords', $totalRecords);
        $smarty->assign('datapage', $pager->page_link());
        $smarty->assign('p', $p);
        break;
}

$smarty->assign('sites', $sites);
//create toolbar buttons
if ($task == 'view' || !$task) {
    $toolbar = createToolbarAce('add', 'edit', 'publish', 'unpublish', 'remove');
} elseif ($task == 'add' || $task == 'edit') {
    $toolbar = createToolbarAce('save', 'cancel');
}

include "admin_footer.php";
?>