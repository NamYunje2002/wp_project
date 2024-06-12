<?php
$host = 'localhost:3308';
$username = 'root';
$password = '';
$database = 'wp_project_db';

$db = new mysqli($host, $username, $password, $database) or die(mysqli_connect_error());
// mysql_select_db('wp_project_db') or die(mysqli_error($db));
?>
