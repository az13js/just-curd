<?php
// 连接数据库，然后下面要对数据库进行操作
$database = new PDO('mysql:host=127.0.0.1;dbname=test_justcurd;port=3306;charset=utf8mb4', 'root', '11111111');

// 用完数据库后关闭连接
$database = null;
