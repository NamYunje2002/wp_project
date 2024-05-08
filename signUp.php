<?php
    $host = 'localhost:3307';
    $username = 'root';
    $password = '1234';
    $database = 'wp_project_db';

    $db = mysqli_connect($host, $username, $password, $database) or die ('Unable to connect');
    // mysql_select_db('wp_project_db') or die(mysqli_error($db));

    $userId = $_REQUEST['id'];
    $userPw = $_REQUEST['pw'];
    $userName = $_REQUEST['name'];
    $userEmail = $_REQUEST['email'];
    $userMonth = $_REQUEST['month'];
    $userDay = $_REQUEST['day'];
    $userYear = $_REQUEST['year'];
    $userGender = $_REQUEST['gender'];

    if(strlen($userMonth) == 1) $userName = '0'.$userName;
    if(strlen($userDay) == 1) $userDay = '0'.$userDay;
    $userBirth = $userMonth.$userDay.$userYear;

    $sql = "INSERT INTO user_info VALUES ('$userId', '$userPw', '$userName', '$userEmail', '$userBirth', '$userGender')";
    mysqli_query($db, $sql);
    mysqli_close($db);
?>