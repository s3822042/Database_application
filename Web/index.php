<?php
  session_start();
  if (isset($_SESSION['user'])) {
    include "navigation.php";

    $type = $_SESSION['user']['type'];
    if ($type == "customer") {
      include "users/customer.php";
    } else if ($type == "shipper") {
      include "users/shipper.php";
    } else if ($type == "vendor") {
      include "users/vendor.php";
    }
  } else {
    header("Location: login.php");
  }
?>
