<?php
  if($_SESSION["user"]["type"] != $pageType) {
    header("Location: ../Web/login.php");
    exit();
  }
?>
