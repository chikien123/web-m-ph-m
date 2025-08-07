<?php
session_start();
include '../config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit;
}

$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../includes/header.php';
?>

<div class="container mt-5">
  <h3 class="text-pink">📦 Quản lý sản phẩm</h3>
  <a href="add_product.php" class="btn btn-buy mb-3">+ Thêm sản phẩm</a>
  <a href="index.php" class="btn btn-secondary mb-3">← Quay lại</a>

  <table class="table table-bordered">
    <tr>
      <th>Tên</th>
      <th>Giá</th>
      <th>Hình</th>
      <th>Hành động</th>
    </tr>
    <?php foreach ($products as $p): ?>
    <tr>
      <td><?= $p['name'] ?></td>
      <td><?= number_format($p['price'],0,',','.') ?>đ</td>
      <td><img src="../assets/images/products/<?= $p['image'] ?>" width="80"></td>
      <td>
        <a href="edit_product.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
        <a href="delete_product.php?id=<?= $p['id'] ?>" onclick="return confirm('Xoá?')" class="btn btn-sm btn-danger">Xoá</a>
      </td>
    </tr>
    <?php endforeach; ?>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
