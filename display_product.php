<?php
session_start();

require "config_mongodb.php";
require "config_mysql.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Product</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <?php require 'require/header.php'; ?>
    <table class="table-auto">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>A</td>
                <td>B</td>
                <td>C</td>
            </tr>
            <tr>
                <td>A</td>
                <td>B</td>
                <td>C</td>
            </tr>
            <tr>
                <td>A</td>
                <td>B</td>
                <td>C</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
