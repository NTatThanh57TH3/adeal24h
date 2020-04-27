<?php
$page = "filemanager";
include "admin_header.php";

$smarty->assign_by_ref('admin', $admin);
$smarty->display("$page.tpl");
?>