<?php
$sub_menu = '100301';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

$data_dir = "/notice";

@mkdir(G5_DATA_PATH.$data_dir, G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.$data_dir, G5_DIR_PERMISSION);

if($w == "u"){
	$sql = "update p_notice set use_yn = '".$use_yn."', 
								notice_subject = '".$notice_subject."', 
								notice_content = '".$notice_content."' 
			where notice_no = '".$notice_no."' ";
	sql_query($sql);
	
	// 이미지업로드
	if($_FILES['notice_file']['tmp_name']) {
		preg_match('#.+\.([a-z]+)$#', $_FILES['notice_file']['name'], $m);
		$ext = strtolower($m[1]);
		$filename = date('YmdHis') . (microtime(true) * 10000) . '.' . $ext;
		$thumb_filename = "thumb_" . $filename;

		$upload_path = G5_DATA_PATH . $data_dir . "/";

		upload_file($_FILES['notice_file']['tmp_name'], $filename, $upload_path);

		// DB 업데이트
		$sql = "UPDATE p_notice SET notice_file = '" . $filename . "', notice_file_name = '".$_FILES['notice_file']['name']."', notice_file_exp = '".$ext."' WHERE notice_no = '" . $notice_no . "'";
		sql_query($sql);
	}

	alert("수정하였습니다.");

}else{
	$sql = "insert into p_notice set notice_kind = 'a', 
									use_yn = '".$use_yn."', 
									notice_subject = '".$notice_subject."', 
									notice_content = '".$notice_content."', 
									notice_file = '', 
									notice_file_name = '', 
									notice_file_exp = '', 
									reg_mb_id = '".$member['mb_id']."', 
									reg_datetime = '".G5_TIME_YMDHIS."' ";
	sql_query($sql);
	
	$notice_no = sql_insert_id();
	
	// 이미지업로드
	if($_FILES['notice_file']['tmp_name']) {
		preg_match('#.+\.([a-z]+)$#', $_FILES['notice_file']['name'], $m);
		$ext = strtolower($m[1]);
		$filename = date('YmdHis') . (microtime(true) * 10000) . '.' . $ext;
		$thumb_filename = "thumb_" . $filename;

		$upload_path = G5_DATA_PATH . $data_dir . "/";

		upload_file($_FILES['notice_file']['tmp_name'], $filename, $upload_path);

		// DB 업데이트
		$sql = "UPDATE p_notice SET notice_file = '" . $filename . "', notice_file_name = '".$_FILES['notice_file']['name']."', notice_file_exp = '".$ext."' WHERE notice_no = '" . $notice_no . "'";
		sql_query($sql);
	}

	alert("등록하였습니다.", "./p_notice.php");
}
?>