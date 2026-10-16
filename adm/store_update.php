<?php
$sub_menu = '100305';
require_once './_common.php';
require_once G5_LIB_PATH . '/store.lib.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('POST 요청만 가능합니다.'); }
$action = isset($_POST['action']) && is_string($_POST['action']) ? $_POST['action'] : '';
if (!in_array($action, array('install', 'save', 'delete'), true)) { http_response_code(400); exit('올바르지 않은 작업입니다.'); }
auth_check_menu($auth, $sub_menu, $action === 'delete' ? 'd' : 'w');
check_admin_token();
$table = wigo_store_table();
if ($action === 'install') {
    if ($is_admin !== 'super') { http_response_code(403); exit('최고관리자만 초기 설정할 수 있습니다.'); }
    $sql = "CREATE TABLE IF NOT EXISTS `$table` (
        store_id int unsigned NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        location varchar(150) NOT NULL,
        photo varchar(64) NOT NULL,
        map_url varchar(1000) NOT NULL,
        is_visible tinyint unsigned NOT NULL DEFAULT 0,
        sort_order int unsigned NOT NULL DEFAULT 0,
        created_at datetime NOT NULL,
        updated_at datetime NOT NULL,
        PRIMARY KEY (store_id), KEY public_order (is_visible, sort_order, store_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    if (!sql_query($sql, false)) alert('매장 테이블을 만들 수 없습니다. DB의 CREATE 권한을 확인해 주세요.');
    goto_url('./stores.php');
}
if (!wigo_store_ready()) alert('최고관리자가 먼저 매장 관리 초기 설정을 진행해 주세요.', './stores.php');
$id = isset($_POST['store_id']) && is_scalar($_POST['store_id']) ? (int) $_POST['store_id'] : 0;
$existing = $id > 0 ? sql_fetch("SELECT * FROM `$table` WHERE store_id = $id") : array();
if ($id > 0 && !$existing) alert('매장을 찾을 수 없습니다.', './stores.php');
if ($action === 'delete') {
    if ($id <= 0) alert('삭제할 매장을 선택해 주세요.');
    if (!sql_query("DELETE FROM `$table` WHERE store_id = $id", false)) alert('삭제에 실패했습니다. 다시 시도해 주세요.');
    wigo_store_remove_photo($existing['photo']);
    goto_url('./stores.php');
}
$input = array();
foreach (array('name' => 100, 'location' => 150, 'map_url' => 1000) as $field => $limit) {
    // common.php already escapes request strings; validate the original text before SQL escaping.
    $input[$field] = isset($_POST[$field]) && is_string($_POST[$field]) ? trim(stripslashes($_POST[$field])) : '';
    if ($input[$field] === '' || mb_strlen($input[$field], 'UTF-8') > $limit || preg_match('/[\x00-\x1f]/', $input[$field])) alert('매장명, 간단한 위치, 지도 링크를 길이에 맞게 입력해 주세요.');
}
if (!wigo_store_map_valid($input['map_url'])) alert('실제 네이버 지도 HTTPS 링크를 입력해 주세요. map.naver.com 또는 naver.me 링크를 사용할 수 있습니다.');
$sort = isset($_POST['sort_order']) && is_string($_POST['sort_order']) ? $_POST['sort_order'] : '';
if (!preg_match('/^[0-9]{1,4}$/D', $sort)) alert('노출 순서는 0부터 9999 사이의 숫자로 입력해 주세요.');
$sort = (int) $sort;
$visible = isset($_POST['is_visible']) && $_POST['is_visible'] === '1' ? 1 : 0;
$new_photo = '';
try {
    $new_photo = wigo_store_upload(isset($_FILES['photo']) ? $_FILES['photo'] : array('error' => UPLOAD_ERR_NO_FILE));
} catch (RuntimeException $error) { alert($error->getMessage()); }
$photo = $new_photo !== '' ? $new_photo : (isset($existing['photo']) ? $existing['photo'] : '');
if (!wigo_store_photo_valid($photo)) alert('매장 사진을 등록해 주세요.');
$name = sql_real_escape_string($input['name']);
$location = sql_real_escape_string($input['location']);
$map = sql_real_escape_string($input['map_url']);
$now = sql_real_escape_string(G5_TIME_YMDHIS);
$values = "name='$name', location='$location', map_url='$map', photo='$photo', sort_order=$sort, is_visible=$visible, updated_at='$now'";
$sql = $id > 0 ? "UPDATE `$table` SET $values WHERE store_id=$id" : "INSERT INTO `$table` SET $values, created_at='$now'";
if (!sql_query($sql, false)) {
    wigo_store_remove_photo($new_photo);
    alert('매장 저장에 실패했습니다. 다시 시도해 주세요.');
}
if ($new_photo && !empty($existing['photo'])) wigo_store_remove_photo($existing['photo']);
goto_url('./stores.php');
