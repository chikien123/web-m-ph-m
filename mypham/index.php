<?php
include 'config.php';
include 'includes/header.php';
include 'includes/navbar.php';

// Xử lý tìm kiếm
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($search)) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE :keyword OR description LIKE :keyword");
    $keyword = "%$search%";
    $stmt->bindParam(':keyword', $keyword);
} else {
    $stmt = $conn->prepare("SELECT * FROM products LIMIT 30");
}

$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<body class="homepage">
<!-- 🌟 Carousel Giới thiệu chương trình khuyến mãi -->
<div id="promoCarousel" class="carousel slide mb-5" data-bs-ride="carousel" data-bs-interval="5000">
  <div class="carousel-inner rounded-4 shadow">

    <!-- Slide 1 -->
    <div class="carousel-item active">
      <img src="assets/images/banner/khuyenmai.jpg" class="d-block w-100" alt="Khuyến mãi 1">
      <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
        <h5>🎉 Ưu Đãi Đặc Biệt!</h5>
        <p>Mua 1 tặng 1 cho tất cả dòng sản phẩm dưỡng da.</p>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="carousel-item">
      <img src="assets/images/banner/spmoi.jpg" class="d-block w-100" alt="Sản phẩm mới">
      <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
        <h5>🌸 Ra Mắt Sản Phẩm Mới</h5>
        <p>Thử ngay serum dưỡng trắng mới chiết xuất thiên nhiên.</p>
      </div>
    </div>

    <!-- Slide 3 -->
    <div class="carousel-item">
      <img src="assets/images/banner/freeship.jpg" class="d-block w-100" alt="Freeship toàn quốc">
      <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3">
        <h5>🚚 Freeship toàn quốc</h5>
        <p>Đơn hàng từ 290.000đ được miễn phí giao hàng.</p>
      </div>
    </div>

  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- 🔍 Form tìm kiếm -->
<div class="container mt-4">
  <form method="GET" action="index.php" class="mb-4 text-center">
    <input type="text" name="search" placeholder="🔍 Tìm kiếm sản phẩm..." 
           class="form-control d-inline-block w-50 rounded-pill px-4 py-2" 
           style="max-width: 400px;" value="<?= htmlspecialchars($search) ?>">
    <button type="submit" class="btn btn-pink rounded-pill px-4">Tìm</button>
  </form>

  <!-- 🛍️ Tiêu đề -->
  <div class="text-center mb-4">
    <h2 class="text-pink">🌸 Sản Phẩm <?= !empty($search) ? 'Tìm Thấy' : 'Nổi Bật' ?></h2>
    <p><?= !empty($search) ? 'Kết quả cho từ khóa: <strong>' . htmlspecialchars($search) . '</strong>' : 'Khám phá những sản phẩm hot nhất dành cho làn da của bạn' ?></p>
  </div>

  <!-- 🧴 Danh sách sản phẩm -->
  <div class="row">
    <?php if (count($products) > 0): ?>
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
    <?php else: ?>
      <div class="col-12 text-center">
        <p class="text-danger">Không tìm thấy sản phẩm phù hợp.</p>
      </div>
    <?php endif; ?>
  </div>
</div>

<script src="assets/js/chatbot.js"></script>
<!-- Bootstrap JS (nếu chưa có trong footer.php thì thêm dòng dưới) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'includes/footer.php'; ?>
