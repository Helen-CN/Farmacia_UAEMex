<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'conexion.php';

$nombre = $_SESSION['usuario_nombre'];
$rol_id = $_SESSION['rol_id'];

$roles = [
    1 => 'Administrador',
    2 => 'Inventario',
    3 => 'Auditor'
];
$rol_nombre = $roles[$rol_id] ?? 'Desconocido';

// KPIs
$total_productos = $conn->query("SELECT COUNT(*) AS total FROM productos")->fetch_assoc()['total'];
$productos_bajos = $conn->query("SELECT COUNT(*) AS total FROM productos WHERE stock <= 5")->fetch_assoc()['total'];
$total_usuarios = $conn->query("SELECT COUNT(*) AS total FROM usuarios")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Farmacia UAEMex</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">
    <style>
        .tarjeta-hover:hover {
            transform: scale(1.05);
            transition: 0.3s;
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

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
<main class="flex-grow-1">
<div class="container mt-5">
    <h3 class="mb-2 text-success">Panel de Control</h3>
    <p class="lead text-muted">Bienvenido(a), <?= htmlspecialchars($nombre) ?>. Tienes acceso como <strong><?= $rol_nombre ?></strong>.</p>

    <!-- Tarjetas resumen -->
    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
        <div class="col">
            <div class="card text-white bg-primary shadow-sm h-100 tarjeta-hover">
                <div class="card-body text-center">
                    <h5 class="card-title">Total de Productos</h5>
                    <p class="display-5 fw-bold"><?= $total_productos ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-warning shadow-sm h-100 tarjeta-hover">
                <div class="card-body text-center">
                    <h5 class="card-title">Stock Bajo (≤ 5)</h5>
                    <p class="display-5 fw-bold"><?= $productos_bajos ?></p>
                </div>
            </div>
        </div>
        <?php if ($rol_id == 1): ?>
        <div class="col">
            <div class="card text-white bg-success shadow-sm h-100 tarjeta-hover">
                <div class="card-body text-center">
                    <h5 class="card-title">Usuarios Registrados</h5>
                    <p class="display-5 fw-bold"><?= $total_usuarios ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Accesos según rol -->
    <div class="row g-4 mb-5">
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
</main>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-3 mt-auto">
    <small>Farmacia Universitaria UAEMéx &copy; <?= date("Y") ?>. Todos los derechos reservados.</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
