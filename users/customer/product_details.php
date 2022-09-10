<?php
require "customer_auth.php";
require "config_mysql.php";
require "../../config_mongodb.php";
require "../homeNav.php";


if (isset($_GET['productID'])) {
    $product_id = (int) $_GET['productID'];
    $mongo = $product_extras->findOne(['_id' => (int) $product_id], ['projection' => ['_id' => 0]]);
    if (!is_null($mongo)) {
        $extra_fields = iterator_to_array($mongo);
        foreach ($extra_fields as $keys => $value) {
            echo "<div>$keys: $value</div>";
        }
    }
}
