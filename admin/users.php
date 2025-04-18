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
    <title>Users</title>

    <!-- css file -->
    <link rel="stylesheet" href="src/style.css">

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>



<body>
<main class="p-0">
    <div class="container-fluid">
        <div class="row">
            <!-- Navbar -->
            <aside class="col-md-2 d-flex flex-column justify-content-between align-items-center bg-dark text-light text-center py-4 vh-100 position-fixed">
                <div class="w-100 d-flex flex-column align-items-center gap-3">
                    <img src="../img/logo.png" alt="logo" class="img-fluid" style="max-width: 80px;">
                    <div class="d-flex flex-column gap-3 w-100">
                        <a href="../admin/dashboard.php" class="text-light text-decoration-none">Dashboard</a>
                        <a href="../admin/users.php" class="text-warning fw-bold fs-4 text-decoration-none">Users</a>
                        <a href="../admin/courses.php" class="text-light text-decoration-none">Courses</a>
                        <a href="../admin/order.php" class="text-light text-decoration-none">Orders</a>
                    </div>
                </div>
                <a class="text-danger text-decoration-none fw-bold" href="../func/logout.php">Logout</a>
            </aside>

    <!-- Main Content -->
    <div class="col-md-10 offset-md-2">
        <div class="container py-4">

            <!-- add user -->
            <div class="row justify-content-center">
                <div class="col-md-4 bg-white p-4 rounded shadow-lg mt-4 text-center" style="box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); transition: transform 0.3s ease;">
                    <h2 class="mb-3 text-dark">Add New User</h2>
                    
                    <?php echo $message; ?>

                    <form action="users.php" method="POST">
                        <!-- name -->
                        <div class="mb-3" style="display: flex; gap: 10px;">
                            <input type="text" class="form-control border-0 border-bottom" name="first_name" required placeholder="First Name" style="flex: 1;">
                            <input type="text" class="form-control border-0 border-bottom" name="last_name" required placeholder="Last Name" style="flex: 1;">
                        </div>

                        <!-- contact -->
                        <div class="mb-3">
                            <input type="text" name="contact" class="form-control border-0 border-bottom" required placeholder="Contact Number">
                        </div>

                        <!-- email -->
                        <div class="mb-3">
                            <input type="email" name="email" class="form-control border-0 border-bottom" placeholder="Email" required >
                        </div>

                        <!-- password -->
                        <div class="mb-3">
                            <input type="password" name="password" class="form-control border-0 border-bottom" placeholder="Password" required>
                        </div>

                        <!-- confirm password -->
                        <div class="mb-3">
                            <input type="password" name="confirm_password" class="form-control border-0 border-bottom" placeholder="Retype Password" required>
                        </div>

                        <!-- account type -->
                        <div class="mb-3">
                            <label class="form-label text-dark">Account Type:</label>
                            <select name="account_type" class="form-select border-0 border-bottom" required>
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
                        </div>
                        <button type="submit" name="add_user" class="btn btn-dark w-100 fw-bold">➕ Add User</button>
                    </form>
                </div>
            </div>




            <!-- user list table -->
            <h1 class="text-center fw-bold my-5 text-primary">Users List</h1>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered shadow rounded">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">First Name</th>
                                        <th scope="col">Last Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Account Type</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>

                                <tbody class="text-center">
                                    <?php
                                        // Fetch users
                                        $sql = "SELECT * FROM user";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {  
                                                echo "<tr>
                                                    <td class='fw-bold'>{$row['user_id']}</td>
                                                    <td>{$row['first_name']}</td>
                                                    <td>{$row['last_name']}</td>
                                                    <td>{$row['email']}</td>
                                                    <td>" . ($row['is_admin'] == 1 ? 'Admin' : 'User') . "</td>
                                                    <td>
                                                        <a href='../func/admin/edit-user.php?user_id={$row['user_id']}' class='btn btn-sm btn-outline-success'>✏️ Edit</a>
                                                        <a href='../func/admin/delete-user.php?user_id={$row['user_id']}' class='btn btn-sm btn-outline-danger' 
                                                            onclick='return confirm('Are you sure you want to delete this user?');'>🗑 Delete
                                                        </a>
                                                    </td>
                                                </tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='5' class='text-center text-muted'>No users found.</td></tr>";
                                        }
                                    ?>
                                </tbody>
                            </table>
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