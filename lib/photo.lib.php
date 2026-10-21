<?php
if (!defined('_GNUBOARD_')) exit;

/* img/grobio/photo/ 안에 같은 이름의 파일이 있으면 그 주소를 돌려주고, 없으면 빈 문자열(= 빈 칸으로 표시). */
function wigo_photo($name)
{
    if (!preg_match('/^[a-z0-9-]+\.jpg$/D', $name)) return '';
    $path = G5_PATH . '/img/grobio/photo/' . $name;
    if (!is_file($path)) return '';
    return G5_URL . '/img/grobio/photo/' . $name . '?v=' . filemtime($path);
}
