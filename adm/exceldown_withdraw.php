<?php
$sub_menu = "100302";
include_once('./_common.php');
auth_check_menu($auth, $sub_menu, 'd');
echo '<meta charset="utf-8">';

$down_name = "withdraw_".G5_TIME_YMD;

header("Content-Type: application/vnd.ms-excel"); 
header("Content-Type: application/x-msexcel"); 
header("Content-Disposition: attachment; filename=".$down_name.".xls");
header("Content-Description: PHP4 Generated Data" ); 

$sql = " select a.*, b.mb_name, b.mb_email from p_withdraw a left join g5_member b on a.mb_id = b.mb_id order by b.mb_name ";
$result = sql_query($sql);
?>

<html>
<body bgcolor="#FFFFFF">
<table border="1" style="table-layout:fixed">
	<tr>
        <th>아이디</th>
		<th>이름</th>
		<th>출금요청액</th>
		<th>수수료</th>
		<th>실제출금액</th>
		<th>보유보너스</th>
		<th>출금주소</th>
		<th>요청일시</th>
		<th>승인일시</th>
	</tr>
<?php
for ($i=0; $row=sql_fetch_array($result); $i++){ 
	$mb_id = $row['mb_id'];
	$withdraw_p = $row['withdraw_p'];
	$withdraw_fee = $row['withdraw_fee'];
	$withdraw_real = $withdraw_p-$withdraw_fee;
	$bonus_sum = get_sum_point($mb_id);
?>

	<tr>
		<td><?php echo $mb_id; ?></td>
		<td><?php echo get_text($row['mb_name']); ?></td>
		<td style="text-align:right"><?php echo number_format($withdraw_p); ?></td>
		<td style="text-align:right"><?php echo number_format($withdraw_fee); ?></td>
		<td style="color:#ff0000;text-align:right"><?php echo number_format($withdraw_real); ?></td>
		<td style="text-align:right"><?php echo number_format($bonus_sum);?></td>
		<td><?php echo $row['bank_info']; ?></td>
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