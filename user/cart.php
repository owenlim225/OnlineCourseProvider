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

<!-- main -->
<main class="main pt-5 mt-2 pb-5">
    <div class="container py-4 mb-5">
        <h3 class="text-center fw-bold my-5 text-primary">Course List</h3>
        <table class="table table-striped table-hover table-bordered shadow rounded">
            <thead class="table-dark text-center">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Image</th>
                    <th scope="col">Course Title</th>
                    <th scope="col">Price</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>

            <tbody class="text-center">
            <?php
                // Fetch cart items with course details using JOIN
                $user_id = $_SESSION['user_id']; // Make sure you have session_start() at the top of your file
                
                $sql = "SELECT c.cart_id, c.user_id, c.course_id, 
                            cs.course_title, cs.price, cs.image
                        FROM cart c
                        JOIN courses cs ON c.course_id = cs.course_id
                        WHERE c.user_id = $user_id";
                        
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {  
                        echo "<tr>
                            <td class='fw-bold'>{$row['course_id']}</td>
                            <td><img src='../img/courses/{$row['image']}' alt='{$row['course_title']}' class='card-img-top' style='height: 100px; object-fit: cover;'></td>
                            <td>{$row['course_title']}</td>
                            <td>₱" . number_format($row['price'], 2) . "</td>
                            <td class='text-center'>
                                <a href='../func/user/delete-cart-item.php?course_id={$row['course_id']}' class='btn btn-sm btn-outline-danger' 
                                    onclick=\"return confirm('Are you sure you want to delete this course?');\">🗑 Delete
                                </a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center text-muted'>No courses in your cart.</td></tr>";
                }
            ?>
            </tbody>
        </table>
    </div>
</main>



<!-- purchase button -->
<div class="container-fluid p-0">
    <nav id="navbar" class="navbar navbar-expand-lg navbar-dark bg-black bg-opacity-95 fixed-bottom">
          <div class="container d-flex justify-content-center p-4">
            <a href='checkout.php' class='btn btn-success p-3 px-5 fs-5'>Checkout</a>
          </div>
</div>

<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
