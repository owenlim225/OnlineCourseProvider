<?php
session_start();
include("../func/connections.php");

// Redirect non-admins
if (!isset($_SESSION["is_admin"]) || $_SESSION["is_admin"] != 1) {
    header("Location: ../login.php");
    exit();
}

$message = "";

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
                $_SESSION['message'] = "<div id='message-box' class='error'>⚠️ Course ID already exists.</div>";
            } else {
                // Insert course into database
                $sql = "INSERT INTO courses (course_id, course_title, description, instructor, price, image) 
                        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssdss", $course_id, $course_title, $description, $instructor, $price, $image_name);

                if ($stmt->execute()) {
                    $_SESSION['message'] = "<div id='message-box' class='success'>✅ Course added successfully!</div>";
                } else {
                    $_SESSION['message'] = "<div id='message-box' class='error'>⚠️ Error adding course.</div>";
                }
            }
        } else {
            $_SESSION['message'] = "<div id='message-box' class='error'>⚠️ Error uploading image.</div>";
        }
    } else {
        $_SESSION['message'] = "<div id='message-box' class='error'>⚠️ Image is required.</div>";
    }
    header("Location: courses.php");
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
<main class="p-0">
    <div class="container-fluid">
        <div class="row">
            <!-- Navbar -->
            <aside class="col-md-2 d-flex flex-column justify-content-between align-items-center bg-dark text-light text-center py-4 vh-100 position-fixed">
                <div class="w-100 d-flex flex-column align-items-center gap-3">
                    <img src="../img/logo.png" alt="logo" class="img-fluid" style="max-width: 80px;">
                    <div class="d-flex flex-column gap-3 w-100">
                        <a href="../admin/dashboard.php" class="text-light text-decoration-none">Dashboard</a>
                        <a href="../admin/users.php" class="text-light text-decoration-none">Users</a>
                        <a href="../admin/courses.php" class="text-warning fw-bold fs-4 text-decoration-none">Courses</a>
                        <a href="../admin/order.php" class="text-light text-decoration-none">Orders</a>
                    </div>
                </div>
                <a class="text-danger text-decoration-none fw-bold" href="../func/logout.php">Logout</a>
            </aside>

    <!-- Main Content -->
    <div class="col-md-10 offset-md-2">
        <div class="container py-4">

            <!-- Add Course -->
            <div class="row justify-content-center">
                <div class="col-md-4 bg-white p-4 rounded shadow-lg mt-4 text-center" 
                    style="box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2); transition: transform 0.3s ease;">
                    <h2 class="mb-3 text-dark">Add New Course</h2>
                    
                    <?php echo $message; ?>

                    <form action="courses.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <input type="text" name="course_title" class="form-control border-0 border-bottom" required placeholder="Course Title">
                        </div>
                        <div class="mb-3">
                            <textarea name="description" class="form-control border-0 border-bottom" required placeholder="Description"></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="text" name="instructor" class="form-control border-0 border-bottom" required placeholder="Category">
                        </div>
                        <div class="mb-3">
                            <input type="file" name="image" class="form-control border-0 border-bottom" required>
                        </div>
                        <div class="mb-3">
                            <input type="number" name="price" step="0.01" class="form-control border-0 border-bottom" required placeholder="Price">
                        </div>
                        <button type="submit" name="add_course" class="btn btn-dark w-100 fw-bold">➕ Add Course</button>
                    </form>
                </div>
            </div>

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