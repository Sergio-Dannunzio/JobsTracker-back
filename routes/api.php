<?php
require_once __DIR__ . '/../app/controllers/AuthController.php';

$authController = new AuthController();

$requestUri = explode("?", $_SERVER['REQUEST_URI'])[0];

switch ($requestUri) {
    case "/api/users":
        $authController->getUsers();
        break;
    case "/api/register":
        $authController->register();
        break;
    case "/api/login":
        $authController->login();
        break;
    case "/api/user":
        $authController->getUserData();
        break;
    default:
        http_response_code(404);
        echo json_encode(["error" => "Ruta no encontrada"]);
}
?>