<?php
// 这里假设 $content 变量是从 show_file.php 文件中读取txt文件内容后传递过来的，确保这个变量已经正确赋值
if (isset($content)) {
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>文本预览-<?php echo $fileName; ?></title>
        <link rel="stylesheet" href="../css/templates.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    </head>

    <body>
        <div class="text-container">
            <?php echo htmlspecialchars($content);?> <!-- 使用pre标签展示文本内容，并对特殊字符进行转义，确保安全和格式保留 -->
        </div>
        <a href="/..">
            <div class="back_button">
                <i class="bi bi-backspace" style="font-size:25px;"></i>
            </div>
        </a>
    </body>

</html>
<?php
} else {
    // 如果 $content 变量未正确赋值（比如读取文件出现问题等情况），可以在这里输出提示信息等进行处理
    echo "无法获取要展示的文本内容";
}
?>