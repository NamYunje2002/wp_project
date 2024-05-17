<?php
session_start();

if(!empty($_SESSION['userid']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['month']) && !empty($_POST['day']) && !empty($_POST['year']) && !empty($_POST['gender'])) {
    include "../db_conn.php";

    $userId = $_SESSION['userid'];
    $userName = $_POST['name'];
    $userEmail = $_POST['email'];
    $userMonth = $_POST['month'];
    $userDay = $_POST['day'];
    $userYear = $_POST['year'];
    $userGender = $_POST['gender'];

    if (strlen($userMonth) == 1) $userMonth = '0' . $userMonth;
    if (strlen($userDay) == 1) $userDay = '0' . $userDay;
    $userBirth = $userMonth . $userDay . $userYear;

    $sql = "UPDATE users_tb SET user_name = '$userName', user_email = '$userEmail', user_birth = '$userBirth', user_gender = '$userGender' WHERE user_id = '$userId'";
    mysqli_query($db, $sql);
    $_SESSION['username'] = $userName;
    mysqli_close($db);
}else{
    echo "<script>alert('Invalid value!')</script>";
}
echo "<script>location.href='show_user_info.php'</script>";
exit();
?>