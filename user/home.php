<?php
session_start();
include("../func/connections.php");

// Update cart badge on page load
if (isset($_SESSION['user_id'])) {
    updateCartBadge($conn);
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

// // Add this to start of pages where you need the cart count
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
    

<?php include 'header.php'; ?>


<!-- main content -->
<main class="main pt-5 mt-3">
<!-- Full-width container for the welcome message -->
<div class="container-fluid bg-black pt-5 pb-5 mt-6">
    <div class="row justify-content-center">
        <div class="col-12 text-center">
            <h1 class="text-white">Welcome back, <?php echo isset($_SESSION["first_name"]) ? htmlspecialchars($_SESSION["first_name"]) : ''; ?>!</h1>
        </div>
    </div>
</div>

  <!-- Hero Section -->
  <section id="home" class="hero section dark-background">
    
    <img src="../img/hero-img.jpg" alt="hero-bg" data-aos="fade-in">

    <div class="container d-flex flex-column align-items-center justify-content-center text-center" data-aos="fade-up" data-aos-delay="100">
      <h2>I am Sherwin Limosnero</h2>
      <p><span class="fs-5 text-warning fst-italic">Designer, Developer, Freelancer, Musician</span></p>
    </div>

  </section><!-- /Hero Section -->

  <!-- About Section -->
  <section id="about-me" class="about section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 align-items-center">
          <!-- Left Column: Image -->
          <div class="col-md-4">
              <img src="../img/face.png" style="width: 80%; height: auto;" class="img-fluid align-items-center" alt="Profile Picture">
          </div>       

          <!-- Right Column: About Me -->
          <div class="col-md-8">
            <div class="about-me">
                  <h4>About Me</h4>
                  <p>
                      Hey there! I'm Sherwin Limosnero, a second-year Game Development student fueled by creativity and a passion for making fun, immersive experiences. 
                  </p>

                  <div class="skills-content skills-animation">
                      <h5>Skills</h5>
                      <div class="d-flex flex-wrap gap-2">
                  <!-- Programming Languages -->
                  <div class="d-flex align-items-center gap-2 border rounded px-2 py-1 text-muted font-monospace hover-bg-light">
                      <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/csharp/csharp-original.svg" width="20" height="20" class="rounded" alt="C#" />
                      <span>C#</span>
                  </div>
                  <div class="d-flex align-items-center gap-2 border rounded px-2 py-1 text-muted font-monospace hover-bg-light">
                      <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/python/python-original.svg" width="20" height="20" class="rounded" alt="Python" />
                      <span>Python</span>
                  </div>

                  <!-- Game Development -->
                  <div class="d-flex align-items-center gap-2 border rounded px-2 py-1 text-muted font-monospace hover-bg-light">
                      <img src="https://upload.wikimedia.org/wikipedia/commons/6/6a/Godot_icon.svg" width="20" height="20" class="rounded" alt="Godot" />
                      <span>Godot</span>
                  </div>
                  <div class="d-flex align-items-center gap-2 border rounded px-2 py-1 text-muted font-monospace hover-bg-light">
                      <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/unity/unity-original.svg" width="20" height="20" class="rounded" alt="Unity" />
                      <span>Unity</span>
                  </div>

                  <!-- Frontend Development -->
                  <div class="d-flex align-items-center gap-2 border rounded px-2 py-1 text-muted font-monospace hover-bg-light">
                      <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg" width="20" height="20" class="rounded" alt="HTML5" />
                      <span>HTML5</span>
                  </div>
                  <div class="d-flex align-items-center gap-2 border rounded px-2 py-1 text-muted font-monospace hover-bg-light">
                      <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg" width="20" height="20" class="rounded" alt="CSS3" />
                      <span>CSS3</span>
                  </div>
                  <div class="d-flex align-items-center gap-2 border rounded px-2 py-1 text-muted font-monospace hover-bg-light">
                      <img src="https://upload.wikimedia.org/wikipedia/commons/d/d5/Tailwind_CSS_Logo.svg" width="20" height="20" class="rounded" alt="Tailwind CSS" />
                      <span>Tailwind CSS</span>
                  </div>
                  <div class="d-flex align-items-center gap-2 border rounded px-2 py-1 text-muted font-monospace hover-bg-light">
                      <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/bootstrap/bootstrap-original.svg" width="20" height="20" class="rounded" alt="Bootstrap" />
                      <span>Bootstrap</span>
                  </div>
                  <div class="d-flex align-items-center gap-2 border rounded px-2 py-1 text-muted font-monospace hover-bg-light">
                      <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg" width="20" height="20" class="rounded" alt="React" />
                      <span>React</span>
                  </div>

                  <!-- Version Control -->
                  <div class="d-flex align-items-center gap-2 border rounded px-2 py-1 text-muted font-monospace hover-bg-light">
                      <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/git/git-original.svg" width="20" height="20" class="rounded" alt="Git" />
                      <span>Git</span>
                  </div>
                  <div class="d-flex align-items-center gap-2 border rounded px-2 py-1 text-muted font-monospace hover-bg-light">
                      <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/github/github-original.svg" width="20" height="20" class="rounded" alt="GitHub" />
                      <span>GitHub</span>
                  </div>

                  <!-- Tools -->
                  <div class="d-flex align-items-center gap-2 border rounded px-2 py-1 text-muted font-monospace hover-bg-light">
                      <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vscode/vscode-original.svg" width="20" height="20" class="rounded" alt="VS Code" />
                      <span>VS Code</span>
                  </div>
                  <div class="d-flex align-items-center gap-2 border rounded px-2 py-1 text-muted font-monospace hover-bg-light">
                      <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/figma/figma-original.svg" width="20" height="20" class="rounded" alt="Figma" />
                      <span>Figma</span>
                  </div>
              </div>
          </div>

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
                                        echo "<a href='checkout.php' class='btn btn-sm btn-primary py-2 px-5'>View Course</a>";
                                    } else {
                                        // If not purchased, show normal buttons
                                        echo "<button type='button' class='btn btn-sm btn-success py-2 px-5' ";
                                        echo ($already_purchased) ? "data-bs-toggle='modal' data-bs-target='#alreadyPurchasedModal{$row['course_id']}'" : "onclick=\"window.location.href='checkout.php'\"";
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
                                                <a href='checkout.php' class='btn btn-primary'>View Course</a>
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

</main>


<?php include 'footer.php'; ?>

<!-- toast container -->
<div id="toastContainer" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999;"></div>

<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

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
        newContainer.style.bottom = '20px';
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