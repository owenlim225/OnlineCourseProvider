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
    <title>Sherwin Limosnero</title>
    
    <!-- css file -->
    <link rel="stylesheet" href="src/style.css">
    <link rel="stylesheet" href="src/main.css" >
    <link rel="stylesheet" href="src/hero.css" >
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
    
<!-- Navbar -->
<?php include 'src/header.php'; ?>


<!-- main content -->
<main class="main pt-5">
 

<!-- Hero Section --> 
<section id="home" class="container hero section dark-background mt-4 pt-7" style="padding: 2rem; max-width: fit-content;">

<img src="img/hero-top.jpg" alt="hero-bg" data-aos="fade-in" class="img-fluid w-100 d-block" data-aos="fade-up" data-aos-delay="100">

  <div class="container" style="padding: 1rem; max-width: fit-content;" data-aos="fade-up" data-aos-delay="100">
    <div class="row col-12 col-md-6 col-lg-5">
      <div class="px-5 px-md-4 px-lg-5">
        <div class="w-100">
          <h4 class="fw-bold">START YOUR GAME DEV JOURNEY</h4>
          <div class="promo-subheading text-warning">DISCOVER OUR SECRET ROADMAP TO TURN YOUR PASSION INTO PROFIT.</div>
          <div class="promo-text">
            <span class="highlight">Learn how to make games, build your portfolio, and start earning—on your own time, from anywhere.</span>
            <div class="turn-career">Join thousands of aspiring game developers taking the first step today.</div>
            <a href="#courses"><button class="btn-donate">Enroll Now!</button></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- line breaker -->

<div class="container">
  <div class="position-relative d-flex align-items-center gap-3 gap-md-5 mt-5 mb-md-5">
    <div class="flex-grow-1 border-top border-white opacity-50"></div>

    <img src="img/gdc-logo.png" alt="" width="80" height="80" class="img-fluid">

    <div class="flex-grow-1 border-top border-white opacity-50"></div>
  </div>
</div>

<div class="col-12 text-center my-5" data-aos="fade-up" data-aos-delay="200">
  <h2 class="fw-semibold text-white display-4 display-md-3 display-lg-2" style="word-break: break-word;">
    We've Buffed <span class="text-warning"><i>2 Million+</i></span> Aspiring Game Devs
  </h2>
</div>

<div class="col-12 text-center mb-4" data-aos="fade-up" data-aos-delay="300">
  <span class="text-secondary fs-5 fs-md-4">
    With courses in Unreal, Unity, Godot, Blender, and more, we've got you covered.
  </span>
</div>

