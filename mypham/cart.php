<?php
session_start();
include 'config.php';
include 'includes/header.php';
include 'includes/navbar.php';

$cart_items = [];
$total_price = 0;

// Lấy dữ liệu giỏ hàng
if (isset($_SESSION['user_id'])) {
    // Nếu đã đăng nhập: lấy giỏ hàng từ DB
    $stmt = $conn->prepare("SELECT c.id as cart_id, p.*, c.quantity 
                            FROM cart c 
                            JOIN products p ON c.product_id = p.id 
                            WHERE c.user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Nếu chưa đăng nhập: lấy từ SESSION
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($product) {
                $product['quantity'] = $quantity;
                $cart_items[] = $product;
            }
        }
    }
}
?>

<div class="container mt-5">
  <h3 class="text-pink mb-4">🛍️ Giỏ hàng của bạn</h3>
<a href="index.php" class="btn btn-secondary mb-3">← Quay lại</a>

  <?php if (count($cart_items) === 0): ?>
    <p>Bạn chưa thêm sản phẩm nào vào giỏ.</p>
  <?php else: ?>
    <table class="table table-bordered align-middle">
      <thead>
        <tr>
          <th>Hình</th>
          <th>Sản phẩm</th>
          <th>Giá</th>
          <th>Số lượng</th>
          <th>Tổng</th>
          <th>Hành động</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($cart_items as $item): 
          $line_total = $item['price'] * $item['quantity'];
          $total_price += $line_total;
        ?>
        <tr>
          <td><img src="assets/images/products/<?= $item['image'] ?>" width="80"></td>
          <td><?= htmlspecialchars($item['name']) ?></td>
          <td><?= number_format($item['price'], 0, ',', '.') ?>đ</td>
          <td>
            <form method="POST" action="update_cart.php" class="d-flex">
              <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
              <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="form-control me-2" style="width:80px;">
              <button type="submit" class="btn btn-sm btn-outline-secondary">Cập nhật</button>
            </form>
          </td>
          <td><?= number_format($line_total, 0, ',', '.') ?>đ</td>
          <td>
            <form method="POST" action="remove_from_cart.php">
              <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
              <button type="submit" class="btn btn-sm btn-danger">Xoá</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="text-end">
      <h4>Tổng cộng: <span class="text-pink"><?= number_format($total_price, 0, ',', '.') ?>đ</span></h4>
      <a href="checkout.php" class="btn btn-buy mt-2">Thanh toán</a>
    </div>
  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
