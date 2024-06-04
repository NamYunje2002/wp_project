<?php

session_start();
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Wrong Access')</script>";
    echo "<script>location.replace('/wp_project');</script>";
    exit;
}

$userId = $_SESSION['userid'];

include "../db_conn.php";

$deleteUserSql = "DELETE FROM users_tb WHERE user_id = '$userId'";
mysqli_query($db, $deleteUserSql);

$deletePetSql = "DELETE FROM pets_tb WHERE pet_owner = '$userId'";
mysqli_query($db, $deletePetSql);

$deletePostSql = "DELETE FROM posts_tb WHERE post_user_id = '$userId'";
mysqli_query($db, $deletePostSql);

session_destroy();

echo "<script>alert('Your account has been deleted.')</script>";
echo "<script>location.replace('/wp_project');</script>";

?>