<?php
include_once('./_common.php');

$mb_id = $_POST['mb_id'];

$sql = "delete from p_cert where mb_id = '".$mb_id."' ";
sql_query($sql);
?>