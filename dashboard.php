<?php
include_once('./_common.php');
include_once(G5_PATH.'/e_head.php');

if($mb_id == ""){
	$mb_id = $member['mb_id'];
}

$sql_notice = "select * from p_notice where use_yn = 'y' and popup_yn = 'y' limit 1";
$result_notice = sql_fetch($sql_notice);
$notice_no = $result_notice['notice_no'];
$notice_subject = isset($result_notice['notice_subject']) ? $result_notice['notice_subject'] : "";
$notice_content = isset($result_notice['notice_content']) ? $result_notice['notice_content'] : "";

//$notice_no = "xx";
if($notice_no){
?>
	<script src="<?php echo G5_JS_URL;?>/popper.min.js"></script>
	<script src="<?php echo G5_JS_URL;?>/bootstrap.min.js"></script>

	<div id="notice_modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<div class="mb-1">
						<?php echo $notice_subject;?>
					</div>
					<div class="mb-3">
						<?php echo $notice_content;?>
					</div>
					<div class="mb-3 text-center">
						<button type="button" class="btn btn-danger rounded-pill" onclick="f_notice_close()">Close</button> &nbsp; 
						<button class="btn btn-primary rounded-pill" type="button" onclick="f_notice_close2()">7일간보지않기</button>
					</div>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<script>
	// 공지사항 팝업
	function f_notice_close(){
		$("#notice_modal").modal("hide");
		$("body").removeClass("modal-open");
		$("body div").removeClass("modal-backdrop");
		$("body div").removeClass("fade");
		$("body div").removeClass("show");
		$("#notice_modal").hide();
	}

	function f_notice_close2(){
		$("body").removeClass("modal-open");
		$("body div").removeClass("modal-backdrop");
		$("body div").removeClass("fade");
		$("body div").removeClass("show");
		$("#notice_modal").hide();

		f_setCookie("z_notice", "done" , 7);
	}

	function f_setCookie( name, value, expiredays ) {
		var todayDate = new Date();
		todayDate.setDate( todayDate.getDate() + expiredays );
		document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
	}

	function f_getCookie( name ) {
		var nameOfCookie = name + "=";
		var x = 0;
		while ( x <= document.cookie.length ) {
			var y = (x+nameOfCookie.length);
			if ( document.cookie.substring( x, y ) == nameOfCookie ) {
						 if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
										 endOfCookie = document.cookie.length;
						 return unescape( document.cookie.substring( y, endOfCookie ) );
			}
			x = document.cookie.indexOf( " ", x ) + 1;
			if ( x == 0 )
			break;
		}
		return "";
	}

	if ( f_getCookie('z_notice') == 'done' ) {

	}else{
		$("#notice_modal").modal("show");
	}
	</script>
<?php 
}
?>

<style>
.blinking{
  -webkit-animation: blink 3.0s ease-in-out infinite alternate;
  -moz-animation: blink 3.0s ease-in-out infinite alternate;
  animation: blink 0.5s ease-in-out infinite alternate;
}

@-webkit-keyframes blink{
  0% {opacity: 0;}
  100% {opacity: 1;}
}

@-moz-keyframes blink{
  0% {opacity: 0;}
  100% {opacity: 1;}
}

@keyframes blink{
  0% {opacity: 0;}
  100% {opacity: 1;}
}
</style>

