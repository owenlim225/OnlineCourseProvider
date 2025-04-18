<?php 
// Only start a session if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- navbar -->
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
                        <a class="nav-link active" aria-current="page" href="#home"></i>Home</a>
                    </li>
                    <li class="nav-item ms-4">
                        <a class="nav-link" href="#about-me">About me</a>
                    </li>
                    <li class="nav-item ms-4">
                        <a class="nav-link" href="#courses">Courses</a>
                    </li>
                    
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <!-- If the user is logged in -->
                <?php if (isset($_SESSION["user_id"])): ?>
                    <!-- cart button -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../user/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                    </li>
                    <!-- profile button -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../user/profile.php"><i class="fa-solid fa-house"></i></a>
                    </li>
                    <!-- profile button -->
                    <li class="nav-item">
                    <a class="nav-link active text-danger" aria-current="page" href="func/logout.php">Logout</a>
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
