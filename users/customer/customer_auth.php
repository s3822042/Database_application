<?php
  session_start();
  if($_SESSION["user"]["type"] != "customer") {
    header("Location: ../login.php");
    exit();
  }
?>
