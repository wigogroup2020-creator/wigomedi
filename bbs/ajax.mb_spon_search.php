<?php
include_once('../common.php');

$mb_id = trim(strip_tags($_POST['mb_id']));

$str_return = "<option value='".$mb_id."'>".$mb_id."</option> ";
$str_return = get_all_spon_sub($mb_id, $str_return);

echo $str_return;

function get_all_spon_sub($mb_id, $str_return){
	$sql = "select * from g5_member where mb_spon = '".$mb_id."' order by mb_no ";
	$result = sql_query($sql);

	for($s=0; $row=sql_fetch_array($result); $s++){
		$mb_id2 = $row['mb_id'];
		$str_return .= "<option value='".$mb_id2."'>".$mb_id2."</option> ";
		$str_return = get_all_spon_sub($mb_id2, $str_return); // 재귀 호출
	}

	return $str_return;
}
?>