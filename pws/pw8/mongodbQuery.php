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
$db = $client->selectDatabase('contact');

//access collection
$collection = $db->selectCollection('data');

//find multiple
$filter = ['gender' => "male"];//associative array
$options = ['projection' => ['_id' => 0,'lastName' => 1,'firstName' => 1,'age' => 1,'gender' => 1]];
$resultsMultiple = $collection->find($filter,$options);
foreach ($resultsMultiple as $doc) {
    echo '<br>', json_encode($doc), '<br>';
}

?>
</body>
</html>