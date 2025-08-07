<?php
include 'config.php';
include 'includes/header.php';
include 'includes/navbar.php';

if (!isset($_GET['id'])) {
  echo "<div class='container mt-5'><h4>Không tìm thấy sản phẩm.</h4></div>";
  include 'includes/footer.php';
  exit;
}

$id = (int) $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
  echo "<div class='container mt-5'><h4>Sản phẩm không tồn tại.</h4></div>";
  include 'includes/footer.php';
  exit;
}
?>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-5">
      <img src="assets/images/products/<?= $product['image'] ?>" class="img-fluid rounded shadow-sm">
    </div>
    <div class="col-md-7">
      <h2><?= htmlspecialchars($product['name']) ?></h2>
      <a href="index.php" class="btn btn-secondary mb-3">← Quay lại</a>
      <h4 class="text-pink mt-3"><?= number_format($product['price'], 0, ',', '.') ?>đ</h4>
      <p class="mt-4"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
      
      <form method="POST" action="add_to_cart.php" class="mt-4">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
        <label for="qty">Số lượng:</label>
        <input type="number" name="quantity" id="qty" value="1" min="1" class="form-control w-25 mb-3">
        <button type="submit" class="btn btn-buy">🛒 Thêm vào giỏ hàng</button>
      </form>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
