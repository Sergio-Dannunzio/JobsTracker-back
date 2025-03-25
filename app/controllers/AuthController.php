<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || !isset($data['name'], $data['email'], $data['password'])) {
            http_response_code(400);
            echo json_encode(["error" => "Datos incompletos"]);
            return;
        }

        if ($this->userModel->getUserByEmail($data['email'])) {
            http_response_code(400);
            echo json_encode(["error" => "El correo ya está registrado"]);
            return;
        }

        $this->userModel->register($data['name'], $data['email'], $data['password']);
        echo json_encode(["message" => "Usuario registrado con éxito"]);
    }

    public function login() {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || !isset($data['email'], $data['password'])) {
            http_response_code(400);
            echo json_encode(["error" => "Datos incompletos"]);
            return;
        }

        $user = $this->userModel->getUserByEmail($data['email']);
        if (!$user || !password_verify($data['password'], $user["password"])) {
            http_response_code(401);
            echo json_encode(["error" => "Credenciales incorrectas"]);
            return;
        }

        $token = AuthMiddleware::generateToken($user);
        echo json_encode(["token" => $token]);
    }

    public function getUserData() {
        $headers = getallheaders();
        if (!isset($headers["Authorization"])) {
            http_response_code(401);
            echo json_encode(["error" => "Token no proporcionado"]);
            return;
        }

        $token = str_replace("Bearer ", "", $headers["Authorization"]);
        $decoded = AuthMiddleware::verifyToken($token);

        if (!$decoded) {
            http_response_code(401);
            echo json_encode(["error" => "Token inválido"]);
            return;
        }

        echo json_encode(["id" => $decoded->id, "email" => $decoded->email]);
    }

    public function getUsers() {
        $users = $this->userModel->getAllUsers(); // No debería ser null
        echo json_encode($users);
    }
}
