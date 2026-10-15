<?php
$sub_menu = "100303";
include_once('./_common.php');
auth_check_menu($auth, $sub_menu, 'd');
echo '<meta charset="utf-8">';

$down_name = "point_".G5_TIME_YMD;

header("Content-Type: application/vnd.ms-excel"); 
header("Content-Type: application/x-msexcel"); 
header("Content-Disposition: attachment; filename=".$down_name.".xls");
header("Content-Description: PHP4 Generated Data" ); 

$sql = " select a.*, b.mb_name, b.mb_email from p_point a left join g5_member b on a.mb_id = b.mb_id where a.reg_datetime between '".$from_dt." 00:00:00' and '".$to_dt." 23:59:59' order by b.mb_name ";
$result = sql_query($sql);
?>

<html>
<body bgcolor="#FFFFFF">
<table border="1" style="table-layout:fixed">
	<tr>
        <th>아이디</th>
		<th>이름</th>
		<th>보너스구분</th>
		<th>지급대수</th>
		<th>발생보너스</th>
		<th>잔액</th>
		<th>보유보너스</th>
		<th>발생대상자-소개보너스일때</th>
		<th>메모</th>
		<th>발생일시</th>
	</tr>
<?php
for ($i=0; $row=sql_fetch_array($result); $i++){ 
	$mb_id = $row['mb_id'];
	$point_gubun = $row['point_gubun'];
	$point_sum = get_sum_point($mb_id);
	$reg_datetime = substr($row['reg_datetime'], 0,10);
?>

	<tr>
		<td><?php echo $mb_id; ?></td>
		<td><?php echo get_text($row['mb_name']); ?></td>
		<td><?php echo get_point_name($point_gubun); ?></td>
		<td><?php if($point_gubun == "c") echo $row['point_gen']; ?></td>
		<td style="text-align:right"><?php echo number_format($row['point_point']); ?></td>
		<td style="text-align:right"><?php echo number_format($row['point_sum']);?></td>
		<td style="text-align:right"><?php echo number_format($point_sum);?></td>
		<td><?php if($point_gubun == "c") echo $row['rec_mb_id']; ?></td>
		<td><?php echo $row['point_memo']; ?></td>
		<td><?php echo $reg_datetime; ?></td>
	</tr>

<?php
}

sql_free_result($result);
?>
    </table>
</body>
</html>