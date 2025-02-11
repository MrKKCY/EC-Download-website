<?php
if (isset($_GET['file'])) {
    $filePath = urldecode($_GET['file']);
    if (is_file($filePath)) {
        $fileName = basename($filePath);
        // 设置强制下载的响应头信息
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'. $fileName. '"');
        // 输出文件内容，实现下载
        readfile($filePath);
        exit;
    } else {
        echo "指定的文件不存在";
    }
} else {
    echo "没有指定要下载的文件";
}
?>