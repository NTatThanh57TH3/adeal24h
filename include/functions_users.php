<?php
/**
 * Created by PhpStorm.
 * User: Ngọc Kiều
 * Date: 3/9/2016
 * Time: 3:28 PM
 */
define('_CHECK_INFO_USER', 0);

function check_user_input($input, $isUpdate=false, $account_type) {
    global $database;

    if ($account_type == SET_VALUE_GIAO_VIEN)
        $table_name = TBL_GIAO_VIEN;
    else if ($account_type == SET_VALUE_PHU_HUYNH)
        $table_name = TBL_PHU_HUYNH;
    else if ($account_type == SET_VALUE_HOC_SINH)
        $table_name = TBL_HOC_SINH;

    if ( !$isUpdate ){
        if ($account_type == SET_VALUE_GIAO_VIEN){
            if ($input['ma_giao_vien'] == '') {
                $aryError[] = 'Mã giáo viên vui lòng không để trống!';
            }else{
                $sql = "SELECT id FROM ".$table_name." WHERE ma_giao_vien='{$input['ma_giao_vien']}'";
                if ($isUpdate) {
                    $sql .= " AND id <>".$input['id'];
                }
                if ($database->db_num_rows($database->db_query($sql))) {
                    $aryError[] = 'Mã giáo viên: '.$input['ma_giao_vien'].' đã tồn tại trong hệ thống. Vui lòng chọn 1 mã khác!';
                }
            }
        }

        if ($account_type == SET_VALUE_HOC_SINH){
            if ($input['lop_key_index'] == '') {
                $aryError[] = 'Vui lòng lựa chọn lớp học cho học sinh!';
            }
            if ($input['ma_phu_huynh'] == '') {
                $aryError[] = 'Mã phụ huynh vui lòng không để trống và là dạng số điện thoại!';
            }else{
                $validate = new PGValidation();
                if ( !$validate->isMobile($input['ma_phu_huynh'])){
                    $aryError[] = 'Mã phụ huynh không đúng định dạng số điện thoại di động!';
                }
            }
            if ($input['ma_hoc_sinh'] == '') {
                $aryError[] = 'Mã học sinh vui lòng không để trống!';
            }else{
                $sql = "SELECT id FROM ".$table_name." WHERE ma_hoc_sinh='{$input['ma_hoc_sinh']}'";
                if ($isUpdate) {
                    $sql .= " AND id <>".$input['id'];
                }
                if ($database->db_num_rows($database->db_query($sql))) {
                    $aryError[] = 'Mã học sinh: '.$input['ma_hoc_sinh'].' đã tồn tại trong hệ thống. Vui lòng chọn 1 mã khác!';
                }
            }
        }

        //CHECK INFO LOGIN
        if ( strlen($input['ten_dang_nhap']) < 4 ){
            $aryError[] = 'Tên đăng nhập ít nhất phải 4 ký tự!';
        }else{
            $sql = "SELECT id FROM ".$table_name." WHERE ten_dang_nhap='{$input['ten_dang_nhap']}'";
            if ($isUpdate) {
                $sql .= " AND id <>".$input['id'];
            }
            if ($database->db_num_rows($database->db_query($sql))) {
                $aryError[] = 'Tên đăng nhập: '.$input['ten_dang_nhap'].' đã tồn tại trong hệ thống. Vui lòng chọn 1 tên đăng nhập khác!';
            }
        }
    }

    if ( $isUpdate ){
        if ($account_type == SET_VALUE_HOC_SINH){
            if ($input['lop_key_index'] == '') {
                $aryError[] = 'Vui lòng lựa chọn lớp học cho học sinh!';
            }
            if ($input['ma_phu_huynh'] == '') {
                $aryError[] = 'Mã phụ huynh vui lòng không để trống và là dạng số điện thoại!';
            }else{
                $validate = new PGValidation();
                if ( !$validate->isMobile($input['ma_phu_huynh'])){
                    $aryError[] = 'Mã phụ huynh không đúng định dạng số điện thoại di động!';
                }
            }
        }
    }

    //CHECK PASSWORDS
    if ( !$isUpdate && strlen($input['password']) < 4 ) {
        $aryError[] = 'Mật khẩu đăng nhập ít nhất phải 4 ký tự!';
    }
    //CHECK TÊN HIỂN THỊ
    if (strlen($input['ten_hien_thi']) < 6) {
        $aryError[] = 'Họ tên phải ít nhất 6 ký tự!';
    }
    //CHECK MOBILE
    if ($account_type != SET_VALUE_HOC_SINH){
        if (strlen($input['phone']) == '') {
            $aryError[] = 'Vui lòng nhập số điện thoại liên hệ của bạn!';
        }else{
            $validate = new PGValidation();
            if ( !$validate->isMobile($input['phone'])){
                $aryError[] = 'Không đúng định dạng số điện thoại di động!';
            }
        }
    }

    if ( _CHECK_INFO_USER ){
        //CHECK EMAIL
        if ($input['email'] == '') {
            $aryError[] = 'Vui lòng nhập địa chỉ email!';
        }
        else if ($input['email'] !='') {
            if (!PGValidation::isEmail($input['email'])) {
                $aryError[] = 'Địa chỉ email không đúng định dạng!';
            }
            else {
                $email = strtolower($input['email']);
                $sql = "SELECT id FROM ".$table_name." WHERE LOWER(email)='{$email}'";
                if ($isUpdate) {
                    $sql .= " AND id <>".$input['id'];
                }
                if ($database->db_num_rows($database->db_query($sql))) {
                    $aryError[] = 'Địa chỉ email này đã có trong hệ thống. Vui lòng chọn 1 email khác!';
                }
            }
        }
        //CHECK ADDRESS
        if (trim($input['dia_chi']) == '' || (int)$input['ma_huyen'] == 0 || (int)$input['ma_tinh'] == 0) {
            $aryError[] = 'Địa chỉ, Quận/Huyện/Thị xã, Tỉnh/Thành phố phải có';
        }
    }

    if ( $aryError && count($aryError) ){
        return $aryError;
    }
    return false;
}

