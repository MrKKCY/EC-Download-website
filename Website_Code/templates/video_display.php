<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>视频文件展示</title>
    <link rel="stylesheet" href="../css/templates.css">
</head>

<body>
    <div class="video-container">
        <video controls width="640" height="360" src="<?php echo $filePath;?>"></video> <!-- 使用video标签展示视频，添加控制条，设置默认宽高 -->
    </div>
</body>

</html>