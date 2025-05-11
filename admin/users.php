<?php
session_start();
include("../func/connections.php");

// Redirect non-admins
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] != 1) {
    header("Location: ../login.php");
    exit();
}

// Display message
$message = "";
if (isset($_SESSION["message"])) {
    $message = $_SESSION["message"];
    unset($_SESSION["message"]);
}

// Add user
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
        $message = "<div class='alert alert-danger'>⚠️ All fields are required except password.</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='alert alert-danger'>⚠️ Invalid email format.</div>";
    } elseif (!empty($password) && (strlen($password) < 6 || $password !== $confirm_password)) {
        $message = "<div class='alert alert-danger'>⚠️ Password must be at least 6 characters and match.</div>";
    } else {
        // Hash password
        $hashed_password = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : null;

        // Check if email already exists
        $check_sql = "SELECT * FROM user WHERE email = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Display error if email already exists
        if ($result->num_rows > 0) {
            $message = "<div class='alert alert-danger'>⚠️ Email already exists.</div>";
        } else {
            // Insert user into database
            $sql = "INSERT INTO user (first_name, last_name, contact, email, password, is_admin) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $first_name, $last_name, $contact, $email, $hashed_password, $is_admin);
            
            // Display success message
            if ($stmt->execute()) {
                $message = "<div class='alert alert-success d-flex align-items-center' role='alert'><i class='fa-solid me-2'></i><div>✅ User added successfully!</div></div>";
                
            } else {
                $message = "<div class='alert alert-danger'>⚠️ Error adding user: " . $conn->error . "</div>";
            }
        }
    }
    $_SESSION["message"] = $message;
    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>

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
            <img src="../img/gdc-logo.png" alt="logo" class="img-fluid" style="max-width: 80px;">
        </div>
        <div class="nav flex-column text-center gap-3">
            <a href="../admin/dashboard.php" class="text-light text-decoration-none">Dashboard</a>
            <a href="../admin/users.php" class="text-warning fw-bold fs-5 text-decoration-none">Users</a>
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
            <a href="../admin/dashboard.php" class="text-light text-decoration-none">Dashboard</a>
            <a href="../admin/users.php" class="text-warning fw-bold fs-5 text-decoration-none">Users</a>
            <a href="../admin/courses.php" class="text-light text-decoration-none">Courses</a>
            <a href="../admin/order.php" class="text-light text-decoration-none">Orders</a>
            <a class="text-danger text-decoration-none fw-bold mt-auto" href="../func/logout.php">Logout</a>
        </div>
    </div>

