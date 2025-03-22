<?php
require 'vendor/autoload.php'; //carga dependencias de composer

$mongoClient = new MongoDB\Client("mongodb+srv://sergiovdannunzio:V6N22YjV4ehWbM7A@jobscluster.pgjl7.mongodb.net/?retryWrites=true&w=majority&appName=JobsCluster");

$database = $mongoClient->selectDatabase("miDB");
$collection = $database->selectCollection("users");

echo "Conexión exitosa a MongoDB!";
?>