<!-- box with stats -->
<section id="stats" style="background-color: #0e0f0f">
 <div class="container" data-aos="fade-up" data-aos-delay="100">
  <div class="position-relative w-100 py-5" style="background-color:rgb(26, 28, 28);">
    <!-- Decorative Borders -->
    <span class="position-absolute top-0 bottom-0 start-0 end-0 pointer-events-none">
      <!-- Left border -->
      <div class="position-absolute top-0 bottom-0 start-0 d-flex align-items-center">
        <div style="width: 2px; height: calc(100% - 68px); background-color: #686868;"></div>
      </div>
      <!-- Top border -->
      <div class="position-absolute top-0 start-0 end-0 d-flex justify-content-center">
        <div style="height: 2px; width: calc(100% - 68px); background-color: #686868;"></div>
      </div>
      <!-- Right border -->
      <div class="position-absolute top-0 bottom-0 end-0 d-flex align-items-center">
        <div style="width: 2px; height: calc(100% - 68px); background-color: #686868;"></div>
      </div>
      <!-- Bottom border -->
      <div class="position-absolute bottom-0 start-0 end-0 d-flex justify-content-center">
        <div style="height: 2px; width: calc(100% - 68px); background-color:#686868;"></div>
      </div>

      <!-- Corner SVGs -->
      <svg class="position-absolute top-0 start-0" width="35" height="35" viewBox="0 0 35 35" fill="#686868" xmlns="http://www.w3.org/2000/svg">
        <path d="M2 35H0V18.988L18.988 0H35v2H20L2 20v15ZM14.7 0 0 14.7V0h14.7ZM6.387 6.388V.875L.875 6.388h5.513Z"/>
      </svg>
      <svg class="position-absolute bottom-0 start-0" style="transform: rotate(-90deg);" width="35" height="35" viewBox="0 0 35 35" fill="#686868">
        <path d="M2 35H0V18.988L18.988 0H35v2H20L2 20v15ZM14.7 0 0 14.7V0h14.7ZM6.387 6.388V.875L.875 6.388h5.513Z"/>
      </svg>
      <svg class="position-absolute top-0 end-0" style="transform: rotate(90deg);" width="35" height="35" viewBox="0 0 35 35" fill="#686868">
        <path d="M2 35H0V18.988L18.988 0H35v2H20L2 20v15ZM14.7 0 0 14.7V0h14.7ZM6.387 6.388V.875L.875 6.388h5.513Z"/>
      </svg>
      <svg class="position-absolute bottom-0 end-0" style="transform: rotate(180deg);" width="35" height="35" viewBox="0 0 35 35" fill="#686868">
        <path d="M2 35H0V18.988L18.988 0H35v2H20L2 20v15ZM14.7 0 0 14.7V0h14.7ZM6.387 6.388V.875L.875 6.388h5.513Z"/>
      </svg>
    </span>

    <!-- Stats -->
    <div class="row text-center text-warning">
      <div class="col-md-4 mb-4 mb-md-0">
        <div class="fw-bold display-4">10+</div>
        <div class="mt-3 small fw-semibold">Courses & Tutorials</div>
      </div>
      <div class="col-md-4 mb-4 mb-md-0">
        <div class="fw-bold display-4">1.2M+</div>
        <div class="mt-3 small fw-semibold">Active Students</div>
      </div>
      <div class="col-md-4">
        <div class="fw-bold display-4">800+</div>
        <div class="mt-3 small fw-semibold">Games Developed</div>
      </div>
    </div>
</div>
 </section>

