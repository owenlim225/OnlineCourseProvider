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
        $message = "<div class='alert alert-danger d-flex align-items-center' role='alert'><i class='bi bi-exclamation-triangle-fill me-2'></i><div>All fields are required except password.</div></div>";
        $_SESSION['message'] = $message;
        header("Location: register.php");
        exit();
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='alert alert-danger d-flex align-items-center' role='alert'><i class='bi bi-exclamation-triangle-fill me-2'></i><div>Invalid email format.</div></div>";
        $_SESSION['message'] = $message;
        header("Location: register.php");
        exit();
    } elseif (!empty($password) && (strlen($password) < 6 || $password !== $confirm_password)) {
        $message = "<div class='alert alert-danger d-flex align-items-center' role='alert'><i class='bi bi-exclamation-triangle-fill me-2'></i><div>Password must be at least 6 characters and match.</div></div>";
        $_SESSION['message'] = $message;
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
        $message = "<div class='alert alert-danger d-flex align-items-center' role='alert'><i class='bi bi-exclamation-triangle-fill me-2'></i><div>Email already exists.</div></div>";
        $_SESSION['message'] = $message;
        header("Location: register.php");
        exit();
    }

    // Insert user into database
    $sql = "INSERT INTO user (first_name, last_name, contact, email, password, is_admin) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $first_name, $last_name, $contact, $email, $hashed_password, $is_admin);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success d-flex align-items-center' role='alert'><i class='bi bi-check-circle-fill me-2'></i><div>Registered successfully!</div></div>";
        $_SESSION['message'] = $message;
        header("Location: register.php");
        exit; // Always exit after a redirect
    }
    else {
        $message = "<div class='alert alert-danger d-flex align-items-center' role='alert'><i class='bi bi-exclamation-triangle-fill me-2'></i><div>Error adding user: " . $conn->error . "</div></div>";
        $_SESSION['message'] = $message;
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

    <!-- Vendor CSS Files -->
    <link href="src/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
<!-- Navbar -->
<div class="container-fluid p-0">
    <nav id="navbar" class="navbar navbar-expand-lg navbar-dark bg-black bg-opacity-95 fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="img/logo.png" alt="logo" class="fa-custom-logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 me-5">
                    <li class="nav-item ms-4">
                        <a class="nav-link active" aria-current="page" href="index.php"></i>Home</a>
                    </li>
                    <li class="nav-item ms-4">
                        <a class="nav-link" href="index.php#about-me">About me</a>
                    </li>
                    <li class="nav-item ms-4">
                        <a class="nav-link" href="index.php#courses">Courses</a>
                    </li>
                    
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<!-- Register Form -->
<div class="row justify-content-center align-items-center vh-100">
    <div class="col-md-4 col-lg-4 bg-white p-5 rounded-4 shadow-lg text-center">
        <h2 class="mb-4 text-black fw-bold">
            <i class="bi bi-person-plus me-2"></i> Register
        </h2>

        <?php echo $message; ?>

        <form action="register.php" method="POST">
            <!-- First and Last Name -->
            <div class="mb-3 d-flex gap-2 text-start">
                <div class="w-100">
                    <label class="form-label text-black">First Name</label>
                    <input type="text" name="first_name" class="form-control rounded-3 shadow-sm" required placeholder="First Name">
                </div>
                <div class="w-100">
                    <label class="form-label text-black">Last Name</label>
                    <input type="text" name="last_name" class="form-control rounded-3 shadow-sm" required placeholder="Last Name">
                </div>
            </div>

            <!-- Contact -->
            <div class="mb-3 text-start">
                <label class="form-label text-black">Contact Number</label>
                <input type="text" name="contact" class="form-control rounded-3 shadow-sm" required placeholder="e.g. 09XXXXXXXXX" pattern="[0-9]{11}" title="Please enter a valid 11-digit contact number">
            </div>

            <!-- Email -->
            <div class="mb-3 text-start">
                <label class="form-label text-black">Email</label>
                <input type="email" name="email" class="form-control rounded-3 shadow-sm" required placeholder="example@mail.com">
            </div>

            <!-- Password -->
            <div class="mb-3 text-start">
                <label class="form-label text-black">Password</label>
                <input type="password" name="password" class="form-control rounded-3 shadow-sm" required placeholder="Password">
            </div>

            <!-- Confirm Password -->
            <div class="mb-4 text-start">
                <label class="form-label text-black">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control rounded-3 shadow-sm" required placeholder="Retype Password">
            </div>

            <!-- Hidden account type -->
            <input type="hidden" name="account_type" value="0">

            <!-- Submit -->
            <button type="submit" name="register" class="btn btn-dark w-100 fw-bold rounded-pill py-2">
                <i class="bi bi-check2-circle me-1"></i> Register
            </button>
        </form>

        <p class="mt-4 text-black">
            Already have an account? <br>
            <a href="login.php" class="fw-semibold text-decoration-none">Login</a>
        </p>
    </div>
</div>

<!-- footer-->
 <?php include 'src/footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
