<?php
$page = "admin_home";
$page_title = "Trang chủ";
include "admin_header.php";

if ( $admin->admin_super || $admin->admin_info['admin_group'] == '2' )
    cheader($uri->base().'admin_report_user.php');
else if ( $admin->admin_info['admin_group'] == '3' || $admin->admin_info['admin_group'] == '4' )
    cheader($uri->base().'admin_content.php');
else if ( $admin->admin_info['admin_group'] == '5' || $admin->admin_info['admin_group'] == '6' || $admin->admin_info['admin_group'] == '8' )
    cheader($uri->base().'admin_candidates.php');

include "admin_footer.php";
?>