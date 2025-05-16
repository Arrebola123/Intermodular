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
        $nombre = $_POST['nombre'];
        $dni = $_POST['dni'];
        $correo = $_POST["correo"];
        $contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT); // Encriptar contraseña

        // Insertar en la tabla `usuarios`
        $sql_usuario = "INSERT INTO usuarios (dni, nombre, contraseña, administrador) VALUES (?, ?, ?, 0)";
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
        $sql_cliente = "INSERT INTO clientes (id_usuario, correo) VALUES (?, ?)";
        $stmt_cliente = $conn->prepare($sql_cliente);
        if (!$stmt_cliente) {
            throw new Exception("Error en la preparación de la consulta de clientes: " . $conn->error);
        }

        $stmt_cliente->bind_param("is", $id_usuario, $correo);
        
        if (!$stmt_cliente->execute()) {
            throw new Exception("Error al insertar el cliente: " . $stmt_cliente->error);
        }

        // Confirmar transacción si todo salió bien
        $conn->commit();
        echo "✅ Cliente registrado con éxito.";
        echo "<meta http-equiv='refresh' content='3;url=formulario_iniciarSesion.html'>";

    } catch (Exception $e) {
        // Si algo falla, deshacer todos los cambios
        $conn->rollback();
        echo "❌ " . $e->getMessage();
    }

    // Cerrar conexión
    $stmt_usuario->close();
    $stmt_cliente->close();
    $conn->close();
}
?>
