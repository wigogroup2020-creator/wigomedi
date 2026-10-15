<?php
include_once('./_common.php');

$sql = " insert into p_contact set mb_id = '{$mb_id}',
                     mb_name = '{$mb_name}',
                     mb_hp = '".$mb_hp."',
					 contact_company = '".$contact_company."', 
					 contact_kind = '".$contact_kind."', 
					 contact_content = '".$contact_content."', 
                     confirm_yn = 'n',
                     confirm_date = '',
                     reg_datetime = '".G5_TIME_YMDHIS."' ";
sql_query($sql);


alert("빠른시간안에 답변을 드리겠습니다.", G5_URL);
?>