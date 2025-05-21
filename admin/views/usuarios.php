<?php
session_start();
require_once __DIR__ . '/../../config/rutas.php';
require_once __DIR__ . '/../../config/conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) {
    header("Location: " . URL_BASE . "/../../views/login.php");
    exit();
}

// Usar la vista en lugar de la consulta con JOIN
$sql = "SELECT id, nombre, correo, rol FROM vista_usuarios_roles";
$resultado = $conn->query($sql);

$success = isset($_GET['success']) && $_GET['success'] == 1;
$error = isset($_GET['error']) && $_GET['error'] == 1;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios - Farmacia UAEMex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Usuarios Registrados</h3>
        <a href="<?= URL_BASE ?>/views/dashboard.php" class="btn btn-outline-success">
            <i class="bi bi-arrow-left"></i> Volver al Panel
        </a>
    </div>

    <!-- Formulario en un acordeón desplegable -->
    <div class="accordion mb-4" id="accordionForm">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingForm">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseForm" aria-expanded="true" aria-controls="collapseForm">
                    <i class="bi bi-person-plus me-2"></i> Agregar nuevo usuario
                </button>
            </h2>
            <div id="collapseForm" class="accordion-collapse collapse show" aria-labelledby="headingForm" data-bs-parent="#accordionForm">
                <div class="accordion-body">
                    <form action="<?= URL_BASE ?>/admin/controllers/usuarios_guardar.php" method="POST"  class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="nombre" class="form-control" placeholder="Nombre completo" required>
                        </div>
                        <div class="col-md-4">
                            <input type="email" name="correo" class="form-control" placeholder="Correo electrónico" required>
                        </div>
                        <div class="col-md-4">
                            <input type="password" name="contrasena" class="form-control" placeholder="Contraseña" required>
                        </div>
                        <div class="col-md-4">
                            <select name="rol_id" class="form-select" required>
                                <option value="">Seleccione rol</option>
                                <?php
                                $roles = $conn->query("SELECT id, nombre FROM roles");
                                while ($rol = $roles->fetch_assoc()) {
                                    echo "<option value='{$rol['id']}'>{$rol['nombre']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success"><i class="bi bi-person-plus"></i> Guardar Usuario</button>
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

    <!-- Tabla de usuarios -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $fila['id'] ?></td>
                <td><?= htmlspecialchars($fila['nombre']) ?></td>
                <td><?= htmlspecialchars($fila['correo']) ?></td>
                <td><?= $fila['rol'] ?></td>
                <td>
                    <a href="<?= URL_BASE ?>/admin/controllers/usuarios_editar.php?id=<?= $fila['id'] ?>" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i> Editar
                    </a>
                    <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" data-id="<?= $fila['id'] ?>">
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
                ¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.
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
    var confirmDeleteModal = document.getElementById('confirmDeleteModal');
    confirmDeleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var confirmDeleteBtn = confirmDeleteModal.querySelector('#confirmDeleteBtn');

        // Construir URL usando PHP para asegurar la ruta correcta
        var urlEliminar = "<?= URL_BASE ?>/admin/controllers/usuarios_eliminar.php?id=" + id;
        confirmDeleteBtn.href = urlEliminar;
    });
</script>

</body>
</html>
