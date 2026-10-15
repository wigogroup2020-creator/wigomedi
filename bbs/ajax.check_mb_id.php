<?php
include_once('./_common.php');

set_session('ss_check_mb_id', '');
$mb_id = $_POST['mb_id'];

$sql = "select count(*) as cnt from g5_member where mb_id = '".$mb_id."' ";
$result = sql_fetch($sql);


set_session('ss_check_mb_id', $mb_id);

echo $result['cnt'];
?>