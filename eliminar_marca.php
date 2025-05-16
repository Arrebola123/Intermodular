<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda_relojes";

// Conectar a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se recibió el ID del producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_marca"])) {
    $id_marca = intval($_POST["id_marca"]);

    // Eliminar el producto de la base de datos
    $sql = "DELETE FROM marca WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_marca);

    if ($stmt->execute()) {
        echo "<script>alert('Marca eliminada correctamente'); window.location.href='tabla_marcas.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar la marca'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
