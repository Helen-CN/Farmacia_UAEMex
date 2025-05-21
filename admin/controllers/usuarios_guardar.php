<?php
session_start();
require_once __DIR__ . '/../../config/rutas.php';
require_once __DIR__ . '/../../config/conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) {
    header("Location: " . URL_BASE . "/views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $rol_id = intval($_POST['rol_id']);

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, contrasena, rol_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nombre, $correo, $contrasena, $rol_id);

    if ($stmt->execute()) {
        header("Location: " . URL_BASE . "/admin/views/usuarios.php?success=1");
    } else {
        header("Location: " . URL_BASE . "/admin/views/usuarios.php?error=1");
    }

    $stmt->close();
}
?>
