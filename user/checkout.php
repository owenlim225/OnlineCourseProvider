<?php
session_start();
include("../func/connections.php");

$user_id = isset($_GET["user_id"]) ? intval($_GET["user_id"]) : 0;
$message = "";
$user = null; // Ensure $user is defined

// Ensure user is logged in before querying
if (isset($_SESSION['email'])) {
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['contact'] = $user['contact'];
        $_SESSION['user_id'] = $user['user_id']; // Make sure user_id is stored in session
    }
}

// Get the current user's ID
$current_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Fetch Total Sum of Product Prices for the current user only
$purchase_query = "SELECT COALESCE(SUM(c.price), 0) AS total_price 
                  FROM cart ct
                  JOIN courses c ON ct.course_id = c.course_id
                  WHERE ct.user_id = ?";
                  
$stmt = $conn->prepare($purchase_query);
$stmt->bind_param("i", $current_user_id);
$stmt->execute();
$result = $stmt->get_result();
$total_price = $result->fetch_assoc()['total_price'];



// Load carousel slides data
$preload_count = 3; // Number of slides to preload
$result->data_seek(0);
$count = 0;

while ($row = $result->fetch_assoc() && $count < $preload_count) {
    // Generate slide HTML
    // ...
    $count++;
}

// Store remaining course IDs in JS variable
echo '<script>var remainingCourseIds = [';
while ($row = $result->fetch_assoc()) {
    echo $row['course_id'] . ',';
}
echo '];</script>';
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Sherwin P. Limosnero">
    <title>Checkout</title>
    
    <!-- css file -->
    <link href="../src/style.css" rel="stylesheet">
    <link href="../src/main.css" rel="stylesheet">
    <link href="../src/course-card.css" rel="stylesheet">

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

