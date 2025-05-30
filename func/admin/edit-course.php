<?php
include("../connections.php");

$course_id = isset($_GET["course_id"]) ? intval($_GET["course_id"]) : 0;
$message = "";
$course = null;

// Fetch course details securely
if ($course_id > 0) {
    $sql = "SELECT course_id, course_title, description, instructor, image, price FROM courses WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();
    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_course"])) {
    $course_title = trim($_POST["course_title"]);
    $description = trim($_POST["description"]);
    $instructor = trim($_POST["instructor"]);
    $price = floatval($_POST["price"]);
    $image = $course['image'] ?? ''; // Keep existing image unless updated

    // Handle File Upload
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $file_name = $_FILES["image"]["name"];
        $file_tmp = $_FILES["image"]["tmp_name"];
        $file_size = $_FILES["image"]["size"];
        $file_type = $_FILES["image"]["type"];
        
        $allowed_types = ["image/jpeg", "image/png", "image/gif"];
        if (in_array($file_type, $allowed_types) && $file_size <= 2 * 1024 * 1024) {
            $new_file_name = uniqid() . "_" . basename($file_name);
            move_uploaded_file($file_tmp, "../../img/courses/" . $new_file_name);
            $image = $new_file_name;
        } else {
            $message = '<div class="alert alert-danger d-flex align-items-center" role="alert"><i class="bi bi-exclamation-triangle-fill me-2"></i><div>⚠️ Invalid file. Ensure it is JPEG, PNG, or GIF and under 2MB.</div></div>';
        }
    }

    if (empty($message)) {
        $sql = "UPDATE courses SET course_title = ?, description = ?, instructor = ?, price = ?, image = ? WHERE course_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisi", $course_title, $description, $instructor, $price, $image, $course_id);
        
        if ($stmt->execute()) {
            $message = '<div class="alert alert-success d-flex align-items-center" role="alert"><i class="bi bi-check-circle-fill me-2"></i><div>✅ Course updated successfully!</div></div>';

            $sql = "SELECT course_id, course_title, description, instructor, image, price FROM courses WHERE course_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $course_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $course = $result->fetch_assoc();
        } else {
            $message = '<div class="alert alert-danger d-flex align-items-center" role="alert"><i class="bi bi-exclamation-triangle-fill me-2"></i><div>⚠️ Error updating course: ' . $stmt->error . '</div></div>';
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>

    <!-- css file -->
    <link rel="stylesheet" href="src/style.css">

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>

    <!-- Top Navbar -->
    <nav class="navbar navbar-dark sticky-top bg-dark d-md-none">
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
            <img src="../../img/gdc-logo.png" alt="logo" class="img-fluid" style="max-width: 80px;">
        </div>
        <div class="nav flex-column text-center gap-3">
            <a href="../../admin/dashboard.php" class="text-light text-decoration-none">Dashboard</a>
            <a href="../../admin/users.php" class="text-light text-decoration-none">Users</a>
            <a href="../../admin/courses.php" class="text-warning fw-bold fs-5 text-decoration-none">Courses</a>
            <a href="../../admin/order.php" class="text-light text-decoration-none">Orders</a>
            <a class="text-danger text-decoration-none fw-bold mt-auto" href="../logout.php">Logout</a>
        </div>
    </aside>

    <!-- Offcanvas Sidebar for Mobile -->
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobileSidebarLabel">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column text-center gap-3">
            <img src="../../img/gdc-logo.png" alt="logo" class="img-fluid mb-3" style="max-width: 80px; margin: 0 auto;">
            <a href="../../admin/dashboard.php" class="text-light text-decoration-none">Dashboard</a>
            <a href="../../admin/users.php" class="text-light text-decoration-none">Users</a>
            <a href="../../admin/courses.php" class="text-warning fw-bold fs-5 text-decoration-none">Courses</a>
            <a href="../../admin/order.php" class="text-light text-decoration-none">Orders</a>
            <a class="text-danger text-decoration-none fw-bold mt-auto" href="../logout.php">Logout</a>
        </div>
    </div>

<main class="p-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 offset-md-2">

                <div class="container py-4">
                    <div class="row justify-content-center">
                        <div class="col-md-6 col-lg-5 bg-white p-5 rounded-4 shadow-lg mt-5">
                            <h2 class="mb-4 text-center text-black fw-bold">
                                <i class="bi bi-pencil-square me-2"></i> Edit Course
                            </h2>

                            <?php echo $message; ?>

                            <form action="edit-course.php?course_id=<?= $course_id; ?>" method="POST" enctype="multipart/form-data">
                                <!-- Course Title -->
                                <div class="mb-3">
                                    <label class="form-label text-black">Course Title</label>
                                    <input type="text" name="course_title" class="form-control rounded-3 shadow-sm" required value="<?= htmlspecialchars($course['course_title'] ?? ''); ?>">
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label class="form-label text-black">Description</label>
                                    <textarea name="description" class="form-control rounded-3 shadow-sm" required><?= htmlspecialchars($course['description'] ?? ''); ?></textarea>
                                </div>

                                <!-- Instructor -->
                                <div class="mb-3">
                                    <label class="form-label text-black">Instructor</label>
                                    <input type="text" name="instructor" class="form-control rounded-3 shadow-sm" required value="<?= htmlspecialchars($course['instructor'] ?? ''); ?>">
                                </div>

                                <!-- Image Upload -->
                                <div class="mb-3">
                                    <label class="form-label text-black">Course Image</label>
                                    <input type="file" name="image" class="form-control rounded-3 shadow-sm" onchange="document.getElementById('courseImagePreview').src = window.URL.createObjectURL(this.files[0])">
                                    <?php if (!empty($course['image'])): ?>
                                        <img id="courseImagePreview" src="../../img/courses/<?= htmlspecialchars($course['image']); ?>" alt="Course Image" class="img-fluid mt-3 rounded shadow-sm" style="max-height: 200px; object-fit: cover;">
                                    <?php endif; ?>
                                </div>

                                <!-- Price -->
                                <div class="mb-4">
                                    <label class="form-label text-black">Price</label>
                                    <input type="number" name="price" step="0.01" class="form-control rounded-3 shadow-sm" required value="<?= htmlspecialchars($course['price'] ?? ''); ?>">
                                </div>

                                <!-- Submit -->
                                <button type="submit" name="update_course" class="btn btn-dark w-100 fw-bold rounded-pill py-2">
                                    <i class="bi bi-save2-fill me-1"></i> Update Course
                                </button>
                            </form>

                            <p class="mt-4 text-center">
                                <a href="../../admin/courses.php" class="text-decoration-none fw-semibold text-black">← Back to Courses</a>
                            </p>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

