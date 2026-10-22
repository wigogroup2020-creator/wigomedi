<?php
$sub_menu = '100305';
require_once './_common.php';
require_once G5_LIB_PATH . '/store.lib.php';
auth_check_menu($auth, $sub_menu, 'r');
$ready = wigo_store_ready();
if ($ready) wigo_store_ensure_schema();
$table = wigo_store_table();
$stores = array();
if ($ready) {
    $result = sql_query("SELECT * FROM `$table` ORDER BY sort_order ASC, store_id DESC");
    while ($row = sql_fetch_array($result)) $stores[] = $row;
}
$token = get_admin_token();
$g5['title'] = '매장안내 관리';
require_once './admin.head.php';
?>
<div class="local_desc01 local_desc"><p>일반 고객이 방문해 제품을 구매하거나 관리를 받을 수 있는 매장을 등록해 주세요. 공개한 매장은 STORES 페이지에 사진 카드(사진 · 지점명 · 주소 · 전화 아이콘)로 표시됩니다. 사진이 없으면 단색 배경으로 보입니다. 숫자가 작은 순서부터 노출됩니다. 목록에서 공개/숨김과 순서를 바꾸고 '선택수정'을 누르면 한꺼번에 저장됩니다. 지역은 주소 앞부분(시·도)으로 자동 분류되며, 미분류로 보이면 주소를 '서울특별시 …'처럼 시·도부터 고쳐 주세요.</p></div>
<?php if (!$ready) { ?>
<div class="local_desc01 local_desc"><p>최초 1회 매장 관리용 테이블을 생성해야 합니다. 기존 회원·제품·문의 데이터는 변경하지 않습니다.</p>
<?php if ($is_admin === 'super') { ?><form method="post" action="./store_update.php"><input type="hidden" name="token" value="<?php echo $token; ?>"><input type="hidden" name="action" value="install"><button class="btn btn_01" type="submit">매장 관리 초기 설정</button></form><?php } else { ?><p>최고관리자에게 초기 설정을 요청해 주세요.</p><?php } ?></div>
<?php } else { ?>
<form name="fstores" id="fstores" method="post" action="./store_update.php" onsubmit="return fstores_submit(this);">
<input type="hidden" name="token" value="<?php echo $token; ?>">
<div class="tbl_head01 tbl_wrap"><table><caption>매장 목록</caption><thead><tr>
<th scope="col"><label for="chkall" class="sound_only">전체</label><input type="checkbox" id="chkall" onclick="var c=document.querySelectorAll('.store_chk');for(var i=0;i<c.length;i++)c[i].checked=this.checked;"></th>
<th scope="col">사진</th><th scope="col">지점명</th><th scope="col">주소</th><th scope="col">지역</th><th scope="col">전화</th><th scope="col">공개</th><th scope="col">순서</th><th scope="col">수정</th></tr></thead><tbody>
<?php foreach ($stores as $i => $store) { ?>
<tr class="bg<?php echo $i % 2; ?>">
<td class="td_chk"><input type="hidden" name="store_id[<?php echo $i; ?>]" value="<?php echo (int) $store['store_id']; ?>"><input type="checkbox" class="store_chk" name="chk[]" value="<?php echo $i; ?>" aria-label="<?php echo wigo_store_escape($store['name']); ?> 선택"></td>
<td><?php if (wigo_store_photo_valid($store['photo'])) { ?><img src="<?php echo wigo_store_escape(wigo_store_photo_url($store['photo'])); ?>" alt="<?php echo wigo_store_escape($store['name']); ?>" width="100" height="75" style="object-fit:cover"><?php } else { ?><span style="display:block;width:100px;height:75px;background:#dfe9e3"></span><?php } ?></td>
<td style="text-align:left"><?php echo wigo_store_escape($store['name']); ?></td>
<td style="text-align:left"><?php echo wigo_store_escape($store['location']); ?></td>
<td><?php $rg = wigo_store_region($store['location']); echo $rg !== '' ? wigo_store_escape($rg) : '<span style="color:#c0392b">미분류</span>'; ?></td>
<td><?php echo wigo_store_escape(isset($store['tel']) ? $store['tel'] : ''); ?></td>
<td><input type="radio" name="is_visible[<?php echo $i; ?>]" id="vis_y_<?php echo $i; ?>" value="1" <?php echo $store['is_visible'] ? 'checked' : ''; ?>> <label for="vis_y_<?php echo $i; ?>">공개</label> &nbsp; <input type="radio" name="is_visible[<?php echo $i; ?>]" id="vis_n_<?php echo $i; ?>" value="0" <?php echo $store['is_visible'] ? '' : 'checked'; ?>> <label for="vis_n_<?php echo $i; ?>">숨김</label></td>
<td><input type="number" name="sort_order[<?php echo $i; ?>]" class="frm_input" style="width:70px" min="0" max="9999" value="<?php echo (int) $store['sort_order']; ?>" aria-label="노출 순서"></td>
<td><a class="btn btn_03" href="./store_form.php?store_id=<?php echo (int) $store['store_id']; ?>">수정</a></td></tr>
<?php } ?>
<?php if (!$stores) { ?><tr><td colspan="9" class="empty_table">등록된 매장이 없습니다. 매장 추가 버튼으로 등록해 주세요.</td></tr><?php } ?>
</tbody></table></div>
<div class="btn_fixed_top">
<button type="submit" name="action" value="bulk_save" class="btn btn_03" onclick="document.pressed='선택수정'">선택수정</button>
<button type="submit" name="action" value="bulk_delete" class="btn btn_01" onclick="document.pressed='선택삭제'">선택삭제</button>
<a href="./store_form.php" class="btn btn_03">매장 추가</a>
<button type="submit" name="action" value="sample" class="btn btn_02" onclick="document.pressed='샘플'">샘플 5개 추가</button>
<a href="<?php echo G5_URL; ?>/pages/stores.html" class="btn btn_02" target="_blank" rel="noopener">공개 화면 보기</a>
</div>
</form>
<script>
function fstores_submit(f){
    var p=document.pressed;
    if(p==='샘플') return confirm('샘플 지점 5개를 추가할까요? (같은 이름이 있으면 건너뜁니다)');
    if(!document.querySelector('.store_chk:checked')){ alert(p+' 하실 항목을 하나 이상 선택하세요.'); return false; }
    if(p==='선택삭제') return confirm('선택한 매장과 등록 사진을 정말 삭제하시겠습니까?');
    return true;
}
</script>
<?php } require_once './admin.tail.php'; ?>
