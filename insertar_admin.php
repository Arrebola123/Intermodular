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
        // Datos de usuario
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT); // Encriptar contraseña
        $rol = $_POST["rol"];

        // Insertar en la tabla `usuarios`
        $sql_usuario = "INSERT INTO usuarios (dni, nombre, contraseña, administrador) VALUES (?, ?, ?, 1)";
        $stmt_usuario = $conn->prepare($sql_usuario);
        if (!$stmt_usuario) {
            throw new Exception("Error en la preparación de la consulta de usuarios: " . $conn->error);
        }

        $stmt_usuario->bind_param("sss", $dni, $nombre, $contraseña);
        
        if (!$stmt_usuario->execute()) {
            throw new Exception("Error al insertar el usuario: " . $stmt_usuario->error);
        }

        // Obtener el ID del usuario recién insertado
        $id_usuario = $stmt_usuario->insert_id;

        // Insertar en la tabla `clientes`
        $sql_empleado = "INSERT INTO empleados (id_usuario, fecha_contratacion, rol) VALUES (?, CURDATE(), ?)";
        $stmt_empleado = $conn->prepare($sql_empleado);
        if (!$stmt_empleado) {
            throw new Exception("Error en la preparación de la consulta de clientes: " . $conn->error);
        }

        $stmt_empleado->bind_param("is", $id_usuario, $rol);
        
        if (!$stmt_empleado->execute()) {
            throw new Exception("Error al insertar el cliente: " . $stmt_empleado->error);
        }

        // Confirmar transacción si todo salió bien
        $conn->commit();
        echo "✅ Administrador registrado con éxito.";
        echo "<meta http-equiv='refresh' content='3;url=index.php'>";

    } catch (Exception $e) {
        // Si algo falla, deshacer todos los cambios
        $conn->rollback();
        echo "❌ " . $e->getMessage();
    }

    // Cerrar conexión
    $stmt_usuario->close();
    $stmt_empleado->close();
    $conn->close();
}
?>
