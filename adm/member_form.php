<?php
$sub_menu = "100100";
require_once './_common.php';

auth_check_menu($auth, $sub_menu, 'w');

$mb = array(
    'mb_certify' => null,
    'mb_adult' => null,
    'mb_sms' => null,
    'mb_intercept_date' => null,
    'mb_id' => null,
    'mb_name' => null,
    'mb_nick' => null,
    'mb_point' => null,
    'mb_email' => null,
    'mb_homepage' => null,
    'mb_hp' => null,
    'mb_tel' => null,
    'mb_zip1' => null,
    'mb_zip2' => null,
    'mb_addr1' => null,
    'mb_addr2' => null,
    'mb_addr3' => null,
    'mb_addr_jibeon' => null,
    'mb_signature' => null,
    'mb_profile' => null,
    'mb_memo' => null,
    'mb_leave_date' => null,
    'mb_1' => null,
    'mb_2' => null,
    'mb_3' => null,
    'mb_4' => null,
    'mb_5' => null,
    'mb_6' => null,
    'mb_7' => null,
    'mb_8' => null,
    'mb_9' => null,
    'mb_10' => null,
);

$sound_only = '';
$required_mb_id = '';
$required_mb_id_class = '';
$required_mb_password = '';
$html_title = '';

if ($w == '') {
    $required_mb_id = 'required';
    $required_mb_id_class = 'required alnum_';
    $required_mb_password = 'required';
    $sound_only = '<strong class="sound_only">필수</strong>';

    $mb['mb_mailling'] = 1;
    $mb['mb_open'] = 1;
    $mb['mb_level'] = 5;
    $html_title = '추가';
} elseif ($w == 'u') {
    $mb = get_member($mb_id);
    if (!$mb['mb_id']) {
        alert('존재하지 않는 회원자료입니다.');
    }

    if ($is_admin != 'super' && $mb['mb_level'] > $member['mb_level']) {
        alert('자신보다 권한이 높은 회원은 수정할 수 없습니다.');
    }

    $required_mb_id = 'readonly';
    $html_title = '수정';

    $mb['mb_name'] = get_text($mb['mb_name']);
    $mb['mb_nick'] = get_text($mb['mb_nick']);
    $mb['mb_email'] = get_text($mb['mb_email']);
    $mb['mb_homepage'] = get_text($mb['mb_homepage']);
    $mb['mb_birth'] = get_text($mb['mb_birth']);
    $mb['mb_tel'] = get_text($mb['mb_tel']);
    $mb['mb_hp'] = get_text($mb['mb_hp']);
    $mb['mb_addr1'] = get_text($mb['mb_addr1']);
    $mb['mb_addr2'] = get_text($mb['mb_addr2']);
    $mb['mb_addr3'] = get_text($mb['mb_addr3']);
    $mb['mb_signature'] = get_text($mb['mb_signature']);
    $mb['mb_recommend'] = get_text($mb['mb_recommend']);
    $mb['mb_profile'] = get_text($mb['mb_profile']);
    $mb['mb_1'] = get_text($mb['mb_1']);
    $mb['mb_2'] = get_text($mb['mb_2']);
    $mb['mb_3'] = get_text($mb['mb_3']);
    $mb['mb_4'] = get_text($mb['mb_4']);
    $mb['mb_5'] = get_text($mb['mb_5']);
    $mb['mb_6'] = get_text($mb['mb_6']);
    $mb['mb_7'] = get_text($mb['mb_7']);
    $mb['mb_8'] = get_text($mb['mb_8']);
    $mb['mb_9'] = get_text($mb['mb_9']);
    $mb['mb_10'] = get_text($mb['mb_10']);
} else {
    alert('제대로 된 값이 넘어오지 않았습니다.');
}

