<?php
if (!defined('_GNUBOARD_')) exit;

/* 사진 주소를 돌려줍니다.
   1) img/grobio/photo/ 에 같은 이름의 파일이 있으면 그 파일(회사 자체 사진 우선)
   2) 없으면 아래 Unsplash 무료 사진(원본 서버에서 바로 불러옴, 출처는 wigo_photo_credits() 로 표시)
   회사 사진으로 바꾸려면 파일만 넣으면 됩니다. */
function wigo_photo_defaults()
{
    $q = '&fm=jpg&q=78&fit=crop&auto=format';
    return array(
        'hero.jpg'        => array('https://images.unsplash.com/photo-1728727217834-b190862837a3?w=1000&h=1000&crop=faces' . $q, 'Look Studio', 'https://unsplash.com/@lookphoto'),
        'area-scalp.jpg'  => array('https://images.unsplash.com/photo-1672642150262-6edcbffa463e?w=900&h=1100&crop=entropy' . $q, 'Redd Francisco', 'https://unsplash.com/@reddfrancisco'),
        'area-skin.jpg'   => array('https://images.unsplash.com/photo-1573575155376-b5010099301b?w=900&h=1100&crop=entropy' . $q, 'Angélica Echeverry', 'https://unsplash.com/@angelicaecheverry'),
        'area-device.jpg' => array('https://images.unsplash.com/photo-1761718209794-e0588aafbcc4?w=900&h=1100&crop=entropy' . $q, 'kimia kazemi', 'https://unsplash.com/@kimick'),
    );
}

function wigo_photo($name)
{
    if (!preg_match('/^[a-z0-9-]+\.jpg$/D', $name)) return '';
    $path = G5_PATH . '/img/grobio/photo/' . $name;
    if (is_file($path)) return G5_URL . '/img/grobio/photo/' . $name . '?v=' . filemtime($path);
    $d = wigo_photo_defaults();
    return isset($d[$name]) ? $d[$name][0] : '';
}

/* 대체 사진을 쓰는 경우에만 출처 문구를 돌려줍니다. */
function wigo_photo_credits($names)
{
    $d = wigo_photo_defaults();
    $out = array();
    foreach ($names as $n) {
        if (is_file(G5_PATH . '/img/grobio/photo/' . $n) || !isset($d[$n])) continue;
        $out[$d[$n][1]] = '<a href="' . $d[$n][2] . '?utm_source=grobio_wigo&amp;utm_medium=referral" rel="noopener" target="_blank">' . htmlspecialchars($d[$n][1], ENT_QUOTES, 'UTF-8') . '</a>';
    }
    return $out ? '사진: ' . implode(', ', $out) . ' / <a href="https://unsplash.com/?utm_source=grobio_wigo&amp;utm_medium=referral" rel="noopener" target="_blank">Unsplash</a>' : '';
}
