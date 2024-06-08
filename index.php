<?php
session_start();

if (!isset($_SESSION['userid'])) {
    echo "<script>location.replace('./views/login.html');</script>";
    exit;
}

$searchKeyword = '';
if (isset($_GET['s'])) $searchKeyword = $_GET['s'];

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
            margin: 40px 0;
            font-weight: bold;
        }

        .heading > span {
            margin-right: 20px;
            font-weight: bold;
        }

        input[type=button] {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            background-color: var(--main-color);
            color: white;
            border: none;
        }

        input[type=button]:hover {
            background-color: #8B715F;
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

        .add-container {
            border: 1px solid var(--main-color);
            border-radius: 5px;
            width: 100%;
            position: relative;
            display: none;
            margin: 40px 0;
        }

        form {
            display: flex;
            flex-direction: column;
            flex: 1;
            align-items: center;
            margin: 20px;
        }

        input[type=text] {
            width: 90%;
            height: 35px;
            margin: 10px;
            padding: 10px 20px;
            background-color: #ffffff;
            border: 1px solid var(--main-color);
            border-radius: 5px;
            font-size: 20px;
            resize: none;
        }

        textarea {
            width: 90%;
            height: 150px;
            margin: 10px;
            padding: 10px 5px;
            background-color: #ffffff;
            border: 1px solid var(--main-color);
            border-radius: 5px;
            font-size: 20px;
        }

        .left-container {
            text-align: left;
            width: 90%;
        }

        div.left-container > span {
            display: block;
            width: 100%;
            text-align: left;
            font-size: 15px;
            font-weight: bold;
        }

        select {
            width: 100%;
            height: 35px;
            margin: 10px;
            padding: 5px;
            background-color: #ffffff;
            border: 1px solid var(--main-color);
            border-radius: 5px;
        }

        input[type=radio] {
            vertical-align: middle;
            border: 1px solid var(--main-color);
            border-radius: 50%;
            width: 1.25em;
            height: 1.25em;
        }

        div.valid_chk {
            width: 250px;
            height: 70px;
            color: #ff0000;
            display: none;
            font-size: 15px;
        }

        .btn-container {
            position: absolute;
            bottom: 20px;
            right: 20px;
        }

        #select-div {
            margin-bottom: 40px;
        }

        input[type=button].negative-btn {
            background-color: #ffffff;
            border: 1px solid var(--main-color);
            color: var(--main-color);
        }

        input[type=button]#cancel-btn:hover {
            background-color: #e6e6e6;
        }

        .search-div {
            background-color: #fefefe;
            position: relative;
            padding: 20px;
            border: 1px solid var(--main-color);
            border-radius: 10px;
            width: 50%;
        }

        .search-wrapper {
            width: 100%;
            height: auto;
            padding: 10px 0 40px;
        }

        .search-heading {
            padding: 0;
            margin: 10px;
            font-size: 28px;
            font-weight: bold;
        }

        @media (max-width: 1000px) {
            .post-wrapper {
                flex-direction: column;
            }

            .post {
                width: 90%;
            }

            .btn-container {
                padding-top: 50px;
            }

            form {
                flex-direction: column;
                width: 100%;
                height: auto;
            }

            .search-div {
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
        </nav>
    </div>
    <div class="header-icons">
        <img class="logo" id="profile-icon" src="./img/profile.png" alt="profile"
             onclick="location.href='views/show_user_info.php'"/>
        <img class="logo" id="menu-icon" src="./img/menu.png" alt="menu" onclick="toggleMenu()"/>
    </div>
</header>
<div class="container">
    <div class="heading">
        <span>Posts</span><input type="button" value="Write" id="write-btn"/>
    </div>
    <div class="add-container">
        <div id="add-div">
            <form id="add-form" method="post">
                <div class="search-heading">Write your post</div>
                <div class="left-container">
                    <span>Subject</span>
                </div>
                <input type="text" id="subject" name="subject"/>
                <div class="left-container">
                    <div class="valid_chk" id="name_valid">Enter a combination of 2 to 14 numbers and characters.</div>
                </div>

                <div class="left-container">
                    <span>Content</span>
                </div>
                <textarea id="content" name="content"></textarea>
                <div class="left-container">
                    <div class="valid_chk" id="email_valid">Enter a valid email.</div>
                </div>

                <div class="left-container">
                    <span>Select your pet.</span>
                </div>
                <div id="select-div">
                    <select id="pet" name="pet">
                        <option selected>None</option>
                        <?php
                        include "./db_conn.php";
                        $sql = "SELECT pet_id, pet_name FROM pets_tb WHERE pet_owner = '$userid'";
                        $rsl = mysqli_query($db, $sql);
                        while ($row = mysqli_fetch_array($rsl)) {
                            echo "<option value='" . $row['pet_id'] . "'>" . $row['pet_name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="btn-container">
                    <input type="button" class="negative-btn" id="register-cancel-btn" value="Cancel"/>
                    <input type="button" class="positive-btn" id="register-btn" value="Register"/>
                </div>
            </form>
        </div>
    </div>
    <div class="search-div">
        <div class="search-heading">Search</div>
        <div class="search-wrapper">
            <div class="left-container">
                <span>Enter the keyword you want to search for.</span>
            </div>
            <input type="text" id="search" name="search"/>
            <div class="left-container">
                <div class="valid_chk" id="name_valid">(Warning message)</div>
            </div>
            <div class="btn-container">
                <input type="button" class="positive-btn" id="search-btn" value="Search"/>
            </div>
        </div>
    </div>
    <?php
    include "./db_conn.php";

    $selectPostsSql = "SELECT PO.post_id, PO.post_subject, PO.post_date, PO.post_user_id, PO.post_hit, PO.post_like, U.user_name, P.pet_type, P.pet_breed
                        FROM posts_tb PO, users_tb U, pets_tb P 
                        WHERE U.user_id = PO.post_user_id AND P.pet_id = PO.post_pet_id AND post_subject LIKE '%$searchKeyword%'
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
<script>
    let subject = document.getElementById('subject');
    let content = document.getElementById('content');
    let pet = document.getElementById('pet');

    let writeBtn = document.getElementById('write-btn');
    let cancelBtn = document.getElementById('register-cancel-btn');
    let addContainer = document.querySelector('.add-container');
    writeBtn.addEventListener('click', () => {
        addContainer.style.display = 'block';
        writeBtn.style.visibility = 'hidden';
    });

    cancelBtn.addEventListener('click', () => {
        subject.value = '';
        content.value = '';
        pet.value = 'None';
        addContainer.style.display = 'none';
        writeBtn.style.visibility = '';
    });

    document.getElementById('register-btn').addEventListener('click', () => {
        document.getElementById('add-form').submit();
    });

    document.getElementById('search-btn').addEventListener('click', () => {
        let searchKeyword = document.getElementById('search').value;
        location.href = "?s=" + searchKeyword;
    })
</script>
</body>
</html>