/**
 * Remove users
 */
function remove($account_type, $cid = null){
    global $database;

    if ($account_type == SET_VALUE_GIAO_VIEN){
        $table_name = TBL_GIAO_VIEN;
        $text = 'giáo viên';
    }else if ($account_type == SET_VALUE_PHU_HUYNH){
        $table_name = TBL_PHU_HUYNH;
        $text = 'phụ huynh';
    }else if ($account_type == SET_VALUE_HOC_SINH){
        $table_name = TBL_HOC_SINH;
        $text = 'học sinh';
    }

    if (!is_array($cid)){
        $is_message = 'Tham số truyền vào không tồn tại!';
    }else{
        $total = count( $cid );
        if ( $total < 1) {
            echo "<script> alert('Lựa chọn một tài khoản '.$text.' để xóa!'); window.history.go(-1);</script>\n";
            exit;
        }
        mosArrayToInts( $cid );
        $cids = 'id=' . implode( ' OR id=', $cid );
        $sql = "DELETE FROM ".$table_name." WHERE ( $cids )";
        $database->db_query($sql);

        $is_message = 'Đã xóa '.$total.' tài khoản '.$text.' thành công!';
    }

    return $is_message;
}

/*
 * Publish and unpublish users
 */
function published($account_type, $cid, $published = 0){
    global $database, $datetime;

    if ($account_type == SET_VALUE_GIAO_VIEN){
        $table_name = TBL_GIAO_VIEN;
        $text = 'giáo viên';
    }else if ($account_type == SET_VALUE_PHU_HUYNH){
        $table_name = TBL_PHU_HUYNH;
        $text = 'phụ huynh';
    }else if ($account_type == SET_VALUE_HOC_SINH){
        $table_name = TBL_HOC_SINH;
        $text = 'học sinh';
    }

    if (count( $cid ) < 1) {
        $action = $published == 1 ? 'Mở khóa' : 'Khóa';
        echo "<script> alert('Chọn một tài khoản '.$text.' để $action'); window.history.go(-1);</script>\n";
        exit;
    }

    mosArrayToInts( $cid );
    $total = count ( $cid );
    $cids = 'id=' . implode( ' OR id=', $cid );

    $database->db_query("UPDATE ".$table_name." SET status=".(int) $published.", last_update='".$datetime->timestampToDateTime()."' WHERE ( $cids )");

    switch ( $published ) {
        case 1:
            $is_message = $total .' tài khoản '.$text.' đã mở khóa thành công!';
            break;

        case 0:
        default:
            $is_message = $total .' tài khoản '.$text.' đã bị khóa thành công!';
            break;
    }

    return $is_message;
}

/*
 * Publish and unpublish data table
 */
function table_published($table_name, $cid, $published = 0){
    global $database;

    if (count( $cid ) < 1) {
        $action = $published == 1 ? 'Mở khóa' : 'Khóa';
        echo "<script> alert('Chọn một dữ liệu đầu vào để $action'); window.history.go(-1);</script>\n";
        exit;
    }

    mosArrayToInts( $cid );
    $total = count ( $cid );
    $cids = 'id=' . implode( ' OR id=', $cid );

    $database->db_query("UPDATE ".$table_name." SET status=".(int) $published." WHERE ( $cids )");

    switch ( $published ) {
        case 1:
            $is_message = $total .' dữ liệu đã mở khóa thành công!';
            break;

        case 0:
        default:
            $is_message = $total .' dữ liệu đã bị khóa thành công!';
            break;
    }

    return $is_message;
}

function table_remove($table_name, $cid = null){
    global $database;

    if (!is_array($cid)){
        $is_message = 'Tham số truyền vào không tồn tại!';
    }else{
        $total = count( $cid );
        if ( $total < 1) {
            echo "<script> alert('Lựa chọn một bản ghi để xóa!'); window.history.go(-1);</script>\n";
            exit;
        }
        mosArrayToInts( $cid );
        $cids = 'id=' . implode( ' OR id=', $cid );
        $sql = "DELETE FROM ".$table_name." WHERE ( $cids )";
        $database->db_query($sql);

        $is_message = 'Đã xóa '.$total.' bản ghi thành công!';
    }

    return $is_message;
}

/**
 * Get access_data of nha_truog
 */
function nt_get_access_data( $id ){
    global $database;

    if ( !$id ) return false;

    $sql = 'SELECT access_data FROM '.TBL_NHA_TRUONG.' WHERE id=' . $id . ' LIMIT 1';
    $result = $database->db_query($sql);
    if ( $row = $database->db_fetch_assoc($result) ){
        if ( is_null($row['access_data']) || $row['access_data'] == null || $row['access_data'] == 'null' )
            return false;
        else
            return $row['access_data'];
    }else
        return false;
}