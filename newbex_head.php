<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
$currentPage = basename($_SERVER['SCRIPT_NAME']);

$siteName = 'GROBio × WIGO 그로바이오 · 위고';

$brandMeta = array(
    'm11.html' => array(
        '기업소개 | 그로바이오 · 위고',
        '그로바이오는 제품 개발 · 제조 · 품질과 브랜드 · 기술을, 위고는 판매 · 지역 유통 · 플랫폼 운영을 담당합니다. 두피 · 피부 케어와 뷰티기기를 중심으로 함께 사업을 추진합니다.'
    ),
    'm12.html' => array(
        '오시는 길 | 그로바이오 · 위고',
        '그로바이오와 위고의 사업장 위치 및 방문 정보를 안내합니다. 방문 전 위치와 연락처를 확인해 주세요.'
    ),
    'm13.html' => array(
        '협력사 · 고객사 | 그로바이오 · 위고',
        '그로바이오와 위고의 협력사 · 고객사를 소개합니다. 제품과 유통, 판매 및 플랫폼 분야의 협력 정보를 확인하세요.'
    ),
    'm21.html' => array(
        '그로바이오 브랜드 · 제품 | GROBio × WIGO',
        '그로바이오의 두피 · 헤어케어, 피부 · 스킨케어 및 앰플 브랜드와 제품을 소개합니다. 제품 정보와 구성, 사용 안내를 확인하세요.'
    ),
    'm22.html' => array(
        '위고 제휴제품 | GROBio × WIGO',
        '위고가 판매 · 유통하는 제휴제품을 소개합니다. ALLVIS 올비스를 비롯한 제품 정보와 도입 상담을 확인하세요.'
    ),
    'stores.html' => array(
        '매장안내 | 그로바이오 · 위고',
        '등록된 매장의 위치와 사진, 방문 정보를 안내합니다. 취급 제품과 상담 가능 여부는 방문 전 해당 매장에 확인해 주세요.'
    ),
    'm41.html' => array(
        '제품 · 총판 · 제휴 문의 | 그로바이오 · 위고',
        '제품 도입, 광역총판 · 대리점, 온라인 판매 및 제품 제휴를 상담합니다. 판매 · 유통 · 플랫폼 운영 담당 주식회사 위고에 문의해 주세요.'
    ),
    'm31.html' => array(
        '공지사항 | 그로바이오 · 위고',
        '그로바이오와 위고의 제품 · 브랜드 소식과 사업 및 운영 공지를 확인하세요.'
    ),
    'm32.html' => array(
        '자료실 | 그로바이오 · 위고',
        '그로바이오 제품과 위고 제휴제품의 소개 자료, 사용 안내 및 사업 관련 자료를 확인하세요.'
    )
);

$brandPage = isset($brandMeta[$currentPage])
    ? $brandMeta[$currentPage]
    : array(
        '그로바이오 · 위고 | 두피 · 피부 케어와 뷰티기기',
        '그로바이오와 위고의 공동 홈페이지입니다. 두피 · 피부 케어와 뷰티기기를 중심으로 브랜드 · 제품, 제휴제품 및 광역총판 · 대리점 상담을 안내합니다.'
    );

// 제품 상세: 제품명 · 설명을 제목과 설명에 사용합니다.
if ($currentPage === 'm21_view.html' && !empty($product_subject)) {
    $brandPage = array(
        $product_subject . ' | 그로바이오 · 위고',
        !empty($product_info) ? strip_tags($product_info) : '그로바이오 · 위고 제품 정보를 확인하세요.'
    );
}

$brandPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$brandPath = is_string($brandPath) ? $brandPath : '/';

if ($brandPath === '/index.html' || $brandPath === '/index.php') {
    $brandPath = '/';
}

$brandUrl = rtrim(G5_URL, '/') . $brandPath;

// 상세페이지는 제품 · 게시글 식별에 필요한 쿼리 문자열을 유지합니다.
if (strpos($currentPage, '_view.') !== false) {
    $brandQuery = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);

    if (is_string($brandQuery) && $brandQuery !== '') {
        $brandUrl .= '?' . $brandQuery;
    }
}

// 그로바이오 이미지가 서버에 있을 때만 출력합니다.
$brandShareExists = is_file(G5_PATH . '/img/grobio/share.png');
$brandIconExists  = is_file(G5_PATH . '/img/grobio/favicon.svg');

$brandShareUrl = rtrim(G5_URL, '/') . '/img/grobio/share.png?v=' . ($brandShareExists ? filemtime(G5_PATH . '/img/grobio/share.png') : '1');
$brandIconUrl  = rtrim(G5_URL, '/') . '/img/grobio/favicon.svg?v=' . ($brandIconExists ? filemtime(G5_PATH . '/img/grobio/favicon.svg') : '1');
?>
<title><?php echo htmlspecialchars($brandPage[0], ENT_QUOTES, 'UTF-8'); ?></title>

<meta name="naver-site-verification" content="60cef302f92d4d6100019aea5e2766764e8afd2a">

