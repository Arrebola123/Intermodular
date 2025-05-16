<?php
session_start();  // Inicia la sesión para acceder a las variables de sesión

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
    <title>Tienda de Relojes de Lujo</title>
    <link rel="stylesheet" href="styles_interfazzz.css">
</head>
<body>
<header id="home">
    <div class="menu">
        <div class="logo"><img src="logos/logo.png" onclick="window.location.href= '#home'" alt=""></div>
        <nav>
    <ul class="menu">
        <div class="search-container">
            <button id="search-icon" class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
            </button>
            <input class="search" type="text" id="search" name="search" placeholder="Buscar productos o marcas">
            <div id="search-results"></div>
        </div>
          
        <li><a href="#products">Productos</a></li>
        <li><a href="#contact">Contacto</a></li>
        <li><a href="sobre-nosotros.php">Sobre Nosotros</a></li>

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

    <section class="hero">
        <video class="video" autoplay loop muted id="video_background" preload="auto">
            <source src="media/video_entrada2.mp4" type="video/mp4"/>
            Tu navegador no soporta el video.
        </video>
        <div class="txtHeader">
        <h1>Bienvenido a la Tienda de Relojes de Lujo</h1>
        <p>Descubre nuestra exclusiva colección de relojes de alta gama.</p>
        <a href="#products" class="btn">Ver Productos</a>
        </div>
    </section>
    </header>

    <!-- Aquí sigue el resto del contenido de la página como ya lo tenías -->


    <?php 
$query = "SELECT p.id, p.nombre, p.precio, p.descripcion, p.imagen1, p.materiales, p.movimiento, p.resistencia_al_agua, p.cristal, m.logo AS logo, m.nombre as marca
FROM productos p
INNER JOIN marca m ON p.id_marca = m.id
LIMIT 6";
$result = $conn->query($query);
?>

<section id="products">
    <div><h2>Productos destacados</h2></div>
<div class="carousel">
        <div class="list">
        <?php 
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { 
            $producto_id = $row["id"];
    ?>
            <div class="item">
                <img class="productos" src="<?php echo $row["imagen1"]; ?>" alt="">
                <div class="introduce">
                    <div class="title">DISEÑADO POR</div>
                    <div class="topic"><img class="logo-marca" src="<?php echo $row["logo"]; ?>" alt=""></div>
                    <div class="des">
                        <?php echo $row["nombre"]; ?>
                    </div>
                    <button class="seeMore">VER MAS &#8599</button>
                </div>
                <div class="detail">
                    <div class="title"><?php echo $row["nombre"]; ?></div>
                    <div class="des">
                        <?php echo $row["descripcion"];?>
                    </div>
                    <ul class="specifications">
                <li><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-watch" viewBox="0 0 16 16">
                    <path d="M8.5 5a.5.5 0 0 0-1 0v2.5H6a.5.5 0 0 0 0 1h2a.5.5 0 0 0 .5-.5z"/>
                    <path d="M5.667 16C4.747 16 4 15.254 4 14.333v-1.86A6 6 0 0 1 2 8c0-1.777.772-3.374 2-4.472V1.667C4 .747 4.746 0 5.667 0h4.666C11.253 0 12 .746 12 1.667v1.86a6 6 0 0 1 1.918 3.48.502.502 0 0 1 .582.493v1a.5.5 0 0 1-.582.493A6 6 0 0 1 12 12.473v1.86c0 .92-.746 1.667-1.667 1.667zM13 8A5 5 0 1 0 3 8a5 5 0 0 0 10 0"/>
                  </svg> <strong>Materiales:</strong> <?php echo $row ["materiales"]; ?></li>
                <li><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-wide-connected" viewBox="0 0 16 16">
                    <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5m0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78zM5.048 3.967l-.087.065zm-.431.355A4.98 4.98 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8zm.344 7.646.087.065z"/>
                  </svg> <strong>Movimiento:</strong> <?php echo $row ["movimiento"]; ?></li>
                <li><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-droplet" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M7.21.8C7.69.295 8 0 8 0q.164.544.371 1.038c.812 1.946 2.073 3.35 3.197 4.6C12.878 7.096 14 8.345 14 10a6 6 0 0 1-12 0C2 6.668 5.58 2.517 7.21.8m.413 1.021A31 31 0 0 0 5.794 3.99c-.726.95-1.436 2.008-1.96 3.07C3.304 8.133 3 9.138 3 10a5 5 0 0 0 10 0c0-1.201-.796-2.157-2.181-3.7l-.03-.032C9.75 5.11 8.5 3.72 7.623 1.82z"/>
                    <path fill-rule="evenodd" d="M4.553 7.776c.82-1.641 1.717-2.753 2.093-3.13l.708.708c-.29.29-1.128 1.311-1.907 2.87z"/>
                  </svg> <strong>Resistente al agua:</strong> <?php echo $row ["resistencia_al_agua"]; ?></li>
                <li><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield" viewBox="0 0 16 16">
                    <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>
                  </svg> <strong>Cristal:</strong> <?php echo $row["cristal"]; ?></li>
            </ul>

                <div class="price">
                    <p><?php echo $row["precio"]; ?> €</p>
                </div>
                    
                    <div class="checkout">
                        <button type="submit" onclick="window.location.href='añadir_al_carrito.php?id=<?php echo $row['id'];?>'">AÑADIR AL CARRITO</button>
                    </div>
                </div>
            </div>
            <?php }
        } else {
            echo "<p>No hay productos disponibles.</p>";
        }
        ?>
            </div>
        </div>
        <div class="arrows">
            <button id="prev"><</button>
            <button id="next">></button>
            <button id="back">Ver todos  &#8599</button>
        </div>
    </div>
    </section>

    <?php 
$query1 = "SELECT id, nombre, logo from marca";
$result = $conn->query($query1);
?>

<section id="marcas">
    <h2>Marcas</h2>
    <div class="marcas-grid">
    <?php 
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { 
            $marca_id = $row["id"];
    ?>
    <div class="name-flex">
        <div class="marca" onclick="window.location.href='detalle_marca.php?id_marca=<?php echo $row['id'];?>'">
            <img class="logo" src="<?php echo $row["logo"]; ?>" 
                 alt="logo">
        </div>
        </div>
    <?php }} else {
        echo "No se encontraron marcas.";
    } ?>
        </div>
    </section>
    <section id="contact">
        <h2>Contacto</h2>
        <p>Si tienes alguna pregunta, no dudes en contactarnos.</p>
        <form>
            <input placeholder="Tu Nombre" type="text" required>
            <input placeholder="Tu Correo" type="email" required>
            <textarea placeholder="Tu Mensaje" rows="5" required></textarea>
            <button type="submit">Enviar</button>
        </form>
    </section>

    <footer>
        
        
        <div class="info_footer"> 
    <nav class="nav_footer">
        <ul>
            <li><a href="#home">Inicio</a></li>
            <li><a href="#about">Sobre Nosotros</a></li>
            <li><a href="#products">Productos</a></li>
            <li><a href="#contact">Contacto</a></li>
        </ul>
    </nav>

        <div class="social-media">
            <a href="https://www.facebook.com/login/?locale=es_ES"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
              </svg></a>
            <a href="https://www.instagram.com/"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
              </svg></a>
            <a href="https://x.com/?lang=es"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
              </svg></a>
        </div>
    </div>
    
        <p>&copy; 2023 Relojes de Lujo. Todos los derechos reservados.</p>
        
    </footer>
    <script src="scriptss_index.js"></script>
</body>
</html>
<?php
$conn->close();
?>