<main class="p-0">
    <div class="container-fluid">
        <div class="row">            
        <!-- Main Content -->
        <div class="col-md-10 offset-md-2">
            <div class="container py-4">

                <!-- add user -->
                <div class="row justify-content-center d-none" id="addUserForm">
                    <div class="col-md-6 col-lg-5 bg-white p-5 rounded-4 shadow-lg mt-5">
                        <h2 class="mb-4 text-center text-black fw-bold">
                            <i class="bi bi-person-plus-fill me-2"></i> Add New User
                        </h2>
                        
                        <?php echo $message; ?>

                        <form action="users.php" method="POST">
                            <!-- Full Name -->
                            <div class="row mb-3">
                                <div class="col">
                                    <label class="form-label text-black">First Name</label>
                                    <input type="text" class="form-control rounded-3 shadow-sm" name="first_name" required placeholder="e.g., John">
                                </div>
                                <div class="col">
                                    <label class="form-label text-black">Last Name</label>
                                    <input type="text" class="form-control rounded-3 shadow-sm" name="last_name" required placeholder="e.g., Doe">
                                </div>
                            </div>

                            <!-- Contact -->
                            <div class="mb-3">
                                <label class="form-label text-black">Contact Number</label>
                                <input type="text" name="contact" class="form-control rounded-3 shadow-sm" required placeholder="e.g., 09123456789" pattern="[0-9]{11}" maxlength="11" title="Please enter a valid 11-digit contact number">
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label text-black">Email Address</label>
                                <input type="email" name="email" class="form-control rounded-3 shadow-sm" required placeholder="example@mail.com">
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label text-black">Password</label>
                                <input type="password" name="password" class="form-control rounded-3 shadow-sm" required placeholder="Enter password">
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-black">Retype Password</label>
                                <input type="password" name="confirm_password" class="form-control rounded-3 shadow-sm" required placeholder="Confirm password">
                            </div>

                            <!-- Account Type -->
                            <div class="mb-4">
                                <label class="form-label text-black">Account Type</label>
                                <select name="account_type" class="form-select rounded-3 shadow-sm" required>
                                    <option value="" disabled selected>Select account type</option>
                                    <option value="1">Admin</option>
                                    <option value="0">User</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" name="add_user" class="btn btn-dark w-100 fw-bold rounded-pill py-2">
                                <i class="bi bi-plus-circle me-1"></i> Add User
                            </button>
                        </form>
                    </div>
                </div>

                <div class="d-grid gap-2 col-4 mx-auto">
                    <button type="button" class="btn btn-primary btn-dark fw-bold rounded-pill py-2 mt-5" id="showAddUserForm">
                        <i class="bi bi-plus-circle me-1"></i> Add New User
                    </button>
                </div>

                <?php if (!empty($message)): ?>
                    <script>
                        // Force the form to stay open if there's a message
                        document.addEventListener('DOMContentLoaded', () => {
                            const addUserForm = document.getElementById('addUserForm');
                            const showAddUserForm = document.getElementById('showAddUserForm');
                            
                            if (addUserForm) {
                                addUserForm.classList.remove('d-none'); // Show form
                                showAddUserForm.innerHTML = '<i class="bi bi-x-circle me-1"></i> Cancel';
                            }
                        });
                    </script>
                <?php endif; ?>

                <script>
                    const addUserForm = document.getElementById('addUserForm');
                    const showAddUserForm = document.getElementById('showAddUserForm');

                    showAddUserForm.addEventListener('click', () => {
                        addUserForm.classList.toggle('d-none');
                        if (addUserForm.classList.contains('d-none')) {
                            showAddUserForm.innerHTML = '<i class="bi bi-plus-circle me-1"></i> Add New User';
                        } else {
                            showAddUserForm.innerHTML = '<i class="bi bi-x-circle me-1"></i> Cancel';
                        }
                    });
                </script>




                <!-- user list grid -->
                <h1 class="text-center fw-bold my-5 text-primary">User List</h1>
                <div class="container">
                    <div class="row">
                        <?php
                            // Fetch users
                            $sql = "SELECT * FROM user";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $isAdmin = $row['is_admin'] == 1;
                                    echo "
                                    <div class='col-12 col-sm-6 col-md-4 col-lg-3 mb-4'>
                                        <div class='card border-0 shadow-lg h-100 rounded-4 position-relative'>
                                            <div class='card-body d-flex flex-column align-items-center text-center p-4'>
                                                <div class='bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mb-3' style='width: 70px; height: 70px; font-size: 28px; font-weight: bold;'>
                                                    " . strtoupper($row['first_name'][0]) . "
                                                </div>
                                                <h5 class='card-title fw-bold mb-1'>{$row['first_name']} {$row['last_name']}</h5>
                                                <p class='text-muted mb-2 small'><i class='bi bi-envelope'></i> user_id: {$row['user_id']}</p>
                                                <p class='text-muted mb-2 small'><i class='bi bi-envelope'></i> {$row['email']}</p>
                                                <p class='text-muted mb-2 small'><i class='bi bi-envelope'></i> {$row['contact']}</p>
                                                <span class='badge " . ($isAdmin ? "bg-gradient bg-success" : "bg-gradient bg-secondary") . " px-3 py-2 mb-3'>" . ($isAdmin ? 'Admin' : 'User') . "</span>
                                                <div class='d-flex justify-content-center gap-2 mt-auto'>
                                                    <a href='../func/admin/edit-user.php?user_id={$row['user_id']}' class='btn btn-sm btn-outline-success'>
                                                        ✏️ Edit
                                                    </a>
                                                    <a href='../func/admin/delete-user.php?user_id={$row['user_id']}' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Are you sure you want to delete this user?\")'>
                                                        🗑 Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
                                }
                            } else {
                                echo "<p class='text-center text-muted'>No users found.</p>";
                            }
                        ?>
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