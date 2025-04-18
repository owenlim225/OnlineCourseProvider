<?php
session_start();
include("../connections.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: ../../login.php");
    exit();
}

// Delete course from cart
if (isset($_GET["course_id"]) && is_numeric($_GET["course_id"])) {
    $course_id = intval($_GET["course_id"]);
    $user_id = $_SESSION['user_id']; // Get user ID from session
    
    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM cart WHERE course_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $course_id, $user_id);
    $result = $stmt->execute();
    
    if ($result) {
        echo "<script>alert('Item removed from cart successfully!'); window.location.href = '../../user/cart.php';</script>";
    } else {
        echo "<script>alert('Failed to remove item from cart!'); window.location.href = '../../user/cart.php';</script>";
    }
    $stmt->close();
} else {
    // Invalid or missing course_id
    echo "<script>alert('Invalid request!'); window.location.href = '../../user/cart.php';</script>";
}

$conn->close();
?>