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
    // Iniciar transacción
    $conn->begin_transaction();

    try {
        // Datos de la marca
        $nombre = trim($_POST['nombre']); // Eliminar espacios en blanco
        
        // Verificar si la marca ya existe
        $sql_check = "SELECT id FROM marca WHERE nombre = ?";
        $stmt_check = $conn->prepare($sql_check);

        if (!$stmt_check) {
            throw new Exception("❌ Error en la consulta SQL: " . $conn->error);
        }

        $stmt_check->bind_param("s", $nombre);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            throw new Exception("❌ Error: La marca '$nombre' ya existe.");
        }

        $stmt_check->close();

        // Carpeta donde se guardarán los logos
        $directorio = "logos/";

        // Asegurar que la carpeta exista
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        // Procesar el logo
        $logo = NULL;
        if (!empty($_FILES["logo"]["name"])) {
            $logo_nombre = basename($_FILES["logo"]["name"]);
            $logo = $directorio . $logo_nombre;

            if (!move_uploaded_file($_FILES["logo"]["tmp_name"], $logo)) { 
                throw new Exception("Error al subir el logo.");
            }
        } else {
            throw new Exception("El logo es obligatorio.");
        }

        // Preparar la consulta SQL con `prepare()`
        $sql = "INSERT INTO marca (nombre, logo) VALUES (?, ?)";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error en la preparación de la consulta: " . $conn->error);
        }

        $stmt->bind_param("ss", $nombre, $logo);

        // Ejecutar la consulta
        if (!$stmt->execute()) {
            throw new Exception("Error al insertar la marca: " . $stmt->error);
        }

        // Confirmar transacción si todo salió bien
        $conn->commit();
        echo "✅ Marca registrada con éxito.";
        echo "<meta http-equiv='refresh' content='3;url=tabla_marcas.php'>";

    } catch (Exception $e) {
        // Si algo falla, deshacer todos los cambios
        $conn->rollback();
        echo "❌ " . $e->getMessage();
    }

    // Cerrar conexión
    $stmt->close();
    $conn->close();
}
?>
