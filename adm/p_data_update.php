<?php
$sub_menu = '100302';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

if($w == "u"){
	for ($i=0; $i<count($_POST['chk']); $i++){
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		$sql = "update p_notice set use_yn = '".$_POST['use_yn'][$k]."' where notice_no = '".$_POST['notice_no'][$k]."' ";
		sql_query($sql);
	}

	alert("수정하였습니다.");

}else if($w == "d"){
	auth_check_menu($auth, $sub_menu, 'd');

	for ($i=0; $i<count($_POST['chk']); $i++){
		// 실제 번호를 넘김
		$k = $_POST['chk'][$i];

		$sql = "delete from p_notice where notice_no = '".$_POST['notice_no'][$k]."' ";
		sql_query($sql);
	}

	alert("삭제하였습니다.");
}
?>