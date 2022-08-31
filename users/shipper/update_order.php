<?php
require "../../config_mysql.php";
require "../../config_mongodb.php";
// update order status
$select_value = $_POST['status'];
$id = $_POST['id'];

// print_r($select_value);
$update_query = "UPDATE Orders SET OrderStatus = '".$select_value ."' WHERE  OrderID = '".$id."' ";
$query3  = $pdo->prepare($update_query);
$status = $query3->execute();
// // if ($order_array == 'Pending') {
// //     sleep(10);
// //     $update_query = "UPDATE Orders SET OrderStatus = '$select_value' WHERE  `OrderID` = ? ";
// //     header('location:view_order.php');
// // }


if ($status == true) {
    header('Location:view_order.php');
}