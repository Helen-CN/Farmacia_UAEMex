<?php
session_start();
require_once __DIR__ . '/../../config/rutas.php';
require_once __DIR__ . '/../../config/conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 1) {
    header("Location: " . URL_BASE . "/views/login.php");
    exit();
}


$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT nombre, correo, rol_id FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$usuario = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$usuario) {
    header("Location: " . URL_BASE . "/admin/views/usuarios.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario - Farmacia UAEMex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../css/estilos.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="text-success">Editar Usuario</h3>
    <a href="<?= URL_BASE ?>/admin/views/usuarios.php" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Volver</a>

    <div class="card p-4 shadow-sm">
        <form action="<?= URL_BASE ?>/admin/controllers/usuarios_actualizar.php" method="POST" class="row g-3">
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="col-md-4">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
            </div>
            <div class="col-md-4">
                <label for="correo" class="form-label">Correo electrónico</label>
                <input type="email" name="correo" id="correo" class="form-control" value="<?= htmlspecialchars($usuario['correo']) ?>" required>
            </div>
            <div class="col-md-4">
                <label for="contrasena" class="form-label">Nueva contraseña (opcional)</label>
                <input type="password" name="contrasena" id="contrasena" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="rol_id" class="form-label">Rol</label>
                <select name="rol_id" id="rol_id" class="form-select" required>
                    <option value="">Seleccione rol</option>
                    <?php
                    $roles = $conn->query("SELECT id, nombre FROM roles");
                    while ($rol = $roles->fetch_assoc()) {
                        $selected = $rol['id'] == $usuario['rol_id'] ? 'selected' : '';
                        echo "<option value='{$rol['id']}' $selected>{$rol['nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Actualizar</button>
                <a href="<?= URL_BASE ?>/admin/views/usuarios.php" class="btn btn-danger ms-2"><i class="bi bi-x-lg"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>