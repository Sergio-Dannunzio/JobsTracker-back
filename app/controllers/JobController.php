<?php
require_once __DIR__ . '/../models/Job.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use MongoDB\BSON\ObjectId;

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

    public function addJob(){
        $data = json_decode(file_get_contents("php://input"), true);
        $headers = getallheaders();
        $token = str_replace("Bearer ", "", $headers['Authorization']);
        $decoded = JWT::decode($token, new Key("clave_secreta", 'HS256'));

        $userId = new ObjectId($decoded->id);

        $this->jobModel->addJob($userId, $data['name'], $data['status'], $data['desc']);
    }

    public function deleteJob($id){
        try{

            $objectId = new ObjectId($id);
            $result = $this->jobModel->deleteJob($objectId);
            
            $this->jobModel->deleteJob($id);
            
            if ($result->getDeletedCount() > 0) {
                echo json_encode(["message" => "Trabajo eliminado correctamente"]);
            } else {
                echo json_encode(["error" => "Trabajo no encontrado"]);
            }
        } catch (Exception $e) {
            echo json_encode(["error" => "ID inválido"]);
        }
    }

    public function updateJob($id){
        try{
            $dataBody = json_decode(file_get_contents("php://input"), true);
            $objectId = new ObjectId($id);
            $data = [
                "name" => $dataBody['name'],
                "status" => $dataBody['status'],
                "desc" => $dataBody['desc']
            ];
            $result = $this->jobModel->updateJob($objectId, $data);
            
            if ($result) {
                echo json_encode(["message" => "Trabajo actualizado correctamente"]);
            } else {
                echo json_encode(["error" => "Trabajo no encontrado"]);
            }
        } catch (Exception $e) {
            echo json_encode(["error" => "ID inválido"]);
        }
    }

}