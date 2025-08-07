<?php
session_start();
include 'config.php';

$product_id = (int) $_POST['product_id'];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
} else {
    unset($_SESSION['cart'][$product_id]);
}

header('Location: cart.php');
exit;
