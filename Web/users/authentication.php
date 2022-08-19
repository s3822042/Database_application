<?php
  if($_SESSION["user"]["type"] != $pageType) {
    header("Location: ../login.php");
    exit();
  }
?>
