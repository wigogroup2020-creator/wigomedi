<?php
include_once('./_common.php');
include_once(G5_PATH.'/e_head.php');

$mb_id = $member['mb_id'];

$sql = "select count(*) as cnt from p_withdraw where mb_id = '".$mb_id."' and confirm_yn = 'y'";
$result = sql_fetch($sql);
$cnt_confirm = $result['cnt'];

$sql = "select count(*) as cnt from p_withdraw where mb_id = '".$mb_id."' ";
$result = sql_fetch($sql);
$cnt_total = $result['cnt'];
?>

<div class="row justify-content-center">
	<div class="col-xxl-6 col-lg-8">
		<h4 class="text-white" style="padding-left:10px">출금내역 (Total <?php echo number_format($cnt_total);?> / 출금완료 <?php echo number_format($cnt_confirm);?>)</h4>
		<?php
		/*
		$withdraw_ing = get_sum_w_wait($mb_id);
		if($withdraw_ing > 0){
			$bonus_info = get_bonus_info();
			$co_bank_name = $bonus_info['co_bank_name'];
			$co_bank_owner = $bonus_info['co_bank_owner'];
			$co_bank_account = $bonus_info['co_bank_account'];
		
			echo "<h5 class='text-white' style='padding-left:10px'>입금정보 : ".$co_bank_name."(".$co_bank_owner.") ".$co_bank_account."</h5>";
		}
		*/
		?>

		<div class="card">
			<div class="card-body" style="padding:10px;">
				<div class="row">
					<div class="col-12">
						<div class="table-responsive">
							<table class="table table-centered table-nowrap mb-0" style="background-color:#fff">
								<thead class="table-light">
									<tr>
										<th>신청액</th>
										<th>요청일</th>
										<th>승인일</th>
										<th>출금계좌</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$sql = "select * from p_withdraw where mb_id = '".$mb_id."' order by withdraw_no desc";
								$result = sql_query($sql);

								for($i=0;$row=sql_fetch_array($result);$i++){
									$withdraw_p = $row['withdraw_p'];
								?>
									<tr>
										<td><?php echo number_format($withdraw_p);?></td>
										<td><?php echo substr($row['reg_datetime'], 0,10);?></td>
										<td><?php echo substr($row['confirm_date'], 0,10);?></td>
										<td><?php $row['bank_info']; ?></td>
									</tr>
								<?php
								}

								if($i == 0){
									echo "<tr><td colspan='5' style='text-align:center'>내용이 없습니다.</td></tr>";
								}
								?>
								</tbody>
							</table>
						</div>
						
						<div class="mt-2 text-white">* 좌우로 스크롤 해주세요.</div>
					</div> <!-- end col -->
				</div> <!-- end row --> 
			</div>
		</div>
	</div>
</div>
<?php
include_once(G5_PATH.'/e_tail.php');
?>