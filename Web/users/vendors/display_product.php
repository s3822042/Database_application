<?php
require 'vendor_auth.php';
require "../../nguyen_config_mysql.php";
require "../../nguyen_config_mongodb.php";


if (isset($_SESSION['user']['id'])) {
  $vendor_id = $_SESSION['user']['id'];

  $sql = "SELECT * FROM product WHERE VendorID = $vendor_id";
  $result = $pdo->query($sql);

  // // Approach 1
  // while($row = $result->fetch()){
  //   $mongo = $product_extras->findOne(['_id' => (int) $row['ProductID']]);
  //   if ($mongo != null) {
  //     $data = $mongo->jsonSerialize();
  //     echo "Product ID: ", $data->_id, " -----> Product Extras: ", print_r($data), "<br>";
  //   }
  // }


  // Approach 2
  echo "Products Fixed Fields (MySQL) <br><br>";

  $array = [];
  $i = 0;
  while($row = $result->fetch()){
    $array[$i] = (int) $row['ProductID']; // Only store the product ID (number)
    echo "<---- ProductID: $row[ProductID] ----> <br>
                                            ProductName: $row[ProductName] <br>
                                            ProductDescription: $row[ProductDescription] <br>
                                            Price: $row[Price]
                                            <br><br>";
    $i++;
  }

  echo "--------------------------------------------------------";
  echo "<br><br> Products Extra Fields (MongoDB) <br>";

  $mongo = $product_extras->find(['_id' =>  ['$in' => $array]]); // Find data with array of ID
  $data = $mongo->toArray();
  $length = count($data);

  for ($x = 0; $x < $length; $x++) {
    $tmp = $data[$x]->jsonSerialize();

    echo "<br>";
    echo "ProductID: $tmp->_id ----> " ;

    foreach ($tmp as $key => $value) {
      echo "$key: $value ";
    }

  }
}



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
</body>

</html>
