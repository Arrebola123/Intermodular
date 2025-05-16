<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda_relojes";

// 1️⃣ Verificar si el usuario está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Login_intermodular/formulario_iniciarSesion.php");
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Conexión fallida: " . $conn->connect_error);
}

$usuario_id = $_SESSION['usuario_id'];
$producto_id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

// 2️⃣ Verificar si el producto existe
$sql = "SELECT precio, nombre FROM productos WHERE id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("❌ Error en prepare (productos): " . $conn->error);
}

$stmt->bind_param("i", $producto_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("❌ Producto no encontrado.");
}

$producto = $result->fetch_assoc();
$precio = $producto['precio'];
$nombre_producto = $producto['nombre'];
$stmt->close();

// 3️⃣ Verificar si hay un pedido abierto para el usuario
$sql = "SELECT id FROM pedidos WHERE id_usuario = ? AND estado = 0 LIMIT 1";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("❌ Error en prepare (pedidos abiertos): " . $conn->error);
}

$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Si hay un pedido abierto, obtener su ID
    $pedido = $result->fetch_assoc();
    $pedido_id = $pedido['id'];
} else {
    // Si no hay pedido abierto, crear uno nuevo
    $sql = "INSERT INTO pedidos (fecha, estado, precio, id_usuario) VALUES (CURDATE(), 0, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("❌ Error en prepare (nuevo pedido): " . $conn->error);
    }

    $total_inicial = 0;  // Inicializamos el precio a 0
    $stmt->bind_param("di", $total_inicial, $usuario_id);
    $stmt->execute();
    $pedido_id = $stmt->insert_id;  // Obtener el ID del nuevo pedido
}
$stmt->close();

// 4️⃣ Verificar si el producto ya está en el carrito (tabla `comprar`)
$sql = "SELECT cantidad FROM comprar WHERE id_pedido = ? AND id_producto = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $pedido_id, $producto_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Producto ya está en el carrito, actualizar la cantidad
    $row = $result->fetch_assoc();
    $nueva_cantidad = $row['cantidad'] + 1;

    // Actualizar cantidad del producto
    $sql = "UPDATE comprar SET cantidad = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $nueva_cantidad);
    $stmt->execute();
    
    // Actualizar el precio total del pedido
    $sql = "UPDATE pedidos SET precio = precio + ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $precio, $pedido_id);
    $stmt->execute();
} else {
    // Si el producto no está en el carrito, lo agregamos
    $sql = "INSERT INTO comprar (id_pedido, id_producto, id_usuario, cantidad) VALUES (?, ?, ?, 1)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $pedido_id, $producto_id, $usuario_id);
    $stmt->execute();
    
    // Actualizamos el precio total del pedido
    $sql = "UPDATE pedidos SET precio = precio + ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $precio, $pedido_id);
    $stmt->execute();
}
$stmt->close();

// 5️⃣ Cerrar conexión y redirigir al carrito
$conn->close();
header("Location: carrito.php");
exit();
?>
