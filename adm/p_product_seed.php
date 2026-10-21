<?php
$sub_menu = '100304';
require_once './_common.php';
require_once G5_LIB_PATH . '/product.lib.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('POST 요청만 가능합니다.'); }
auth_check_menu($auth, $sub_menu, 'w');
if ($is_admin !== 'super') { http_response_code(403); exit('최고관리자만 사용할 수 있습니다.'); }
check_admin_token();
$added = wigo_prod_seed();
alert($added > 0 ? "기본 카드 {$added}개를 등록했습니다. 목록에서 내용을 수정할 수 있습니다." : '이미 제품이 등록되어 있어 추가하지 않았습니다.', './p_product.php');
