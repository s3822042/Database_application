<?php
require 'vendor_auth.php';
require "../../nguyen_config_mysql.php";
require "../../nguyen_config_mongodb.php";

$_SESSION['id'] = 6;
$id = $_SESSION['id'];

$extra_fields = false;

// // Luan's code
// if (isset($_GET["id"])) {
//     $product_id = $_GET['id'];
//
//     $query = "SELECT * FROM product WHERE product.id = $product_id";
//     $row = $pdo->query($query)->fetch(PDO::FETCH_ASSOC);
//     $mongo_doc = $product_extras->findOne(['_id' => (int) $product_id], ['projection' => ['_id' => 0]]);
// }


if (isset($_SESSION['user']['id'])) {
  $vendor_id = $_SESSION['user']['id'];

  $sql = "SELECT * FROM product WHERE VendorID = $vendor_id";
  $result = $pdo->query($sql);

  while($row = $result->fetch()){
    $mongo = $product_extras->findOne(['_id' => (int) $row['ProductID']]);
    if ($mongo != null) {
      $data = $mongo->jsonSerialize();
      echo "Product ID: ", $data->_id, " -----> Product Extras: ", print_r($data), "<br>";
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
