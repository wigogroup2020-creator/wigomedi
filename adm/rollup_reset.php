<?php
require_once './_common.php';

$sql = "truncate table p_game";
sql_query($sql);

$sql = "truncate table p_point";
sql_query($sql);

$sql = "truncate table p_enuri";
sql_query($sql);





$sql = "INSERT INTO p_game SELECT * FROM p_game_copy";
sql_query($sql);

$sql = "INSERT INTO p_point SELECT * FROM p_point_copy";
sql_query($sql);

$sql = "INSERT INTO p_enuri SELECT * FROM p_enuri_copy";
sql_query($sql);

alert("완료");
?>