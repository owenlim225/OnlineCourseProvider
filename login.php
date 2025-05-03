<?php
session_start();
include("func/connections.php");


$message = "";

// received message when first registered
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Clear the message so it doesn't show again on refresh
}
// Handle login request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if user exists and get user information
    $stmt = $conn->prepare("SELECT user_id, email, password, is_admin FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    // If user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $email, $hashed_password, $is_admin);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Set session variables
            $_SESSION["email"] = $email;
            $_SESSION["is_admin"] = $is_admin;
            $_SESSION["user_id"] = $user_id; // Correctly set user_id from the query result

            // Redirect based on admin status
            if ($is_admin == 1) {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: user/home.php");
            }
            exit();
        } else {
            $message = "<div class='error' style='background-color: red; color: white; padding: 10px; border-radius: 5px'>⚠️ Invalid email or password!.</div>";
        }
    } else {
        $message = "<div class='error'>⚠️ Incorrect username or password.</div>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- css file -->
    <link rel="stylesheet" href="src/style.css">

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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

<!-- login -->
<main class="d-flex align-items-center justify-content-center vh-100">
    <div class="col-md-4 col-lg-4 bg-white p-5 rounded-4 shadow-lg text-center">
        <h2 class="mb-4 text-black fw-bold">
            <i class="bi bi-box-arrow-in-right me-2"></i> Login
        </h2>

        <?php echo $message; ?>

        <form method="POST" action="login.php">
            <!-- Email -->
            <div class="mb-3 text-start">
                <label class="form-label text-black">Email</label>
                <input type="email" name="email" class="form-control rounded-3 shadow-sm" required placeholder="example@mail.com">
            </div>

            <!-- Password -->
            <div class="mb-4 text-start">
                <label class="form-label text-black">Password</label>
                <input type="password" name="password" class="form-control rounded-3 shadow-sm" required placeholder="Enter password">
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-dark w-100 fw-bold rounded-pill py-2">
                <i class="bi bi-door-open me-1"></i> Login
            </button>
        </form>

        <p class="mt-4 text-black">
            No account?<br>
            <a href="register.php" class="fw-semibold text-decoration-none">Sign up</a>
        </p>
    </div>
</main>


<!-- Footer -->
<?php include 'src/footer.php'; ?>

<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>