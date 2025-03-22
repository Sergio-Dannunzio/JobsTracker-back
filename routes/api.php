<?php
require_once __DIR__ . '/../app/controllers/UserController.php';

$controller = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->getUsers();
}
?>