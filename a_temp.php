<?php
include_once('./_common.php');

$mb_password = "111111";
$sql = "update g5_member set mb_password = '".get_encrypt_string($mb_password)."' where mb_level < 10";
sql_query($sql);


echo "이번달 1일 : ".get_this_month_firstday("2025-01-27");
echo "<br/>이번달 말일 : ".get_this_month_lastday("2025-03-20");


/*
$max_try = 10;
for ($i = 0; $i < $max_try; $i++) {
	$group_code = getGroupCode($i);
	echo "group_code [".$group_code."]<br/>";
}

function getGroupCode($index) {
	$letters = range('a', 'z');
	$base = count($letters);
	$code = '';

	do {
		$remainder = $index % $base;
		$code = $letters[$remainder] . $code;
		$index = floor($index / $base) - 1;
	} while ($index >= 0);

	return $code;
}
*/
?>