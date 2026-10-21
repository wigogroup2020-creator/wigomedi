<?php
require_once './_common.php';
include_once(G5_PATH.'/newbex_head.php');

$notice_no = isset($_GET['no']) ? intval($_GET['no']) : 0;

if ($notice_no == 0) {
    echo "잘못된 접근입니다."; exit;
}

$sql = "SELECT * FROM p_notice WHERE notice_no = '$notice_no' AND use_yn <> 'n'";
$row = sql_fetch($sql);

if (!$row) {
    echo "존재하지 않는 게시글입니다.";
    exit;
}
$kind = $row['notice_kind']; // 'a = 공지사항' 또는 'b = 자료실'
// URL 분기
$list_url = ($kind === 'a') ? 'm31.html' : 'm32.html';
// kind 값에 따라 타이틀 텍스트를 설정
$page_title = ($row['notice_kind'] === 'a') ? '공지사항' : '자료실';
?>
    <main class="container">
        <div id="contents">
            <div class="pageTop pn3 bn-face">
                <div class="bg"></div>
                <div class="inner">
                    <h1 class="pageSlg"><?php echo $page_title; ?></h1>
                </div>
            </div>
            <div class="pageTitleArea inner">
                <ul>
                    <li><a href="/index.html">Home</a></li>
                    <li>Customer</li>
                    <li><?php echo $page_title; ?></li>
                </ul>
            </div>

            <div class="page m31_view inner">
                <!-- 게시판시작 -->
                <div class="board_view">
                    <div class="b_info">
                        <!-- 제목 -->
                        <strong><?php echo $row['notice_subject'];?></strong>
                    </div>
                    <ul class="bd_view_ul_info">
                        <li>
                            <span class="info_tit">작성일</span>
                            <span><?php echo substr($row['reg_datetime'], 0,10);?></span>
                        </li>
                    </ul>
                    <!-- 내용 -->
                    <div class="b_content">
                        <?php echo $row['notice_content'];?>
                    </div>
                    <!-- 첨부파일 -->
                    <?php if ($row['notice_file']) { $gw_fu = G5_URL . '/data/notice/' . rawurlencode($row['notice_file']); $gw_fd = G5_BBS_URL . '/newbex_download.php?notice_no=' . (int) $notice_no; ?>
                    <dl class="b_file">
                        <dt>첨부파일</dt>
                        <dd>
                            <ul>
                                <li><a href="<?php echo $gw_fd;?>" download><?php echo htmlspecialchars($row['notice_file_name'] !== '' ? $row['notice_file_name'] : $row['notice_file'], ENT_QUOTES, 'UTF-8');?></a></li>
                                <li><a class="download_btn" href="<?php echo $gw_fd;?>" download aria-label="파일 다운로드"></a></li>
                                <li><a class="view_btn" href="<?php echo $gw_fu;?>" target="_blank" rel="noopener" aria-label="파일 보기"></a></li>
                            </ul>
                        </dd>
                    </dl>
                    <?php } ?>
                    <!-- 이전글 다음글 -->
                    <?php
                    $sql_prev = "SELECT notice_no, notice_subject FROM p_notice 
                                WHERE notice_no > '$notice_no' AND notice_kind = '{$kind}' AND use_yn <> 'n'
                                ORDER BY notice_no ASC LIMIT 1";
                    $row_prev = sql_fetch($sql_prev);

                    $sql_next = "SELECT notice_no, notice_subject FROM p_notice 
                                WHERE notice_no < '$notice_no' AND notice_kind = '{$kind}' AND use_yn <> 'n'
                                ORDER BY notice_no DESC LIMIT 1";
                                $row_next = sql_fetch($sql_next);
                    ?>
                    <div class="b_page">
                        <ul>
                            <li>
                                <?php if ($row_prev) { ?>
                                    <a href="<?php echo G5_URL; ?>/pages/m31_view.php?no=<?php echo $row_prev['notice_no']; ?>">
                                        <div>
                                            <span><img src="/img/common/page_arr_left.png" alt=""></span>
                                            <span>이전글</span>
                                        </div>
                                        <span class="before_txt">
                                            <?php echo $row_prev['notice_subject']; ?>
                                        </span>
                                    </a>
                                <?php } else { ?>
                                    <a href="#" onclick="alert('이전글이 없습니다.'); return false;">
                                        <div>
                                            <span><img src="/img/common/page_arr_left.png" alt=""></span>
                                            <span>이전글</span>
                                        </div>
                                        <span class="before_txt">등록된 글이 없습니다.</span>
                                    </a>
                                <?php } ?>
                            </li>
                            <li>
                                <?php if ($row_next) { ?>
                                    <a href="<?php echo G5_URL; ?>/pages/m31_view.php?no=<?php echo $row_next['notice_no']; ?>">
                                        <div>
                                            <span>다음글</span>
                                            <span><img src="/img/common/page_arr_right.png" alt=""></span>
                                        </div>
                                        <span class="before_txt">
                                            <?php echo $row_next['notice_subject']; ?>
                                        </span>
                                    </a>
                                <?php } else { ?>
                                    <a href="#" onclick="alert('다음글이 없습니다.'); return false;">
                                        <div>
                                            <span>다음글</span>
                                            <span><img src="/img/common/page_arr_right.png" alt=""></span>
                                        </div>
                                        <span class="before_txt">등록된 글이 없습니다.</span>
                                    </a>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                    <div class="bd_butt">
                        <a class="btn" href="<?php echo $list_url; ?>">
                            목록보기
                        </a>
                    </div>
                </div>
            </div>
        </div> 
    </main>
<?php
include_once(G5_PATH."/newbex_tail.php");
?>