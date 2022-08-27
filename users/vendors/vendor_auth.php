<?php
  session_start();
  if($_SESSION["user"]["type"] != "vendor") {
    header("Location: ../login.php");
    exit();
  }
?>
