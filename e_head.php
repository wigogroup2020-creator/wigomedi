<?php
if($is_guest){
	goto_url(G5_URL."/page/login.php");
}

include_once(G5_PATH.'/e_head_sub.php');

if($search_mb_id){
	$mb_id = $search_mb_id;
}else{
	$mb_id = $member['mb_id'];
}
?>

<style>
.gradient_red {
	background: linear-gradient(to right, #FF1212, #8E52FB);
	border: none; /* 기본 경계선을 제거합니다 */
	color: white; /* 텍스트 색상을 흰색으로 설정합니다 */
	padding: 10px 20px; /* 패딩을 설정합니다 */
	font-size: 16px; /* 폰트 크기를 설정합니다 */
	transition: background 0.3s ease; /* 배경 전환 효과를 추가합니다 */
}
</style>

<body class="loading" data-layout-color="light" data-layout="topnav" data-layout-mode="fluid" data-rightbar-onstart="true">
    
    <!-- Begin page -->
    <div class="wrapper">

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <!-- <div class="navbar-custom topnav-navbar topnav-navbar-dark" style="background-color:#f9bc0d"> -->
				<div class="navbar-custom topnav-navbar">
                    <div class="container-fluid">

                        <!-- LOGO -->
                        <a href="<?php echo G5_URL;?>" class="topnav-logo">
                            <span class="topnav-logo-lg text-white" style="font-size:1rem;font-weight:bold">
                                <img src="<?php echo G5_IMG_URL;?>/favicon.png" alt="logo" width="50px"> <?php echo $config['cf_title'];?>
                            </span>
                            <span class="topnav-logo-sm text-white" style="font-size:0.8rem;font-weight:bold">
								<?php echo $config['cf_title'];?>
                            </span>
                        </a>

                        <ul class="list-unstyled topbar-menu mb-0">                            
                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="noti-icon dripicons-user"></i>
                                    <div style="color:#fff">
                                        <?php
                                        echo $member['mb_name'];
										
										$mb_grade = $member['mb_grade'];
                                        if($mb_grade){
											if($mb_grade != "c"){
												echo "<br/>".get_grade_name($mb_grade);
											}
                                        }
                                        ?>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="topbar-userdrop">

                                    <!-- item-->
									<?php
									$site_admin = "";

									if($is_admin){
										$site_admin = "y";
									}

									$sql_auth = "SELECT count(*) as cnt FROM g5_auth WHERE mb_id = '".$member['mb_id']."'";
									$result_auth = sql_fetch($sql_auth);
									if($result_auth['cnt'] > 1){
										$site_admin = "y";
									}

									if($site_admin == "y"){
									?>
										<a href="<?php echo G5_ADMIN_URL;?>" class="dropdown-item notify-item">
											<i class="mdi mdi-account-circle me-1"></i>
											<span>관리자페이지</span>
										</a>
									<?php 
									}
									?>
									<a href="<?php echo G5_URL;?>/page/info.php" class="dropdown-item notify-item">
										<i class="mdi mdi-account-circle me-1"></i>
										<span>개인정보</span>
									</a>

                                    <!-- item-->
                                    <a href="<?php echo G5_BBS_URL;?>/logout.php" class="dropdown-item notify-item">
                                        <i class="mdi mdi-logout me-1"></i>
                                        <span>Logout</span>
                                    </a>

                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
                <!-- end Topbar -->


				<!-- Start Content-->
				<!-- <div class="container-fluid" style="max-width:100%"> -->
				<div style="">