<?php
session_start();
if(!isset($_SESSION['userid'])) {
    echo "<script>alert('Please log in and use it.')</script>";
    echo "<script>location.replace('/wp_project');</script>";
    exit;
}

if(!isset($_POST['pet_type']) || !isset($_POST['pet_name']) || !isset($_POST['pet_month']) || !isset($_POST['pet_year']) || !isset($_POST['pet_gender'])) {
    echo "<script>alert('It is invalid value.')</script>";
    echo "<script>location.replace('./show_pet_info.php');</script>";
    exit;
}

$petOwner = $_SESSION['userid'];
$petType = $_POST['pet_type'];
$petBreed = $_POST['pet_breed'];
$petName = $_POST['pet_name'];
$petMonth = $_POST['pet_month'];
if (strlen($petMonth) == 1) $petMonth = '0' . $petMonth;
$petYear = $_POST['pet_year'];
$petBirth = $petMonth . $petYear;
$petGender = $_POST['pet_gender'];
$petDec = '';
if(isset($_POST['pet_des'])) $petDec = $_POST['pet_des'];

echo $petType . '<br>';
echo $petBreed . '<br>';
echo $petName . '<br>';
echo $petGender . '<br>';
echo $petBirth . '<br>';
echo $petDec . '<br>';

$db = mysqli_connect('localhost:3308', 'root', '1234', 'wp_project_db') or die(mysqli_connect_error());

$insertPetQuery = "INSERT INTO pets_tb(PET_TYPE, PET_BREED, PET_NAME, PET_BIRTH, PET_GENDER, PET_dec, PET_OWNER) VALUES('$petType', '$petBreed', '$petName', '$petBirth', '$petGender', '$petDec', '$petOwner')";
mysqli_query($db, $insertPetQuery) or die(mysqli_error($db));

echo "<script>alert('Successful SignUP!')</script>";
echo "<script>location.href='./show_pet_info.php'</script>";