<!DOCTYPE html>
    <html lang="ko">

    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="UTF-8">
        <title><?php echo $config['cf_title'];?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="<?php echo $config['cf_title'];?>" name="description" />
        <meta content="<?php echo $config['cf_title'];?>" name="author" />
        <meta property="og:title" content="<?php echo $config['cf_title'];?>" />
		<meta property="og:type" content="website" />
		<meta property="og:description" content="<?php echo $config['cf_title'];?>">
		<meta property="og:url" content="" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="<?php echo G5_IMG_URL;?>/favicon.png">

        
        <!-- third party css -->
		<link href="<?php echo G5_URL;?>/page/assets/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
		<link href="<?php echo G5_URL;?>/page/assets/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />
		<!-- third party css end -->
		
        <!-- App css -->
        <link href="<?php echo G5_URL;?>/page/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo G5_URL;?>/page/assets/css/app-creative.min.css" rel="stylesheet" type="text/css" id="app-style" />
        <link href="<?php echo G5_CSS_URL;?>/common.css?ver=2" rel="stylesheet" type="text/css" />

		<script src="<?php echo G5_JS_URL;?>/jquery-1.12.4.min.js"></script>
		<script src="<?php echo G5_JS_URL;?>/jquery-migrate-1.4.1.min.js"></script>
		<script src="<?php echo G5_JS_URL;?>/common.js?ver=2"></script>
		<?php 
		//ajax 알람
		if(!$is_admin){
			include_once(G5_PLUGIN_PATH.'/alarm/alarm.php');
		}
		?>
		<script>
			var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
		</script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <meta name="naver-site-verification" content="580a165978a18aaefcf133b99973ad01e2df2f93" />
    </head>