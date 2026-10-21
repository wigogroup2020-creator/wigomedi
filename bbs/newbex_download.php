<?php
include_once('./_common.php');

// clean the output buffer
ob_end_clean();

$notice_no = (int) $notice_no;
$sql = "select * from p_notice where notice_no = '".$notice_no."' and use_yn <> 'n' ";
$result = sql_fetch($sql);
if (!$result || !$result['notice_file'] || !is_file(G5_DATA_PATH.'/notice/'.basename($result['notice_file']))) { header('HTTP/1.1 404 Not Found'); exit('파일을 찾을 수 없습니다.'); }

$notice_file_name = $result['notice_file_name'];	// 파일명
$notice_file = basename($result['notice_file']);				// 저장된파일명

$filepath = G5_DATA_PATH.'/notice/'.$notice_file;
$filepath = addslashes($filepath);

$g5['title'] = '다운로드';

$original = rawurlencode($notice_file_name);


run_event('download_file_header', $file, $file_exist_check);

if(preg_match("/msie/i", $_SERVER['HTTP_USER_AGENT']) && preg_match("/5\.5/", $_SERVER['HTTP_USER_AGENT'])) {
    header("content-type: doesn/matter");
    header("content-length: ".filesize($filepath));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-transfer-encoding: binary");
} else if (preg_match("/Firefox/i", $_SERVER['HTTP_USER_AGENT'])){
    header("content-type: file/unknown");
    header("content-length: ".filesize($filepath));
    header("content-disposition: attachment; filename=\"".$original."\"");
    header("content-description: php generated data");
} else {
    header("content-type: file/unknown");
    header("content-length: ".filesize($filepath));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-description: php generated data");
}
header("pragma: no-cache");
header("expires: 0");
flush();

$fp = fopen($filepath, 'rb');

$download_rate = 10;

while(!feof($fp)) {
    print fread($fp, round($download_rate * 1024));
    flush();
    usleep(1000);
}
fclose ($fp);
flush();