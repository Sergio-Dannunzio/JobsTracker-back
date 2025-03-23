<?php
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../app/models/User.php";

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User(); // Crear instancia correctamente
    }

    public function getUsers() {
        $users = $this->userModel->getAllUsers(); // No debería ser null
        echo json_encode($users);
    }
}
?>