<?php
include_once('./_common.php');

$config['cf_title'] = "후원";

include_once(G5_PATH.'/e_head_sub.php');

$top_yn = "y";	// 상위로

if($top_id == ""){
	$top_id = $mb_id;

}else{
	if($mb_id == ""){
		$mb_id = $top_id;
	}
}

if($mb_id == ""){
	$mb_id = $member['mb_id'];
	$top_yn = "";
	$top_id = $mb_id;
}

if($mb_id == ""){
	alert("정상적으로 접근해주세요.");
}

$mb_arr = get_member($mb_id);

$total_cnt = get_spon_cnt_all($mb_id);

$my_class = "level_member";

if(!$view_cnt) $view_cnt = 11;
?>
<link rel="stylesheet" href="<?php echo G5_URL;?>/page/jquery.orgchart.css?ver=1">
<style>
#chart_spon {
  position: relative;
  height: 700px;
  border: 1px solid #aaa;
  margin: 0.5rem;
  overflow: auto;
  text-align: center;
}


.orgchart { background: #fff; }
.orgchart td.left, .orgchart td.right, .orgchart td.top { border-color: #aaa; }
.orgchart td.down { background-color: #aaa; }

.orgchart .level_member .title { background-color: #330000; line-height: 25px; height: 25px;}
.orgchart .level_member .content { border-color: #330000; }

select.form-select option {
    color: #000 !important;
    background-color: #fff !important;
}
</style>
<body>
<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div>
			<h4 class="page-title">
				<div style="float:left;padding:0 10px 0 10px">
					<a href="<?php echo G5_URL;?>" class="topnav-logo">
						<img src="<?php echo G5_IMG_URL;?>/favicon.png" alt="" height="50">
					</a>
				</div>
				<div style="float:left;font-size:1rem;padding-top:10px">
					<?php
					echo $config['cf_title']." ".number_format($total_cnt)." 명";

					if($top_yn == "y"){
					?>
						<a href="./tree_spon.php?top_id=<?php echo $top_id;?>">처음으로</a>
					<?php 
					}
					?>
				</div>
				<div style="clear:both"></div>
			</h4>
		</div>
	</div>
</div>   
<!-- end page title -->

<!-- start page title -->
<div class="row">
	<div class="col-12" style="padding:0 20px;">
		<select class="form-select" id="view_cnt" onchange="f_view_cnt()">
			<option value="11" <?php if($view_cnt == "11") echo "selected";?>>10대까지 보기</option>
			<option value="16" <?php if($view_cnt == "16") echo "selected";?>>15대까지 보기</option>
			<option value="21" <?php if($view_cnt == "21") echo "selected";?>>20대까지 보기</option>
			<option value="100" <?php if($view_cnt == "100") echo "selected";?>>전체 보기</option>
		</select>
	</div>
</div>   
<!-- end page title -->

<div class="row">
	<script>
	$(function(){
		var sel = $('#mb_id');
		var selected = sel.val(); // cache selected value, before reordering
		var opts_list = sel.find('option');
		opts_list.sort(function(a, b) { return $(a).text() > $(b).text() ? 1 : -1; });
		sel.html('').append(opts_list);
		sel.val(selected); // set cached selected value
	});
	</script>

	<div>
		<div>
			<div id="chart_spon"></div>
		</div>
	</div>
</div>

<?php
$json_data = get_full_tree($mb_id);

$info_name = $mb_arr['mb_name']."(".$mb_id.")";

// 내 투자이력
$mb_datetime = substr($mb_arr['mb_datetime'], 0,10);

$info_title = $mb_datetime;

if($mb_arr['auction_yn'] == "y") $my_class = "level_auction";
?>
<script src="<?php echo G5_URL;?>/page/assets/js/vendor.min.js"></script>
<script src="<?php echo G5_URL;?>/page/assets/js/app.min.js"></script>

<!-- <script src="<?php echo G5_JS_URL;?>/jquery.min.js"></script> -->
<script src="<?php echo G5_URL;?>/page/jquery.orgchart.js?ver=2"></script>

<script>
$(function() {
	var datascource = {
	  "id": "first_node", 
      "name": <?php echo json_encode($info_name); ?>,
	  "title": "<?php echo $info_title;?>",
	  "className": "<?php echo $my_class;?>", 
      "children": <?php echo json_encode($json_data);?>
    };

	$("#chart_spon").orgchart({
		"data" : datascource,
		"nodeContent": "title", 
		'pan': true,
		'zoom': true, 
		'visibleLevel': <?php echo $view_cnt;?>,
	});
});

function scrollToNode(nodeId) {
    const element = document.getElementById(nodeId);
    if (element) {
        element.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'center' });
    }
}

// orgchart 초기화 후 특정 노드로 이동
$(document).ready(function() {
    const nodeId = 'first_node'; // 화면 중앙에 보이게 하고 싶은 노드의 ID
    scrollToNode(nodeId);
});
</script>


<?php
function get_full_tree($mb_id) {
	$mb_id = strtolower($mb_id);
    // 모든 데이터를 한 번에 가져오기
	$sql = "SELECT mb_id, mb_spon, mb_name, mb_datetime, auction_yn FROM g5_member order by mb_no ";
    $result = sql_query($sql);

    // 데이터를 배열로 저장
    $members_arr = [];
    while ($row = sql_fetch_array($result)) {
        // mb_spon(추천인)을 기준으로 배열에 저장
        $members_arr[$row['mb_spon']][] = $row;
    }

    // 트리를 생성하는 함수 호출
    $tree = build_tree($mb_id, $members_arr);
    return $tree;
}

function build_tree($mb_id, $members_arr) {
    $tree = [];
	global $g5, $config, $is_admin;

    // 현재 mb_id의 하위 노드 가져오기
    if (!isset($members_arr[$mb_id])) {
        return $tree;
    }

    foreach ($members_arr[$mb_id] as $row) {
        $mb_id2 = $row['mb_id'];

        $str_class = "level_member";
		if($row['auction_yn'] == "y") $str_class = "level_auction";
		
		$mb_name = $row['mb_name']."(".$mb_id2.")";

		$mb_datetime = substr($row['mb_datetime'], 0,10);
		
		$info_title = $mb_datetime;

        $tree[] = [
            'name' => $mb_name,
            'title' => $info_title,
            'className' => $str_class,
            'children' => build_tree($mb_id2, $members_arr) // 재귀 호출
        ];
    }

    return $tree;
}

?>

<script>
function f_view_cnt(){
	var view_cnt = $("#view_cnt").val();
	var top_id = "<?php echo $top_id;?>";
	var mb_id = "<?php echo $mb_id;?>";
	
	location.href = "./tree_spon.php?top_id="+top_id+"&mb_id="+mb_id+"&view_cnt="+view_cnt
}
</script>


<div id="dashboard_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="dashboard_modalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content modal-filled bg-info">
			<div class="modal-header">
				<h4 class="modal-title" id="dashboard_modalLabel">DashBoard</h4>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
			</div>
			<div id="user_info">
				<div class="modal-body"></div>
				<div class="modal-footer text-center">
					<button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">닫기</button>
				</div>
			</div>
		</div>
	</div>
</div>

    </body>
</html>
<?php echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다.