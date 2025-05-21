<?php
require_once __DIR__ . '/../config/rutas.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Farmacia UAEMex</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS de terceros -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Tus estilos -->
    <link href="<?= URL_BASE ?>/public/css/estilos.css" rel="stylesheet">
    <link href="<?= URL_BASE ?>/public/css/login.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">
            <div class="card login-card shadow-lg border-0">
                <div class="text-center mb-4 mt-4">
                    <img src="<?= URL_BASE ?>/public/img/logo-uaemex.png" class="logo-img mb-2" alt="UAEMex" width="100">
                    <h4 class="fw-bold text-success">Farmacia Universitaria</h4>
                    <small class="text-muted">Acceso institucional</small>
                </div>

                <!-- Alertas desde backend -->
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger mx-3"><?= htmlspecialchars($_GET['error']) ?></div>
                <?php elseif (isset($_GET['success'])): ?>
                    <div class="alert alert-success mx-3"><?= htmlspecialchars($_GET['success']) ?></div>
                <?php endif; ?>

                <!-- Alertas dinámicas desde JS -->
                <div id="alertContainer" class="mx-3"></div>

                <form id="loginForm" action="<?= URL_BASE ?>/controllers/procesar_login.php" method="POST" autocomplete="off" class="px-3 pb-4">
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo institucional</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input id="correo" type="email" name="correo" class="form-control" placeholder="ej. nombre@alumno.uaemex.mx" required autocomplete="email">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input id="contrasena" type="password" name="contrasena" class="form-control" placeholder="********" required autocomplete="current-password">
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword" aria-label="Mostrar u ocultar contraseña">
                                <i class="bi bi-eye-fill"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 shadow-sm">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Ingresar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script src="<?= URL_BASE ?>/public/js/login.js"></script>
</body>
</html>
