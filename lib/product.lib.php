<?php
if (!defined('_GNUBOARD_')) exit;

/*
 * 홈페이지 PRODUCT 카드 (GROBio × WIGO)
 * 기존 제품관리(p_product) 테이블을 그대로 읽습니다. 새 테이블·컬럼은 만들지 않습니다.
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

/* 기본 카드: 사업계획서 기준 제품군. 확인되지 않은 효능·인증·수치·가격은 넣지 않습니다. */
function wigo_prod_defaults($group)
{
    if ($group === 'grobio') {
        return array(
            array('kind' => '그로바이오', 'slug' => 'sugar-grow', 'name' => '슈가그로우', 'info' => '프리미엄 두피·헤어케어 전문 솔루션', 'area' => '두피·헤어케어', 'en' => 'Scalp & Hair Care', 'tone' => 'mint', 'status' => '상세 안내 준비 중',
                  'content' => '<p>그로바이오의 두피·헤어케어 브랜드입니다.</p><p>제품 구성과 사용 방법, 출시 일정은 확정되는 대로 안내합니다. 도입 상담은 문의하기를 이용해 주세요.</p>'),
            array('kind' => '그로바이오', 'slug' => 'sugar-face', 'name' => '슈가페이스', 'info' => '프리미엄 페이셜·스킨케어 라인', 'area' => '피부·스킨케어', 'en' => 'Facial Skincare', 'tone' => 'blush', 'status' => '상세 안내 준비 중',
                  'content' => '<p>그로바이오의 페이셜·스킨케어 브랜드입니다.</p><p>제품 구성과 사용 방법, 출시 일정은 확정되는 대로 안내합니다. 도입 상담은 문의하기를 이용해 주세요.</p>'),
            array('kind' => '그로바이오', 'slug' => 'sugar-regen', 'name' => '슈가리젠', 'info' => '플래그십 2PC 셀프케어 앰플', 'area' => '셀프케어 앰플', 'en' => 'Self-care Ampoule', 'tone' => 'sky', 'status' => '상세 안내 준비 중',
                  'content' => '<p>그로바이오가 직접 제조하는 셀프케어 앰플 라인의 플래그십 제품입니다.</p><p>제품 구성과 사용 방법, 공급 조건은 확정되는 대로 안내합니다. 도입 상담은 문의하기를 이용해 주세요.</p>'),
            array('kind' => '그로바이오', 'slug' => 'grobio-wellness', 'name' => '그로바이오 웰니스', 'info' => '이너 웰니스 제품군', 'area' => '웰니스', 'en' => 'Nutritional & Bio', 'tone' => 'mute', 'status' => '출시 준비 중',
                  'content' => '<p>이너 웰니스 제품군을 준비하고 있습니다.</p><p>제품 구성과 출시 일정은 관련 기준 검토를 마친 뒤 안내합니다.</p>'),
        );
    }
    if ($group === 'partner') {
        return array(
            array('kind' => '제휴제품', 'slug' => 'allvis', 'name' => 'ALLVIS 올비스', 'info' => 'HIFU & LDM 관리 기기', 'area' => '뷰티기기 · 제휴제품', 'en' => 'Beauty Device', 'tone' => 'navy', 'status' => '',
                  'content' => '<p>매장 관리 프로그램을 위한 HIFU &amp; LDM 기기입니다. 제품 구성과 사용 방법, 도입 조건은 상담을 통해 안내합니다.</p>'
                             . '<p><a href="/img/file/올비스_카달로그(국문).pdf" download>카탈로그 · 국문 다운로드</a><br><a href="/img/file/올비스_카달로그(영문).pdf" download>카탈로그 · 영문 다운로드</a></p>'),
        );
    }
    return array();
}

function wigo_prod_count($group)
{
    $in = wigo_prod_in_clause($group);
    $row = sql_fetch("SELECT COUNT(*) AS cnt FROM p_product WHERE product_kind IN ($in)", false);
    return is_array($row) && isset($row['cnt']) ? (int) $row['cnt'] : 0;
}

function wigo_prod_image_url($file)
{
    // 업로드 파일명은 날짜+숫자+확장자 형태입니다. 그 밖의 값은 사용하지 않습니다.
    if (!is_string($file) || $file === '' || !preg_match('/^[0-9A-Za-z._+-]{1,120}$/D', $file) || strpos($file, '..') !== false) return '';
    return G5_DATA_URL . '/product/' . rawurlencode($file);
}

