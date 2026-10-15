<?php
include_once('./_common.php');

$sql = "select a.mb_id, a.order_real, b.mb_name, b.mb_pack_real  from p_order a left join g5_member b on a.mb_id = b.mb_id where a.confirm_yn = 'b' and a.order_real != b.mb_pack_real order by a.mb_id";
$result = sql_query($sql);

for($i=0;$row=sql_fetch_array($result);$i++){
	echo "mb_id [".$row['mb_id']."]  [".$row['mb_name']."] order_real [".$row['order_real']."] mb_pack_real [".$row['mb_pack_real']."] <br/>";
}
?>