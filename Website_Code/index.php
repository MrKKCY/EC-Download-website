<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    // 这里定义为绝对路径，假设你的服务器环境下，files文件夹位于网站根目录下的public文件夹内，你需要根据实际情况修改此路径
    // 目的是明确指定files文件夹的位置，避免相对路径可能出现的解析不一致问题，确保后续能正确访问其中的文件和文件夹
    $filesFolder = 'files';
    $Web_title = "文件下载站";
    $host = $_SERVER['HTTP_HOST'];
    $http_r = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
    // 判断files文件夹是否存在，如果存在则获取其目录内容，并设置页面标题
    if (is_dir($filesFolder)) {
        $contents = scandir($filesFolder);
        echo '<title>'. $Web_title. '</title>';
    }
    ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <h1><?php echo $Web_title?></h1>

    <?php
    // 定义displayContents函数，用于展示指定文件夹路径下的文件和文件夹内容
    // 参数$folderPath表示要展示内容的文件夹路径，$currentPath表示当前所在路径（用于构建面包屑导航），默认为空字符串
    function displayContents($folderPath, $currentPath = '')
    {
        // 使用scandir函数获取指定文件夹路径下的所有文件和文件夹名称，存储在$contents数组中
        $contents = scandir($folderPath);
        $breadcrumb = '<div class="breadcrumb">';
        $pathParts = explode('/', $folderPath);
        $relativePathParts = [];
        foreach ($pathParts as $index => $part) {
            if ($part!= '') {
                $relativePathParts[] = $part;
                $relativePath = implode('/', $relativePathParts);
                // 构建相对路径形式的链接，用于面包屑导航展示
                $breadcrumb.= '<a href="index.php?path='. urlencode($relativePath). '">'. htmlspecialchars($part). '</a> / ';
            }
        }
        $breadcrumb = rtrim($breadcrumb, " / ");
        $breadcrumb.= '</div>';
        echo $breadcrumb;

        echo '<ul>';
        foreach ($contents as $item) {
    if ($item!= '.' && $item!= '..') {
        $fullPath = rtrim($folderPath, '/'). '/'. $item;
        if (is_dir($fullPath)) {
            // 如果是文件夹，先输出文件夹的展示代码，使其显示在上方
            echo '<li><a href="index.php?path='. urlencode($fullPath). '" class="folder-link">'. htmlspecialchars($item). '</a></li>';
        }
    }
}
$host = $_SERVER['HTTP_HOST'];
$http_r = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
foreach ($contents as $item) {
    if ($item!= '.' && $item!= '..') {
        $fullPath = rtrim($folderPath, '/'). '/'. $item;
        if (is_file($fullPath)) {
            $fileExtension = pathinfo($fullPath, PATHINFO_EXTENSION);
            if ($fileExtension == 'html' or 'txt' or 'png') {
                // 这里不再直接设置响应头和执行下载操作，而是将下载相关逻辑放到链接点击的处理中
                echo '<li class="file_box"><a href ="show_file.php?file='. htmlspecialchars($item). '" " style="color:#383838; text-decoration: none;"><i class="bi bi-filetype-'. $fileExtension. '"></i>  '. htmlspecialchars($item). '</a><a href="download.php?file='. urlencode($fullPath). '" style="color:#383838; "><i class="bi bi-download"></i></a></li>';
            } else {
                echo '<li class="file_box"><a href ="show_file.php?file='. htmlspecialchars($item). '" " style="color:#383838; text-decoration: none;"><i class="bi bi-filetype-'. $fileExtension. '"></i>  '. htmlspecialchars($item). '</a><a href="'. $fullPath. '" style="color:#383838; "><i class="bi bi-download"></i></a></li>';
            }
        }
    }
}
        echo '</ul>';
    }

    function isPathAllowed($path)  
    {
        $allowedBasePath = 'files';
        if (strpos($path, $allowedBasePath)!== 0) {
            return false;
        }
        $path = ltrim($path, $allowedBasePath. '/');
        $pathSegments = explode('/', $path);
        foreach ($pathSegments as $segment) {
            if ($segment == '..') {
                return false;
            }
        }
        return true;
    }
    
    // 判断是否通过URL参数传递了路径信息（即用户点击文件夹链接进入下一级目录的情况）
    if (isset($_GET['path'])) {
        $currentPath = urldecode($_GET['path']);
        if (!isPathAllowed($currentPath)) {
            echo "非法访问路径，你无权访问该路径下的内容!";
            exit;
        }
        // 判断解码后的路径是否是一个有效的文件夹，如果是则调用displayContents函数展示其内容
        if (is_dir($currentPath)) {
            displayContents($currentPath, $currentPath);
        } else {
            // 如果不是有效文件夹，则输出提示信息
            echo "指定的路径不存在或不是文件夹!";
        }
    } else {
        // 如果没有通过URL参数传递路径信息，默认展示根目录下files文件夹的内容
        displayContents($filesFolder);
    }
   ?>
</body>

</html>