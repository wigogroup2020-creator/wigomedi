<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/register.lib.php');

$mb_id = strtolower(trim($mb_id));
$mb_nick = $mb_id;

if ($msg = empty_mb_id($mb_id))	alert($msg, "", true, true); // alert($msg, $url, $error, $post);
if ($msg = valid_mb_id($mb_id))	alert($msg, "", true, true);
if ($msg = count_mb_id($mb_id))	alert($msg, "", true, true);
if ($msg = exist_mb_id($mb_id))	alert($msg);

$mb_recommend = strtolower($mb_recommend);
$mb_chong = "";
$mb_branch = "";
$mb_sales = "";

if($mb_recommend == $mb_id){
	alert("나 자신을 추천할 수 없습니다.");
}

if($mb_recommend){
	$mb_arr = get_member($mb_recommend);
	if($mb_arr['mb_id'] == ""){
		alert("추천인 ".$mb_recommend." 은(는) 존재하지 않는 회원입니다.");
	}
}

$sql = " insert into {$g5['member_table']}
                set mb_id = '{$mb_id}',
                     mb_password = '".get_encrypt_string($mb_password)."',
                     mb_name = '{$mb_name}',
                     mb_nick = '{$mb_nick}',
                     mb_nick_date = '".G5_TIME_YMD."',
                     mb_email = '".$mb_email."',
                     mb_homepage = '',
                     mb_hp = '".$mb_hp."',
					 mb_recommend = '".$mb_recommend."', 
					 mb_tel = '',
                     mb_zip1 = '',
                     mb_zip2 = '',
                     mb_addr1 = '',
                     mb_addr2 = '',
                     mb_addr3 = '',
                     mb_addr_jibeon = '',
                     mb_signature = '',
                     mb_profile = '',
                     mb_today_login = '',
                     mb_datetime = '".G5_TIME_YMDHIS."',
                     mb_ip = '{$_SERVER['REMOTE_ADDR']}',
                     mb_level = '2',
                     mb_login_ip = '{$_SERVER['REMOTE_ADDR']}',
                     mb_mailling = '1',
                     mb_sms = '1',
                     mb_open = '1',
                     mb_open_date = '".G5_TIME_YMD."',
                     mb_1 = '',
                     mb_2 = '',
                     mb_3 = '',
                     mb_4 = '',
                     mb_5 = '',
                     mb_6 = '',
                     mb_7 = '',
                     mb_8 = '',
                     mb_9 = '',
                     mb_10 = '', 
					 mb_chong = '".$mb_chong."' , 
					 mb_branch = '".$mb_branch."', 
					 mb_sales = '".$mb_sales."', 
					 company_name = '".$company_name."', 
					 company_no = '".$company_no."', 
					 company_ceo = '".$company_ceo."', 
					 company_tel = '".$company_tel."', 
					 company_address = '".$company_address."', 
					 company_dept = '".$company_dept."', 
					 co_kind = '".$co_kind."' ";
sql_query($sql);

$mb = get_member($mb_id);

$key = md5($_SERVER['SERVER_ADDR'] . $_SERVER['SERVER_SOFTWARE'] . $_SERVER['HTTP_USER_AGENT'] . $mb['mb_password']);
set_cookie('ck_mb_id', $mb['mb_id'], 86400 * 31);
set_cookie('ck_auto', $key, 86400 * 31);

// 회원아이디 세션 생성
set_session('ss_mb_id', $mb['mb_id']);
// FLASH XSS 공격에 대응하기 위하여 회원의 고유키를 생성해 놓는다. 관리자에서 검사함 - 110106
set_session('ss_mb_key', md5($mb['mb_datetime'] . get_real_client_ip() . $_SERVER['HTTP_USER_AGENT']));
// 회원의 토큰키를 세션에 저장한다. /common.php 에서 해당 회원의 토큰값을 검사한다.
if(function_exists('update_auth_session_token')) update_auth_session_token($mb['mb_datetime']);


goto_url(G5_URL);
?>