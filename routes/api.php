<?php
require_once __DIR__ . '/../app/controllers/UserController.php';

$controller = new UserController();

// Obtener la ruta solicitada
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($requestUri) {
    case '/users':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $controller->getUsers();
        }
        break;

    /*case '/users/create':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos del cuerpo de la solicitud
            $data = json_decode(file_get_contents("php://input"), true);
            $controller->createUser($data['name'], $data['email']);
        }
        break;*/

    default:
        http_response_code(404);
        echo json_encode(["message" => "Ruta no encontrada"]);
        break;
}
?>