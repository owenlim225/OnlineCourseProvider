<!-- navbar -->
<div class="container-fluid p-0">
    <nav id="navbar" class="navbar navbar-expand-lg navbar-dark bg-black bg-opacity-95 fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="../img/logo.png" alt="logo" class="fa-custom-logo"></a>
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
                        <a class="nav-link active position-relative" aria-current="page" href="cart.php">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span id="cartBadge" class="cart-badge badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle" <?php echo (isset($_SESSION['cart_count']) && $_SESSION['cart_count'] > 0) ? '' : 'style="display: none;"'; ?>>
                                <?php echo isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : '0'; ?>
                            </span>
                        </a>
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