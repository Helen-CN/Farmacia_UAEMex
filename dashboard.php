<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$nombre = $_SESSION['usuario_nombre'];
$rol_id = $_SESSION['rol_id'];

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Farmacia UAEMex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #006341;">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="img/logo-uaemex.png" alt="UAEMex" width="40" class="me-2">
            <span class="fw-bold">Farmacia UAEMex</span>
        </a>
        <div class="d-flex align-items-center">
            <span class="text-white me-3"><i class="bi bi-person-circle me-1"></i><?= htmlspecialchars($nombre) ?> <span class="badge bg-warning text-dark"><?= $rol_nombre ?></span></span>
            <a href="logout.php" class="btn btn-outline-warning btn-sm"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</a>
        </div>
    </div>
</nav>

<!-- CONTENIDO -->
<div class="container mt-5">
    <h3 class="mb-2 text-success">Panel de Control</h3>
    <p class="lead text-muted">Bienvenido(a), <?= htmlspecialchars($nombre) ?>. Tienes acceso como <strong><?= $rol_nombre ?></strong>.</p>

    <div class="row g-4">

        <?php if ($rol_id == 1): ?>
            <h5 class="mt-4 text-success">Gestión Administrativa</h5>
            <div class="col-md-4">
                <a href="admin/usuarios.php" class="text-decoration-none">
                    <div class="card h-100 shadow tarjeta-hover border-0">
                        <div class="card-body text-center">
                            <i class="bi bi-people-fill display-4 text-success"></i>
                            <h5 class="card-title mt-2 text-dark">Gestión de Usuarios</h5>
                        </div>
                    </div>
                </a>
            </div>
        <?php endif; ?>

        <?php if ($rol_id == 1 || $rol_id == 2): ?>
            <h5 class="mt-4 text-success">Gestión de Inventario</h5>
            <div class="col-md-4">
                <a href="admin/productos.php" class="text-decoration-none">
                    <div class="card h-100 shadow tarjeta-hover border-0">
                        <div class="card-body text-center">
                            <i class="bi bi-capsule-pill display-4 text-primary"></i>
                            <h5 class="card-title mt-2 text-dark">Productos</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="admin/proveedores.php" class="text-decoration-none">
                    <div class="card h-100 shadow tarjeta-hover border-0">
                        <div class="card-body text-center">
                            <i class="bi bi-truck display-4 text-secondary"></i>
                            <h5 class="card-title mt-2 text-dark">Proveedores</h5>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="admin/movimientos.php" class="text-decoration-none">
                    <div class="card h-100 shadow tarjeta-hover border-0">
                        <div class="card-body text-center">
                            <i class="bi bi-arrow-left-right display-4 text-info"></i>
                            <h5 class="card-title mt-2 text-dark">Movimientos</h5>
                        </div>
                    </div>
                </a>
            </div>
        <?php endif; ?>

        <?php if ($rol_id == 3): ?>
            <h5 class="mt-4 text-success">Auditoría</h5>
            <div class="col-md-4">
                <a href="admin/reportes.php" class="text-decoration-none">
                    <div class="card h-100 shadow tarjeta-hover border-0">
                        <div class="card-body text-center">
                            <i class="bi bi-graph-up display-4 text-warning"></i>
                            <h5 class="card-title mt-2 text-dark">Ver Reportes</h5>
                        </div>
                    </div>
                </a>
            </div>
        <?php endif; ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>