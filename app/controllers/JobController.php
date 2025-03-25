<?php
require_once __DIR__ . '/../models/Job.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JobController {
    private $jobModel;

    public function __construct(){
        $this->jobModel = new Job();
    }

    public function getJobsByUser(){
        $headers = getallheaders(); // Obtiene las cabeceras de la solicitud
        if (!isset($headers['Authorization'])) {
            http_response_code(401);
            echo json_encode(["error" => "Token no proporcionado"]);
            return;
        }

        // Extrae el token (formato: "Bearer <token>")
        $token = str_replace("Bearer ", "", $headers['Authorization']);

        try {
            // Decodifica el token con la clave secreta
            $decoded = JWT::decode($token, new Key("clave_secreta", 'HS256'));

            // Extrae el userId del token
            $userId = $decoded->id;

            // Llama al modelo con el userId
            $jobs = $this->jobModel->getAllJobsByUser($userId);

            echo json_encode($jobs);
        } catch (Exception $e) {
            http_response_code(401);
            echo json_encode(["error" => "Token inválido"]);
        }
    }

}