<?php

session_start();
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please log in and use it.')</script>";
    echo "<script>location.replace('/wp_project');</script>";
    exit;
}

if(!isset($_POST['origin_pw']) || !isset($_POST['new_pw'])) {
    echo "<script>alert('Enter the original password and new password.')</script>')";
    echo "<script>location.replace('/wp_project/views/show_user_info.php');</script>";
    exit;
}

$userId = $_SESSION['userid'];
$originPw = $_POST['origin_pw'];
$newPw = $_POST['new_pw'];


include "../db_conn.php";

$chkOriginalPwSql = "SELECT count(*) FROM users_tb WHERE user_id = '$userId' AND user_pw = '$originPw'";
$rsl = mysqli_query($db, $chkOriginalPwSql);

if(mysqli_fetch_array($rsl)) {
    $updatePwSql = "UPDATE users_tb SET user_pw = '$newPw' WHERE user_id = '$userId'";
    mysqli_query($db, $updatePwSql);
} else {
    echo "<script>alert('Wrong original password.')</script>";
}
echo '<script>location.replace("/wp_project/views/show_user_info.php");</script>';