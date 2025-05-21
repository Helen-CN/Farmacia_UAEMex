<?php
session_start();
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../config/rutas.php';

if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol_id'] != 1 && $_SESSION['rol_id'] != 2)) {
    header("Location: " . URL_BASE . "/views/login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']); // Guardar como cadena vacía si está vacía, no como null
    $stock = intval($_POST['stock']);
    $precio = floatval($_POST['precio']);
    $proveedor_id = intval($_POST['proveedor_id']);

    $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, stock, precio, proveedor_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssidi", $nombre, $descripcion, $stock, $precio, $proveedor_id);

    if ($stmt->execute()) {
        header("Location: ../views/productos.php?success=1");
    } else {
        header("Location: ../views/productos.php?error=1");
    }

    $stmt->close();
}
?>