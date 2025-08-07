<?php
session_start();
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $password, $role]);

    header("Location: login.php");
    exit;
}

include '../includes/header.php';
?>

<div class="auth-container">
  <h3 class="text-center text-pink">📝 Đăng ký tài khoản</h3>
  <form method="POST" class="p-4 bg-light rounded shadow">
    <div class="mb-3">
      <input type="text" name="name" class="form-control" placeholder="Họ tên..." required>
    </div>
    <div class="mb-3">
      <input type="email" name="email" class="form-control" placeholder="Email..." required>
    </div>
    <div class="mb-3">
      <input type="password" name="password" class="form-control" placeholder="Mật khẩu..." required>
    </div>
    <div class="mb-3">
      <select name="role" class="form-control">
        <option value="user">Người dùng</option>
        <option value="admin">Admin</option>
      </select>
    </div>
    <button type="submit" class="btn btn-buy w-100">Đăng ký</button>
  </form>
</div>


<?php include '../includes/footer.php'; ?>
