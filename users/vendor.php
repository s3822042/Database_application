<?php
  $pageType = "vendor";
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
  <title>Vendor Page</title>
</head>
<body>

  <div class="card custom">
    <div class="card text-center align">
      <div class="card-body-custom">
        <h5 class="card-title">List products</h5>
        <div class="b">
          <p class="card-text">display all products of the logged-in vendor</p>
        </div>
        <a href="#" class="btn btn-primary make-bottom">List products</a>
      </div>
    </div>
    <div class="card text-center align">
      <div class="card-body-custom">
        <h5 class="card-title">Add a product</h5>
        <div class="b">
          <p class="card-text">allow the logged-in vendor to add one product. Each product contains those required fields: name, price, and description. The vendor is free to add more custom fields as needed (for example, if the added product is a smartphone, the vendor may add extra information like OS, screen size, resolution, etc.)</p>
        </div>
        <a href="#" class="btn btn-primary make-bottom">Add a product</a>
      </div>
    </div>
    <div class="card text-center align">
      <div class="card-body-custom">
        <h5 class="card-title">Edit a product</h5>
        <div class="b">
          <p class="card-text">allow the logged-in vendor to edit one product. A product cannot be edited if there it has been purchased by a customer and the purchase has not been finished yet. See below for more details</p>
        </div>
        <a href="#" class="btn btn-primary make-bottom">Edit a product</a>
      </div>
    </div>
  </div>

</body>
</html>
