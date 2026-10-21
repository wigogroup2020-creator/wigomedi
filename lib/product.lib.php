<?php
if (!defined('_GNUBOARD_')) exit;

/*
 * 홈페이지 PRODUCT 카드 (GROBio × WIGO)
 * 기존 제품관리(p_product) 테이블을 그대로 읽습니다. 새 테이블 · 컬럼은 만들지 않습니다.
 *
 *  - 그로바이오 제품 : product_kind = '그로바이오'
 *  - 제휴제품       : product_kind = '제휴제품' 또는 기존 'HIFU+LDM'(ALLVIS)
 *  - Newbex / ReviveCell 은 홈페이지 PRODUCT에 표시하지 않습니다(DB 데이터는 그대로 보관).
 *
 * 해당 구분에 등록된 행이 하나도 없으면 아래 기본 카드를 보여줍니다.
 * 관리자 > 제품관리 > "기본 카드 등록"을 누르면 기본 카드가 DB에 들어가 수정할 수 있습니다.
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

/* 기본 카드: 목록에 보이는 4개(그로바이오) + 1개(제휴제품). 확인되지 않은 효능 · 인증 · 수치 · 가격 · 출시 일정은 넣지 않습니다. */
function wigo_prod_defaults($group)
{
    if ($group === 'grobio') {
        return array(
            array('kind' => '그로바이오', 'slug' => 'sugar-grow', 'name' => '슈가그로우', 'info' => '두피 · 헤어케어', 'area' => '두피 · 헤어케어', 'en' => 'Scalp & Hair Care', 'tone' => 'mint', 'status' => '',
                  'content' => '<p>그로바이오의 두피 · 헤어케어 제품입니다.</p>'),
            array('kind' => '그로바이오', 'slug' => 'sugar-face', 'name' => '슈가페이스', 'info' => '페이셜 케어', 'area' => '페이셜 케어', 'en' => 'Facial Care', 'tone' => 'blush', 'status' => '',
                  'content' => '<p>그로바이오의 페이셜 케어 제품입니다.</p>'),
            array('kind' => '그로바이오', 'slug' => 'sugar-regen', 'name' => '슈가리젠', 'info' => '셀프케어 앰플', 'area' => '셀프케어 앰플', 'en' => 'Self-care Ampoule', 'tone' => 'sky', 'status' => '',
                  'content' => '<p>그로바이오가 제조하는 셀프케어 앰플 제품입니다.</p>'),
            array('kind' => '그로바이오', 'slug' => 'beauty-device', 'name' => '뷰티기기', 'info' => '기기 기반 케어', 'area' => '뷰티기기', 'en' => 'Beauty Device', 'tone' => 'lav', 'status' => '',
                  'content' => '<p>제품과 함께 사용하는 기기 기반 케어 제품입니다.</p>'),
        );
    }
    if ($group === 'partner') {
        return array(
            array('kind' => '제휴제품', 'slug' => 'partner-select', 'name' => '제휴상품', 'info' => '함께 선보이는 뷰티 셀렉션', 'area' => '제휴제품', 'en' => 'Beauty Selection', 'tone' => 'ivory', 'status' => '',
                  'content' => '<p>위고가 함께 선보이는 뷰티 셀렉션입니다. 제품 구성은 상담을 통해 안내합니다.</p>'),
        );
    }
    return array();
}

/* 예전 기본 카드(웰니스 · ALLVIS): 목록에는 쓰지 않지만 기존 상세 주소(?item=)가 깨지지 않도록 남깁니다. */
function wigo_prod_legacy_defaults()
{
    return array(
        array('kind' => '그로바이오', 'slug' => 'grobio-wellness', 'name' => '그로바이오 웰니스', 'info' => '이너 웰니스 제품군',
              'content' => '<p>이너 웰니스 제품군을 준비하고 있습니다.</p>'),
        array('kind' => '제휴제품', 'slug' => 'allvis', 'name' => 'ALLVIS 올비스', 'info' => 'HIFU & LDM 관리 기기',
              'content' => '<p>매장 관리 프로그램을 위한 HIFU &amp; LDM 기기입니다. 제품 구성과 사용 방법, 도입 조건은 상담을 통해 안내합니다.</p>'
                         . '<p><a href="/img/file/올비스_카달로그(국문).pdf" download>카탈로그 · 국문 다운로드</a><br><a href="/img/file/올비스_카달로그(영문).pdf" download>카탈로그 · 영문 다운로드</a></p>'),
    );
}

/* 기본 제품 사진: img/grobio/products/<slug>.jpg 가 있으면 그 주소, 없으면 빈 문자열 */
function wigo_prod_default_image($slug)
{
    $slug = preg_replace('/[^a-z-]/', '', (string) $slug);
    $path = G5_PATH . '/img/grobio/products/' . $slug . '.jpg';
    return ($slug !== '' && is_file($path)) ? G5_URL . '/img/grobio/products/' . $slug . '.jpg?v=' . filemtime($path) : '';
}

