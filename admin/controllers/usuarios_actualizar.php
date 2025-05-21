<?php
session_start();

require_once __DIR__ . '/../../config/rutas.php';
require_once __DIR__ . '/../../config/conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) {
    header("Location: " . URL_BASE . "/views/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $rol_id = intval($_POST['rol_id']);
    $contrasena = !empty($_POST['contrasena']) ? password_hash($_POST['contrasena'], PASSWORD_DEFAULT) : null;

    // Verificar si el correo ya existe para otro usuario
    $stmt_check = $conn->prepare("SELECT id FROM usuarios WHERE correo = ? AND id != ?");
    $stmt_check->bind_param("si", $correo, $id);
    $stmt_check->execute();
    if ($stmt_check->get_result()->num_rows > 0) {
        header("Location: " . URL_BASE . "/admin/views/usuarios_editar.php?id=$id&error=duplicate");
        exit();
    }
    $stmt_check->close();

    if ($contrasena) {
        $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, correo = ?, contrasena = ?, rol_id = ? WHERE id = ?");
        $stmt->bind_param("sssii", $nombre, $correo, $contrasena, $rol_id, $id);
    } else {
        $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, correo = ?, rol_id = ? WHERE id = ?");
        $stmt->bind_param("ssii", $nombre, $correo, $rol_id, $id);
    }

    if ($stmt->execute()) {
        header("Location: " . URL_BASE . "/admin/views/usuarios.php?success=1");
    } else {
        header("Location: " . URL_BASE . "/admin/views/usuarios.php?error=1");
    }

    $stmt->close();
}
?>
