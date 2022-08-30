<?php
require 'vendor_auth.php';
require "../../config_mysql.php";
require "../../config_mongodb.php";
require "../homeNav.php";

if (isset($_SESSION['productID'])) {
  $product_id = (int) $_SESSION['productID'];
  $sql = "SELECT * FROM product WHERE ProductID = $product_id";
  $result = $pdo->query($sql);
  $row = $result->fetch();

  $mongo = $product_extras->findOne(['_id' => $product_id]);
  $data = null;

  if ($mongo !== null) {
    $data = $mongo->jsonSerialize();
  }
}

if (isset($_POST['editData'])) {
  $product_id = $_POST['productID'];
  $_SESSION['productID'] = $product_id;

  $sql = "SELECT * FROM product WHERE ProductID = $product_id";
  $result = $pdo->query($sql);
  $row = $result->fetch();

  $mongo = $product_extras->findOne(['_id' => $row['ProductID']]);
  $data = null;

  if ($mongo !== null) {
    $data = $mongo->jsonSerialize();
  }
}

if (isset($_POST['submit'])) {
  $product_id = (int) $_SESSION['productID'];

  if ($row['Status'] == 'AVAILABLE') {
    $stmt = $pdo->prepare("UPDATE `Product` SET ProductName = :product_name, ProductDescription = :product_description, Price = :product_price WHERE ProductID = $product_id");
    $stmt->bindParam(':product_name', $_POST['product_name']);
    $stmt->bindParam(':product_description', $_POST['product_description']);
    $stmt->bindParam(':product_price', $_POST['product_price']);
    $result = $stmt->execute();

    if (isset($_POST['field']) && isset($_POST['val'])) {
      $prevData = [];
      if(isset($_SESSION['extra'])) {
        $prevData = $_SESSION['extra'];
      }

      $extra_fields = array_combine($_POST['field'], $_POST['val']);
      $product_id = array('_id' => (int) $row['ProductID']);
      unset($extra_fields['']);

      $extra_fields = array_merge($product_id, $extra_fields);
      try {
        $cursor = $product_extras->deleteOne(['_id' => $row['ProductID']]);
        $cursor = $product_extras->insertOne($extra_fields);

        $check = $product_extras->findOne($product_id)->jsonSerialize();
        $count = 0;
        foreach ($check as $key => $value) {$count++;}
        if ($count == 1) {
          $product_extras->deleteOne($product_id);
        }

      } catch (MongoDb\Exception\Exception $e) {
          $createErr = 'Extra fields not added successfully';
      }
    }
    header("Refresh:0");
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <div class="flex items-center justify-center p-12">

        <div class="mx-auto w-full max-w-[550px]">
            <h1 class="text-4xl text-center text-[#07074D] py-5">Product Detail</h1>
            <form name="myForm" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" target="_self" method="POST">
                <div class="mb-5">
                    <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">
                        Product ID
                    </label>
                    <input type="text" id="name" value="<?php echo $row['ProductID'];?>" readonly class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                </div>
                <div class="mb-5">
                    <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">
                        Product Name
                    </label>
                    <input type="text" name="product_name" id="name" value="<?php echo $row['ProductName'];?>" placeholder="Product Name" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                </div>
                <div class="mb-5">
                    <label for="subject" class="mb-3 block text-base font-medium text-[#07074D]">
                        Price
                    </label>
                    <input type="text" name="product_price" id="subject" value="<?php echo $row['Price'];?>" placeholder="Product Price" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
                <div class="mb-5">
                    <label for="message" class="mb-3 block text-base font-medium text-[#07074D]">
                        Product Description
                    </label>
                    <textarea rows="4" name="product_description" id="message" placeholder="Product Description" class="w-full resize-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"><?php echo $row['ProductDescription'];?></textarea>
                </div>
                <div id="additionalField" class="mb-5">
                  <?php
                    if ($data !== null) {
                      $len = count((array)$data) - 1;
                      $array = [];
                      foreach ($data as $key => $value) {
                        if (strcmp($key, "_id") != 0) {
                          echo "
                          <div class='rounded w-full flex-col flex rounded-md bg-white py-3 my-4 px-6 border border-[#e0e0e0]'>
                            <input class='form-control' type='text' value='$key' name='field[]' pattern='^[A-Za-z0-9-_ ]*$' placeholder='Field Name'>
                          </div>
                          <div class='rounded w-full flex-col flex rounded-md bg-white py-3 my-4 px-6 border border-[#e0e0e0]'>
                            <input class='form-control' type='text' value='$value' name='val[]' pattern='^[A-Za-z0-9-\/\\.,_%#&amp; ]*$' placeholder='Value'>
                          </div>
                          ";
                          $array[$key] = $value;
                        }
                      }
                      $_SESSION['extra'] = $array;
                    }
                  ?>
                </div>
                <input type="button" value="+" onClick="addInput('additionalField');">
                <div>
                    <button name="submit" class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none">
                        Edit Product
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="../../js/script.js"></script>
</body>

</html>