/* 등록 제품에 사진이 없을 때: 같은 이름의 기본 제품 사진, 없으면 빈 문자열 */
function wigo_prod_image_by_name($name)
{
    foreach (array('grobio', 'partner') as $group) {
        foreach (wigo_prod_defaults($group) as $d) {
            if ($d['name'] === $name) return wigo_prod_default_image($d['slug']);
        }
    }
    foreach (wigo_prod_legacy_defaults() as $d) {
        if ($d['name'] === $name && $d['slug'] === 'allvis') return wigo_prod_default_image('allvis');
    }
    return '';
}

function wigo_prod_image_url($file)
{
    // 업로드 파일명은 날짜+숫자+확장자 형태입니다. 그 밖의 값은 사용하지 않습니다.
    if (!is_string($file) || $file === '' || !preg_match('/^[0-9A-Za-z._+-]{1,120}$/D', $file) || strpos($file, '..') !== false) return '';
    return G5_DATA_URL . '/product/' . rawurlencode($file);
}

/* 제품 목록 페이지용: DB와 무관하게 고정 카드(그로바이오 4 / 제휴 1)를 돌려줍니다. */
function wigo_prod_static_cards($group)
{
    $cards = array();
    foreach (wigo_prod_defaults($group) as $d) {
        $cards[] = array('name' => $d['name'], 'info' => $d['info'], 'img' => wigo_prod_default_image($d['slug']));
    }
    return $cards;
}

/* 홈 뷰티 컬렉션: 5개 고정(그로바이오 4 + 제휴 1). 이름이 같은 등록 제품이 있으면 그 상세로, 없으면 기본 안내로 연결합니다. */
function wigo_prod_collection()
{
    $out = array();
    foreach (array('grobio', 'partner') as $group) {
        foreach (wigo_prod_defaults($group) as $d) {
            $kinds = wigo_prod_in_clause($group);
            $name = sql_real_escape_string($d['name']);
            $row = sql_fetch("SELECT product_no, product_file FROM p_product WHERE use_yn = 'y' AND product_kind IN ($kinds) AND product_subject = '$name' ORDER BY product_no ASC LIMIT 1", false);
            $db = (is_array($row) && !empty($row['product_no']));
            $img = ($db ? wigo_prod_image_url($row['product_file']) : '');
            if ($img === '') $img = wigo_prod_default_image($d['slug']);
            $out[] = array(
                'slug' => $d['slug'], 'name' => $d['name'], 'info' => $d['info'], 'img' => $img,
                'href' => $db ? '/pages/m21_view.html?product_no=' . (int) $row['product_no'] : '/pages/m21_view.html?item=' . $d['slug'],
                'tone' => $d['tone'],
            );
        }
    }
    return $out;
}

/* 목록 카드 1장: 큰 제품 이미지 + 이름 + 짧은 설명. 누르면 "준비 중" 안내(js/soon.js). */
function wigo_prod_card_html($card, $index)
{
    $img = $card['img'] !== '' ? '<img src="' . wigo_prod_e($card['img']) . '" alt="' . wigo_prod_e($card['name']) . '" loading="lazy" width="900" height="900">' : '';
    return '<a class="gw-pc2" href="#" data-soon><span class="pic">' . $img . '</span><strong>' . wigo_prod_e($card['name']) . '</strong><span class="d">' . wigo_prod_e($card['info']) . '</span></a>';
}

/* 관리자: 기본 카드를 p_product에 등록. 같은 분류에 같은 이름의 제품이 이미 있으면 건너뜁니다(기존 제품은 수정 · 삭제하지 않음). */
function wigo_prod_seed()
{
    global $member;
    $added = 0;
    $reg = sql_real_escape_string(isset($member['mb_id']) ? $member['mb_id'] : '');
    foreach (array('grobio', 'partner') as $group) {
        $in = wigo_prod_in_clause($group);
        foreach (wigo_prod_defaults($group) as $d) {
            $exists = sql_fetch("SELECT COUNT(*) AS cnt FROM p_product WHERE product_kind IN ($in) AND product_subject = '" . sql_real_escape_string($d['name']) . "'", false);
            if (is_array($exists) && (int) $exists['cnt'] > 0) continue;
            $sql = "INSERT INTO p_product SET
                product_kind = '" . sql_real_escape_string($d['kind']) . "',
                use_yn = 'y',
                product_info = '" . sql_real_escape_string($d['info']) . "',
                product_subject = '" . sql_real_escape_string($d['name']) . "',
                product_content = '" . sql_real_escape_string($d['content']) . "',
                product_price = '0', product_price_member = '0', product_price_sales = '0', product_price_branch = '0', product_price_chong = '0',
                product_file = '',
                reg_mb_id = '$reg',
                reg_datetime = '" . G5_TIME_YMDHIS . "'";
            if (sql_query($sql, false)) $added++;
        }
    }
    return $added;
}

/* 상세 페이지(m21_view)용: 기본 카드 slug 로 기본 제품 정보를 찾습니다. */
function wigo_prod_default_by_slug($slug)
{
    foreach (array('grobio', 'partner') as $group) {
        foreach (wigo_prod_defaults($group) as $d) {
            if ($d['slug'] === $slug) return $d;
        }
    }
    foreach (wigo_prod_legacy_defaults() as $d) {
        if ($d['slug'] === $slug) return $d;
    }
    return null;
}
