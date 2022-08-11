<?php

$server = "localhost";
$port = "3306";
$username = "root";
$password = "123456";
$database = "db_course";

$pdo = new PDO("mysql:host=$server:$port;dbname=$database", $username, $password);
