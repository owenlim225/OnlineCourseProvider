<?php
session_start();
include("../func/connections.php");

// Update cart badge on page load
if (isset($_SESSION['user_id'])) {
    updateCartBadge($conn);
}

// Redirect non-logged in users
if (!isset($_SESSION["email"])) {
    header("Location: ../login.php");
    exit();
}

function updateCartBadge($conn) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $query = "SELECT COUNT(*) as cart_count FROM cart WHERE user_id = ? AND is_purchased = 0";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $_SESSION['cart_count'] = $row['cart_count'];
        return $row['cart_count'];
    }
    return 0;
}

// Call this function right after session_start() in your code
if (isset($_SESSION['user_id'])) {
    $cart_count = updateCartBadge($conn);
}

// Ensure user is logged in before querying
if (isset($_SESSION['email'])) {
    $sql = "SELECT first_name FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['first_name'] = $row['first_name'];
    }
}

// function updateCartBadge($conn) {
//     if (isset($_SESSION['user_id'])) {
//         $user_id = $_SESSION['user_id'];
//         $query = "SELECT COUNT(*) as cart_count FROM cart WHERE user_id = ? AND is_purchased = 0";
//         $stmt = $conn->prepare($query);
//         $stmt->bind_param("i", $user_id);
//         $stmt->execute();
//         $result = $stmt->get_result();
//         $row = $result->fetch_assoc();
//         $_SESSION['cart_count'] = $row['cart_count'];
//     }
// }

?>




<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Sherwin P. Limosnero">
    <title>Home</title>
    
    <!-- css file -->
    <link rel="stylesheet" href="../src/style.css">
    <link rel="stylesheet" href="../src/main.css" >
    <link rel="stylesheet" href="../src/hero.css" >
    <link rel="stylesheet" href="../src/call-to-action.css" >

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files PARA maganda sir, sana may plus point sa effort <3 -->
    <link href="../src/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/aos/aos.css" rel="stylesheet">
    <link href="vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  </head>

