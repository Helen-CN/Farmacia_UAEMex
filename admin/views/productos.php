<?php
session_start();
require_once __DIR__ . '/../../config/conexion.php';
require_once __DIR__ . '/../../config/rutas.php';

if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol_id'] != 1 && $_SESSION['rol_id'] != 2)) {
    header("Location: " . URL_BASE . "/views/login.php");
    exit();
}

// Usar la vista para listar productos con proveedor
$sql = "SELECT id, nombre, descripcion, stock, precio, proveedor FROM vista_stock_productos";
$resultado = $conn->query($sql);

$success = isset($_GET['success']) && $_GET['success'] == 1;
$error = isset($_GET['error']) && $_GET['error'] == 1;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Productos - Farmacia UAEMex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= URL_BASE ?>/public/css/estilos.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Productos Registrados</h3>
        <a href="<?= URL_BASE ?>/views/dashboard.php" class="btn btn-outline-success">
            <i class="bi bi-arrow-left"></i> Volver al Panel
        </a>
    </div>

    <!-- Formulario en un acordeón desplegable -->
    <div class="accordion mb-4" id="accordionForm">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingForm">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseForm" aria-expanded="true" aria-controls="collapseForm">
                    <i class="bi bi-capsule-pill me-2"></i> Agregar nuevo producto
                </button>
            </h2>
            <div id="collapseForm" class="accordion-collapse collapse show" aria-labelledby="headingForm" data-bs-parent="#accordionForm">
                <div class="accordion-body">
                    <form action="<?= URL_BASE ?>/admin/controllers/productos_guardar.php" method="POST" class="row g-3">
                        <div class="col-md-3">
                            <input type="text" name="nombre" class="form-control" placeholder="Nombre del producto" required>
                        </div>
                        <div class="col-md-3">
                            <textarea name="descripcion" class="form-control" placeholder="Descripción"></textarea>
                        </div>
                        <div class="col-md-2">
                            <input type="number" name="stock" class="form-control" placeholder="Stock inicial" value="0" required>
                        </div>
                        <div class="col-md-2">
                            <input type="number" step="0.01" name="precio" class="form-control" placeholder="Precio" required>
                        </div>
                        <div class="col-md-2">
                            <select name="proveedor_id" class="form-select" required>
                                <option value="">Seleccione proveedor</option>
                                <?php
                                $proveedores = $conn->query("SELECT id, nombre FROM proveedores");
                                while ($prov = $proveedores->fetch_assoc()) {
                                    echo "<option value='{$prov['id']}'>{$prov['nombre']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-capsule-pill"></i> Guardar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas de éxito o error -->
    <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>¡Éxito!</strong> La operación se realizó correctamente.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error</strong> Ocurrió un problema al realizar la operación.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Tabla de productos -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Proveedor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($p = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['nombre']) ?></td>
                <td>
                    <?= htmlspecialchars(trim($p['descripcion']) !== '' ? $p['descripcion'] : 'Sin descripción') ?>
                </td>
                <td><?= $p['stock'] ?></td>
                <td>$<?= number_format($p['precio'], 2) ?></td>
                <td><?= htmlspecialchars($p['proveedor']) ?></td>
                <td>
                    <a href="<?= URL_BASE ?>/admin/controllers/productos_editar.php?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i> Editar
                    </a>
                    <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="<?= $p['id'] ?>">
                        <i class="bi bi-trash"></i> Eliminar
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal de confirmación para eliminar -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este producto? Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const confirmDeleteModal = document.getElementById('confirmDeleteModal');
    confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const confirmDeleteBtn = confirmDeleteModal.querySelector('#confirmDeleteBtn');
        confirmDeleteBtn.href = '<?= URL_BASE ?>/admin/controllers/productos_eliminar.php?id=' + id;
    });
</script>
</body>
</html>
