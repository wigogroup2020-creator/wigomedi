<?php
include_once('./_common.php');

$sql_password = "";
if ($mb_password){
	$sql_password.= ", mb_password = '".get_encrypt_string($mb_password)."'  ";
}

$sql = " update {$g5['member_table']} set mb_name = '".$mb_name."', 
										mb_hp = '".$mb_hp."', 
										mb_email = '".$mb_email."', 
										mb_zip1 = '".$mb_zip."',
										mb_zip2 = '',
										mb_addr1 = '".$mb_addr1."',
										mb_addr2 = '".$mb_addr2."',
										mb_addr3 = '".$mb_addr3."',
										mb_addr_jibeon = '".$mb_addr_jibeon."', 
										bank_name = '".$bank_name."', 
										bank_owner = '".$bank_owner."', 
										bank_account = '".$bank_account."' 
										{$sql_password} 
			where mb_id = '".$member['mb_id']."' ";
sql_query($sql);

alert("수정하였습니다.");
?>