<meta name="description" content="<?php echo htmlspecialchars($brandPage[1], ENT_QUOTES, 'UTF-8'); ?>">
<meta name="keywords" content="그로바이오, GROBio, 위고, WIGO, 두피케어, 헤어케어, 스킨케어, 바이오 앰플, 마이크로니들, 뷰티기기, 제휴제품, 광역총판, 대리점">
<meta name="author" content="주식회사 위고">

<link rel="canonical" href="<?php echo htmlspecialchars($brandUrl, ENT_QUOTES, 'UTF-8'); ?>">

<meta property="og:type" content="website">
<meta property="og:locale" content="ko_KR">
<meta property="og:site_name" content="<?php echo htmlspecialchars($siteName, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:title" content="<?php echo htmlspecialchars($brandPage[0], ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:description" content="<?php echo htmlspecialchars($brandPage[1], ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:url" content="<?php echo htmlspecialchars($brandUrl, ENT_QUOTES, 'UTF-8'); ?>">

<meta name="twitter:card" content="<?php echo $brandShareExists ? 'summary_large_image' : 'summary'; ?>">
<meta name="twitter:title" content="<?php echo htmlspecialchars($brandPage[0], ENT_QUOTES, 'UTF-8'); ?>">
<meta name="twitter:description" content="<?php echo htmlspecialchars($brandPage[1], ENT_QUOTES, 'UTF-8'); ?>">

<?php if ($brandShareExists) { ?>
<meta property="og:image" content="<?php echo htmlspecialchars($brandShareUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:alt" content="GROBio × WIGO 그로바이오 · 위고">
<meta name="twitter:image" content="<?php echo htmlspecialchars($brandShareUrl, ENT_QUOTES, 'UTF-8'); ?>">
<meta name="twitter:image:alt" content="GROBio × WIGO 그로바이오 · 위고">
<?php } ?>

