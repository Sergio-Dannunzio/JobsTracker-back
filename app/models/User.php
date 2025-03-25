<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use MongoDB\Client;

class User {
    private $client;
    private $db;

    public function __construct() {
        $mongoUri = $_ENV['MONGO_URI'] ?? null;
        
        if (!$mongoUri) {
            die(json_encode(["error" => "MONGO_URI no está definido en el entorno"]));
        }

        $this->client = new Client($mongoUri);
        $this->db = $this->client->selectDatabase('jobs_db');
    }

    public function getAllUsers() {
        $collection = $this->db->users;
        return $collection->find()->toArray();
    }

    public function register($name, $email, $password) {
        echo $email;
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $user = [
            "name" => $name,
            "email" => $email,
            "password" => $hashedPassword
        ];
        return $this->db->users->insertOne($user);
    }

    public function getUserByEmail($email) {
        return $this->db->users->findOne(["email" => $email]);
    }

    /*public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }*/
}