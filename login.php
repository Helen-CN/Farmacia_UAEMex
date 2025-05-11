<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Farmacia UAEMex</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            border: none;
            border-radius: 12px;
            padding: 2rem;
        }
        .logo-img {
            max-width: 70px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card login-card shadow-lg">
                <div class="text-center mb-4">
                    <img src="img/logo-uaemex.png" class="logo-img mb-2" alt="UAEMex">
                    <h4 class="fw-bold text-success">Farmacia Universitaria</h4>
                    <small class="text-muted">Acceso institucional</small>
                </div>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
                <?php endif; ?>

                <form action="procesar_login.php" method="POST">
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo institucional</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" name="correo" class="form-control" placeholder="ej. nombre@alumno.uaemex.mx" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" name="contrasena" class="form-control" placeholder="********" required>
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

</body>
</html>
