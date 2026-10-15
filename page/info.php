<?php
include_once('./_common.php');
include_once(G5_PATH.'/newbex_head.php');

// include_once(G5_PATH.'/e_head.php');

$mb_id = $member['mb_id'];
?>

<style>
.form-label {color:#000}
.col-form-label {color:#000}
.form-control {color:#000}
.form-control:focus {
    color: black !important;
    background-color: white !important;
}
</style>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js" async></script>
<main class="container">
	<div id="contents">
		<div class="pageTop pn7">
			<div class="bg"></div>
			<div class="inner">
				<h1 class="pageSlg">회원서비스</h1>
			</div>
		</div>
		<div class="pageTitleArea pn7">
			<div class="inner">
				<ul>
					<li><a href="index.html">Home</a></li>
					<li>회원서비스</li>
				</ul>
			</div>
		</div>
		<div class="page m70 infoPage">
			<div class="inner">
				<h1>마이페이지</h1>
				<form name="fmember" method="post" enctype="multipart/form-data">
					<input type="hidden" name="w" value="u">
					<div class="form_box">
						<ul>
							<li>
								<label for="mb_id" class="col-4 col-form-label">ID <span style="color:#ff3300">*</span></label>
								<input class="form-control" type="text" name="mb_id" id="mb_id" value="<?php echo $mb_id;?>" readonly>
							</li>
							<li>
								<label for="mb_name" class="col-4 col-form-label">이름 <span style="color:#ff3300">*</span></label>
								<input class="form-control" type="text" name="mb_name" id="mb_name" value="<?php echo $member['mb_name'];?>">
							</li>
							<li>
								<label for="mb_hp" class="col-4 col-form-label">연락처 <span style="color:#ff3300">*</span></label>
								<input class="form-control" type="text" name="mb_hp" id="mb_hp" value="<?php echo $member['mb_hp'];?>">
							</li>
							
							<li>
								<label for="mb_email" class="col-4 col-form-label">Email</label>
								<input class="form-control" type="text" name="mb_email" id="mb_email" value="<?php echo $member['mb_email'];?>">
							</li>
							<li>
								<label for="bank_name" class="col-4 col-form-label">은행명</label>
									<input type="text" name="bank_name" class="form-control" id="bank_name" value="<?php echo $member['bank_name'];?>">
							</li>
							<li>
								<label for="bank_owner" class="col-4 col-form-label">예금주</label>
									<input type="text" name="bank_owner" class="form-control" id="bank_owner" value="<?php echo $member['bank_owner'];?>">
							</li>
							<li>
								<label for="bank_account" class="col-4 col-form-label">계좌번호</label>
									<input type="text" name="bank_account" class="form-control" id="bank_account" value="<?php echo $member['bank_account'];?>">
							</li>

					
							<ul>
								<li>
									<label for="mb_zip" class="form-label"> 주소</label>
									<div class="adress-input">
										<input type="text" name="mb_zip" id="reg_mb_zip" value="<?php echo $member['mb_zip1'];?>" class="form-control" readonly="" placeholder="우편번호">
										<button type="button" class="btn btn-primary" onclick="win_zip('fmember', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button>
									</div>
								</li>
								<li>
									<label for="mb_addr1">기본주소</label>
									<input type="text" name="mb_addr1" id="reg_mb_addr1" class="form-control" placeholder="기본주소" value="<?php echo $member['mb_addr1'];?>">
								</li>
								<li>
									<label for="mb_addr2">상세주소</label>
									<input type="text" name="mb_addr2" id="reg_mb_addr2" class="form-control" placeholder="상세주소" value="<?php echo $member['mb_addr2'];?>">
								</li>

								<input type="hidden" name="mb_addr3" id="reg_mb_addr3">
								<input type="hidden" name="mb_addr_jibeon">
							</ul>
							
							<li>
								<label for="mb_password" class="col-4 col-form-label">변경 비밀번호</label>
								<div class="input-group">
									<input type="password" name="mb_password" id="mb_password" class="form-control" autocomplete="new-password">
									<div class="input-group-text" data-password="false"></div>
								</div>
							</li>
							<li>
								<label for="mb_password_re" class="col-4 col-form-label">비밀번호 확인</label>
								<div class="input-group">
									<input type="password" name="mb_password_re" id="mb_password_re" class="form-control" autocomplete="new-password">
									<div class="input-group-text" data-password="false"></div>
								</div>
							</li>
						</ul>
					</div>

					<div class="foun_btn"><button type="button" onclick="f_save()">수정하기</button></div>
				</form>
				<!-- 로그아웃 기능 넣어야함 -->
				<button class="logout_btn">로그아웃</button>
			</div>
		</div>
	</div>
</main>

<script>
function f_save(){
	var mb_password = $("#mb_password").val();
	var mb_password_re = $("#mb_password_re").val();
	var mb_name = $("#mb_name").val();

	if(mb_name == ""){
		Swal.fire("", "이름을 입력해주세요.", "error");
		return;
	}

	mb_password = mb_password.replace(/\s+/g, "");

	if(mb_password != mb_password_re){
		Swal.fire("", "비밀번호가 다릅니다.", "error");
		return;
	}
	
	var frm = document.fmember;
	frm.action = "./info_update.php";
	frm.submit();
}
</script>
<?php
include_once(G5_PATH."/newbex_tail.php");

// include_once(G5_PATH.'/e_tail.php');
?>