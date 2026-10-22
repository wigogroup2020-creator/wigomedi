<?php
$sub_menu = "100304";
require_once './_common.php';
require_once G5_EDITOR_LIB;
require_once G5_LIB_PATH . '/product.lib.php';

auth_check_menu($auth, $sub_menu, 'w');

$sql = "select * from p_product where product_no = '".$product_no."'";
$result = sql_fetch($sql);
$use_yn = $result['use_yn'];

if($product_no == ""){
	$use_yn = "y";
}

$g5['title'] .= '제품';
require_once './admin.head.php';
?>

<form name="fproduct" id="fproduct" action="./p_product_form_update.php" onsubmit="return fproduct_submit(this);" method="post" enctype="multipart/form-data">
    <input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="product_no" value="<?php echo $product_no; ?>">

    <div class="tbl_frm01 tbl_wrap">
        <table>
            <tbody>
				<tr>
                    <th scope="row">분류</th>
                    <td>
                        <select name="product_kind">
							<option value="그로바이오" <?php if($result['product_kind'] == "그로바이오") echo "selected";?>>그로바이오 (홈페이지 PRODUCT 표시)</option>
							<option value="제휴제품" <?php if($result['product_kind'] == "제휴제품") echo "selected";?>>제휴제품 (홈페이지 PRODUCT 표시)</option>
							<option value="Newbex" <?php if($result['product_kind'] == "Newbex") echo "selected";?>>Newbex (기존 · 홈페이지 미표시)</option>
							<option value="HIFU+LDM" <?php if($result['product_kind'] == "HIFU+LDM") echo "selected";?>>HIFU+LDM (제휴제품에 함께 표시)</option>
							<option value="ReviveCell" <?php if($result['product_kind'] == "ReviveCell") echo "selected";?>>ReviveCell (기존 · 홈페이지 미표시)</option>
						</select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">제품명</th>
                    <td>
                        <input type="text" name="product_subject" value="<?php echo $result['product_subject'] ?>" id="product_subject" class="frm_input" style="width:100%">
                    </td>
                </tr>
				<tr>
                    <th scope="row">간략설명</th>
                    <td>
                        <input type="text" name="product_info" value="<?php echo $result['product_info'] ?>" id="product_info" class="frm_input" style="width:100%">
                    </td>
                </tr>
				<tr>
                    <th scope="row">제품가격</th>
                    <td>
                        <input type="text" name="product_price" value="<?php echo number_format($result['product_price']); ?>" id="product_price" class="frm_input">
                    </td>
                </tr>
				<tr>
                    <th scope="row">회원가</th>
                    <td>
                        <input type="text" name="product_price_member" value="<?php echo number_format($result['product_price_member']); ?>" id="product_price_member" class="frm_input">
                    </td>
                </tr>
				<tr>
                    <th scope="row">영업사원가</th>
                    <td>
                        <input type="text" name="product_price_sales" value="<?php echo number_format($result['product_price_sales']); ?>" id="product_price_sales" class="frm_input">
                    </td>
                </tr>
				<tr>
                    <th scope="row">대리점가</th>
                    <td>
                        <input type="text" name="product_price_branch" value="<?php echo number_format($result['product_price_branch']); ?>" id="product_price_branch" class="frm_input">
                    </td>
                </tr>
				<tr>
                    <th scope="row">총판가</th>
                    <td>
                        <input type="text" name="product_price_chong" value="<?php echo number_format($result['product_price_chong']); ?>" id="product_price_chong" class="frm_input">
                    </td>
                </tr>
				<tr>
                    <th scope="row">대표이미지</th>
                    <td>
                        <input type="file" name="product_file" id="product_file" class="frm_input">
						<?php
						if($result['product_file']){
							$gw_img = wigo_prod_file_url($result['product_file']);
							if ($gw_img !== '') echo "<img src='".wigo_prod_e($gw_img)."' style='width:200px'>";
						}
						?>
                    </td>
                </tr>
				<tr>
                    <th scope="row">사용여부</th>
                    <td>
                        <input type="radio" name="use_yn" id="use_yn_y" value="y" <?php if($use_yn == "y") echo "checked";?>> 
						<label for="use_yn_y">예</label> &nbsp; 
						<input type="radio" name="use_yn" id="use_yn_n" value="n" <?php if($use_yn == "n") echo "checked";?>> 
						<label for="use_yn_n">아니오</label>
                    </td>
                </tr>
                <tr>
                    <th scope="row">내용</th>
                    <td>
						1. 이미지클릭 후 사진크기조절<br/>
						2. 이미지는 최대 가로 1024px로 업로드 (이미지크기 최대 3M 권장)<br/>
						3. 이미지삭제시 이미지오른쪽에 깜박이는 커서를 놓고 백스페이스키로 삭제
						<?php echo editor_html("product_content", get_text(html_purifier($result['product_content']), 0)); ?>
					</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="btn_fixed_top">
        <a href="./p_product.php" class="btn btn_02">목록</a> 
        <input type="button" value="저장" class="btn_submit btn" onclick="f_ok()" style="cursor:pointer">
    </div>
</form>

<script>
function f_ok(){
	<?php
	echo get_editor_js("product_content");
	?>


	var product_subject = $("#product_subject").val();
	var product_info = $("#product_info").val();
	
	if(product_subject == ""){
		alert("제품명을 입력해주세요.");
		return;
	}
	
	if(product_info == ""){
		alert("간략설명을 입력해주세요.");
		return;
	}

	var frm = document.fproduct;
	frm.action = "./p_product_form_update.php";
	frm.submit();
}
</script>

<?php
require_once './admin.tail.php';
?>