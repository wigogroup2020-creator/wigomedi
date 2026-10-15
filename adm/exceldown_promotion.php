<?php
$sub_menu = "100305";
include_once('./_common.php');
auth_check_menu($auth, $sub_menu, 'd');
echo '<meta charset="utf-8">';

$down_name = "promotion_".G5_TIME_YMD;

header("Content-Type: application/vnd.ms-excel"); 
header("Content-Type: application/x-msexcel"); 
header("Content-Disposition: attachment; filename=".$down_name.".xls");
header("Content-Description: PHP4 Generated Data" ); 

$sql = " select a.*, b.promotion_name, b.promotion_date, c.mb_name, c.mb_recommend, c.mb_spon, c.mb_center 
		from p_promotion_join a left join p_promotion b on a.promotion_no = b.promotion_no 
								left join g5_member c on a.mb_id = c.mb_id 
		where a.reg_datetime between '".$from_dt." 00:00:00' and '".$to_dt." 23:59:59' order by c.mb_name ";
$result = sql_query($sql);
?>

<html>
<body bgcolor="#FFFFFF">
<table border="1" style="table-layout:fixed">
	<tr>
        <th>아이디</th>
		<th>이름</th>
		<th>프로모션명</th>
		<th>경매일자</th>
		<th>추첨번호</th>
		<th>당첨번호</th>
		<th>당첨여부</th>
		<th>참여횟수</th>
		<th>당첨횟수</th>
		<th>참여일시</th>
	</tr>
<?php
for ($i=0; $row=sql_fetch_array($result); $i++){ 
	$mb_id = $row['mb_id'];
?>

	<tr>
		<td><?php echo $mb_id; ?></td>
		<td><?php echo get_text($row['mb_name']); ?></td>
		<td><?php echo $row['promotion_name']; ?></td>
		<td><?php echo $row['promotion_date']; ?></td>
		<td><?php echo $row['join_lottery']; ?></td>
		<td><?php echo $row['join_winning']; ?></td>
		<td>
			<?php
			if($row['join_win'] == "y") echo "당첨";
			?>
		</td>
		<td style="text-align:right"><?php echo number_format(get_lottery_cnt_my($mb_id));?></td>
		<td style="text-align:right"><?php echo number_format(get_winning_cnt_my($mb_id));?></td>
		<td><?php echo $row['reg_datetime']; ?></td>
	</tr>

<?php
}

sql_free_result($result);
?>
    </table>
</body>
</html>