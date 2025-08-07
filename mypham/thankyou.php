<?php
include 'includes/header.php';
include 'includes/navbar.php';

$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
?>

<div class="container text-center mt-5">
  <h2 class="text-pink">🎉 Cảm ơn bạn đã đặt hàng!</h2>
  <a href="index.php" class="btn btn-secondary mb-3">← Quay lại</a>
  <p>Đơn hàng #<?= $order_id ?> của bạn đã được ghi nhận.</p>
  <a href="index.php" class="btn btn-buy mt-3">Tiếp tục mua sắm</a>
</div>

<?php include 'includes/footer.php'; ?>
