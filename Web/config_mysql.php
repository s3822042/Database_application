<?php

$server = "localhost";
$port = "3306";
$username = "root";
$password = "abc123";
$database = "user_db";

// $pdo = new PDO("mysql:host=$server:$port;dbname=$database", $username, $password);

try {
  $pdo = new PDO("mysql:host=$server;dbname=$database", $username, $password);
  // set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //
  // $sql = "CREATE DATABASE testdatabase";
  // $pdo->exec($sql);

  echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