<div class="row justify-content-center">
	<div class="col-xxl-4 col-lg-6">
        <div class="card">
            <div class="card-body p-2">
                <div class="text-center">
					<div class="mb-2 text-white" style="font-size:1.2rem;font-weight:bold">DASHBOARD</div>
				</div>
				
				<div class="row mb-3">
					<div class="col-12">
						<div class="chart-widget-list" style="display: flex; flex-direction: column; gap: 12px;">
							<div class="dashboard_card" style="background-color:#fff;">
								<a class="p-2 dashoard_items row align-items-center" href="<?php echo G5_URL;?>/page/order.php">
									<div class="col-auto" style="padding-right:0">
										<i class="mdi mdi-battery-charging-20 text-primary widget-icon me-3"></i>
									</div>
									<div class="col ps-0">
										<h5 class="mb-1 text-black">포인트구매</h5>
									</div>
								</a>
							</div>
							
							<?php
							date_default_timezone_set('Asia/Seoul');
							$now_time = date("H:i");
								
							$str_yoil = get_yoil_num();	// 일요일은 1
							
							$bonus_info = get_bonus_info();
							$auction_mon = $bonus_info['auction_mon'];
							$auction_tue = $bonus_info['auction_tue'];
							$auction_wed = $bonus_info['auction_wed'];
							$auction_thu = $bonus_info['auction_thu'];
							$auction_fri = $bonus_info['auction_fri'];
							$auction_sat = $bonus_info['auction_sat'];
							$auction_sun = $bonus_info['auction_sun'];
							$auction_point = $bonus_info['auction_point'];	// 경매참여(낙찰)금액

							$bonus_max = $bonus_info['bonus_max'];
	
							//$bonus_my = get_sum_point_give($mb_id);
							$bonus_sum = get_sum_point($mb_id, "");
							$bonus_join = get_sum_point($mb_id, "b", G5_TIME_YMD);		// a포인트전환, b참여, c소개, d롤업-영업보너스1, e롤다운-영업보너스2, f센터, g경매당첨, h프로모션경매참여, i프로모션보너스, w출금, z관리자
							$bonus_introduce = get_sum_point($mb_id, "c", G5_TIME_YMD);
							$bonus_rollup = get_sum_point($mb_id, "d", G5_TIME_YMD);
							$bonus_rolldown = get_sum_point($mb_id, "e", G5_TIME_YMD);
							$bonus_center = get_sum_point($mb_id, "f", G5_TIME_YMD);
							
							$bonus_w = get_sum_point($mb_id, "w")*-1;
							$rec_cnt_direct = get_rec_cnt($mb_id);		// 직접추천인수
							$rec_cnt_all = get_reccnt_all($mb_id);		// 추천인 전체수
							$spon_cnt = get_spon_cnt($mb_id);			// 후원인수
							$spon_cnt_all = get_spon_cnt_all($mb_id);	// 후원인 전체수
							$center_cnt = get_center_cnt($mb_id);		// 센터산하인원수
							
							$auction_cnt = get_auction_cnt($mb_id);
							$auction_cnt_win = get_auction_cnt_win($mb_id);
							
							$auction_check = "y";
							
							if($str_yoil == "1"){
								if($auction_sun == "n"){
									$auction_check = "";
								}
							}elseif($str_yoil == "2"){
								if($auction_mon == "n"){
									$auction_check = "";
								}
							}elseif($str_yoil == "3"){
								if($auction_tue == "n"){
									$auction_check = "";
								}
							}elseif($str_yoil == "4"){
								if($auction_wed == "n"){
									$auction_check = "";
								}
							}elseif($str_yoil == "5"){
								if($auction_thu == "n"){
									$auction_check = "";
								}
							}elseif($str_yoil == "6"){
								if($auction_fri == "n"){
									$auction_check = "";
								}
							}elseif($str_yoil == "7"){
								if($auction_sat == "n"){
									$auction_check = "";
								}
							}
							
							if($auction_check == "y"){
								$sql_a = "select * from p_auction where auction_end > '".$now_time."' order by auction_start limit 1";
								$result_a = sql_fetch($sql_a);
								
								$auction_start = $result_a['auction_start'];
								$auction_end = $result_a['auction_end'];
								$auction_no = $result_a['auction_no'];
								
								$auction_status = "none";
								$auction_time = "";
								
								//echo "now_time [".$now_time."] auction_start [".$auction_start."] auction_end [".$auction_end."]<br/>";
								
								if($auction_start){
									if ($now_time >= $auction_start && $now_time < $auction_end) {
										// 진행 중인 경매
										$auction_status = "active";
										$auction_time = $auction_end;
										
									} elseif ($now_time < $auction_start) {
										// 아직 시작 전 (대기 중인 경매)
										$auction_status = "waiting";
										$auction_time = $auction_start;
									}
								}
								
								$auction_url = G5_URL;
								
								//echo "now_time [".$now_time."] auction_status [".$auction_status."] auction_url [".$auction_url."] auction_time [".$auction_time."] auction_start [".$auction_start."] auction_end [".$auction_end."] <br/>";
							
								if ($auction_status == "active" || $auction_status == "waiting") {
									
									//echo "auction_status [".$auction_status."] auction_time [".$auction_time."] auction_end [".$auction_end."] auction_start [".$auction_start."]<br/>";
							?>
									<div class="dashboard_card bg-info">
										<?php
										if($auction_status == "active"){
											$auction_text = "구매가 종료되었습니다.";
											$auction_url = G5_URL."/page/auction_update.php?auction_no=".$auction_no;
										?>
											<a class="p-2 dashoard_items row align-items-center" href="javascript:void(0)" onclick="f_auction('<?php echo $auction_no; ?>')">
										<?php 
										}else{
											$auction_text = "구매가 시작되었습니다.";
											echo "<a class='p-2 dashoard_items row align-items-center href='javascript:void(0)'>";
										}
										?>
											<div class="col-auto" style="padding-right:0">
												<?php
												if($auction_status == "active"){
													echo "<i class='mdi mdi-cursor-default-click-outline widget-icon me-3' style='background-color:#ff6600 !important'></i>";
													
												}else{
													echo "<i class='mdi dripicons-broadcast widget-icon me-3' style='background-color:#ff6600 !important'></i>";
												}
												?>
											</div>
											<div class="col ps-0">
												<h5 class="mb-1">
													<?php echo $auction_status == "active" ? '구매 진행중 (남은 시간)' : '구매 시작 '; ?> <span id="auction_countdown"></span>
												</h5>
											</div>
										</a>
									</div>

									<script>
										function f_auction(auction_no){
											var my_point = "<?php echo $bonus_sum;?>";
											var auction_point = "<?php echo $auction_point;?>";
											my_point = my_point*1;
											auction_point = auction_point*1;
											
											if(my_point < auction_point){
												Swal.fire("", "구매참여 포인트가 부족합니다.", "error");
												return;
											}
											
											/*
											if(confirm("구매에 참여하시겠습니까?")){
												location.href = "<?php echo G5_URL;?>/page/auction_join.php?auction_no="+auction_no;
											}
											*/
											location.href = "<?php echo G5_URL;?>/page/auction_item.php?auction_no="+auction_no;
										}
									
										function startCountdown(targetTimeStr) {
											const [targetH, targetM] = targetTimeStr.split(":");
											const now = new Date();
											const target = new Date();
											let timer;

											target.setHours(parseInt(targetH), parseInt(targetM), 0, 0);
											if (target < now){
												clearInterval(timer);
												return;
												//target.setDate(target.getDate() + 1); // 시간 지나갔을 경우 다음날로 설정
											}

											function updateCountdown() {
												const now_sub = new Date();
												const diff = Math.floor((target - now_sub) / 1000);

												if (diff <= 0) {
													document.getElementById("auction_countdown").innerText = "00:00";
													clearInterval(timer);
													setTimeout(function() {
														alert("<?php echo $auction_text;?>");
														location.href = "<?php echo $auction_url;?>";
													}, 1200);
													
													return;
												}

												const minutes = String(Math.floor(diff / 60)).padStart(2, "0");
												const seconds = String(diff % 60).padStart(2, "0");
												document.getElementById("auction_countdown").innerText = `${minutes}분 ${seconds}초전`;
											}

											updateCountdown();
											timer = setInterval(updateCountdown, 1000);
										}
										
										startCountdown("<?php echo $auction_time; ?>");
									</script>
							<?php 
								}
							}
							
							// 프로모션 경매
							$sql_p = "select * from p_promotion where promotion_date = '".G5_TIME_YMD."' and promotion_end > '".$now_time."' and use_yn = 'y' ";
							$result_p = sql_fetch($sql_p);
							
							$promotion_no  = isset($result_p['promotion_no']) ? $result_p['promotion_no'] : 0;
							$promotion_start = $result_p['promotion_start'];
							$promotion_end = $result_p['promotion_end'];
							$promotion_name = $result_p['promotion_name'];
							$promotion_point = isset($result_p['promotion_point']) ? $result_p['promotion_point'] : 0;
							
							$promotion_status = "none";
							$promotion_time = "";
							$promotion_url = G5_URL;
							
							if($promotion_no > 0){
								if ($now_time >= $promotion_start && $now_time < $promotion_end) {
									// 진행 중인 경매
									$promotion_status = "active";
									$promotion_time = $promotion_end;
								}else{
									// 아직 시작 전 (대기 중인 경매)
									$promotion_status = "waiting";
									$promotion_time = $promotion_start;
								}
								
								$join_cnt = get_promotion_cnt_my($promotion_no, $mb_id);
							?>
								<div class="dashboard_card bg-danger">
										<?php
										if($promotion_status == "active"){
											$promotion_text = "프로모션이 종료되었습니다.";
											$promotion_url = G5_URL."/page/promotion_update.php?promotion_no=".$promotion_no;
										?>
											<a class="p-2 dashoard_items row align-items-center" href="javascript:void(0)" onclick="f_promotion('<?php echo $promotion_no; ?>')">
										<?php 
										}else{
											$promotion_text = "프로모션이 시작되었습니다.";
											echo "<a class='p-2 dashoard_items row align-items-center href='javascript:void(0)'>";
										}
										?>
											<div class="col-auto" style="padding-right:0">
												<?php
												if($promotion_status == "active"){
													echo "<i class='mdi mdi-cursor-default-click-outline widget-icon me-3' style='background-color:#fff !important;color:#000 !important'></i>";
													
												}else{
													echo "<i class='mdi dripicons-broadcast widget-icon me-3' style='background-color:#fff !important;color:#000 !important'></i>";
												}
												?>
											</div>
											<div class="col ps-0">
												<h5 class="mb-1">
													<?php echo $promotion_status == "active" ? '프로모션 진행중 (남은 시간)' : '프로모션 시작 '; ?> <span id="promotion_countdown"></span>
												</h5>
											</div>
										</a>
									</div>
									
									<div id="promotion_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="promotion_modalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content modal-filled bg-info">
												<div class="modal-header">
													<h4 class="modal-title" id="promotion_modalLabel">프로모션 참여 번호입력</h4>
													<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
												</div>
												<div class="modal-body">
													<form name="fpromotion" method="post" class="form-horizontal">
														<input type="hidden" name="promotion_no" id="promotion_no" value="<?php echo $promotion_no;?>">
														<?php
														$over_sum = get_over_sum();
									
														if($over_sum > 0){
														?>
															<div class="row mb-2">
																<label for="over_sum" class="col-6 col-form-label text-white">이월금액</label>
																<div class="col-6"><?php echo number_format($over_sum);?></div>
															</div>
														<?php 
														}
														?>
														<div class="row mb-2">
															<label for="join_lottery" class="col-6 col-form-label text-white">추첨번호 (0 ~ 99 숫자만)</label>
															<div class="col-6">
																<input type="text" class="form-control" name="join_lottery" id="join_lottery" maxlength="2" inputmode="numeric" min="0" max="99">
															</div>
														</div>
														<div class="row mb-2">
															<label for="join_winning" class="col-6 col-form-label text-white">당첨번호 (0 ~ 99 숫자만)</label>
															<div class="col-6">
																<input type="text" class="form-control" name="join_winning" id="join_winning" maxlength="2" inputmode="numeric" min="0" max="99">
															</div>
														</div>
													</form>
												</div>
												<div class="modal-footer text-center">
													<button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">닫기</button>
													<button type="button" class="btn btn-dark text-white" onclick="f_promotion_ok()">참여하기</button>
												</div>
											</div>
										</div>
									</div>
									
									<script>
										function f_promotion(promotion_no){
											var my_point = "<?php echo $bonus_sum;?>";
											var promotion_point = "<?php echo $promotion_point;?>";
											var join_cnt = "<?php echo $join_cnt;?>";
											my_point = my_point*1;
											promotion_point = promotion_point*1;
											join_cnt = join_cnt*1;
											
											if(join_cnt > 0){
												Swal.fire("", "이미 참여하였습니다.", "error");
												return;
											}
											
											if(my_point < promotion_point){
												Swal.fire("", "프로모션참여 포인트가 부족합니다.", "error");
												return;
											}
											
											$("#promotion_modal").modal("show");
											
											//if(confirm("프로모션에 참여하시겠습니까?")){
											//	location.href = "<?php echo G5_URL;?>/page/promotion_join.php?promotion_no="+promotion_no;
											//}
										}
										
										function f_promotion_ok(){
											var join_lottery = $("#join_lottery").val();
											var join_winning = $("#join_winning").val();
											
											if( (join_lottery == "") || (join_winning == "") ){
												Swal.fire("", "추첨번호와 당첨번호 모두 입력해주세요.", "error");
												return;
											}
											
											var frm = document.fpromotion;
											frm.action = "<?php echo G5_URL;?>/page/promotion_join.php";
											frm.submit();
										}
									
										function p_startCountdown(targetTimeStr) {
											const [targetH, targetM] = targetTimeStr.split(":");
											const promotion_now = new Date();
											const promotion_target = new Date();
											let promotion_timer;

											promotion_target.setHours(parseInt(targetH), parseInt(targetM), 0, 0);
											if (promotion_target < promotion_now){
												clearInterval(promotion_timer);
												return;
												//promotion_target.setDate(promotion_target.getDate() + 1); // 시간 지나갔을 경우 다음날로 설정
											}

											function p_updateCountdown() {
												const promotion_now_sub = new Date();
												const promotion_diff = Math.floor((promotion_target - promotion_now_sub) / 1000);

												if (promotion_diff <= 0) {
													document.getElementById("promotion_countdown").innerText = "00:00";
													clearInterval(promotion_timer);
													setTimeout(function() {
														alert("<?php echo $promotion_text;?>");
														location.href = "<?php echo $promotion_url;?>";
													}, 1200);
													
													return;
												}

												const minutes = String(Math.floor(promotion_diff / 60)).padStart(2, "0");
												const seconds = String(promotion_diff % 60).padStart(2, "0");
												document.getElementById("promotion_countdown").innerText = `${minutes}분 ${seconds}초전`;
											}

											p_updateCountdown();
											promotion_timer = setInterval(p_updateCountdown, 1000);
										}
										
										p_startCountdown("<?php echo $promotion_time; ?>");
									</script>
							<?php 
							}
							?>
							<div class="dashboard_card" style="background-color:#fff;">
								<a class="p-2 dashboard_items row align-items-center" href="<?php echo G5_URL;?>/page/point.php">
									<div class="col-auto pr-0">
										<i class="flex-shrink-0 me-3 dripicons-jewel widget-icon <?php echo $add_class;?>"></i>
									</div>
									<div class="col ps-0">
										<h5 class="mt-0 mb-1 text-black">보유포인트 <span class="float-end"><?php echo number_format($bonus_sum);?> P</span></h5>
									</div>
									<div class="col-auto">
										<i class="dripicons-chevron-right btn btn-link btn-lg text-muted"></i>
									</div>
								</a>
								<hr style="margin:0px;height:2px"></hr>
								
								<a class="p-2 dashboard_items row align-items-center" href="<?php echo G5_URL;?>/page/auction_list.php">
									<div class="col-auto pr-0">
										<i class="flex-shrink-0 me-3 dripicons-rocket widget-icon"></i>
									</div>
									<div class="col ps-0">
										<h5 class="mt-0 mb-1 text-black">구매참여횟수 <span class="float-end"><?php echo number_format($auction_cnt_win);?> / <?php echo number_format($auction_cnt);?> 회</span></h5>
									</div>
									<div class="col-auto">
										<i class="dripicons-chevron-right btn btn-link btn-lg text-muted"></i>
									</div>
								</a>
								<hr style="margin:0px;height:2px"></hr>

								<a class="p-2 dashboard_items row align-items-center" href="<?php echo G5_URL;?>/page/point.php?point_gubun=b">
									<div class="col-auto pr-0">
										<i class="flex-shrink-0 me-3 dripicons-jewel widget-icon"></i>
									</div>
									<div class="col ps-0">
										<h5 class="mt-0 mb-1 text-black">참여보너스 <span class="float-end"><?php echo number_format($bonus_join);?> P</span></h5>
									</div>
									<div class="col-auto">
										<i class="dripicons-chevron-right btn btn-link btn-lg text-muted"></i>
									</div>
								</a>
								<hr style="margin:0px;height:2px"></hr>
								
								<a class="p-2 dashboard_items row align-items-center" href="<?php echo G5_URL;?>/page/point.php?point_gubun=c">
									<div class="col-auto pr-0">
										<i class="flex-shrink-0 me-3 dripicons-jewel widget-icon"></i>
									</div>
									<div class="col ps-0">
										<h5 class="mt-0 mb-1 text-black">소개보너스 <span class="float-end"><?php echo number_format($bonus_introduce);?> P</span></h5>
									</div>
									<div class="col-auto">
										<i class="dripicons-chevron-right btn btn-link btn-lg text-muted"></i>
									</div>
								</a>
								<hr style="margin:0px;height:2px"></hr>
								
								<a class="p-2 dashboard_items row align-items-center" href="<?php echo G5_URL;?>/page/point.php?point_gubun=d">
									<div class="col-auto pr-0">
										<i class="flex-shrink-0 me-3 dripicons-jewel widget-icon"></i>
									</div>
									<div class="col ps-0">
										<h5 class="mt-0 mb-1 text-black">영업보너스1 <span class="float-end"><?php echo number_format($bonus_rollup);?> P</span></h5>
									</div>
									<div class="col-auto">
										<i class="dripicons-chevron-right btn btn-link btn-lg text-muted"></i>
									</div>
								</a>
								<hr style="margin:0px;height:2px"></hr>
								
								<a class="p-2 dashboard_items row align-items-center" href="<?php echo G5_URL;?>/page/point.php?point_gubun=e">
									<div class="col-auto pr-0">
										<i class="flex-shrink-0 me-3 dripicons-jewel widget-icon"></i>
									</div>
									<div class="col ps-0">
										<h5 class="mt-0 mb-1 text-black">영업보너스2 <span class="float-end"><?php echo number_format($bonus_rolldown);?> P</span></h5>
									</div>
									<div class="col-auto">
										<i class="dripicons-chevron-right btn btn-link btn-lg text-muted"></i>
									</div>
								</a>
								<hr style="margin:0px;height:2px"></hr>
								
								<a class="p-2 dashboard_items row align-items-center" href="<?php echo G5_URL;?>/page/point.php?point_gubun=f">
									<div class="col-auto pr-0">
										<i class="flex-shrink-0 me-3 dripicons-jewel widget-icon"></i>
									</div>
									<div class="col ps-0">
										<h5 class="mt-0 mb-1 text-black">센터보너스 <span class="float-end"><?php echo number_format($bonus_center);?> P</span></h5>
									</div>
									<div class="col-auto">
										<i class="dripicons-chevron-right btn btn-link btn-lg text-muted"></i>
									</div>
								</a>
							</div>
							<div class="row index_wallet" style="background-color:#fff;">
								<?php
								if($member['mb_id'] == $member['mb_center']){
								?>
									<div class="row col-3 card mb-1 text-black">
										<div class="mb-1 pr-0 text-center">
											<i class="mdi dripicons-user-group mdi-24px"></i>
										</div>
										<div class="mt-0 mb-1 text-black pr-0">추천 <?php echo number_format($rec_cnt_direct);?><br/>전체 <a href="./page/rec_list.php"><?php echo number_format($rec_cnt_all);?></a></div>
									</div>
									<div class="row col-3 card mb-1 text-black">
										<div class="mb-1 pr-0 text-center">
											<i class="mdi dripicons-heart mdi-24px"></i>
										</div>
										<div class="mt-0 mb-1 text-black pr-0">후원 <?php echo number_format($spon_cnt);?><br/>전체 <a href="./page/rec_list_spon.php"><?php echo number_format($spon_cnt_all);?></a></div>
									</div>
									<div class="row col-3 card mb-1 text-black">
										<div class="mb-1 pr-0 text-center">
											<i class="mdi dripicons-heart mdi-24px"></i>
										</div>
										<div class="mt-0 mb-1 text-black pr-0">센터산하<br/>전체 <a href="./page/center_member.php"><?php echo number_format($center_cnt);?></a></div>
									</div>
									<div class="row col-3 card mb-1 text-black">
										<div class="mb-1 pr-0 text-center">
											<i class="mdi dripicons-wallet mdi-24px"></i>
										</div>
										<div class="mt-0 mb-1 text-black pr-0">
											출금<br/>
											<a href="<?php echo G5_URL;?>/page/withdraw.php"><?php echo number_format($bonus_w);?> P</a>
										</div>
									</div>
								<?php 
								}else{
								?>
									<div class="row col-4 card mb-1 text-black">
										<div class="mb-1 pr-0 text-center">
											<i class="mdi dripicons-user-group mdi-24px"></i>
										</div>
										<div class="mt-0 mb-1 text-dark pr-0"><a href="./page/rec_list.php" class="text-black">추천 <?php echo number_format($rec_cnt_direct);?><br/>전체 <?php echo number_format($rec_cnt_all);?></a></div>
									</div>
									<div class="row col-4 card mb-1 text-black">
										<div class="mb-1 pr-0 text-center">
											<i class="mdi dripicons-heart mdi-24px"></i>
										</div>
										<div class="mt-0 mb-1 text-dark pr-0"><a href="./page/rec_list_spon.php" class="text-black">후원 <?php echo number_format($spon_cnt);?><br/>전체 <?php echo number_format($spon_cnt_all);?></a></div>
									</div>
									<div class="row col-4 card mb-1 text-black">
										<div class="mb-1 pr-0 text-center">
											<i class="mdi dripicons-wallet mdi-24px"></i>
										</div>
										<div class="mt-0 mb-1 text-dark pr-0">
											<a href="<?php echo G5_URL;?>/page/withdraw.php" class="text-black">출금<br/><?php echo number_format($bonus_w);?> P</a>
										</div>
									</div>
								<?php
								}
								?>
							</div>
						</div>
					</div>
				</div>
            </div>			<!-- end card body-->
        </div>				<!-- end card -->
    </div>					<!-- end col-->
</div>
<?php
include_once(G5_PATH.'/e_tail.php');
?>