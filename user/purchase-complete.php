<?php
session_start();
include("../func/connections.php");
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Sherwin P. Limosnero">
    <title>Purchase Complete!</title>
    
    <!-- css file -->
    <link href="../src/style.css" rel="stylesheet">
    <link href="../src/main.css" rel="stylesheet">
    <link href="../src/course-card.css" rel="stylesheet">
    <link href="../src/check-animation.css" rel="stylesheet">

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../src/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  </head>
<body>

<!-- navbar -->
<div class="container-fluid p-0">
    <nav id="navbar" class="navbar navbar-expand-lg navbar-dark bg-black bg-opacity-95 fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php"><img src="../img/logo.png" alt="logo" class="fa-custom-logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 me-5">
                    <li class="nav-item ms-4">
                        <a class="nav-link active" aria-current="page" href="home.php"></i>Home</a>
                    </li>
                </ul>

                
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <!-- If the user is logged in -->
                <?php if (isset($_SESSION["email"])): ?>
                    <!-- profile button -->
                    <li class="nav-item">
                        <a class="nav-link active text-warning" aria-current="page" href="profile.php">
                            <i>
                                <?php echo isset($_SESSION["first_name"]) ? htmlspecialchars($_SESSION["first_name"]) : 'Profile'; ?>
                            </i>
                        </a>
                    </li>
                    <!-- cart button -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                    </li>
                    <!-- Logout button -->
                    <li class="nav-item">
                    <a class="nav-link active text-danger" aria-current="page" href="../func/logout.php">Logout</a>
                    </li>

                <!-- If the user is not logged in -->
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php endif; ?>
                </ul>
        </div>
    </nav>
</div>


<!-- login -->
<main class="d-flex align-items-center justify-content-center vh-100">
    <div class="col-md-4 bg-white p-4 rounded shadow-lg text-center">
        <h2 class="mb-3 text-dark p-5">Purchase Complete!</h2>

        <div class="success-checkmark">
            <div class="check-icon">
                <span class="icon-line line-tip"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
        </div>


        <p class="mt-4">
            Check your courses! <br>
            <a href="profile.php" class="btn btn-primary w-100 fw-bold my-3">Profile</a>
        </p>
    </div>
</main>



<?php include 'footer.php'; ?>

<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- check animation -->
 <script>
    $("button").click(function () {
  $(".check-icon").hide();
  setTimeout(function () {
    $(".check-icon").show();
  }, 10);
});
 </script>
</body>
</html>