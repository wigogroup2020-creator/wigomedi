<?php
require_once './_common.php';

include_once(G5_PATH.'/e_head_guest.php');

if($member['mb_id']){
	goto_url(G5_BBS_URL."/logout.php");
}
?>

	<div class="account-pages">
		<div class="row justify-content-center">
			<div class="col-xxl-6 col-lg-6">
				<div class="card" style="margin:0px">
                    <div class="mt-3 mb-3 text-style">
                        비밀번호 찾기 
                    </div>

					<div class="card-body" style="padding:0">
						<form name="fpass" method="post" action="<?php echo G5_URL;?>/page/pass_confirm.php">
                            <div class="mb-2">
                                <input class="form-control text-white" type="text" name="mb_id" id="mb_id" required="" placeholder="LOGIN ID">
							</div>

							<div class="mb-3">
								<input type="text" name="mb_email" id="mb_email" class="form-control" placeholder="Email Address" autocomplete="new-password">
							</div>

							<div class="mb-3" id="cert_div" style="display:none">
								<div class="input-group">
                                    <input type="text" class="form-control" id="cert_code" placeholder="인증코드" aria-label="인증코드">
									<input type="text" class="form-control" id="cert_count" value="03:00">
									<button class="btn btn-dark" type="button" onclick="f_cert()">확인</button>
								</div>
							</div>
							<div class="mb-2 d-grid">
                                <button class="btn btn-primary rounded" type="button" onclick="f_find()" id="btn_auth">인증코드 요청</button>
								<button class="btn btn-primary rounded" type="button" onclick="f_find()" style="display:none;" id="btn_re">인증코드 재전송</button>
							</div>
                            
                            <div class="d-grid"><button class="btn btn-danger rounded" type="button" onclick="f_qna()">이메일이 기억나지 않나요?</button></div>
						</form>
					</div> <!-- end card-body -->
				</div>
				<!-- end card -->


			</div> <!-- end col -->
		</div>
		<!-- end row -->
	</div>
	<!-- end page -->
</div>

<script>
function f_find(){
	var mb_id = $("#mb_id").val();
	var mb_email = $("#mb_email").val();

	if(mb_id == ""){
		Swal.fire("", "아이디를 입력해주세요.", "error");
		return;
	}

	if(mb_email == ""){
		Swal.fire("", "이메일주소를 입력해주세요.", "error");
		return;
	}

	const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // 이메일 형식 정규식

	if (emailPattern.test(mb_email)) {
		// ok
	} else {
		Swal.fire("", "이메일 형식이 올바르지 않습니다.", "error");
		return;
	}

	var mb_id_check = "";
	$.ajax({
		async: false,
		cache: false,
		type: "POST",
		url: "<?php echo G5_BBS_URL;?>/ajax.cert_send.php",
		data: {mb_id: mb_id, mb_email: mb_email},
		success: function(result) {
			mb_id_check = result;
        }
	});

	if(mb_id_check == "y"){
		Swal.fire("", "이메일주소로 인증코드를 전송했습니다.<br/>스팸함도 확인해주세요.", "info");
		$("#btn_auth").hide();
		$("#btn_re").show();

		$("#cert_div").show();

		startCountdown();
	}else{
		Swal.fire("", "회원정보가 없습니다.", "error");
		return;
	}
}

function f_cert(){
	var cert_code = $("#cert_code").val();
	var mb_id = $("#mb_id").val();

	if(cert_code == ""){
		Swal.fire("", "인증코드를 입력해주세요.", "error");
		return;
	}

	var cert_check = "";
	$.ajax({
		async: false,
		cache: false,
		type: "POST",
		url: "<?php echo G5_BBS_URL;?>/ajax.cert_check.php",
		data: {mb_id: mb_id, cert_code: cert_code},
		success: function(result) {
			cert_check = result;
        }
	});

	if(cert_check == "n"){
		Swal.fire("", "인증코드가 틀렸습니다.", "error");
		$("#cert_code").val("");
		return;

	}else{
		var frm = document.fpass;
		frm.submit();
	}
}

function startCountdown() {
	let countDownTime = 180; // 3분 = 180초
	const certCountElem = document.getElementById('cert_count');

	const timer = setInterval(() => {
		const minutes = Math.floor(countDownTime / 60).toString().padStart(2, '0');
		const seconds = (countDownTime % 60).toString().padStart(2, '0');
		certCountElem.value = `${minutes}:${seconds}`;

		if (countDownTime <= 0) {
			clearInterval(timer);
			Swal.fire("", "시간초과로 인증코드를 재전송합니다.", "error");
			f_find();
		}

		countDownTime--;
	}, 1000);
}

function f_qna(){
	location.href = "./qna.php";
}
</script>

<?php
include_once(G5_PATH.'/e_tail.php');
?>