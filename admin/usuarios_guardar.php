<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) {
    header("Location: ../login.php");
    exit();
}

require_once '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $rol_id = intval($_POST['rol_id']);

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, contrasena, rol_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nombre, $correo, $contrasena, $rol_id);

    if ($stmt->execute()) {
        header("Location: usuarios.php");
    } else {
        echo "Error al guardar: " . $conn->error;
    }

    $stmt->close();
}
?>
