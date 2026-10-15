<?php
$sub_menu = '100400';
include_once('./_common.php');

// 상품이 많을 경우 대비 설정변경
set_time_limit ( 0 );
ini_set('memory_limit', '50M');

auth_check_menu($auth, $sub_menu, "w");

function only_number($n)
{
    return preg_replace('/[^0-9]/', '', (string)$n);
}

$is_upload_file = (isset($_FILES['excelfile']['tmp_name']) && $_FILES['excelfile']['tmp_name']) ? 1 : 0;

if( ! $is_upload_file){
    alert("엑셀 파일을 업로드해 주세요.");
}


if($is_upload_file) {
    $file = $_FILES['excelfile']['tmp_name'];

    include_once(G5_LIB_PATH.'/PHPExcel/IOFactory.php');

    $objPHPExcel = PHPExcel_IOFactory::load($file);
    $sheet = $objPHPExcel->getSheet(0);

    $num_rows = $sheet->getHighestRow();
    $highestColumn = $sheet->getHighestColumn();

    $total_count = 0;
    $fail_count = 0;
    $succ_count = 0;
	$fail_arr = array();

    for ($i = 2; $i <= $num_rows; $i++) {
        $total_count++;

        $j = 0;

        $rowData = $sheet->rangeToArray('A' . $i . ':' . $highestColumn . $i,
                                            NULL,
                                            TRUE,
                                            FALSE);

        $mb_id			= trim(addslashes($rowData[0][$j++]));			// 아이디
        $mb_name		= trim(addslashes((string)$rowData[0][$j++]));	// 이름
        $point_point	= trim(addslashes((string)$rowData[0][$j++]));	// 포인트
		$point_str		= trim(addslashes((string)$rowData[0][$j++]));	// 내용
        $point_now		= trim(addslashes((string)$rowData[0][$j++]));	// 현재포인트
		$point_sum		= trim(addslashes((string)$rowData[0][$j++]));	// 누적
		$order_date		= trim(addslashes((string)$rowData[0][$j++]));	// 발생일시
		
		$point_point = preg_replace("/[^0-9]/", "", $point_point);
		$point_point = isset($point_point) ? $point_point : 0;
		
		$reg_datetime = "2025-04-25 10:00:00";

        if(!$mb_id) {
            $fail_count++;
			$fail_arr[] = "id 없음";

            continue;
        }
		
		$mb_id = strtolower($mb_id);
		//point_gubun a데일리,b추천,c추천매칭,d직급,w출금,z관리자, e후원, f후원매칭
		if($point_str == "D포인트"){
			$point_gubun = "a";
			
			$sql = "insert into p_daily set mb_id = '".$mb_id."', daily_bonus = '".$point_point."', daily_date = '2025-04-25', order_no = '0', give_yn = 'n' ";
			sql_query($sql);
	
		}elseif($point_str == "R포인트"){
			$point_gubun = "c";
			
			$sql = "insert into p_daily_match set mb_id = '".$mb_id."', 
												match_bonus = '".$point_point."', 
												match_gen = '0', 
												match_date = '2025-04-25', 
												rec_mb_id = '', 
												order_no = '0', 
												give_yn = 'n' ";
			sql_query($sql);
			
		}elseif($point_str == "P포인트"){
			$point_gubun = "d";
			
			$sql = "insert into p_daily_grade set mb_id = '".$mb_id."', grade_bonus = '".$point_point."', grade_level = '1', grade_date = '2025-04-25', give_yn = 'n' ";
			sql_query($sql);
	
		}elseif($point_str == "출금완료"){
			$point_gubun = "w";
			
			$sql_insert = " insert into p_withdraw set mb_id = '".$mb_id."',
											withdraw_p = '".$point_point."', 
											withdraw_fee = '0', 
											withdraw_memo = '', 
											confirm_yn = 'n', 
											confirm_date = '',
											reg_datetime = '2025-04-25 10:00:00', 
											bank_info = '', 
											avatar_yn = 'n' ";
			sql_query($sql_insert);
		}

        $succ_count++;
    }
}

$g5['title'] = '엑셀일괄등록 결과';
include_once(G5_PATH.'/head.sub.php');
?>

<div class="new_win">
    <h1><?php echo $g5['title']; ?></h1>

    <div class="local_desc01 local_desc">
        <p>등록을 완료했습니다.</p>
    </div>

    <dl id="excelfile_result">
        <dt>총 등록건수</dt>
        <dd><?php echo number_format($total_count); ?></dd>
        <dt>완료건수</dt>
        <dd><?php echo number_format($succ_count); ?></dd>
        <dt>실패건수</dt>
        <dd>
			<?php
			echo number_format($fail_count);
			
			echo "<br/><br/>";

			echo implode('<br/>', $fail_arr);
			?>
		</dd>
    </dl>

    <div class="btn_win01 btn_win">
        <button type="button" onclick="window.close();">창닫기</button>
    </div>

</div>

<?php
include_once(G5_PATH.'/tail.sub.php');
?>