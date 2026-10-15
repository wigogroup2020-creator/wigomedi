<?php
include_once('./_common.php');

$mb_email = $_POST['mb_email'];

$sql = "select count(*) as cnt from g5_member where mb_email = '".$mb_email."' ";
$result = sql_fetch($sql);

if($result['cnt'] > 0){
	echo "y";
}else{
	echo "";
}
?>