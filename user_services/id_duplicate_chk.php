<?php

if(!empty($_GET['userid'])) {
    include "../db_conn.php";

    $userId = $_GET['userid'];

    $sql = "SELECT count(*) FROM users_tb WHERE user_id = '$userId'";
    $rsl = mysqli_query($db, $sql);
    echo mysqli_fetch_array($rsl)["count(*)"];
    mysqli_close($db);
}