<?php
$path = "/wigo8601471/"; // 루트 경로

$total_space = disk_total_space($path);
$free_space = disk_free_space($path);
$used_space = $total_space - $free_space;
$percent_used = ($used_space / $total_space) * 100;

echo "전체 용량: " . round($total_space / (1024 ** 3), 2) . " GB<br>";
echo "사용 중: " . round($used_space / (1024 ** 3), 2) . " GB<br>";
echo "남은 용량: " . round($free_space / (1024 ** 3), 2) . " GB<br>";
echo "사용률: " . round($percent_used, 2) . " %<br/><br/>";





function getFolderSize($path) {
    $size = 0;
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $file) {
        if ($file->isFile()) {
            $size += $file->getSize();
        }
    }
    return $size;
}

$folder = "."; // 또는 "/home/사용자아이디" 경로
$sizeBytes = getFolderSize($folder);
$sizeMB = round($sizeBytes / (1024 * 1024), 2);

echo "폴더 총 용량: {$sizeMB} MB";
?>