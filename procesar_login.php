<?php
session_start();
require_once 'conexion.php';

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

// Validar correo institucional
if (!preg_match('/^(alumno@uaemex\.mx|[^@]+@uaemex\.mx)$/', $correo)) {
    header("Location: login.php?error=Correo no válido");
    exit();
}

// Buscar usuario
$stmt = $conn->prepare("SELECT id, nombre, contrasena, rol_id FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
    if (password_verify($contrasena, $usuario['contrasena'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['rol_id'] = $usuario['rol_id'];
        header("Location: dashboard.php");
    } else {
        header("Location: login.php?error=Contraseña incorrecta");
    }
} else {
    header("Location: login.php?error=Usuario no encontrado");
}
