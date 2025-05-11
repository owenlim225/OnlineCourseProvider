<h1 class="text-center fw-bold my-5 text-primary">Users List</h1>
                <!-- Users Table -->
                <div class="container">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 justify-content-center">
                        <?php
                            // Fetch users
                            $sql = "SELECT * FROM user";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $isAdmin = $row['is_admin'] == 1;
                                    if ($isAdmin) {
                                        continue;
                                    }

                                    echo "
                                    <div>
                                        <div class='card border-0 shadow-lg h-100 rounded-4 position-relative'>
                                            <div class='card-body d-flex flex-column align-items-center text-center p-4'>
                                                <div class='bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mb-3' style='width: 70px; height: 70px; font-size: 28px; font-weight: bold;'>
                                                    " . strtoupper($row['first_name'][0]) . "
                                                </div>
                                                <h5 class='card-title fw-bold mb-1'>{$row['first_name']} {$row['last_name']}</h5>
                                                <p class='text-muted mb-1 small'><i class='bi bi-envelope'></i> {$row['email']}</p>
                                                <p class='text-muted mb-2 small'><i class='bi bi-envelope'></i> {$row['contact']}</p>
                                                <span class='badge " . ($isAdmin ? "bg-gradient bg-success" : "bg-gradient bg-secondary") . " px-3 py-2 mb-3'>" . ($isAdmin ? 'Admin' : 'User') . "</span>
                                            </div>
                                        </div>
                                    </div>";
                                }
                            } else {
                                echo "<p class='text-center text-muted'>No users found.</p>";
                            }
                          ?>
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