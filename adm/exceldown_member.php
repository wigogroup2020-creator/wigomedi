<?php
$sub_menu = "100100";
include_once('./_common.php');
auth_check_menu($auth, $sub_menu, 'd');
echo '<meta charset="utf-8">';

$down_name = "member_".G5_TIME_YMD;

header("Content-Type: application/vnd.ms-excel"); 
header("Content-Type: application/x-msexcel"); 
header("Content-Disposition: attachment; filename=".$down_name.".xls");
header("Content-Description: PHP4 Generated Data" ); 

$sql = " select * from {$g5['member_table']} where mb_level < 5 order by mb_no desc";
$result = sql_query($sql);
?>

<html>
<body bgcolor="#FFFFFF">
<table border="1" style="table-layout:fixed">
	<tr>
		<th>아이디</th>
		<th>이름</th>
		<th>휴대폰</th>
		<th>이메일</th>
		<th>참여횟수</th>
		<th>당첨횟수</th>
		<th>투자금</th>
		<th>보너스</th>
		<th>추천인</th>
		<th>추천인수</th>
		<th>추천인전체</th>
		<th>후원인</th>
		<th>후원인수</th>
		<th>후원인전체</th>
		<th>가입일</th>
		<th>최종접속</th>
	</tr>
<?php
for ($i=0; $row=sql_fetch_array($result); $i++){ 
	$mb_id = strtolower($row['mb_id']);
	$order_sum = get_sum_order($mb_id);
	$auction_cnt = get_auction_cnt($mb_id);
	$auction_cnt_win = get_auction_cnt_win($mb_id);
	$rec_cnt = get_rec_cnt($mb_id);
	$spon_cnt = get_spon_cnt($mb_id);
?>

	<tr>
		<td><?php echo $mb_id;?></td>
		<td>
			<?php
			echo get_text($row['mb_name']);
			?>
		</td>
		<td><?php echo get_text($row['mb_hp']); ?></td>
		<td><?php echo $row['mb_email']; ?></td>
		<td><?php echo number_format($auction_cnt);?></td>
		<td><?php echo number_format($auction_cnt_win);?></td>
		<td><?php echo number_format($order_sum);?></td>
		<td><?php echo number_format(get_sum_point($mb_id));?></td>
		<td><?php echo $row['mb_recommend'];?></td>
		<td><?php echo number_format($rec_cnt);?></td>
		<td><?php echo number_format(get_reccnt_all($mb_id));?></td>
		<td><?php echo $row['mb_spon'];?></td>
		<td><?php echo number_format($spon_cnt);?></td>
		<td><?php echo number_format(get_spon_cnt_all($mb_id));?></td>
		<td><?php echo $row['mb_datetime']; ?></td>
		<td><?php echo $row['mb_today_login']; ?></td>
	</tr>
<?php
}

sql_free_result($result);
?>
    </table>
</body>
</html>