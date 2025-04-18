<?php
include("func/connections.php");
session_start();

// Retrieve session message if exists
$message = isset($_SESSION['message']) ? $_SESSION['message'] : "";
unset($_SESSION['message']); // Clear after displaying

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $contact = trim($_POST["contact"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $is_admin = isset($_POST["account_type"]) ? intval($_POST["account_type"]) : 0; // Default: Not Admin

    // Validate fields
    if (empty($first_name) || empty($last_name) || empty($contact) || empty($email)) {
        $_SESSION['message'] = "<div class='error'>⚠️ All fields are required except password.</div>";
        header("Location: register.php");
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "<div class='error'>⚠️ Invalid email format.</div>";
        header("Location: register.php");
        exit();
    } elseif (!empty($password) && (strlen($password) < 6 || $password !== $confirm_password)) {
        $_SESSION['message'] = "<div class='error'>⚠️ Password must be at least 6 characters and match.</div>";
        header("Location: register.php");
        exit();
    }

    // Hash password if provided, otherwise set to NULL
    $hashed_password = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : null;

    // Check if email already exists
    $check_sql = "SELECT user_id FROM user WHERE email = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['message'] = "<div class='error' style='background-color: red; color: white; padding: 10px; border-radius: 5px'>⚠️ Email already exists.</div>";
        header("Location: register.php");
        exit();
    }

    // Insert user into database
    $sql = "INSERT INTO user (first_name, last_name, contact, email, password, is_admin) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $first_name, $last_name, $contact, $email, $hashed_password, $is_admin);

    if ($stmt->execute()) {
        $_SESSION['message'] = "✅ Registered successfully!";
        header("Location: login.php");
        exit; // Always exit after a redirect
    }
    else {
        $_SESSION['message'] = "<div class='error'>⚠️ Error adding user: " . $conn->error . "</div>";
        header("Location: register.php");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- CSS and Bootstrap -->
    <link rel="stylesheet" href="src/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
<!-- Register Form -->
<div class="row justify-content-center d-flex align-items-center vh-100">
    <div class="col-md-4 bg-white p-4 rounded shadow-lg text-center" style="box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); transition: transform 0.3s ease;">
        <h2 class="mb-3 text-dark">Register</h2>
        
        <?php echo $message; ?>

        <form action="register.php" method="POST">
            <div class="mb-3" style="display: flex; gap: 10px;">
                <input type="text" class="form-control border-0 border-bottom" name="first_name" required placeholder="First Name">
                <input type="text" class="form-control border-0 border-bottom" name="last_name" required placeholder="Last Name">
            </div>

            <div class="mb-3">
                <input type="text" name="contact" class="form-control border-0 border-bottom" required placeholder="Contact Number">
            </div>

            <div class="mb-3">
                <input type="email" name="email" class="form-control border-0 border-bottom" required placeholder="Email">
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control border-0 border-bottom" placeholder="Password">
            </div>

            <div class="mb-3">
                <input type="password" name="confirm_password" class="form-control border-0 border-bottom" placeholder="Retype Password">
            </div>

            <!-- Account Type (Hidden if not used in UI) -->
            <input type="hidden" name="account_type" value="0"> 

            <button type="submit" name="register" class="btn btn-dark w-100 fw-bold">Register</button>
        </form>

        <p class="mt-4">Already have an account? <br><a href="login.php">Login</a></p>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
