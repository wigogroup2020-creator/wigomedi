<?php
include_once('../common.php');

$search = trim(strip_tags($_GET['term']));
$sql = " select * from {$g5['member_table']} where mb_id like '$search%' ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $return_arr[] = array("mb_id" => $row['mb_id'], "label" => $row['mb_name']);
}

echo json_encode($return_arr);
?>