/* 카드 목록. $group = 'grobio' | 'partner' */
function wigo_prod_cards($group, $limit = 0)
{
    $cards = array();
    $groups = wigo_prod_groups();
    if (!isset($groups[$group])) return $cards;
    $in = wigo_prod_in_clause($group);
    $result = sql_query("SELECT product_no, product_kind, product_subject, product_info, product_file FROM p_product WHERE use_yn = 'y' AND product_kind IN ($in) ORDER BY product_no ASC", false);
    while ($result && ($row = sql_fetch_array($result))) {
        $cards[] = array(
            'no'    => (int) $row['product_no'],
            'group' => $group,
            'kind'  => $groups[$group]['label'],
            'name'  => $row['product_subject'],
            'info'  => $row['product_info'],
            'img'   => wigo_prod_image_url($row['product_file']),
            'href'  => '/pages/m21_view.html?product_no=' . (int) $row['product_no'],
            'desc'  => '',
            'area'  => $groups[$group]['label'],
            'en'    => '',
            'tone'  => ($group === 'partner') ? 'navy' : 'mint',
            'status' => '',
        );
    }
    if (!$cards && wigo_prod_count($group) === 0) {
        foreach (wigo_prod_defaults($group) as $d) {
            $cards[] = array('no' => 0, 'group' => $group, 'kind' => $groups[$group]['label'], 'name' => $d['name'], 'info' => $d['info'],
                             'img' => '', 'href' => '/pages/m21_view.html?item=' . $d['slug'], 'desc' => '',
                             'area' => $d['area'], 'en' => $d['en'], 'tone' => $d['tone'], 'status' => $d['status']);
        }
    }
    return ($limit > 0) ? array_slice($cards, 0, $limit) : $cards;
}

/* 홈: 그로바이오 최대 4개 + 제휴제품 최대 2개 */
function wigo_prod_home_cards()
{
    $cards = array_merge(wigo_prod_cards('grobio', 4), wigo_prod_cards('partner', 2));
    // 출시 준비 중인 웰니스는 목록 맨 뒤로 보냅니다.
    usort($cards, function ($a, $b) {
        $aw = (strpos($a['name'], '웰니스') !== false) ? 1 : 0;
        $bw = (strpos($b['name'], '웰니스') !== false) ? 1 : 0;
        return $aw - $bw;
    });
    return $cards;
}

/* 메인 슬라이드용 카드 1장 (이미지가 있으면 사진, 없으면 분야 그래픽) */
function wigo_prod_rail_card_html($card)
{
    $tone = preg_match('/^[a-z]+$/', (string) $card['tone']) ? $card['tone'] : 'mint';
    $en = ($card['en'] !== '') ? $card['en'] : $card['kind'];
    $media = ($card['img'] !== '')
        ? '<img class="hm-ph" src="' . wigo_prod_e($card['img']) . '" alt="" loading="lazy">'
        : '<span class="hm-art" aria-hidden="true"><i></i><em>' . wigo_prod_e($en) . '</em></span>';
    $chip = ($card['status'] !== '') ? '<span class="hm-chip">' . wigo_prod_e($card['status']) . '</span>' : '';
    $inner = '<span class="hm-media">' . $media . $chip . '</span>'
        . '<span class="hm-body"><span class="hm-area">' . wigo_prod_e($card['area']) . '</span>'
        . '<strong class="hm-name">' . wigo_prod_e($card['name']) . '</strong>'
        . '<span class="hm-desc">' . wigo_prod_e($card['info']) . '</span>'
        . '<span class="hm-cta">' . '자세히 보기' . '<i aria-hidden="true">→</i></span></span>';
    return '<li class="hm-card t-' . $tone . '"><a class="hm-card-in" href="' . wigo_prod_e($card['href']) . '">' . $inner . '</a></li>';
}

/* 카드 1장. 모든 카드는 제품 상세 페이지로 연결합니다(기본 카드는 ?item= 안내 페이지). */
function wigo_prod_card_html($card, $index)
{
    $tone = 'c' . (($index % 5) + 1);
    $img = $card['img'] !== '' ? '<img class="ph" src="' . wigo_prod_e($card['img']) . '" alt="" loading="lazy">' : '';
    $cls = 'gw-pc ' . $tone . ($img !== '' ? ' has-img' : '');
    $inner = $img
        . '<span class="k">' . wigo_prod_e($card['kind']) . '</span>'
        . '<span class="m">' . wigo_prod_e($card['name']) . '</span>'
        . '<span class="i">' . wigo_prod_e($card['info']) . '</span>';
    return '<a class="' . $cls . '" href="' . wigo_prod_e($card['href']) . '">' . $inner . '</a>';
}

/* 관리자: 기본 카드를 p_product에 등록(해당 구분이 비어 있을 때만). 등록한 개수를 돌려줍니다. */
function wigo_prod_seed()
{
    global $member;
    $added = 0;
    $reg = sql_real_escape_string(isset($member['mb_id']) ? $member['mb_id'] : '');
    foreach (array('grobio', 'partner') as $group) {
        if (wigo_prod_count($group) > 0) continue;
        foreach (wigo_prod_defaults($group) as $d) {
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
    return null;
}
