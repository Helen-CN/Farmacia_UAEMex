<?php
require_once __DIR__ . '/../config/conexion.php'; // Ajusta la ruta

// Cambiar esta nueva contraseña para todos los usuarios con contraseña corta
$nuevaPassword = '123456';
$hash = password_hash($nuevaPassword, PASSWORD_BCRYPT);

// Buscar usuarios con contraseña corta
$sql = "SELECT id, nombre, correo FROM usuarios WHERE CHAR_LENGTH(contrasena) < 60";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($usuario = $result->fetch_assoc()) {
        $id = $usuario['id'];
        $correo = $usuario['correo'];
        $nombre = $usuario['nombre'];

        // Actualizar contraseña cifrada
        $stmt = $conn->prepare("UPDATE usuarios SET contrasena = ? WHERE id = ?");
        $stmt->bind_param("si", $hash, $id);
        $stmt->execute();

        echo "Contraseña actualizada para usuario: $nombre ($correo) <br>";
    }
} else {
    echo "No hay usuarios con contraseñas cortas.";
}
?>
