<?php
require_once './_common.php';
include_once(G5_PATH.'/newbex_head.php');

if($member['mb_id']){
	goto_url(G5_URL."/page/info.php");
}

$co_kind_title = "";
if($co_kind == "b"){
	$co_kind_title = "병원/클리닉 ";
	
}elseif($co_kind == "c"){
	$co_kind_title = "벤더/대리점 ";
}
?>

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
					<li><a href="<?php echo G5_URL;?>">Home</a></li>
					<li>회원서비스</li>
				</ul>
			</div>
		</div>
		<div class="page m70 m41 joinPage">
			<div class="inner">
				<h1><?php echo $co_kind_title;?>회원가입</h1>
				<form name="fjoin" method="post" action="./join_update.php">
					<input type="hidden" name="co_kind" value="<?php echo $co_kind;?>">
					<input type="hidden" name="mb_recommend" value="<?php echo $mb_recommend;?>">
					<div class="form_box">
						<ul>
							<li>
								<label for="mb_id">아이디<span> *</span></label>
								<input type="text" id="mb_id" name="mb_id" placeholder="아이디" value="" required>
							</li>
							<li>
								<label for="mb_password">비밀번호<span> *</span></label>
								<input type="password" id="mb_password" name="mb_password" required autocomplete="new-password">
							</li>
							<li>
								<label for="mb_password_re">비밀번호 확인<span> *</span></label>
								<input type="password" id="mb_password_re" name="mb_password_re" required autocomplete="new-password">
							</li>
							<li>
								<label for="mb_name">이름<span> *</span></label>
								<input type="text" name="mb_name" placeholder="이름 입력" id="mb_name" required>
							</li>
							<li>
								<label for="mb_hp">연락처<span> *</span></label>
								<input type="text" name="mb_hp" id="mb_hp" placeholder="'-'제외하고 숫자만 입력" pattern="[0-9]{2,3}-[0-9]{3,4}-[0-9]{3,4}" maxlength="11" required>
							</li>
							<li>
								<label for="mb_email">이메일<span> *</span></label>
								<input type="text" name="mb_email" placeholder="이메일 입력" id="mb_email" required>
							</li>
							
							<?php
							if($co_kind == "b"){
							?>
								<li>
									<label for="company_name">병원 및 상호명<span> *</span></label>
									<input type="text" name="company_name" placeholder="병원 및 상호명 입력" id="company_name" required>
								</li>
								<li>
									<label for="company_no">사업자등록번호<span> *</span></label>
									<input type="text" name="company_no" id="company_no" placeholder="숫자만 입력" required>
								</li>
								<li>
									<label for="company_ceo">대표자명<span> *</span></label>
									<input type="text" name="company_ceo" placeholder="대표 성함 입력" id="company_ceo" required>
								</li>
								<li>
									<label for="company_tel">병원 연락처<span> *</span></label>
									<input type="text" name="company_tel" id="company_tel" placeholder="'-'제외하고 숫자만 입력" pattern="[0-9]{2,3}-[0-9]{3,4}-[0-9]{3,4}" maxlength="11" required>
								</li>
								<li>
									<label for="company_address">병원 주소<span> *</span></label>
									<input type="text" name="company_address" placeholder="주소 입력" id="company_address" required>
								</li>
								<li>
									<label for="company_dept">담당자 직책<span> *</span></label>
									<input type="text" name="company_dept" placeholder="담당자 직책 입력" id="company_dept" required>
								</li>
							<?php
							}
							
							if($co_kind == "c"){
							?>
								<li>
                                    <label for="company_name">벤더/대리점명<span> *</span></label>
                                    <input type="text" name="company_name" placeholder="벤더/대리점명 입력" id="company_name" required>
                                </li>
								<li>
									<label for="company_dept">담당자 직책<span> *</span></label>
									<input type="text" name="company_dept" placeholder="담당자 직책 입력" id="company_dept" required>
								</li>
							<?php
							}
							?>
						</ul>
					</div>
					<div class="agree_box">
						<input type="checkbox" name="startup_agree" id="agree_check" value="y" checked>
						<label for="agree_check" class="check_img"></label>
						<label for="agree_check">[필수] 개인정보 수집ㆍ이용</label>
						<a href="javascript:void(0)" onclick="f_modal_show()">[내용보기]</a>
					</div>
					<div class="foun_btn" style="padding-top:20px">
						<button type="button" value="보내기" style="cursor:pointer" onclick="f_join()">신청하기</button>
					</div>
				</form>
			</div>
		</div>
	</div> 
</main>

<script>
function f_join(){
	var mb_id = $("#mb_id").val();
	var mb_password = $("#mb_password").val();
	var mb_password_re = $("#mb_password_re").val();
	var mb_name = $("#mb_name").val();
	var mb_hp = $("#mb_hp").val();
	var mb_email = $("#mb_email").val();
	var co_kind = "<?php echo $co_kind;?>";	// a일반 b병원, c벤더
	
	if(mb_id == ""){
		Swal.fire("", "아이디를 입력해주세요.", "error");
		return;
	}
	
	if(mb_password == ""){
		Swal.fire("", "비밀번호를 입력해주세요.", "error");
		return;
	}
	
	if(mb_password != mb_password_re){
		Swal.fire("", "비밀번호가 틀립니다.", "error");
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
	
	if(mb_email == ""){
		Swal.fire("", "이메일을 입력해주세요.", "error");
		return;
	}
	
	const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // 이메일 형식 정규식

	if (emailPattern.test(mb_email)) {
		// ok
	} else {
		Swal.fire("", "이메일 형식이 올바르지 않습니다.", "error");
		return;
	}
	
	if(co_kind == "b"){
		var company_name = $("#company_name").val();
		var company_no = $("#company_no").val();
		var company_ceo = $("#company_ceo").val();
		var company_tel = $("#company_tel").val();
		var company_address = $("#company_address").val();
		var company_dept = $("#company_dept").val();
		
		if(company_name == ""){
			Swal.fire("", "병원 및 상호명을 입력해주세요.", "error");
			return;
		}
		
		if(company_no == ""){
			Swal.fire("", "사업자등록번호를 입력해주세요.", "error");
			return;
		}
		
		if(company_ceo == ""){
			Swal.fire("", "대표자 성함을 입력해주세요.", "error");
			return;
		}
		
		if(company_tel == ""){
			Swal.fire("", "병원 연락처를 입력해주세요.", "error");
			return;
		}
		
		if(company_address == ""){
			Swal.fire("", "병원 주소를 입력해주세요.", "error");
			return;
		}
		
		if(company_dept == ""){
			Swal.fire("", "담당자 직책을 입력해주세요.", "error");
			return;
		}
		
	}else if(co_kind == "c"){
		var company_name = $("#company_name").val();
		var company_dept = $("#company_dept").val();
		
		if(company_name == ""){
			Swal.fire("", "벤더/대리점명을 입력해주세요.", "error");
			return;
		}
		
		if(company_dept == ""){
			Swal.fire("", "담당자 직책을 입력해주세요.", "error");
			return;
		}
	}
	
	var frm = document.fjoin;
	frm.submit();
}

function f_modal_show(){
	$('.modal').addClass('active');
    $('body').addClass('scroll-disable');
}

function f_modal_hide(){
	$('.modal').removeClass('active');
    $('body').removeClass('scroll-disable');
}
</script>

<?php
include_once(G5_PATH."/pages/modal_privacy.php");

include_once(G5_PATH."/newbex_tail.php");
?>