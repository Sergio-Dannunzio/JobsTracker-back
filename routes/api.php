<?php
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/JobController.php';

$authController = new AuthController();
$jobController = new JobController();

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
    case "/api/jobs":
        $jobController->getJobsByUser();
        break;
    default:
        http_response_code(404);
        echo json_encode(["error" => "Ruta no encontrada"]);
}
?>