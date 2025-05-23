<?php
session_start();
include("../func/connections.php");

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
        $_SESSION['user_id'] = $user['user_id']; // Store user_id in session
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['contact'] = $user['contact'];
    }
}

// Use the user_id from session or GET parameter
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 
          (isset($_GET["user_id"]) ? intval($_GET["user_id"]) : 0);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_user"])) {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $contact = trim($_POST["contact"]);
    $new_password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $is_admin = isset($_POST["is_admin"]) ? intval($_POST["is_admin"]) : 0;
    $user_id = isset($_POST["user_id"]) ? $_POST["user_id"] : $user_id;

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($contact)) {
        $message = "<div class='alert alert-danger d-flex align-items-center' role='alert'><i class='bi me-2'></i><div>⚠️ Name and contact fields are required.</div></div>";
    } elseif (!empty($new_password) && (strlen($new_password) < 6 || $new_password !== $confirm_password)) {
        $message = "<div class='alert alert-danger d-flex align-items-center' role='alert'><i class='bi me-2'></i><div>⚠️ Password must be at least 6 characters and match.</div></div>";
    }

    if (empty($message)) {
        // Prepare dynamic update query
        $updates = "first_name=?, last_name=?, contact=?";
        $params = [$first_name, $last_name, $contact];
        $types = "sss";

        // Add admin update if needed
        if (isset($is_admin)) {
            $updates .= ", is_admin=?";
            $params[] = $is_admin;
            $types .= "i";
        }

        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $updates .= ", password=?";
            $params[] = $hashed_password;
            $types .= "s";
        }

        // Execute update query
        $update_sql = "UPDATE user SET $updates WHERE user_id=?";
        $params[] = $user_id;
        $types .= "i";

        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            $message = "<div class='alert alert-success d-flex align-items-center' role='alert'><i class='bi me-2'></i><div>✅ Profile updated successfully!</div></div>";
            // Refresh user data in session
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['contact'] = $contact;
        } else {
            $message = "<div class='alert alert-danger d-flex align-items-center' role='alert'><i class='bi me-2'></i><div>⚠️ Error updating profile: " . $stmt->error . "</div></div>";
        }
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Sherwin P. Limosnero">
    <title>Profile</title>
    
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
<body class="d-flex flex-column min-vh-100">

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
                        <a class="nav-link active" aria-current="page" href="cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
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

