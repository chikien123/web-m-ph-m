<?php
include 'config.php';
include 'includes/header.php';
include 'includes/navbar.php';

// Lấy sản phẩm từ database
$stmt = $conn->prepare("SELECT * FROM products LIMIT 20");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-4">
  <div class="text-center mb-4">
    <h2 class="text-pink">🌸 Sản Phẩm Nổi Bật</h2>
    <p>Khám phá những sản phẩm hot nhất dành cho làn da của bạn</p>
  </div>

  <div class="row">
    <?php foreach ($products as $product): ?>
      <div class="col-md-3 mb-4">
        <div class="card h-100 shadow-sm">
          <img src="assets/images/products/<?= $product['image'] ?>" class="card-img-top" height="200" style="object-fit: cover;">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
            <p class="price"><?= number_format($product['price'], 0, ',', '.') ?>đ</p>
            <a href="product.php?id=<?= $product['id'] ?>" class="btn btn-buy mt-auto">Xem chi tiết</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script src="assets/js/chatbot.js"></script>


<?php include 'includes/footer.php'; ?>