<!-- Mga picture ng tropa para maangas CTO -->
<section id="aboutus" class="container section" style="background-color: #0e0f0f">
  <div class="row ">

      <!-- #1 -->
      <div class="container call-to-action-2 " data-aos="fade-up" data-aos-delay="100">
        <div class="advertise-1 d-flex flex-column flex-lg-row gap-4 align-items-center position-relative p-5">
          <div class="content-left flex-grow-1" data-aos="fade-right" data-aos-delay="200">
            <span class="badge text-uppercase mb-2">Don't Miss</span>
            <h2 class="text-white">Create irresistible eye-popping games</h2>
            <p class="my-4">Master 2D & 3D game art to make stunning creations. Stop labelling yourself as a "bad artist" and learn this fundamental pillar.</p>

            <!-- <div class="features d-flex flex-wrap gap-3 mb-4">
              <div class="feature-item">
                <i class="bi bi-check-circle-fill"></i>
                <span>Premium Support</span>
              </div>
              <div class="feature-item">
                <i class="bi bi-check-circle-fill"></i>
                <span>Cloud Integration</span>
              </div>
              <div class="feature-item">
                <i class="bi bi-check-circle-fill"></i>
                <span>Real-time Analytics</span>
              </div>
            </div> -->

            <!-- <div class="cta-buttons d-flex flex-wrap gap-3">
              <a href="#" class="btn btn-primary">Start Free Trial</a>
              <a href="#" class="btn btn-outline">Learn More</a>
            </div> -->
          </div>

          <div class="content-right position-relative" data-aos="fade-left" data-aos-delay="300" style="height: 400px;">
            <img src="img/blogs/img5.jpg" style="height: 100%; width: auto; object-fit: contain;" alt="Digital Platform" class="img-fluid rounded-4">
            <div class="floating-card">
              <div class="card-icon">
                <i class="bi bi-graph-up-arrow"></i>
              </div>
              <div class="card-content">
                <span class="stats-number">90% Discount</span>
                <span class="stats-text">For UPHSL Students</span>
              </div>
            </div>
          </div>


          <div class="decoration">
            <div class="circle-1"></div>
            <div class="circle-2"></div>
          </div>
        </div>
      </div>

      <!-- #2 -->
      <div class="container call-to-action-2 gy-5" data-aos="fade-up" data-aos-delay="100">
        <div class="advertise-1 d-flex flex-column flex-lg-row gap-4 align-items-center position-relative p-5">

          <div class="col-auto d-flex align-items-center" data-aos="fade-left" data-aos-delay="300">
            <img src="img/blogs/img1.jpg" style="height: 200px; width: auto; object-fit: contain;" alt="Digital Platform" class="img-fluid rounded-4">
          </div>

          <div class="col-auto d-flex align-items-center" data-aos="fade-left" data-aos-delay="300">
            <img src="img/blogs/img2.jpg" style="height: 200px; width: auto; object-fit: contain;" alt="Digital Platform" class="img-fluid rounded-4">
          </div>

          <div class="content-right flex-grow-1" data-aos="fade-right" data-aos-delay="200">
            <span class="badge text-uppercase mb-2 text-warning">Must have!</span>
            <h2 class="text-white">Code whatever you can imagine</h2>
            <p class="my-4">Learn game programming in c# so that you can bring your imagination to life. Have the freedom and confidence to make anything.</p>
          </div>



          <div class="decoration">
            <div class="circle-1"></div>
            <div class="circle-2"></div>
          </div>
        </div>
      </div>

   
      <!-- #3 -->
      <div class="container col-12 call-to-action-2 gy-5" data-aos="fade-up" data-aos-delay="100">
        <div class="advertise-1 d-flex flex-column flex-lg-row gap-4 align-items-center position-relative p-5">

        
          <div class="content-left flex-grow-1" data-aos="fade-right" data-aos-delay="200">
            <span class="badge text-uppercase mb-2 text-danger">Limited Offer!</span>
            <h2 class="text-white">Build an audience & market your games</h2>
            <p class="my-4">Making fun and beautiful games is not enough. You need to learn how to build a following and market your game to make money.</p>
          </div>

          <div class="col-auto d-flex align-items-center" data-aos="fade-left" data-aos-delay="300">
            <img src="img/blogs/img3.jpg" style="height: 200px; width: auto; object-fit: contain;" alt="Digital Platform" class="img-fluid rounded-4">
          </div>

          <div class="col-auto d-flex align-items-center" data-aos="fade-left" data-aos-delay="300">
            <img src="img/blogs/img4.jpg" style="height: 200px; width: auto; object-fit: contain;" alt="Digital Platform" class="img-fluid rounded-4">
          </div>




          <div class="decoration">
            <div class="circle-1"></div>
            <div class="circle-2"></div>
          </div>
        </div>
      </div>


  </div>
</section>


<!-- courses Section -->
  <section id="courses" class="services section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
      <h2>Courses</h2>
      <p>Explore our wide range of courses designed to enhance your skills and knowledge in various domains.</p>
    </div><!-- End Section Title -->

    <div class="container">
      <div class="row gy-4">
        <?php
            // Fetch courses
            $sql = "SELECT * FROM courses";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {  
                echo "<div class='col-lg-4 col-md-6' data-aos='fade-up' data-aos-delay='100'>
                        <div class='service-item position-relative'>
                            <div class='mb-3'>
                                <img src='img/courses/{$row['image']}' alt='{$row['course_title']}' class='img-fluid rounded' style='width: 100%; height: 200px; object-fit: cover;'>
                            </div>

                            <div class='card-body text-center'>
                                <h5 class='card-title fw-bold'>{$row['course_title']}</h5>
                                <p class='card-text text-muted fw-bold m-2' style='font-size: 12px;'>{$row['instructor']}</p>
                                <p class='card-text text-muted m-2' style='font-size: 16px;'>
                                    {$row['description']}
                                </p>
                                <p class='card-text fw-bold' style='font-size: 18px;'>₱" . number_format($row['price'], 2) . "</p>

                                <div class='m-4'>
                                  <a href='login.php' class='btn btn-sm btn-success py-2 px-5'>Buy</a>
                                  <a href='login.php' class='btn btn-sm btn-outline-danger py-2 px-3'>
                                      <i class='fa-solid fa-cart-shopping'></i>
                                  </a>
                                  

                                </div>
                            </div>
                        </div>
                      </div>";
                }
            } else {
                echo "<p class='text-center text-muted'>No courses found.</p>";
            }
        ?>
      </div>
    </div>
  </section>



  <!-- box with stats -->
