<?php

session_start();

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please log in and use it.')</script>";
    echo "<script>location.replace('./user_views/login.html');</script>";
    exit;
}

include "../db_conn.php";
$userId = $_SESSION['userid'];
$postId = $_GET['id'];

$sql = "SELECT COUNT(*) FROM likes_tb WHERE post_id = '$postId' AND user_id = '$userId'";
$rsl = mysqli_query($db, $sql);

if(mysqli_fetch_array($rsl)['COUNT(*)'] == 0) {
    $sql = "INSERT INTO likes_tb(post_id, user_id) VALUES('$postId', '$userId')";
    $sql2 = "UPDATE posts_tb SET post_like = post_like + 1 WHERE post_id = $postId";
    mysqli_query($db, $sql2);
} else {
    $sql = "DELETE FROM likes_tb WHERE post_id = '$postId' AND user_id = '$userId'";
    $sql2 = "UPDATE posts_tb SET post_like = post_like - 1 WHERE post_id = $postId";
    mysqli_query($db, $sql2);
}
mysqli_query($db, $sql);
$sql = "SELECT post_like FROM posts_tb WHERE post_id = '$postId'";
$rsl = mysqli_query($db, $sql);
echo mysqli_fetch_array($rsl)['post_like'];
mysqli_close($db);
?>