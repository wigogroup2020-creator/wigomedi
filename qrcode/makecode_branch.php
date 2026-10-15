<?
include_once("./_common.php");
include_once("qrlib.php");

//** 전달값 처리.
//$qrcode_url = G5_URL.'/meme_qr/qr_intro.php?'. getenv('QUERY_STRING');

$mb_id = $_GET['mb_id'];

$sql = "select * from g5_member where mb_id = '".$mb_id."' ";
$result = sql_fetch($sql);

$mb_gen = $result['mb_gen'];	// 권한 6 지점, 3-4-5 영업사원
$mb_1 = $result['mb_1'];			// 소속지점

$sql_cnt = "select count(*) as cnt from meme_branchqr where qr_mb_id = '".$mb_id."' ";
$result_cnt = sql_fetch($sql_cnt);

$from_cnt = $result_cnt['cnt']*1;
$to_cnt = 11;

if($from_cnt == 0){
	$from_cnt = 1;
}else{
	$to_cnt = ($from_cnt*2)+1;
	$from_cnt = $from_cnt + 1;
}

for($i=$from_cnt;$i<$to_cnt;$i++){
	$filename				= $mb_id.'_'.$i.'.png';
	$errorCorrectionLevel	= 'H';
	$matrixPointSize		= 10;

	if($mb_gen == 1){
		$qrcode_path         = G5_DATA_PATH.'/meme_qrcode/'.$mb_id;
		$qrcode_save_path    = G5_DATA_PATH.'/meme_qrcode/'.$mb_id.'/';
		$qrcode_save_url     = G5_DATA_URL.'/meme_qrcode/'.$mb_id.'/';
		$qrcode_full_path    = $qrcode_save_path.'/'.$filename;

		$qrcode_url = G5_URL.'/memetest/qr_intro.php?branch_code='.$mb_id.'_'.$i;
		//$qrcode_url = G5_URL.'/memetest/qr_intro.php?branch_code='.$mb_id.'_'.$i;

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
	}else{
		$qrcode_path         = G5_DATA_PATH.'/meme_qrcode/'.$mb_1.'/'.$mb_id;
		$qrcode_save_path    = G5_DATA_PATH.'/meme_qrcode/'.$mb_1.'/'.$mb_id.'/';
		$qrcode_save_url     = G5_DATA_URL.'/meme_qrcode/'.$mb_1.'/'.$mb_id.'/';
		$qrcode_full_path    = $qrcode_save_path.'/'.$filename;

		$qrcode_url = G5_URL.'/memetest/qr_intro.php?branch_code='.$mb_id.'_'.$i;
		//$qrcode_url = G5_URL.'/memetest/qr_intro.php?branch_code='.$mb_id.'_'.$i;

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
	
	$qr_branch_code = $mb_id."_".$i;

	$sql_insert = "insert into meme_branchqr set qr_branch = '".$mb_1."', 
												qr_mb_id = '".$mb_id."',
												qr_branch_code = '".$qr_branch_code."', 
												qr_seq = '".$i."',
												qr_date = '".G5_TIME_YMDHIS."', 
												qr_salestore = '' ";
	sql_query($sql_insert);
}

goto_url('../meme_sales_view.php?mb_id='.$mb_id.'&makeyn=y');
?>