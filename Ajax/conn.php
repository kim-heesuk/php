<?php
$host = "localhost";
$db_name = "mysql";
$username = "root";
$password = "heedol12!";
$conn = new mysqli($host, $username, $password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>