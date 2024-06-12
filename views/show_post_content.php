<?php
session_start();

if (!isset($_SESSION['userid'])) {
    echo "<script>location.replace('./views/login.html');</script>";
    exit;
}
$userId = $_SESSION['userid'];
$username = $_SESSION['username'];

$id = $_GET['id'];
include "../db_conn.php";

$updateViewsSql = "UPDATE posts_tb SET post_hit = post_hit + 1 WHERE post_id = $id";
mysqli_query($db, $updateViewsSql);

$sql = "SELECT PO.post_subject, PO.post_content, PO.post_date, PO.post_hit, PO.post_like, U.user_id, U.user_name, P.pet_type, P.pet_breed
        FROM posts_tb PO, users_tb U, pets_tb P
        WHERE PO.post_id = $id AND U.user_id = PO.post_user_id AND P.pet_id = PO.post_pet_id;";
$rsl = mysqli_fetch_assoc(mysqli_query($db, $sql));

$getCommentSql = "SELECT C.comment_text, U.user_name
                  FROM comments_tb C, users_tb U
                  WHERE C.comment_post_id = '$id' AND C.comment_user_id = U.user_id";
$comments = mysqli_query($db, $getCommentSql);

$postSubject = $rsl['post_subject'];
$postContent = $rsl['post_content'];
$postDate = $rsl['post_date'];
$postMonth = substr($postDate, 0, 2);
$postDay = substr($postDate, 2, 2);
$postYear = substr($postDate, 4);
$postDate = $postMonth . ' / ' . $postDay . ' / ' . $postYear;
$postHit = $rsl['post_hit'];
$postLike = $rsl['post_like'];
$postWriterId = $rsl['user_id'];
$postWriter = $rsl['user_name'];
$petType = $rsl['pet_type'];
$petBreed = $rsl['pet_breed'];

$checkLikeSql = "SELECT count(*) FROM likes_tb WHERE post_id = $id AND user_id = '$userId'";
$isLike = mysqli_query($db, $checkLikeSql);

mysqli_close($db);

