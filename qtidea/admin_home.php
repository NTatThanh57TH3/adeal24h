<?php
$page = "admin_home";
$page_title = "Trang chủ";
include "admin_header.php";

$task = PGRequest::getCmd('task','view');

$task = PGRequest::GetCmd('task', 'view');
if ($task == 'cancel') $task = 'view';

//$objAcl = new PGAcl();
//if (!$objAcl->checkPermission($page, $task)) {
//    $objAcl->showErrorPage($smarty);
//}

/*
$sql = "select partner_id, partner_start_date, partner_end_date from tbl_partners where partner_special = 1";
$results = $database->db_query($sql);
while ( $row = $database->db_fetch_assoc($results) ){
    $start_date = strtotime($row['partner_start_date']);
    $end_date = strtotime($row['partner_end_date']);
    $_3_year_startdate = date('Y-m-d h:m:s', strtotime("+2 year", $start_date));
    $_3_year_enddate = date('Y-m-d h:m:s', strtotime("+2 year", $end_date));
    $database->db_query("update tbl_partners set partner_start_date = '{$_3_year_startdate}', partner_end_date = '{$_3_year_enddate}' where partner_id=".$row['partner_id']);
}
*/

if ( !$check_on_localhost ){
    $email = 'ngockv@gmail.com';
    $email_cc = array(
        'truonggiang.cp08@gmail.com'
    );

    $now = time();
    $date_sendmail = $datetime->timestampToDateTime();
    $date_sendmail_max = 0;

    // Check domain PBN expiration
    $sql = "SELECT domain_id, domain_name, domain_expiration_date, domain_time_send_mail_expiration FROM ".TBL_DOMAIN_PBN." WHERE (DATE(domain_expiration_date) <= NOW()) OR (DATE(domain_expiration_date) <= (NOW() + INTERVAL 1 MONTH)) ORDER BY domain_expiration_date, domain_name ASC";
    $results = $database->db_query($sql);
    while ( $row = $database->db_fetch_assoc($results) ){
        if ( !$row['domain_expiration_date'] || $row['domain_expiration_date'] == '0000-00-00 00:00:00' ){
            $row['domain_expiration_date'] = $datetime->timestampToDateTime();
        }
        $expiration_date = strtotime($row['domain_expiration_date']);
        $_30DAY_expiration_now = strtotime("+1 month", $now);
        if ( $expiration_date <= $now || ($_30DAY_expiration_now >= $expiration_date) ){
            $date1 = new DateTime(date('m/d/Y', $now));
            $date2 = new DateTime(date('m/d/Y', $expiration_date));
            $diff = $date1->diff($date2);
            $row['days'] = $diff->days;
            if ( $expiration_date <= $now ){
                $row['days'] = 0 - $row['days'];
            }
        }
        if (!is_null($row['domain_time_send_mail_expiration']) && (strtotime($row['domain_time_send_mail_expiration']) > $date_sendmail_max) ){
            $date_sendmail_max = $row['domain_time_send_mail_expiration'];
        }
        $listID[] = $row['domain_id'];
        $list[] = $row;
    }
    if ( isset($list) && is_array($list) && !empty($list) ){
        if ( !$date_sendmail_max || ( $now > strtotime("+1 day", strtotime($date_sendmail_max)) ) ){
            $totals = count($list);
            $txtText = '<p>Danh sách tổng <b>'.$totals.'</b> các tên miền đã và sắp hết hạn:</p>';
            foreach($list as $key => $value){
                $txtText .= $value['domain_name'] . ' <b style="color:red;">('.$value['days'].' ngày)</b>' . '<br/>';
            }
            $subject = 'THÔNG BÁO HẾT HẠN TÊN MIỀN PBN TỪ HỆ THỐNG';
            if (send_gmail($email, $subject, $txtText, $email_cc, true, false) ){
                $update = "UPDATE ".TBL_DOMAIN_PBN." SET domain_time_send_mail_expiration = '{$date_sendmail}' WHERE domain_id IN(".implode(",", $listID).")";
                $database->db_query($update);
            }
        }
    }


    // Check HOSTING PBN expiration
    $sql = "SELECT domain_id, domain_name, ht_expiration_date, ht_time_send_mail_expiration FROM tbl_domain_vts WHERE (DATE(ht_expiration_date) <= NOW()) OR (DATE(ht_expiration_date) <= (NOW() + INTERVAL 1 MONTH)) AND domain_status=1 AND ht_expiration_date !=NULL ORDER BY ht_expiration_date, domain_name ASC";
    $results = $database->db_query($sql);
    while ( $row = $database->db_fetch_assoc($results) ){
        $ht_expiration_date = strtotime($row['ht_expiration_date']);
        $_30DAY_expiration_now1 = strtotime("+1 month", $now);
        if ( $ht_expiration_date <= $now || ($_30DAY_expiration_now1 >= $ht_expiration_date) ){
            $ht_date1 = new DateTime(date('m/d/Y', $now));
            $ht_date2 = new DateTime(date('m/d/Y', $ht_expiration_date));
            $diff = $ht_date1->diff($ht_date2);
            $row['days'] = $diff->days;
            if ( $ht_expiration_date <= $now ){
                $row['days'] = 0 - $row['days'];
            }
        }
        if (!is_null($row['ht_time_send_mail_expiration']) && (strtotime($row['ht_time_send_mail_expiration']) > $date_sendmail_max) ){
            $date_sendmail_max_ht = $row['ht_time_send_mail_expiration'];
        }
        $listID[] = $row['domain_id'];
        $list[] = $row;
    }

    if ( isset($list) && is_array($list) && !empty($list) ){

        if ( !$date_sendmail_max_ht || ( $now > strtotime("+1 day", strtotime($date_sendmail_max_ht)) ) ){
            $totals = count($list);
            $txtText = '<p>Danh sách tổng <b>'.$totals.'</b> các Hosting đã và sắp hết hạn:</p>';
            foreach($list as $key => $value){
                $txtText .= $value['domain_name'] . ' <b style="color:red;">('.$value['days'].' ngày)</b>' . '<br/>';
            }
            $subject = 'THÔNG BÁO HẾT HẠN HOSTING PBN TỪ HỆ THỐNG';
            if (send_gmail($email, $subject, $txtText, $email_cc, true, false) ){
                $update = "UPDATE ".TBL_DOMAIN_PBN." SET ht_time_send_mail_expiration = '{$date_sendmail}' WHERE domain_id IN(".implode(",", $listID).")";
                $database->db_query($update);
            }
        }
    }

    // Check sites expiration
    $s_sql = "SELECT site_id, site_domain, site_created, site_register_date, site_number_month_reset, site_time_send_mail_expiration FROM ".TBL_SITE." WHERE site_status = 1 AND ((DATE(site_register_date) <= NOW()) OR (DATE(site_register_date) <= (NOW() + INTERVAL 1 MONTH) OR DATE(site_created) <= NOW()) OR (DATE(site_created) <= (NOW() + INTERVAL 1 MONTH))) ORDER BY site_register_date DESC, site_domain ASC";
    $s_results = $database->db_query($s_sql);
    while ( $s_row = $database->db_fetch_assoc($s_results) ){
        // Xử lý thông báo các site sắp hết hạn
        $s_row['expiration'] = 0;
        if ( is_null($s_row['site_register_date']) || $s_row['site_register_date'] == '0000-00-00 00:00:00' || $s_row['site_register_date'] == '1970-01-01 00:00:00' ){
            $s_row['site_register_date'] = $s_row['site_created'];
        }
        if ( $s_row['site_register_date'] ){
            if ( $s_row['site_number_month_reset'] == 12 ){
                $expiration_date = strtotime("+1 year", strtotime($s_row['site_register_date']));
            }else{
                // Set number month
                $expiration_date = strtotime("+".$s_row['site_number_month_reset']." month", strtotime($s_row['site_register_date']));
            }
            $s_row['site_expirated_date'] = date('m/d/Y', $expiration_date);
            $_30DAY_expiration_now = strtotime("+1 month", $now);
            if ( $expiration_date <= $now || ($_30DAY_expiration_now >= $expiration_date) ){
                $s_row['expiration'] = 1;

                $date1 = new DateTime(date('m/d/Y', $now));
                $date2 = new DateTime(date('m/d/Y', $expiration_date));
                $diff = $date1->diff($date2);
                $s_row['days'] = $diff->days;
                if ( $expiration_date <= $now ){
                    $s_row['days'] = 0 - $s_row['days'];
                }
            }
        }

        if ( isset($s_row['days']) && $s_row['days'] ){
            if (!is_null($s_row['site_time_send_mail_expiration']) && (strtotime($s_row['site_time_send_mail_expiration']) > $date_sendmail_max) ){
                $date_sendmail_site_max = $s_row['site_time_send_mail_expiration'];
            }
            $list_site_ID[] = $s_row['site_id'];
            $list_sites[] = $s_row;
        }
    }
    if ( isset($list_sites) && is_array($list_sites) && !empty($list_sites) ){
        if ( !$date_sendmail_site_max || ( $now > strtotime("+1 day", strtotime($date_sendmail_site_max)) ) ){
            $s_totals = count($list_sites);
            $s_txtText = '<p>Danh sách tổng <b>'.$s_totals.'</b> tên miền các site đã và sắp hết hạn:</p>';
            foreach($list_sites as $s_key => $s_value){
                $s_txtText .= $s_value['site_domain'] . ' <b style="color:red;">('.$s_value['days'].' ngày)</b>' . '<br/>';
            }
            $s_subject = 'THÔNG BÁO HẾT HẠN TÊN MIỀN SITE HỆ THỐNG';
            if (send_gmail($email, $s_subject, $s_txtText, $email_cc, true, false) ){
                $s_update = "UPDATE ".TBL_SITE." SET site_time_send_mail_expiration = '{$date_sendmail}' WHERE site_id IN(".implode(",", $list_site_ID).")";
                $database->db_query($s_update);
            }
        }
    }
}

include "admin_footer.php";
?>