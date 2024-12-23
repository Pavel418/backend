<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
require_once __DIR__ . '/vendor/autoload.php';

use MongoDB\Client;

$uri="mongodb+srv://pavel:Vaterloo2016@cluster0.pzhkasw.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0";

$client = new MongoDB\Client($uri);

//access Database
$db = $client->selectDatabase('customers_orders_products');

//access collection
$collection = $db->selectCollection('orders');

$matchStage = ['$match' => ['customer_id' => ['$eq' => 2]]];

$lookupStageOnCustomers = ['$lookup' => ['from' => 'customers', 'localField' => 'customer_id', 'foreignField' => 'customer_id', 'as'=> 'customerData']];

$unwindStageOnCustomers = ['$unwind' => ['path' => '$customerData']];

$projectStage1 = ['$project' => ['_id' => 0, 'date' => 1, 'product_id' => 1, 'quantity' => 1, 'customerData.last_name' => 1, 'customerData.first_name' => 1]];

$lookupStageOnProducts = ['$lookup' => ['from' => 'products', 'localField' => 'product_id', 'foreignField' => 'product_id', 'as'=> 'productData']];

$unwindStageOnProducts = ['$unwind' => '$productData'];

$projectStage2 = [ '$project' => [ 'date' => 1, 'quantity' => 1, 'first_name' => '$customerData.first_name',  'last_name' => '$customerData.last_name', 'product' => '$productData.product', 'price' => '$productData.price', 'totalCost' => [ '$multiply' => ['$quantity', '$productData.price'] ] ] ];

$outStage = [ '$out' =>  'order_from_customer_php' ];

$pipeline = [$matchStage,$lookupStageOnCustomers,$unwindStageOnCustomers,$projectStage1,$lookupStageOnProducts,$unwindStageOnProducts,$projectStage2];


$aggregateResult=$collection->aggregate($pipeline);

foreach ($aggregateResult as $doc) {
    echo '<pre>', json_encode($doc,JSON_PRETTY_PRINT), '<pre>';
}



?>
</body>
</html>