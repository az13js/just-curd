<?php
// 按照不同的请求方法，需要进行不同的操作
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $location = strstr($_SERVER['REQUEST_URI'], '?', true);
        $resource = $location ? $location : $_SERVER['REQUEST_URI'];
        if ('/' == $resource) {
            header('Content-Type: text/plain; charset=UTF-8');
            echo '欢迎使用。';
        } else {
            // 连接数据库，然后下面要对数据库进行操作
            $database = new PDO('mysql:host=127.0.0.1;dbname=test_justcurd;port=3306;charset=utf8mb4', 'root', '11111111');
            // 用完数据库后关闭连接
            $database = null;
        }
        break;
    default:
        header('Content-Type: text/plain; charset=UTF-8');
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed', 405);
        echo '请求方法：“' . $_SERVER['REQUEST_METHOD'] . '”目前不被服务器程序支持。';
}

