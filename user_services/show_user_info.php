<?php

session_start();

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please log in and use it.')</script>";
    echo "<script>location.replace('./user_views/login.html');</script>";
    exit;
}

include "../db_conn.php";

$userId = $_SESSION['userid'];

$getUserInfoSql = "SELECT user_name, user_email, user_birth, user_gender FROM users_tb WHERE user_id = '$userId'";
$rsl = mysqli_query($db, $getUserInfoSql);

$infoArr = $rsl->fetch_array();
$userName = $infoArr['user_name'];
$userEmail = $infoArr['user_email'];
$userBirth = $infoArr['user_birth'];
$userGender = ($infoArr['user_gender'] == 'm' ? 'Male' : 'Female');

$userMonth = substr($userBirth, 0, 2);
$userDay = substr($userBirth, 2, 2);
$userYear = substr($userBirth, 4);

$userBirth = $userMonth . ' / ' . $userDay . ' / ' . $userYear;
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
        div.container {
            padding: 20px 0;
        }

        div.heading {
            font-size: 34px;
            margin: 40px 0;
            font-weight: bold;
        }

        div.sub-heading {
            font-size: 28px;
            margin: 40px 0 20px;
            font-weight: bold;
        }

        div.profile {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 50px 0;
            width: 100%;
            border: 1px solid var(--main-color);
            border-radius: 20px;
            font-size: 24px;
        }

        div#profile-info-div {
            width: 100%;
        }

        div.profile-info {
            margin: 20px 0;
        }

        div#profile-pw-div {
            justify-content: space-between;
        }

        div#info-name {
            font-size: 28px;
        }

        div#info-birth, #info-email, #info-gender {
            color: #717171;
        }

        input[type=button] {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type=button]#info-modify-btn, #info-confirm-btn {
            background-color: var(--main-color);
            color: white;
            border: none;
        }

        input[type=button]#info-cancel-btn {
            background-color: #ffffff;
            border: 1px solid var(--main-color);
            color: var(--main-color);
        }

        input[type=button]#info-cancel-btn:hover {
            background-color: #e6e6e6;
        }

        input[type=button]#pw-change-btn {
            background-color: #ffffff;
            border: 1px solid #717171;
        }

        input[type=button]#pw-change-btn {
            background-color: #ffffff;
            border: 1px solid #717171;
        }

        input[type=button]#info-modify-btn:hover, #info-confirm-btn:hover {
            background-color: #8B715F;
        }

        form {
            display: flex;
            flex-direction: column;
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
        }

        a {
            text-decoration: none;
            color: var(--main-color);
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

        div#modify-div {
            display: none;
            text-align: center;
        }

        div.valid_chk {
            width: 250px;
            height: 70px;
            color: #ff0000;
            display: none;
            font-size: 15px;
        }

        div#email_valid, #birth_valid, #gender_valid {
            height: 50px;
        }

        .basic-info-btn-container {
            position: absolute;
            bottom: 20px;
            right: 20px;
        }

        .password-info {
            margin-left: 50px;
        }

        .password-btn-container {
            margin-right: 50px;
        }
    </style>
</head>
<body>
<header>
    <div class="header-home">
        <div class="home-wrapper" id="home" onclick="location.href = '/wp_project'">
            <img class="logo" id="main_logo" src="../img/logo.png" alt="logo"/>
            <span>PET</span>
        </div>
        <nav>
            <div class="home-nav" onclick="location.href='../pet_services/show_pet_info.php'"><span>My Pets</span></div>
            <div class="home-nav"><span>Types</span></div>
        </nav>
    </div>
    <img class="logo" src="../img/profile.png" alt="profile" onclick="location.href='show_user_info.php'"/>
