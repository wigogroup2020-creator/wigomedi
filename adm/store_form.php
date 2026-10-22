<?php
$sub_menu = '100305';
require_once './_common.php';
require_once G5_LIB_PATH . '/store.lib.php';
auth_check_menu($auth, $sub_menu, 'w');
if (!wigo_store_ready()) alert('매장 관리 초기 설정을 먼저 진행해 주세요.', './stores.php');
wigo_store_ensure_schema();
$id = isset($_GET['store_id']) && is_scalar($_GET['store_id']) ? (int) $_GET['store_id'] : 0;
$table = wigo_store_table();
$store = $id > 0 ? sql_fetch("SELECT * FROM `$table` WHERE store_id=$id") : array('name'=>'', 'location'=>'', 'tel'=>'', 'map_url'=>'', 'photo'=>'', 'is_visible'=>0, 'sort_order'=>0);
if (!$store) alert('매장을 찾을 수 없습니다.', './stores.php');
$token = get_admin_token();
$g5['title'] = $id > 0 ? '매장 수정' : '매장 추가';
require_once './admin.head.php';
?>
<form method="post" action="./store_update.php" enctype="multipart/form-data">
    <input type="hidden" name="action" value="save"><input type="hidden" name="store_id" value="<?php echo $id; ?>"><input type="hidden" name="token" value="<?php echo $token; ?>"><input type="hidden" name="MAX_FILE_SIZE" value="5242880">
    <div class="tbl_frm01 tbl_wrap"><table><caption><?php echo $g5['title']; ?></caption><tbody>
        <tr><th scope="row"><label for="store_name">지점명 (필수)</label></th><td><input id="store_name" name="name" type="text" class="frm_input" required maxlength="100" size="45" value="<?php echo wigo_store_escape($store['name']); ?>"></td></tr>
        <tr><th scope="row"><label for="store_location">주소 (필수)</label></th><td><input id="store_location" name="location" type="text" class="frm_input" required maxlength="150" size="60" placeholder="예: 대전광역시 서구 둔산중로 19" value="<?php echo wigo_store_escape($store['location']); ?>"></td></tr>
        <tr><th scope="row"><label for="store_tel">전화번호</label></th><td><input id="store_tel" name="tel" type="text" class="frm_input" maxlength="30" size="30" placeholder="예: 042-123-4567" value="<?php echo wigo_store_escape(isset($store['tel']) ? $store['tel'] : ''); ?>"><p>입력하면 매장 카드에 전화 아이콘이 나타나고, 누르면 바로 전화가 연결됩니다. 비워 두면 아이콘이 보이지 않습니다.</p></td></tr>
        <tr><th scope="row"><label for="store_photo">매장 사진</label></th><td><input id="store_photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp"><p>JPG·PNG·WEBP 1장, 5MB 이하. 가로 사진(4:3)을 권장합니다. 사진이 없으면 단색 배경으로 표시됩니다. 수정 시 새 사진을 선택하지 않으면 기존 사진이 유지됩니다.</p><img id="store_preview" src="<?php echo wigo_store_escape(wigo_store_photo_url($store['photo'])); ?>" alt="매장 사진 미리보기" style="max-width:360px;max-height:260px;object-fit:contain;<?php echo $store['photo'] ? '' : 'display:none;'; ?>"></td></tr>
        <tr><th scope="row"><label for="store_map">네이버 지도 링크 (선택)</label></th><td><input id="store_map" name="map_url" type="url" class="frm_input" maxlength="1000" size="70" placeholder="https://naver.me/… 또는 https://map.naver.com/…" value="<?php echo wigo_store_escape($store['map_url']); ?>"><p>입력하면 카드의 주소를 눌러 네이버 지도로 이동합니다. 비워 두면 주소만 표시됩니다.</p></td></tr>
        <tr><th scope="row">공개 여부</th><td><label><input name="is_visible" type="checkbox" value="1" <?php echo $store['is_visible'] ? 'checked' : ''; ?>> 홈페이지에 공개</label><p>체크하지 않으면 관리자에서만 보입니다.</p></td></tr>
        <tr><th scope="row"><label for="store_order">노출 순서</label></th><td><input id="store_order" name="sort_order" type="number" class="frm_input" min="0" max="9999" required value="<?php echo (int) $store['sort_order']; ?>"><p>작은 숫자가 먼저 표시됩니다. 같은 숫자는 최근 등록 순서로 표시됩니다.</p></td></tr>
    </tbody></table></div>
    <div class="btn_fixed_top"><a href="./stores.php" class="btn btn_02">목록</a> <button class="btn_submit btn" type="submit">저장</button></div>
</form>
<script>
(function(){
    var input=document.getElementById('store_photo'), preview=document.getElementById('store_preview'), original=preview.getAttribute('src'), localUrl;
    input.addEventListener('change',function(){
        if(localUrl) URL.revokeObjectURL(localUrl);
        if(!input.files.length){preview.src=original;preview.style.display=original?'':'none';return;}
        if(input.files[0].size>5242880){alert('사진은 5MB 이하로 선택해 주세요.');input.value='';preview.src=original;preview.style.display=original?'':'none';return;}
        localUrl=URL.createObjectURL(input.files[0]);preview.src=localUrl;preview.style.display='block';
    });
})();
</script>
<?php require_once './admin.tail.php'; ?>
