<?php
session_start();
include 'conexion.php';

// Verificar si el usuario está logueadO
if (!isset($_SESSION['usuario_id'])) {
    header("Location:Login_intermodular/formulario_iniciarSesion.html");
    exit();
}



$usuario_id = $_SESSION['usuario_id'];

// Obtener el pedido abierto del usuario
$sql = "SELECT id FROM pedidos WHERE id_usuario = ? AND estado = 0 LIMIT 1";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error en la consulta SQL: " . $conn->error);  // Si la preparación de la consulta falla
}

$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $pedido_id = null;
} else {
    $pedido = $result->fetch_assoc();
    $pedido_id = $pedido['id'];
}
$stmt->close();

$total = 0;
$productos = [];

if ($pedido_id) {
    $sql = "
    SELECT p.nombre, p.precio, p.imagen1, c.id_producto, c.cantidad 
    FROM comprar c
    INNER JOIN productos p ON c.id_producto = p.id
    WHERE c.id_pedido = ? 
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $pedido_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar que la consulta devuelve resultados
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
            // Ahora el total se calcula multiplicando el precio por la cantidad
            $total += $row['precio'] * $row['cantidad'];
        }
    }

    $stmt->close();
}

if (isset($_SESSION['usuario_id'])) {
    // Recuperar el ID del usuario desde la sesión
    $usuario_id = $_SESSION['usuario_id'];
    
    // Realiza una consulta a la base de datos para obtener el valor del campo "administrador"
    $sql = "SELECT administrador FROM usuarios WHERE id = '$usuario_id'";
    $result1 = mysqli_query($conn, $sql);
    $usuario = mysqli_fetch_assoc($result1);
    
    // Ahora puedes obtener el valor de administrador
    $es_administrador = $usuario['administrador']; // Será 0 o 1
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f5;
            margin: 0;
            padding: 0;
            height: 100vh;
        }

        header {
    box-shadow: inset 0 10px 60px rgba(0, 0, 0, 1);
    position: relative;
    color: #fff;
}

.menu {
    padding: 10px 30px; /* Agrega padding para dar espacio */
    background-color: transparent;
    display: flex;
    justify-content: space-between;
    align-items: center; /* Centra verticalmente */
    color: #fff;
    height: 6vw; /* Asegura una altura adecuada */
}


.logo {
    height: 100%;
    display: flex; /* Asegura que el contenido interno se alinee */
    align-items: center; /* Centra verticalmente */
}

.logo img {
    display: block;
    height: auto;
    max-height: 100%; /* Para que se ajuste bien */
}


nav {
    white-space: nowrap;
    display: flex;
    align-items: center;
    justify-content: space-around;
    padding: 10px 20px;
}

nav ul {
    list-style: none;
    display: flex;
}

nav ul li {
    margin-left: 30px;
}

nav ul li a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s, transform 0.3s;
}

nav ul li a:hover {
    color: #717171;
    transform: scale(1.1);
}



.icon {
    color: #fff;
    height: 25px;
    background: transparent;
    border: none;
    cursor: pointer;
    transition: transform 0.3s, color 0.3s;
}

.icon:hover{
    transform: translateY(-2px);
    color: #717171;
}



        .flex-container{
            height: 80%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .cart-container {
            max-height: 500px;
            overflow-y: auto;
            width: 90%;
            max-width: 500px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 25px;
        }
        .cart-header {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #444;
        }
        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }
        .cart-item img {
            width: 70px;
            height: 70px;
            border-radius: 8px;
        }
        .cart-item-info {
            flex: 1;
            margin-left: 15px;
        }
        .cart-item-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }
        .cart-item-price {
            font-size: 14px;
            color: #666;
        }
        .remove-btn {
            background: none;
            border: none;
            color: red;
            cursor: pointer;
            font-size: 14px;
        }
        .total-price {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-top: 15px;
        }
        .checkout-container {
            text-align: center;
            margin-top: 20px;
        }
        .checkout-btn {
            background: #007bff;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }
        .checkout-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
<header>
<div class="menu">
        <div class="logo"><img src="logos/logo.png" onclick="window.location.href= 'index.php'" alt=""></div>
        <nav>
    <ul class="menu">
        <li><a href="index.php#products">Productos</a></li>
        <li><a href="index.php#contact">Contacto</a></li>
        <li><a href="sobre-nosotros.html">Sobre Nosotros</a></li>

        <?php if (isset($_SESSION['usuario_id'])): ?>
            <!-- Si el usuario está logueado, mostramos el perfil o el panel de control según el rol -->
            <?php if ($es_administrador == 1): ?>
                <li><a href="panel_control.php">Panel de Control</a></li>
            <?php else: ?>
                <li><a href="perfil.php"><?php echo $_SESSION['usuario_nombre']; ?> - Perfil</a></li>
            <?php endif; ?>
            <li><a href="Login_intermodular/cerrar_sesion.php">Cerrar sesión</a></li>
            <?php if ($es_administrador == 0): ?>
            
        <?php endif; ?>
        <?php else: ?>
            <!-- Si no está logueado, mostramos el botón de iniciar sesión -->
            <li><a href="Login_intermodular/formulario_iniciarSesion.html">Iniciar sesión</a></li>
        <?php endif; ?>
    </ul>
</nav>
    </div>
</header>
<section class="flex-container">
    <div class="cart-container">
        <div class="cart-header">Tu Carrito</div>
        
        <?php if (empty($productos)): ?>
            <p style="text-align:center; color:#888;">🛒 Tu carrito está vacío</p>
        <?php else: ?>
            <?php foreach ($productos as $producto): ?>
    <div class="cart-item">
        <img src="<?php echo htmlspecialchars($producto['imagen1']); ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
        <div class="cart-item-info">
            <div class="cart-item-title"><?php echo htmlspecialchars($producto['nombre']); ?></div>
            <div class="cart-item-price">$<?php echo number_format($producto['precio'], 2); ?></div>
            <div class="cart-item-quantity">Cantidad: <?php echo $producto['cantidad']; ?></div>
        </div>
        <button class="remove-btn" onclick="window.location.href='eliminar_producto_del_carrito.php?id=<?php echo $producto['id_producto'];?>'">Eliminar</button>
    </div>
<?php endforeach; ?>
            
            <div class="total-price">Precio del pedido: $<?php echo number_format($total, 2); ?></div>
            
            <div class="checkout-container">
                <button class="checkout-btn">Finalizar Compra</button>
            </div>
        <?php endif; ?>
    </div>
            </section>
</body>
</html>
