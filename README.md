# Just CURD

这是一个通过提供简单的 HTTP 请求，就能实现数据 CURD 操作的 PHP 程序。目前程序仅支持 MySQL, MariaDB。

## 使用方法

使用前需要进行准备：

1. 创建新的数据库

    CREATE DATABASE test_justcurd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

2. 配置`index.php`文件。

正式使用：

### 查看全部表

    curl http://127.0.0.1

返回所有表

    ["user"]

### 查看`user`表的数据

    curl http://127.0.0.1/user

返回

    [{"id":"1","name":"asdsada"}]

### 查看不存在的表

会在数据库新建那张表

    curl http://127.0.0.1/school

然后

    curl http://127.0.0.1

表变成了

    ["school","user"]