<!-- payment -->
<main class="main pt-5 mt-3">
    <div class="container py-4">
        <div class="container d-lg-flex align-items-start justify-content-between py-4">
            <!-- Box 1 (courses)-->
            <div class="col-lg-7 bg-light p-4 rounded shadow">
                <!-- main carousel -->
                <div class="mb-3">    
                    
                    <?php
                        // Fetch cart items count - we only need the count initially
                        $user_id = $_SESSION['user_id'];
                        $count_sql = "SELECT COUNT(*) as total_courses 
                                    FROM cart c
                                    JOIN courses cs ON c.course_id = cs.course_id
                                    WHERE c.user_id = $user_id";
                        $count_result = $conn->query($count_sql);
                        $count_row = $count_result->fetch_assoc();
                        $total_courses = $count_row['total_courses'];
                    ?>
                    
                    <div class="d-flex justify-content-between">
                        <p class="fw-bold">Your Course Selection</p>
                    </div>

                    <!-- Carousel -->
                    <div id="my" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="2000">
                        <div class="carousel-indicators">
                            <?php
                                // Generate indicators based on course count
                                for ($i = 0; $i < $total_courses; $i++) {
                                    echo '<button type="button" data-bs-target="#my" data-bs-slide-to="' . $i . '"' . 
                                        ($i == 0 ? ' class="active" aria-current="true"' : '') . '></button>';
                                }
                                
                                // If no courses, show at least one indicator
                                if ($total_courses == 0) {
                                    echo '<button type="button" data-bs-target="#my" data-bs-slide-to="0" class="active" aria-current="true"></button>';
                                }
                            ?>
                        </div>
                        <div class="carousel-inner rounded">
                            <?php if ($total_courses > 0): ?>
                                <?php 
                                // Get all courses for this user
                                $sql = "SELECT c.cart_id, c.user_id, c.course_id, 
                                            cs.course_title, cs.price, cs.image
                                        FROM cart c
                                        JOIN courses cs ON c.course_id = cs.course_id
                                        WHERE c.user_id = $user_id";
                                        
                                $result = $conn->query($sql);
                                $index = 0;
                                
                                // Create carousel items for each course
                                while ($row = $result->fetch_assoc()): 
                                ?>
                                    <div class="carousel-item <?php echo ($index == 0) ? 'active' : ''; ?>">
                                        <?php 
                                            // Display course image or placeholder
                                            $image_src = !empty($row['image']) ? "../img/courses/" . $row['image'] : 'https://via.placeholder.com/800x400?text=Course+Image';
                                        ?>
                                        <img src="<?php echo htmlspecialchars($image_src, ENT_QUOTES, 'UTF-8'); ?>" class="d-block w-100" alt="<?php echo $row['course_title']; ?>">
                                        <div class="carousel-caption d-md-block" style="background-color: rgba(0,0,0,0.5); border-radius: 5px; padding: 10px;">
                                            <h5><?php echo $row['course_title']; ?></h5>
                                            <p class="mb-0">&#8369;<?php echo number_format($row['price'], 2); ?></p>
                                        </div>
                                    </div>
                                <?php 
                                    $index++;
                                endwhile; 
                                ?>
                            <?php else: ?>
                                <!-- No courses case -->
                                <div class="carousel-item active">
                                    <div class="d-flex justify-content-center align-items-center bg-light text-center" style="height: 300px;">
                                        <div>
                                            <p class="fs-4 text-muted">No courses in your cart</p>
                                            <a href="courses.php" class="btn btn-primary">Browse Courses</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if ($total_courses > 1): ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#my" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#my" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                        <?php endif; ?>
                    </div>
                    <p class="mt-3 text-muted">Browse through courses in your cart before checkout.</p>
                </div>
            </div>

            <!-- Box 2 (Payment) -->
            <div class="col-lg-4">
                <div class="row">
                    <!-- first row — Order Summary-->
                    <div class="col-12 bg-white p-4 rounded shadow mt-4">
                        <h3 class="mb-3 fw-bold mb-5">Order Summary</h3>
                        
                        <?php
                        // Fetch cart items with course details using JOIN
                        $user_id = $_SESSION['user_id'];
                        
                        $sql = "SELECT c.cart_id, c.user_id, c.course_id, 
                                    cs.course_title, cs.price, cs.image
                                FROM cart c
                                JOIN courses cs ON c.course_id = cs.course_id
                                WHERE c.user_id = $user_id";
                                
                        $result = $conn->query($sql);
                        
                        if ($result->num_rows > 0) {
                            echo '<div class="mb-3">';
                            while ($row = $result->fetch_assoc()) {  
                                echo '<div class="d-flex justify-content-between mb-2">
                                    <span>' . $row['course_title'] . '</span>
                                    <span class="fw-bold"> &#8369;' . number_format($row['price'], 2) . '</span>
                                </div>';
                            }
                            echo '</div>';
                        } else {
                            echo '<div class="text-center text-muted mb-3">No courses in your cart.</div>';
                        }
                        ?>
                        
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total Amount</span>
                            <span>&#8369;<?php echo number_format($total_price, 2); ?></span>
                        </div>    
                    </div>

                    <!-- second row — Customer Details & Payment Due -->
                    <div class="col-12 bg-white p-4 rounded shadow mt-4">
                        <h3 class="mb-3 fw-bold mb-5">Customer Details</h3>
                        <form method="POST" action="../func/user/process_order.php" class="d-flex flex-column gap-3">
                            <!-- Customer Details -->
                            <div>
                                <div class="mb-3">
                                    <label class="form-label">Full Name *</label>
                                    <input type="text" class="form-control" name="full_name" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" required disabled>

                                    <!-- Hidden input to send the email in POST request -->
                                    <input type="hidden" name="email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Mobile Number *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">+63</span>
                                        <input type="text" class="form-control" name="mobile" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Country *</label>
                                    <input type="text" class="form-control" name="country" required>
                                </div>
                            </div>

                            <!-- Payment Due -->
                            <div>
                                <h6>Select Payment Method</h6>
                                <p class="text-muted">
                                    Payments are secure & payment information is encrypted. The merchant does not store any payment information.
                                </p>

                                <!-- Payment Methods -->
                                <div class="d-flex flex-column gap-3">
                                    <!-- Gcash -->
                                    <label class="w-100 d-flex align-items-center justify-content-between p-2 border rounded bg-white transition" role="button">
                                        <div class="d-flex align-items-center gap-2 flex-grow-1 m-2">
                                            <img alt="Gcash" src="https://cdn.helixpay.ph/images/payment_types/gcash_logo.png" class="payment-type-logo img-fluid" style="max-height: 32px;">
                                        </div>
                                        <input class="form-check-input" value="gcash" name="payment" type="radio" required>
                                    </label> 

                                    <!-- Maya -->
                                    <label class="w-100 d-flex align-items-center justify-content-between p-2 border rounded bg-white transition" role="button">
                                        <div class="d-flex align-items-center gap-2 flex-grow-1 m-2">
                                            <img src="https://cdn.helixpay.ph/images/payment_types/maya_logo.png" alt="PayMaya" class="payment-type-logo img-fluid" style="max-height: 32px;">
                                        </div>
                                        <input class="form-check-input" value="maya" name="payment" type="radio" required>
                                    </label> 

                                    <!-- GrabPay -->
                                    <label class="w-100 d-flex align-items-center justify-content-between p-2 border rounded bg-white transition" role="button">
                                        <div class="d-flex align-items-center gap-2 flex-grow-1 m-2">
                                            <img alt="GrabPay" src="https://cdn.helixpay.ph/images/payment_types/grabpay_logo.png" class="payment-type-logo img-fluid" style="max-height: 32px;">
                                        </div>
                                        <input class="form-check-input" value="grabpay" name="payment" type="radio" required>
                                    </label> 
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" name="pay_now" class="btn btn-primary w-100">Pay now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>



<?php include 'footer.php'; ?>
<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- Add AJAX loading script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to load course data via AJAX
        function loadCourseData(index) {
            // Find the carousel item with this index
            const carouselItem = document.querySelector(`.carousel-item[data-index="${index}"]`);
            
            // Only load if not already loaded
            if (!carouselItem.classList.contains('loaded')) {
                // Create AJAX request
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'get_course_slide.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                
                // Handle response
                xhr.onload = function() {
                    if (this.status === 200) {
                        carouselItem.innerHTML = xhr.responseText;
                        carouselItem.classList.add('loaded');
                    }
                };
                
                // Send request with index and user ID
                xhr.send(`index=${index}&user_id=<?php echo $user_id; ?>`);
            }
        }
        
        // Get the carousel element
        const myCarousel = document.getElementById('my');
        
        // Load first slide immediately
        loadCourseData(0);
        
        // Set up event listener for slide change
        myCarousel.addEventListener('slide.bs.carousel', function(e) {
            // Get the index of the next slide
            const nextIndex = e.to;
            loadCourseData(nextIndex);
            
            // Preload the next slide too for smoother experience
            const nextNextIndex = (nextIndex + 1) % <?php echo max(1, $total_courses); ?>;
            loadCourseData(nextNextIndex);
        });
    });
</script>
</body>
</html>
