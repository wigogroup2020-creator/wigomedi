<?
include_once("./_common.php");
include_once("qrlib.php");

//** 전달값 처리.
//$qrcode_url = G5_URL.'/meme_qr/qr_intro.php?'. getenv('QUERY_STRING');


$sql = "select * from g5_member where mb_level between 3 and 6 ";
$result = sql_query($sql);

for($i=0;$row=sql_fetch_array($result);$i++){
	$filename				= $row['mb_id'] .'.png';
	$errorCorrectionLevel	= 'H';
	$matrixPointSize		= 10;

	$qrcode_path         = G5_DATA_PATH.'/meme_qrcode';
	$qrcode_save_path    = G5_DATA_PATH.'/meme_qrcode/';
	$qrcode_save_url     = G5_DATA_URL.'/meme_qrcode/';
	$qrcode_full_path    = $qrcode_save_path.'/'.$filename;

	//echo $filename." [".$qrcode_full_path."]<br/><br/>";
	$qrcode_url = G5_ADMIN_URL.'?mb_id='.$row['mb_id'];

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
}

goto_url('../make_qrcode.php?makeyn=y');
?>