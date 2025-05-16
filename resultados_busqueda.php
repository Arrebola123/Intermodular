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

$search = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $query = "SELECT p.id, p.nombre, p.precio, p.imagen1, m.nombre AS marca 
              FROM productos p 
              INNER JOIN marca m ON p.id_marca = m.id 
              WHERE p.nombre LIKE '%$search%' OR m.nombre LIKE '%$search%'";
    $result_search = $conn->query($query);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Búsqueda</title>
    <link rel="stylesheet" href="styles-interfaz.css">
</head>
<body>
    <header>
        <h1>Resultados de Búsqueda</h1>
        <button onclick="window.location.href= 'index.php'">Volver al inicio</button>
    </header>
    <section id="search-results">
        <h2>Resultados para "<?php echo htmlspecialchars($search); ?>"</h2>
        <div class="product-grid">
        <?php 
        if ($result_search->num_rows > 0) {
            while ($row = $result_search->fetch_assoc()) { 
        ?>
        <div class="name-flex">
            <div class="product" onclick="window.location.href='detalle_producto.php?id=<?php echo $row['id'];?>'">
                <img class="imgs_relojes" src="<?php echo $row["imagen1"]; ?>" alt="Imagen">
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
        <?php }} else { echo "<p>No se encontraron resultados.</p>"; } ?>
        </div>
    </section>
</body>
</html>
<?php
$conn->close();
?>
