<?php
if (!defined('_GNUBOARD_')) exit;

/*
 * 공지사항 · 자료실 공통 조회 (p_notice 테이블, 새 테이블 · 컬럼 없음)
 *   notice_kind = 'a' : 공지사항  (관리자 > 공지사항 관리)
 *   notice_kind = 'b' : 자료실    (관리자 > 자료실 관리)
 * 공개 여부(use_yn)가 'n'인 글은 보이지 않습니다. 정렬은 기존과 같이 최신(notice_no 내림차순)입니다.
 * 메인 · 공지사항 · 자료실 페이지가 모두 이 함수를 같은 기준으로 사용합니다.
 */
function wigo_board_rows($kind, $limit = 0)
{
    $kind = ($kind === 'b') ? 'b' : 'a';
    $rows = array();
    $res = sql_query("SELECT notice_no, notice_kind, notice_subject, notice_file, notice_file_name, notice_file_exp, reg_datetime FROM p_notice WHERE notice_kind = '$kind' AND use_yn <> 'n' ORDER BY notice_no DESC", false);
    while ($res && ($row = sql_fetch_array($res))) {
        // 예전 Newbex / ReviveCell 게시물은 기존과 같이 표시하지 않습니다(DB에는 그대로 남아 있음).
        if (preg_match('/newbex|뉴벡스|revive[ _-]*cell|리바이브셀/iu', $row['notice_subject'])) continue;
        $rows[] = $row;
        if ($limit > 0 && count($rows) >= $limit) break;
    }
    return $rows;
}
