<?php
require 'vendor_auth.php';
require "config_mysql.php";
require "../../config_mongodb.php";
require "../homeNav.php"
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
                                          Edit
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
