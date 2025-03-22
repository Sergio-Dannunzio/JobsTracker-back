<?php
require_once __DIR__ . "/../../config/database.php";

class UserController {
    private $collection;

    public function __construct(){
        global $collection;
        $this->collection = $collection;
    }

    public function getUsers(){
        $users = $this->collection->find()->toArray();
        echo json_encode($users);
    }
}
?>