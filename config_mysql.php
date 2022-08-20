<?php

$server = "localhost";
$port = "3306";
$username = "root";
$password = "ZedPaul1312@2001!#";
$database = "db_course";

try {
  $pdo = new PDO("mysql:host=$server;dbname=$database", $username, $password);
  // set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}