<?php
// 获取文件名
$fileName = basename($filePath);
// 构建相对路径
$relativePath = 'files/' . $fileName;
echo $relativePath;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>视频文件展示</title>
    <link rel="stylesheet" href="../css/templates.css">
</head>

<body>
    <div class="video-container">
        <video controls src="<?php echo $relativePath;?>"></video> <!-- 使用video标签展示视频，添加控制条，设置默认宽高 -->
    </div>
</body>

</html>