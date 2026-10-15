<?php
require_once './_common.php';

include_once(G5_PATH.'/e_head_guest.php');

if($member['mb_id']){
	goto_url(G5_BBS_URL."/logout.php");
}
?>

	<div class="account-pages login">
		<div class="justify-content-center">
			<div class="col-12">
				<div class="card" style="margin:0px">
					<div class="text-center h3 text-white"><img src="<?php echo G5_IMG_URL;?>/favicon.png" style="height:80px"> <?php echo $config['cf_title'];?></div>
					<div class="justify-content-center">
						<div class="col-lg-12">
							<div class="card-body p-2">
								<form name="flogin" method="post" action="<?php echo G5_BBS_URL;?>/login_check.php">
									<div class="mb-2">
										<input class="form-control" type="text" name="mb_id" id="mb_id" required="" placeholder="LOGIN ID">
									</div>

									<div class="mb-3">
										<div class="input-group input-group-merge">
											<input type="password" id="mb_password" name="mb_password" class="form-control" placeholder="PASSWORD" autocomplete="new-password">
											<div class="input-group-text" data-password="false">
												<span class="password-eye"></span>
											</div>
										</div>
									</div>

									<div class="mb-3 d-grid">
										<button class="btn btn-primary rounded" type="button" onclick="f_login()">LOG IN</button>
									</div>
									
									<div class="row" style="justify-content: center;">
										<div class="col-6 d-grid">
											<button class="btn btn-danger rounded" type="button" onclick="f_findpass()">비밀번호 찾기</button>
										</div>
										<div class="col-6 d-grid">
											<button class="btn btn-info rounded" type="button" onclick="f_join()"> 회원가입</button>
										</div>
									</div>
								</form>
							</div> <!-- end card-body -->
						</div>
					</div>
				</div>
				<!-- end card -->


			</div> <!-- end col -->
		</div>
		<!-- end row -->
	</div>
	<!-- end page -->
</div>

<script>
function f_findpass(){
	location.href = "./pass_find.php";
}

function f_join(){
	location.href = "./join.php?mb_recommend=";
}

function f_login(){
	var mb_id = $("#mb_id").val();
	var mb_password = $("#mb_password").val();

	if(mb_id == ""){
		Swal.fire("", "아이디를 입력해주세요.", "error");
		return;
	}

	if(mb_password == ""){
		Swal.fire("", "비밀번호를 입력해주세요.", "error");
		return;
	}

	var frm = document.flogin;
	frm.submit();
}

$('#mb_password').keyup(function(e){
	if(e.keyCode == 13)  f_login();
});
</script>

<?php
include_once(G5_PATH.'/e_tail.php');
?>