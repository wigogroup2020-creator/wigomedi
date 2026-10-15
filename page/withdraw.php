<?php
include_once('./_common.php');
include_once(G5_PATH.'/e_head.php');

$mb_id = $member['mb_id'];

$bonus_info = get_bonus_info();
$withdraw_min = $bonus_info['withdraw_min'];	// 최소출금
$withdraw_fee = $bonus_info['withdraw_fee'];

$my_bonus = 0;
$wait_withdraw = 0;


$my_bonus = get_sum_point($mb_id);
$wait_withdraw = get_sum_w_wait($mb_id);

if($wait_withdraw > 0){
	$my_bonus = $my_bonus - $wait_withdraw;
}
?>
<style>
.fees-container {
	display: flex;
	justify-content: space-between;
	font-weight: 300;
}
</style>
<!-- start page title -->
<div class="row justify-content-center">
	<div class="col-xxl-4 col-lg-6 col-12">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body" style="padding:0px 1rem">
						<div class="text-center">
							<h3 class="mb-3 text-white" style="font-family:맑은고딕">출금요청</h3>
						</div>

						<form name="fwithdraw" method="post">
							<div class="mt-2">
								<h4 class="text-white" style="font-weight:300">은행명</h4>
								<div>
									<input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo $member['bank_name'];?>">
								</div>
							</div>
							<div class="mt-2">
								<h4 class="text-white" style="font-weight:300">예금주</h4>
								<div>
									<input type="text" class="form-control" name="bank_owner" id="bank_owner" value="<?php echo $member['bank_owner'];?>">
								</div>
							</div>
							<div class="mt-2">
								<h4 class="text-white" style="font-weight:300">계좌번호</h4>
								<div>
									<input type="text" class="form-control" name="bank_account" id="bank_account" value="<?php echo $member['bank_account'];?>">
								</div>
							</div>
							<div class="mt-2">
								<h4 class="text-white" style="font-weight:300">요청금액</h4>
								<div>
									<div class="input-group">
										<input type="text" class="form-control" name="withdraw_p" id="withdraw_p" value="" placeholder="Minimum <?php echo $withdraw_min;?>"  inputmode="numeric" onblur="f_point_change()">
										<button class="btn btn-info rounded" type="button" onclick="f_all()" style="border-radius:10px">전체</button>
									</div>
								</div>
							</div>
							
							<h4 class="mt-3 mb-3 text-white" style="font-weight:300">가능금액 <?php echo number_format($my_bonus);?></h4>
							<div class="fees-container text-white">
								<span>수수료 (<?php echo $withdraw_fee;?>%)</span> <span id="withdraw_fee">0</span>
							</div>
							<div style="width:100%;height:30px"></div>
							<div class="mt-3 d-grid" id="view_btn">
								<button class="btn btn-primary rounded" type="button" onclick="f_withdraw()" id="view_btn" style="font-family:맑은고딕">요청하기</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
$in_check = "y";
// 지정공휴일 금지
$sql_h = "select * from p_holyday where holyday_date = '".G5_TIME_YMD."' ";
$result_h = sql_fetch($sql_h);
if($result_h){
	$in_check = "n";
}
?>

<script>
function f_withdraw(){
	var my_bonus = "<?php echo $my_bonus;?>";
	var withdraw_p = $("#withdraw_p").val();
	var in_check = "<?php echo $in_check;?>";

	if(in_check == "n"){
		Swal.fire("", "오늘은 출금불가일 입니다.", "error");
		return;
	}

	if(my_bonus == ""){
		Swal.fire("", "출금가능액이 없습니다.", "error");
		return;
	}

	my_bonus = my_bonus*1;

	if(!withdraw_p){
		Swal.fire("", "출금액을 입력해주세요.", "error");
		return;
	}

	withdraw_p = withdraw_p*1;

	var bank_name = $("#bank_name").val();
	var bank_owner = $("#bank_owner").val();
	var bank_account = $("#bank_account").val();
	
	if(bank_name == ""){
		Swal.fire("", "계좌정보를 입력해주세요.", "error");
		return;
	}
	
	if(bank_owner == ""){
		Swal.fire("", "계좌정보를 입력해주세요.", "error");
		return;
	}
	
	if(bank_account == ""){
		Swal.fire("", "계좌정보를 입력해주세요.", "error");
		return;
	}

	if(withdraw_p > my_bonus){
		Swal.fire("", "보유 보너스 이상으로 출금할 수 없습니다.", "error");
		return;
	}

	var withdraw_min = "<?php echo $withdraw_min;?>";
	if(withdraw_min){
		if(withdraw_min > withdraw_p){
			withdraw_min = withdraw_min.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
			
			var alert_text = "최소 출금액은 " + withdraw_min + "입니다.";

			Swal.fire("", alert_text, "error");
			return;
		}
	}

	if(confirm("출금요청 하시겠습니까?")){
		$("#view_btn").hide();

		var frm = document.fwithdraw;
		frm.action = "./withdraw_update.php";

		frm.submit();
	}
}

function f_all(){
	var my_bonus = "<?php echo $my_bonus;?>";
	var withdraw_fee = "<?php echo $withdraw_fee;?>";

	my_bonus = Math.floor(my_bonus);

	$("#withdraw_p").val(my_bonus);

	var withdraw_fee = (my_bonus*withdraw_fee)*0.01;
	withdraw_fee = my_bonus - withdraw_fee.toFixed(3);

	withdraw_fee = withdraw_fee.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
	$("#withdraw_fee").html(withdraw_fee + " P");
}

function f_point_change(){
	var withdraw_fee = "<?php echo $withdraw_fee;?>";
	var withdraw_p = $("#withdraw_p").val();
	
	if(withdraw_p == ""){
		return;
	}

	withdraw_p = withdraw_p*1;

	if(withdraw_p == 0){
		return;
	}

	var withdraw_fee = (withdraw_p*withdraw_fee)*0.01;
	withdraw_fee = withdraw_p - withdraw_fee.toFixed(3);

	withdraw_fee = withdraw_fee.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
	$("#withdraw_fee").html(withdraw_fee + " P");
}
</script>
<?php
include_once(G5_PATH.'/e_tail.php');
?>