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
            move_uploaded_file($file_tmp, "uploads/" . $new_file_name);
            $image = $new_file_name;
        } else {
            $message = "<div class='error'>⚠️ Invalid file. Ensure it is JPEG, PNG, or GIF and under 2MB.</div>";
        }
    }

    if (empty($message)) {
        $sql = "UPDATE courses SET course_title = ?, description = ?, instructor = ?, price = ?, image = ? WHERE course_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssisi", $course_title, $description, $instructor, $price, $image, $course_id);
        
        if ($stmt->execute()) {
            $message = "<div class='success'>✅ Course updated successfully!</div>";
        } else {
            $message = "<div class='error'>⚠️ Error updating course: " . $stmt->error . "</div>";
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
    <link rel="stylesheet" href="src/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<main class="p-0">
    <div class="container-fluid">
        <div class="row">
            <aside class="col-md-2 d-flex flex-column justify-content-between align-items-center bg-dark text-light text-center py-4 vh-100 position-fixed">
                <div class="w-100 d-flex flex-column align-items-center gap-3">
                    <img src="../../img/logo.png" alt="logo" class="img-fluid" style="max-width: 80px;">
                    <div class="d-flex flex-column gap-3 w-100">
                        <a href="../admin/dashboard.php" class="text-light text-decoration-none">Dashboard</a>
                        <a href="../admin/users.php" class="text-light text-decoration-none">Users</a>
                        <a href="../admin/courses.php" class="text-warning fw-bold fs-4 text-decoration-none">Courses</a>
                        <a href="../admin/order.php" class="text-light text-decoration-none">Orders</a>
                    </div>
                </div>
                <a class="text-danger text-decoration-none fw-bold" href="../func/logout.php">Logout</a>
            </aside>

            <div class="col-md-10 offset-md-2">

                <div class="container py-4">
                    <div class="row justify-content-center">
                        <div class="col-md-6 bg-white p-4 rounded shadow-lg mt-4 text-center">
                            <h2 class="mb-3 text-dark">Edit Course</h2>
                            <?php echo $message; ?>
                            <form action="edit-course.php?course_id=<?= $course_id; ?>" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <input type="text" name="course_title" class="form-control" required value="<?= htmlspecialchars($course['course_title'] ?? ''); ?>">
                                </div>
                                <div class="mb-3">
                                    <textarea name="description" class="form-control" required><?= htmlspecialchars($course['description'] ?? ''); ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="instructor" class="form-control" required value="<?= htmlspecialchars($course['instructor'] ?? ''); ?>">
                                </div>
                                <div class="mb-3">
                                    <input type="file" name="image" class="form-control">
                                    <?php if (!empty($course['image'])): ?>
                                        <img src="../../img/courses/<?= htmlspecialchars($course['image']); ?>" alt="Course Image" class="img-fluid mt-2" style="max-height: 200px; object-fit: cover;">
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <input type="number" name="price" step="0.01" class="form-control" required value="<?= htmlspecialchars($course['price'] ?? ''); ?>">
                                </div>
                                <button type="submit" name="update_course" class="btn btn-dark w-100 fw-bold">➕ Update Course</button>
                            </form>
                            <p class="mt-5"><a href="../../admin/courses.php">Back to Courses</a></p>
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