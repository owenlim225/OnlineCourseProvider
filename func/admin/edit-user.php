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
        $message = "<div class='error'>⚠️ All fields are required except password.</div>";
    } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='error'>⚠️ Invalid email format.</div>";
    } elseif (!empty($new_password) && (strlen($new_password) < 6 || $new_password !== $confirm_password)) {
        $message = "<div class='error'>⚠️ Password must be at least 6 characters and match.</div>";
    }

    if (empty($message)) {
        // Check for duplicate email
        $check_sql = "SELECT * FROM user WHERE email = ? AND user_id != ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("si", $new_email, $user_id);
        $stmt->execute();
        $check_result = $stmt->get_result();

        if ($check_result->num_rows > 0) {
            $message = "<div class='error'>⚠️ Email is already taken.</div>";
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
                $message = "<div class='success'>✅ User updated successfully!</div>";
                // Refresh user data
                $user['first_name'] = $first_name;
                $user['last_name'] = $last_name;
                $user['contact'] = $contact;
                $user['email'] = $new_email;
                $user['is_admin'] = $is_admin;
            } else {
                $message = "<div class='error'>⚠️ Error updating user.</div>";
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



<main class="p-0">
    <div class="container-fluid">
        <div class="row">
            <aside class="col-md-2 d-flex flex-column justify-content-between align-items-center bg-dark text-light text-center py-4 vh-100 position-fixed">
                <div class="w-100 d-flex flex-column align-items-center gap-3">
                    <img src="../../img/logo.png" alt="logo" class="img-fluid" style="max-width: 80px;">
                    <div class="d-flex flex-column gap-3 w-100">
                        <a href="dashboard.php" class="text-light text-decoration-none">Dashboard</a>
                        <a href="../../admin/users.php" class="text-warning fw-bold fs-4 text-decoration-none">Users</a>
                        <a href="../../admin/courses.php" class="text-light text-decoration-none">Courses</a>
                        <a href="../../admin/order.php" class="text-light text-decoration-none">Orders</a>
                    </div>
                </div>
                <a class="text-danger text-decoration-none fw-bold" href="../logout.php">Logout</a>
            </aside>

            <div class="col-md-10 offset-md-2">
                <div class="container py-4">
                    <div class="row justify-content-center">
                        <div class="col-md-4 bg-white p-4 rounded shadow-lg mt-4 text-center">
                            <h2 class="mb-3 text-dark">Edit User</h2>
                            <?php echo $message; ?>

                            <form action="edit-user.php?user_id=<?php echo $user_id; ?>" method="POST">
                                <div class="mb-3 d-flex gap-2">
                                    <input type="text" class="form-control border-0 border-bottom" name="first_name" required value="<?php echo htmlspecialchars($user['first_name']); ?>">
                                    <input type="text" class="form-control border-0 border-bottom" name="last_name" required value="<?php echo htmlspecialchars($user['last_name']); ?>">
                                </div>

                                <div class="mb-3">
                                    <input type="text" name="contact" class="form-control border-0 border-bottom" required value="<?php echo htmlspecialchars($user['contact']); ?>">
                                </div>

                                <div class="mb-3">
                                    <input type="email" name="email" class="form-control border-0 border-bottom" required value="<?php echo htmlspecialchars($user['email']); ?>">
                                </div>

                                <div class="mb-3">
                                    <input type="password" name="password" class="form-control border-0 border-bottom" placeholder="New Password">
                                </div>

                                <div class="mb-3">
                                    <input type="password" name="confirm_password" class="form-control border-0 border-bottom" placeholder="Retype Password">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-dark">Account Type:</label>
                                    <select name="is_admin" class="form-select border-0 border-bottom">
                                        <option value="1" <?php echo ($user['is_admin'] == 1) ? 'selected' : ''; ?>>Admin</option>
                                        <option value="0" <?php echo ($user['is_admin'] == 0) ? 'selected' : ''; ?>>User</option>
                                    </select>
                                </div>

                                <button type="submit" name="update_user" class="btn btn-dark w-100 fw-bold">Update User</button>
                            </form>

                            <p class="mt-5"><a href="users.php">Back to Users</a></p>
                        </div>
                    </div>
                </div>
</main>



<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>