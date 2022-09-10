<?php
require 'shipper_auth.php';
require "config_mysql.php";
require "../../config_mongodb.php";

// update order status
$OrderID =  $_POST['id'];
$OrderStatus = $_POST['status'];
$ShipperID = $_SESSION['user']['id'];


update_order($pdo, $OrderID, $ShipperID, $OrderStatus);
//buy function
function update_order($pdo, $OrderID, $ShipperID, $OrderStatus)
{
    $randomWaitingTime =  rand(10, 30);
    $update_order = 'CALL update_order(' . $OrderID . "," . $ShipperID . ",'" . $OrderStatus . "'," . $randomWaitingTime . ');';
    echo $update_order;
    if ($temp = $pdo->prepare($update_order)) {
        $temp->execute();
        if ($temp == true) {
            header('Location:view_order.php');
        }
    }
}
