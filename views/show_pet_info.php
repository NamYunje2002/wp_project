<?php

session_start();

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please log in and use it.')</script>";
    echo "<script>location.replace('./user_views/login.html');</script>";
    exit;
}

include "../db_conn.php";
$userId = $_SESSION['userid'];
$showPetsSql = "SELECT pet_id, pet_name, pet_birth, pet_gender, pet_desc, pet_type, pet_breed, pet_img_name FROM pets_tb AS P, users_tb U WHERE P.pet_owner = U.user_id AND P.pet_owner = '$userId'";
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
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
            width: 800px;
            padding: 20px;
            border: 1px solid var(--main-color);
            border-radius: 20px;
            font-size: 24px;
        }

        #add-container {
            height: auto;
            padding: 100px 0;
            display: none;
        }

        form {
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

        #upload-wrapper, #img-upload-btn  {
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

        textarea.pet-desc {
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

        .photo-wrapper, .info-wrapper, .desc-wrapper {
            flex: 1;
            align-items: center;
            justify-content: center;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .desc-wrapper, .desc {
            width: auto;
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

        .desc-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100%;
            width: 100%;
            overflow: hidden;
        }

        .desc {
            width: 100%;
            height: 200px;
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

        input[type=button].cancel-btn {
            background-color: #ffffff;
            border: 1px solid var(--main-color);
            color: var(--main-color);
        }

        input[type=button].cancel-btn:hover {
            background-color: #e6e6e6;
        }

        input[type=button]#delete-btn {
            background-color: #CD5C5C;
            margin-right: auto;
        }

        input[type=button]#delete-btn:hover {
            background-color: #B22222;
        }

        .basic-info-btn-container {
            position: absolute;
            bottom: 20px;
            right: 20px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: auto;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
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

        @media screen and (max-width: 1000px) {
            .profile-container {
                flex-direction: column;
                width: 100%;
                height: auto;
            }

            .photo-wrapper, .info-wrapper, .desc-wrapper {
                width: 100%;
                margin-bottom: 20px;
            }

            .basic-info-btn-container {
                position: static;
                margin-top: 20px;
            }

            .desc-wrapper, .desc {
                height: auto;
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
    <div class="heading">
        <span>My Pets</span><input type="button" id="add-form-btn" value="Add my pet"/>
    </div>
    <div class="sub-heading" id="add-heading">Add my pet</div>
    <div class="profile-container" id="add-container">
        <form id="add-form" action="../pet_services/add_pet.php" method="post" enctype="multipart/form-data">
            <div class="photo-wrapper">
                <div class="left-container">
                    <span>Upload Pet Image</span>
                </div>
                <div class="pet-img" id="upload-wrapper">
                    <input type="file" id="upload-pet-img" name="pet_img">
                    <img id="preview-img" src="#" alt="preview">
                </div>
                <input type="button" value="Upload" id="img-upload-btn"/>
            </div>
            <div class="info-wrapper">
                <div class="left-container">
                    <span>Type</span>
                </div>
                <div class="select-wrapper">
                    <select class="pet-type" id="add-pet-type" name="pet_type">
                        <option selected disabled>Type</option>
                    </select>
                    <select class="pet-breed" id="add-pet-breed" name="pet_breed">
                        <option selected disabled>Breed</option>
                    </select>
                </div>
                <div class="left-container">
                    <div class="check-valid" id="add-pet-type-valid">Enter your pet's name up to 20 characters.</div>
                </div>
                <div class="left-container">
                    <span>Name</span>
                </div>
                <input type="text" class="pet-name" id="add-pet-name" name="pet_name"/>
                <div class="left-container">
                    <div class="check-valid" id="add-pet-name-valid">Enter your pet's name up to 20 characters.</div>
                </div>
                <div class="left-container">
                    <span>Birthday or Age</span>
                </div>
                <div class="select-wrapper">
                    <select class="pet-month" id="add-pet-month" name="pet_month">
                        <option selected disabled>Month</option>
                    </select>
                    <select class="pet-year" id="add-pet-year" name="pet_year">
                        <option selected disabled>Year</option>
                    </select>
                </div>
                <div class="left-container">
                    <div class="check-valid" id="add-pet-birth-valid">Select your pet's date of birth.</div>
                </div>

                <div class="left-container">
                    <span>Gender</span>
                </div>
                <div class="left-container">
                    <label for="male">Male</label><input type="radio" name="pet_gender" value="m">
                    <label for="female">Female</label><input type="radio" name="pet_gender" value="f">
                </div>
                <div class="left-container">
                    <div class="check-valid">Select your pet's gender.</div>
                </div>
            </div>
            <div class="desc-wrapper">
                <div class="left-container">
                    <span>Description</span>
                </div>
                <textarea class="pet-desc" name="pet_desc" rows="2"></textarea>
            </div>
            <div class="basic-info-btn-container">
                <input type="button" class="cancel-btn" id="add-cancel-btn" value="Cancel"/>
                <input type="button" id="add-btn" value="Add"/>
            </div>
        </form>
    </div>
    <div class="modal" id="modify-modal" >
        <div class="modal-content">
            <div class="sub-heading" id="modal-heading">Modify</div>
            <div class="profile-container" id="modal-wrapper">
            <form id="modify-form" action="../pet_services/modify_pet.php" method="post">
                <div class="photo-wrapper">
                    <div class="left-container">
                        <span>Upload Pet Image</span>
                    </div>
                    <div class="pet-img" id="upload-wrapper">
                        <input type="file" id="upload-pet-img" name="pet_img">
                        <img id="preview-img" src="#" alt="preview">
                    </div>
                    <input type="button" value="Upload" id="img-upload-btn"/>
                </div>
                <div class="info-wrapper">
                    <div class="left-container">
                        <span>Type</span>
                    </div>
                    <div class="select-wrapper">
                        <select class="pet-type" id="modify-pet-type" name="pet_type">
                            <option selected disabled>Type</option>
                        </select>
                        <select class="pet-breed" id="modify-pet-breed" name="pet_breed">
                            <option selected disabled>Breed</option>
                        </select>
                    </div>
                    <div class="left-container">
                        <span>Name</span>
                    </div>
                    <input type="text" class="pet-name" id="modify-pet-name" name="pet_name"/>
                    <div class="left-container">
                        <div class="check-valid" id="name_valid">Enter your pet's name up to 20 characters.</div>
                    </div>
                    <div class="left-container">
                        <span>Birthday</span>
                    </div>
                    <div class="select-wrapper">
                        <select class="pet-month" id="modify-pet-month" name="pet_month">
                            <option selected disabled>Month</option>
                        </select>
                        <select class="pet-year" id="modify-pet-year" name="pet_year">
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
                        <label for="male">Male</label><input type="radio" name="pet_gender" value="m" id="modify-pet-male">
                        <label for="female">Female</label><input type="radio" name="pet_gender" value="f" id="modify-pet-female">
                    </div>
                    <div class="left-container">
                        <div class="check-valid">Select your pet's gender.</div>
                    </div>
                </div>
                <div class="desc-wrapper">
                    <div class="left-container">
                        <span>Description</span>
                    </div>
                    <textarea class="pet-desc" id="modify-pet-desc" name="pet_desc" rows="2"></textarea>
                </div>
                <div class="basic-info-btn-container">
                    <input type="button" id="delete-btn" value="Delete"/>
                    <input type="button" class="cancel-btn" id="modify-cancel-btn" value="Cancel"/>
                    <input type="button" id="modify-modify-btn" value="Modify"/>
                </div>
                <input type="hidden" id="pet-id" name="pet_id" value="">
            </form>
            </div>
        </div>
    </div>
    <?php
    while ($row = mysqli_fetch_array($rsl)) {
        $petId = $row['pet_id'];

        $petName = $row['pet_name'];
        $petType = $row['pet_type'];
        $petBreed = $row['pet_breed'];
        $petBirth = $row['pet_birth'];
        $petGender = ($row['pet_gender'] == 'm' ? 'Male' : 'Female');
        $petDesc = $row['pet_desc'];

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

        echo '<div class="sub-heading" id="sub-heading-'.$petId.'">' . $petType;
        if ($petBreed != '') echo ' - ' . $petBreed;
        echo '</div>';
        echo '<div class="profile-container" id="pet-id-' . $petId . '">';
        echo '<div class="photo-wrapper">';
        if($petImgName != '') {
            echo '<img class="pet-img" src="../pet_services/pet_img/' . $petImgName . '" alt="pet-image"/>';
        } else {
            echo '<img class="pet-img" src="../img/logo.png"  alt="pet-image"/>';
        }
        echo '</div>';
        echo '<div class="info-wrapper">';
        echo '<div class="info">' . $petName . '</div>';
        echo '<div class="info">' . (substr($petBirth, 0, 2)) . ' / ' . $petBirthY . '</div>';
        echo '<div class="info" birth="'.$petBirth.'">' . $petAge . ' years old (' . $petAgeM . ' months)</div>';
        echo '<div class="info">' . $petGender . '</div>';
        echo '</div>';

            echo '<div class="desc-wrapper">';
            echo '<div class="desc">' . $petDesc . '</div>';
            echo '</div>';

        echo '<div class="basic-info-btn-container">';
        echo '<input pet-id=' . $petId . ' type="button" value="Modify" class="modify-btn"/>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>
<script src="../toggle.js"></script>
<script src="../user_services/signup_valid_chk.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script>
    const imgUploadBtn = document.getElementById('img-upload-btn');
    const petImgInput = document.getElementById('upload-pet-img');
    const previewImage = document.getElementById('preview-img');
    let cropper;

    imgUploadBtn.addEventListener('click', function() {
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
                    cropper.desctroy();
                }
                cropper = new Cropper(previewImage, {
                    aspectRatio: 1,
                    viewMode: 2,
                    background: false,
                    autoCropArea: 1,
                });
            };
            reader.readAsDataURL(file);
        } else {
            previewImage.src = '#';
            if (cropper) {
                cropper.desctroy();
            }
        }
    });

    document.getElementById('add-btn').addEventListener('click', () => {
        let addForm = document.getElementById('add-form');
        addForm.submit();
    });

    let addContainer = document.getElementById('add-container');
    let addHeading = document.getElementById('add-heading');
    let openAddFormBtn = document.getElementById('add-form-btn');
    openAddFormBtn.addEventListener('click', () => {
        addContainer.style.display = 'block';
        addHeading.style.display = 'block';
        openAddFormBtn.style.visibility = 'hidden';
    });

    document.getElementById('add-cancel-btn').addEventListener('click', () => {
        addContainer.style.display = 'none';
        addHeading.style.display = 'none';
        openAddFormBtn.style.visibility = '';
    });

    document.querySelectorAll('.modify-btn').forEach((button) => {
        button.addEventListener('click', () => {
            let petId = button.getAttribute('pet-id');
            document.querySelector('#pet-id').value = petId;

            let profileContainer = document.getElementById('pet-id-' + petId);

            let petTypeBreed = document.getElementById('sub-heading-'+petId).textContent.split(' - ');
            let petName = profileContainer.querySelector('.info:nth-child(1)').textContent;
            let petAge = profileContainer.querySelector('.info:nth-child(2)').textContent.split(' / ');
            let petGender = profileContainer.querySelector('.info:nth-child(4)').textContent;
            let petDesc = profileContainer.querySelector('.desc').textContent;

            document.getElementById('modify-pet-type').value = petTypeBreed[0];
            updateBreedOptions(1);
            if(petTypeBreed.length > 1) document.getElementById('modify-pet-breed').value = petTypeBreed[1];
            document.getElementById('modify-pet-name').value = petName;
            document.getElementById('modify-pet-month').value = parseInt(petAge[0]);
            document.getElementById('modify-pet-year').value = petAge[1];
            document.getElementById('modify-pet-' + petGender.toLowerCase()).checked = true;
            document.getElementById('modify-pet-desc').value = petDesc;
            document.getElementById('modify-modal').style.display = 'block';
        });
    });

    document.getElementById('modify-cancel-btn').addEventListener('click', () => {
        document.getElementById('modify-modal').style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === document.getElementById('modify-modal')) {
            document.getElementById('modify-modal').style.display = 'none';
        }
    });

    let modifyForm = document.getElementById('modify-form');
    document.getElementById('modify-modify-btn').addEventListener('click', () => {
        modifyForm.submit();
    });

    document.getElementById('delete-btn').addEventListener('click', () => {
        if(confirm('Are you sure you want to delete your pet?')) {
            modifyForm.action = '../pet_service/delete_pet.php';
            modifyForm.submit();
        }
    });

    let monthArr = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    function setMonth(k) {
        let monthSelect = document.querySelectorAll('.pet-month')[k];
        for (let i = 0; i < monthArr.length; i++) {
            monthSelect.appendChild(new Option(monthArr[i], (i + 1)));
        }
    }
    function setYear(k) {
        let curYear = new Date().getFullYear();
        let yearSelect = document.querySelectorAll('.pet-year')[k];
        for (let i = curYear; i >= curYear - 500; i--) {
            yearSelect.appendChild(new Option(i, i));
        }
    }
    for(let i = 0; i < 2; i++) {
        setMonth(i);
        setYear(i);
    }

    let petOptions = [
        {type: 'Dog', breeds: ['Puppy', 'Labrador Retriever', 'Golden Retriever']},
        {type: 'Cat', breeds: ['Siamese', 'Persian', 'Maine Coon']},
        {type: 'Bird', breeds: ['Parrot', 'Canary', 'Cockatiel']}
    ];

    let type = document.querySelectorAll('.pet-type');

    function initTypeOptions() {
        petOptions.forEach((option) => {
            for(let i = 0; i < 2; i++) {
                type[i].appendChild(new Option(option.type, option.type))
            }
        });
    }

    function updateBreedOptions(k) {
        let breed = document.querySelectorAll('.pet-breed')[k];
        breed.innerHTML = '';
        let defaultOption = new Option('Breed', '', true, true);
        defaultOption.disabled = true;
        breed.appendChild(defaultOption);

        let selectedBreeds = petOptions.find((option) => {
            return option.type.toLowerCase() === type[k].value.toLowerCase();
        }).breeds;
        selectedBreeds.forEach((b) => {
            breed.appendChild(new Option(b, b));
        })
    }

    initTypeOptions();
    for(let i = 0; i < 2; i++) {
        type[i].addEventListener('blur', () => updateBreedOptions(i));
    }
</script>
</html>
