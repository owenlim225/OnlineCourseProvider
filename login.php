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
</head>



<body>

<!-- login -->
<main class="d-flex align-items-center justify-content-center vh-100">
    <div class="col-md-4 bg-white p-4 rounded shadow-lg text-center">
        <h2 class="mb-3 text-dark">Login</h2>

        <?php echo $message; ?>

        <form class="form" method="POST" action="login.php">
            <!-- Email -->
            <div class="mb-3">
                <input type="email" name="email" class="form-control border-0 border-bottom" required placeholder="Email">
            </div>

            <!-- Password -->
            <div class="mb-3">
                <input type="password" name="password" class="form-control border-0 border-bottom" placeholder="Password">
            </div>

            <button type="submit" class="btn btn-dark w-100 fw-bold my-3">Login</button>
        </form>

        <p class="mt-4">
            No account? <br>
            <a href="register.php">Sign up</a>
        </p>
    </div>
</main>





<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>