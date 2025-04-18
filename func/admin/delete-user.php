<?php
include("../connections.php");

// delete user
if (isset($_GET["user_id"]) && is_numeric($_GET["user_id"])) {
    $user_id = intval($_GET["user_id"]);

    $delete = mysqli_query($conn, "DELETE FROM user WHERE user_id = '$user_id'");

    if ($delete) {
        echo "<script>alert('User deleted successfully!'); window.location.href = '../../admin/users.php';</script>";
    } else {
        echo "<script>alert('Failed to delete user!'); window.location.href = '../../admin/users.php';</script>";
    }
}
?>
