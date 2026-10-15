<?php
$sub_menu = "100302";
require_once './_common.php';
require_once G5_EDITOR_LIB;

auth_check_menu($auth, $sub_menu, 'w');

$sql = "select * from p_notice where notice_no = '".$notice_no."'";
$result = sql_fetch($sql);
$use_yn = $result['use_yn'];

if($notice_no == ""){
	$use_yn = "y";
}

$g5['title'] .= '자료실';
require_once './admin.head.php';
?>

<form name="fdata" id="fdata" action="./p_data_form_update.php" onsubmit="return fdata_submit(this);" method="post" enctype="multipart/form-data">
    <input type="hidden" name="w" value="<?php echo $w ?>">
	<input type="hidden" name="notice_no" value="<?php echo $notice_no; ?>">

    <div class="tbl_frm01 tbl_wrap">
        <table>
            <tbody>
                <tr>
                    <th scope="row">제목</th>
                    <td>
                        <input type="text" name="notice_subject" value="<?php echo $result['notice_subject'] ?>" id="notice_subject" class="frm_input" style="width:100%">
                    </td>
                </tr>
				<tr>
                    <th scope="row">첨부파일</th>
                    <td>
                        <input type="file" name="notice_file" id="notice_file" class="frm_input">
						<?php
						if($result['notice_file']){
							echo "<a href='".G5_BBS_URL."/newbex_download.php?notice_no=".$notice_no."'>".$result['notice_file_name']."</a>";
						}
						?>
                    </td>
                </tr>
				<tr>
                    <th scope="row">사용여부</th>
                    <td>
                        <input type="radio" name="use_yn" id="use_yn_y" value="y" <?php if($use_yn == "y") echo "checked";?>> 
						<label for="use_yn_y">예</label> &nbsp; 
						<input type="radio" name="use_yn" id="use_yn_n" value="n" <?php if($use_yn == "n") echo "checked";?>> 
						<label for="use_yn_n">아니오</label>
                    </td>
                </tr>
                <tr>
                    <th scope="row">내용</th>
                    <td>
						1. 이미지클릭 후 사진크기조절<br/>
						2. 이미지는 최대 가로 1024px로 업로드 (이미지크기 최대 3M 권장)<br/>
						3. 이미지삭제시 이미지오른쪽에 깜박이는 커서를 놓고 백스페이스키로 삭제
						<?php echo editor_html("notice_content", get_text(html_purifier($result['notice_content']), 0)); ?>
					</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="btn_fixed_top">
        <a href="./p_notice.php" class="btn btn_02">목록</a> 
        <input type="button" value="저장" class="btn_submit btn" onclick="f_ok()" style="cursor:pointer">
    </div>
</form>

<script>
function f_ok(){
	<?php
	echo get_editor_js("notice_content");
	?>


	var notice_subject = $("#notice_subject").val();
	if(notice_subject == ""){
		alert("제목을 입력해주세요.");
		return;
	}

	var frm = document.fdata;
	frm.action = "./p_data_form_update.php";
	frm.submit();
}
</script>

<?php
require_once './admin.tail.php';
?>