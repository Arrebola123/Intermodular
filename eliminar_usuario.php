<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda_relojes";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_usuario"])) {
    $id_usuario = intval($_POST["id_usuario"]);

    // Eliminar de clientes si existe
    $conn->query("DELETE FROM clientes WHERE id_usuario = $id_usuario");

    // Eliminar de empleados si existe
    $conn->query("DELETE FROM empleados WHERE id_usuario = $id_usuario");

    // Finalmente, eliminar de la tabla usuarios
    $sql = "DELETE FROM usuarios WHERE id = $id_usuario";

    if ($conn->query($sql) === TRUE) {
        echo "Usuario eliminado correctamente.";
    } else {
        echo "Error al eliminar usuario: " . $conn->error;
    }
}

$conn->close();
header("Location: tabla_usuarios.php"); // Redirigir a la lista de usuarios
exit();
?>