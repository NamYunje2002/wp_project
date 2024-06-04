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
            display: flex;
            flex-direction: column;
            padding: 20px 50px;
            height: auto;
        }

        div.heading {
            font-size: 34px;
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

        input[type=button] {
            background-color: var(--main-color);
            color: white;
            border: none;
        }

        input[type=button]:hover {
            background-color: #8B715F;
        }

        input[type=button].negative-btn {
            background-color: #ffffff;
            border: 1px solid var(--main-color);
            color: var(--main-color);
        }

        input[type=button]#info-cancel-btn:hover {
            background-color: #e6e6e6;
        }

        input[type=button]#user-delete-btn {
            background-color: #CD5C5C;
        }

        input[type=button]#user-delete-btn:hover {
            background-color: #B22222;
        }

        form {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        #modify-form {
            align-items: center;
            margin: 20px;
        }

        input[type=text], input[type=password] {
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

        .btn-container {
            margin: 20px 50px;
            justify-content: space-between;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            position:relative;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            border-radius: 10px;
            width: 60%;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
        }

        #modal-wrapper {
            height: 400px;
            padding: 100px 0;
        }

        #modal-heading {
            padding: 0;
            margin: 10px;
        }
        
        @media (max-width: 1000px) {
            #sensitive-info-wrapper {
                flex-direction: column;
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
            <div class="home-nav"><span>My Posts</span></div>
            <div class="home-nav"><span>Types</span></div>
        </nav>
    </div>
    <div class="header-icons">
        <img class="logo" id="profile-icon" src="../img/profile.png" alt="profile" onclick="location.href='./show_user_info.php'"/>
        <img class="logo" id="menu-icon" src="../img/menu.png" alt="menu" onclick="toggleMenu()"/>
    </div>
</header>
<div class="container">
    <div style="display: flex;">
    <div class="heading">Profile</div>
    <input type="button" value="Logout" id="logout-btn"/>
    </div>
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
            <form id="modify-form" action="../user_services/modify_user_info.php" method="post">
                <div class="left-container">
                    <span>Name</span>
                </div>
                <input type="text" id="name" name="name" value="<?php echo $userName ?>"/>
                <div class="left-container">
                    <div class="valid_chk" id="name_valid">Enter a combination of 2 to 14 numbers and characters.</div>
                </div>

                <div class="left-container">
                    <span>Email</span>
                </div>
                <input type="text" id="email" name="email" value="<?php echo $userEmail ?>" />
                <div class="left-container">
                    <div class="valid_chk" id="email_valid">Enter a valid email.</div>
                </div>

                <div class="left-container">
                    <span>Birthday</span>
                </div>
                <div>
                    <select data-user-month="<?php echo $userMonth; ?>" id="month" name="month"><option selected disabled>Month</option></select>
                    <select data-user-day="<?php echo $userDay; ?>" id="day" name="day"><option selected disabled>Day</option></select>
                    <select data-user-year="<?php echo $userYear; ?>" id="year" name="year"><option selected disabled>Year</option></select>
                </div>
                <div class="left-container">
                    <div class="valid_chk" id="birth_valid">Select your date of birth.</div>
                </div>

                <div class="left-container">
                    <span>Gender</span>
                </div>
                <div class="left-container">
                    <label for="male">Male</label><input type="radio" name="gender" value="m" id="male" <?php if($userGender == "Male") echo 'checked'; ?> >
                    <label for="female">Female</label><input type="radio" name="gender" value="f" id="female" <?php if($userGender == "Female") echo 'checked'; ?> >
                </div>
                <div class="left-container">
                    <div class="valid_chk" id="gender_valid">Select your gender.</div>
                </div>
                <div class="basic-info-btn-container">
                    <input type="button" class="negative-btn" id="info-cancel-btn" value="Cancel"/>
                    <input type="button" class="positive-btn" id="info-confirm-btn" value="Confirm"/>
                </div>
            </form>
        </div>
    </div>
    <div class="modal" id="modify-modal" >
        <div class="modal-content">
            <div class="sub-heading" id="modal-heading">Change your password</div>
            <div class="profile-container" id="modal-wrapper">
                <form id="pw-change-form" method="post" action="../user_services/change_pw.php">
                    <div class="left-container">
                        <span>Origin password</span>
                    </div>
                    <input type="password" id="origin-pw" name="origin_pw"/>
                    <div class="left-container">
                        <div class="valid_chk" id="name_valid">Enter a combination of 2 to 14 numbers and characters.</div>
                    </div>
                    <div class="left-container">
                        <span>New password</span>
                    </div>
                    <input type="password" id="new-pw" name="new_pw"/>
                    <div class="left-container">
                        <div class="valid_chk" id="name_valid">Enter a combination of 2 to 14 numbers and characters.</div>
                    </div>
                    <div class="basic-info-btn-container">
                        <input type="button" class="negative-btn" id="change-cancel-btn" value="Cancel"/>
                        <input type="button" id="change-confirm-btn" value="change"/>
                    </div>
                    <input type="hidden" id="pet-id" name="pet_id" value="">
                </form>
            </div>
        </div>
    </div>
    <div class="sub-heading">Sensitive information</div>
    <div class="profile" id="sensitive-info-wrapper">
        <div class="btn-container"><input type="button" value="Change your password" id="pw-change-btn" /></div>
        <div class="btn-container"><input type="button" value="Delete your account" id="user-delete-btn" /></div>
    </div>
</div>
</body>
<script src="../user_services/signup_valid_chk.js"></script>
<script src="../toggle.js"></script>
<script>
    let birthArray = ['month', 'day', 'year'];
    for(let i = 0; i < birthArray.length; i++) {
        document.getElementById(birthArray[i]).addEventListener("blur", isBirthValid(i));
    }

    let fieldArray = ['id', 'pw', 'name', 'email'];
    for (let i = 2; i < fieldArray.length; i++) {
        document.getElementById(fieldArray[i]).addEventListener("blur", isInputValid(i));
    }

    document.querySelector('.home-wrapper').addEventListener('click', () => {
        location.href = '/wp_project';
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

    const pwChangeBtn = document.getElementById('pw-change-btn');
    const changeCancelBtn = document.getElementById('change-cancel-btn');
    const changeConfirmBtn = document.getElementById('change-confirm-btn');
    const userDeleteBtn = document.getElementById('user-delete-btn');

    pwChangeBtn.addEventListener('click', () => {
       let modal = document.querySelector('.modal');
       modal.style.display = 'block';
    });

    changeCancelBtn.addEventListener('click', () => {
        let modal = document.querySelector('.modal');
        modal.style.display = 'none';
    });

    changeConfirmBtn.addEventListener('click', () => {
        const pwChangeForm = document.getElementById('pw-change-form');
        pwChangeForm.submit();
    });

    userDeleteBtn.addEventListener('click', () => {
        if(confirm('Are you sure you want to delete your account?')) {
            location.href="../user_services/delete_user.php";
        }
    });

    document.getElementById('logout-btn').addEventListener('click', () => {
        if(confirm('Are you sure you want to log out?')) {
            location.href="../user_services/logout.php";
        }
    })
</script>
</html>
