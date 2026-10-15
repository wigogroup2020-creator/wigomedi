<?php
include_once('./_common.php');

$mb_name = isset($_POST['mb_name']) ? trim($_POST['mb_name']) : '';
$mb_email = isset($_POST['mb_email']) ? trim($_POST['mb_email']) : '';

$sql = "select mb_id from g5_member where mb_name = '".$mb_name."' and mb_email = '".$mb_email."' ";
$result = sql_fetch($sql);

$mb_id = isset($result['mb_id']) ? $result['mb_id'] : "";

if($mb_id == "admin") $mb_id = "";
echo $mb_id;
?>