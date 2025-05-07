<?php
session_start();
if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol_id'] != 1 && $_SESSION['rol_id'] != 2)) {
    header("Location: ../login.php");
    exit();
}

require_once '../conexion.php';

// Obtener productos
$productos = $conn->query("
    SELECT p.id, p.nombre, p.descripcion, p.stock, p.precio, pr.nombre AS proveedor
    FROM productos p
    LEFT JOIN proveedores pr ON p.proveedor_id = pr.id
");

// Eliminar producto (si se manda por GET)
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conn->query("DELETE FROM productos WHERE id = $id");
    header("Location: productos.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3 class="mb-4">Gestión de Productos</h3>
    <a href="../dashboard.php" class="btn btn-secondary mb-3">← Volver al Dashboard</a>

    <form method="POST" action="productos_guardar.php" class="row g-3 mb-4">
        <div class="col-md-3">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="descripcion" class="form-control" placeholder="Descripción" required>
        </div>
        <div class="col-md-2">
            <input type="number" name="stock" class="form-control" placeholder="Stock" required>
        </div>
        <div class="col-md-2">
            <input type="number" name="precio" class="form-control" placeholder="Precio" step="0.01" required>
        </div>
        <div class="col-md-2">
            <select name="proveedor_id" class="form-select" required>
                <option value="">Proveedor</option>
                <?php
                $proveedores = $conn->query("SELECT id, nombre FROM proveedores");
                while ($prov = $proveedores->fetch_assoc()):
                ?>
                    <option value="<?= $prov['id'] ?>"><?= $prov['nombre'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-12">
            <button class="btn btn-primary w-100">Agregar Producto</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th><th>Nombre</th><th>Descripción</th><th>Stock</th><th>Precio</th><th>Proveedor</th><th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($p = $productos->fetch_assoc()): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= $p['nombre'] ?></td>
                    <td><?= $p['descripcion'] ?></td>
                    <td><?= $p['stock'] ?></td>
                    <td>$<?= number_format($p['precio'], 2) ?></td>
                    <td><?= $p['proveedor'] ?></td>
                    <td>
                        <a href="productos.php?eliminar=<?= $p['id'] ?>" onclick="return confirm('¿Eliminar producto?')" class="btn btn-sm btn-danger">Eliminar</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
