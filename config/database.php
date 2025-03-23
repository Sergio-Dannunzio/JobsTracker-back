<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Obtener la URI de MongoDB y el nombre de la base de datos
$mongoUri = $_ENV['MONGO_URI'] ?? null;
$databaseName = $_ENV['DB_NAME'] ?? null;
$collectionName = $_ENV['COLLECTION_NAME'] ?? null;

if (!$mongoUri || !$databaseName || !$collectionName) {
    die('La configuración de la base de datos es incorrecta.');
}

// Crear el cliente y seleccionar la base de datos y colección
$client = new MongoDB\Client($mongoUri);
$database = $client->selectDatabase($databaseName);
$collection = $database->selectCollection($collectionName);
?>