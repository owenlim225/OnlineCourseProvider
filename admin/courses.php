<?php
session_start();
include("../func/connections.php");

// Redirect non-admins
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] != 1) {
    header("Location: ../login.php");
    exit();
}

$message = "";
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);  
}


// Handle Course Insert
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_course"])) {
    $course_id = trim($_POST["course_id"]);
    $course_title = trim($_POST["course_title"]);
    $description = trim($_POST["description"]);
    $instructor = trim($_POST["instructor"]);
    $price = trim($_POST["price"]);
    $image = trim($_POST["image"]);

    // Handle File Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = basename($_FILES['image']['name']);
        $image_target = "../img/courses/" . $image_name;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $image_target)) {
            // Check for duplicate course ID
            $check_sql = "SELECT * FROM courses WHERE course_id = ?";
            $stmt = $conn->prepare($check_sql);
            $stmt->bind_param("s", $course_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $message = '<div class="alert alert-danger d-flex align-items-center" role="alert"><i class="bi me-2"></i><div>⚠️ Course ID already exists.</div></div>';
            } else {
                // Insert course into database
                $sql = "INSERT INTO courses (course_id, course_title, description, instructor, price, image) 
                        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssss", $course_id, $course_title, $description, $instructor, $price, $image_name);

                if ($stmt->execute()) {
                    $message = '<div class="alert alert-success d-flex align-items-center" role="alert"><i class="bi me-2"></i><div>✅ Course added successfully!</div></div>';
                } else {
                    $message = '<div class="alert alert-danger d-flex align-items-center" role="alert"><i class="bi me-2"></i><div>⚠️ Error adding course.</div></div>';
                }
            }
        } else {
            $message = '<div class="alert alert-danger d-flex align-items-center" role="alert"><i class="bi me-2"></i><div>⚠️ Error uploading image.</div></div>';
        }
    } else {
        $message = '<div class="alert alert-danger d-flex align-items-center" role="alert"><i class="bi me-2"></i><div>⚠️ Image is required.</div></div>';
    }
    $_SESSION["message"] = $message;
    header("Location: courses.php?");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>

    <!-- css file -->
    <link rel="stylesheet" href="src/style.css">

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>



<body>
    <!-- Top Navbar -->
    <nav class="navbar sticky-top navbar-dark bg-dark d-md-none">
        <div class="container-fluid">
            <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
            <i class="fas fa-bars"></i>
            </button>
            <span class="navbar-brand mx-auto">Courses</span>
        </div>
    </nav>

    <!-- Navbar -->
    <!-- Desktop Sidebar (hidden on small screens) -->
    <aside class="d-none d-md-block col-md-2 bg-dark text-white vh-100 position-fixed p-3">
        <div class="text-center mb-4">
            <img src="../img/logo.png" alt="logo" class="img-fluid" style="max-width: 80px;">
        </div>
        <div class="nav flex-column text-center gap-3">
            <a href="../admin/dashboard.php" class="text-light text-decoration-none">Dashboard</a>
            <a href="../admin/users.php" class="text-light text-decoration-none">Users</a>
            <a href="../admin/courses.php" class="text-warning fw-bold fs-5 text-decoration-none">Courses</a>
            <a href="../admin/order.php" class="text-light text-decoration-none">Orders</a>
            <a class="text-danger text-decoration-none fw-bold mt-auto" href="../func/logout.php">Logout</a>
        </div>
    </aside>

    <!-- Offcanvas Sidebar for Mobile -->
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobileSidebarLabel">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column text-center gap-3">
            <img src="../img/logo.png" alt="logo" class="img-fluid mb-3" style="max-width: 80px; margin: 0 auto;">
            <a href="../admin/dashboard.php" class="text-light text-decoration-none">Dashboard</a>
            <a href="../admin/users.php" class="text-light text-decoration-none">Users</a>
            <a href="../admin/courses.php" class="text-warning fw-bold fs-5 text-decoration-none">Courses</a>
            <a href="../admin/order.php" class="text-light text-decoration-none">Orders</a>
            <a class="text-danger text-decoration-none fw-bold mt-auto" href="../func/logout.php">Logout</a>
        </div>
    </div>
    
