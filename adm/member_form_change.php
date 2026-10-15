<?php
$sub_menu = "100100";
require_once "./_common.php";

auth_check_menu($auth, $sub_menu, 'w');

parse_str(htmlspecialchars_decode($_SERVER['QUERY_STRING']), $query);
$page = isset($query['page']) ? $query['page'] : 1;

$qstr = "&page=".$page."&sst=".$sst."&sod=".$sod."&sfl=".$sfl."&stx=".$stx;

if($mb_id == ""){
	alert("회원 아이디가 없습니다.");
}

if($mb_recommend == ""){
	alert("추천인 아이디를 입력해주세요.");
}

if($mb_id == $mb_recommend){
	alert("회원 본인을 추천인으로 할 수 없습니다.");
}

$rec_arr = get_member($mb_recommend);
if($rec_arr['mb_id'] == ""){
	alert("입력하신 추천인은 존재하지 않는 회원입니다.");
}

// 추천인변경처리
$sql_update = "update g5_member set mb_recommend = '".$mb_recommend."' where mb_id = '".$mb_id."' ";
sql_query($sql_update);

goto_url('./member_form.php?' . $qstr . '&amp;w=u&amp;mb_id=' . $mb_id, false);
?>