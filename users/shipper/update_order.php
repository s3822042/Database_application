<?php
require "../../config_mysql.php";
require "../../config_mongodb.php";
require 'shipper_auth.php';

// update order status
$OrderID =  $_POST['id'];
$ProductStatus = $_POST['status'];
$ShipperID = $_SESSION['user']['id'];


update_order($pdo, $ProductID, $ProductStatus, $ShipperID);
//buy function
function update_order($pdo, $OrderID, $ShipperID, $ProductStatus){
	$randomWaitingTime =  rand(3,5);
	$update_order = 'CALL update_order('.$OrderID .",'".$ShipperID."',".$ProductStatus .','.$randomWaitingTime .');';
    if ($temp = $pdo->prepare($update_order)) {
		$temp->execute();
        if ($temp == true) {
            header('Location:view_order.php');
        }
	}
}

