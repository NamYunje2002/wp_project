<?php
session_start();
if(!empty($_POST['id']) && !empty($_POST['pw']) ) {
    include "../db_conn.php";

    $userId = $_REQUEST['id'];
    $userPw = $_REQUEST['pw'];

    $sql = "SELECT user_id, user_name FROM users_tb WHERE user_id = '$userId' AND user_pw = '$userPw'";
    $rsl = mysqli_query($db, $sql);
    $row = $rsl->fetch_array();

    if($row != null) {
        $_SESSION['userid'] = $row['user_id'];
        $_SESSION['username'] = $row['user_name'];
        echo "<script>alert('Successful LogIn!')</script>";
    } else {
        echo "<script>alert('Invalid ID or password.')</script>";
        session_destroy();
    }
    mysqli_close($db);
    echo "<script>location.href='/wp_project'</script>";
    exit;
}else{
    echo "<script>alert('Invalid value!')</script>";
    echo "<script>location.href='/wp_project'</script>";
}
exit();
?>