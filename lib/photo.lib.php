<?php
if (!defined('_GNUBOARD_')) exit;

/* img/grobio/photo/ 안에 파일이 있을 때만 주소를 돌려줍니다(없으면 빈 문자열 -> 색 면으로 표시). */
function wigo_photo($name)
{
    if (!preg_match('/^[a-z0-9-]+\.jpg$/D', $name)) return '';
    $path = G5_PATH . '/img/grobio/photo/' . $name;
    if (!is_file($path)) return '';
    return G5_URL . '/img/grobio/photo/' . $name . '?v=' . filemtime($path);
}
