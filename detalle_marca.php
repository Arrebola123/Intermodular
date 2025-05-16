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

// Verificar si se ha seleccionado una marca
if (isset($_GET['id_marca']) && is_numeric($_GET['id_marca'])) {
    $id_marca = intval($_GET['id_marca']);
} else {
    die("⚠ Error: No se ha proporcionado un ID de marca válido.");
}

// Construir la consulta para obtener productos de la marca seleccionada
$query = "SELECT p.id, p.nombre, p.precio, p.imagen1, m.nombre AS marca 
          FROM productos p
          INNER JOIN marca m ON p.id_marca = m.id
          WHERE p.id_marca = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_marca);
$stmt->execute();
$result = $stmt->get_result();

// Obtener el nombre de la marca antes del bucle
$nombre_marca = "Desconocida";
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Obtener la primera fila
    $nombre_marca = $row["marca"];
}

// Reiniciar el puntero de los resultados
$result->data_seek(0);

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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos <?php echo htmlspecialchars($nombre_marca); ?></title>
    <link rel="stylesheet" href="styles_detalles_marcas.css">
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

<section id="marcas">
<h2>Productos <?php echo htmlspecialchars($nombre_marca); ?></h2>
    <div class="marcas-grid">

    <?php 
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { 
            $producto_id = $row["id"];
    ?>
    <div class="name-flex">
        <div class="product" onclick="window.location.href='detalle_producto.php?id=<?php echo $row['id'];?>'">
            <img class="imgs_relojes" src="<?php echo $row["imagen1"]; ?>" 
                 alt="Imagen">
        
        </div>
        <div class="product_info">
        <div>
        <h3><?php echo $row["marca"]; ?></h3>
        <p><?php echo $row["nombre"]; ?></p>
        </div>
        <div>
        <h3 class="precio"><?php echo $row["precio"]; ?>€</h3>  
        </div>
        </div>
        </div>
    <?php }} else {
        echo "No se encontraron productos.";
    } ?>
        </div>
    </section>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
