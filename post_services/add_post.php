<?php

session_start();

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please log in and use it.')</script>";
    echo "<script>location.replace('/wp_project');</script>";
    exit;
}

$petId = $_POST['pet'];

if (empty($_POST['subject']) || empty($_POST['content']) || $petId == 'None') {
    echo "<script>alert('Please fill all the required fields.')</script>";
    echo "<script>location.replace('/wp_project');</script>";
    exit;
}

include "../db_conn.php";

$userId = $_SESSION['userid'];
$subject = $_POST['subject'];
$content = $_POST['content'];
$today = date("mdY");

echo $userId, $subject, $content, $petId, $today;

$sql = "INSERT INTO posts_tb(POST_SUBJECT, POST_CONTENT, POST_DATE, POST_USER_ID, POST_PET_ID)
        VALUES('$subject', '$content', '$today', '$userId', '$petId')";

mysqli_query($db, $sql);
mysqli_close($db);

//echo "<script>alert('Your post has been registered.');</script>";
//echo "<script>location.replace('/wp_project');</script>";
?>