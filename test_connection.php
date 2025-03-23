<?php
require_once __DIR__ . '/config/database.php';

// Hacer una consulta para obtener todos los usuarios
$cursor = $collection->find([]);

$result = iterator_to_array($cursor);

echo json_encode($result, JSON_PRETTY_PRINT);
?>