<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 4) {
    header("Location: login.php");
    exit();
}

require_once 'conexion.php';

$productos = $conn->query("SELECT id, nombre, stock FROM productos WHERE stock > 0");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitar Medicamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Solicitar Medicamento</h3>
    <a href="alumno_panel.php" class="btn btn-secondary mb-3">← Volver</a>

    <form action="solicitar_guardar.php" method="POST">
        <div class="mb-3">
            <label for="producto_id" class="form-label">Selecciona el medicamento</label>
            <select name="producto_id" class="form-select" required>
                <option value="">-- Selecciona --</option>
                <?php while ($p = $productos->fetch_assoc()): ?>
                    <option value="<?= $p['id'] ?>">
                        <?= $p['nombre'] ?> (Stock: <?= $p['stock'] ?>)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" name="cantidad" class="form-control" required min="1">
        </div>

        <button class="btn btn-primary w-100">Enviar Solicitud</button>
    </form>
</div>
</body>
</html>
