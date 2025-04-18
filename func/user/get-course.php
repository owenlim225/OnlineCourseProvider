<?php
session_start();
include("../connections.php");

// Security validation
if (!isset($_SESSION['user_id']) || !isset($_POST['user_id']) || $_SESSION['user_id'] != $_POST['user_id']) {
    echo '<div class="alert alert-danger">Unauthorized access</div>';
    exit;
}

// Get index from POST
$index = isset($_POST['index']) ? intval($_POST['index']) : 0;
$user_id = $_SESSION['user_id'];

// Fetch specific course at position $index
$sql = "SELECT c.cart_id, c.course_id, cs.course_title, cs.price, cs.image, cs.description
        FROM cart c
        JOIN courses cs ON c.course_id = cs.course_id
        WHERE c.user_id = ?
        LIMIT ?, 1";

// Use prepared statement for security
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $index);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Format image source - use placeholder if no image available
    $image_src = !empty($row['image']) ? htmlspecialchars($row['image']) : 'https://via.placeholder.com/800x400?text=Course+Image';
    
    // Create HTML for the course slide
    ?>
    <img src="<?php echo $image_src; ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($row['course_title']); ?>">
    <div class="carousel-caption d-md-block" style="background-color: rgba(0,0,0,0.5); border-radius: 5px; padding: 10px;">
        <h5><?php echo htmlspecialchars($row['course_title']); ?></h5>
        <p class="mb-0">&#8369;<?php echo number_format($row['price'], 2); ?></p>
    </div>
    <?php
} else {
    // Error case - should not happen normally
    echo '<div class="d-flex justify-content-center align-items-center bg-light" style="height: 300px;">
            <div class="text-center text-danger">
                <p>Error loading course data</p>
            </div>
          </div>';
}

$stmt->close();
?>