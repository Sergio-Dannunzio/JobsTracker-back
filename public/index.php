<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno desde .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../'); // Ruta relativa a la raíz del proyecto
$dotenv->load();

// Comprobar si la URI de MongoDB está cargada correctamente
$mongoUri = $_ENV['MONGO_URI'] ?? null;

if (!$mongoUri) {
    die('La URI de MongoDB no está configurada correctamente.');
}

// Incluir las rutas de la API después de cargar el .env
require_once __DIR__ . '/../routes/api.php';

echo "✅ MONGO_URI cargada: " . $mongoUri;
?>