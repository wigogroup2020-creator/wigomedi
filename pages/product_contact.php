<!-- alert안떠서 z-index 조정 -->
<style>
.modal {z-index:1000;}
</style>
<div class="modal">
	<div class="modal_body">
		<h2>문의하기</h2>
			<form name="fcontact" method="post" action="./m23_update.php">
				<input type="hidden" name="mb_id" value="<?php echo $member['mb_id'];?>">
				<div class="form_box">
					<ul>
						<li>
							<label for="mb_name">성함<span> *</span></label>
							<input type="text" name="mb_name" placeholder="성함입력" id="mb_name" required value="<?php echo $member['mb_name'];?>">
						</li>
						<li>
							<label for="mb_hp">연락처<span> *</span></label>
							<input type="text" name="mb_hp" id="mb_hp" placeholder="'-'제외하고 숫자만 입력" pattern="[0-9]{2,3}-[0-9]{3,4}-[0-9]{3,4}" maxlength="11" required value="<?php echo $member['mb_hp'];?>">
						</li>
						<li>
							<label for="contact_company">업체명</label>
							<input type="text" name="contact_company" placeholder="업체명입력" id="contact_company" required>
						</li>
						<li>
							<label for="contact_kind">상품유형<span> *</span></label>
							<select name="contact_kind" id="contact_kind">
								<?php
                                $current_product_no = isset($_GET['product_no']) ? intval($_GET['product_no']) : 0;
								$sql = "select * from p_product where use_yn = 'y' order by product_kind";
								$result = sql_query($sql);
                                
                                $selected_product = null;
                                if ($current_product_no > 0) {
                                    $sql = "SELECT * FROM p_product WHERE product_no = '{$current_product_no}' AND use_yn = 'y'";
                                    $selected_product = sql_fetch($sql);
                                }
                                $options = [];

                                // 전체 제품 목록 조회
                                $sql = "SELECT * FROM p_product WHERE use_yn = 'y' ORDER BY product_kind";
                                $result = sql_query($sql);

                                while ($row = sql_fetch_array($result)) {
                                    $options[] = $row;
                                }

                                // 선택된 제품이 있을 경우 맨 앞으로 이동
                                if ($selected_product) {
                                    // product_no로 일치하는 항목 제거
                                    $options = array_filter($options, function($item) use ($selected_product) {
                                        return $item['product_no'] != $selected_product['product_no'];
                                    });

                                    // 배열 맨 앞에 삽입
                                    array_unshift($options, $selected_product);
                                }

                                foreach ($options as $row) {
                                    echo "<option value='{$row['product_subject']}'>{$row['product_subject']}</option>";
                                }
								?>
								<!-- <option value="revivecell">revivecell</option>
								<option value="newbex250">newbex250</option>
								<option value="newbex450">newbex450</option>
								<option value="newbex650">newbex650</option>
								<option value="newbex850">newbex850</option>
								<option value="newbex1.25">newbex1.25</option>
								<option value="allvis">allvis</option> -->
							</select>
						</li>
						<li>
							<label for="contact_content">문의내용</label>
							<textarea class="form-control" type="text" name="contact_content" id="contact_content" style="height: 65px; padding: 12px 18px 16px;"></textarea>
						</li>
					</ul>
				</div>
				<div class="agree_box">
					<input type="checkbox" name="startup_agree" id="agree_check" value="y" checked>
					<label for="agree_check" class="check_img"></label>
					<label for="agree_check">[필수] 개인정보 수집ㆍ이용</label>
					<a href="<?php echo G5_URL;?>/pages/service_company.html" target=”_blank” >[내용보기]</a>
				</div>
				<div class="foun_btn">
					<button type="button" value="보내기" style="cursor:pointer" onclick="f_contact()">신청하기</button>
				</div>
			</form>
	</div>
</div>

<script>
function f_contact(){
	var mb_name = $("#mb_name").val();
	var mb_hp = $("#mb_hp").val();
	var contact_company = $("#contact_company").val();
	var contact_content = $("#contact_content").val();
	
	const checkbox = document.getElementById("agree_check");
    if (!checkbox.checked){
		Swal.fire("", "문의 등록시 개인정보 수집ㆍ이용에 동의해 주셔야 합니다.", "error");
		return;
    }
	
	if(mb_name == ""){
		Swal.fire("", "이름을 입력해주세요.", "error");
		return;
	}
	
	if(mb_hp == ""){
		Swal.fire("", "연락처를 입력해주세요.", "error");
		return;
	}
	
	if(contact_company == ""){
		Swal.fire("", "업체명을 입력해주세요.", "error");
		return;
	}
	
	if(contact_content == ""){
		Swal.fire("", "문의내용을 입력해주세요.", "error");
		return;
	}
	
	var frm = document.fcontact;
	frm.submit();
}
</script>