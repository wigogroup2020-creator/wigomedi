<?php
include_once('./_common.php');

$mb_id = isset($_POST['mb_id']) ? trim($_POST['mb_id']) : '';

$sql = "select count(*) as cnt from g5_member where mb_id = '".$mb_id."' ";
$result = sql_fetch($sql);

if($result['cnt'] > 0){
	echo "y";
}else{
	echo "";
}
?>