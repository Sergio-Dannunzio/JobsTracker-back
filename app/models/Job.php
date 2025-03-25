<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use MongoDB\Client;
use MongoDB\BSON\ObjectId;

class Job {
    private $collection;
    private $db;

    public function __construct(){
        $mongoUri = $_ENV['MONGO_URI'] ?? null;
        
        if (!$mongoUri) {
            die(json_encode(["error" => "MONGO_URI no está definido en el entorno"]));
        }

        $this->client = new Client($mongoUri);
        $this->db = $this->client->selectDatabase('jobs_db');
    }

    public function getAllJobsByUser($userId) {
        return $this->db->jobs->find(['userId' => new ObjectId($userId)])->toArray();
    }
}