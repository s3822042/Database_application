<?php
require 'vendor_auth.php';
require "../../config_mysql.php";
require "../../config_mongodb.php";


// if (isset($_SESSION['user']['id'])) {
//   $vendor_id = $_SESSION['user']['id'];
//
//   $sql = "SELECT * FROM product WHERE VendorID = $vendor_id";
//   $result = $pdo->query($sql);
//
//   // // Approach 1
//   // while($row = $result->fetch()) {
//   //   $mongo = $product_extras->findOne(['_id' => (int) $row['ProductID']]);
//   //   if ($mongo != null) {
//   //     $data = $mongo->jsonSerialize();
//   //     print_r($row);
//   //     echo "<br><br>";
//   //     echo "Product ID: ", $data->_id, " -----> Product Extras: ", print_r($data), "<br>";
//   //   }
//   // }
//
//
//   // Approach 2
//   echo "Products Fixed Fields (MySQL) <br><br>";
//
//   $array = [];
//   $i = 0;
//   while($row = $result->fetch()){
//     $array[$i] = (int) $row['ProductID']; // Only store the product ID (number)
//     echo "<---- ProductID: $row[ProductID] ----> <br>
//                                             ProductName: $row[ProductName] <br>
//                                             ProductDescription: $row[ProductDescription] <br>
//                                             Price: $row[Price]
//                                             <br><br>";
//     // var_dump($row);
//     // echo "<br><br>";
//     $i++;
//   }
//
//   echo "--------------------------------------------------------";
//   echo "<br><br> Products Extra Fields (MongoDB) <br>";
//
//   $mongo = $product_extras->find(['_id' =>  ['$in' => $array]]); // Find data with array of ID
//   $data = $mongo->toArray();
//   $length = count($data);
//
//   for ($x = 0; $x < $length; $x++) {
//     $tmp = $data[$x]->jsonSerialize();
//
//     echo "<br>";
//     echo "ProductID: $tmp->_id ----> ";
//
//     foreach ($tmp as $key => $value) {
//       echo "$key: $value ";
//     }
//   }
// }



?>








<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="px-20 py-10">
        <!-- Product list -->
        <div class="my-5">
            <div class="container mx-auto">
                <div class="grid grid-cols-4 gap-6">
                    <?php
                      $vendor_id = $_SESSION['user']['id'];

                      $sql = "SELECT * FROM product WHERE VendorID = $vendor_id";
                      $result = $pdo->query($sql);

                      while($row = $result->fetch()) {

                        echo "<div
                                  class='flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl'>
                                  <div class='my-5'>
                                      <p>".$row['ProductName']."</p>
                                      <p>".$row['Price']."</p>
                                  </div>
                                  <div class='my-5'>
                                    <form action='edit_product.php' method='post'>
                                      <input style='visibility: hidden;' name='productID' value=".$row['ProductID'].">
                                      <button type='submit' name='editData'
                                          class='px-8 py-3 text-base font-semibold text-white bg-indigo-500 rounded-md outline-none hover:shadow-form'>
                                          Buy
                                      </button>
                                    </form>
                                  </div>
                              </div>";
                      }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>








<!-- <!DOCTYPE html>
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

</html> -->
