<?php
$host = '127.0.0.1';
$dbname = 'test_justcurd';
$port = '3306';
$user = 'root';
$password = '11111111';

// 按照不同的请求方法，需要进行不同的操作
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        header('Content-Type: application/json;charset=UTF-8');
        $location = strstr($_SERVER['REQUEST_URI'], '?', true);
        $resource = $location ? $location : $_SERVER['REQUEST_URI'];
        if ('/' == $resource || empty($resource)) {
            try {
                $database = new PDO("mysql:host=$host;dbname=$dbname;port=$port;charset=utf8mb4", $user, $password);
            } catch (PDOException $e) {
                header($_SERVER['SERVER_PROTOCOL'] . ' 503 Service Unavailable', 503);
                echo json_encode($e->getMessage());
                exit();
            }
            $result = $database->query('SHOW TABLES');
            $database = null;
            if (false === $result) {
                header($_SERVER['SERVER_PROTOCOL'] . ' 503 Service Unavailable', 503);
                echo json_encode('获取所有的数据库表名失败！');
            } else {
                echo json_encode($result->fetchAll(PDO::FETCH_COLUMN));
            }
        } elseif (substr($resource, 0, 1) != '/') {
            header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request', 400);
            echo json_encode('请求的资源必须以“/”开头！');
        } else {
            $path = explode('/', $resource);
            try {
                $database = new PDO("mysql:host=$host;dbname=$dbname;port=$port;charset=utf8mb4", $user, $password);
            } catch (PDOException $e) {
                header($_SERVER['SERVER_PROTOCOL'] . ' 503 Service Unavailable', 503);
                echo json_encode($e->getMessage());
                exit();
            }
            $database->exec('CREATE TABLE IF NOT EXISTS `' . addslashes($path[1]) . '` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');
            $result = $database->query('SELECT * FROM `' . addslashes($path[1]) . '`');
            $database = null;
            if (false === $result) {
                header($_SERVER['SERVER_PROTOCOL'] . ' 503 Service Unavailable', 503);
                echo json_encode('获取表数据失败！');
            } else {
                echo json_encode($result->fetchAll(PDO::FETCH_CLASS));
            }
        }
        break;
    default:
        header('Content-Type: application/json;charset=UTF-8');
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed', 405);
        echo json_encode('请求方法：“' . $_SERVER['REQUEST_METHOD'] . '”目前不被服务器程序支持。');
}

