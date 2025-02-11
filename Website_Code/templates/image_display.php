<?php
// 获取文件名
$fileName = basename($filePath);
// 构建相对路径
$relativePath = 'files/' . $fileName;
?>

<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="UTF-8">
        <title>图片预览-<?php echo $fileName?></title>
        <link rel="stylesheet" href="../css/templates.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    </head>
    </head>

    <body class='cbodys'>
        <div class="image-container">
            <img src="<?php echo $relativePath;?>" alt="展示图片"> <!-- 使用img标签展示图片，设置默认宽高和替代文本 -->
        </div>
        <a href="<?php echo $relativePath;?>"><button>查看原图</button></a>
        <a href="/..">
            <div class="back_button">
                <i class="bi bi-backspace" style="font-size:25px;"></i>
            </div>
        </a>
    </body>
</html>