<main class="p-0">
    <div class="container-fluid">
        <div class="row">
            <!-- Main Content -->
            <div class="col-md-10 offset-md-2">
                <div class="container py-4">

                    <!-- Add Course -->
                    <?php echo $message; ?>
                    <div class="row justify-content-center d-none" id="addCourseForm">
                        <div class="col-md-6 col-lg-5 bg-white p-5 rounded-4 shadow-lg mt-5">
                            <h2 class="mb-4 text-center text-black fw-bold">
                                <i class="bi bi-journal-plus me-2"></i> Add New Course
                            </h2>

                            <?php //echo $message; ?>

                            <form action="courses.php" method="POST" enctype="multipart/form-data">
                                <!-- Course Title -->
                                <div class="mb-3">
                                    <label class="form-label text-black">Course Title</label>
                                    <input type="text" name="course_title" class="form-control rounded-3 shadow-sm" required placeholder="e.g., Introduction to Programming">
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label class="form-label text-black">Description</label>
                                    <textarea name="description" class="form-control rounded-3 shadow-sm" rows="3" required placeholder="Course description here..."></textarea>
                                </div>

                                <!-- Instructor -->
                                <div class="mb-3">
                                    <label class="form-label text-black">Instructor</label>
                                    <input type="text" name="instructor" class="form-control rounded-3 shadow-sm" required placeholder="e.g., John Smith">
                                </div>

                                <!-- Image -->
                                <div class="mb-3">
                                    <label class="form-label text-black">Course Image</label>
                                    <input type="file" name="image" class="form-control rounded-3 shadow-sm" required>
                                </div>

                                <!-- Price -->
                                <div class="mb-4">
                                    <label class="form-label text-black">Price</label>
                                    <input type="number" name="price" step="0.01" class="form-control rounded-3 shadow-sm" required placeholder="e.g., 99.99">
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" name="add_course" class="btn btn-dark w-100 fw-bold rounded-pill py-2">
                                    <i class="bi bi-plus-circle me-1"></i> Add Course
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Trigger Button -->
                    <div class="d-grid gap-2 col-4 mx-auto">
                        <button type="button" class="btn btn-primary btn-dark fw-bold rounded-pill py-2 mt-5" id="showCourseForm">
                            <i class="bi bi-plus-circle me-1"></i> Add New Course
                        </button>
                    </div>

                    <?php if (!empty($message)): ?>
                        <script>
                            // Force the form to stay open if there's a message
                            document.addEventListener('DOMContentLoaded', () => {
                                const addCourseForm = document.getElementById('addCourseForm');
                                const showCourseForm = document.getElementById('showCourseForm');
                                
                                if (addUserForm) {
                                    addCourseForm.classList.remove('d-none'); // Show form
                                    showCourseForm.innerHTML = '<i class="bi bi-x-circle me-1"></i> Cancel';
                                }
                            });
                        </script>
                    <?php endif; ?>

                    <script>
                        const addCourseForm = document.getElementById('addCourseForm');
                        const showCourseForm = document.getElementById('showCourseForm');

                        showCourseForm.addEventListener('click', () => {
                            addCourseForm.classList.toggle('d-none');
                            if (addCourseForm.classList.contains('d-none')) {
                                showCourseForm.innerHTML = '<i class="bi bi-plus-circle me-1"></i> Add Course';
                            } else {
                                showCourseForm.innerHTML = '<i class="bi bi-x-circle me-1"></i> Cancel';
                            }
                        });
                    </script>


                    <!-- Course List -->
                    <h1 class="text-center fw-bold my-5 text-primary">Course List</h1>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <div class="row">
                                    <?php
                                        // Fetch courses
                                        $sql = "SELECT * FROM courses";
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {  
                                                echo "<div class='col-md-4 mb-4'>
                                                        <div class='card shadow-lg' style='width: 100%; height: 100%;'>
                                                            <img src='../img/courses/{$row['image']}' alt='{$row['course_title']}' class='card-img-top' style='height: 200px; object-fit: cover;'>
                                                            <div class='card-body text-center'>
                                                                <h5 class='card-title'>{$row['course_title']}</h5>
                                                                <p class='card-text text-muted fw-bold' style='font-size: 12px;'>{$row['instructor']}</p>
                                                                <p class='card-text text-muted' style='font-size: 16px;'>{$row['description']}</p>
                                                                <p class='card-text fw-bold'>₱" . number_format($row['price'], 2) . "</p>
                                                                <a href='../func/admin/edit-course.php?course_id={$row['course_id']}' class='btn btn-sm btn-outline-success'>✏️ Edit</a>
                                                                <a href='../func/admin/delete-course.php?course_id={$row['course_id']}' class='btn btn-sm btn-outline-danger' 
                                                                    onclick=\"return confirm('Are you sure you want to delete this course?');\">🗑 Delete
                                                                </a>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Course Card Template -->
<!-- 
<div class="card" style="width: 18rem;">
    <img src='../courses/" . $row['image'] . "' alt='" . $row['course_title'] . "'>
    <div class="card-body">
        <h4 class="card-title">" . $row['course_title'] . "</h4>
        <h6 class="card-title">" . $row['price'] . "</h6>
        <p class="card-text">"₱ . number_format($row['price'], 2) . "</p>
        <a href='../func/edit-course.php?course_id={$row['course_id']}' class='btn btn-sm btn-outline-success'>✏️ Edit</a>
        <a href='../func/delete-course.php?course_id={$row['course_id']}' class='btn btn-sm btn-outline-danger' 
            onclick='return confirm('Are you sure you want to delete this user?');'>🗑 Delete
        </a>
    </div>
</div> -->


<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>