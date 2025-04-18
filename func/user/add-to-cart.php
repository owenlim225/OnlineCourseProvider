<?php
session_start();
include("../connections.php");

// Set headers to return JSON response
header('Content-Type: application/json');

// Prepare response array
$response = [
    'success' => false,
    'message' => '',
    'type' => 'error',
    'cart_count' => 0
];

// Check if user is logged in
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    $response['message'] = 'Please login to add items to your cart.';
    echo json_encode($response);
    exit();
}

// Check if request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") { // Only allow POST requests
    $user_id = $_SESSION['user_id']; // Get user_id from session
    $course_id = $_POST['course_id']; // Get course_id from POST

    // Prevent duplicate cart entries
    $check_query = "SELECT * FROM cart WHERE user_id = ? AND course_id = ? AND is_purchased = 0";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ii", $user_id, $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Insert new cart item
        $query = "INSERT INTO cart (user_id, course_id, is_purchased, added_at) VALUES (?, ?, 0, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $user_id, $course_id);

        if ($stmt->execute()) {
            // Update cart count
            $cart_count = updateCartCount($conn, $user_id);
            
            // Set response
            $response['success'] = true;
            $response['message'] = 'Course added to cart successfully!';
            $response['type'] = 'success';
            $response['cart_count'] = $cart_count;
        } else {
            $response['message'] = 'Failed to add course to cart. Please try again.';
        }
    } else {
        $response['message'] = 'This course is already in your cart.';
        $response['type'] = 'warning';
        $response['cart_count'] = $_SESSION['cart_count'];
    }
} else {
    $response['message'] = 'Invalid request method.';
}

// Return JSON response
echo json_encode($response);
exit();

// Function to update cart count in session
function updateCartCount($conn, $user_id) {
    $query = "SELECT COUNT(*) as cart_count FROM cart WHERE user_id = ? AND is_purchased = 0";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $cart_count = $row['cart_count'];
    $_SESSION['cart_count'] = $cart_count;
    return $cart_count;
}
?>