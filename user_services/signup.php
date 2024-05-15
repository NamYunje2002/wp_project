<?php
if(!empty($_POST['id']) && !empty($_POST['pw']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['month']) && !empty($_POST['day']) && !empty($_POST['year']) && !empty($_POST['gender'])) {
    include "../db_conn.php";

    $userId = $_REQUEST['id'];
    $userPw = $_REQUEST['pw'];
    $userName = $_REQUEST['name'];
    $userEmail = $_REQUEST['email'];
    $userMonth = $_REQUEST['month'];
    $userDay = $_REQUEST['day'];
    $userYear = $_REQUEST['year'];
    $userGender = $_REQUEST['gender'];

    if (strlen($userMonth) == 1) $userMonth = '0' . $userMonth;
    if (strlen($userDay) == 1) $userDay = '0' . $userDay;
    $userBirth = $userMonth . $userDay . $userYear;

    $sql = "INSERT INTO users_tb VALUES ('$userId', '$userPw', '$userName', '$userEmail', '$userBirth', '$userGender')";
    mysqli_query($db, $sql);
    mysqli_close($db);

    echo "<script>alert('Successful SignUP!')</script>";
    echo "<script>location.href='../index.php'</script>";
}else{
    echo "<script>alert('Invalid value!')</script>";
    echo "<script>location.href='/wp_project/user_views/signup.html'</script>";
}
exit();
?>