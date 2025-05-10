<?php
session_start();
if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol_id'] != 1 && $_SESSION['rol_id'] != 2)) {
    header("Location: ../login.php");
    exit();
}

require_once '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']); // Guardar como cadena vacía si está vacía, no como null
    $stock = intval($_POST['stock']);
    $precio = floatval($_POST['precio']);
    $proveedor_id = intval($_POST['proveedor_id']);

    $stmt = $conn->prepare("UPDATE productos SET nombre = ?, descripcion = ?, stock = ?, precio = ?, proveedor_id = ? WHERE id = ?");
    $stmt->bind_param("ssiddi", $nombre, $descripcion, $stock, $precio, $proveedor_id, $id);

    if ($stmt->execute()) {
        header("Location: productos.php?success=1");
    } else {
        header("Location: productos.php?error=1");
    }

    $stmt->close();
}
?>