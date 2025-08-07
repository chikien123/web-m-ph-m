<?php
session_start();
include '../config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

$stmt = $conn->query("SELECT * FROM users");

include '../includes/header.php';
?>

<div class="container mt-5">
  <h3 class="text-pink">👥 Danh sách người dùng</h3>
  <a href="index.php" class="btn btn-secondary mb-3">← Quay lại</a>

  <table class="table table-bordered">
    <tr>
      <th>Tên</th>
      <th>Email</th>
      <th>Vai trò</th>
    </tr>
    <?php while ($u = $stmt->fetch()): ?>
    <tr>
      <td><?= $u['name'] ?></td>
      <td><?= $u['email'] ?></td>
      <td><?= $u['role'] ?></td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
