<?php
session_start();
include 'config.php';

// Nếu chưa đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: user/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Lấy sản phẩm trong giỏ hàng từ DB
$stmt = $conn->prepare("SELECT c.product_id, c.quantity, p.price 
                        FROM cart c 
                        JOIN products p ON c.product_id = p.id 
                        WHERE c.user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($cart_items) === 0) {
    echo "<script>alert('Giỏ hàng trống.'); window.location='cart.php';</script>";
    exit;
}

// Tính tổng tiền
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Tạo đơn hàng
$stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
$stmt->execute([$user_id, $total]);
$order_id = $conn->lastInsertId();

// (Tuỳ chọn) bạn có thể tạo bảng order_details nếu muốn lưu từng dòng chi tiết
// Xoá giỏ hàng
$stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);

// Chuyển hướng về trang cảm ơn
header("Location: thankyou.php?order_id=$order_id");
exit;
?>
