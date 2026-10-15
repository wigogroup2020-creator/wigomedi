<?php
include_once('./_common.php');

$act = $_POST['act'];

if ($act =='alarm') {
	$result = array();
	$row = sql_fetch(" select * from {$g5['memo_table']} where me_recv_mb_id = '{$member['mb_id']}' and me_send_datetime >= NOW() - INTERVAL 2 DAY and me_read_datetime = '0000-00-00 00:00:00' order by me_id desc limit 1");
	if ($row) {
		$result['content'] = $row['me_memo'];
		$result['msg'] = 'SUCCESS';
		$result['me_id'] = $row['me_id'];
		//$result['sound'] = 'N';
			$mb = get_member($row['me_send_mb_id'], 'mb_name');
		$result['title'] = $mb['mb_name'];
		$result['url'] = G5_URL . '/bbs/memo_view.php?me_id=' . $row['me_id'] . '&kind=recv';
	}else{
		$result['msg'] = 'NOMSG';
		$result['me_id'] = '';
	}
	echo json_encode($result);		
}

if($act == "recv_memo"){
	$result = array();	
	
	$me_id = $_POST['me_id'];

	$sql = " delete from {$g5['memo_table']} where me_recv_mb_id = '".$member['mb_id']."' and me_read_datetime = '0000-00-00 00:00:00' ";
    sql_query($sql);
	
	$result['msg'] = 'SUCCESS';
	
	echo json_encode($result);
}
?>