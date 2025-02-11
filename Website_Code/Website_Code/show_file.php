<?php
// 定义允许访问的文件基础目录，根据实际情况调整其路径
$allowedBasePath = realpath('files');
if (!$allowedBasePath) {
    header('HTTP/1.1 500 Internal Server Error');
    echo "文件基础目录不存在或不可访问，请检查配置。";
    exit;
}

// 获取要展示的文件的文件名，假设通过URL参数传递，例如：show_file.php?file=example.txt
if (isset($_GET['file'])) {
    $input = urldecode($_GET['file']);
    // 检查输入是否为包含 show_file.php 的 URL
    if (strpos($input, 'show_file.php')!== false) {
        $parsedUrl = parse_url($input);
        parse_str($parsedUrl['query'], $queryParams);
        if (isset($queryParams['file'])) {
            $fileName = $queryParams['file'];
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo "URL中未包含有效的文件参数";
            exit;
        }
    } else {
        $fileName = $input;
    }

    // 拼接完整的文件路径
    $filePath = $allowedBasePath. DIRECTORY_SEPARATOR. $fileName;

    // 校验文件路径是否在允许访问的范围内，防止路径遍历攻击等安全问题
    if (strpos($filePath, $allowedBasePath)!== 0) {
        header('HTTP/1.1 403 Forbidden');
        echo "非法访问路径，禁止访问该文件。";
        exit;
    }

    // 获取文件的扩展名
    $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

    switch ($fileExtension) {
        case 'txt':
            // 以 txt 文件为例
            if (file_exists('templates/txt_display.php')) {
                $content = file_get_contents($filePath);
                if ($content!== false) {
                    include('templates/txt_display.php');
                }
            } else {
                echo "模板文件不存在，请检查配置。";
                exit;
            }
            break;
        case 'mp4':
            // 对于mp4视频文件，设置对应的视频类型的Content-Type响应头，然后输出文件内容展示视频
            if (!file_exists($filePath)) {
                header('HTTP/1.1 404 Not Found');
                header('Content-Type: application/json');
                $error = [
                    'status' => 404,
                    'message' => '指定的视频文件不存在。'
                ];
                echo json_encode($error);
                exit;
            }
            header('Content-Type: video/mp4');
            include('templates/video_display.php'); // 引入视频文件展示的模板文件
            break;
        case 'jpg':
        case 'jpeg':
            if (!file_exists($filePath)) {
                header('HTTP/1.1 404 Not Found');
                echo "指定的图片文件不存在。";
                exit;
            }
            header('Content-Type: image/jpeg');
            include('templates/image_display.php'); // jpg和jpeg共用图片展示模板
            break;
        case 'png':
            if (!file_exists($filePath)) {
                header('HTTP/1.1 404 Not Found');
                echo "指定的图片文件不存在。";
                exit;
            }
            include('templates/image_display.php'); // 引入图片文件展示的模板文件
            break;
        default:
            // 如果是不支持的文件格式，输出错误信息并终止脚本执行
            header('HTTP/1.1 400 Bad Request');
            echo "不支持的文件格式";
            exit;
    }
} else {
    // 如果没有指定要展示的文件，输出提示信息并终止脚本执行
    header('HTTP/1.1 400 Bad Request');
    echo "未指定要展示的文件";
    exit;
}
?>