<body class="body-color index-page">
    
  <!-- Navbar -->
  <?php include 'header.php'; ?>


  <!-- main content -->
  <main class="main pt-5">
    <!-- Full-width container for the welcome message -->
    <div class="container-fluid bg-black pt-5 pb-5 mt-6">
        <div class="row justify-content-center">
            <div class="col-12 text-center">
                <h1 class="text-white">Welcome <?php echo isset($_SESSION["first_name"]) ? htmlspecialchars($_SESSION["first_name"]) : ''; ?>!</h1>
            </div>
        </div>
    </div>


    <!-- Hero Section --> 
    <section id="home" class="container hero section dark-background mt-4 pt-7" style="padding: 2rem; max-width: fit-content;">

    <img src="../img/hero-top.jpg" alt="hero-bg" data-aos="fade-in" class="img-fluid w-100 d-block" data-aos="fade-up" data-aos-delay="100">

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

        <img src="../img/gdc-logo.png" alt="" width="80" height="80" class="img-fluid">

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
    <!-- <section id="stats" style="background-color: #0e0f0f">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="position-relative w-100 py-5" style="background-color:rgb(26, 28, 28);"> -->
          <!-- Decorative Borders -->
          <!-- <span class="position-absolute top-0 bottom-0 start-0 end-0 pointer-events-none"> -->
            <!-- Left border -->
            <!-- <div class="position-absolute top-0 bottom-0 start-0 d-flex align-items-center">
              <div style="width: 2px; height: calc(100% - 68px); background-color: #686868;"></div>
            </div> -->
            <!-- Top border -->
            <!-- <div class="position-absolute top-0 start-0 end-0 d-flex justify-content-center">
              <div style="height: 2px; width: calc(100% - 68px); background-color: #686868;"></div>
            </div> -->
            <!-- Right border -->
            <!-- <div class="position-absolute top-0 bottom-0 end-0 d-flex align-items-center">
              <div style="width: 2px; height: calc(100% - 68px); background-color: #686868;"></div>
            </div> -->
            <!-- Bottom border -->
            <!-- <div class="position-absolute bottom-0 start-0 end-0 d-flex justify-content-center">
              <div style="height: 2px; width: calc(100% - 68px); background-color:#686868;"></div>
            </div> -->

            <!-- Corner SVGs -->
            <!-- <svg class="position-absolute top-0 start-0" width="35" height="35" viewBox="0 0 35 35" fill="#686868" xmlns="http://www.w3.org/2000/svg">
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
          </span> -->

          <!-- Stats -->
          <!-- <div class="row text-center text-warning">
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
    </section> -->

    <!-- Mga picture ng tropa para maangas CTO -->
    <!-- <section id="aboutus" class="container section" style="background-color: #0e0f0f">
      <div class="row "> -->

          <!-- #1 -->
          <!-- <div class="container call-to-action-2 " data-aos="fade-up" data-aos-delay="100">
            <div class="advertise-1 d-flex flex-column flex-lg-row gap-4 align-items-center position-relative p-5">
              <div class="content-left flex-grow-1" data-aos="fade-right" data-aos-delay="200">
                <span class="badge text-uppercase mb-2">Don't Miss</span>
                <h2 class="text-white">Create irresistible eye-popping games</h2>
                <p class="my-4">Master 2D & 3D game art to make stunning creations. Stop labelling yourself as a "bad artist" and learn this fundamental pillar.</p> -->

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
                </div> 
              </div> -->

              <!-- <div class="content-right position-relative" data-aos="fade-left" data-aos-delay="300" style="height: 400px;">
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
          </div> -->

          <!-- #2 -->
          <!-- <div class="container call-to-action-2 gy-5" data-aos="fade-up" data-aos-delay="100">
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
          </div> -->

      
          <!-- #3 -->
          <!-- <div class="container col-12 call-to-action-2 gy-5" data-aos="fade-up" data-aos-delay="100">
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
    </section> -->

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
                    $course_id = $row['course_id'];
                    $already_purchased = false;
                    
                    // Check if user is logged in and if they've already purchased this course
                    if (isset($_SESSION['user_id'])) {
                        $user_id = $_SESSION['user_id'];
                        $purchase_check = "SELECT * FROM purchased_courses WHERE user_id = ? AND course_id = ?";
                        $stmt = $conn->prepare($purchase_check);
                        $stmt->bind_param("ii", $user_id, $course_id);
                        $stmt->execute();
                        $purchase_result = $stmt->get_result();
                        $already_purchased = ($purchase_result->num_rows > 0);
                    }
                    
                    echo "<div class='col-lg-4 col-md-6' data-aos='fade-up' data-aos-delay='100'>
                            <div class='service-item position-relative d-flex flex-column h-100'>
                                <div class='mb-3'>
                                    <img src='../img/courses/{$row['image']}' alt='{$row['course_title']}' class='img-fluid rounded' style='width: 100%; height: 200px; object-fit: cover;'>
                                </div>

                                <div class='card-body text-center d-flex flex-column flex-grow-1'>
                                    <h5 class='card-title fw-bold'>{$row['course_title']}</h5>
                                    <p class='card-text text-muted fw-bold m-2' style='font-size: 12px;'>{$row['instructor']}</p>
                                    
                                    <div class='description-container' style='height: 80px; overflow: hidden; margin-bottom: 10px;'>
                                        <p class='card-text text-muted m-2' style='font-size: 16px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;'>
                                            {$row['description']}
                                        </p>
                                    </div>
                                    
                                    <p class='card-text fw-bold mt-auto m-3 p-2' style='font-size: 18px;'>₱" . number_format($row['price'], 2) . "</p>";
                                    
                                    // Show "Purchased" badge if already purchased
                                    if ($already_purchased) {
                                        echo "<span class='badge bg-success mb-2'>Already Purchased</span>";
                                    }
                                    
                                echo "</div>

                                <div class='button-container p-3 mt-auto border-top'>
                                    <div class='d-flex justify-content-center gap-2'>";
                                    
                                    if ($already_purchased) {
                                        // If already purchased, show "View Course" button instead of "Buy"
                                        echo "<a href='home.php' class='btn btn-sm btn-primary py-2 px-5'>View Course</a>";
                                    } else {
                                        // If not purchased, show normal buttons
                                        echo "<button type='button' class='btn btn-sm btn-success py-2 px-5' ";
                                        echo ($already_purchased) ? "data-bs-toggle='modal' data-bs-target='#alreadyPurchasedModal{$row['course_id']}'" : "onclick=\"window.location.href='checkout.php?course_id={$row['course_id']}'\"";
                                        echo ">Buy</button>";
                                        
                                        echo "<form class='add-to-cart-form'>
                                            <input type='hidden' name='course_id' value='{$row['course_id']}'>
                                            <button type='submit' name='add_to_cart' class='btn btn-sm btn-outline-danger py-2 px-3' ";
                                        echo ($already_purchased) ? "disabled" : "";
                                        echo ">
                                                <i class='fa-solid fa-cart-shopping'></i>
                                            </button>
                                        </form>";
                                    }
                                    
                                    echo "</div>
                                </div>
                            </div>";
                            
                            // Modal for already purchased notification
                            if ($already_purchased) {
                                echo "<div class='modal fade' id='alreadyPurchasedModal{$row['course_id']}' tabindex='-1' aria-labelledby='alreadyPurchasedModalLabel{$row['course_id']}' aria-hidden='true'>
                                    <div class='modal-dialog'>
                                        <div class='modal-content'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title' id='alreadyPurchasedModalLabel{$row['course_id']}'>Course Already Purchased</h5>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                            </div>
                                            <div class='modal-body'>
                                                <p>You have already purchased the course \"{$row['course_title']}\". You can access it in your purchased courses.</p>
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                                <a href='home.php' class='btn btn-primary'>View Course</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                            }
                            
                        echo "</div>";
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
          </div>
        </div>
      </div>
    </section>
