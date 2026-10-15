<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>위고메디 - 뉴벡스, 올비스, 리바이브셀</title>
    <meta name="naver-site-verification" content="60cef302f92d4d6100019aea5e2766764e8afd2a" />
    <meta name="description" content="의료ㆍ미용 장비와 플랫폼 비즈니스, 뉴벡스(무통주사), 올비스(HIFU+LDM), 리바이브셀(셀프뷰티샵 프랜차이즈), 총판문의, 가맹문의"/>
    <meta name="keywords" content="위고메디, wigomedi, 뉴벡스, newbex, 주사기, 주사, 바늘, 올비스, allvis, hifu, 하이프 장비, LDM, 초음파 장비, 물방울 리프팅, 피부미용, 피부, 피부미용기기, 피부미용 시술, 피부 리프팅, 탄력 개선, 주름 개선, 콜라겐 생성, 고강도 집속초음파, 하이푸, 바늘없는 주사기, 무바늘 주사기, 무통 주사기, 마이크로니들, 중공형 마이크로니들, 바늘 공포증 해결, 바늘없는 인슐린 주사, 정밀 약물 주입, 피부과 주사기, 미용 시술 주사기, 당뇨 자가주사, 예방접종 솔루션, 어린이 주사기, 고령자 주사기, 감염 방지 의료기기, 의료기기 플랫폼,무통 의료기기, 병원 전용 주사기, 백신 주사기, 필러 주사 대체, 의료기기 총판, 의료기기 수출, 글로벌 의료기기, B2B 의료기기, Newbex250, Newbex850"/>
    <meta name="author" content="위고메디 - 기술과 상생을 연결하다">
    <meta property="og:title" content="위고메디 - 뉴벡스, 올비스, 리바이브셀" />
    <meta property="og:url" content="<?php echo G5_URL;?>" />
    <meta property="og:image" content="<?php echo G5_URL;?>/img/common/og_image.png" /> 
    <meta property="og:description" content="의료ㆍ미용 장비와 플랫폼 비즈니스" />
    <link rel="icon" type="image/png" sizes="16x16"  href="<?php echo G5_URL;?>/img/favicon-16x16.png">
    <!-- css -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
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
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
        <header id="header">
		<div class="head">
			<h1><a href="/">wigomedi</a></h1>
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
							<li><a href="<?php echo G5_URL;?>/pages/m21.html">Newbex</a></li>
							<li><a href="<?php echo G5_URL;?>/pages/m22.html">HIFU+LDM</a></li>
							<li><a href="<?php echo G5_URL;?>/pages/m23.html">ReviveCell</a></li>
						</ul>
					</li>
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
						<div class="login_btn"><i class="ri-user-line"></i></div>
						<span><?php echo $member['mb_name'];?></span>
					</a>
				<?php 
				}else{
				?>
					<a href="<?php echo G5_URL;?>/pages/login.html" style="display: flex; flex-direction: column; align-items: center; margin-right: 8px;">
						<div class="login_btn"><i class="ri-user-line"></i></div>
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
				<div class="btnMenu">
					<div></div>
					<div></div>
					<div></div>
				</div>
			</div>
		</div>
		<div class="allmenuBg"></div>
		<div class="allmenu">
			<div class="allmenuwrap">
				<div>
					<div class="wigomedi">
						wigo<br>
						medi
					</div>
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
                                <li><a href="<?php echo G5_URL;?>/pages/m21.html">Newbex</a></li>
                                <li><a href="<?php echo G5_URL;?>/pages/m22.html">HIFU+LDM</a></li>
                                <li><a href="<?php echo G5_URL;?>/pages/m23.html">ReviveCell</a></li>
                            </ul>
                        </li>
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