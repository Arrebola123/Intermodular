<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda_relojes";

// Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    die("⚠ Debes iniciar sesión para eliminar productos del carrito.");
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Conexión fallida: " . $conn->connect_error);
}

$usuario_id = $_SESSION['usuario_id'];

// Verificar que el id_producto está en la URL
if (isset($_GET['id'])) {
    $id_producto = (int)$_GET['id'];

    // Obtener el pedido abierto del usuario
    $sql = "SELECT id FROM pedidos WHERE id_usuario = ? AND estado = 0 LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("❌ No se encontró un pedido abierto para este usuario.");
    } else {
        $pedido = $result->fetch_assoc();
        $pedido_id = $pedido['id'];
    }
    $stmt->close();

    // Obtener el precio del producto que se va a eliminar
    $sql = "SELECT p.precio, c.cantidad FROM comprar c INNER JOIN productos p ON c.id_producto = p.id WHERE c.id_pedido = ? AND c.id_producto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $pedido_id, $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();
    $producto = $result->fetch_assoc();
    $precio_producto = $producto['precio'];
    $cantidad_producto = $producto['cantidad'];
    $stmt->close();

    if ($cantidad_producto > 1) {
        // Si la cantidad es mayor a 1, solo disminuimos la cantidad en lugar de eliminar el producto
        $sql = "UPDATE comprar SET cantidad = cantidad - 1 WHERE id_pedido = ? AND id_producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $pedido_id, $id_producto);
        $stmt->execute();

        // Actualizar el total en la tabla pedidos después de restar el precio del producto
        $sql = "UPDATE pedidos SET precio = precio - ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $precio_producto, $pedido_id);
        $stmt->execute();

        // Redirigir al carrito después de disminuir la cantidad
        header("Location: carrito.php");
        exit();
    } else {
        // Si la cantidad es 1, eliminamos el producto del carrito
        $sql = "DELETE FROM comprar WHERE id_pedido = ? AND id_producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $pedido_id, $id_producto);
        if ($stmt->execute()) {
            // Actualizar el total en la tabla pedidos después de eliminar el producto
            $sql = "UPDATE pedidos SET precio = precio - ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("di", $precio_producto, $pedido_id);
            $stmt->execute();
        }

        // Redirigir al carrito después de eliminar el producto
        header("Location: carrito.php");
        exit();
    }
} else {
    echo "❌ No se especificó el producto a eliminar.";
}

$conn->close();
?>
