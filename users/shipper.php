<?php
  $pageType = "shipper";
  include "authentication.php";
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="../css/homepage.css">
  <title>Shipper Page</title>
</head>
<body>

  <div class="card custom">
    <div class="card text-center align">
      <div class="card-body-custom">
        <h5 class="card-title">View orders at the assigned hub</h5>
        <div class="b">
          <p class="card-text">display all products from all vendors. Most recently added products are displayed first. You must use pagination to limit the number of displayed products at a time</p>
        </div>
        <a href="#" class="btn btn-primary make-bottom">View orders</a>
      </div>
    </div>
    <div class="card text-center align">
      <div class="card-body-custom">
        <h5 class="card-title">Update an order status</h5>
        <div class="b">
          <p class="card-text">search products based on name (products whose names start with the words entered by customers) and price (products whose prices are within a range entered by customers)</p>
        </div>
        <a href="users/shipper/test.php" class="btn btn-primary make-bottom">Update order</a>
      </div>
    </div>
  </div>

</body>
</html>
