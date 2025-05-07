<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener datos de sesión
$nombre = $_SESSION['usuario_nombre'];
$rol_id = $_SESSION['rol_id'];

// Asignar nombre de rol
$roles = [
    1 => 'Administrador',
    2 => 'Inventario',
    3 => 'Auditor'
];
$rol_nombre = $roles[$rol_id] ?? 'Desconocido';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Farmacia UAEMex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <div class="alert alert-success">
        <h4>Bienvenido, <?= htmlspecialchars($nombre) ?>!</h4>
        <p>Rol: <strong><?= $rol_nombre ?></strong></p>
        <a href="logout.php" class="btn btn-danger btn-sm">Cerrar sesión</a>
    </div>

    <div class="row">
        <?php if ($rol_id == 1): // Administrador ?>
            <div class="col-md-4 mb-3">
                <a href="admin/usuarios.php" class="btn btn-primary w-100">Gestión de Usuarios</a>
            </div>
        <?php endif; ?>

        <?php if ($rol_id == 1 || $rol_id == 2): // Admin e Inventario ?>
            <div class="col-md-4 mb-3">
                <a href="admin/productos.php" class="btn btn-secondary w-100">Gestión de Productos</a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="admin/proveedores.php" class="btn btn-secondary w-100">Proveedores</a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="admin/movimientos.php" class="btn btn-secondary w-100">Movimientos</a>
            </div>
        <?php endif; ?>

        <?php if ($rol_id == 3): // Auditor ?>
            <div class="col-md-4 mb-3">
                <a href="admin/reportes.php" class="btn btn-info w-100">Ver Reportes</a>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
