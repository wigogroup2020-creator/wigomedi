<?php
$sub_menu = '100304';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

$data_dir = "/product";

@mkdir(G5_DATA_PATH.$data_dir, G5_DIR_PERMISSION);
@chmod(G5_DATA_PATH.$data_dir, G5_DIR_PERMISSION);

if($w == "u"){
	$product_price = preg_replace("/[^0-9]/", "", $product_price);
	$product_price_member = preg_replace("/[^0-9]/", "", $product_price_member);
	$product_price_sales = preg_replace("/[^0-9]/", "", $product_price_sales);
	$product_price_branch = preg_replace("/[^0-9]/", "", $product_price_branch);
	$product_price_chong = preg_replace("/[^0-9]/", "", $product_price_chong);
	
	$sql = "update p_product set use_yn = '".$use_yn."', 
								product_kind = '".$product_kind."', 
								product_info = '".$product_info."', 
								product_subject = '".$product_subject."', 
								product_price = '".$product_price."', 
								product_price_member = '".$product_price_member."', 
								product_price_sales = '".$product_price_sales."', 
								product_price_branch = '".$product_price_branch."', 
								product_price_chong = '".$product_price_chong."', 
								product_content = '".$product_content."' 
			where product_no = '".$product_no."' ";
	sql_query($sql);
	
	// 이미지업로드
	if($_FILES['product_file']['tmp_name']) {
		preg_match('#.+\.([a-z]+)$#', $_FILES['product_file']['name'], $m);
		$ext = strtolower($m[1]);
		$filename = date('YmdHis') . (microtime(true) * 10000) . '.' . $ext;
		$thumb_filename = "thumb_" . $filename;

		$upload_path = G5_DATA_PATH . $data_dir . "/";

		upload_file($_FILES['product_file']['tmp_name'], $filename, $upload_path);

		// DB 업데이트
		$sql = "UPDATE p_product SET product_file = '" . $filename . "' WHERE product_no = '" . $product_no . "'";
		sql_query($sql);
	}

	alert("수정하였습니다.");

}else{
	$product_price = preg_replace("/[^0-9]/", "", $product_price);
	$product_price_member = preg_replace("/[^0-9]/", "", $product_price_member);
	$product_price_sales = preg_replace("/[^0-9]/", "", $product_price_sales);
	$product_price_branch = preg_replace("/[^0-9]/", "", $product_price_branch);
	$product_price_chong = preg_replace("/[^0-9]/", "", $product_price_chong);
	
	$sql = "insert into p_product set product_kind = '".$product_kind."', 
									use_yn = '".$use_yn."', 
									product_info = '".$product_info."', 
									product_subject = '".$product_subject."', 
									product_content = '".$product_content."', 
									product_price = '".$product_price."', 
									product_price_member = '".$product_price_member."', 
									product_price_sales = '".$product_price_sales."', 
									product_price_branch = '".$product_price_branch."', 
									product_price_chong = '".$product_price_chong."', 
									product_file = '', 
									reg_mb_id = '".$member['mb_id']."', 
									reg_datetime = '".G5_TIME_YMDHIS."' ";
	sql_query($sql);
	
	$product_no = sql_insert_id();
	
	// 이미지업로드
	if($_FILES['product_file']['tmp_name']) {
		preg_match('#.+\.([a-z]+)$#', $_FILES['product_file']['name'], $m);
		$ext = strtolower($m[1]);
		$filename = date('YmdHis') . (microtime(true) * 10000) . '.' . $ext;
		$thumb_filename = "thumb_" . $filename;

		$upload_path = G5_DATA_PATH . $data_dir . "/";

		upload_file($_FILES['product_file']['tmp_name'], $filename, $upload_path);

		// DB 업데이트
		$sql = "UPDATE p_product SET product_file = '" . $filename . "' WHERE product_no = '" . $product_no . "'";
		sql_query($sql);
	}

	alert("등록하였습니다.", "./p_product.php");
}
?>