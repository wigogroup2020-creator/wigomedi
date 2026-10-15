<?php
$sub_menu = '100400';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "w");

$g5['title'] = '엑셀파일로 보너스 등록';
include_once(G5_PATH.'/head.sub.php');
?>

<div class="new_win">
    <h1><?php echo $g5['title']; ?></h1>

    <div class="local_desc01 local_desc">
        <p>
            엑셀파일을 이용하여 보너스 일괄등록</a>
        </p>
    </div>

    <form name="fitemexcel" method="post" action="./excel_upload_point_update.php" enctype="MULTIPART/FORM-DATA" autocomplete="off">

    <div id="excelfile_upload">
        <label for="excelfile">파일선택</label>
        <input type="file" name="excelfile" id="excelfile">
    </div>

    <div class="win_btn btn_confirm">
        <input type="submit" value="엑셀파일 등록" class="btn_submit btn btn_03">
        <button type="button" onclick="window.close();" class="btn_close btn btn_01">닫기</button>
    </div>

    </form>

</div>

<?php
include_once(G5_PATH.'/tail.sub.php');