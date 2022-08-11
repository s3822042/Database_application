<?php

$user = 'app_user';
$pass = 'password';

global $dbh;

$dbh = new PDO('mysql:host=localhost;dbname=user_db', $user, $pass);
