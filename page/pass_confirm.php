<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/mailer.lib.php');

if($mb_email == ""){
	alert("이메일주소를 입력해주세요.");
}

$sql = "select * from g5_member where mb_id = '".$mb_id."' ";
$result = sql_fetch($sql);

if($result['mb_id'] == ""){
	alert("회원정보가 없습니다.");
}

$mb_password = sprintf('%06d',rand(000000,999999));

$sql = " update {$g5['member_table']} set mb_password = '".get_encrypt_string($mb_password)."' where mb_id = '".$mb_id."' ";
sql_query($sql);

$subject = $config['cf_title']." 임시 비밀번호 전송";
$content = $mb_arr['mb_name']." 임시 비밀번호를 전달해 드립니다.<br/>임시 비밀번호'] : ".$mb_password."<br/>로그인 후 개인정보에서 비밀번호를 변경하시기 바랍니다.";
mailer($config['cf_title'], $config['cf_admin_email'], $mb_email, $subject, $content, 1);

alert("임시 비밀번호를 이메일로 전송하였습니다.", G5_URL."/page/login.php");
?>