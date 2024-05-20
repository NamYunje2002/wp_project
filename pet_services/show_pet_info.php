<?php

session_start();

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please log in and use it.')</script>";
    echo "<script>location.replace('./user_views/login.html');</script>";
    exit;
}

include "../db_conn.php";
$userId = $_SESSION['userid'];
$showPetsSql = "SELECT pet_name, pet_birth, pet_gender, pet_dec, pet_type, pet_breed, pet_img_name FROM pets_tb AS P, users_tb U WHERE P.pet_owner = U.user_id AND P.pet_owner = '$userId'";
$rsl = mysqli_query($db, $showPetsSql);
mysqli_close($db);
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
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

        #add-pet-container {
            height: auto;
            padding: 100px 0;
            display: none;
        }

        #add-pet-form {
            display: flex;
            flex: 1;
        }

        input[type=file] {
            display: none;
        }

        #preview-img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        #upload-wrapper, #pet-img-upload-btn  {
            margin-top: 20px;
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
            flex: 1;
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

        div.check-valid {
            width: 250px;
            height: 70px;
            color: #ff0000;
            display: none;
            font-size: 15px;
        }

        textarea#pet-des {
            width: 90%;
            height: 260px;
            margin: 10px;
            padding: 10px 20px;
            background-color: #ffffff;
            border: 1px solid var(--main-color);
            border-radius: 5px;
            font-size: 20px;
            box-sizing: border-box;
            resize: none;
        }

        .photo-wrapper, .info-wrapper, .dec-wrapper {
            flex: 1;
            align-items: center;
            justify-content: center;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .photo-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .pet-img {
            border: 2px solid var(--main-color);
            position: relative;
            border-radius: 50%;
            overflow: hidden;
            width: 200px;
            height: 200px;
        }

        .info-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .dec-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100%;
            width: 100%;
            overflow: hidden;
        }

        .dec {
            width: 100%;
            height: 260px;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 10px;
            box-sizing: border-box;
            word-wrap: break-word;
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
    <div class="header-home">
        <div class="home-wrapper" id="home" onclick="location.href = '/wp_project'">
            <img class="logo" id="main_logo" src="../img/logo.png" alt="logo"/>
            <span>Along with the pet</span>
        </div>
        <nav>
            <div class="home-nav" onclick="location.href='../pet_services/show_pet_info.php'"><span>My Pets</span></div>
            <div class="home-nav"><span>My Posts</span></div>
            <div class="home-nav"><span>Types</span></div>
        </nav>
    </div>
    <img class="logo" src="../img/profile.png" alt="profile"
         onclick="location.href='../user_services/show_user_info.php'"/>
</header>
<div class="container">
    <div class="heading">
        <span>My Pets</span><input type="button" id="open-add-form-btn" value="Add my pet"/>
    </div>
    <div class="sub-heading" id="add-heading">Add my pet</div>
    <div class="profile-container" id="add-pet-container">
        <form id="add-pet-form" action="./add_pet.php" method="post" enctype="multipart/form-data">
            <div class="photo-wrapper">
                <div class="left-container">
                    <span>Upload Pet Image</span>
                </div>
                <div class="pet-img" id="upload-wrapper">
                    <input type="file" id="upload-pet-img" name="pet_img">
                    <img id="preview-img" src="#" alt="preview">
                </div>
                <input type="button" value="Upload" id="pet-img-upload-btn"/>
            </div>
            <div class="info-wrapper">
                <div class="left-container">
                    <span>Type</span>
                </div>
                <div class="select-wrapper">
                    <select id="pet-type" name="pet_type">
                        <option selected disabled>Type</option>
                    </select>
                    <select id="pet-breed" name="pet_breed">
                        <option selected disabled>Breed</option>
                    </select>
                </div>
                <div class="left-container">
                    <span>Name</span>
                </div>
                <input type="text" id="pet-name" name="pet_name"/>
                <div class="left-container">
                    <div class="check-valid" id="name_valid">Enter your pet's name up to 20 characters.</div>
                </div>
                <div class="left-container">
                    <span>Birthday</span>
                </div>
                <div class="select-wrapper">
                    <select id="pet-month" name="pet_month">
                        <option selected disabled>Month</option>
                    </select>
                    <select id="pet-year" name="pet_year">
                        <option selected disabled>Year</option>
                    </select>
                </div>
                <div class="left-container">
                    <div class="check-valid">Select your pet's date of birth.</div>
                </div>

                <div class="left-container">
                    <span>Gender</span>
                </div>
                <div class="left-container">
                    <label for="male">Male</label><input type="radio" name="pet_gender" value="m" id="male">
                    <label for="female">Female</label><input type="radio" name="pet_gender" value="f" id="female">
                </div>
                <div class="left-container">
                    <div class="check-valid">Select your pet's gender.</div>
                </div>
            </div>
            <div class="dec-wrapper">
                <div class="left-container">
                    <span>Description</span>
                </div>
                <textarea id="pet-des" name="pet_des" rows="2"></textarea>
            </div>
            <div class="basic-info-btn-container">
                <input type="button" id="cancel-btn" value="Cancel"/>
                <input type="button" id="add-pet-btn" value="Add"/>
            </div>
        </form>
    </div>
    <?php
    while ($row = mysqli_fetch_array($rsl)) {
        $petName = $row['pet_name'];
        $petType = $row['pet_type'];
        $petBreed = $row['pet_breed'];
        $petBirth = $row['pet_birth'];
        $petGender = ($row['pet_gender'] == 'm' ? 'Male' : 'Female');
        $petDec = $row['pet_dec'];

        $petBirthY = (int)(substr($petBirth, 2, 4));
        $petBirthM = (int)(substr($petBirth, 0, 2));
        $todayY = (int)date("Y");
        $todayM = (int)date("m");
        $petAge = $todayY - $petBirthY;

        $petImgName = $row['pet_img_name'];

        $petAgeM = 0;
        if ($petBirthM <= $todayM) {
            $petAgeM += 12 * $petAge;
            $petAgeM += ($todayM - $petBirthM);
        } else {
            $petAgeM += 12 * ($petAge - 1);
            $petAgeM += (12 - ($petBirthM - $todayM));
        }

        echo '<div class="sub-heading">' . $petType;
        if ($petBreed != '') echo ' - ' . $petBreed;
        echo '</div>';
        echo '<div class="profile-container">';
        echo '<div class="photo-wrapper">';
        if($petImgName != '') {
            echo '<img class="pet-img" src="./pet_img/' . $petImgName . '" alt="pet-image"/>';
        } else {
            echo '<img class="pet-img" src="../img/logo.png"  alt="pet-image"/>';
        }
        echo '</div>';
        echo '<div class="info-wrapper">';
        echo '<div class="info">' . $petName . '</div>';
        echo '<div class="info">' . $petAge . ' years old (' . $petAgeM . ' months)</div>';
        echo '<div class="info">' . $petGender . '</div>';
        echo '</div>';
        echo '<div class="dec-wrapper">';
        echo '<div class="dec">' . $petDec . '</div>';
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
    const petImgUploadBtn = document.getElementById('pet-img-upload-btn');
    const petImgInput = document.getElementById('upload-pet-img');
    const previewImage = document.getElementById('preview-img');
    let cropper;

    petImgUploadBtn.addEventListener('click', function() {
        petImgInput.click();
    });

    petImgInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const imageUrl = event.target.result;
                previewImage.src = imageUrl;
                if (cropper) {
                    cropper.destroy(); // 기존의 Cropper 인스턴스가 있으면 제거
                }
                cropper = new Cropper(previewImage, {
                    aspectRatio: 1, // 자를 이미지의 가로세로 비율 (예: 1은 정사각형)
                    viewMode: 2, // 이미지가 최대한 크게 표시됨
                    background: false, // 배경을 투명하게 설정
                    autoCropArea: 1, // 자동으로 이미지를 자르는 영역 설정 (예: 1은 이미지 전체)
                });
            };
            reader.readAsDataURL(file);
        } else {
            previewImage.src = '#';
            if (cropper) {
                cropper.destroy(); // 파일 선택이 취소되면 Cropper 인스턴스 제거
            }
        }
    });


    let addContainer = document.getElementById('add-pet-container');
    let addHeading = document.getElementById('add-heading');
    let openAddFormBtn = document.getElementById('open-add-form-btn');
    openAddFormBtn.addEventListener('click', () => {
        addContainer.style.display = 'block';
        addHeading.style.display = 'block';
        openAddFormBtn.style.visibility = 'hidden';
    });

    document.getElementById('cancel-btn').addEventListener('click', () => {
        addContainer.style.display = 'none';
        addHeading.style.display = 'none';
        openAddFormBtn.style.visibility = '';
    });

    document.getElementById('add-pet-btn').addEventListener('click', () => {
        document.getElementById('add-pet-form').submit();
    });

    let monthArr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    let monthSelect = document.getElementById('pet-month');
    for (let i = 0; i < monthArr.length; i++) {
        monthSelect.appendChild(new Option(monthArr[i], (i + 1)));
    }

    let curYear = new Date().getFullYear();
    let yearSelect = document.getElementById('pet-year');
    for (let i = curYear; i >= curYear - 500; i--) {
        yearSelect.appendChild(new Option(i, i));
    }

    let petOptions = [
        {type: 'Dog', breeds: ['Puppy', 'Labrador Retriever', 'Golden Retriever']},
        {type: 'Cat', breeds: ['Siamese', 'Persian', 'Maine Coon']},
        {type: 'Bird', breeds: ['Parrot', 'Canary', 'Cockatiel']}
    ];

    let type = document.getElementById('pet-type');
    petOptions.forEach((option) => {
        type.appendChild(new Option(option.type, option.type))
    });

    function updateBreedOptions() {
        let breed = document.getElementById('pet-breed');
        breed.innerHTML = '';
        let defaultOption = new Option('Breed', '', true, true);
        defaultOption.disabled = true;
        breed.appendChild(defaultOption);

        let selectedBreeds = petOptions.find((option) => {
            return option.type.toLowerCase() === type.value.toLowerCase();
        }).breeds;
        selectedBreeds.forEach((b) => {
            breed.appendChild(new Option(b, b));
        })
    }

    type.addEventListener('change', () => updateBreedOptions());
</script>
</html>