<?php if ($brandIconExists) { ?>
<link rel="icon" type="image/svg+xml" href="<?php echo htmlspecialchars($brandIconUrl, ENT_QUOTES, 'UTF-8'); ?>">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo G5_URL; ?>/img/grobio/favicon-32.png">
<link rel="icon" type="image/png" sizes="192x192" href="<?php echo G5_URL; ?>/img/grobio/favicon-192.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo G5_URL; ?>/img/grobio/apple-touch-icon.png">
<link rel="shortcut icon" href="<?php echo G5_URL; ?>/favicon.ico">
<meta name="theme-color" content="#00553d">
<?php } ?>
    <!-- css -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo G5_URL; ?>/css/swiper-bundle.min.css" />
    <link rel="stylesheet" href="<?php echo G5_URL;?>/css/common.css">
	<?php 
	$currentPage = basename($_SERVER['SCRIPT_NAME']);
	if ($currentPage !== 'index.php' && $currentPage !== 'index.html') {
		// index.html 이 아닐 때만 추가되는 css
	?>
		<link rel="stylesheet" href="<?php echo G5_URL; ?>/css/style.css">
	<?php 
	}
	?>
    <link rel="stylesheet" href="<?php echo G5_URL; ?>/css/brand-88lion.css">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700;12..96,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo G5_URL; ?>/css/grobio-wigo.css?v=20">
    <link rel="stylesheet" href="<?php echo G5_URL; ?>/css/grobio-menu.css?v=4">
	<?php if ($currentPage === 'index.php' || $currentPage === 'index.html') { ?>
    <link rel="stylesheet" href="<?php echo G5_URL; ?>/css/grobio-home.css?v=11">
	<?php } ?>
	<?php if ($currentPage === 'm11.html') { ?>
    <link rel="stylesheet" href="<?php echo G5_URL; ?>/css/grobio-about.css?v=4">
	<?php } ?>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
        <header id="header">
		<div class="head">
			<h1><a class="brand-wordmark" href="/" aria-label="GROBio × WIGO 홈"><img class="brand-logo brand-logo-primary" src="<?php echo G5_URL; ?>/img/grobio/lockup.png" alt="GROBio × WIGO" width="236" height="38"><img class="brand-logo brand-logo-inverse" src="<?php echo G5_URL; ?>/img/grobio/lockup-white.png" alt="" aria-hidden="true" width="236" height="38"></a></h1>
			<div class="pcNav">
				<ul>
					<li><a href="<?php echo G5_URL;?>/pages/m11.html">ABOUT US</a>
						<ul>
							<li><a href="<?php echo G5_URL;?>/pages/m11.html">기업소개</a></li>
							<li><a href="<?php echo G5_URL;?>/pages/m12.html">오시는 길</a></li>
							<li><a href="<?php echo G5_URL;?>/pages/m13.html">협력사 / 고객사</a></li>
						</ul>
					</li>
					<li><a href="<?php echo G5_URL;?>/pages/m21.html">PRODUCT</a>
						<ul>
							<li><a href="<?php echo G5_URL;?>/pages/m21.html">그로바이오</a></li>
							<li><a href="<?php echo G5_URL;?>/pages/m22.html">제휴제품</a></li>
						</ul>
					</li>
                    <li><a href="<?php echo G5_URL;?>/pages/stores.html">STORES</a><ul><li><a href="<?php echo G5_URL;?>/pages/stores.html">매장안내</a></li></ul></li>
                    <li><a href="<?php echo G5_URL;?>/pages/m41.html">CONTACT</a>
                        <ul>
                            <li><a href="<?php echo G5_URL;?>/pages/m41.html">문의하기</a></li>
                        </ul>
                    </li>
					<li><a href="<?php echo G5_URL;?>/pages/m31.html">CUSTOMER</a>
						<ul>
							<li><a href="<?php echo G5_URL;?>/pages/m31.html">공지사항</a></li>
							<li><a href="<?php echo G5_URL;?>/pages/m32.html">자료실</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="gnb">
				<?php if ($member['mb_id']) { // 로그인 상태: 이름 첫 글자 배지 ?>
				<a class="gw-user in" href="<?php echo G5_URL;?>/page/info.php" title="<?php echo htmlspecialchars($member['mb_name'], ENT_QUOTES, 'UTF-8');?>님 · 회원 정보" aria-label="회원 정보 (<?php echo htmlspecialchars($member['mb_name'], ENT_QUOTES, 'UTF-8');?>님 로그인 중)"><?php echo htmlspecialchars(mb_strtoupper(mb_substr(trim($member['mb_name']) !== '' ? trim($member['mb_name']) : $member['mb_id'], 0, 1, 'UTF-8'), 'UTF-8'), ENT_QUOTES, 'UTF-8');?></a>
				<?php } else { // 로그아웃 상태: 사람 아이콘 ?>
				<a class="gw-user" href="<?php echo G5_URL;?>/pages/login.html" title="로그인" aria-label="로그인"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><circle cx="12" cy="8" r="3.6"/><path d="M5 20c.6-3.6 3.4-5.6 7-5.6s6.4 2 7 5.6"/></svg></a>
				<?php } ?>
				<div class="language">
					<a role="button" tabindex="0" aria-haspopup="true" aria-label="언어 선택">KO</a>
					<div class="lang_box">
						<ul class="lang_list">
							<li><span class="cur">KO</span></li>
							<li><a href="/en/" target="_blank" rel="noopener">EN</a></li>
						</ul>
					</div>
				</div>
				<div class="btnMenu" role="button" tabindex="0" aria-label="전체 메뉴" aria-expanded="false" aria-controls="brand-allmenu" aria-haspopup="dialog">
					<svg width="22" height="22" viewBox="0 0 22 22" fill="currentColor" aria-hidden="true"><circle cx="4" cy="4" r="1.8"/><circle cx="11" cy="4" r="1.8"/><circle cx="18" cy="4" r="1.8"/><circle cx="4" cy="11" r="1.8"/><circle cx="11" cy="11" r="1.8"/><circle cx="18" cy="11" r="1.8"/><circle cx="4" cy="18" r="1.8"/><circle cx="11" cy="18" r="1.8"/><circle cx="18" cy="18" r="1.8"/></svg>
				</div>
			</div>
		</div>
		<div class="gwm" id="brand-allmenu" role="dialog" aria-modal="true" aria-label="전체 메뉴" hidden>
			<span id="gwm-ready" hidden></span>
			<div class="gwm-panel">
			<div class="gwm-top">
				<a class="gwm-logo" href="/" aria-label="홈"><img src="<?php echo G5_URL; ?>/img/grobio/lockup.png" alt="GROBio × WIGO" width="236" height="38"></a>
				<button type="button" class="gwm-x" aria-label="메뉴 닫기"><span aria-hidden="true"></span><span aria-hidden="true"></span></button>
			</div>
			<div class="gwm-in">
				<div class="gwm-nav" role="navigation" aria-label="전체 메뉴">
					<ul>
						<li><a href="<?php echo G5_URL;?>/pages/m11.html">회사소개</a></li>
						<li><a href="<?php echo G5_URL;?>/pages/m21.html">제품소개</a></li>
						<li><a href="<?php echo G5_URL;?>/pages/m22.html">제휴제품</a></li>
						<li><a href="<?php echo G5_URL;?>/pages/stores.html">매장안내</a></li>
						<li><a href="<?php echo G5_URL;?>/pages/m12.html">오시는 길</a></li>
						<li><a href="<?php echo G5_URL;?>/pages/m13.html">협력사 / 고객사</a></li>
						<li><a href="<?php echo G5_URL;?>/pages/m31.html">공지사항</a></li>
						<li><a href="<?php echo G5_URL;?>/pages/m32.html">자료실</a></li>
						<li><a href="<?php echo G5_URL;?>/pages/m41.html">문의하기</a></li>
						<?php if (!$member['mb_id']) { ?>
						<li class="sub"><a href="<?php echo G5_URL;?>/pages/login.html">로그인</a></li>
						<?php } ?>
						<li class="sub"><a href="https://pf.kakao.com/_KmSJn">카카오톡 상담</a></li>
					</ul>
				</div>
				<p class="gwm-contact"><a href="tel:15553336">1555-3336</a><span>평일 09:00–18:00</span></p>
			</div>
			</div>
		</div>
	</header>