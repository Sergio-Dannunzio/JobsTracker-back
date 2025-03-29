<?php
header("Access-Control-Allow-Origin: http://localhost:5173"); // Permite solo tu frontend
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS"); // Métodos permitidos
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // Permite estos headers
header("Access-Control-Allow-Credentials: true"); // Habilita credenciales (cookies, auth headers)

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

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

?>