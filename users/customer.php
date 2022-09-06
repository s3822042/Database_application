<?php
  $pageType = "customer";
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
  <title>Customer Page</title>
</head>
  <body>

  <div class="card custom">
    <div class="card text-center align">
      <div class="card-body-custom">
        <h5 class="card-title">View products</h5>
        <div class="b">
          <p class="card-text">display all products from all vendors. Most recently added products are displayed first. You must use pagination to limit the number of displayed products at a time</p>
        </div>
        <a href="#" class="btn btn-primary make-bottom">View products</a>
      </div>
    </div>
    <div class="card text-center align">
      <div class="card-body-custom">
        <h5 class="card-title">Search vendors based on distance</h5>
        <div class="b">
          <p class="card-text">the customer enters a distance (for example, 10km), then the system returns a list of vendors whose distances to the customer's location are within the entered value</p>
        </div>
        <a href="users/customer/search_vendor.php" class="btn btn-primary make-bottom">Search vendors</a>
      </div>
    </div>

  </div>

</body>
</html>