</header>
<div class="container">
    <div class="heading">Profile</div>
    <div class="sub-heading">Basic Information</div>
    <div class="profile">
        <div id="profile-info-div" style="text-align: center">
            <div class="profile-info" id="info-name"><?php echo $userName ?></div>
            <div class="profile-info" id="info-email"><?php echo $userEmail ?></div>
            <div class="profile-info" id="info-birth"><?php echo $userBirth ?></div>
            <div class="profile-info" id="info-gender"><?php echo $userGender ?></div>
            <div class="basic-info-btn-container">
                <input type="button" value="Modify" id="info-modify-btn"/>
            </div>
        </div>
        <div id="modify-div">
            <form id="modify-form" action="modify_user_info.php" method="post">
                <div class="left_container">
                    <span>Name</span>
                </div>
                <input type="text" id="name" name="name" value="<?php echo $userName ?>"/>
                <div class="left_container">
                    <div class="valid_chk" id="name_valid">Enter a combination of 2 to 14 numbers and characters.</div>
                </div>

                <div class="left_container">
                    <span>Email</span>
                </div>
                <input type="text" id="email" name="email" value="<?php echo $userEmail ?>" />
                <div class="left_container">
                    <div class="valid_chk" id="email_valid">Enter a valid email.</div>
                </div>

                <div class="left_container">
                    <span>Birthday</span>
                </div>
                <div>
                    <select data-user-month="<?php echo $userMonth; ?>" id="month" name="month"><option selected disabled>Month</option></select>
                    <select data-user-day="<?php echo $userDay; ?>" id="day" name="day"><option selected disabled>Day</option></select>
                    <select data-user-year="<?php echo $userYear; ?>" id="year" name="year"><option selected disabled>Year</option></select>
                </div>
                <div class="left_container">
                    <div class="valid_chk" id="birth_valid">Select your date of birth.</div>
                </div>

                <div class="left_container">
                    <span>Gender</span>
                </div>
                <div class="left_container">
                    <label for="male">Male</label><input type="radio" name="gender" value="m" id="male" <?php if($userGender == "Male") echo 'checked'; ?> >
                    <label for="female">Female</label><input type="radio" name="gender" value="f" id="female" <?php if($userGender == "Female") echo 'checked'; ?> >
                </div>
                <div class="left_container">
                    <div class="valid_chk" id="gender_valid">Select your gender.</div>
                </div>
                <div class="basic-info-btn-container">
                    <input type="button" id="info-cancel-btn" value="Cancel"/>
                    <input type="button" id="info-confirm-btn" value="Confirm"/>
                </div>
            </form>
        </div>
    </div>
    <div class="sub-heading">Password</div>
    <div class="profile" id="profile-pw-div">
        <div class="password-info">password</div>
        <div class="password-btn-container"><input type="button" value="Change password" id="pw-change-btn" /></div>
    </div>
</div>
<script src="../user_services/signup_valid_chk.js"></script>
<script>
    let birthArray = ['month', 'day', 'year'];
    for(let i = 0; i < birthArray.length; i++) {
        document.getElementById(birthArray[i]).addEventListener("blur", isBirthValid(i));
    }

    let fieldArray = ['id', 'pw', 'name', 'email'];
    for (let i = 2; i < fieldArray.length; i++) {
        document.getElementById(fieldArray[i]).addEventListener("blur", isInputValid(i));
    }

    document.getElementById('home').addEventListener('click', () => {
        location.href = '/wp_project';
    });

    document.getElementById('profile').addEventListener('click', () => {
        location.href = 'show_user_profile.php';
    });

    let modifyDiv = document.getElementById('modify-div');
    let profileInfoDiv = document.getElementById('profile-info-div');
    document.getElementById('info-modify-btn').addEventListener('click', () => {
        modifyDiv.style.display = 'block';
        profileInfoDiv.style.display = 'none';
    });

    document.getElementById('info-cancel-btn').addEventListener('click', () => {
        modifyDiv.style.display = 'none';
        profileInfoDiv.style.display = 'block';
    });

    let monthArr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    let monthSelect = document.getElementById('month');
    let userMonth = monthSelect.getAttribute('data-user-month');
    for(let i = 0; i < monthArr.length; i++) {
        let option = document.createElement('option');
        option.value = i+1;
        option.text = monthArr[i];
        monthSelect.appendChild(option);
        if(i+1 == userMonth) option.selected = true;
    }

    let daySelect = document.getElementById('day');
    let userDay = daySelect.getAttribute('data-user-day');
    for(let i = 1; i <= 31; i++) {
        let option = document.createElement('option');
        option.value = i;
        option.text = i;
        daySelect.appendChild(option);
        if(i == userDay) option.selected = true;
    }

    let curYear = new Date().getFullYear();
    let yearSelect = document.getElementById('year');
    let userYear = yearSelect.getAttribute('data-user-year');
    for(let i = curYear; i >= curYear-100; i--) {
        let option = document.createElement('option');
        option.value = i;
        option.text = i;
        yearSelect.appendChild(option);
        if(i == userYear) option.selected = true;
    }

    document.getElementById('info-confirm-btn').addEventListener("click", () => {
        let allFieldsValid = true;
        for (let i = 2; i < fieldArray.length; i++) {
            let inputValid = isInputValid(i)();
            if(!inputValid) allFieldsValid = false;
        }

        for(let i = 0; i < birthArray.length; i++) {
            let birthValid = isBirthValid(i)();
            if(!birthValid) allFieldsValid = false;
        }

        let male = document.getElementById('male');
        let female = document.getElementById('female');
        let genderValid = document.getElementById('gender_valid');
        if (!male.checked && !female.checked) {
            genderValid.style.display = 'block';
            allFieldsValid = false;
        } else {
            genderValid.style.display = 'none';
        }

        if (allFieldsValid) {
            document.getElementById('modify-form').submit();
        }
    });
</script>
</html>
