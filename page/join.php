<?php
require_once './_common.php';
include_once(G5_PATH.'/e_head_guest.php');
add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js

if($member['mb_id']){
	goto_url(G5_BBS_URL."/logout.php");
}

$mb_center = get_center($mb_recommend);
?>
<style>
#mb_spon option {
  color: black !important;     /* 글자색을 검정으로 */
  background-color: white !important; /* 배경을 흰색으로 */
}
</style>
<div class="account-pages join">
	<div class="row justify-content-center">
		<div class="col-xxl-6 col-lg-6">
			<div class="card" style="margin:0px">
				<div class="mt-3 mb-3 text-style">회원가입</div>

				<div class="card-body" style="padding:0">
					<form name="fjoin" method="post" action="./join_update.php" class="form-horizontal">
						<div class="mb-1">
							<label for="mb_id" class="col-4 col-form-label">아이디 <span style="color:var(--main-color02)">*</span></label>
							<input type="text" name="mb_id" class="form-control" id="mb_id">
						</div>
						<div class="mb-1">
							<label for="mb_password" class="col-4 col-form-label">비밀번호 <span style="color:var(--main-color02)">*</span></label>
							<div class="input-group input-group-merge">
								<input type="password" id="mb_password" name="mb_password" class="form-control" placeholder="PASSWORD" autocomplete="new-password">
								<div class="input-group-text" data-password="false">
									<span class="password-eye"></span>
								</div>
							</div>
						</div>
								
						<div class="mb-1">
							<label for="mb_password_re" class="col-4 col-form-label">비밀번호확인 <span style="color:var(--main-color02)">*</span></label>
							<div class="input-group input-group-merge">
								<input type="password" id="mb_password_re" name="mb_password_re" class="form-control" placeholder="PASSWORD" autocomplete="new-password">
								<div class="input-group-text" data-password="false">
									<span class="password-eye"></span>
								</div>
							</div>
						</div>
						
						<div class="mb-1">
							<label for="mb_name" class="col-4 col-form-label">이름 <span style="color:var(--main-color02)">*</span></label>
							<input type="text" name="mb_name" class="form-control" id="mb_name">
						</div>
						<div class="mb-1">
							<label for="mb_hp" class="col-4 col-form-label">연락처 <span style="color:var(--main-color02)">*</span></label>
							<input type="text" name="mb_hp" class="form-control" id="mb_hp">
						</div>
						<div class="mb-1">
							<label for="mb_email" class="col-4 col-form-label">이메일</label>
							<input type="text" name="mb_email" class="form-control" id="mb_email">
						</div>
						
						<div class="mb-1" style="display:none">
							<label for="mb_center" class="col-4 col-form-label">센터 <span style="color:var(--main-color02)">*</span></label>
							<div>
								<input type="text" name="mb_center" class="form-control" id="mb_center" value="<?php echo $mb_center;?>" readonly>
							</div>
						</div>
						
						<div class="mb-1">
							<label for="mb_recommend" class="col-4 col-form-label">추천인 <span style="color:var(--main-color02)">*</span></label>
							<div>
								<input type="text" name="mb_recommend" class="form-control" id="mb_recommend" value="<?php echo $mb_recommend;?>" onblur="f_spon_search()">
							</div>
						</div>
						<div class="mb-3">
							<label for="mb_spon" class="col-4 col-form-label">후원인 <span style="color:var(--main-color02)">*</span></label>
							<div>
								<select name="mb_spon" id="mb_spon" class="form-select">
									<?php
									$spon_cnt = get_spon_cnt($mb_recommend);
									if($spon_cnt < 2){
										echo "<option value='".$mb_recommend."'>".$mb_recommend."</option>";
									}
									
									echo get_all_spon_sub($mb_recommend);
									?>
								</select>
							</div>
						</div>

						<div class="mb-1 d-grid">
							<button class="btn btn-primary" type="button" onclick="f_join()">회원가입</button>
						</div>
					</form>
				</div> <!-- end card-body -->
			</div>
			<!-- end card -->


		</div> <!-- end col -->
	</div>
	<!-- end row -->



