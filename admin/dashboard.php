<?php
session_start();
include("../func/connections.php");

// Redirect non-admins
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] != 1) {
    header("Location: ../login.php");
    exit();
}

// Fetch Total Users (Exclude Admins)
$user_query = "SELECT COUNT(*) AS total_users FROM user WHERE is_admin = 0;";
$user_result = $conn->query($user_query);
$total_users = $user_result->fetch_assoc()['total_users'];

// Fetch Total Products
$course_query = "SELECT COUNT(*) AS total_courses FROM courses";
$course_result = $conn->query($course_query);
$total_courses = $course_result->fetch_assoc()['total_courses'];

// Fetch Total Sum of Product Prices
$purchase_query = "SELECT COALESCE(SUM(total_amount), 0) AS total_price FROM orders;";
$purchase_result = $conn->query($purchase_query);
$total_price = $purchase_result->fetch_assoc()['total_price'];

// Fetch Total Orders 
$order_query = "SELECT COUNT(*) AS total_orders FROM orders";
$order_result = $conn->query($order_query);
$total_orders = $order_result->fetch_assoc()['total_orders'];

// ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- css file -->
    <link rel="stylesheet" href="src/style.css">

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>



<body>

    <!-- Top Navbar -->
    <nav class="navbar navbar-dark sticky-top bg-dark d-md-none">
    <div class="container-fluid">
        <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
        <i class="fas fa-bars"></i>
        </button>
        <span class="navbar-brand mx-auto">Dashboard</span>
    </div>
    </nav>

    <!-- Navbar -->
    <!-- Desktop Sidebar (hidden on small screens) -->
    <aside class="d-none d-md-block col-md-2 bg-dark text-white vh-100 position-fixed p-3">
        <div class="text-center mb-4">
            <img src="../img/gdc-logo.png" alt="logo" class="img-fluid" style="max-width: 80px;">
        </div>
        <div class="nav flex-column text-center gap-3">
            <a href="../admin/dashboard.php" class="text-warning fw-bold fs-5 text-decoration-none">Dashboard</a>
            <a href="../admin/users.php" class="text-light text-decoration-none">Users</a>
            <a href="../admin/courses.php" class="text-light text-decoration-none">Courses</a>
            <a href="../admin/order.php" class="text-light text-decoration-none">Orders</a>
            <a class="text-danger text-decoration-none fw-bold mt-auto" href="../func/logout.php">Logout</a>
        </div>
    </aside>

    <!-- Offcanvas Sidebar for Mobile -->
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobileSidebarLabel">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column text-center gap-3">
            <img src="../img/gdc-logo.png" alt="logo" class="img-fluid mb-3" style="max-width: 80px; margin: 0 auto;">
            <a href="../admin/dashboard.php" class="text-warning fw-bold fs-5 text-decoration-none">Dashboard</a>
            <a href="../admin/users.php" class="text-light text-decoration-none">Users</a>
            <a href="../admin/courses.php" class="text-light text-decoration-none">Courses</a>
            <a href="../admin/order.php" class="text-light text-decoration-none">Orders</a>
            <a class="text-danger text-decoration-none fw-bold mt-auto" href="../func/logout.php">Logout</a>
        </div>
    </div>

<!-- main -->
<main class="col-md-10 offset-md-1 p-0">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-10 offset-md-2">
            <div class="container py-4">
                <h1 class="text-center fw-bold mb-3 mb-md-5">Dashboard</h1>


                <!-- Dashboard Cards -->
                <div class="row g-4">
                    <div class="col-12 col-sm-6 col-md-6">
                        <div class="bg-primary p-4 rounded shadow text-white text-center">
                            <span class="fs-2 fw-bold"><?php echo $total_users; ?></span>
                            <h4 class="fw-bold">Total Users</h4>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6">
                        <div class="bg-warning p-4 rounded shadow text-white text-center">
                            <span class="fs-2 fw-bold"><?php echo $total_courses; ?></span>
                            <h4 class="fw-bold">Total Courses</h4>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6">
                        <div class="bg-success p-4 rounded shadow text-white text-center">
                            <span class="fs-2 fw-bold"><?php echo $total_orders; ?></span>
                            <h4 class="fw-bold">Total Orders</h4>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6">
                        <div class="bg-danger p-4 rounded shadow text-white text-center">
                            <span class="fs-2 fw-bold">₱<?php echo number_format($total_orders, 2); ?></span>
                            <h4 class="fw-bold">Total Revenue</h4>
                        </div>
                    </div>
                </div>




                
            </div>
        </div>
    </div>
</main>

<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>