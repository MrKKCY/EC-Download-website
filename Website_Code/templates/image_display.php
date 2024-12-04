<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>图片文件展示</title>
    <link rel="stylesheet" href="../css/templates.css">
</head>

<body>
    <div class="image-container">
        <img src="<?php echo $filePath;?>" alt="展示图片" width="300" height="300"> <!-- 使用img标签展示图片，设置默认宽高和替代文本 -->
    </div>
</body>

</html>