<section id="stats" style="background-color: #0e0f0f">
 <div class="container" data-aos="fade-up" data-aos-delay="100">
  <div class="position-relative w-100 py-5" style="background-color:rgb(26, 28, 28);">
    <!-- Decorative Borders -->
    <span class="position-absolute top-0 bottom-0 start-0 end-0 pointer-events-none">
      <!-- Left border -->
      <div class="position-absolute top-0 bottom-0 start-0 d-flex align-items-center">
        <div style="width: 2px; height: calc(100% - 68px); background-color: #686868;"></div>
      </div>
      <!-- Top border -->
      <div class="position-absolute top-0 start-0 end-0 d-flex justify-content-center">
        <div style="height: 2px; width: calc(100% - 68px); background-color: #686868;"></div>
      </div>
      <!-- Right border -->
      <div class="position-absolute top-0 bottom-0 end-0 d-flex align-items-center">
        <div style="width: 2px; height: calc(100% - 68px); background-color: #686868;"></div>
      </div>
      <!-- Bottom border -->
      <div class="position-absolute bottom-0 start-0 end-0 d-flex justify-content-center">
        <div style="height: 2px; width: calc(100% - 68px); background-color:#686868;"></div>
      </div>

      <!-- Corner SVGs -->
      <svg class="position-absolute top-0 start-0" width="35" height="35" viewBox="0 0 35 35" fill="#686868" xmlns="http://www.w3.org/2000/svg">
        <path d="M2 35H0V18.988L18.988 0H35v2H20L2 20v15ZM14.7 0 0 14.7V0h14.7ZM6.387 6.388V.875L.875 6.388h5.513Z"/>
      </svg>
      <svg class="position-absolute bottom-0 start-0" style="transform: rotate(-90deg);" width="35" height="35" viewBox="0 0 35 35" fill="#686868">
        <path d="M2 35H0V18.988L18.988 0H35v2H20L2 20v15ZM14.7 0 0 14.7V0h14.7ZM6.387 6.388V.875L.875 6.388h5.513Z"/>
      </svg>
      <svg class="position-absolute top-0 end-0" style="transform: rotate(90deg);" width="35" height="35" viewBox="0 0 35 35" fill="#686868">
        <path d="M2 35H0V18.988L18.988 0H35v2H20L2 20v15ZM14.7 0 0 14.7V0h14.7ZM6.387 6.388V.875L.875 6.388h5.513Z"/>
      </svg>
      <svg class="position-absolute bottom-0 end-0" style="transform: rotate(180deg);" width="35" height="35" viewBox="0 0 35 35" fill="#686868">
        <path d="M2 35H0V18.988L18.988 0H35v2H20L2 20v15ZM14.7 0 0 14.7V0h14.7ZM6.387 6.388V.875L.875 6.388h5.513Z"/>
      </svg>
    </span>

    <!-- Stats -->
    <div class="row text-center text-warning">
      <div class="col-md-12 mb-4 mb-md-0">
        <div class="fw-bold display-4">What are you waiting for?</div>

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
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/php-email-form/validate.js"></script>
<script src="vendor/aos/aos.js"></script>
<script src="vendor/swiper/swiper-bundle.min.js"></script>
<script src="vendor/purecounter/purecounter_vanilla.js"></script>
<script src="vendor/glightbox/js/glightbox.min.js"></script>

<!-- Main JS File -->
<script src="js/main.js"></script>

</body>
</html>