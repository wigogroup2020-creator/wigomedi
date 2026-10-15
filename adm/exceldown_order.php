<?php
$sub_menu = "100301";
include_once('./_common.php');
auth_check_menu($auth, $sub_menu, 'd');
echo '<meta charset="utf-8">';

$down_name = "order_".G5_TIME_YMD;

header("Content-Type: application/vnd.ms-excel"); 
header("Content-Type: application/x-msexcel"); 
header("Content-Disposition: attachment; filename=".$down_name.".xls");
header("Content-Description: PHP4 Generated Data" ); 

$sql = " select a.*, b.mb_name, b.mb_email, b.mb_recommend, b.mb_addr1, b.mb_addr2 from p_order a left join g5_member b on a.mb_id = b.mb_id order by b.mb_name ";
$result = sql_query($sql);
?>

<html>
<body bgcolor="#FFFFFF">
<table border="1" style="table-layout:fixed">
	<tr>
        <th>아이디</th>
		<th>이름</th>
		<th>주소</th>
		<th>추천인</th>
		<th>입금금액</th>
		<th>전환포인트</th>
		<th>경매참여</th>
		<th>경매당첨</th>
		<th>구매일시</th>
		<th>승인일시</th>
	</tr>
<?php
for ($i=0; $row=sql_fetch_array($result); $i++){ 
	$mb_id = $row['mb_id'];
	$order_price = $row['order_price'];
	$order_point = $row['order_point'];
	$mb_recommend = isset($row['mb_recommend']) ? $row['mb_recommend'] : "";
	$mb_addr1 = isset($row['mb_addr1']) ? $row['mb_addr1'] : "";
	$mb_addr2 = isset($row['mb_addr2']) ? $row['mb_addr2'] : "";
	
	$auction_cnt = get_auction_cnt($mb_id);
	$auction_cnt_win = get_auction_cnt_win($mb_id);
?>

	<tr>
		<td><?php echo $mb_id; ?></td>
		<td><?php echo get_text($row['mb_name']); ?></td>
		<td><?php if($mb_addr1) echo $mb_addr1." ".$mb_addr2;?></td>
		<td><?php echo $mb_recommend; ?></td>
		<td style="text-align:right">
			<?php
			echo number_format($order_price);
			?>
		</td>
		<td style="text-align:right"><?php echo number_format($order_point);?></td>
		<td style="text-align:right"><?php echo number_format($auction_cnt);?></td>
		<td style="text-align:right"><?php echo number_format($auction_cnt_win);?></td>
		<td><?php echo $row['reg_datetime']; ?></td>
		<td><?php echo $row['confirm_date']; ?></td>
	</tr>

<?php
}

sql_free_result($result);
?>
    </table>
</body>
</html>