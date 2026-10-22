<?php
if (!defined('_GNUBOARD_')) exit;

/*
 * 홈페이지 PRODUCT 카드 (GROBio × WIGO)
 * 관리자 > 제품관리(p_product 테이블)에 등록된 제품을 그대로 보여줍니다. 코드에 고정된 제품 목록은 없습니다.
 *
 *  - 그로바이오 제품 : product_kind = '그로바이오'
 *  - 제휴제품       : product_kind = '제휴제품' 또는 기존 'HIFU+LDM'(ALLVIS)
 *  - Newbex / ReviveCell 은 홈페이지 PRODUCT에 표시하지 않습니다(DB 데이터는 그대로 보관).
 *  - 사용여부가 '예'(use_yn = 'y')인 제품만, 먼저 등록한 제품이 앞에 표시됩니다.
 *  - 제휴제품 카드는 아직 상세로 연결하지 않고 "준비 중" 안내를 띄웁니다.
 */

function wigo_prod_e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function wigo_prod_groups()
{
    return array(
        'grobio'  => array('label' => '그로바이오', 'kinds' => array('그로바이오')),
        'partner' => array('label' => '제휴제품',   'kinds' => array('제휴제품', 'HIFU+LDM')),
    );
}

function wigo_prod_in_clause($group)
{
    $groups = wigo_prod_groups();
    if (!isset($groups[$group])) return "''";
    $quoted = array();
    foreach ($groups[$group]['kinds'] as $kind) $quoted[] = "'" . sql_real_escape_string($kind) . "'";
    return implode(',', $quoted);
}

/*
 * 제품 사진 주소: product_file 의 파일명을 아래 두 곳에서 찾아 먼저 있는 쪽을 씁니다.
 *   1) data/product/<파일명>        (관리자에서 직접 올린 사진)
 *   2) img/grobio/products/<파일명>  (홈페이지에 함께 들어 있는 기본 제품 사진)
 * 어느 쪽에도 없으면 빈 문자열을 돌려줍니다(엑스박스 대신 이미지 없는 카드).
 */
function wigo_prod_file_url($file)
{
    if (!is_string($file) || $file === '' || !preg_match('/^[0-9A-Za-z._+-]{1,120}$/D', $file) || strpos($file, '..') !== false) return '';
    $path = G5_DATA_PATH . '/product/' . $file;
    if (is_file($path)) return G5_DATA_URL . '/product/' . rawurlencode($file) . '?v=' . filemtime($path);
    $path = G5_PATH . '/img/grobio/products/' . $file;
    if (is_file($path)) return G5_URL . '/img/grobio/products/' . rawurlencode($file) . '?v=' . filemtime($path);
    return '';
}

/* 제품 목록 카드: DB에 등록된 제품(사용 '예')을 등록 순서대로 돌려줍니다. 누르면 해당 제품 상세로 이동합니다. */
function wigo_prod_cards($group)
{
    $cards = array();
    $kinds = wigo_prod_in_clause($group);
    $result = sql_query("SELECT product_no, product_subject, product_info, product_file FROM p_product WHERE LOWER(TRIM(use_yn)) = 'y' AND TRIM(product_kind) IN ($kinds) ORDER BY product_no ASC", false);
    if (!$result) return $cards;
    while ($row = sql_fetch_array($result)) {
        $cards[] = array(
            'group' => $group,
            'name'  => $row['product_subject'],
            'info'  => $row['product_info'],
            'img'   => wigo_prod_file_url($row['product_file']),
            'href'  => '/pages/m21_view.html?product_no=' . (int) $row['product_no'],
        );
    }
    return $cards;
}

/* 홈 뷰티 컬렉션: 그로바이오 제품 뒤에 제휴제품을 이어서, 최대 10개. */
function wigo_prod_collection()
{
    return array_slice(array_merge(wigo_prod_cards('grobio'), wigo_prod_cards('partner')), 0, 10);
}

/* 목록 카드 1장: 큰 제품 이미지 + 이름 + 짧은 설명. 제휴제품은 준비 중 안내(js/soon.js). */
function wigo_prod_card_html($card, $index)
{
    $img = $card['img'] !== '' ? '<img src="' . wigo_prod_e($card['img']) . '" alt="' . wigo_prod_e($card['name']) . '" loading="lazy" width="900" height="900">' : '';
    $link = (isset($card['group']) && $card['group'] === 'partner') ? 'href="#" data-soon' : 'href="' . wigo_prod_e($card['href']) . '"';
    return '<a class="gw-pc2" ' . $link . '><span class="pic">' . $img . '</span><strong>' . wigo_prod_e($card['name']) . '</strong><span class="d">' . wigo_prod_e($card['info']) . '</span></a>';
}

/*
 * 관리자(로그인한 상태)에게만: 목록이 비어 있을 때 원인을 찾는 데 쓰는 점검 문구.
 * p_product 의 분류(product_kind) · 사용여부(use_yn) 조합별 개수를 보여줍니다. 일반 방문자에게는 아무것도 출력하지 않습니다.
 */
function wigo_prod_debug_html($group)
{
    global $is_admin;
    if (empty($is_admin)) return '';
    $groups = wigo_prod_groups();
    $res = sql_query("SELECT product_kind, use_yn, COUNT(*) AS c FROM p_product GROUP BY product_kind, use_yn", false);
    $lines = array();
    if (!$res) {
        $lines[] = 'p_product 조회에 실패했습니다. 테이블 이름이나 DB 연결을 확인해 주세요.';
    } else {
        while ($r = sql_fetch_array($res)) $lines[] = '분류 [' . wigo_prod_e($r['product_kind']) . '] · 사용여부 [' . wigo_prod_e($r['use_yn']) . '] : ' . (int) $r['c'] . '건';
        if (!$lines) $lines[] = 'p_product 에 등록된 제품이 없습니다.';
    }
    $want = isset($groups[$group]) ? implode(', ', $groups[$group]['kinds']) : '';
    return '<div style="margin:18px 0;padding:14px 16px;border:1px dashed #c0392b;color:#7a2a20;font-size:13px;line-height:1.7;text-align:left"><b>[관리자 점검]</b> 이 목록은 분류가 <b>' . wigo_prod_e($want) . '</b> 이고 사용여부가 <b>y</b> 인 제품만 보여줍니다.<br>' . implode('<br>', $lines) . '</div>';
}
