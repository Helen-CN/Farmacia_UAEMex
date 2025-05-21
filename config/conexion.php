<?php
// config/conexion.php

$host = 'localhost';
$db = 'farmacia_uaemex';
$user = 'root';
$pass = '';

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Opcional: establecer codificación
$conn->set_charset("utf8");
?>
