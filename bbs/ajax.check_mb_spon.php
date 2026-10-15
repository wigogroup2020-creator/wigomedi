<?php
include_once('./_common.php');

$mb_spon = $_POST['mb_spon'];
$mb_recommend = $_POST['mb_recommend'];

$sql = "select * from g5_member where mb_id = '".$mb_spon."' and mb_level < 10 and mb_intercept_date = '' ";
$result = sql_fetch($sql);

$mb_id = isset($result['mb_id']) ? $result['mb_id'] : "";

if($mb_id == ""){
	echo "";
}else{
	/*
	$spon_cnt = get_spon_cnt($mb_id);

	if($spon_cnt == 2){
		echo "two";
	}else{
		echo "y";
	}
	*/
	echo "y";
}
?>