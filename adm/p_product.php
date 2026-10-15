<?php
$sub_menu = "100304";
require_once './_common.php';

auth_check_menu($auth, $sub_menu, 'r');

$g5['title'] = '제품관리';
require_once './admin.head.php';
?>

<form name="fproduct" id="fproduct" action="./p_product_update.php" onsubmit="return fproduct_submit(this);" method="post">
	<input type="hidden" name="token" value="">
	<input type="hidden" name="w" value="u" id="check_w">

	<div class="tbl_head01 tbl_wrap">
		<table>
			<caption><?php echo $g5['title']; ?> 목록</caption>
			<thead>
				<tr>
					<th scope="col" id="mb_list_chk">
						<label for="chkall" class="sound_only">전체</label>
						<input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
					</th>
					<th scope="col">분류</th>
					<th scope="col">제품명</th>
					<th scope="col">가격</th>
					<th scope="col">간략설명</th>
					<th scope="col">대표이미지</th>
					<th scope="col">사용여부</th>
					<th scope="col">등록자</th>
					<th scope="col">등록일</th>
					<th scope="col">수정</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$sql = "select * from p_product order by product_no desc ";
				$result = sql_query($sql);

				for ($i = 0; $row = sql_fetch_array($result); $i++) {
					$bg = 'bg' . ($i % 2);
				?>

					<tr class="<?php echo $bg; ?>">
						<td headers="mb_list_chk" class="td_chk">
							<input type="hidden" name="product_no[<?php echo $i ?>]" value="<?php echo $row['product_no'] ?>" id="product_no_<?php echo $i ?>">
							<input type="checkbox" name="chk[]" value="<?php echo $i ?>" id="chk_<?php echo $i ?>">
						</td>
						<td><?php echo $row['product_kind']; ?></td>
						<td><?php echo $row['product_subject']; ?></td>
						<td style="text-align:right">
							<?php
							echo "정상가 : ".number_format($row['product_price']);
							echo "<div style='color:#ff0000'>회원가 : ".number_format($row['product_price_member'])."</div>";
							echo "영업가 : ".number_format($row['product_price_sales'])."</div>";
							echo "<div style='color:#ff0000'>대리점 : ".number_format($row['product_price_branch'])."</div>";
							echo "총판가 : ".number_format($row['product_price_chong'])."</div>";
							?>
						</td>
						<td style="text-align:left"><?php echo $row['product_info']; ?></td>
						<td>
							<?php
							if($row['product_file']){
								echo "<img src='".G5_URL."/data/product/".$row['product_file']."' style='width:100px'>";
							}
							?>
						</td>
						<td>
							<input type="radio" name="use_yn[<?php echo $i ?>]" id="use_yn_y_<?php echo $i;?>" value="y" <?php if($row['use_yn'] == "y") echo "checked";?>> 
							<label for="use_yn_y_<?php echo $i;?>">예</label> &nbsp; 
							<input type="radio" name="use_yn[<?php echo $i ?>]" id="use_yn_n_<?php echo $i;?>" value="n" <?php if($row['use_yn'] == "n") echo "checked";?>> 
							<label for="use_yn_n_<?php echo $i;?>">아니오</label>
						</td>
						<td><?php echo $row['reg_mb_id']; ?></td>
						<td><?php echo $row['reg_datetime']; ?></td>
						<td>
							<input type="button" value="수정" onclick="f_view('<?php echo $row['product_no'];?>')" class="btn btn_03" style="cursor:pointer"> 
						</td>
					</tr>

				<?php
				}
				
				if($i == 0){
					echo "<tr><td colspan='9' class=\"empty_table\">내용이 없습니다.</td></tr>";
				}
				?>
			</tbody>
		</table>
	</div>

	<div class="btn_fixed_top">
		<input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="btn btn_03" style="cursor:pointer"> 
		<input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn btn_01" style="cursor:pointer"> 
		<input type="button" value="제품등록" onclick="f_view('')" class="btn btn_03" style="cursor:pointer"> 
	</div>
</form>


<script>
function fproduct_submit(f){
    if (!is_checked("chk[]")) {
        alert(document.pressed+" 하실 항목을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
            return false;
        }

		$("#check_w").val("d");

    }else{
		// 수정
		$("#check_w").val("u");
    }

    return true;
}

function f_view(product_no){
	if(product_no){
		location.href = "./p_product_form.php?w=u&product_no="+product_no;
	}else{
		location.href = "./p_product_form.php?w=";
	}
}
</script>
<?php
require_once './admin.tail.php';
?>