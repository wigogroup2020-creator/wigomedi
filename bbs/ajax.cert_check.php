<?php
include_once('./_common.php');

$mb_id = isset($_POST['mb_id']) ? trim($_POST['mb_id']) : '';
$cert_code = isset($_POST['cert_code']) ? trim($_POST['cert_code']) : '';

$sql = "select count(*) as cnt from p_cert where mb_id = '".$mb_id."' and cert_code = '".$cert_code."' ";
$result = sql_fetch($sql);

if($result['cnt'] > 0){
	$sql_del = "delete from p_cert where mb_id = '".$mb_id."'";
	sql_query($sql_del);
	
	echo "";
}else{
	echo "n";
}
?>