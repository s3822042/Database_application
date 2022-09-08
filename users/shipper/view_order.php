<?php
require 'shipper_auth.php';
require "../../config_mysql.php";
require "../../config_mongodb.php";

$ShipperID = $_SESSION['user']['id'];
$HubID = (int)$pdo->query("SELECT HubID FROM shipper WHERE ShipperID =".$ShipperID.";")->fetch(PDO::FETCH_ASSOC)["HubID"];
$query = "SELECT Orders.OrderID, Orders.VendorID, Orders.OrderStatus, Product.ProductID, Product.ProductName, Product.Price, Orders.HubID, Customer.CustomerAddress
FROM Orders
INNER JOIN Customer ON Orders.CustomerID = Customer.CustomerID
INNER JOIN product ON product.ProductID = Orders.ProductID
WHERE Orders.HUBID  =".$HubID.";";
$stm = $pdo->prepare($query);
$stm->execute(); // The ID of the shipper using the website
$orders_array = $stm->fetchAll(PDO::FETCH_ASSOC);

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
    <div class="px-20 py-10">
        <h1 class="text-4xl text-black">Oder in Hub: <?php echo $HubID  ?></h1>
        <!-- Product list -->
        <div class="my-5">
            <div class="container mx-auto">
                <?php foreach ($orders_array as $orders) { ?>
                <div class="grid grid-cols-4 gap-6 mt-10">
                    <div
                        class="flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl">
                        <div class="my-5">
                            <p>Order ID: <?php echo $orders['OrderID'] ?></p>
                            <p>Vendor ID: <?php echo $orders['VendorID'] ?></p>
                            <p>Product ID: <?php echo $orders['ProductID'] ?></p>
                            <p>Product Name: <?php echo $orders['ProductName'] ?></p>
                            <p>Product Price: <?php echo $orders['Price'] ?></p>
                            <p>Order status: <?php echo $orders['OrderStatus'] ?></p>
                            <p>Customer Address: <?php echo $orders['CustomerAddress'] ?></p>
                        </div>
                        <!-- Update order status button  -->
                        <div class="my-5">
                            <button id="btn" onclick="ShowModal('myModal-<?= $orders['OrderID']?>')" class=" px-8 py-3 text-base font-semibold text-white bg-indigo-500 rounded-md
                                outline-none hover:shadow-form">
                                Update order status
                            </button>
                        </div>
                        <div id="myModal-<?= $orders['OrderID']; ?>" class="hidden modal">
                            <form method="post" action="update_order.php" role="form" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= $orders['OrderID'] ?>">
                                <label for="orders" class="block mb-2 text-sm font-medium text-white">Choose order
                                    status</label>
                                <select id="orders" name="status"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="Cancelled">Cancelled</option>
                                    <option value="Shipped">Shipped</option>
                                </select>
                                <button type="submit" name="submit"
                                    class="px-2 py-4 mt-4 text-base font-semibold text-white bg-indigo-500 rounded-md outline-none hover:shadow-form">Confirm</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    </div>
    <script>
    function ShowModal(id) {
        var modal = document.getElementById(id);
        modal.style.display = "block";
    }
    </script>
</body>

</html>