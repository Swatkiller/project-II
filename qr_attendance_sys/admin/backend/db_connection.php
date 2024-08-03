<?php
$server = "localhost";
$user = "root";
$pass = "mysql";
$db = "attendance_sys";

// create connection
$conn = new mysqli($server, $user, $pass, $db);

if($conn -> connect_error){
    die("Connection Failed!". $conn ->connect_error);
}
?>