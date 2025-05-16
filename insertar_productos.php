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
        // Obtener datos del formulario
        $id_producto = $_POST['id_producto'] ?? null;
        $nombre = $_POST['nombre'];
        $numero_de_modelo = $_POST['numero_de_modelo'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $materiales = $_POST['materiales'];
        $movimiento = $_POST['movimiento'];
        $resistencia_al_agua = $_POST['resistencia_al_agua'];
        $cristal = $_POST['cristal'];
        $stock_disponible = $_POST['stock_disponible'];
        $id_categoria = $_POST['id_categoria'];
        $id_proveedor = $_POST['id_proveedor'];
        $id_marca = $_POST['id_marca'];

        // Carpeta donde se guardarán las imágenes
        $directorio = "imgs/";

        // Asegurar que la carpeta exista
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        // Si se está editando un producto, obtener la imagen actual
        $imagen1 = null;
        if ($id_producto) {
            $sql = "SELECT imagen1 FROM productos WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_producto);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {
                $fila = $resultado->fetch_assoc();
                $imagen1 = $fila['imagen1']; // Guardar la imagen existente
            } else {
                throw new Exception("No se encontró el producto.");
            }
        }

        // Procesar imagen 1 (solo si se sube una nueva)
        if (!empty($_FILES["imagen1"]["name"])) {
            $imagen1_nombre = basename($_FILES["imagen1"]["name"]);
            $imagen1 = $directorio . $imagen1_nombre;

            if (!move_uploaded_file($_FILES["imagen1"]["tmp_name"], $imagen1)) { 
                throw new Exception("Error al subir la imagen 1.");
            }
        }

        // 📌 Verificación antes de insertar
        echo "Imagen 1 usada: " . $imagen1 . "<br>";

        // Si es una actualización (el ID del producto existe)
        if ($id_producto) {
            $sql = "UPDATE productos 
                    SET nombre=?, numero_de_modelo=?, descripcion=?, materiales=?, movimiento=?, 
                        resistencia_al_agua=?, cristal=?, precio=?, stock_disponible=?, imagen1=?, 
                        id_categoria=?, id_proveedor=?, id_marca=? 
                    WHERE id=?";

            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            $stmt->bind_param("sssssssdisiiii", 
                $nombre, $numero_de_modelo, $descripcion, $materiales, $movimiento, 
                $resistencia_al_agua, $cristal, $precio, $stock_disponible, 
                $imagen1, $id_categoria, $id_proveedor, $id_marca, $id_producto);
        
        } else {
            // Si es una inserción (nuevo producto)
            $sql = "INSERT INTO productos 
                    (nombre, numero_de_modelo, descripcion, materiales, movimiento, 
                    resistencia_al_agua, cristal, precio, stock_disponible, imagen1, 
                    id_categoria, id_proveedor, id_marca) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Error en la preparación de la consulta: " . $conn->error);
            }

            $stmt->bind_param("sssssssdisiii", 
                $nombre, $numero_de_modelo, $descripcion, $materiales, $movimiento, 
                $resistencia_al_agua, $cristal, $precio, $stock_disponible, 
                $imagen1, $id_categoria, $id_proveedor, $id_marca);
        }

        // Ejecutar la consulta
        if (!$stmt->execute()) {
            throw new Exception("Error al guardar el producto: " . $stmt->error);
        }

        // Confirmar transacción
        $conn->commit();
        echo "✅ Producto guardado con éxito.";
        echo "<meta http-equiv='refresh' content='3;url=tabla_productos.php'>";

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
