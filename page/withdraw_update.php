<?php
include_once('./_common.php');

$mb_id = $member['mb_id'];

if($mb_id == ""){
	alert("로그인 후 이용해주세요.");
}

$avatar_yn = "n";
$mb_id = strtolower($mb_id);

$bonus_info = get_bonus_info();
$withdraw_min = $bonus_info['withdraw_min'];	// 최소출금포인트
$withdraw_fee_per = $bonus_info['withdraw_fee'];

$withdraw_p = preg_replace("/[^0-9]/", "", $withdraw_p);

if($withdraw_min > $withdraw_p){
	alert("최소 출금액은 ".number_format($withdraw_min)." 입니다.");
}

$my_bonus = get_sum_point($mb_id);
$wait_withdraw = get_sum_w_wait($mb_id);

if($wait_withdraw > 0){
	$my_bonus = $my_bonus - $wait_withdraw;
}

if($withdraw_p > $my_bonus){
	alert("보유보너스 ".number_format($my_bonus)." 이상으로 출금할 수 없습니다.");
}

$order_sum = get_sum_order($mb_id);	// 최대 출금가능액

$bank_info = $bank_name." ".$bank_owner." ".$bank_account;

$withdraw_fee = ($withdraw_p*$withdraw_fee_per)*0.01;	// 수수료

$sql_insert = " insert into p_withdraw set mb_id = '".$mb_id."',
								withdraw_p = '".$withdraw_p."', 
								withdraw_fee = '".$withdraw_fee."', 
								withdraw_memo = '', 
								confirm_yn = 'n', 
								confirm_date = '',
								reg_datetime = '".G5_TIME_YMDHIS."', 
								bank_info = '".$bank_info."' ";
sql_query($sql_insert);


// 출금요청 쪽지전송
$row = sql_fetch(" select max(me_id) as new_me_id from {$g5['memo_table']} ");
$new_me_id = $row['new_me_id'];
if($new_me_id == "") $new_me_id = 0;
$me_id = $new_me_id + 1;

$sql_insert = " insert into {$g5['memo_table']} set me_id='$me_id', me_recv_mb_id = 'admin', me_send_mb_id = '".$mb_id."', me_send_datetime='".G5_TIME_YMDHIS."', me_memo='출금요청'  ";
sql_query($sql_insert);

goto_url("./withdraw_list.php");
?>