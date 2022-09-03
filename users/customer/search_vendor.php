<?php
  require "customer_auth.php";
  require "../../config_mysql.php";
  require "../../config_mongodb.php";
  require "../homeNav.php";

  if (isset($_POST['submitData'])) {
    $customer_id = (int) $_SESSION['user']['id'];
    $_SESSION['submitted'] = 1;
    $_SESSION['distance'] = $_POST['distance'];

    // Get a customer record based on ID
    $currentDistance = "SELECT CustomerID, Latitude, Longitude FROM customer WHERE CustomerID = $customer_id";
    $result = $pdo->query($currentDistance);
    $row = $result->fetch();

    // 3d Sphere Distance
    // $otherDistance = "SELECT VendorID, ST_Distance_Sphere(POINT($row[Latitude], $row[Longitude]), POINT (Latitude, Longitude) ) FROM vendor";

    // Euclidean distance
    $otherDistance = "SELECT VendorID, SQRT(POW(latitude - $row[Latitude], 2) + POW(longitude - $row[Longitude], 2)) FROM vendor;";
    $result = $pdo->query($otherDistance);

    // Append all distances into the array
    $array = [];
    while ($row = $result->fetch()) {
      $castKM = $row[1]; // Is it required to cast to other unit ? Ex. ($row[1] / 1000)
      if ( $castKM <= $_POST['distance'] ) {
        $array[$row['VendorID']] = $castKM;
        // echo "VendorID: ", $row['VendorID'], " ------> ", $castKM, "<br>";
      }
    }
  }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<style>
  input[type=number] {
    padding: 2px 20px;
    border: 3px solid #ccc;
    transition: 0.2s;
    outline: none;
  }

  input[type=number]:focus {
    border: 3px solid #555;
  }
</style>

<body>
  <form class="" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" target="_self" method="post">
    <div class="flex flex-row justify-evenly">
      <div class="my-5">
          <label for="price-range" class="block mb-2 text-black">Distance</label>
          <input type="number" name="distance" value="" id="fname"/>
      </div>
    </div>
    <button type="submit" name="submitData" class="w-full hover:shadow-form rounded-md bg-[#6A64F1] py-3 px-8 text-base
                font-semibold text-white outline-none">
        Submit
    </button>
  </form>


    <div class="px-20 py-10">
        <div class="my-5">
            <div class="container mx-auto">
                <div class="grid grid-cols-4 gap-6">
                    <?php
                      if ((int) $_SESSION['submitted'] == 1) {
                        foreach($array as $key => $value) {
                          $data = number_format((float) $value, 2, '.', '');
                          echo "<div
                                    class='flex flex-col justify-center p-6 text-white bg-gray-500 border-2 border-gray-300 cursor-pointer rounded-xl'>
                                    <div class='my-5'>
                                        <p>VendorID: ".$key."</p>
                                        <p>".$data." (km)</p>
                                    </div>
                                </div>";
                        }
                        unset($_SESSION['submitted']);
                        unset($_SESSION['distance']);
                      }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
