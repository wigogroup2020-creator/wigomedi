<?php
$sub_menu = "100303";
require_once './_common.php';

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '문의하기';
require_once './admin.head.php';
?>

<div class="tbl_head01 tbl_wrap">
	<table>
		<caption><?php echo $g5['title']; ?> 목록</caption>
		<thead>
			<tr>
				<th scope="col">아이디(회원일때)</th>
				<th scope="col">이름</th>
				<th scope="col">연락처</th>
				<th scope="col">업체명</th>
				<th scope="col">문의유형</th>
				<th scope="col">내용</th>
				<th scope="col">등록일</th>
				<th scope="col">처리여부</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$sql = "select * from p_contact order by contact_no desc ";
			$result = sql_query($sql);

			for ($i = 0; $row = sql_fetch_array($result); $i++) {
				$bg = 'bg' . ($i % 2);
			?>

				<tr class="<?php echo $bg; ?>">
					<td><?php echo $row['mb_id']; ?></td>
					<td><?php echo $row['mb_name']; ?></td>
					<td><?php echo $row['mb_hp']; ?></td>
					<td><?php echo $row['contact_company']; ?></td>
					<td><?php echo $row['contact_kind']; ?></td>
					<td><?php echo $row['contact_content']; ?></td>
					<td><?php echo $row['reg_datetime']; ?></td>
					<td>
						<?php
						if($row['confirm_yn'] == "n"){
						?>
							<input type="button" value="통화완료" onclick="f_confirm('<?php echo $row['contact_no'];?>')" class="btn btn_03" style="cursor:pointer">
						<?php
						}else{
							echo $row['confirm_date'];
						}
						?>
					</td>
				</tr>

			<?php
			}
			
			if($i == 0){
				echo "<tr><td colspan='8' class=\"empty_table\">내용이 없습니다.</td></tr>";
			}
			?>
		</tbody>
	</table>
</div>


<script>
function f_confirm(contact_no){
	if(confirm("통화완료 하였습니까?")){
		location.href = "./p_contact_update.php?contact_no="+contact_no;
	}
}
</script>
<?php
require_once './admin.tail.php';
?>