<?php
$sub_menu = '100000';
require_once './_common.php';

@require_once './safe_check.php';

if (function_exists('social_log_file_delete')) {
    //소셜로그인 디버그 파일 24시간 지난것은 삭제
    social_log_file_delete(86400);
}

$g5['title'] = '관리자메인';
require_once './admin.head.php';

$new_member_rows = 5;
$new_point_rows = 5;
$new_write_rows = 5;

$addtional_content_before = run_replace('adm_index_addtional_content_before', '', $is_admin, $auth, $member);
if ($addtional_content_before) {
    echo $addtional_content_before;
}

if (!auth_check_menu($auth, '200100', 'r', true)) {
    $sql_common = " from {$g5['member_table']} ";

    $sql_search = " where (1) ";

    if ($is_admin != 'super') {
        $sql_search .= " and mb_level <= '{$member['mb_level']}' ";
    }

    if (!$sst) {
        $sst = "mb_datetime";
        $sod = "desc";
    }

    $sql_order = " order by {$sst} {$sod} ";

    $sql = " SELECT count(*) as cnt {$sql_common} {$sql_search} {$sql_order} ";
    $row = sql_fetch($sql);
    $total_count = $row['cnt'];

    $sql = " SELECT * {$sql_common} {$sql_search} {$sql_order} limit {$new_member_rows} ";
    $result = sql_query($sql);

    $colspan = 4;
    ?>

    <section>
        <h2>신규가입회원 <?php echo $new_member_rows ?>건 목록</h2>
        <div class="local_desc02 local_desc">
            총회원수 <?php echo number_format($total_count) ?>명 
        </div>

        <div class="tbl_head01 tbl_wrap">
            <table>
                <caption>신규가입회원</caption>
                <thead>
                    <tr>
                        <th scope="col">회원아이디</th>
                        <th scope="col">이름</th>
                        <th scope="col">연락처</th>
                        <th scope="col">이메일</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($i = 0; $row = sql_fetch_array($result); $i++) {
                        $mb_id = $row['mb_id'];
                        ?>
                        <tr>
                            <td><?php echo $mb_id ?></td>
                            <td><?php echo get_text($row['mb_name']); ?></td>
                            <td><?php echo $row['mb_hp'] ?></td>
                            <td><?php echo $row['mb_email'] ?></td>
                        </tr>
                        <?php
                    }
                    if ($i == 0) {
                        echo '<tr><td colspan="4" class="empty_table">자료가 없습니다.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="btn_list03 btn_list">
            <a href="./member_list.php">회원 전체보기</a>
        </div>
    </section>
<?php
} //endif 최신 회원


//$i_cal = 90/0.9;
//echo "[".$i_cal."]";
?>

<!-- <input type="button" class="btn btn_03" onclick="f_excel_show()" value="회원 엑셀업로드" style="cursor:pointer"> 
<input type="button" class="btn btn_03" onclick="f_excel_bonus_show()" value="보너스 엑셀업로드" style="cursor:pointer;background-color:#339900"> -->

<script>
function f_excel_show(){
	var opt = "width=600,height=450,left=10,top=10";
    window.open("./excel_upload.php", "win_excel", opt);
    return false;
}

function f_excel_bonus_show(){
	var opt = "width=600,height=450,left=10,top=10";
    window.open("./excel_upload_point.php", "win_excel", opt);
    return false;
}
</script>

<?php 
$addtional_content_after = run_replace('adm_index_addtional_content_after', '', $is_admin, $auth, $member);
if ($addtional_content_after) {
    echo $addtional_content_after;
}
require_once './admin.tail.php';