<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');

$mb_id = isset($_POST['mb_id']) ? trim($_POST['mb_id']) : '';
$mb_email = isset($_POST['mb_email']) ? trim($_POST['mb_email']) : '';

if($mb_id == "admin"){
	echo "n";
	
}else{
	$sql = "select count(*) as cnt from g5_member where mb_id = '".$mb_id."' and mb_email = '".$mb_email."' ";
	$result = sql_fetch($sql);

	if($result['cnt'] > 0){
		$cert_code = sprintf('%06d',rand(000000,999999));

		$content = $config['cf_title']." 임시비밀번호 [".$cert_code."]";

		$subject = $config['cf_title']." 임시비밀번호를 보내드립니다. 로그인 후 개인정보에서 비밀번호를 변경해주세요.";
		mailer($config['cf_title'], $config['cf_admin_email'], $mb_email, $subject, $content, 1);
		
		echo "y";
	}else{
		echo "n";
	}
}
?>