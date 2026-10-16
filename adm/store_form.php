<?php
$sub_menu = '100305';
require_once './_common.php';
require_once G5_LIB_PATH . '/store.lib.php';
auth_check_menu($auth, $sub_menu, 'w');
if (!wigo_store_ready()) alert('매장 관리 초기 설정을 먼저 진행해 주세요.', './stores.php');
$id = isset($_GET['store_id']) && is_scalar($_GET['store_id']) ? (int) $_GET['store_id'] : 0;
$table = wigo_store_table();
$store = $id > 0 ? sql_fetch("SELECT * FROM `$table` WHERE store_id=$id") : array('name'=>'', 'location'=>'', 'map_url'=>'', 'photo'=>'', 'is_visible'=>0, 'sort_order'=>0);
if (!$store) alert('매장을 찾을 수 없습니다.', './stores.php');
$token = get_admin_token();
$g5['title'] = $id > 0 ? '매장 수정' : '매장 추가';
require_once './admin.head.php';
?>
<form method="post" action="./store_update.php" enctype="multipart/form-data">
    <input type="hidden" name="action" value="save"><input type="hidden" name="store_id" value="<?php echo $id; ?>"><input type="hidden" name="token" value="<?php echo $token; ?>"><input type="hidden" name="MAX_FILE_SIZE" value="5242880">
    <div class="tbl_frm01 tbl_wrap"><table><caption><?php echo $g5['title']; ?></caption><tbody>
        <tr><th scope="row"><label for="store_name">매장명 (필수)</label></th><td><input id="store_name" name="name" type="text" class="frm_input" required maxlength="100" size="45" value="<?php echo wigo_store_escape($store['name']); ?>"></td></tr>
        <tr><th scope="row"><label for="store_location">간단한 위치 (필수)</label></th><td><input id="store_location" name="location" type="text" class="frm_input" required maxlength="150" size="60" placeholder="예: 서울 강남구 · 신사역 인근" value="<?php echo wigo_store_escape($store['location']); ?>"><p>정확한 주소와 길찾기는 네이버 지도에서 확인하도록 안내합니다.</p></td></tr>
        <tr><th scope="row"><label for="store_photo">매장 사진<?php echo $id ? '' : ' (필수)'; ?></label></th><td><input id="store_photo" name="photo" type="file" accept="image/jpeg,image/png,image/webp" <?php echo $id ? '' : 'required'; ?>><p>JPG·PNG·WEBP 1장, 5MB 이하. 가로 사진(4:3)을 권장합니다. 수정 시 새 사진을 선택하지 않으면 기존 사진이 유지됩니다.</p><img id="store_preview" src="<?php echo wigo_store_escape(wigo_store_photo_url($store['photo'])); ?>" alt="매장 사진 미리보기" style="max-width:360px;max-height:260px;object-fit:contain;<?php echo $store['photo'] ? '' : 'display:none;'; ?>"></td></tr>
        <tr><th scope="row"><label for="store_map">네이버 지도 링크 (필수)</label></th><td><input id="store_map" name="map_url" type="url" class="frm_input" required maxlength="1000" size="70" placeholder="https://naver.me/… 또는 https://map.naver.com/…" value="<?php echo wigo_store_escape($store['map_url']); ?>"><p>네이버 지도에서 해당 매장의 공유 링크를 복사해 넣어 주세요.</p></td></tr>
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
