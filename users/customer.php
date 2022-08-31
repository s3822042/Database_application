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
        <h5 class="card-title">Search products</h5>
        <div class="b">
          <p class="card-text">search products based on name (products whose names start with the words entered by customers) and price (products whose prices are within a range entered by customers)</p>
        </div>
        <a href="#" class="btn btn-primary make-bottom">Search products</a>
      </div>
    </div>
    <div class="card text-center align">
      <div class="card-body-custom">
        <h5 class="card-title">Search products based on custom attributes</h5>
        <div class="b">
          <p class="card-text">customers enter an attribute name and search condition, and the system returns all matched products. As an example, if the attribute name is "OS" and the search condition is "Android", the system returns all products with a custom attribute name "OS" and contains the value "Android". To simplify this feature, assume the search condition is always "equal to"</p>
        </div>
        <a href="#" class="btn btn-primary make-bottom">Search products</a>
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
    <div class="card text-center align">
      <div class="card-body-custom">
        <h5 class="card-title">View all products of a vendor</h5>
        <div class="b">
          <p class="card-text">similar to the "View products" page, but all displayed products are from a single vendor</p>
        </div>
        <a href="#" class="btn btn-primary make-bottom">View products</a>
      </div>
    </div>
    <div class="card text-center align">
      <div class="card-body-custom">
        <h5 class="card-title">Buy a product</h5>
        <div class="b">
          <p class="card-text">No integration with payment service providers is required. But it will take a while from the time a customer clicks the "Buy" button to the time when all relevant records are created. For testing purposes, let's assume this time is a random value between 10 to 30 seconds (that means you need to pause the purchasing process for a random time from 10 to 30 seconds - during this period, do not allow a vendor to edit the product being purchased).</p>
        </div>
        <a href="#" class="btn btn-primary make-bottom">Buy a product</a>
      </div>
    </div>
  </div>

</body>
</html>