?>
<!doctype html>
<html lang="en">
<head>
    <title>main</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../main.css">
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

        .post-wrapper {
            width: 90%;
        }

        .post-header {
            font-size: 30px;
            font-weight: bold;
        }

        .post-header2 {
            display: flex;
        }

        .post-writer {
            margin-left: auto;
        }

        .post-content {
            margin: 10px 0;
            padding 100px;
            width: 100%;
            height: 500px;
            border: 1px solid var(--main-color);
            border-radius: 20px;
            font-size: 20px;
        }

        .post-footer {
            width: 100%;
            font-size: 25px;
            display: flex;
            justify-content: space-between;
        }

        .left-container {
            display: flex;
        }

        .left-container > div {
            padding: 0 10px;
        }

        input[type=button] {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            color: white;
        }

        .register-btn {
            background-color: var(--main-color);
        }

        .register-btn:hover {
            background-color: #8B715F;
        }

        .dislike-btn {
            background-color: #CCCCCC;
        }

        .dislike-btn:hover {
            background-color: #AAAAAA;
        }

        .like-btn {
            background-color: #FF4500;
        }

        .like-btn:hover {
            background-color: #FF6347;
        }

        input[type=button]#delete-btn {
            background-color: #CD5C5C;
        }

        input[type=button]#delete-btn:hover {
            background-color: #B22222;
        }

        .comment-container {
            display: flex;
            flex-direction: column;
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid var(--main-color);
            border-radius: 10px;
            width: 50%;
            margin: 50px 0;
        }

        .register-wrapper {
            width: 100%;
            height: auto;
            padding: 10px 0 60px;
            display: flex;
            float: left;
            position: relative;
        }

        .register-heading {
            padding: 0;
            margin: 10px;
            font-size: 28px;
            font-weight: bold;
        }

        .btn-container {
            position: absolute;
            bottom: 20px;
            right: 10px;
        }

        input[type=text] {
            width: 100%;
            height: 35px;
            margin: 10px;
            padding: 10px 20px;
            background-color: #ffffff;
            border: 1px solid var(--main-color);
            border-radius: 5px;
            font-size: 20px;
            resize: none;
        }

        .valid_chk {
            width: 250px;
            height: 70px;
            color: #ff0000;
            display: none;
            font-size: 15px;
        }

        .comment-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .comment-text {
            flex: 1;
            font-size: 16px;
        }

        .comment-writer {
            font-size: 14px;
            color: #666;
            margin-left: 10px;
        }


        @media (max-width: 1000px) {
            .post-header2 {
                display: flex;
                flex-direction: column;
            }

            .comment-container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
<header>
    <div class="header-home">
        <div class="home-wrapper" onclick="location.href = '/wp_project'">
            <img class="logo" id="main-icon" src="../img/logo.png" alt="logo"/>
            <span>Along with the pet</span>
        </div>
        <nav id="nav-links">
            <div class="home-nav" onclick="location.href='./show_pet_info.php'"><span>My Pets</span></div>
            <div class="home-nav" onclick="location.href='./show_my_posts.php'"><span>My Posts</span></div>
        </nav>
    </div>
    <div class="header-icons">
        <img class="logo" id="profile-icon" src="../img/profile.png" alt="profile"
             onclick="location.href='./show_user_info.php'"/>
        <img class="logo" id="menu-icon" src="../img/menu.png" alt="menu" onclick="toggleMenu()"/>
    </div>
</header>
<div class="container">
    <div class="heading">
        <span>Post</span>
    </div>
    <div class="post-wrapper">
        <div class="post-header">
            <div class="post-subject">Title : <?php echo $postSubject ?></div>
            <div class="post-header2">
                <div class="pet-type">Type : <?php echo $petType ?></div>
                <div class="pet-type">, Breed : <?php echo $petBreed ?></div>
                <div class="post-writer"><?php echo "Writer : " . $postWriter ?></div>
            </div>
        </div>
        <div class="post-content"><?php echo $postContent ?></div>
        <div class="post-footer">
            <div class="left-container">
                <label>Views</label>
                <div class="post-view"><?php echo $postHit ?></div>
                <label>Likes</label>
                <div class="post-like"><?php echo $postLike ?></div>
            </div>
            <div class="like-container">
                <?php
                if ($postWriterId == $userId) {
                    echo '<input type="button" class="delete" id="delete-btn" value="Delete"/>';
                }
                ?>
                <?php
                if (mysqli_fetch_assoc($isLike)['count(*)'] == '1') {
                    echo '<input type="button" class="dislike-btn" id="like-btn" value="Dislike"/>';
                } else {
                    echo '<input type="button" class="like-btn" id="like-btn" value="Like"/>';
                }
                ?>
            </div>
        </div>
    </div>
    <div class="comment-container">
        <div class="register-heading">Comments</div>
        <form id="register-form" action="../post_services/add_comment.php" method="post">
            <input type="hidden" name="post_id" value="<?php echo $id ?>" />
            <div class="register-wrapper">
                <input type="text" id="comment" name="comment"/>
                <div class="left-container">
                    <div class="valid_chk">(Warning message)</div>
                </div>
                <div class="btn-container">
                    <input type="button" class="register-btn" value="Register"/>
                </div>
            </div>
        </form>
        <?php
        while ($row = mysqli_fetch_array($comments)) {
            echo '<div class="comment-wrapper">';
            echo '<div class="comment-text">' . $row["comment_text"] . '</div>';
            echo '<div class="comment-writer">' . $row["user_name"] . '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>
<script src="../toggle.js"></script>
<script>
    let id = "<?php echo $id ?>";
    let likeBtn = document.getElementById('like-btn');
    likeBtn.addEventListener('click', () => {
        let url = "../user_services/like_post.php?id=" + id;
        fetch(url)
            .then(response => response.text())
            .then(data => {
                document.querySelector('.post-like').innerText = data;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        if (likeBtn.classList.contains('like-btn')) {
            likeBtn.classList.remove('like-btn');
            likeBtn.classList.add('dislike-btn');
            likeBtn.value = 'Dislike';
        } else {
            likeBtn.classList.remove('dislike-btn');
            likeBtn.classList.add('like-btn');
            likeBtn.value = 'Like';
        }
    });

    let commentRegisterBtn = document.querySelector('.register-btn');
    commentRegisterBtn.addEventListener('click', () => {
        document.getElementById('register-form').submit();
    });
</script>
</body>
</html>