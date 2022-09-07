<?php
$server = "localhost";
$port = "3306";
$username = "root";
$password = "abc123";
$database = "lazadar";


// $conn = new mysqli($server, $username, $password, $database);
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }

try {
  $pdo = new PDO("mysql:host=$server;dbname=$database", $username, $password);
  // set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
