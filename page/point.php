<?php
include_once('./_common.php');
include_once(G5_PATH.'/e_head.php');

$sql_common = "from p_point where mb_id = '".$member['mb_id']."'  ";	// point_gubun a포인트전환, b참여, c소개, d롤업, e롤다운, f센터, w출금, z관리자
if($point_gubun){
	$sql_common .= " and point_gubun = '".$point_gubun."' ";
}

$sql = "select count(*) as cnt ".$sql_common;
$result = sql_fetch($sql);
$i_cnt = $result['cnt'];

$sql = "select sum(point_point) as point_point ".$sql_common;
$result = sql_fetch($sql);
$point_point = $result['point_point'];

$rows = 10;
$total_page  = ceil($i_cnt / $rows);  // 전체 페이지 계산
if ($page < 1) {
    $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
}
$from_record = ($page - 1) * $rows; // 시작 열을 구함
?>

<div class="row justify-content-center">
	<div class="col-xxl-6 col-lg-8">
		<h4 class="text-white" style="padding-left:10px">보너스 합계 : <?php echo number_format($point_point);?></h4>

		<div class="card">
			<div class="card-body" style="padding:10px;">
				<div class="row">
					<div class="col-12">
						<div class="table-responsive">
							<table class="table table-centered table-nowrap mb-0" style="background-color:#fff">
								<thead class="table-light">
									<tr>
										<th>날짜</th>
										<th>보너스</th>
										<th>합계</th>
										<th>구분</th>
									</tr>
								</thead>
								<tbody>
								<?php
								$sql = "select * ".$sql_common." order by reg_datetime desc limit {$from_record}, {$rows}";
								$result = sql_query($sql);

								for($i=0;$row=sql_fetch_array($result);$i++){
									$reg_datetime = substr($row['reg_datetime'], 0,10);
								?>
									<tr>
										<td><?php echo $reg_datetime;?></td>
										<td><?php echo number_format($row['point_point']);?></td>
										<td><?php echo number_format($row['point_sum']);?></td>
										<td><?php echo $row['point_memo'];	//get_point_name($row['point_gubun']);?></td>
									</tr>
								<?php
								}

								if($i == 0){
									echo "<tr><td class='text-white' colspan='4' style='text-align:center'>내용이 없습니다.</td></tr>";
								}
								?>
								</tbody>
							</table>
						</div>
						<div class="mt-2 text-white">* 좌우로 스크롤 해주세요.</div>
					</div> <!-- end col -->
					
					<?php echo get_p_paging(5, $page, $total_page, '?' . $qstr . '&amp;page='); ?>
				</div> <!-- end row --> 
			</div>
		</div>
	</div>
</div>

<?php
include_once(G5_PATH.'/e_tail.php');
?>