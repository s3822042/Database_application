<?php
require "config_mysql.php";
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login</title>
</head>

<body>
<!-- ---------------- Begin Form ------------------>
<form method="post" name="loginForm" action="login.php" target="_self">
    <label for="email"></label>
    <input type="email" name="email" placeholder="Enter your email" required/>
    <label for="password"></label>
    <input type="password" name="password" placeholder="Enter your password" required/>
    <!-- ---------------- End input ------------------>

    <button type="submit">Login</button>
    <!-- ---------------- End Form ------------------>

</form>
</body>

</html>