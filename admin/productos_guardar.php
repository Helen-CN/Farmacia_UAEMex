<?php
session_start();
if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol_id'] != 1 && $_SESSION['rol_id'] != 2)) {
    header("Location: ../login.php");
    exit();
}

require_once '../conexion.php';

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$stock = intval($_POST['stock']);
$precio = floatval($_POST['precio']);
$proveedor_id = intval($_POST['proveedor_id']);

$stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, stock, precio, proveedor_id) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssidi", $nombre, $descripcion, $stock, $precio, $proveedor_id);
$stmt->execute();

header("Location: productos.php");
