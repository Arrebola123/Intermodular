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

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos categoria
    $nombre_categoria = $_POST['nombre'];

 
// Insertar datos categoria
    $sql1 = "INSERT INTO categorias (nombre) 
             VALUES ('$nombre_categoria')";

    if ($conn->query($sql1) === TRUE) {
        echo "Categoria guardada correctamente.";
    } else {
        echo "Error al guardar la categoria: " . $conn->error;
    }

    // Cerrar conexión
    $conn->close();
}
?>
