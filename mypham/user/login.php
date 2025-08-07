<?php
session_start();
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        if ($user['role'] === 'admin') {
            header("Location: ../admin/");
        } else {
            header("Location: ../index.php");
        }
        exit;
    } else {
        echo "<script>alert('Sai thông tin đăng nhập');</script>";
    }
}

include '../includes/header.php';
?>
<body class="authpage">
<div class="auth-container">
  <h3 class="text-center text-pink">🔐 Đăng nhập</h3>
  <form method="POST" class="p-4 bg-light rounded shadow">
    <div class="mb-3">
      <input type="email" name="email" class="form-control" placeholder="Email..." required>
    </div>
    <div class="mb-3">
      <input type="password" name="password" class="form-control" placeholder="Mật khẩu..." required>
    </div>
    <button type="submit" class="btn btn-buy w-100">Đăng nhập</button>
  </form>
</div>


<?php include '../includes/footer.php'; ?>
