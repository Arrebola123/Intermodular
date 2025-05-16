<?php
session_start(); 

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

// Verificar si se pasa un ID válido en la URL
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $producto_id = intval($_GET["id"]); // Convertir a número seguro
    
    // Consulta para obtener los datos del producto por ID
    $query = "SELECT * FROM productos WHERE id = $producto_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
    } else {
        die("❌ Producto no encontrado.");
    }
} else {
    die("⚠ No se ha especificado un producto válido.");
}

if (isset($_SESSION['usuario_id'])) {
    // Recuperar el ID del usuario desde la sesión
    $usuario_id = $_SESSION['usuario_id'];
    
    // Realiza una consulta a la base de datos para obtener el valor del campo "administrador"
    $sql = "SELECT administrador FROM usuarios WHERE id = '$usuario_id'";
    $result = mysqli_query($conn, $sql);
    $usuario = mysqli_fetch_assoc($result);
    
    // Ahora puedes obtener el valor de administrador
    $es_administrador = $usuario['administrador']; // Será 0 o 1
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($producto["nombre"]); ?></title>
    <link rel="stylesheet" href="styles_detalles_productoss.css">
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
            <!-- Si el usuario está logueado, mostramos el perfil o el panel de control según el roL -->
            <?php if ($es_administrador == 1): ?>
                <li><a href="panel_control.html">Panel de Control</a></li>
            <?php else: ?>
                <li><a href="perfil.php"><?php echo $_SESSION['usuario_nombre']; ?> - Perfil</a></li>
            <?php endif; ?>
            <li><a href="Login_intermodular/cerrar_sesion.php">Cerrar sesión</a></li>
            <?php if ($es_administrador == 0): ?>
            <div class="carrito">
            <button class="icon" onclick="window.location.href= 'carrito.php'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="icon" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0M6.854 8.146a.5.5 0 1 0-.708.708L7.293 10l-1.147 1.146a.5.5 0 0 0 .708.708L8 10.707l1.146 1.147a.5.5 0 0 0 .708-.708L8.707 10l1.147-1.146a.5.5 0 0 0-.708-.708L8 9.293z"/>
                </svg>
            </button>
        </div>
        <?php endif; ?>
        <?php else: ?>
            <!-- Si no está logueado, mostramos el botón de iniciar sesión -->
            <li><a href="Login_intermodular/formulario_iniciarSesion.html">Iniciar sesión</a></li>
        <?php endif; ?>

       
    </ul>
</nav>
    </div>
</header>

<main>
    <?php 
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); 
    ?>
        <div class="product-detail">
            <img class="productos" src="<?php echo $producto["imagen1"]; ?>" alt="<?php echo $row["nombre"]; ?>">
            <div class="product-info">
                <div class="title"><?php echo $producto["nombre"]; ?></div>
                <div class="description"><?php echo $producto["descripcion"]; ?></div>
                <ul class="specifications">
                <li><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-watch" viewBox="0 0 16 16">
                    <path d="M8.5 5a.5.5 0 0 0-1 0v2.5H6a.5.5 0 0 0 0 1h2a.5.5 0 0 0 .5-.5z"/>
                    <path d="M5.667 16C4.747 16 4 15.254 4 14.333v-1.86A6 6 0 0 1 2 8c0-1.777.772-3.374 2-4.472V1.667C4 .747 4.746 0 5.667 0h4.666C11.253 0 12 .746 12 1.667v1.86a6 6 0 0 1 1.918 3.48.502.502 0 0 1 .582.493v1a.5.5 0 0 1-.582.493A6 6 0 0 1 12 12.473v1.86c0 .92-.746 1.667-1.667 1.667zM13 8A5 5 0 1 0 3 8a5 5 0 0 0 10 0"/>
                  </svg> <strong>Materiales:</strong> <?php echo $producto ["materiales"]; ?></li>
                <li><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-wide-connected" viewBox="0 0 16 16">
                    <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5m0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78zM5.048 3.967l-.087.065zm-.431.355A4.98 4.98 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8zm.344 7.646.087.065z"/>
                  </svg> <strong>Movimiento:</strong> <?php echo $producto ["movimiento"]; ?></li>
                <li><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-droplet" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M7.21.8C7.69.295 8 0 8 0q.164.544.371 1.038c.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8m.413 1.021A31 31 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10a5 5 0 0 0 10 0c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z"/>
                    <path fill-rule="evenodd" d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87z"/>
                  </svg> <strong>Resistente al agua:</strong> <?php echo $producto ["resistencia_al_agua"]; ?></li>
                <li><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield" viewBox="0 0 16 16">
                    <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>
                  </svg> <strong>Cristal:</strong> <?php echo $producto ["cristal"]; ?></li>
                </ul>
                <div class="price"><?php echo $producto["precio"]; ?> €</div>
                <div class="checkout"> <button type="submit" onclick="window.location.href='añadir_al_carrito.php?id=<?php echo $producto['id'];?>'">AÑADIR AL CARRITO</button> </div>
            </div>
        </div>
    <?php 
    } else {
        echo "<p>Producto no encontrado.</p>";
    }
    ?>
</main>
</body>
</html>

<?php
$conn->close();
?>
