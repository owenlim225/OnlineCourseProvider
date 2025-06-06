<?php
session_start();
include("../func/connections.php");

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



// Check if Cart is empty to hide the checkout button
$cart_sql = "SELECT COUNT(*) as total FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($cart_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_count = $result->fetch_assoc()['total'] ?? 0;

?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Sherwin P. Limosnero">
    <title>Cart</title>
    
    <!-- css file -->
    <link href="../src/style.css" rel="stylesheet">
    <link href="../src/main.css" rel="stylesheet">

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
            <a class="navbar-brand" href="home.php"><img src="../img/gdc-logo.png" alt="logo" class="fa-custom-logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 me-5">
                    <li class="nav-item ms-4">
                        <a class="nav-link" aria-current="page" href="home.php"></i>Home</a>
                    </li>
                    <li class="nav-item ms-4">
                        <a class="nav-link" href="home.php#courses">Courses</a>
                    </li>
                </ul>

                
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <!-- If the user is logged in -->
                <?php if (isset($_SESSION["email"])): ?>

                    <!-- profile button -->
                    <li class="nav-item ms-4">
                        <a class="nav-link active text-warning" aria-current="page" href="profile.php">
                            <i>
                                <?php echo isset($_SESSION["first_name"]) ? htmlspecialchars($_SESSION["first_name"]) : 'Profile'; ?>
                            </i>
                        </a>
                    </li>

                    <!-- cart button -->
                    <li class="nav-item ms-4">
                        <a class="nav-link active" aria-current="page" href="../user/cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                    </li>
                    
                    <!-- Logout button -->
                    <li class="nav-item ms-4">
                    <a class="nav-link active text-danger" aria-current="page" href="../func/logout.php">Logout</a>
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

<!-- main -->
<main class="main pt-5 mt-2 pb-5">
    <div class="container py-4 mb-5">
        <h3 class="text-center fw-bold my-5 text-primary">My Cart</h3>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
                // Fetch cart items with course details using JOIN
                $user_id = $_SESSION['user_id']; // Make sure you have session_start() at the top of your file
                
                $sql = "SELECT c.cart_id, c.user_id, c.course_id, 
                            cs.course_title, cs.price, cs.image, cs.description, cs.instructor
                        FROM cart c
                        JOIN courses cs ON c.course_id = cs.course_id
                        WHERE c.user_id = $user_id";
                        
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {  
                        echo "<div class='col'>
                                <div class='card h-100 d-flex flex-column'>
                                    <img src='../img/courses/{$row['image']}' alt='{$row['course_title']}' class='card-img-top' style='height: 200px; object-fit: cover;'>
                                    <div class='card-body d-flex flex-column'>
                                        <h5 class='card-title text-primary fw-bold'>{$row['course_title']}</h5>
                                        <p class='card-text text-muted'>{$row['description']}</p>
                                        <p class='card-text text-muted'><i class='fa-solid fa-user-tie me-2'></i>Instructor: {$row['instructor']}</p>
                                        <p class='card-text text-black fw-bold'>₱" . number_format($row['price'], 2) . "</p>
                                        
                                        <!-- Centered and bottom-aligned button -->
                                        <div class='mt-auto text-center border-top pt-3'>
                                            <a href='../func/user/delete-cart-item.php?course_id={$row['course_id']}' 
                                            class='btn btn-sm btn-outline-danger'
                                            onclick='return confirm('Are you sure you want to delete this course?');'>
                                                <i class='fa-solid fa-trash-can me-1'></i>Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                    }
                } else {
                    echo "<div class='col-md-6 col-lg-4 offset-md-3 offset-lg-4 d-flex justify-content-center text-center text-muted'>No courses in your cart.</div>";
                }
            ?>
        </div>
    </div>
</main>



<!-- purchase button -->
<div class="container-fluid p-0">
    <nav id="navbar" class="navbar navbar-expand-lg navbar-dark bg-black bg-opacity-95 fixed-bottom">
        <div class="container d-flex justify-content-center p-2">
            <div id="checkout-button">
                <button class='btn btn-secondary p-3 px-5 fs-2 w-100' disabled>Checking cart...</button>
            </div>
        </div>
    </nav>
</div>  


<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
function updateCheckoutButton() {
    fetch('check-cart.php')
        .then(res => res.json())
        .then(data => {
            const btnContainer = document.getElementById('checkout-button');
            if (!data.success || data.count === 0) {
                btnContainer.innerHTML = `
                    <button class='btn btn-secondary p-3 px-5 fs-5' disabled>Cart is empty</button>
                `;
            } else {
                btnContainer.innerHTML = `
                    <a href='checkout.php' class='btn btn-success p-3 px-5 fs-5'>Checkout</a>
                `;
            }
        })
        .catch(err => console.error('Error fetching cart data:', err));
}

// Update immediately and every 3 seconds
updateCheckoutButton();
setInterval(updateCheckoutButton, 3000);
</script>

</body>
</html>
