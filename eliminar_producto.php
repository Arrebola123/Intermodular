<?php
include 'conexion.php';

// Verificar si se recibió el ID del producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_producto"])) {
    $id_producto = intval($_POST["id_producto"]);

    // Eliminar el producto de la base de datos
    $sql = "DELETE FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_producto);

    if ($stmt->execute()) {
        echo "<script>alert('Producto eliminado correctamente'); window.location.href='tabla_productos.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el producto'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
