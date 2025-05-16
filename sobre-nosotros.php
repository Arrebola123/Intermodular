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
    <title>Sobre Nosotros - Relojes de Lujo</title>
    <link rel="stylesheet" href="styles_sobre_nosotros.css">
</head>
<body>
    <header id="home">
        <div class="menu">
            <div class="logo"><img src="logos/logo.png" onclick="window.location.href= 'index.php'" alt=""></div>
            <nav>
        <ul class="menu">
            <li><a href="index.php#products">Productos</a></li>
            <li><a href="index.php#contact">Contacto</a></li>
    
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
            <source src="media/video_entrada_sobre_nosotros.mp4" type="video/mp4"/>
            Tu navegador no soporta el video.
        </video>
        <div class="txtHeader">
            <h1>Sobre Nosotros</h1>
            <p>Descubre la historia, la pasión y la excelencia detrás de nuestra tienda de relojes de lujo.</p>
        </div>
    </section>
        </header>

   

    <section class="about">
        <div class="about-container fade-in-section">
            <div class="about-text">
                <h2>Nuestra Historia</h2>
                <p>Desde nuestros inicios, en <strong>Relojes de Lujo</strong> nos hemos dedicado a la búsqueda y selección de las piezas más exclusivas de la relojería suiza y mundial. Con más de una década en el mercado, hemos construido una reputación basada en la calidad, la confianza y la satisfacción de nuestros clientes.</p>

                <h2>Calidad y Exclusividad</h2>
                <p>Trabajamos con las marcas más prestigiosas, incluyendo Rolex, Patek Philippe, Audemars Piguet, Omega y muchas más. Cada pieza que ofrecemos ha sido cuidadosamente seleccionada para garantizar su autenticidad, precisión y diseño excepcional. Contamos con modelos de edición limitada, relojes vintage y colecciones exclusivas para los conocedores más exigentes.</p>

                <h2>Nuestra Filosofía</h2>
                <p>Para nosotros, un reloj es más que un accesorio: es una inversión, un símbolo de éxito y una obra de arte que trasciende generaciones. Creemos en la elegancia atemporal y en la importancia de la artesanía excepcional.</p>

                <h2>Servicios Exclusivos</h2>
                <ul>
                    <li><strong>Asesoría personalizada:</strong> Te ayudamos a elegir la pieza ideal según tu estilo y necesidades.</li>
                    <li><strong>Autenticación y certificación:</strong> Garantizamos que cada reloj cuenta con certificación de autenticidad.</li>
                    <li><strong>Mantenimiento y reparación:</strong> Disponemos de un equipo de relojeros expertos para el cuidado de tu inversión.</li>
                    <li><strong>Compra y venta de relojes:</strong> Ofrecemos opciones seguras para la compra y reventa de piezas exclusivas.</li>
                </ul>

                <h2>Nuestro Compromiso con el Cliente</h2>
                <p>En <strong>Relojes de Lujo</strong>, brindamos una atención excepcional, asegurándonos de que cada cliente viva una experiencia única. Desde el primer contacto hasta la entrega de tu reloj, garantizamos un servicio de primer nivel, con transparencia y confianza absoluta.</p>
                </div>
            </div>
        </div>
    </section>

    

    <section class="why-choose-us fade-in-section">
        <h2>¿Por qué Elegirnos?</h2>
        <div class="features-container">
            <div class="feature">
                <h3>Autenticidad Garantizada</h3>
                <p>Todos nuestros relojes son 100% originales y certificados.</p>
            </div>
            <div class="feature">
                <h3>Atención Exclusiva</h3>
                <p>Ofrecemos asesoría personalizada para cada cliente.</p>
            </div>
            <div class="feature">
                <h3>Reputación y Confianza</h3>
                <p>Más de 10 años en el sector de la alta relojería nos respaldan.</p>
            </div>
            <div class="feature">
                <h3>Selección de Élite</h3>
                <p>Contamos con piezas de las marcas más prestigiosas del mundo.</p>
            </div>
        </div>
    </section>

    <section id="testimonials" class="fade-in-section">
    <h2>Testimonios</h2>
    <div class="testimonial_grid">
        <div class="testimonial">
            <p>"Los relojes son simplemente impresionantes. La calidad es excepcional y el servicio al cliente es inmejorable."</p>
            <span>- Juan Pérez</span>
        </div>
        <div class="testimonial">
            <p>"He comprado varios relojes aquí y nunca me han decepcionado. ¡Altamente recomendados!"</p>
            <span>- María López</span>
        </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Relojes de Lujo. Todos los derechos reservados.</p>
    </footer>
    <script src="sobre_nosotros.js"></script>
</body>
</html>
<?php
$conn->close();
?>