<main class="main pt-5 mt-5 flex-grow-1">
    <div class="container py-4">
        <div class="row gx-4 gy-4">

            <!-- Left column: User profile -->
            <div class="col-12 col-lg-4">
                <div class="bg-white p-4 rounded shadow-lg text-center h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="m-0 fw-bold">User Profile</h5>
                        <button id="editProfileBtn" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-pencil-alt me-1"></i> Edit Profile
                        </button>
                    </div>

                    <!-- Profile picture -->
                    <div class="profile-image-container mb-3">
                        <div class="profile-image mx-auto rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                            <span class="display-4 text-muted"><?php echo substr(isset($_SESSION["first_name"]) ? htmlspecialchars($_SESSION["first_name"]) : '', 0, 1); ?></span>
                        </div>
                    </div>

                    <?php echo $message; ?>

                    <!-- View mode -->
                    <div id="viewProfileMode">
                        <h3 class="mb-4"><?php echo isset($_SESSION["first_name"]) ? htmlspecialchars($_SESSION["first_name"] . ' ' . $_SESSION["last_name"]) : ''; ?></h3>

                        <div class="profile-info mb-4 p-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-phone text-primary me-2"></i>
                                <div><?php echo isset($_SESSION["contact"]) ? htmlspecialchars($_SESSION["contact"]) : ''; ?></div>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-envelope text-primary me-2"></i>
                                <div><?php echo isset($_SESSION["email"]) ? htmlspecialchars($_SESSION["email"]) : ''; ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit mode -->
                    <div id="editProfileMode" style="display: none;">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="mb-3 d-flex flex-column gap-2">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="first_name" name="first_name" required value="<?php echo isset($_SESSION["first_name"]) ? htmlspecialchars($_SESSION["first_name"]) : ''; ?>">
                                    <label for="first_name">First Name</label>
                                </div>
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="last_name" name="last_name" required value="<?php echo isset($_SESSION["last_name"]) ? htmlspecialchars($_SESSION["last_name"]) : ''; ?>">
                                    <label for="last_name">Last Name</label>
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" name="contact" id="contact" class="form-control" required value="<?php echo isset($_SESSION["contact"]) ? htmlspecialchars($_SESSION["contact"]) : ''; ?>" pattern="[0-9]{11}" maxlength="11" title="Please enter a valid 11-digit contact number">
                                <label for="contact">Contact Number</label>
                                <div class="invalid-feedback">Please enter a valid 11-digit contact number</div>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="email" name="email" id="email" class="form-control" readonly disabled value="<?php echo isset($_SESSION["email"]) ? htmlspecialchars($_SESSION["email"]) : ''; ?>">
                                <label for="email">Email Address</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" name="password" id="password" class="form-control" placeholder="New Password">
                                <label for="password">New Password</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Retype Password">
                                <label for="confirm_password">Confirm Password</label>
                            </div>

                            <button type="submit" name="update_user" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-save me-1"></i> Save Changes
                            </button>
                            <button type="button" id="cancelEditBtn" class="btn btn-outline-secondary w-100">
                                Cancel
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right column: User courses -->
            <div class="col-12 col-lg-8">
                <div class="bg-white p-4 rounded shadow-lg h-100">
                    <h2 class="mb-3 text-primary fw-bold text-center">My Courses</h2>

                    <div class="row g-4">
                        <?php
                            if ($user_id > 0) {
                                $sql = "SELECT c.* FROM purchased_courses pc 
                                        JOIN courses c ON pc.course_id = c.course_id 
                                        WHERE pc.user_id = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("i", $user_id);
                                $stmt->execute();
                                $result = $stmt->get_result();
                            } else {
                                $result = false;
                            }

                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {  
                                    echo "<div class='col-sm-6 col-md-4'>
                                            <div class='course-card h-100 d-flex flex-column justify-content-between shadow-sm rounded p-2'>
                                                <div class='course-image-container'>
                                                    <img src='../img/courses/{$row['image']}' alt='{$row['course_title']}' class='img-fluid rounded'>
                                                </div>
                                                <div class='course-info mt-2'>
                                                    <h6 class='mb-1 text-truncate fw-bold'>{$row['course_title']}</h6>
                                                    <p class='mb-2 small text-muted'><i class='fas fa-user-tie me-1'></i>{$row['instructor']}</p>
                                                </div>
                                                <a href='profile.php' class='btn btn-outline-primary w-100 mt-auto'>
                                                    <i class='fas fa-play me-1'></i> Start Course
                                                </a>
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
</main>





<script>
document.addEventListener('DOMContentLoaded', function() {
    const editProfileBtn = document.getElementById('editProfileBtn');
    const cancelEditBtn = document.getElementById('cancelEditBtn');
    const viewProfileMode = document.getElementById('viewProfileMode');
    const editProfileMode = document.getElementById('editProfileMode');
    
    // Toggle to edit mode
    editProfileBtn.addEventListener('click', function() {
        viewProfileMode.style.display = 'none';
        editProfileMode.style.display = 'block';
    });
    
    // Cancel edit and return to view mode
    cancelEditBtn.addEventListener('click', function() {
        editProfileMode.style.display = 'none';
        viewProfileMode.style.display = 'block';
    });
});

document.addEventListener('DOMContentLoaded', function() {
  // Get the main profile container
  const profileContainer = document.querySelector('.profile-container');
  
  // Get the edit and view mode divs
  const viewMode = document.getElementById('viewProfileMode');
  const editMode = document.getElementById('editProfileMode');
  
  // Get the buttons
  const editProfileBtn = document.getElementById('editProfileBtn');
  const cancelEditBtn = document.getElementById('cancelEditBtn');
  
  // Add event listener to edit button
  editProfileBtn.addEventListener('click', function() {
    // Hide view mode, show edit mode
    viewMode.style.display = 'none';
    editMode.style.display = 'block';
    
    // Change container height for edit mode
    profileContainer.classList.remove('profile-container-small');
    profileContainer.classList.add('profile-container-large');
  });
  
  // Add event listener to cancel button
  cancelEditBtn.addEventListener('click', function() {
    // Hide edit mode, show view mode
    editMode.style.display = 'none';
    viewMode.style.display = 'block';
    
    // Change container height for view mode
    profileContainer.classList.remove('profile-container-large');
    profileContainer.classList.add('profile-container-small');
  });
});
</script>

<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

