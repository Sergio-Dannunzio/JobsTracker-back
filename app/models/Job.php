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

    public function addJob($userId, $name, $status, $desc) {
        $job = [
            "userId" => $userId,
            "name" => $name,
            "status" => $status,
            "desc" => $desc
        ];
        return $this->db->jobs->insertOne($job);
    }

    public function deleteJob($id){
        $objectId = new ObjectId($id);
        return $this->db->jobs->deleteOne(["_id" => $objectId]);
    }

    public function updateJob($id, $data){
        $objectId = new ObjectId($id);
        $result = $this->db->jobs->updateOne(
            ["_id" => $objectId],
            ['$set' => $data]
        );
        return $result;
    }
}