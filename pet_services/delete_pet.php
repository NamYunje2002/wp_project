<?php

session_start();

if (!isset($_SESSION['userid'])) {
    echo "<script>alert('Please log in and use it.')</script>";
    echo "<script>location.replace('/wp_project');</script>";
    exit;
}

if (!isset($_POST['pet_id'])) {
    echo "<script>alert('Invalid Value')</script>";
    echo "<script>location.replace('/wp_project');</script>";
    exit;
}

include '../db_conn.php';

$petId = $_POST['pet_id'];
$petOwner = $_SESSION['userid'];

$sql = "SELECT COUNT(*) FROM pets_tb WHERE pet_id = '$petId' AND pet_owner = '$petOwner'";
$rsl = mysqli_query($db, $sql) or die(mysqli_error($db));
$rsl = $rsl->fetch_array()['COUNT(*)'];
if ($rsl == 0) {
    echo "<script>alert('Invalid Value')</script>";
    echo "<script>location.replace('/wp_project');</script>";
    exit;
}

$deletePetSql = "DELETE FROM pets_tb WHERE pet_id = '$petId' AND pet_owner = '$petOwner'";
mysqli_query($db, $deletePetSql) or die(mysqli_error($db));
echo "<script>alert('Successful delete')</script>";
echo "<script>location.replace('./show_pet_info.php');</script>";
exit;
?>