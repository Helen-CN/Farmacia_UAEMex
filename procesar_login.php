<?php
session_start();
require_once 'conexion.php';

$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

// Validar correo institucional (acepta @uaemex.mx y @alumno.uaemex.mx)
if (!preg_match('/^.+@(alumno\.)?uaemex\.mx$/', $correo)) {
    header("Location: login.php?error=Correo institucional inválido");
    exit();
}

$esAlumno = str_contains($correo, '@alumno.uaemex.mx');

// Verificar si ya existe
$stmt = $conn->prepare("SELECT id, nombre, contrasena, rol_id FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();

    // Validar contraseña encriptada
    if (password_verify($contrasena, $usuario['contrasena'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['rol_id'] = $usuario['rol_id'];

        if ($usuario['rol_id'] == 4) {
            header("Location: alumno_panel.php");
        } else {
            header("Location: dashboard.php");
        }
    } else {
        header("Location: login.php?error=Contraseña incorrecta");
    }
    exit();
} elseif ($esAlumno) {
    // Crear nuevo usuario alumno si no existe
    $nombreAuto = explode('@', $correo)[0];
    $hash = password_hash($contrasena, PASSWORD_BCRYPT);
    $rol_id = 4;

    // Intentar insertar solo si no existe ya (evita error por correo duplicado)
    $stmtInsert = $conn->prepare("INSERT IGNORE INTO usuarios (nombre, correo, contrasena, rol_id) VALUES (?, ?, ?, ?)");
    $stmtInsert->bind_param("sssi", $nombreAuto, $correo, $hash, $rol_id);
    $stmtInsert->execute();

    if ($stmtInsert->affected_rows > 0) {
        $_SESSION['usuario_id'] = $stmtInsert->insert_id;
        $_SESSION['usuario_nombre'] = $nombreAuto;
        $_SESSION['rol_id'] = $rol_id;

        header("Location: alumno_panel.php");
        exit();
    } else {
        // Ya existía ese correo
        header("Location: login.php?error=El correo ya está registrado");
        exit();
    }
} else {
    header("Location: login.php?error=Usuario no autorizado");
    exit();
}
