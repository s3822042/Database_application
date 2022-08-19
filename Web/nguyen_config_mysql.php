<?php
$server = "localhost";
$port = "3306";
$username = "root";
$password = "abc123";
$database = "user_db";


$conn = new mysqli($server, $username, $password, $database);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
