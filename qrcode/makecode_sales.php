<?
include_once("./_common.php");
include_once("qrlib.php");

$mb_id = $_GET['mb_id'];

$filename				= $mb_id.'.png';
$errorCorrectionLevel	= 'H';
$matrixPointSize		= 10;

$qrcode_path         = G5_DATA_PATH.'/meme_qrcode';
$qrcode_save_path    = G5_DATA_PATH.'/meme_qrcode/';
$qrcode_save_url     = G5_DATA_URL.'/meme_qrcode/';
$qrcode_full_path    = $qrcode_save_path.'/'.$filename;

$qrcode_url = G5_URL.'/memetest/qr_intro.php?branch_code='.$mb_id;

//** 코드이미지는 한번만 생성.
if (!file_exists($qrcode_full_path)) {
	if(!is_dir($qrcode_path)) {
		@mkdir($qrcode_path, G5_DIR_PERMISSION);
		@chmod($qrcode_path, G5_DIR_PERMISSION);
	}
	
	if(!is_dir($qrcode_save_path)) {
		@mkdir($qrcode_save_path, G5_DIR_PERMISSION);
		@chmod($qrcode_save_path, G5_DIR_PERMISSION);
	}

	//** 코드생성.
	QRcode::png($qrcode_url, $qrcode_full_path, $errorCorrectionLevel, $matrixPointSize, 2);
}

goto_url('../memecam_sales_list.php');
?>