<?php
session_start();
include("func/connections.php");
?>




<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Sherwin P. Limosnero">
    <title>Sherwin Limosnero</title>
    
    <!-- css file -->
    <link rel="stylesheet" href="src/style.css">
    <link rel="stylesheet" href="src/main.css" >

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="src/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  </head>
<body>
    
<!-- Navbar -->
<?php include 'src/header.php'; ?>


<!-- main content -->
<main class="main pt-5">

  <!-- Hero Section -->
  <section id="home" class="hero section dark-background mt-4 pt-7">

    <img src="img/hero-img.jpg" alt="hero-bg" data-aos="fade-in">

    <div class="container d-flex flex-column align-items-center justify-content-center text-center" data-aos="fade-up" data-aos-delay="100">
      <h2>I am Sherwin Limosnero</h2>
      <p><span class="fs-5 text-warning fst-italic">Designer, Developer, Freelancer, Musician</span></p>
    </div>

  </section>

  <!-- About Section -->
  <section id="about-me" class="about section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row gy-4 align-items-center">
          <!-- Left Column: Image -->
          <div class="col-md-4">
              <img src="img/face.png" style="width: 80%; height: auto;" class="img-fluid align-items-center" alt="Profile Picture">
          </div>       

          <!-- Right Column: About Me -->
          <div class="col-md-8 mt-1">
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
                echo "<div class='col-lg-4 col-md-6' data-aos='fade-up' data-aos-delay='100'>
                        <div class='service-item position-relative'>
                            <div class='mb-3'>
                                <img src='img/courses/{$row['image']}' alt='{$row['course_title']}' class='img-fluid rounded' style='width: 100%; height: 200px; object-fit: cover;'>
                            </div>

                            <div class='card-body text-center'>
                                <h5 class='card-title fw-bold'>{$row['course_title']}</h5>
                                <p class='card-text text-muted fw-bold m-2' style='font-size: 12px;'>{$row['instructor']}</p>
                                <p class='card-text text-muted m-2' style='font-size: 16px;'>
                                    {$row['description']}
                                </p>
                                <p class='card-text fw-bold' style='font-size: 18px;'>₱" . number_format($row['price'], 2) . "</p>

                                <div class='m-4'>
                                  <a href='login.php' class='btn btn-sm btn-success py-2 px-5'>Buy</a>
                                  <a href='login.php' class='btn btn-sm btn-outline-danger py-2 px-3'>
                                      <i class='fa-solid fa-cart-shopping'></i>
                                  </a>
                                  

                                </div>
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
  </section>

</main>


<!-- Footer -->
<?php include 'src/footer.php'; ?>

<!-- bootstrap js link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</body>
</html>