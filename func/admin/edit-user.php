<?php
include("../connections.php");

$user_id = isset($_GET["user_id"]) ? intval($_GET["user_id"]) : 0;
$message = "";
$user = null; // Ensure $user is defined

// Fetch user details securely
if ($user_id > 0) {
    $sql = "SELECT user_id, first_name, last_name, contact, email, is_admin FROM user WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $user['is_admin'] = isset($user['is_admin']) ? $user['is_admin'] : 0; // Default to 0 if missing
    } else {
        header("Location: users.php");
        exit();
    }
    
} else {
    header("Location: users.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_user"])) {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $contact = trim($_POST["contact"]);
    $new_email = trim($_POST["email"]);
    $new_password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $is_admin = intval($_POST["is_admin"]); // Ensure integer

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($contact) || empty($new_email)) {
        $message = '<div class="alert alert-danger d-flex align-items-center" role="alert"><i class="bi bi-exclamation-triangle-fill me-2"></i><div>All fields are required except password.</div></div>';
    } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $message = '<div class="alert alert-danger d-flex align-items-center" role="alert"><i class="bi bi-exclamation-triangle-fill me-2"></i><div>Invalid email format.</div></div>';
    } elseif (!empty($new_password) && (strlen($new_password) < 6 || $new_password !== $confirm_password)) {
        $message = '<div class="alert alert-danger d-flex align-items-center" role="alert"><i class="bi bi-exclamation-triangle-fill me-2"></i><div>Password must be at least 6 characters and match.</div></div>';
    }

    if (empty($message)) {
        // Check for duplicate email
        $check_sql = "SELECT * FROM user WHERE email = ? AND user_id != ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("si", $new_email, $user_id);
        $stmt->execute();
        $check_result = $stmt->get_result();

        if ($check_result->num_rows > 0) {
            $message = '<div class="alert alert-danger d-flex align-items-center" role="alert"><i class="bi bi-exclamation-triangle-fill me-2"></i><div>Email is already taken.</div></div>';
        } else {
            // Prepare dynamic update query
            $updates = "first_name=?, last_name=?, contact=?, email=?, is_admin=?";
            $params = [$first_name, $last_name, $contact, $new_email, $is_admin];
            $types = "ssssi";

            if (!empty($new_password)) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $updates .= ", password=?";
                $params[] = $hashed_password;
                $types .= "s";
            }

            // Execute update query
            $update_sql = "UPDATE user SET $updates WHERE user_id=?";
            $params[] = $user_id;
            $types .= "i";

            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param($types, ...$params);

            if ($stmt->execute()) {
                $message = '<div class="alert alert-success d-flex align-items-center" role="alert"><i class="bi bi-check-circle-fill me-2"></i><div>✅ User updated successfully!</div></div>';
                // Refresh user data
                $user['first_name'] = $first_name;
                $user['last_name'] = $last_name;
                $user['contact'] = $contact;
                $user['email'] = $new_email;
                $user['is_admin'] = $is_admin;
            } else {
                $message = '<div class="alert alert-danger d-flex align-items-center" role="alert"><i class="bi bi-exclamation-triangle-fill me-2"></i><div>Error updating user.</div></div>';
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit user</title>

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
            <span class="navbar-brand mx-auto">Users</span>
        </div>
    </nav>

    <!-- Navbar -->
    <!-- Desktop Sidebar (hidden on small screens) -->
    <aside class="d-none d-md-block col-md-2 bg-dark text-white vh-100 position-fixed p-3">
        <div class="text-center mb-4">
            <img src="../../img/gdc-logo.png" alt="logo" class="img-fluid" style="max-width: 80px;">
        </div>
        <div class="nav flex-column text-center gap-3">
            <a href="../../admin/dashboard.php" class="text-light text-decoration-none">Dashboard</a>
            <a href="../../admin/users.php" class="text-warning fw-bold fs-5 text-decoration-none">Users</a>
            <a href="../../admin/courses.php" class="text-light text-decoration-none">Courses</a>
            <a href="../../admin/order.php" class="text-light text-decoration-none">Orders</a>
            <a class="text-danger text-decoration-none fw-bold mt-auto" href="../logout.php">Logout</a>
        </div>
    </aside>

    <!-- Offcanvas Sidebar for Mobile -->
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobileSidebarLabel">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column text-center gap-3">
            <img src="../../img/gdc-logo.png" alt="logo" class="img-fluid mb-3" style="max-width: 80px; margin: 0 auto;">
            <a href="../../admin/dashboard.php" class="text-light text-decoration-none">Dashboard</a>
            <a href="../../admin/users.php" class="text-warning fw-bold fs-5 text-decoration-none">Users</a>
            <a href="../../admin/courses.php" class="text-light text-decoration-none">Courses</a>
            <a href="../../admin/order.php" class="text-light text-decoration-none">Orders</a>
            <a class="text-danger text-decoration-none fw-bold mt-auto" href="../logout.php">Logout</a>
        </div>
    </div>


<main class="p-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 offset-md-2">
                <div class="container py-4">
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-lg-5 bg-white p-5 rounded-4 shadow-lg mt-5">
                            <h2 class="mb-4 text-center text-black fw-bold">
                                <i class="bi bi-pencil-square me-2"></i> Edit User
                            </h2>

                            <?php echo $message; ?>

                            <form action="edit-user.php?user_id=<?php echo $user_id; ?>" method="POST">
                                <!-- Full Name -->
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label text-black">First Name</label>
                                        <input type="text" class="form-control rounded-3 shadow-sm" name="first_name" required value="<?php echo htmlspecialchars($user['first_name']); ?>">
                                    </div>
                                    <div class="col">
                                        <label class="form-label text-black">Last Name</label>
                                        <input type="text" class="form-control rounded-3 shadow-sm" name="last_name" required value="<?php echo htmlspecialchars($user['last_name']); ?>">
                                    </div>
                                </div>

                                <!-- Contact -->
                                <div class="mb-3">
                                    <label class="form-label text-black">Contact Number</label>
                                    <input type="text" name="contact" class="form-control rounded-3 shadow-sm" required pattern="[0-9]{11}" maxlength="11" value="<?php echo htmlspecialchars($user['contact']); ?>" title="Please enter a valid 11-digit contact number">
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label class="form-label text-black">Email Address</label>
                                    <input type="email" name="email" class="form-control rounded-3 shadow-sm" required value="<?php echo htmlspecialchars($user['email']); ?>">
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label class="form-label text-black">New Password</label>
                                    <input type="password" name="password" class="form-control rounded-3 shadow-sm" placeholder="New Password">
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-3">
                                    <label class="form-label text-black">Retype Password</label>
                                    <input type="password" name="confirm_password" class="form-control rounded-3 shadow-sm" placeholder="Retype Password">
                                </div>

                                <!-- Account Type -->
                                <div class="mb-4">
                                    <label class="form-label text-black">Account Type</label>
                                    <select name="is_admin" class="form-select rounded-3 shadow-sm">
                                        <option value="1" <?php echo ($user['is_admin'] == 1) ? 'selected' : ''; ?>>Admin</option>
                                        <option value="0" <?php echo ($user['is_admin'] == 0) ? 'selected' : ''; ?>>User</option>
                                    </select>
                                </div>

                                <!-- Submit -->
                                <button type="submit" name="update_user" class="btn btn-dark w-100 fw-bold rounded-pill py-2">
                                    <i class="bi bi-save2-fill me-1"></i> Update User
                                </button>
                            </form>

                            <p class="mt-4 text-center">
                                <a href="../../admin/users.php" class="text-decoration-none fw-semibold text-black">← Back to Users</a>
                            </p>
                        </div>
                    </div>

                    </div>
                </div>
</main>



<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>