<?php
session_start();

if (!isset($_SESSION['userid'])) {
    echo "<script>location.replace('./user_views/login.html');</script>";
    exit;
}

$userid = $_SESSION['userid'];
$username = $_SESSION['username'];
?>
<!doctype html>
<html lang="en">
<head>
    <title>main</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jua&display=swap" rel="stylesheet">
    <style>
        div.container {
            display: flex;
            height: 100%;
        }
    </style>
</head>
<body>
<header>
    <div class="header-home">
        <div class="home-wrapper" id="home" onclick="location.href = '/wp_project'">
            <img class="logo" id="main_logo" src="./img/logo.png" alt="logo"/>
            <span>PET</span>
        </div>
        <nav>
            <div class="home-nav" onclick="location.href='./pet_services/show_pet_info.php'"><span>My Pets</span></div>
            <div class="home-nav"><span>Types</span></div>
        </nav>
    </div>
    <img class="logo" src="./img/profile.png" alt="profile" onclick="location.href='user_services/show_user_info.php'"/>
</header>
<div class="container">
</div>
<script>
</script>
</body>
</html>
