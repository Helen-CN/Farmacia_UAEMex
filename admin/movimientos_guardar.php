<?php
session_start();
if (!isset($_SESSION['usuario_id']) || ($_SESSION['rol_id'] != 1 && $_SESSION['rol_id'] != 2)) {
    header("Location: ../login.php");
    exit();
}

require_once '../conexion.php';

$producto_id = intval($_POST['producto_id']);
$cantidad = intval($_POST['cantidad']);
$tipo = $_POST['tipo'];
$usuario_id = $_SESSION['usuario_id'];

if ($producto_id && $cantidad > 0 && in_array($tipo, ['entrada', 'salida'])) {
    $conn->begin_transaction();
    try {
        // Insertar movimiento
        $stmt = $conn->prepare("INSERT INTO movimientos (producto_id, cantidad, tipo, usuario_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iisi", $producto_id, $cantidad, $tipo, $usuario_id);
        $stmt->execute();

        // Actualizar stock
        $operador = $tipo === 'entrada' ? '+' : '-';
        $conn->query("UPDATE productos SET stock = stock $operador $cantidad WHERE id = $producto_id");

        $conn->commit();
        header("Location: movimientos.php");
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}
