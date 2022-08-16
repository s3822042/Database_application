<?php

$server = "localhost";
$port = "3306";
$username = "root";
$password = "123456";
$database = "user_db";

try {
    $conn = new PDO("mysql:host=$server;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
  ?>