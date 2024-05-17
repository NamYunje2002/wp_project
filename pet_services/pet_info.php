<?php

session_start();

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please log in and use it.')</script>";
    echo "<script>location.replace('./user_views/login.html');</script>";
    exit;
}

include "../db_conn.php";
$userId = $_SESSION['userid'];
$showPetsSql = "SELECT pet_name, pet_birth, pet_gender, pet_etc, pet_type, pet_type_detailed FROM pets_tb AS P, users_tb U WHERE P.pet_owner = U.user_id AND P.pet_owner = '$userId'";
$rsl = mysqli_query($db, $showPetsSql);
?>

<html lang="en">
<head>
    <title>main</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100..900&display=swap" rel="stylesheet">
    <style>
        .container {
            padding: 20px 0;
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

        .sub-heading {
            font-size: 28px;
            margin: 40px 0 20px;
            font-weight: bold;
        }

        #add-heading {
            display: none;
        }

        .profile-container {
            display: flex;
            height: 350px;
            position: relative;
            border: 1px solid var(--main-color);
            border-radius: 20px;
            font-size: 24px;
        }

        #add-container {
            height: auto;
            padding: 100px 0;
            display: none;
        }

        .pet-add-form {
            display: flex;
            flex: 1;
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
        }

        .left_container {
            text-align: left;
            width: 90%;
        }

        div.left_container > span {
            display: block;
            width: 100%;
            text-align: left;
            font-size: 15px;
            font-weight: bold;
        }

        select {
            width: 80px;
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

        .photo-wrapper, .info-wrapper, .etc-wrapper {
            flex: 1;
            align-items: center;
            justify-content: center;
            display: flex;
            flex-direction: column;
            height: 100%; /* 각 wrapper의 높이를 100%로 설정합니다. */
        }

        .photo-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .info-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .etc-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .info {
            text-align: center;
            margin: 10px 0;
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

        input[type=button]#cancel-btn {
            background-color: #ffffff;
            border: 1px solid var(--main-color);
            color: var(--main-color);
        }

        input[type=button]#cancel-btn:hover {
            background-color: #e6e6e6;
        }

        .basic-info-btn-container {
            position: absolute;
            bottom: 20px;
            right: 20px;
        }

    </style>
</head>
<body>
<header>
    <div class="header-left-container">
        <div class="home" id="home" onclick="location.href = '/wp_project'">
            <img class="logo" id="main_logo" src="../img/logo.png" alt="logo"/>
            <span>PET</span>
        </div>
        <nav>
            <div id="mypets" class="nav-div" onclick="location.href='/wp_project/pet_services/pet_info.php'"><span>My Pets</span>
            </div>
            <div id="types" class="nav-div"><span>Types</span></div>
        </nav>
    </div>
    <img class="logo" id="profile" src="../img/profile.png" alt="profile"
         onclick="location.href='/wp_project/user_services/profile.php'"/>
</header>
<div class="container">
    <div class="heading"><span>My Pets</span><input type="button" id="open-add-form-btn" value="Add my pet"/></div>
    <div class="sub-heading" id="add-heading">Add my pet</div>
    <div class="profile-container" id="add-container">
        <form class="pet-add-form" action="./add_pet.php" method="post">
            <div class="photo-wrapper"></div>
            <div class="info-wrapper">
                <div class="left_container">
                    <span>Name</span>
                </div>
                <input type="text" id="name" name="name"/>
                <div class="left_container">
                    <div class="valid_chk" id="name_valid">Enter your pet's name up to 20 characters.</div>
                </div>
                <div class="left_container">
                    <span>Birthday</span>
                </div>
                <div>
                    <select id="month" name="month">
                        <option selected disabled>Month</option>
                    </select>
                    <select id="year" name="year">
                        <option selected disabled>Year</option>
                    </select>
                </div>
                <div class="left_container">
                    <div class="valid_chk" id="birth_valid">Select your pet's date of birth.</div>
                </div>

                <div class="left_container">
                    <span>Gender</span>
                </div>
                <div class="left_container">
                    <label for="male">Male</label><input type="radio" name="gender" value="m" id="male">
                    <label for="female">Female</label><input type="radio" name="gender" value="f" id="female">
                </div>
                <div class="left_container">
                    <div class="valid_chk" id="gender_valid">Select your pet's gender.</div>
                </div>
            </div>
            <div class="etc-wrapper">
                <div class="left_container">
                    <span>Description</span>
                </div>
                <input type="text" id="name" name="name"/>
            </div>
            <div class="basic-info-btn-container">
                <input type="button" id="cancel-btn" value="Cancel"/>
                <input type="button" id="add-btn" value="Add"/>
            </div>
        </form>
    </div>
    <?php
    while ($row = mysqli_fetch_array($rsl)) {
        $petName = $row['pet_name'];
        $petType = $row['pet_type'];
        $petTypeDetail = $row['pet_type_detailed'];
        $petBirth = $row['pet_birth'];
        $petGender = ($row['pet_gender'] == 'm' ? 'Male' : 'Female');
        $petEtc = $row['pet_etc'];

        $petBirthY = (int)(substr($petBirth, 2, 4));
        $petBirthM = (int)(substr($petBirth, 0, 2));
        $todayY = (int)date("Y");
        $todayM = (int)date("m");
        $petAge = $todayY - $petBirthY;

        $petAgeM = 0;
        if ($petBirthM <= $todayM) {
            $petAgeM += 12 * $petAge;
            $petAgeM += ($todayM - $petBirthM);
        } else {
            $petAgeM += 12 * ($petAge - 1);
            $petAgeM += (12 - ($petBirthM - $todayM));
        }

        echo '<div class="sub-heading">' . $petType . '</div>';
        echo '<div class="profile-container">';
        echo '<div class="photo-wrapper">';
        echo '</div>';
        echo '<div class="info-wrapper">';
        echo '<div class="info">' . $petName . '</div>';
        echo '<div class="info">' . $petAge . ' years old (' . $petAgeM . ' months)</div>';
        echo '<div class="info">' . $petGender . '</div>';
        echo '</div>';
        echo '<div class="etc-wrapper">';
        echo '<div class="etc">' . $petEtc . '</div>';
        echo '</div>';
        echo '<div class="basic-info-btn-container">';
        echo '<input type="button" value="Modify" id="info-modify-btn"/>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>
<script src="../user_services/signup_valid_chk.js"></script>
<script>
    let addContainer = document.getElementById('add-container');
    let addHeading = document.getElementById('add-heading');
    document.getElementById('open-add-form-btn').addEventListener('click', () => {
        addContainer.style.display = 'block';
        addHeading.style.display = 'block';
    });

    document.getElementById('cancel-btn').addEventListener('click', () => {
        addContainer.style.display = 'none';
        addHeading.style.display = 'none';
    });

    document.getElementById('add-btn').addEventListener('click', () => {
        document.getElementById('pet-add-form').submit();
    });
</script>
</html>