</main>


<?php include 'footer.php'; ?>

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
<script src="../js/main.js"></script>


<script>
    document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function() {
        let courseId = this.getAttribute('data-course-id');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "add-to-cart.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("cart-message").innerHTML = xhr.responseText;
            }
        };

        xhr.send("course_id=" + courseId);
    });
});
</script>

<!-- Dynamically update cart number -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    updateCartBadge(); // Fetch cart count on page load

    function updateCartBadge() {
        fetch('../func/user/get-cart-count.php')
            .then(response => response.json())
            .then(data => {
                const cartBadge = document.getElementById('cartBadge');
                if (cartBadge) {
                    cartBadge.textContent = data.cart_count;
                    cartBadge.style.display = data.cart_count > 0 ? 'inline-block' : 'none';
                }
            })
            .catch(error => console.error('Error fetching cart count:', error));
    }
});

</script>


<!-- JavaScript for displaying notifications -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle add to cart forms
    const addToCartForms = document.querySelectorAll('.add-to-cart-form');
    
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const courseId = this.querySelector('input[name="course_id"]').value;
            const submitButton = this.querySelector('button[type="submit"]');
            
            // Temporarily disable button and add spinner
            const originalButtonContent = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
            
            // Create form data
            const formData = new FormData();
            formData.append('course_id', courseId);
            
            // Make AJAX request
            fetch('../func/user/add-to-cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Show toast notification
                showToast(data.type, data.message);
                
                // Update cart badge if available
                const cartBadges = document.querySelectorAll('.cart-badge');
                if (cartBadges.length > 0 && data.cart_count) {
                    cartBadges.forEach(badge => {
                        badge.textContent = data.cart_count;
                        badge.style.display = data.cart_count > 0 ? 'inline-block' : 'none';
                    });
                }
                
                // Re-enable button and restore original content
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonContent;
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('error', 'An error occurred. Please try again.');
                
                // Re-enable button and restore original content
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonContent;
            });
        });
    });
});

// Toast notification function
function showToast(type, message) {
    const container = document.getElementById('toastContainer');
    if (!container) {
        // Create container if it doesn't exist
        const newContainer = document.createElement('div');
        newContainer.id = 'toastContainer';
        newContainer.style.position = 'fixed';
        newContainer.style.bottom = '60px';
        newContainer.style.right = '20px';
        newContainer.style.zIndex = '9999';
        document.body.appendChild(newContainer);
    }
    
    const toastContainer = document.getElementById('toastContainer');
    
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'toast show';
    toast.style.minWidth = '250px'; 
    
    // Set color based on type
    let bgColor, textColor, icon;
    switch(type) {
        case 'success':
            bgColor = '#4CAF50';
            textColor = 'white';
            icon = '<i class="fa-solid fa-check-circle"></i>';
            break;
        case 'warning':
            bgColor = '#FF9800';
            textColor = 'white';
            icon = '<i class="fa-solid fa-exclamation-triangle"></i>';
            break;
        case 'error':
            bgColor = '#F44336';
            textColor = 'white';
            icon = '<i class="fa-solid fa-times-circle"></i>';
            break;
        default:
            bgColor = '#2196F3';
            textColor = 'white';
            icon = '<i class="fa-solid fa-info-circle"></i>';
    }
    
    toast.style.backgroundColor = bgColor;
    toast.style.color = textColor;
    toast.style.borderRadius = '4px';
    toast.style.padding = '15px';
    toast.style.marginBottom = '10px';
    toast.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';
    toast.style.display = 'flex';
    toast.style.alignItems = 'center';
    toast.style.animation = 'fadeIn 0.5s, fadeOut 0.5s 2.5s';
    
    // Set content
    toast.innerHTML = `
        <div style="margin-right: 10px;">${icon}</div>
        <div style="flex-grow: 1;">${message}</div>
        <div style="cursor: pointer; margin-left: 10px;" onclick="this.parentElement.remove()">
            <i class="fa-solid fa-times"></i>
        </div>
    `;
    
    // Add to container
    toastContainer.appendChild(toast);
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>
</body>
</html>