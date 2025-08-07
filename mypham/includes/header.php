<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Shop Mỹ Phẩm</title>
  <link rel="stylesheet" href="/assets/css/auth.css">
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4 mb-4">
  <h2 class="text-center">🛍️ Shop Mỹ Phẩm</h2>
  <nav class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <a href="/index.php" class="btn btn-buy me-2">🏠 Trang chủ</a>
      <?php if (!empty($_SESSION['user_id'])): ?>
        <a href="/cart.php" class="btn btn-buy me-2">🛒 Giỏ hàng</a>
        <?php if ($_SESSION['role'] === 'admin'): ?>
          <a href="/admin/index.php" class="btn btn-buy me-2">👩‍💼 Quản trị</a>
        <?php endif; ?>
        <a href="/user/logout.php" class="btn btn-danger">🚪 Đăng xuất</a>
      <?php else: ?>
        <a href="/user/register.php" class="btn btn-outline-secondary me-2">📝 Đăng ký</a>
        <a href="/user/login.php" class="btn btn-outline-secondary">🔐 Đăng nhập</a>
      <?php endif; ?>
    </div>
  </nav>
