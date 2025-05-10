<?php
session_start();
if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol_id'] != 1 && $_SESSION['rol_id'] != 2)) {
    header("Location: ../login.php");
    exit();
}

require_once '../conexion.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: productos.php?success=1");
    } else {
        header("Location: productos.php?error=1");
    }

    $stmt->close();
}
?>