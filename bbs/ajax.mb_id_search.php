<?php
include_once('../common.php');

$mb_id = trim(strip_tags($_GET['mb_id']));

$sql = "select * from g5_member where instr(mb_id, '".$mb_id."') and mb_id != '".$member['mb_id']."' ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
    $return_arr[] = array("mb_id" => $row['mb_id'], "mb_name" => $row['mb_name'], "mb_id" => $row['mb_id']);
}

echo json_encode($return_arr);
?>