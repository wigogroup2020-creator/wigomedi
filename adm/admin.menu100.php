<?php
$sql_join = "select count(*) as cnt from g5_memo where me_memo='회원가입' ";
$result_join = sql_fetch($sql_join);
$join_cnt = $result_join['cnt'];

$join_txt = "";
if($join_cnt > 0){
	$join_txt = "<font color='#ff3300'>-".$join_cnt."건</font>";
}

$menu['menu100'] = array(
	array('100000', '회원관리', G5_ADMIN_URL . '/member_list.php', 'mb_list'),
	array('100100', '회원-관리용'.$join_txt, G5_ADMIN_URL . '/member_list.php', 'member_list'),
	array('100102', '회원-총판', G5_ADMIN_URL . '/p_member_chong.php', 'p_member_chong'),
	array('100103', '회원-대리점', G5_ADMIN_URL . '/p_member_branch.php', 'p_member_branch'),
	array('100104', '회원-영업', G5_ADMIN_URL . '/p_member_sales.php', 'p_member_sales'),
	array('100105', '회원-일반', G5_ADMIN_URL . '/p_member_list.php', 'p_member_list'),

	array('100901', 'line'),
	array('100201', '기본환경설정', G5_ADMIN_URL . '/config_form.php',   'cf_basic'),
	array('100202', '관리권한설정', G5_ADMIN_URL . '/auth_list.php',     'cf_auth'),
	
	array('100901', 'line'),
	array('100301', '공지사항관리', G5_ADMIN_URL . '/p_notice.php',   'p_notice'),
	array('100302', '자료실관리', G5_ADMIN_URL . '/p_data.php',   'p_data'),
	array('100303', '문의하기', G5_ADMIN_URL . '/p_contact.php',   'p_contact'),
	array('100304', '제품관리', G5_ADMIN_URL . '/p_product.php',   'p_product'),
	array('100305', '매장안내 관리', G5_ADMIN_URL . '/stores.php', 'stores'),
);