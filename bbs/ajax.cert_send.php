<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');

$mb_email = isset($_POST['mb_email']) ? trim($_POST['mb_email']) : '';
$mb_id = isset($_POST['mb_id']) ? trim($_POST['mb_id']) : '';

$sql = "select count(*) as cnt from g5_member where mb_id = '".$mb_id."' and mb_email = '".$mb_email."' ";
$result = sql_fetch($sql);

if($result['cnt'] > 0){
	$cert_code = sprintf('%06d',rand(000000,999999));

	// 이전꺼는 다 지우고
	$sql_del = "delete from p_cert where mb_id = '".$mb_id."'";
	sql_query($sql_del);

	$sql = "insert into p_cert set mb_id = '".$mb_id."', cert_code = '".$cert_code."' ";
	sql_query($sql);

	$content = $config['cf_title']." ".$lang_text['인증코드']." [".$cert_code."]";

	$subject = $config['cf_title']." ".$lang_text['인증코드를 보내드립니다.'];
	mailer($config['cf_title'], $config['cf_admin_email'], $mb_email, $subject, $content, 1);
	
	echo "y";
}else{
	echo "n";
}
?>