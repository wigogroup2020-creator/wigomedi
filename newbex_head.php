<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php
$currentPage = basename($_SERVER['SCRIPT_NAME']);
$brandMeta = array(
    'm11.html' => array('회사소개 | 88LION 88라이온', '88LION을 운영하는 주식회사 위고를 소개합니다. 두피·뷰티 케어 제품과 ALLVIS 관리 기기를 통해 고객과 파트너를 연결합니다.'),
    'm21.html' => array('88LION 제품 소개 | 두피·뷰티 케어', '88LION 두피·뷰티 케어 제품과 홈케어를 소개합니다. 제품 구성과 사용 안내, 관리 프로그램 및 도입 상담을 확인하세요.'),
    'm22.html' => array('ALLVIS 올비스 | HIFU & LDM 관리 기기', 'ALLVIS HIFU & LDM 관리 기기를 소개합니다. 제품 구성과 사용 안내, 매장 도입 상담을 확인하세요.'),
    'stores.html' => array('88LION 매장안내 | 88라이온', '88LION을 만나볼 수 있는 매장을 안내합니다. 매장 사진과 위치를 확인하고 네이버 지도로 방문 정보를 확인하세요.'),
    'm41.html' => array('제품 및 파트너 문의 | 88LION', '88LION 제품, ALLVIS 기기, 가맹·대리점 및 총판 도입을 상담합니다. 주식회사 위고에 문의해 주세요.'),
    'm31.html' => array('공지사항 | 88LION', '88LION과 ALLVIS의 새로운 소식을 안내합니다.'),
    'm32.html' => array('자료실 | 88LION', '88LION 제품과 ALLVIS 관리 기기의 자료를 확인하세요.')
);
$brandPage = isset($brandMeta[$currentPage]) ? $brandMeta[$currentPage] : array('88LION 88라이온 | 두피·뷰티 케어와 ALLVIS', '88LION 공식 홈페이지입니다. 두피·뷰티 케어 제품과 홈케어, ALLVIS HIFU & LDM 기기를 소개합니다. 제품 도입과 가맹·대리점 상담을 안내합니다.');
$brandPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$brandUrl = rtrim(G5_URL, '/') . (($brandPath === '/index.html') ? '/' : $brandPath);
?>
    <title><?php echo htmlspecialchars($brandPage[0], ENT_QUOTES, 'UTF-8'); ?></title>
    <meta name="naver-site-verification" content="60cef302f92d4d6100019aea5e2766764e8afd2a" />
    <meta name="description" content="<?php echo htmlspecialchars($brandPage[1], ENT_QUOTES, 'UTF-8'); ?>">
    <meta name="keywords" content="88LION, 88라이온, 두피관리, 뷰티 케어, 홈케어, ALLVIS, 올비스, HIFU, LDM, 주식회사 위고">
    <meta name="author" content="주식회사 위고">
    <link rel="canonical" href="<?php echo htmlspecialchars($brandUrl, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="88LION">
    <meta property="og:title" content="88LION 88라이온">
    <meta property="og:url" content="<?php echo htmlspecialchars($brandUrl, ENT_QUOTES, 'UTF-8'); ?>">
    <meta property="og:image" content="<?php echo G5_URL; ?>/img/88lion/share.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="88LION · 두피·뷰티 케어와 ALLVIS">
    <meta property="og:description" content="두피·뷰티 케어부터 홈케어까지. 88LION 제품과 ALLVIS 관리 기기를 만나보세요.">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="88LION 88라이온">
    <meta name="twitter:description" content="두피·뷰티 케어부터 홈케어까지. 88LION 제품과 ALLVIS 관리 기기를 만나보세요.">
    <meta name="twitter:image" content="<?php echo G5_URL; ?>/img/88lion/share.png">
    <link rel="icon" type="image/svg+xml" href="<?php echo G5_URL; ?>/img/88lion/favicon.svg">
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
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
        <header id="header">
		<div class="head">
			<h1><a class="brand-wordmark" href="/" aria-label="88LION 88라이온 홈"><img class="brand-logo brand-logo-primary" src="<?php echo G5_URL; ?>/img/88lion/logo.svg" alt="88LION 88라이온" width="150" height="45"><img class="brand-logo brand-logo-inverse" src="<?php echo G5_URL; ?>/img/88lion/logo-white.svg" alt="" aria-hidden="true" width="150" height="45"></a></h1>
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
							<li><a href="<?php echo G5_URL;?>/pages/m21.html">88LION</a></li>
							<li><a href="<?php echo G5_URL;?>/pages/m22.html">ALLVIS</a></li>
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
					<div class="brand-menu-logo"><a href="/" aria-label="88LION 홈"><img src="<?php echo G5_URL; ?>/img/88lion/logo.svg" alt="88LION 88라이온" width="240" height="72"></a></div>
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
                                <li><a href="<?php echo G5_URL;?>/pages/m21.html">88LION</a></li>
                                <li><a href="<?php echo G5_URL;?>/pages/m22.html">ALLVIS</a></li>
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