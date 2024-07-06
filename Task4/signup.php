<?php

print_r($_POST);

//$conn = new mysqli("localhost","root","","project",3306);
include_once "connection.php";
$password = $_POST['password1'];
$phash = password_hash($password, PASSWORD_DEFAULT);

$query = "insert into user(username, password, usertype) values('$_POST[username]', '$phash', '$_POST[usertype]')";
echo $query;
$status = mysqli_query($conn, $query);

?>

<!-- $query = "insert into user(username, password, usertype) values('$_POST[username]', '$_POST[password1]', '$_POST[usertype]')"; -->