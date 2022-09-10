
<?php
require "customer_auth.php";
require "config_mysql.php";
require "../../config_mongodb.php";
require "../homeNav.php";


//buy function
function buy_product($pdo, $customerID, $VendorID, $ProductID)
{
	$randomWaitingTime =  rand(10, 30);
	$HubID = (int)$pdo->query("SELECT HubID FROM vendor WHERE VendorID =" . $VendorID . ";")->fetch(PDO::FETCH_ASSOC)["HubID"];
	$buy_procedure = 'CALL sp_fail(?, ?, ?, ?, ?)';
	if ($temp = $pdo->prepare($buy_procedure)) {
		$temp->bindParam(1, $customerID, PDO::PARAM_INT);
		$temp->bindParam(2, $VendorID, PDO::PARAM_INT);
		$temp->bindParam(3, $HubID, PDO::PARAM_INT);
		$temp->bindParam(4, $ProductID, PDO::PARAM_INT);
		$temp->bindParam(5, $randomWaitingTime, PDO::PARAM_INT);
		$temp->execute();
	}
}

if (isset($_GET['productID'])) {
	$ProductID = (int) $_GET['productID'];
	$VendorID = (int) $_GET['vendorID'];
	$customerID = $_SESSION['user']['id'];
	buy_product($pdo, $customerID, $VendorID, $ProductID);
	echo "Buy Sucessfully";
}
