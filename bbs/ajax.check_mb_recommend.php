<?php
include_once('./_common.php');

$mb_recommend = $_POST['mb_recommend'];

$sql = "select * from g5_member where mb_id = '".$mb_recommend."' and mb_level < 10 and mb_intercept_date = '' ";
//$sql = "select * from g5_member where mb_id = '".$mb_recommend."' ";
$result = sql_fetch($sql);

echo $result['mb_id'];
?>