<?php
$sub_menu = '100303';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

$sql = "update p_contact set confirm_yn = 'y', confirm_date = '".G5_TIME_YMDHIS."' where contact_no = '".$contact_no."' ";
sql_query($sql);

alert("통화완료 하였습니다.");
?>