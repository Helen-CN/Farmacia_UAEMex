<?php
session_start();
if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol_id'] != 1 && $_SESSION['rol_id'] != 2)) {
    header("Location: ../login.php");
    exit();
}

require_once '../conexion.php';

$productos = $conn->query("SELECT id, nombre FROM productos");

// Obtener últimos movimientos
$movimientos = $conn->query("
    SELECT m.id, p.nombre AS producto, m.cantidad, m.tipo, m.fecha
    FROM movimientos m
    JOIN productos p ON m.producto_id = p.id
    ORDER BY m.fecha DESC
    LIMIT 10
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Movimientos de Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/estilos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3 class="mb-4">Registrar Movimiento</h3>
    <a href="../dashboard.php" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left-circle"></i> Volver al Dashboard</a>

    <form action="movimientos_guardar.php" method="POST" class="row g-3 mb-4">
        <div class="col-md-4">
            <select name="producto_id" class="form-select" required>
                <option value="">Seleccionar producto</option>
                <?php while ($p = $productos->fetch_assoc()): ?>
                    <option value="<?= $p['id'] ?>"><?= $p['nombre'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" name="cantidad" class="form-control" placeholder="Cantidad" required min="1">
        </div>
        <div class="col-md-2">
            <select name="tipo" class="form-select" required>
                <option value="">Tipo</option>
                <option value="entrada">Entrada</option>
                <option value="salida">Salida</option>
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary w-100"><i class="bi bi-plus-circle"></i> Registrar Movimiento</button>
        </div>
    </form>

    <h5>Últimos Movimientos</h5>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Tipo</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($m = $movimientos->fetch_assoc()): ?>
                <tr class="<?= $m['tipo'] == 'entrada' ? 'table-success' : 'table-danger' ?>">
                    <td><?= $m['id'] ?></td>
                    <td><?= $m['producto'] ?></td>
                    <td><?= $m['cantidad'] ?></td>
                    <td>
                        <i class="bi <?= $m['tipo'] == 'entrada' ? 'bi-box-arrow-in-down' : 'bi-box-arrow-up' ?>"></i>
                        <?= ucfirst($m['tipo']) ?>
                    </td>
                    <td><?= $m['fecha'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
