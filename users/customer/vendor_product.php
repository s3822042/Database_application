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
    <title>Vendor Product Home</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="px-20 py-10">
        <h1 class="text-black text-4xl">Vendor 1</h1>
        <div class=" my-5">
            <div class="container mx-auto">
                <div class="grid grid-cols-4 gap-6">
                    <div
                        class="flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl">
                        <p>Product Name</p>
                        <p>Product Price</p>
                    </div>
                    <div
                        class="flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl">
                        <p>Product Name</p>
                        <p>Product Price</p>
                    </div>
                    <div
                        class="flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl">
                        <p>Product Name</p>
                        <p>Product Price</p>
                    </div>
                    <div
                        class="flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl">
                        <p>Product Name</p>
                        <p>Product Price</p>
                    </div>
                    <div
                        class="flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl">
                        <p>Product Name</p>
                        <p>Product Price</p>
                    </div>
                    <div
                        class="flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl">
                        <p>Product Name</p>
                        <p>Product Price</p>
                    </div>
                    <div
                        class="flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl">
                        <p>Product Name</p>
                        <p>Product Price</p>
                    </div>
                    <div
                        class="flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl">
                        <p>Product Name</p>
                        <p>Product Price</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>