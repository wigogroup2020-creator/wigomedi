<?php
require_once './_common.php';

// -------------------------------- 먼저 초기화 후 시작
$sql = "delete from p_game where game_gubun = 'b' ";
sql_query($sql);

$sql = "delete from table p_point where point_gubun = 'b'' ";
sql_query($sql);

$sql = "delete table p_enuri where enuri_gubun = 'b'";
sql_query($sql);



for($i_date=$from_dt;$i_date<=$to_dt;$i_date++){
	$str_date = $i_date;

	$str_yoil = get_yoil_num_from($str_date)*1;	// 요일체크 7 일요일, 1월, 2화, 3수, 4목, 5금, 6토
	if($str_yoil == 1){
		continue;
	}

	//-------------------- 일수익지급 -----------------------------------
	$sql = "select * from g5_member where pack_buy = 'y' and point_start <= '".$str_date."' order by mb_datetime";
	$result = sql_query($sql);

	for($i=0;$row=sql_fetch_array($result);$i++){
		$mb_id = $row['mb_id'];
		$mb_pack = $row['mb_pack'];
		$mb_insu = $row['mb_insu'];
		$mb_auto = $row['mb_auto'];

		if($mb_pack){
			// 보험과 오토모두 있어야함
			$insu_sum = get_sum_insuauto($mb_id, "a");
			$auto_sum = get_sum_insuauto($mb_id, "b");

			if($mb_insu > $insu_sum){
				continue;
			}

			if($mb_auto > $auto_sum){
				continue;
			}

			// 팩이 있어야 지급
			$package_price = get_pack_point($mb_pack);

			$sql_d = "select * from p_daily where pack_no = '".$mb_pack."' and work_day = '".$str_date."' ";
			$result_d = sql_fetch($sql_d);
			$daily_per = $result_d['daily_per'];

			$daily_point = ($package_price*$daily_per)*0.01;

			if($daily_point > 0){
				// 롤업지급
				$rollup_point = ($daily_point*$config['cf_10'])*0.01;
				set_rollup($rollup_point, $mb_id, $str_date);

			}
		}
	}
}



//--------------------------- 롤업지급 ------------------------------------------------------------------
function set_rollup($rollup_point, $mb_id, $str_date){
	$i_gen = 1;
	$mb_arr = get_member($mb_id);
	$mb_recommend = $mb_arr['mb_recommend'];
	$enuri_point = $rollup_point;

	if($mb_recommend){
		$rec_arr = get_member($mb_recommend);
		$mb_grade = $rec_arr['mb_grade'];

		// 보험과 오토모두 있어야함
		$insu_sum = get_sum_insuauto($mb_recommend, "a");
		$auto_sum = get_sum_insuauto($mb_recommend, "b");

		if($rec_arr['mb_insu'] > $insu_sum){
			$mb_grade = "";
		}

		if($rec_arr['mb_auto'] > $auto_sum){
			$mb_grade = "";
		}

		if($mb_grade){
			$rollup_per = get_per_rollup($i_gen, $mb_grade);
			if($rollup_per){
				$rollup_point_give = ($rollup_point*$rollup_per)*0.01;

				$point_point = $rollup_point_give*0.9;
				$game_point = $rollup_point_give*0.1;

				$sql_insert = "insert into p_point set mb_id = '".$mb_recommend."', 
													point_point = '".$point_point."', 
													point_gubun = 'b', 
													rec_mb_id = '".$mb_id."', 
													point_gen = '".$i_gen."', 
													reg_datetime = '".$str_date." 00:00:01', 
													point_per = '".$rollup_per."' ";
				sql_query($sql_insert);

				set_point_game($mb_recommend, $game_point, "b", $mb_id);

				$enuri_point = $enuri_point - $rollup_point_give;	// 에누리차감
			}
		}

		$enuri_point = set_rollup_sub($rollup_point, $mb_recommend, $enuri_point, $i_gen, $mb_id, $str_date);	// 2대부터지급
	}

	if($enuri_point > 0){
		$sql_insert = "insert into p_enuri set mb_id = '".$mb_id."', enuri_point = '".$enuri_point."', enuri_gubun = 'b', reg_datetime = '".$str_date." 00:05:01' ";
		sql_query($sql_insert);
	}
}

function set_rollup_sub($rollup_point, $mb_id, $enuri_point, $i_gen, $org_mb_id, $str_date){
	$i_gen++;
	
	$mb_arr = get_member($mb_id);
	$mb_recommend = $mb_arr['mb_recommend'];

	if($mb_recommend){
		$rec_arr = get_member($mb_recommend);
		$mb_grade = $rec_arr['mb_grade'];

		// 보험과 오토모두 있어야함
		$insu_sum = get_sum_insuauto($mb_recommend, "a");
		$auto_sum = get_sum_insuauto($mb_recommend, "b");

		if($rec_arr['mb_insu'] > $insu_sum){
			$mb_grade = "";
		}

		if($rec_arr['mb_auto'] > $auto_sum){
			$mb_grade = "";
		}

		if($mb_grade){
			$rollup_per = get_per_rollup($i_gen, $mb_grade);
			if($rollup_per){
				$rollup_point_give = ($rollup_point*$rollup_per)*0.01;

				$point_point = $rollup_point_give*0.9;
				$game_point = $rollup_point_give*0.1;

				$sql_insert = "insert into p_point set mb_id = '".$mb_recommend."', 
													point_point = '".$point_point."', 
													point_gubun = 'b', 
													rec_mb_id = '".$org_mb_id."', 
													point_gen = '".$i_gen."', 
													reg_datetime = '".$str_date." 00:05:01', 
													point_per = '".$rollup_per."' ";
				sql_query($sql_insert);

				set_point_game($mb_recommend, $game_point, "b", $org_mb_id);

				$enuri_point = $enuri_point - $rollup_point_give;	// 에누리차감
			}
		}

		set_rollup_sub($rollup_point, $mb_recommend, $enuri_point, $i_gen, $org_mb_id, $str_date);
	}

	return $enuri_point;
}
?>