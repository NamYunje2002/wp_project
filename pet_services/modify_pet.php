<?php
session_start();
if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please log in and use it.')</script>";
    echo "<script>location.replace('/wp_project');</script>";
    exit;
}

echo $_POST['pet_type'] . '<br>';
echo $_POST['pet_name'] . '<br>';
echo $_POST['pet_month'] . '<br>';
echo $_POST['pet_year'] . '<br>';
echo $_POST['pet_gender'] . '<br>';

if (!isset($_POST['pet_type']) || !isset($_POST['pet_name']) || !isset($_POST['pet_month']) || !isset($_POST['pet_year']) || !isset($_POST['pet_gender'])) {
    echo "<script>alert('It is invalid value.')</script>";
    //echo "<script>location.replace('./show_pet_info.php');</script>";
    exit;
}

$petOwner = $_SESSION['userid'];

$petId = $_POST['pet_id'];

$petType = $_POST['pet_type'];
$petBreed = '';
if (isset($_POST['pet_breed'])) $petBreed = $_POST['pet_breed'];

$petName = $_POST['pet_name'];

$petMonth = $_POST['pet_month'];
if (strlen($petMonth) == 1) $petMonth = '0' . $petMonth;
$petYear = $_POST['pet_year'];
$petBirth = $petMonth . $petYear;

$petGender = $_POST['pet_gender'];

$petDesc = isset($_POST['pet_desc']) ? $_POST['pet_desc'] : '';

$today = date("Ymd");

$petImgName = '';
$tmpPetImgName = '';
$imgFolder = './pet_img/' . $today;
if (isset($_FILES['pet_img']) && $_FILES['pet_img']['error'] != UPLOAD_ERR_NO_FILE) {
    $petImgName = $_FILES['pet_img']['name'];
    $tmpPetImgName = $_FILES['pet_img']['tmp_name'];
    if (!file_exists($imgFolder)) mkdir($imgFolder, 0777, true);

    function generateRandomString($length = 16)
    {
        return bin2hex(openssl_random_pseudo_bytes($length / 2));
    }

    $randomValue = generateRandomString();
    $extension = pathinfo($petImgName, PATHINFO_EXTENSION);
    $petImgName = $randomValue . '.' . $extension;

    $imgPath = $imgFolder . '/' . $petImgName;
    $petImgName = $today . '/' . $petImgName;
}
include "../db_conn.php";
echo $petImgName;
$isUpload = 1;

if ($petImgName != '') {
    if (!(move_uploaded_file($tmpPetImgName, $imgPath))) {
        $isUpload = 0;
    }
}
$insertPetQuery = "UPDATE pets_tb SET PET_TYPE = '$petType', PET_BREED = '$petBreed', PET_NAME = '$petName', PET_BIRTH = '$petBirth', PET_GENDER = '$petGender', PET_DESC = '$petDesc', PET_IMG_NAME = '$petImgName' WHERE pet_owner = '$petOwner' AND pet_id = '$petId'";

mysqli_query($db, $insertPetQuery) or die(mysqli_error($db));
mysqli_close($db);

if ($isUpload) echo "<script>alert('Successful add pet')</script>";
else echo "<script>alert('Failed to upload image')</script>";

echo "<script>location.href='./show_pet_info.php'</script>";
?>