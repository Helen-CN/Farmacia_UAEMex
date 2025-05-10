<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 4) {
    header("Location: login.php");
    exit();
}

$nombre = $_SESSION['usuario_nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alumno - Farmacia UAEMex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="alert alert-success">
        <h4>Bienvenido, <?= htmlspecialchars($nombre) ?>!</h4>
        <p>Este es tu panel como alumno. Aquí puedes solicitar medicamentos.</p>
        <a href="logout.php" class="btn btn-danger btn-sm">Cerrar sesión</a>
    </div>

    <a href="solicitar_medicamento.php" class="btn btn-primary w-100">
        <i class="bi bi-capsule"></i> Solicitar Medicamento
    </a>
</div>
</body>
</html>
