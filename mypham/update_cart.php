<?php
session_start();
include 'config.php';

$product_id = (int) $_POST['product_id'];
$quantity = max(1, (int) $_POST['quantity']);

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$quantity, $user_id, $product_id]);
} else {
    $_SESSION['cart'][$product_id] = $quantity;
}

header('Location: cart.php');
exit;
