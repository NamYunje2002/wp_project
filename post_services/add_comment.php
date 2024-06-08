<?php

session_start();

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please log in and use it.')</script>";
    echo "<script>location.replace('/wp_project');</script>";
    exit;
}

if (empty($_POST['post_id']) || empty($_POST['comment'])) {
    echo "<script>alert('Please fill all the required fields.')</script>";
    echo "<script>location.replace('/wp_project');</script>";
    exit;
}

include "../db_conn.php";

$userId = $_SESSION['userid'];
$postId = $_POST['post_id'];
$comment = $_POST['comment'];
$today = date("mdY");

$sql = "INSERT INTO comments_tb(comment_post_id, comment_user_id, comment_text)
        VALUES('$postId', '$userId', '$comment')";

mysqli_query($db, $sql);
mysqli_close($db);

echo "<script>alert('Your comment has been registered.');</script>";
echo '<script>location.replace("../views/show_post_content.php?id='. $postId .'");</script>';
?>