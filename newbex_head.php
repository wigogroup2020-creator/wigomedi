<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
$currentPage = basename($_SERVER['SCRIPT_NAME']);
$brandMeta = array(
    'm11.html' => array('기업소개 | GROBio × WIGO 그로바이오·위고', '두피·헤어케어, 피부 앰플, 뷰티기기. 그로바이오가 제품을 개발·제조하고 위고가 판매와 유통 플랫폼을 운영합니다.'),
    'm12.html' => array('오시는 길 | GROBio × WIGO 그로바이오·위고', '그로바이오 공장(대전 유성구 테크노2로)과 위고 사무실(대전 서구 둔산중로)의 위치와 연락처를 안내합니다.'),
    'm21.html' => array('그로바이오 제품 | GROBio × WIGO', '그로바이오가 개발·제조하는 두피·헤어케어, 스킨케어, 셀프케어 앰플 제품을 소개합니다.'),
    'm22.html' => array('위고 제휴제품 | GROBio × WIGO', '위고가 공급하는 제휴제품을 소개합니다. 제품 구성과 도입 조건은 상담을 통해 안내합니다.'),
    'stores.html' => array('매장안내 | GROBio × WIGO', '제품을 만나볼 수 있는 매장을 안내합니다. 매장 사진과 위치를 확인하고 네이버 지도로 방문 정보를 확인하세요.'),
    'm41.html' => array('제품 및 파트너 문의 | GROBio × WIGO', '그로바이오 제품, 제휴제품, 가맹·대리점 및 총판 도입을 상담합니다. 주식회사 위고에 문의해 주세요.'),
    'm31.html' => array('공지사항 | GROBio × WIGO', '그로바이오와 위고의 새로운 소식을 안내합니다.'),
    'm32.html' => array('자료실 | GROBio × WIGO', '그로바이오와 위고의 제품 소개·사용 안내 자료를 확인하세요.')
);
$brandPage = isset($brandMeta[$currentPage]) ? $brandMeta[$currentPage] : array('GROBio × WIGO 그로바이오·위고 | 두피·피부·뷰티기기', '두피·헤어케어, 피부 앰플, 뷰티기기. 그로바이오 제품 안내와 위고의 제품 도입·총판·대리점 문의를 확인하세요.');
$brandPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$brandUrl = rtrim(G5_URL, '/') . (($brandPath === '/index.html') ? '/' : $brandPath);
?>
    <title><?php echo htmlspecialchars($brandPage[0], ENT_QUOTES, 'UTF-8'); ?></title>
    <meta name="naver-site-verification" content="60cef302f92d4d6100019aea5e2766764e8afd2a" />
    <meta name="description" content="<?php echo htmlspecialchars($brandPage[1], ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="keywords" content="GROBio, 그로바이오, WIGO, 위고, 슈가그로우, 슈가페이스, 슈가리젠, 뷰티기기, 앰플, 두피케어, 총판, 대리점">
    <meta name="author" content="주식회사 위고">
    <link rel="canonical" href="<?php echo htmlspecialchars($brandUrl, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ko_KR">
    <meta property="og:site_name" content="GROBio × WIGO">
    <meta property="og:title" content="<?php echo htmlspecialchars($brandPage[0], ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:url" content="<?php echo htmlspecialchars($brandUrl, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:image" content="<?php echo G5_URL; ?>/img/grobio/share.png?v=3">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="GROBio × WIGO 그로바이오·위고 | 기술에서 일상까지">
    <meta property="og:description" content="<?php echo htmlspecialchars($brandPage[1], ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo htmlspecialchars($brandPage[0], ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:description" content="<?php echo htmlspecialchars($brandPage[1], ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="twitter:image" content="<?php echo G5_URL; ?>/img/grobio/share.png?v=3">
    <link rel="icon" type="image/svg+xml" href="<?php echo G5_URL; ?>/img/grobio/favicon.svg">
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
    <link rel="stylesheet" href="<?php echo G5_URL; ?>/css/grobio-wigo.css?v=4">
	<?php if ($currentPage === 'index.php' || $currentPage === 'index.html') { ?>
    <link rel="stylesheet" href="<?php echo G5_URL; ?>/css/grobio-home.css?v=2">
	<?php } ?>
	<?php if ($currentPage === 'm11.html') { ?>
    <link rel="stylesheet" href="<?php echo G5_URL; ?>/css/grobio-about.css?v=1">
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
				<?php
				if($member['mb_id']){
					// 로그인중
				?>
					<a href="<?php echo G5_URL;?>/page/info.php" style="display: flex; flex-direction: column; align-items: center; margin-right: 8px;">
						<div class="login_btn" aria-label="회원 페이지"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="12" cy="7" r="4"/><path d="M4 22v-2a8 8 0 0 1 16 0v2"/></svg></div>
						<span><?php echo $member['mb_name'];?></span>
					</a>
				<?php 
				}else{
				?>
					<a href="<?php echo G5_URL;?>/pages/login.html" style="display: flex; flex-direction: column; align-items: center; margin-right: 8px;">
						<div class="login_btn" aria-label="회원 페이지"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="12" cy="7" r="4"/><path d="M4 22v-2a8 8 0 0 1 16 0v2"/></svg></div>
					</a>
				<?php
				}
				?>
                <div class="language">
					<a>KOR<i></i></a>
					<div class="lang_box">
						<ul class="lang_list">
							<li><a href="/en/" target="_blank">ENG</a></li>
						</ul>
					</div>
				</div>
				<div class="btnMenu" role="button" tabindex="0" aria-label="전체 메뉴" aria-expanded="false" aria-controls="brand-allmenu">
					<div></div>
					<div></div>
					<div></div>
				</div>
			</div>
		</div>
		<div class="allmenuBg"></div>
		<div class="allmenu" id="brand-allmenu">
			<div class="allmenuwrap">
				<div>
					<div class="brand-menu-logo"><a href="/" aria-label="GROBio × WIGO 홈"><img src="<?php echo G5_URL; ?>/img/grobio/lockup.png" alt="GROBio × WIGO" width="260" height="42"></a></div>
					<ul>
                        <li><a>ABOUT US</a>
                            <ul>
                                <li><a href="<?php echo G5_URL;?>/pages/m11.html">기업소개</a></li>
                                <li><a href="<?php echo G5_URL;?>/pages/m12.html">오시는 길</a></li>
                                <li><a href="<?php echo G5_URL;?>/pages/m13.html">협력사 / 고객사</a></li>
                            </ul>
                        </li>
                        <li><a>PRODUCT</a>
                            <ul>
                                <li><a href="<?php echo G5_URL;?>/pages/m21.html">그로바이오</a></li>
                                <li><a href="<?php echo G5_URL;?>/pages/m22.html">제휴제품</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo G5_URL;?>/pages/stores.html">STORES</a><ul><li><a href="<?php echo G5_URL;?>/pages/stores.html">매장안내</a></li></ul></li>
                        <li><a>CONTACT</a>
                            <ul>
                                <li><a href="<?php echo G5_URL;?>/pages/m41.html">문의하기</a></li>
                            </ul>
                        </li>
                        <li><a>CUSTOMER</a>
                            <ul>
                                <li><a href="<?php echo G5_URL;?>/pages/m31.html">공지사항</a></li>
                                <li><a href="<?php echo G5_URL;?>/pages/m32.html">자료실</a></li>
                            </ul>
                        </li>
                    </ul>
				</div>
			</div>
		</div>
	</header>