// 본인확인방법
switch ($mb['mb_certify']) {
    case 'simple':
        $mb_certify_case = '간편인증';
        $mb_certify_val = 'simple';
        break;
    case 'hp':
        $mb_certify_case = '휴대폰';
        $mb_certify_val = 'hp';
        break;
    case 'ipin':
        $mb_certify_case = '아이핀';
        $mb_certify_val = 'ipin';
        break;
    case 'admin':
        $mb_certify_case = '관리자 수정';
        $mb_certify_val = 'admin';
        break;
    default:
        $mb_certify_case = '';
        $mb_certify_val = 'admin';
        break;
}

// 본인확인
$mb_certify_yes  =  $mb['mb_certify'] ? 'checked="checked"' : '';
$mb_certify_no   = !$mb['mb_certify'] ? 'checked="checked"' : '';

// 성인인증
$mb_adult_yes       =  $mb['mb_adult']      ? 'checked="checked"' : '';
$mb_adult_no        = !$mb['mb_adult']      ? 'checked="checked"' : '';

//메일수신
$mb_mailling_yes    =  $mb['mb_mailling']   ? 'checked="checked"' : '';
$mb_mailling_no     = !$mb['mb_mailling']   ? 'checked="checked"' : '';

// SMS 수신
$mb_sms_yes         =  $mb['mb_sms']        ? 'checked="checked"' : '';
$mb_sms_no          = !$mb['mb_sms']        ? 'checked="checked"' : '';

// 정보 공개
$mb_open_yes        =  $mb['mb_open']       ? 'checked="checked"' : '';
$mb_open_no         = !$mb['mb_open']       ? 'checked="checked"' : '';

if (isset($mb['mb_certify'])) {
    // 날짜시간형이라면 drop 시킴
    if (preg_match("/-/", $mb['mb_certify'])) {
        sql_query(" ALTER TABLE `{$g5['member_table']}` DROP `mb_certify` ", false);
    }
} else {
    sql_query(" ALTER TABLE `{$g5['member_table']}` ADD `mb_certify` TINYINT(4) NOT NULL DEFAULT '0' AFTER `mb_hp` ", false);
}

if (isset($mb['mb_adult'])) {
    sql_query(" ALTER TABLE `{$g5['member_table']}` CHANGE `mb_adult` `mb_adult` TINYINT(4) NOT NULL DEFAULT '0' ", false);
} else {
    sql_query(" ALTER TABLE `{$g5['member_table']}` ADD `mb_adult` TINYINT NOT NULL DEFAULT '0' AFTER `mb_certify` ", false);
}

// 지번주소 필드추가
if (!isset($mb['mb_addr_jibeon'])) {
    sql_query(" ALTER TABLE {$g5['member_table']} ADD `mb_addr_jibeon` varchar(255) NOT NULL DEFAULT '' AFTER `mb_addr2` ", false);
}

// 건물명필드추가
if (!isset($mb['mb_addr3'])) {
    sql_query(" ALTER TABLE {$g5['member_table']} ADD `mb_addr3` varchar(255) NOT NULL DEFAULT '' AFTER `mb_addr2` ", false);
}

// 중복가입 확인필드 추가
if (!isset($mb['mb_dupinfo'])) {
    sql_query(" ALTER TABLE {$g5['member_table']} ADD `mb_dupinfo` varchar(255) NOT NULL DEFAULT '' AFTER `mb_adult` ", false);
}

// 이메일인증 체크 필드추가
if (!isset($mb['mb_email_certify2'])) {
    sql_query(" ALTER TABLE {$g5['member_table']} ADD `mb_email_certify2` varchar(255) NOT NULL DEFAULT '' AFTER `mb_email_certify` ", false);
}

