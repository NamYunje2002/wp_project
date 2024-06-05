<?php
session_start();

if (!isset($_SESSION['userid'])) {
    echo "<script>location.replace('./views/login.html');</script>";
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
        .container {
            display: flex;
            flex-direction: column;
            padding: 20px 50px;
            height: auto;
        }

        .heading {
            font-size: 34px;
            font-weight: bold;
        }

        .post-wrapper {
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .post {
            border: 5px solid var(--main-color);
            width: 350px;
            height: 200px;
            border-radius: 20px;
            padding: 20px;
            margin-top: 50px;
        }

        .post:hover {
            background-color: var(--main-color);
            color: white;
            cursor: pointer;
        }

        .post-subject {
            text-align: center;
            font-weight: bold;
            font-size: 30px;
        }

        .post-pet {
            display: flex;
        }

        @media (max-width: 1000px) {
            .post-wrapper {
                flex-direction: column;
            }

            .post {
                width: 90%;
            }
        }
    </style>
</head>
<body>
<header>
    <div class="header-home">
        <div class="home-wrapper" onclick="location.href = '/wp_project'">
            <img class="logo" id="main-icon" src="./img/logo.png" alt="logo"/>
            <span>Along with the pet</span>
        </div>
        <nav id="nav-links">
            <div class="home-nav" onclick="location.href='views/show_pet_info.php'"><span>My Pets</span></div>
            <div class="home-nav"><span>My Posts</span></div>
            <div class="home-nav"><span>Types</span></div>
        </nav>
    </div>
    <div class="header-icons">
        <img class="logo" id="profile-icon" src="./img/profile.png" alt="profile"
             onclick="location.href='views/show_user_info.php'"/>
        <img class="logo" id="menu-icon" src="./img/menu.png" alt="menu" onclick="toggleMenu()"/>
    </div>
</header>
<div class="container">
    <div class="heading">Posts</div>
    <?php
    include "./db_conn.php";

    $selectPostsSql = "SELECT PO.post_id, PO.post_subject, PO.post_date, PO.post_user_id, PO.post_hit, PO.post_like, U.user_name, P.pet_type, P.pet_breed
                        FROM posts_tb PO, users_tb U, pets_tb P 
                        WHERE U.user_id = PO.post_user_id AND P.pet_id = PO.post_pet_id
                        ORDER BY PO.post_id DESC;";
    $rsl = mysqli_query($db, $selectPostsSql);
    mysqli_close($db);
    $cnt = 0;
    while ($row = mysqli_fetch_array($rsl)) {
        if ($cnt == 0) echo '<div class="post-wrapper">';
        else if ($cnt % 4 == 0) echo '</div><div class="post-wrapper">';
        $cnt += 1;

        $postId = $row['post_id'];
        $postSubject = $row['post_subject'];
        $postDate = $row['post_date'];
        $postWriter = $row['user_name'];
        $postHit = $row['post_hit'];
        $petType = $row['pet_type'];
        $petBreed = $row['pet_breed'];
        $postLike = $row['post_like'];

        $postMonth = substr($postDate, 0, 2);
        $postDay = substr($postDate, 2, 2);
        $postYear = substr($postDate, 4);

        $postDate = $postMonth . ' / ' . $postDay . ' / ' . $postYear;

        echo '<div class="post" onclick="location.href=';
        echo "'./views/show_post_content.php?id=$postId'";
        echo '">';
        echo '<div class="post-subject">' . $postSubject . '</div>';
        echo '<div class="post-pet">';
        echo '<div class="pet-type">' . $petType . ' </div>';
        echo '<div class="pet-breed">-' . $petBreed . '</div>';
        echo '</div>';
        echo '<div class="post-date">Date : ' . $postDate . '</div>';
        echo '<div class="post-writer">Writer : ' . $postWriter . '</div>';
        echo '<div class="post-hit">Views : ' . $postHit . '</div>';
        echo '<div class="post-like">Likes : ' . $postLike . '</div>';
        echo '</div>';
    }
    echo '</div>';
    ?>
</div>
<script src="./toggle.js"></script>
</body>
</html>
