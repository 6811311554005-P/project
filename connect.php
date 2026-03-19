<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "hr_system"; 

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// ตั้งค่าให้รองรับภาษาไทย
mysqli_set_charset($conn, "utf8mb4");
?>