// 본인인증 내역 테이블 정보가 dbconfig에 없으면 소셜 테이블 정의
if (!isset($g5['member_cert_history'])) {
    $g5['member_cert_history_table'] = G5_TABLE_PREFIX . 'member_cert_history';
}
// 멤버 본인인증 정보 변경 내역 테이블 없을 경우 생성
if (isset($g5['member_cert_history_table']) && !sql_query(" DESC {$g5['member_cert_history_table']} ", false)) {
    sql_query(
        " CREATE TABLE IF NOT EXISTS `{$g5['member_cert_history_table']}` (
                    `ch_id` int(11) NOT NULL auto_increment,
                    `mb_id` varchar(20) NOT NULL DEFAULT '',
                    `ch_name` varchar(255) NOT NULL DEFAULT '',
                    `ch_hp` varchar(255) NOT NULL DEFAULT '',
                    `ch_birth` varchar(255) NOT NULL DEFAULT '',
                    `ch_type` varchar(20) NOT NULL DEFAULT '',
                    `ch_datetime` datetime NOT NULL default '0000-00-00 00:00:00',
                    PRIMARY KEY (`ch_id`),
                    KEY `mb_id` (`mb_id`)
                ) ",
        true
    );
}

$mb_cert_history = '';
if (isset($mb_id) && $mb_id) {
    $sql = "select * from {$g5['member_cert_history_table']} where mb_id = '{$mb_id}' order by ch_id asc";
    $mb_cert_history = sql_query($sql);
}

if ($mb['mb_intercept_date']) {
    $g5['title'] = "차단된 ";
} else {
    $g5['title'] .= "";
}
$g5['title'] .= '회원 ' . $html_title;
require_once './admin.head.php';

// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js
?>

