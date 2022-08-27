<?php
  session_start();
  if($_SESSION["user"]["type"] != "shipper") {
    header("Location: ../login.php");
    exit();
  }
?>
