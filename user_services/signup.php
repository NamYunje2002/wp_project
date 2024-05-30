<?php
if(!empty($_POST['id']) && !empty($_POST['pw']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['month']) && !empty($_POST['day']) && !empty($_POST['year']) && !empty($_POST['gender'])) {
    include "../db_conn.php";

    $userId = $_POST['id'];
    $userPw = $_POST['pw'];
    $userName = $_POST['name'];
    $userEmail = $_POST['email'];
    $userMonth = $_POST['month'];
    $userDay = $_POST['day'];
    $userYear = $_POST['year'];
    $userGender = $_POST['gender'];

    if (strlen($userMonth) == 1) $userMonth = '0' . $userMonth;
    if (strlen($userDay) == 1) $userDay = '0' . $userDay;
    $userBirth = $userMonth . $userDay . $userYear;

    $sql = "INSERT INTO users_tb VALUES ('$userId', '$userPw', '$userName', '$userEmail', '$userBirth', '$userGender')";
    mysqli_query($db, $sql);
    mysqli_close($db);

    echo "<script>alert('Successful SignUP!')</script>";
    echo '<script>location.href="/wp_project</script>';
}else{
    echo "<script>alert('Invalid value!')</script>";
    echo '<script>location.href="/wp_project/views/signup.html"</script>';
}
exit();
?>