<form name="fmember" id="fmember" action="./member_form_update.php" onsubmit="return fmember_submit(this);" method="post" enctype="multipart/form-data">
    <input type="hidden" name="w" value="<?php echo $w ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="token" value="">

    <div class="tbl_frm01 tbl_wrap">
        <table>
            <caption><?php echo $g5['title']; ?></caption>
            <colgroup>
                <col class="grid_4">
                <col>
                <col class="grid_4">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <th scope="row"><label for="mb_id">아이디<?php echo $sound_only ?></label></th>
                    <td>
                        <input type="text" name="mb_id" value="<?php echo $mb['mb_id'] ?>" id="mb_id" <?php echo $required_mb_id ?> class="frm_input <?php echo $required_mb_id_class ?>" size="15" maxlength="20">
                    </td>
                    <th scope="row"><label for="mb_password">비밀번호<?php echo $sound_only ?></label></th>
                    <td>
						<input type="password" name="mb_password" id="mb_password" <?php echo $required_mb_password ?> class="frm_input <?php echo $required_mb_password ?>" size="15" maxlength="20" autocomplete="new-password">
					</td>
                </tr>
                <tr>
                    <th scope="row"><label for="mb_name">이름<strong class="sound_only">필수</strong></label></th>
                    <td><input type="text" name="mb_name" value="<?php echo $mb['mb_name'] ?>" id="mb_name" required class="required frm_input" size="15" maxlength="20"></td>
					<th scope="row"><label for="mb_email">E-mail</label></th>
                    <td><input type="text" name="mb_email" value="<?php echo $mb['mb_email'] ?>" id="mb_email" maxlength="100" class="frm_input email" size="30"></td>
					<input type="hidden" name="mb_homepage" value="<?php echo $mb['mb_homepage'] ?>" id="mb_homepage">
					<input type="hidden" name="mb_tel" value="<?php echo $mb['mb_tel'] ?>" id="mb_tel">
                </tr>
					<input type="hidden" name="mb_level" value="<?php if($mb['mb_level']) echo $mb['mb_level']; else echo "2"; ?>">

                <tr>
                    <th scope="row"><label for="mb_hp">휴대폰번호</label></th>
                    <td><input type="text" name="mb_hp" value="<?php echo $mb['mb_hp'] ?>" id="mb_hp" class="frm_input" size="15" maxlength="20"></td>
					<th scope="row">추천인</th>
					<td>
						<input type="text" name="mb_recommend" value="<?php echo $mb['mb_recommend'] ?>" id="mb_recommend" class="frm_input">
						<?php
						if($mb['mb_recommend']){
							//echo " ".get_member_name($mb['mb_recommend']);
						?>
							&nbsp; 
							<input type='button' class='btn btn_01' onclick='f_rec_change()' value='추천인변경하기' style='cursor:pointer;'>
							<div style="color:#ff3300"># 추천인 변경시 자동완성된 아이디를 선택하셔야 정확합니다.</div>
						<?php
						}
						?>
					</td>
                </tr>
				<tr>
                    <th scope="row"><label for="mb_grade">등급</label></th>
                    <td>
						<select name="mb_grade">
							<option value="">등급을 선택해주세요.</option>
							<option value="d" <?php if($mb['mb_grade'] == "d") echo "selected";?>>일반</option>
							<option value="c" <?php if($mb['mb_grade'] == "c") echo "selected";?>>영업</option>
							<option value="b" <?php if($mb['mb_grade'] == "b") echo "selected";?>>대리점</option>
							<option value="a" <?php if($mb['mb_grade'] == "a") echo "selected";?>>총판</option>
						</select>
					</td>
					<th scope="row">총판 / 대리점 / 영업</th>
					<td><?php echo $mb['mb_chong']." / ".$mb['mb_branch']." / ".$mb['mb_sales']; ?></td>
                </tr>
				<tr>
                    <th scope="row"><label for="co_kind">회원구분</label></th>
                    <td>
						<select name="co_kind">
							<option value="a" <?php if($mb['co_kind'] == "a") echo "selected";?>>일반</option>
							<option value="b" <?php if($mb['co_kind'] == "b") echo "selected";?>>병원</option>
							<option value="c" <?php if($mb['co_kind'] == "c") echo "selected";?>>벤더</option>
						</select>
					</td>
					<th scope="row"></th>
					<td></td>
                </tr>
				
				<tr>
                    <th scope="row"><label for="company_name">병원 및 상호명</label></th>
                    <td><input type="text" name="company_name" value="<?php echo $mb['company_name'] ?>" id="company_name" class="frm_input" size="60"></td>
					<th scope="row"><label for="company_no">사업자등록번호</label></th>
                    <td><input type="text" name="company_no" value="<?php echo $mb['company_no'] ?>" id="company_no" class="frm_input" maxlength=20></td>
                </tr>
				<tr>
                    <th scope="row"><label for="company_ceo">대표자명</label></th>
                    <td><input type="text" name="company_ceo" value="<?php echo $mb['company_ceo'] ?>" id="company_ceo" class="frm_input"></td>
					<th scope="row"><label for="company_tel">병원연락처</label></th>
                    <td><input type="text" name="company_tel" value="<?php echo $mb['company_tel'] ?>" id="company_tel" class="frm_input" maxlength=20></td>
                </tr>
				<tr>
                    <th scope="row"><label for="company_address">병원주소</label></th>
                    <td><input type="text" name="company_address" value="<?php echo $mb['company_address'] ?>" id="company_address" class="frm_input" size="60"></td>
					<th scope="row"><label for="company_dept">담당자직책</label></th>
                    <td><input type="text" name="company_dept" value="<?php echo $mb['company_dept'] ?>" id="company_dept" class="frm_input"></td>
                </tr>

                <tr style="display:none">
                    <th scope="row">본인확인방법</th>
                    <td colspan="3">
                        <input type="radio" name="mb_certify_case" value="simple" id="mb_certify_sa" <?php if ($mb['mb_certify'] == 'simple') { echo 'checked="checked"'; } ?>>
                        <label for="mb_certify_sa">간편인증</label>
                        <input type="radio" name="mb_certify_case" value="hp" id="mb_certify_hp" <?php if ($mb['mb_certify'] == 'hp') { echo 'checked="checked"'; } ?>>
                        <label for="mb_certify_hp">휴대폰</label>
                        <input type="radio" name="mb_certify_case" value="ipin" id="mb_certify_ipin" <?php if ($mb['mb_certify'] == 'ipin') { echo 'checked="checked"'; } ?>>
                        <label for="mb_certify_ipin">아이핀</label>
                    </td>
                </tr>
                <tr style="display:none">
                    <th scope="row">본인확인</th>
                    <td>
                        <input type="radio" name="mb_certify" value="1" id="mb_certify_yes" <?php echo $mb_certify_yes; ?>>
                        <label for="mb_certify_yes">예</label>
                        <input type="radio" name="mb_certify" value="0" id="mb_certify_no" <?php echo $mb_certify_no; ?>>
                        <label for="mb_certify_no">아니오</label>
                    </td>
                    <th scope="row">성인인증</th>
                    <td>
                        <input type="radio" name="mb_adult" value="1" id="mb_adult_yes" <?php echo $mb_adult_yes; ?>>
                        <label for="mb_adult_yes">예</label>
                        <input type="radio" name="mb_adult" value="0" id="mb_adult_no" <?php echo $mb_adult_no; ?>>
                        <label for="mb_adult_no">아니오</label>
                    </td>
                </tr>
                <tr>
                    <th scope="row">주소</th>
                    <td colspan="3" class="td_addr_line">
                        <label for="mb_zip" class="sound_only">우편번호</label>
                        <input type="text" name="mb_zip" value="<?php echo $mb['mb_zip1']; ?>" id="mb_zip" class="frm_input readonly" size="5" maxlength="6">
                        <button type="button" class="btn_frmline" onclick="win_zip('fmember', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button><br>
                        <input type="text" name="mb_addr1" value="<?php echo $mb['mb_addr1'] ?>" id="mb_addr1" class="frm_input readonly" size="60">
                        <label for="mb_addr1">기본주소</label><br>
                        <input type="text" name="mb_addr2" value="<?php echo $mb['mb_addr2'] ?>" id="mb_addr2" class="frm_input" size="60">
                        <label for="mb_addr2">상세주소</label>
                        <br>
                        <input type="text" name="mb_addr3" value="<?php echo $mb['mb_addr3'] ?>" id="mb_addr3" class="frm_input" size="60">
                        <label for="mb_addr3">참고항목</label>
                        <input type="hidden" name="mb_addr_jibeon" value="<?php echo $mb['mb_addr_jibeon']; ?>"><br>
                    </td>
                </tr>
                <tr style="display:none">
                    <th scope="row"><label for="mb_icon">회원아이콘</label></th>
                    <td colspan="3">
                        <?php echo help('이미지 크기는 <strong>넓이 ' . $config['cf_member_icon_width'] . '픽셀 높이 ' . $config['cf_member_icon_height'] . '픽셀</strong>로 해주세요.') ?>
                        <input type="file" name="mb_icon" id="mb_icon">
                        <?php
                        $mb_dir = substr($mb['mb_id'], 0, 2);
                        $icon_file = G5_DATA_PATH . '/member/' . $mb_dir . '/' . get_mb_icon_name($mb['mb_id']) . '.gif';
                        if (file_exists($icon_file)) {
                            $icon_url = str_replace(G5_DATA_PATH, G5_DATA_URL, $icon_file);
                            $icon_filemtile = (defined('G5_USE_MEMBER_IMAGE_FILETIME') && G5_USE_MEMBER_IMAGE_FILETIME) ? '?' . filemtime($icon_file) : '';
                            echo '<img src="' . $icon_url . $icon_filemtile . '" alt="">';
                            echo '<input type="checkbox" id="del_mb_icon" name="del_mb_icon" value="1">삭제';
                        }
                        ?>
                    </td>
                </tr>
                <tr style="display:none">
                    <th scope="row"><label for="mb_img">회원이미지</label></th>
                    <td colspan="3">
                        <?php echo help('이미지 크기는 <strong>넓이 ' . $config['cf_member_img_width'] . '픽셀 높이 ' . $config['cf_member_img_height'] . '픽셀</strong>로 해주세요.') ?>
                        <input type="file" name="mb_img" id="mb_img">
                        <?php
                        $mb_dir = substr($mb['mb_id'], 0, 2);
                        $icon_file = G5_DATA_PATH . '/member_image/' . $mb_dir . '/' . get_mb_icon_name($mb['mb_id']) . '.gif';
                        if (file_exists($icon_file)) {
                            echo get_member_profile_img($mb['mb_id']);
                            echo '<input type="checkbox" id="del_mb_img" name="del_mb_img" value="1">삭제';
                        }
                        ?>
                    </td>
                </tr>
                <tr style="display:none">
                    <th scope="row">메일 수신</th>
                    <td>
                        <input type="radio" name="mb_mailling" value="1" id="mb_mailling_yes" <?php echo $mb_mailling_yes; ?>>
                        <label for="mb_mailling_yes">예</label>
                        <input type="radio" name="mb_mailling" value="0" id="mb_mailling_no" <?php echo $mb_mailling_no; ?>>
                        <label for="mb_mailling_no">아니오</label>
                    </td>
                    <th scope="row"><label for="mb_sms_yes">SMS 수신</label></th>
                    <td>
                        <input type="radio" name="mb_sms" value="1" id="mb_sms_yes" <?php echo $mb_sms_yes; ?>>
                        <label for="mb_sms_yes">예</label>
                        <input type="radio" name="mb_sms" value="0" id="mb_sms_no" <?php echo $mb_sms_no; ?>>
                        <label for="mb_sms_no">아니오</label>
                    </td>
                </tr>
                <tr style="display:none">
                    <th scope="row">정보 공개</th>
                    <td colspan="3">
                        <input type="radio" name="mb_open" value="1" id="mb_open_yes" <?php echo $mb_open_yes; ?>>
                        <label for="mb_open_yes">예</label>
                        <input type="radio" name="mb_open" value="0" id="mb_open_no" <?php echo $mb_open_no; ?>>
                        <label for="mb_open_no">아니오</label>
                    </td>
                </tr>
                <tr style="display:none">
                    <th scope="row"><label for="mb_signature">서명</label></th>
                    <td colspan="3"><textarea name="mb_signature" id="mb_signature"><?php echo html_purifier($mb['mb_signature']); ?></textarea></td>
                </tr>
                <tr style="display:none">
                    <th scope="row"><label for="mb_profile">자기 소개</label></th>
                    <td colspan="3"><textarea name="mb_profile" id="mb_profile"><?php echo html_purifier($mb['mb_profile']); ?></textarea></td>
                </tr>
                <tr>
                    <th scope="row"><label for="mb_memo">메모</label></th>
                    <td colspan="3"><textarea name="mb_memo" id="mb_memo"><?php echo html_purifier($mb['mb_memo']); ?></textarea></td>
                </tr>
                <tr style="display:none">
                    <th scope="row"><label for="mb_cert_history">본인인증 내역</label></th>
                    <td colspan="3">
                        <?php
                        $cnt = 0;
                        while ($row = sql_fetch_array($mb_cert_history)) {
                            $cnt++;
                            $cert_type = '';
                            switch ($row['ch_type']) {
                                case 'simple':
                                    $cert_type = '간편인증';
                                    break;
                                case 'hp':
                                    $cert_type = '휴대폰';
                                    break;
                                case 'ipin':
                                    $cert_type = '아이핀';
                                    break;
                            }
                        ?>
                            <div>
                                [<?php echo $row['ch_datetime']; ?>]
                                <?php echo $row['mb_id']; ?> /
                                <?php echo $row['ch_name']; ?> /
                                <?php echo $row['ch_hp']; ?> /
                                <?php echo $cert_type; ?>
                            </div>
                        <?php } ?>

                        <?php if ($cnt == 0) { ?>
                            본인인증 내역이 없습니다.
                        <?php } ?>
                    </td>
                </tr>

                <?php if ($w == 'u') { ?>
                    <tr>
                        <th scope="row">회원가입일</th>
                        <td><?php echo $mb['mb_datetime'] ?></td>
                        <th scope="row">최근접속일</th>
                        <td><?php echo $mb['mb_today_login'] ?></td>
                    </tr>
                    <tr style="display:none">
                        <th scope="row">IP</th>
                        <td colspan="3"><?php echo $mb['mb_ip'] ?></td>
                    </tr>
                    <?php if ($config['cf_use_email_certify']) { ?>
                        <tr>
                            <th scope="row">인증일시</th>
                            <td colspan="3">
                                <?php if ($mb['mb_email_certify'] == '0000-00-00 00:00:00') { ?>
                                    <?php echo help('회원님이 메일을 수신할 수 없는 경우 등에 직접 인증처리를 하실 수 있습니다.') ?>
                                    <input type="checkbox" name="passive_certify" id="passive_certify">
                                    <label for="passive_certify">수동인증</label>
                                <?php } else { ?>
                                    <?php echo $mb['mb_email_certify'] ?>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>


                <tr style="display:none">
                    <th scope="row"><label for="mb_leave_date">탈퇴일자</label></th>
                    <td>
                        <input type="text" name="mb_leave_date" value="<?php echo $mb['mb_leave_date'] ?>" id="mb_leave_date" class="frm_input" maxlength="8">
                        <input type="checkbox" value="<?php echo date("Ymd"); ?>" id="mb_leave_date_set_today" onclick="if (this.form.mb_leave_date.value==this.form.mb_leave_date.defaultValue) { this.form.mb_leave_date.value=this.value; } else { this.form.mb_leave_date.value=this.form.mb_leave_date.defaultValue; }">
                        <label for="mb_leave_date_set_today">탈퇴일을 오늘로 지정</label>
                    </td>
                    <th scope="row">접근차단일자</th>
                    <td>
                        <input type="text" name="mb_intercept_date" value="<?php echo $mb['mb_intercept_date'] ?>" id="mb_intercept_date" class="frm_input" maxlength="8">
                        <input type="checkbox" value="<?php echo date("Ymd"); ?>" id="mb_intercept_date_set_today" onclick="if (this.form.mb_intercept_date.value==this.form.mb_intercept_date.defaultValue) { this.form.mb_intercept_date.value=this.value; } else { this.form.mb_intercept_date.value=this.form.mb_intercept_date.defaultValue; }">
                        <label for="mb_intercept_date_set_today">접근차단일을 오늘로 지정</label>
                    </td>
                </tr>

                <?php
                //소셜계정이 있다면
                if (function_exists('social_login_link_account') && $mb['mb_id']) {
                    if ($my_social_accounts = social_login_link_account($mb['mb_id'], false, 'get_data')) { ?>
                        <tr>
                            <th>소셜계정목록</th>
                            <td colspan="3">
                                <ul class="social_link_box">
                                    <li class="social_login_container">
                                        <h4>연결된 소셜 계정 목록</h4>
                                        <?php foreach ($my_social_accounts as $account) {     //반복문
                                            if (empty($account)) {
                                                continue;
                                            }

                                            $provider = strtolower($account['provider']);
                                            $provider_name = social_get_provider_service_name($provider);
                                        ?>
                                            <div class="account_provider" data-mpno="social_<?php echo $account['mp_no']; ?>">
                                                <div class="sns-wrap-32 sns-wrap-over">
                                                    <span class="sns-icon sns-<?php echo $provider; ?>" title="<?php echo $provider_name; ?>">
                                                        <span class="ico"></span>
                                                        <span class="txt"><?php echo $provider_name; ?></span>
                                                    </span>

                                                    <span class="provider_name"><?php echo $provider_name;   //서비스이름 ?> ( <?php echo $account['displayname']; ?> )</span>
                                                    <span class="account_hidden" style="display:none"><?php echo $account['mb_id']; ?></span>
                                                </div>
                                                <div class="btn_info"><a href="<?php echo G5_SOCIAL_LOGIN_URL . '/unlink.php?mp_no=' . $account['mp_no'] ?>" class="social_unlink" data-provider="<?php echo $account['mp_no']; ?>">연동해제</a> <span class="sound_only"><?php echo substr($account['mp_register_day'], 2, 14); ?></span></div>
                                            </div>
                                        <?php } //end foreach ?>
                                    </li>
                                </ul>
                                <script>
                                    jQuery(function($) {
                                        $(".account_provider").on("click", ".social_unlink", function(e) {
                                            e.preventDefault();

                                            if (!confirm('정말 이 계정 연결을 삭제하시겠습니까?')) {
                                                return false;
                                            }

                                            var ajax_url = "<?php echo G5_SOCIAL_LOGIN_URL . '/unlink.php' ?>";
                                            var mb_id = '',
                                                mp_no = $(this).attr("data-provider"),
                                                $mp_el = $(this).parents(".account_provider");

                                            mb_id = $mp_el.find(".account_hidden").text();

                                            if (!mp_no) {
                                                alert('잘못된 요청! mp_no 값이 없습니다.');
                                                return;
                                            }

                                            $.ajax({
                                                url: ajax_url,
                                                type: 'POST',
                                                data: {
                                                    'mp_no': mp_no,
                                                    'mb_id': mb_id
                                                },
                                                dataType: 'json',
                                                async: false,
                                                success: function(data, textStatus) {
                                                    if (data.error) {
                                                        alert(data.error);
                                                        return false;
                                                    } else {
                                                        alert("연결이 해제 되었습니다.");
                                                        $mp_el.fadeOut("normal", function() {
                                                            $(this).remove();
                                                        });
                                                    }
                                                }
                                            });

                                            return;
                                        });
                                    });
                                </script>

                            </td>
                        </tr>

                <?php
                    }   //end if
                }   //end if

                run_event('admin_member_form_add', $mb, $w, 'table');
                ?>

                <?php for ($i = 1; $i <= 10; $i++) { ?>
                    <tr style="display:none">
                        <th scope="row"><label for="mb_<?php echo $i ?>">여분 필드 <?php echo $i ?></label></th>
                        <td colspan="3"><input type="text" name="mb_<?php echo $i ?>" value="<?php echo $mb['mb_' . $i] ?>" id="mb_<?php echo $i ?>" class="frm_input" size="30" maxlength="255"></td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>

    <div class="btn_fixed_top">
        <a href="./member_list.php?<?php echo $qstr ?>" class="btn btn_02">목록</a>
        <input type="submit" value="확인" class="btn_submit btn" accesskey='s'>
    </div>
</form>

<script>
function fmember_submit(f) {

	return true;
}

function f_rec_change(){
	var mb_rec_before = "<?php echo $mb['mb_recommend'];?>";
	var mb_id = $("#mb_id").val();
	var mb_recommend = $("#mb_recommend").val();

	if(mb_rec_before == mb_recommend){
		alert("이전과 동일한 추천인 입니다.");
		return;
	}

	if(mb_id == mb_recommend){
		alert("회원 본인을 추천인으로 할 수 없습니다.");
		return;
	}

	if(mb_recommend == ""){
		alert("추천인을 입력해주세요.");
		return;
	}

	if(confirm("추천인을 변경하시겠습니까?")){
		location.href = "./member_form_change.php?<?php echo $qstr;?>&mb_id="+mb_id+"&mb_recommend="+mb_recommend;
	}
}
</script>


<script src="<?php echo G5_JS_URL;?>/jquery-migrate-1.4.1.min.js" type="text/javascript"></script>
<script src="<?php echo G5_JS_URL;?>/jquery.autocomplete.js" type="text/javascript"></script>
<link href="<?php echo G5_CSS_URL;?>/jquery.autocomplete.css" rel="stylesheet" type="text/css">

<script>
// 자동완성 시작
var availableTags = [];

<?php
$sql_auto = "select mb_id from g5_member where mb_level < 10";
$result_auto = sql_query($sql_auto);

for($a=0;$row_auto=sql_fetch_array($result_auto);$a++){
	echo "availableTags[".$a."] = '".$row_auto['mb_id']."';";
}
?>

$(document).ready(function() {
	$("#mb_recommend").autocomplete(availableTags,{
		minChars: 3,
		max: 20,
		autoFill: false,
		selectFirst: false,
		scrollHeight: 500,
		matchContains: true
	});
});
// 자동완성 끝
</script>
<?php
run_event('admin_member_form_after', $mb, $w);

require_once './admin.tail.php';
