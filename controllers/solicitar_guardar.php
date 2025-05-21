<?php
session_start();
require_once __DIR__ . '/../config/rutas.php';
require_once __DIR__ . '/../config/conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 4) {
    header("Location: " . URL_BASE . "/views/login.php");
    exit();
}


$usuario_id = $_SESSION['usuario_id'];
$producto_id = intval($_POST['producto_id']);
$cantidad = intval($_POST['cantidad']);

if ($producto_id > 0 && $cantidad > 0) {
    $stmt = $conn->prepare("INSERT INTO solicitudes (usuario_id, producto_id, cantidad) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $usuario_id, $producto_id, $cantidad);
    $stmt->execute();

    header("Location: " . URL_BASE . "/views/alumno_panel.php?msg=Solicitud enviada");
} else {
    header("Location: " . URL_BASE . "/views/solicitar_medicamento.php?error=Datos inválidos");
}
