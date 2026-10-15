<?php
$sub_menu = "100100";
require_once './_common.php';

auth_check_menu($auth, $sub_menu, 'r');

$sql_common = " from {$g5['member_table']} ";

$sql_search = " where (1) ";
if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case 'mb_point':
            $sql_search .= " ({$sfl} >= '{$stx}') ";
            break;
        case 'mb_level':
            $sql_search .= " ({$sfl} = '{$stx}') ";
            break;
        case 'mb_tel':
        case 'mb_hp':
            $sql_search .= " ({$sfl} like '%{$stx}') ";
            break;
        default:
            $sql_search .= " ({$sfl} like '{$stx}%') ";
            break;
    }
    $sql_search .= " ) ";
}

/*
if ($is_admin != 'super') {
    $sql_search .= " and mb_level <= '{$member['mb_level']}' ";
}
*/

if (!$sst) {
    $sst = "mb_datetime";
    $sod = "desc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) {
    $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
}
$from_record = ($page - 1) * $rows; // 시작 열을 구함


$listall = '<a href="' . $_SERVER['SCRIPT_NAME'] . '" class="ov_listall">전체목록</a>';

$g5['title'] = '회원-관리용';
require_once './admin.head.php';

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$from_record}, {$rows} ";
$result = sql_query($sql);
?>

<div class="local_ov01 local_ov">
    <?php echo $listall ?>
    <span class="btn_ov01"><span class="ov_txt">총회원수 </span><span class="ov_num"> <?php echo number_format($total_count) ?>명 </span></span>
</div>

<form id="fsearch" name="fsearch" class="local_sch01 local_sch" method="get">

    <label for="sfl" class="sound_only">검색대상</label>
    <select name="sfl" id="sfl">
		<option value="mb_name" <?php echo get_selected($sfl, "mb_name"); ?>>이름</option>
        <option value="mb_id" <?php echo get_selected($sfl, "mb_id"); ?>>회원아이디</option>
        <option value="mb_email" <?php echo get_selected($sfl, "mb_email"); ?>>E-MAIL</option>
        <option value="mb_hp" <?php echo get_selected($sfl, "mb_hp"); ?>>휴대폰번호</option>
        <option value="mb_recommend" <?php echo get_selected($sfl, "mb_recommend"); ?>>추천인</option>
    </select>
    <label for="stx" class="sound_only">검색어<strong class="sound_only"> 필수</strong></label>
    <input type="text" name="stx" value="<?php echo $stx ?>" id="stx" required class="required frm_input">
    <input type="submit" class="btn_submit" value="검색">
</form>


<div class="tbl_head01 tbl_wrap">
	<table>
		<caption><?php echo $g5['title']; ?> 목록</caption>
		<thead>
			<tr>
				<th>총판</th>
				<th>대리점</th>
				<th>영업</th>
				<th>회원구분</th>
				<th><?php echo subject_sort_link('mb_id') ?>아이디 ▼</a></th>
				<th><?php echo subject_sort_link('mb_name') ?>이름 ▼</a></th>
				<th>휴대폰</th>
				<th>이메일</th>
				<th>추천인</th>
				<th>추천인수</th>
				<th><?php echo subject_sort_link('mb_datetime', '', 'desc') ?>가입일 ▼</a></th>
				<th><?php echo subject_sort_link('mb_today_login', '', 'desc') ?>최종접속 ▼</a></th>
				<th>관리</th>
			</tr>
		</thead>
		<tbody>
			<?php
			for ($i = 0; $row = sql_fetch_array($result); $i++) {
				$mb_id = strtolower($row['mb_id']);
				$bg = 'bg' . ($i % 2);
				$s_mod = '<a href="./member_form.php?' . $qstr . '&amp;w=u&amp;mb_id=' . $mb_id . '" class="btn btn_03">수정</a>';
				$rec_cnt = get_rec_cnt($mb_id);
			?>
				<tr class="<?php echo $bg; ?>">
					<td><?php echo $row['mb_chong']; ?></td>
					<td><?php echo $row['mb_branch']; ?></td>
					<td><?php echo $row['mb_sales']; ?></td>
					<td>
						<?php
						if($row['co_kind'] == "b") echo "병원";
						elseif($row['co_kind'] == "c") echo "벤더";
						else echo "일반";
						?>
					</td>
					<td><?php echo $mb_id;?></td>
					<td><?php echo get_text($row['mb_name']); ?></td>
					<td><?php echo get_text($row['mb_hp']); ?></td>
					<td><?php echo $row['mb_email']; ?></td>
					<td><?php echo $row['mb_recommend'];?></td>
					<td>
						<a href="<?php echo G5_URL;?>/page/tree_rec.php?mb_id=<?php echo $mb_id;?>" style="color:#0066ff" target="_blank">
							<?php echo number_format($rec_cnt)." / ".number_format(get_reccnt_all($mb_id));?>
						</a>
					</td>
					<td><?php echo $row['mb_datetime']; ?></td>
					<td><?php echo $row['mb_today_login']; ?></td>
					<td>
						<?php
						echo $s_mod;
						?>
					</td>
				</tr>
			<?php
			}
			if ($i == 0) {
				echo "<tr><td colspan=13 class=\"empty_table\">자료가 없습니다.</td></tr>";
			}
			?>
		</tbody>
	</table>
</div>

<div class="btn_fixed_top">
	<?php if ($is_admin == 'super') { ?>
		<a href="./member_form.php?w=&mb_level=5" id="member_add" class="btn btn_01">관리자 추가</a>
	<?php } ?>

</div>

<?php echo get_paging(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, '?' . $qstr . '&amp;page='); ?>

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
	$("#stx").autocomplete(availableTags,{
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

<?php
require_once './admin.tail.php';
