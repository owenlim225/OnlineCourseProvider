<?php
session_start();
include("../connections.php");

// // Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     // Redirect to login page if not logged in
//     header("Location: ../../login.php");
//     exit();
// }

// echo"Connected yes"; 

// Get the user ID from session
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pay_now"])) {
    // Input variables
    $full_name = trim($_POST["full_name"]);
    $email = trim($_POST["email"]);
    $mobile = trim($_POST["mobile"]);
    $country = trim($_POST["country"]);
    $paymentMethod = $_POST['payment'] ?? '';

    // Payment validation
    $allowedMethods = ['gcash', 'maya', 'grabpay'];
    
    // Validate required fields (fixed variable name)
    if (empty($full_name) || empty($email) || empty($mobile) || empty($country) || empty($paymentMethod)) {
        $_SESSION['error_message'] = "All fields are required.";
        // header("Location: ../../src/user/checkout.php");
        echo"Missing entry";
        exit();
    }

    if (!in_array($paymentMethod, $allowedMethods)) {
        $_SESSION['error_message'] = "Invalid payment method selected";
        header("Location: ../../src/user/checkout.php");
        exit();
    }

    // Calculate total amount
    $total_query = "SELECT COALESCE(SUM(c.price), 0) AS total_price 
                    FROM cart ct
                    JOIN courses c ON ct.course_id = c.course_id
                    WHERE ct.user_id = ? AND ct.is_purchased = 0";
                    
    $stmt = $conn->prepare($total_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $total_price = $result->fetch_assoc()['total_price'];
    
    // If cart is empty, redirect back
    if ($total_price <= 0) {
        $_SESSION['error_message'] = "Your cart is empty.";
        // header("Location: ../../src/user/checkout.php");
        exit();
    }
    

    // Check for duplicate purchases
    $dup_check_query = "SELECT pc.course_id 
                        FROM purchased_courses pc
                        JOIN cart ct ON pc.course_id = ct.course_id
                        WHERE pc.user_id = ? AND ct.user_id = ? AND ct.is_purchased = 0";

    $dup_stmt = $conn->prepare($dup_check_query);
    $dup_stmt->bind_param("ii", $user_id, $user_id);
    $dup_stmt->execute();
    $dup_result = $dup_stmt->get_result();

    if ($dup_result->num_rows > 0) {
        $_SESSION['error_message'] = "You have already purchased one or more courses in your cart.";
        header("Location: ../../src/user/checkout.php");
        exit();
    }

    
    // Begin transaction
    $conn->begin_transaction();
    

    try {
        // Insert into orders table
        $order_sql = "INSERT INTO orders (user_id, full_name, email, mobile, country, payment_method, total_amount, order_status) VALUES (?, ?, ?, ?, ?, ?, ?, 'completed')";
        $order_stmt = $conn->prepare($order_sql);
        $order_stmt->bind_param("isssssd", $user_id, $full_name, $email, $mobile, $country, $paymentMethod, $total_price);
        $order_stmt->execute();
        $order_id = $order_stmt->insert_id;
        
        // Fetch all courses in the cart
        $cart_query = "SELECT course_id FROM cart WHERE user_id = ? AND is_purchased = 0";
        $cart_stmt = $conn->prepare($cart_query);
        $cart_stmt->bind_param("i", $user_id);
        $cart_stmt->execute();
        $cart_result = $cart_stmt->get_result();
        
        // Insert purchased courses into new table
        $purchased_sql = "INSERT INTO purchased_courses (user_id, course_id, order_id) VALUES (?, ?, ?)";
        $purchased_stmt = $conn->prepare($purchased_sql);
        while ($row = $cart_result->fetch_assoc()) {
            $purchased_stmt->bind_param("iii", $user_id, $row['course_id'], $order_id);
            $purchased_stmt->execute();
        }
        
        // Update the cart to mark items as purchased
        $update_sql = "UPDATE cart SET is_purchased = 1 WHERE user_id = ? AND is_purchased = 0";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        // Delete items from the cart after updating
        $delete_sql = "DELETE FROM cart WHERE user_id = ? AND is_purchased = 1";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    
        // Commit transaction
        $conn->commit();
    
        $_SESSION['success_message'] = "Order placed successfully!";
        header("Location: ../../user/purchase-complete.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error_message'] = "An error occurred: " . $e->getMessage();
        header("Location: ../../user/checkout.php");
        exit();
    }
    
    
} else {
    header("Location: ../../user/checkout.php");
    exit();
}

?>
