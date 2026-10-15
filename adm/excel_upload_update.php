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

        $mb_id			= trim(addslashes($rowData[0][$j++]));
        $mb_name		= trim(addslashes((string)$rowData[0][$j++]));
        $mb_recommend	= trim(addslashes((string)$rowData[0][$j++]));	// 추천인
		$mb_spon		= trim(addslashes((string)$rowData[0][$j++]));	// 후원인
        $mb_open_date	= trim(addslashes((string)$rowData[0][$j++]));	// 회원가입일
		$reg_datetime	= trim(addslashes((string)$rowData[0][$j++]));	// 투자일
		$order_price	= trim(addslashes((string)$rowData[0][$j++]));	// 투자금
		
		$mb_open_date = substr($mb_open_date, 0, 4) . '-' . substr($mb_open_date, 4, 2) . '-' . substr($mb_open_date, 6, 2);
		$reg_datetime = substr($reg_datetime, 0, 4) . '-' . substr($reg_datetime, 4, 2) . '-' . substr($reg_datetime, 6, 2);
		
		$order_price = preg_replace("/[^0-9]/", "", $order_price);
		$order_price = isset($order_price) ? $order_price : 0;
		
		$mb_datetime = $mb_open_date." 10:00:00";
		$reg_datetime = $reg_datetime." 10:00:00";

        if(!$mb_id) {
            $fail_count++;
			$fail_arr[] = "id 없음";

            continue;
        }
		
		$mb_id = strtolower($mb_id);
		$mb_recommend = strtolower($mb_recommend);
		$mb_spon = strtolower($mb_spon);
		$mb_password = "1111";

		$sql = " insert into {$g5['member_table']}
						set mb_id = '{$mb_id}',
							 mb_password = '".get_encrypt_string($mb_password)."',
							 mb_name = '{$mb_name}',
							 mb_nick = '{$mb_id}',
							 mb_nick_date = '".G5_TIME_YMD."',
							 mb_email = '',
							 mb_hp = '',
							 mb_recommend = '".$mb_recommend."', 
							 mb_datetime = '".$mb_datetime."',
							 mb_level = '2',
							 mb_mailling = '1',
							 mb_sms = '1',
							 mb_open = '1',
							 mb_open_date = '".$mb_open_date."',
							 mb_grade = 0, 
							 mb_spon = '".$mb_spon."', 
							 mb_spon_lr = 'l', 
							 bonus_end = 'n', 
							 order_pv = 0 ";
		sql_query($sql);
		
		if($order_price > 0){
			$sql = "SELECT * FROM p_item where item_price = '".$order_price."' ";
			$result = sql_fetch($sql);
			$item_no = $result['item_no'];
			$order_pv = isset($result['item_pv']) ? $result['item_pv'] : 0;

			$mb_id = strtolower($mb_id);
			$sql_insert = " insert into p_order set mb_id = '".$mb_id."',
											confirm_yn = 'y', 
											confirm_date = '".$reg_datetime."',
											reg_datetime = '".$reg_datetime."', 
											order_price = '".$order_price."', 
											item_no = '".$item_no."', 
											order_pv = '".$order_pv."' ";
			sql_query($sql_insert);
			
			$sql_update = "update g5_member set order_pv = '".$order_pv."' where mb_id = '".$mb_id."'";
			sql_query($sql_update);
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