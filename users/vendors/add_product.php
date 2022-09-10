<?php
require 'vendor_auth.php';
require "config_mysql.php";
require "../../config_mongodb.php";
require "../homeNav.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pdo->beginTransaction();

    $hasExtra = 0;
    if (isset($_POST['field']) && isset($_POST['val'])) {
        $hasExtra = 1;
    }

    $stmt = $pdo->prepare("INSERT INTO `Product` (VendorID, ProductName,ProductDescription, Price, haveExtraField, added_date) VALUES (:vendor_id, :product_name, :product_description, :product_price, $hasExtra, now())");
    $stmt->bindParam(':vendor_id', $_SESSION['user']['id']);
    $stmt->bindParam(':product_name', $_POST['product_name']);
    $stmt->bindParam(':product_description', $_POST['product_description']);
    $stmt->bindParam(':product_price', $_POST['product_price']);

    $result = $stmt->execute();

    $product_id = $pdo->lastInsertId();

    if (isset($_POST['field']) && isset($_POST['val'])) {
        $extra_fields = array_combine($_POST['field'], $_POST['val']);
        unset($extra_fields['']);

        $product_id = array('_id' => (int) $product_id);
        $extra_fields = array_merge($product_id, $extra_fields);

        try {
            $cursor = $product_extras->insertOne($extra_fields);
        } catch (MongoDb\Exception\Exception $e) {
            $createErr = 'Extra fields not added successfully';
            $pdo->rollBack();
        }
    }

    if ($result == true) {
        $pdo->commit();
        header("location:display_product.php");
        exit();
    } else {
        $createErr = 'An error occurred. Product not created successfully';
        $pdo->rollBack();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <div class="flex items-center justify-center p-12">

        <div class="mx-auto w-full max-w-[550px]">
            <h1 class="text-4xl text-center text-[#07074D] py-5">Add Product</h1>
            <form name="myForm" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" target="_self" method="post">
                <input type="hidden" name="product[id]" id="id" required />
                <div class="mb-5">
                    <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">
                        Product Name
                    </label>
                    <input type="text" name="product_name" id="product_name" placeholder="Product Name" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                </div>
                <div class="mb-5">
                    <label for="subject" class="mb-3 block text-base font-medium text-[#07074D]">
                        Price
                    </label>
                    <input type="number" step='any' name="product_price" id="product_price" placeholder="Product Price" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
                <div class="mb-5">
                    <label for="message" class="mb-3 block text-base font-medium text-[#07074D]">
                        Product Description
                    </label>
                    <textarea rows="4" name="product_description" id="product_description" placeholder="Product Description" class="w-full resize-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"></textarea>
                </div>
                <!-- Additional Field -->
                <div id="additionalField" class="mb-5">
                </div>
                <input type="button" value="+" onClick="addInput('additionalField');">
                <!-- Submit -->
                <div>
                    <button type="submit" name="submit" class="hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base
                        font-semibold text-white outline-none">
                        Add Product
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="../../js/script.js"></script>
</body>

</html>,
