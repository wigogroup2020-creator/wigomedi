<?php
/* 매장안내 공개 페이지와 관리 화면에서 공통 사용: 서버 배포 필수 */
if (!defined('_GNUBOARD_')) exit;

function wigo_store_table()
{
    $table = G5_TABLE_PREFIX . 'stores';
    if (!preg_match('/^[a-zA-Z0-9_]+$/D', $table)) throw new RuntimeException('Invalid table prefix');
    return $table;
}

function wigo_store_escape($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function wigo_store_ready()
{
    $name = sql_real_escape_string(wigo_store_table());
    $row = sql_fetch("SELECT table_name FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = '$name'", false);
    return !empty($row['table_name']);
}

// 기존 테이블에 전화번호(tel) 칸이 없으면 추가합니다. (관리자 화면에서만 호출)
function wigo_store_ensure_schema()
{
    $table = wigo_store_table();
    $col = sql_fetch("SHOW COLUMNS FROM `$table` LIKE 'tel'", false);
    if (empty($col['Field'])) sql_query("ALTER TABLE `$table` ADD COLUMN tel varchar(30) NOT NULL DEFAULT '' AFTER location", false);
}

// 지역 탭 목록과, 주소 앞부분으로 지역을 판별합니다.
function wigo_store_regions()
{
    return array('서울', '경기', '강원', '광주', '대구', '대전', '부산', '세종', '울산', '인천', '제주', '충청도', '전라도', '경상도');
}

function wigo_store_region($address)
{
    $a = trim((string) $address);
    foreach (wigo_store_regions() as $r) {
        if (mb_strpos($a, mb_substr($r, 0, 2, 'UTF-8'), 0, 'UTF-8') === 0 && !in_array($r, array('충청도', '전라도', '경상도'), true)) return $r;
    }
    $map = array('충청도' => array('충남', '충북', '충청'), '전라도' => array('전남', '전북', '전라'), '경상도' => array('경남', '경북', '경상'));
    foreach ($map as $r => $keys) foreach ($keys as $k) if (mb_strpos($a, $k, 0, 'UTF-8') === 0) return $r;
    return '';
}

function wigo_store_tel_valid($tel)
{
    return is_string($tel) && ($tel === '' || preg_match('/^[0-9][0-9\-]{6,19}$/D', $tel));
}

function wigo_store_map_valid($url)
{
    if (!is_string($url) || strlen($url) > 1000 || preg_match('/[\x00-\x20]/', $url) || !filter_var($url, FILTER_VALIDATE_URL)) return false;
    $parts = parse_url($url);
    return $parts && strtolower($parts['scheme']) === 'https'
        && in_array(strtolower($parts['host']), array('map.naver.com', 'm.map.naver.com', 'place.map.naver.com', 'place.naver.com', 'm.place.naver.com', 'naver.me'), true)
        && !isset($parts['user']) && !isset($parts['pass']) && !isset($parts['port']);
}

function wigo_store_photo_valid($filename)
{
    return is_string($filename) && preg_match('/^[a-f0-9]{32}\.jpg$/D', $filename);
}

function wigo_store_photo_url($filename)
{
    return wigo_store_photo_valid($filename) ? G5_DATA_URL . '/stores/' . $filename : '';
}

function wigo_store_remove_photo($filename)
{
    if (wigo_store_photo_valid($filename)) @unlink(G5_DATA_PATH . '/stores/' . $filename);
}

function wigo_store_upload($upload)
{
    if (!isset($upload['error']) || is_array($upload['error'])) throw new RuntimeException('사진 업로드 정보가 올바르지 않습니다.');
    if ($upload['error'] === UPLOAD_ERR_NO_FILE) return '';
    if ($upload['error'] !== UPLOAD_ERR_OK) throw new RuntimeException('사진 업로드에 실패했습니다. 파일 크기와 서버 설정을 확인해 주세요.');
    if ($upload['size'] > 5 * 1024 * 1024 || !is_uploaded_file($upload['tmp_name'])) throw new RuntimeException('사진은 5MB 이하로 등록해 주세요.');
    if (!function_exists('imagecreatefromstring')) throw new RuntimeException('서버에 PHP GD 이미지 확장이 필요합니다.');
    $info = @getimagesize($upload['tmp_name']);
    if (!$info || !in_array($info[2], array(IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP), true)) throw new RuntimeException('JPG, PNG, WEBP 사진만 등록할 수 있습니다.');
    if ($info[0] > 6000 || $info[1] > 6000 || $info[0] * $info[1] > 16000000) throw new RuntimeException('사진은 가로·세로 6000px 이하, 총 1600만 화소 이하로 등록해 주세요.');
    $image = @imagecreatefromstring(file_get_contents($upload['tmp_name']));
    if (!$image) throw new RuntimeException('사진 파일을 읽을 수 없습니다.');
    $directory = G5_DATA_PATH . '/stores';
    if (!is_dir($directory) && !@mkdir($directory, G5_DIR_PERMISSION, true)) {
        imagedestroy($image);
        throw new RuntimeException('data/stores 폴더를 만들 수 없습니다. 쓰기 권한을 확인해 주세요.');
    }
    // Re-encode pixels rather than retaining arbitrary uploaded file contents.
    $filename = bin2hex(random_bytes(16)) . '.jpg';
    $scale = min(1, 1600 / max($info[0], $info[1]));
    $width = max(1, (int) round($info[0] * $scale));
    $height = max(1, (int) round($info[1] * $scale));
    $canvas = imagecreatetruecolor($width, $height);
    imagefill($canvas, 0, 0, imagecolorallocate($canvas, 255, 255, 255));
    imagecopyresampled($canvas, $image, 0, 0, 0, 0, $width, $height, $info[0], $info[1]);
    $written = imagejpeg($canvas, $directory . '/' . $filename, 88);
    imagedestroy($image);
    imagedestroy($canvas);
    if (!$written) throw new RuntimeException('사진 저장에 실패했습니다. 폴더 쓰기 권한을 확인해 주세요.');
    @chmod($directory . '/' . $filename, G5_FILE_PERMISSION);
    if (!file_exists($directory . '/index.html')) file_put_contents($directory . '/index.html', '');
    return $filename;
}
