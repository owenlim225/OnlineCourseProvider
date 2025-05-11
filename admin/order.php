<?php
session_start();
include("../func/connections.php");

// Redirect non-admins
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] != 1) {
    header("Location: ../login.php");
    exit();
}


$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_user"])) {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $contact = trim($_POST["contact"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $is_admin = intval($_POST["account_type"]); 

    // Validate fields
    if (empty($first_name) || empty($last_name) || empty($contact) || empty($email)) {
        $message = "<div class='error'>⚠️ All fields are required except password.</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='error'>⚠️ Invalid email format.</div>";
    } elseif (!empty($password) && (strlen($password) < 6 || $password !== $confirm_password)) {
        $message = "<div class='error'>⚠️ Password must be at least 6 characters and match.</div>";
    } else {
        // Hash password if provided
        $hashed_password = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : null;

        // Check if email already exists
        $check_sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "<div class='error'>⚠️ Email already exists.</div>";
        } else {
            // Insert user into database
            $sql = "INSERT INTO user (first_name, last_name, contact, email, password, is_admin) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $first_name, $last_name, $contact, $email, $hashed_password, $is_admin);

            if ($stmt->execute()) {
                $message = "<div class='success'>✅ User added successfully!</div>";
                
            } else {
                $message = "<div class='error'>⚠️ Error adding user: " . $conn->error . "</div>";
            }
        }
    }
    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>

    <!-- css file -->
    <link rel="stylesheet" href="src/style.css">

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>



<body>
    <!-- Top Navbar -->
    <nav class="navbar sticky-top navbar-dark bg-dark d-md-none">
        <div class="container-fluid">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
            <i class="fas fa-bars"></i>
            </button>
            <span class="navbar-brand mx-auto">Orders</span>
        </div>
    </nav>

    <!-- Navbar -->
    <!-- Desktop Sidebar (hidden on small screens) -->
    <aside class="d-none d-md-block col-md-2 bg-dark text-white vh-100 position-fixed p-3">
        <div class="text-center mb-4">
            <img src="../img/gdc-logo.png" alt="logo" class="img-fluid" style="max-width: 80px;">
        </div>
        <div class="nav flex-column text-center gap-3">
            <a href="../admin/dashboard.php" class="text-light text-decoration-none">Dashboard</a>
            <a href="../admin/users.php" class="text-light text-decoration-none">Users</a>
            <a href="../admin/courses.php" class="text-light text-decoration-none">Courses</a>
            <a href="../admin/order.php" class="text-warning fw-bold fs-5 text-decoration-none">Orders</a>
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
            <a href="../admin/dashboard.php" class="text-light text-decoration-none">Dashboard</a>
            <a href="../admin/users.php" class="text-light text-decoration-none">Users</a>
            <a href="../admin/courses.php" class="text-light text-decoration-none">Courses</a>
            <a href="../admin/order.php" class="text-warning fw-bold fs-5 text-decoration-none">Orders</a>
            <a class="text-danger text-decoration-none fw-bold mt-auto" href="../func/logout.php">Logout</a>
        </div>
    </div>

<main class="p-0">
    <div class="container-fluid">
        <div class="row">
            <!-- Main Content -->
            <div class="col-md-10 offset-md-2">
                <div class="container py-4">

                <!-- Order List Table -->
                <h1 class="text-center fw-bold my-5 text-primary">Orders List</h1>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <?php
                        $sql = "SELECT * FROM orders";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Bootstrap badge classes for status
                                $statusClass = match(strtolower($row['order_status'])) {
                                    'pending' => 'bg-warning text-dark',
                                    'completed' => 'bg-success',
                                    'cancelled' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                                
                                echo "<div class='col'>
                                    <div class='card border-0 shadow-lg h-100 rounded-4'>
                                        <div class='card-body'>
                                            <h5 class='card-title fw-bold mb-1'>Order #{$row['order_id']}</h5>
                                            <p class='card-text'>User ID: {$row['user_id']}<br>
                                            <ul class='list-unstyled'>
                                                <li><strong>Full Name:</strong> {$row['full_name']}</li>
                                                <li><strong>Email:</strong> {$row['email']}</li>
                                                <li><strong>Contact:</strong> {$row['mobile']}</li>
                                                <li><strong>Country:</strong> {$row['country']}</li>
                                                <li><strong>MOP:</strong> {$row['payment_method']}</li>
                                            </ul>
                                            <p class='fw-bold'>Total Amount: <span class='text-success'>₱" . number_format($row['total_amount'], 2) . "</span></p>
                                            <span class='badge {$statusClass} px-3 py-2 rounded-pill'>{$row['order_status']}</span>
                                        </div>
                                    </div>
                                </div>";
                            }
                        } else {
                            echo "<div class='col'><div class='card border-0 shadow-lg h-100 rounded-4'><div class='card-body'><p class='text-muted'>No orders found.</p></div></div></div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>



<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>