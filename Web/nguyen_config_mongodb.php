<?php
require 'vendor/autoload.php';
echo extension_loaded("mongodb") ? "loaded\n" : "not loaded\n";
$mongodb_uri = "mongodb://localhost:27017";

try {
    $mongodb_client = new MongoDB\Client($mongodb_uri);
} catch (Exception $e) {
    echo $e->getMessage();
    die(1);
}

$product_extras = $mongodb_client->product->product;
