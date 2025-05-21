<?php
session_start();
require_once __DIR__ . '/../../config/rutas.php';
require_once __DIR__ . '/../../config/conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) {
    header("Location: " . URL_BASE . "/views/login.php");
    exit();
}


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Evitar que un admin se elimine a sí mismo
    if ($id === $_SESSION['usuario_id']) {
        header("Location: " . URL_BASE . "/admin/views/usuarios.php?error=1");
        exit();
    }
    
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: " . URL_BASE . "/admin/views/usuarios.php?success=1");
    } else {
        header("Location: " . URL_BASE . "/admin/views/usuarios.php?error=1");
    }

    $stmt->close();
}
?>