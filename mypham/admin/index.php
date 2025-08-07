<?php
session_start();
include '../config.php';

// Kiểm tra quyền
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

include '../includes/header.php';
?>

<div class="container mt-5">
  <h2 class="text-pink">👩‍💼 Trang Quản Trị</h2>
  <ul>
    <li><a href="manage_products.php">Quản lý sản phẩm</a></li>
    <li><a href="manage_users.php">Quản lý người dùng</a></li>
    <li><a href="../index.php">Về trang chính</a></li>
  </ul>
</div>

<?php include '../includes/footer.php'; ?>
