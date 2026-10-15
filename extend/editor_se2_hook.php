<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가;

add_event('tail_sub', 'se2_custom');
function se2_custom() {
	global $board, $wr_id, $config, $member;
	$youtube_width = "100%";
	if (basename($_SERVER['PHP_SELF']) === "write.php" && ($wr_id || $wr_id === 0) && $board['bo_use_dhtml_editor'] && $config['cf_editor'] == "smarteditor2") {
		$upload_display = $member['mb_level'] < $board['bo_upload_level'] ? "none" : "block";
		echo "
			<script>
			document.addEventListener('DOMContentLoaded', () => {
			    se2Width = '100%';
				wr_content.nextSibling.onload = function() {
					se2Custom = this['contentWindow']['document'];
					se2Custom.querySelector('#smart_editor2').style.width = se2Custom.querySelector('#smart_editor2').style.maxWidth = se2Custom.querySelector('#smart_editor2').style.minWidth = se2Width;
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_font_type').insertAdjacentHTML('afterend', '<ul id=\'addMedia\'><span style=\'display:flex;justify-content:center;align-items:center;color:#0000ff;font-weight:bold;cursor:pointer;width:60px;height:21px;background-color:#d5e6f9;border:1px solid #bbbbbb;border-radius:3px;box-sizing:border-box\'>유튜브</span></ul>');
					se2Custom.querySelector('#smart_editor2 .se2_text_tool').style.padding = '0px 0px 5px 5px';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_font_type li').style.marginLeft = '-1px';
					for (se2_tt_ul of se2Custom.querySelectorAll('#smart_editor2 .se2_text_tool ul')) se2_tt_ul.style.paddingTop = '5px';
					se2Custom.querySelector('#smart_editor2 .se2_bx_character .se2_s_character ul').style = marginTop = '5px';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_multy').style.float = 'right';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_multy').style.paddingRight = '4px';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_multy').style.position = 'static';			
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_multy').style.height = '21px';					
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_multy').style.border = 'none';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_multy button').style.height = '21px';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_multy button').style.backgroundColor = '#f4e3d5';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_multy button').style.border = '1px solid #bbbbbb';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_multy .se2_icon').style.marginTop = se2Custom.querySelector('#smart_editor2 .se2_text_tool button span.se2_mntxt').style.marginTop = '-5px';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_multy').style.display = '".$upload_display."';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_font_type').style.position = 'relative';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_font_type').style.zIndex = '60';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_font_type').nextSibling.style.position = 'relative';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_font_type').nextSibling.style.zIndex = '59';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_font_type').nextSibling.nextSibling.style.position = 'relative';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_font_type').nextSibling.nextSibling.style.zIndex = '58';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_font_type').nextSibling.nextSibling.nextSibling.style.position = 'relative';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_font_type').nextSibling.nextSibling.nextSibling.style.zIndex = '57';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_font_type').nextSibling.nextSibling.nextSibling.nextSibling.style.position = 'relative';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_font_type').nextSibling.nextSibling.nextSibling.nextSibling.style.zIndex = '56';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_font_type').nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.style.position = 'relative';
					se2Custom.querySelector('#smart_editor2 .se2_text_tool .se2_font_type').nextSibling.nextSibling.nextSibling.nextSibling.nextSibling.style.zIndex = '55';
					se2Custom.querySelector('#smart_editor2 .se2_conversion_mode').style.padding = '5px';
					se2Custom.querySelector('#smart_editor2 .se2_conversion_mode').style.backgroundColor = '#f9f9f9';
					se2Custom.querySelector('#smart_editor2 .se2_inputarea_controller').style.textAlign = 'left';
					se2Custom.querySelector('#smart_editor2 .se2_inputarea_controller').style.paddingLeft = '5px';
					se2Custom.querySelector('#addMedia').innerHTML += '<div style=\'display:none;position:fixed;top:' + (se2Custom.querySelector('#smart_editor2 #se2_iframe').offsetHeight) + 'px;right:25px\'><input style=\'width:200px;height:19px;border:1px solid #bbbbbb;border-radius:3px;margin-right:5px;background-color:#eeeeee;outline:none;\'><span id=\'addMediaClose\' style=\'display:flex;justify-content:center;align-items:center;color:#c00000;font-weight:bold;float:right;margin-left:5px;cursor:pointer;width:40px;height:19px;border:1px solid #bbbbbb;border-radius:3px;background-color:#f7d7e4\'>닫기</span><span id=\'addMediaOpen\' style=\'display:flex;justify-content:center;align-items:center;color:#0000ff;font-weight:bold;float:right;cursor:pointer;width:40px;height:19px;border:1px solid #bbbbbb;border-radius:3px;background-color:#d5e6f9\'>입력</span></div>'					
					se2Custom.querySelector('#addMedia').onmousedown = function() {
						se2Custom.querySelector('#addMedia div').style.display = 'block';
					}
					se2Custom.querySelector('#addMediaOpen').onclick = function() {
						se2Media = se2Custom.querySelector('#addMedia input').value.trim();
						if (se2Media.indexOf('https://youtu.be/') > -1) se2Custom.querySelector('#addMedia input').value = se2Media.split('https://youtu.be/')[1].slice(0, 11);
						else if (se2Media.indexOf('https://www.youtube.com/watch?v=') > -1) se2Custom.querySelector('#addMedia input').value = se2Media.split('https://www.youtube.com/watch?v=')[1].slice(0, 11); 
						else se2Custom.querySelector('#addMedia input').value = se2Media; 
						oEditors.getById['wr_content'].exec('PASTE_HTML', ['<div class=\'youtube-bo_v_con\'><iframe style=\'display:block;margin:0 auto\' src=\'https://www.youtube.com/embed/' + se2Custom.querySelector('#addMedia input').value + '\' frameborder=\'0\' allowfullscreen></iframe></div>']);
						se2Custom.querySelector('#addMedia input').value = '';
						se2Custom.querySelector('#addMedia div').style.display = 'none';
					}
					se2Custom.querySelector('#addMediaClose').onclick = function() {
						se2Custom.querySelector('#addMedia input').value = '';
						se2Custom.querySelector('#addMedia div').style.display = 'none';
					}
					se2Custom.querySelector('#smart_editor2 #se2_iframe').onload = function() {
						this['contentWindow']['document'].querySelector('body').insertAdjacentHTML('beforebegin', '<style>img { max-width:100%; }</style>');
					}
				}
			} );
			</script>
		";
	}
	if (basename($_SERVER['PHP_SELF']) === "board.php" && $wr_id && $wr_id > 0) {
		echo "
			<style>.youtube-bo_v_con iframe { display:block; }</style>
			<script>
			function ytSize() {
				for (youtube_bo_v_con of bo_v_con.querySelectorAll('.youtube-bo_v_con iframe')) {
					youtube_bo_v_con.style.width = '".$youtube_width."';
					youtube_bo_v_con.style.height = youtube_bo_v_con.offsetWidth * 9 / 16 + 'px';
				}
			}
			ytSize();
			addEventListener('resize', ytSize);
			</script>
		";
	}
}