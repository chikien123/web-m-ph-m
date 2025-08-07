<?php
$host = 'localhost';
$db   = 'mypham_db';
$user = 'root';     // đổi nếu khác
$pass = '';         // nếu có mật khẩu thì nhập

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Kết nối CSDL thất bại: " . $e->getMessage());
}
?>
