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

    public function createUser($name, $email) {
        $collection = $this->db->users;
        $result = $collection->insertOne([
            'name' => $name,
            'email' => $email
        ]);
        return $result;
    }
}