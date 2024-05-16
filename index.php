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
    <div class="left-container">
        <div class="home" id="home">
            <img class="logo" id="main_logo" src="./img/logo.png" alt="logo"/>
            <span>PET</span>
        </div>
        <nav>
            <div class="nav-div"><span>asd</span></div>
            <div class="nav-div"><span>asd</span></div>
        </nav>
    </div>
    <img class="logo" id="profile" src="./img/profile.png" alt="profile"/>
</header>
<div class="container">
    <!-- Content goes here -->
</div>
<script>
    document.getElementById('home').addEventListener('click', () => {
        location.href = '/wp_project';
    });

    document.getElementById('profile').addEventListener('click', () => {
        location.href = './user_services/profile.php';
    });
</script>
</body>
</html>
