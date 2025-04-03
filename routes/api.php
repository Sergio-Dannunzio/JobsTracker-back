<?php
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/JobController.php';

$authController = new AuthController();
$jobController = new JobController();

$requestUri = explode("?", $_SERVER['REQUEST_URI'])[0];

if (preg_match('/^\/api\/jobs\/([a-f0-9]{24})$/', $requestUri, $matches) && $_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $jobController->deleteJob($matches[1]); // Pasar ID a deleteJob()
} elseif (preg_match('/^\/api\/jobs\/([a-f0-9]{24})$/', $requestUri, $matches) && $_SERVER['REQUEST_METHOD'] === 'PUT') {
    $jobController->updateJob($matches[1]); // Pasar ID a updateJob()
} else {
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
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $jobController->getJobsByUser();
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $jobController->addJob();
            } else {
                http_response_code(405);
                echo json_encode(["error" => "Método no permitido"]);
            }
            break;
            case (preg_match("#^/api/jobs/\d+$#", $requestUri) ? true : false):
                if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                    $jobController->deleteJob();
                } else {
                    http_response_code(405);
                    echo json_encode(["error" => "Método no permitido"]);
                }
            break;
        default:
            http_response_code(404);
            echo json_encode(["error" => "Ruta no encontrada"]);
    }
}
?>