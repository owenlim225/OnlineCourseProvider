<?php
session_start();
include("func/connections.php");
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Sherwin P. Limosnero">
    <title>GameDev Master</title>
    
    <!-- css file -->
    <link rel="stylesheet" href="src/style.css">
    <link rel="stylesheet" href="src/main.css" >
    <link rel="stylesheet" href="src/hero.css" >
    <link rel="stylesheet" href="src/devs.css" >
    <link rel="stylesheet" href="src/call-to-action.css" >

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files PARA maganda sir, sana may plus point sa effort <3 -->
    <link href="src/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/aos/aos.css" rel="stylesheet">
    <link href="vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  </head>


  
<body class="body-color index-page">
    
<!-- navbar -->
  <div class="container-fluid p-0">
    <nav id="navbar" class="navbar navbar-expand-lg navbar-dark bg-black bg-opacity-95 fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="img/gdc-logo.png" alt="logo" class="fa-custom-logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 me-5">
                    <li class="nav-item ms-4">
                        <a class="nav-link" aria-current="page" href="index.php"></i>Home</a>
                    </li>
                    <li class="nav-item ms-4">
                        <a class="nav-link" href="index.php#learnmore">Learn More</a>
                    </li>
                    <li class="nav-item ms-4">
                        <a class="nav-link active" href="aboutus.php">About us</a>
                    </li>
                    <!-- <li class="nav-item ms-4">
                        <a class="nav-link" href="#stats">Stats</a>
                    </li> -->
                    <li class="nav-item ms-4">
                        <a class="nav-link" href="index.php#courses">Courses</a>
                    </li>
                    
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <!-- If the user is logged in -->
                <?php if (isset($_SESSION["user_id"])): ?>
                    <!-- cart button -->
                    <li class="nav-item ms-4">
                        <a class="nav-link active" aria-current="page" href="../user/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                    </li>
                    <!-- profile button -->
                    <li class="nav-item ms-4">
                        <a class="nav-link active" aria-current="page" href="../user/profile.php"><i class="fa-solid fa-house"></i></a>
                    </li>
                    <!-- profile button -->
                    <li class="nav-item ms-4">
                    <a class="nav-link active text-danger" aria-current="page" href="func/logout.php">Logout</a>
                    </li>

                <!-- If the user is not logged in -->
                <?php else: ?>
                    <li class="nav-item ms-4">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                    <li class="nav-item ms-4">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                <?php endif; ?>
                </ul>
        </div>
    </nav>
</div>


<!-- main content -->
<main class="main pt-5">

  <div class="container text-center my-2" data-aos="fade-up" data-aos-delay="200">
    <div class="row py-3 mt-5 d-flex justify-content-center">
      <div class="col-12 ">
        
        <!-- row 1 -->
        <div class="mb-3">
          <!-- Frame container for devs -->
          <div class="position-relative image-frame">
          
            <!-- Decorative Borders -->
            <span class="position-absolute top-0 bottom-0 start-0 end-0 pointer-events-none">
              <!-- Left border -->
              <div class="position-absolute top-0 bottom-0 start-0 d-flex align-items-center">
                <div class="border-line vertical"></div>
              </div>
              <!-- Top border -->
              <div class="position-absolute top-0 start-0 end-0 d-flex justify-content-center">
                <div class="border-line horizontal"></div>
              </div>
              <!-- Right border -->
              <div class="position-absolute top-0 bottom-0 end-0 d-flex align-items-center">
                <div class="border-line vertical"></div>
              </div>
              <!-- Bottom border -->
              <div class="position-absolute bottom-0 start-0 end-0 d-flex justify-content-center">
                <div class="border-line horizontal"></div>
              </div>

              <!-- Corner SVGs -->
              <svg class="corner top-0 start-0" width="35" height="35" viewBox="0 0 35 35" fill="#686868" xmlns="http://www.w3.org/2000/svg">
                <path d="M2 35H0V18.988L18.988 0H35v2H20L2 20v15ZM14.7 0 0 14.7V0h14.7ZM6.387 6.388V.875L.875 6.388h5.513Z"/>
              </svg>
              <svg class="corner bottom-0 start-0" style="transform: rotate(-90deg);" width="35" height="35" viewBox="0 0 35 35" fill="#686868">
                <path d="M2 35H0V18.988L18.988 0H35v2H20L2 20v15ZM14.7 0 0 14.7V0h14.7ZM6.387 6.388V.875L.875 6.388h5.513Z"/>
              </svg>
              <svg class="corner top-0 end-0" style="transform: rotate(90deg);" width="35" height="35" viewBox="0 0 35 35" fill="#686868">
                <path d="M2 35H0V18.988L18.988 0H35v2H20L2 20v15ZM14.7 0 0 14.7V0h14.7ZM6.387 6.388V.875L.875 6.388h5.513Z"/>
              </svg>
              <svg class="corner bottom-0 end-0" style="transform: rotate(180deg);" width="35" height="35" viewBox="0 0 35 35" fill="#686868">
                <path d="M2 35H0V18.988L18.988 0H35v2H20L2 20v15ZM14.7 0 0 14.7V0h14.7ZM6.387 6.388V.875L.875 6.388h5.513Z"/>
              </svg>
            </span>

            <!-- Image -->
            <div class="container my-5">
              <div class="position-relative mx-auto dev-container" style="max-width: 800px;">

                <!-- Base Image -->
                <img src="img/devs.jpg" alt="Developers" class="img-fluid w-100">

                <!-- Left Half -->
                <div class="hover-area left-area"></div>

                <!-- Right Half -->
                <div class="hover-area right-area"></div>

                <!-- Left Overlay - Sherwin -->
                <div class="dark-overlay left-overlay d-flex flex-column justify-content-center align-items-center text-center p-4">
                  <div>
                    <h3 class="text-warning fw-bold mb-2 fs-4 fs-md-2">Sherwin Limosnero</h3>
                    <p class="text-light fs-6 fs-md-5 mb-0">Front-end Developer</p>
                  </div>
                </div>

                <!-- Right Overlay - Christian -->
                <div class="dark-overlay right-overlay d-flex flex-column justify-content-center align-items-center text-center p-4">
                  <div>
                    <h3 class="text-warning fw-bold mb-2 fs-4 fs-md-2">Christian Jude Villaber</h3>
                    <p class="text-light fs-6 fs-md-5 mb-0">Back-end Developer</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- row 2 -->
        <div class="mb-3">
          <!-- line breaker -->
          <div class="container my-3">
            <div class="text-center">
              <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                <!-- line -->
                <div class="flex-grow-1 border-top border-white opacity-50"></div>

                <h2 class="fw-semibold text-white m-0" style="font-size: 2.5rem;">
                  Meet our <span class="text-warning"><i>Developers</i></span>
                </h2>
                
                <!-- line -->
                <div class="flex-grow-1 border-top border-white opacity-50"></div>
              </div>

              <p class="text-secondary fs-5 mb-0">Two-man team with a dream.</p>
            </div>
          </div>
        </div>
      </div>
  </div>

</div>
</main>



<!-- Footer -->
<?php include 'src/footer.php'; ?>

<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center" style="background-color: #f0ad4e; color: #0e0f0f;"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<!-- <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
<script src="vendor/php-email-form/validate.js"></script>
<script src="vendor/aos/aos.js"></script>
<script src="vendor/swiper/swiper-bundle.min.js"></script>
<script src="vendor/purecounter/purecounter_vanilla.js"></script>
<script src="vendor/glightbox/js/glightbox.min.js"></script>

<!-- Main JS File -->
<script src="js/main.js"></script>

</body>
</html>