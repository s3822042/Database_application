<?php
require "../../config_mysql.php";
require "../../config_mongodb.php";
// update order status
$id = $_POST['id'];
$select_value = $_POST['status'];

$select_query = "SELECT OrderStatus FROM Orders WHERE OrderID = $id ";
$query2  = $pdo->prepare($select_query);
$query2->execute();
$orders_status = $query2->fetch();

if ($orders_status['OrderStatus'] !== 'Pending') {
    $pending_query = "UPDATE Orders SET OrderStatus = 'Pending' WHERE  OrderID = '" . $id . "' ";
    $query1  = $pdo->prepare($pending_query);
    $query1->execute();

    sleep(10);

    $update_query = "UPDATE Orders SET OrderStatus = '" . $select_value . "' WHERE  OrderID = '" . $id . "' ";
    $query3  = $pdo->prepare($update_query);
    $status = $query3->execute();
    if ($status == true) {
        header('Location:view_order.php');
    }
}
