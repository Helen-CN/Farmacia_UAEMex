<?php
session_start();
if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol_id'] != 1 && $_SESSION['rol_id'] != 2)) {
    header("Location: ../login.php");
    exit();
}

require_once '../conexion.php';

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT nombre, descripcion, stock, precio, proveedor_id FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$producto = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$producto) {
    header("Location: productos.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto - Farmacia UAEMex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../css/estilos.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="text-success">Editar Producto</h3>
    <a href="productos.php" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Volver</a>

    <div class="card p-4 shadow-sm">
        <form action="productos_actualizar.php" method="POST" class="row g-3">
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="col-md-4">
                <label for="nombre" class="form-label">Nombre del producto</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
            </div>
            <div class="col-md-4">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcion" class="form-control"><?= htmlspecialchars($producto['descripcion'] ?? '') ?></textarea>
            </div>
            <div class="col-md-4">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" value="<?= $producto['stock'] ?>" required>
            </div>
            <div class="col-md-4">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" step="0.01" name="precio" id="precio" class="form-control" value="<?= $producto['precio'] ?>" required>
            </div>
            <div class="col-md-4">
                <label for="proveedor_id" class="form-label">Proveedor</label>
                <select name="proveedor_id" id="proveedor_id" class="form-select" required>
                    <option value="">Seleccione proveedor</option>
                    <?php
                    $proveedores = $conn->query("SELECT id, nombre FROM proveedores");
                    while ($proveedor = $proveedores->fetch_assoc()) {
                        $selected = $proveedor['id'] == $producto['proveedor_id'] ? 'selected' : '';
                        echo "<option value='{$proveedor['id']}' $selected>{$proveedor['nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Actualizar</button>
                <a href="productos.php" class="btn btn-danger ms-2"><i class="bi bi-x-lg"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>