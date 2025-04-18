<?php
session_start();
include("../connections.php");

$user_id = $_SESSION['user_id'] ?? 0;
if ($user_id > 0) {
    $stmt = $pdo->prepare("SELECT COUNT(*) AS cart_count FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $cartCount = $stmt->fetchColumn();

    $_SESSION['cart_count'] = $cartCount; // Update session
    echo json_encode(['cart_count' => $cartCount]);
} else {
    echo json_encode(['cart_count' => 0]);
}
?>
