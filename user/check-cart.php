<?php
session_start();
include("../func/connections.php");

header('Content-Type: application/json');

$user_id = $_SESSION['user_id'] ?? 0;

if ($user_id === 0) {
    echo json_encode(['success' => false, 'count' => 0]);
    exit;
}

$stmt = $conn->prepare("SELECT COUNT(*) as total FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$count = $result->fetch_assoc()['total'] ?? 0;

echo json_encode(['success' => true, 'count' => $count]);

?>