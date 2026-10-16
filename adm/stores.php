<?php
$sub_menu = '100305';
require_once './_common.php';
require_once G5_LIB_PATH . '/store.lib.php';
auth_check_menu($auth, $sub_menu, 'r');
$ready = wigo_store_ready();
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
<div class="local_desc01 local_desc"><p>일반 고객이 방문해 제품을 구매하거나 관리를 받을 수 있는 매장을 등록해 주세요. 공개한 매장은 STORES 페이지에 사진 카드로 표시됩니다. 숫자가 작은 순서부터 노출됩니다.</p></div>
<div class="btn_fixed_top"><a href="<?php echo G5_URL; ?>/pages/stores.html" class="btn btn_02" target="_blank" rel="noopener">공개 화면 보기</a> <?php if ($ready) { ?><a href="./store_form.php" class="btn btn_01">매장 추가</a><?php } ?></div>
<?php if (!$ready) { ?>
<div class="local_desc01 local_desc"><p>최초 1회 매장 관리용 테이블을 생성해야 합니다. 기존 회원·제품·문의 데이터는 변경하지 않습니다.</p>
<?php if ($is_admin === 'super') { ?><form method="post" action="./store_update.php"><input type="hidden" name="token" value="<?php echo $token; ?>"><input type="hidden" name="action" value="install"><button class="btn btn_01" type="submit">매장 관리 초기 설정</button></form><?php } else { ?><p>최고관리자에게 초기 설정을 요청해 주세요.</p><?php } ?></div>
<?php } else { ?>
<div class="tbl_head01 tbl_wrap"><table><caption>매장 목록</caption><thead><tr><th scope="col">사진</th><th scope="col">매장명</th><th scope="col">간단한 위치</th><th scope="col">공개</th><th scope="col">순서</th><th scope="col">관리</th></tr></thead><tbody>
<?php foreach ($stores as $store) { ?>
<tr><td><img src="<?php echo wigo_store_escape(wigo_store_photo_url($store['photo'])); ?>" alt="<?php echo wigo_store_escape($store['name']); ?>" width="100" height="75" style="object-fit:cover"></td><td><?php echo wigo_store_escape($store['name']); ?></td><td><?php echo wigo_store_escape($store['location']); ?></td><td><?php echo $store['is_visible'] ? '공개' : '숨김'; ?></td><td><?php echo (int) $store['sort_order']; ?></td><td><a class="btn btn_03" href="./store_form.php?store_id=<?php echo (int) $store['store_id']; ?>">수정</a>
<form method="post" action="./store_update.php" style="display:inline" onsubmit="return confirm('이 매장과 등록 사진을 삭제할까요?');"><input type="hidden" name="token" value="<?php echo $token; ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="store_id" value="<?php echo (int) $store['store_id']; ?>"><button class="btn btn_02" type="submit">삭제</button></form></td></tr>
<?php } ?>
<?php if (!$stores) { ?><tr><td colspan="6" class="empty_table">등록된 매장이 없습니다. 매장 추가 버튼으로 등록해 주세요.</td></tr><?php } ?>
</tbody></table></div>
<?php } require_once './admin.tail.php'; ?>
