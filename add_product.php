<?php

require "config_mongodb.php";
require "config_mysql.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_price = $_POST['product_price'];
    $vendor_id = $_POST['vendor_id'];
    $status = "available";
    $sql = "INSERT INTO Product (Price, VendorID) VALUES ('$product_price', '$vendor_id')";
    $res = $conn->exec('$sql');
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
                    <input type="text" name="product_name" id="name" placeholder="Product Name" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                </div>
                <div class="mb-5">
                    <label for="subject" class="mb-3 block text-base font-medium text-[#07074D]">
                        Price
                    </label>
                    <input type="number" name="product_price" id="price" placeholder="Product Price" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                </div>
                <div class="mb-5">
                    <label for="message" class="mb-3 block text-base font-medium text-[#07074D]">
                        Product Description
                    </label>
                    <textarea rows="4" name="product_description" id="message" placeholder="Product Description" class="w-full resize-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"></textarea>
                </div>

                <div>
                    <button type="submit" name="submit" class=" hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base
                        font-semibold text-white outline-none">
                        Add Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>,