<script>
function f_join(){
	var mb_id = $("#mb_id").val();
	var mb_password = $("#mb_password").val();
	var mb_password_re = $("#mb_password_re").val();
	var mb_name = $("#mb_name").val();
	var mb_recommend = $("#mb_recommend").val();
	var mb_spon = $("#mb_spon").val();
	//var mb_center = $("#mb_center").val();
	/*
	if(mb_center == ""){
		Swal.fire("", "센터가 없습니다.", "error");
		return;
	}
	*/

	if(mb_id == ""){
		Swal.fire("", "아이디를 입력해주세요.", "error");
		return;
	}

	if(mb_name == ""){
		Swal.fire("", "이름을 입력해주세요.", "error");
		return;
	}

	mb_password = mb_password.replace(/\s+/g, "");

	if(mb_password != mb_password_re){
		Swal.fire("", "비밀번호가 다릅니다.", "error");
		return;
	}

	const passwordPattern = /^.{6,}$/;

    if (passwordPattern.test(mb_password)) {
    }else{
		Swal.fire("", "비밀번호는 6자 이상으로 입력해주세요.", "error");
		return;
    }
	
	var mb_id_check = "";
	$.ajax({
		async: false,
		cache: false,
		type: "POST",
		url: "<?php echo G5_BBS_URL;?>/ajax.mb_id_check.php",
		data: {mb_id: mb_id},
		success: function(result) {
			mb_id_check = result;
        }
	});

	if(mb_id_check == "y"){
		Swal.fire("", "이미 존재하는 아이디 입니다.", "error");
		return;
	}
	
	if(mb_id == mb_recommend){
		Swal.fire("", "본인을 추천할 수 없습니다.", "error");
		return;
	}
	
	if(mb_id == mb_spon){
		Swal.fire("", "본인을 후원할 수 없습니다.", "error");
		return;
	}

	var mb_rec_check = "";
	var mb_spon_check = "";

	if(mb_recommend == ""){
		Swal.fire("", "추천인이 없습니다.", "error");
		return;
		
	}else{
		$.ajax({
			async: false,
			cache: false,
			type: "POST",
			url: "<?php echo G5_BBS_URL;?>/ajax.mb_id_check.php",
			data: {mb_id: mb_recommend},
			success: function(result) {
				mb_rec_check = result;
			}
		});	
	}
	
	if(mb_rec_check == ""){
		Swal.fire("", "추천인이 존재하지 않습니다.", "error");
		$("#mb_recommend").val("");
		$("#mb_spon").html("");
		return;
		
	}
	
	if(mb_spon == ""){
		Swal.fire("", "후원인을 선택해주세요.", "error");
		return;
		
	}else{
		$.ajax({
			async: false,
			cache: false,
			type: "POST",
			url: "<?php echo G5_BBS_URL;?>/ajax.check_mb_spon.php",
			data: {mb_spon: mb_spon},
			success: function(result) {
				mb_spon_check = result;
			}
		});	
	}

	if(mb_spon_check == ""){
		Swal.fire("", "후원인이 존재하지 않습니다.", "error");
		$("#mb_spon").html("");
		return;
		
	}else{
		var frm = document.fjoin;
		frm.submit();
	}
}

function f_spon_search(){
	var mb_recommend = $("#mb_recommend").val();
	
	if(mb_recommend == ""){
		Swal.fire("", "추천인을 입력해주세요.", "error");
		return;
	}else{
		var mb_rec_check = "";
		
		$.ajax({
			async: false,
			cache: false,
			type: "POST",
			url: "<?php echo G5_BBS_URL;?>/ajax.mb_id_check.php",
			data: {mb_id: mb_recommend},
			success: function(result) {
				mb_rec_check = result;
			}
		});
		
		if(mb_rec_check == ""){
			Swal.fire("", "추천인이 존재하지 않습니다.", "error");
			$("#mb_recommend").val("");
			$("#mb_spon").html("");
			return;
			
		}
	}

	$.ajax({
		async: false,
		cache: false,
		type: "POST",
		url: "<?php echo G5_BBS_URL;?>/ajax.mb_spon_search.php",
		data: {mb_id: mb_recommend},
		success: function(result) {
			$("#mb_spon").html(result);
		}
	});
}

//f_spon_search();
</script>

<?php
include_once(G5_PATH.'/e_tail.php');

function get_all_spon_sub($mb_id){
	$str_return = "";
	
	$sql = "SELECT * FROM g5_member WHERE mb_spon = '".addslashes($mb_id)."' ORDER BY mb_no";
	$result = sql_query($sql);

	while ($row = sql_fetch_array($result)) {
		$mb_id2 = $row['mb_id'];

		$spon_cnt = get_spon_cnt($mb_id2);
		if ($spon_cnt < 2) {
			$str_return .= "<option value='{$mb_id2}'>{$mb_id2}</option>";
		}

		// 하위가 몇 명이든 관계없이 재귀 탐색은 계속 진행
		$str_return .= get_all_spon_sub($mb_id2);
	}

	return $str_return;
}
?>

<script src="<?php echo G5_JS_URL;?>/jquery-migrate-1.4.1.min.js" type="text/javascript"></script>
<script src="<?php echo G5_JS_URL;?>/jquery.autocomplete.js" type="text/javascript"></script>
<link href="<?php echo G5_CSS_URL;?>/jquery.autocomplete.css" rel="stylesheet" type="text/css">

<script>
// 자동완성 시작
var availableTags = [];

<?php
$sql_auto = "select mb_id from g5_member ";
$result_auto = sql_query($sql_auto);

for($a=0;$row_auto=sql_fetch_array($result_auto);$a++){
	echo "availableTags[".$a."] = '".$row_auto['mb_id']."';";
}
?>

$(document).ready(function() {
	$("#mb_recommend").autocomplete(availableTags,{
		minChars: 3,
		max: 20,
		autoFill: false,
		selectFirst: false,
		scrollHeight: 500,
		matchContains: true
	});
});
// 자동완성 끝
</script>