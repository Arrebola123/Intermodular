<?php
include 'conexion.php';

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos productos
    $nombre_proveedor = $_POST['nombre'];
    $contacto_proveedor = $_POST['contacto'];
    $direccion_proveedor = $_POST['direccion'];
   
// Insertar datos de proveedor
    $sql1 = "INSERT INTO proveedores (nombre, contacto, direccion) 
             VALUES ('$nombre_proveedor', '$contacto_proveedor', '$direccion_proveedor')";

    if ($conn->query($sql1) === TRUE) {
        echo "Proveedor guardado correctamente.";
    } else {
        echo "Error al guardar el proveedor: " . $conn->error;
    }

    // Cerrar conexión
    $conn->close();
}
?>
