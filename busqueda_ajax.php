<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda_relojes";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $query = "SELECT p.id, p.nombre, p.precio, p.imagen1, m.nombre AS marca 
              FROM productos p 
              INNER JOIN marca m ON p.id_marca = m.id 
              WHERE p.nombre LIKE '%$search%' OR m.nombre LIKE '%$search%' 
              LIMIT 5";  // Limita la cantidad de resultados para rendimiento

    $result_search = $conn->query($query);

    if ($result_search->num_rows > 0) {
        while ($row = $result_search->fetch_assoc()) {
            echo "<div class='search-item' onclick=\"window.location.href='detalle_producto.php?id=" . $row['id'] . "'\">";
            echo "<img src='" . $row["imagen1"] . "' width='50' height='50'>";
            echo "<span>" . $row["marca"] . " - " . $row["nombre"] . "</span>";
            echo "</div>";
        }
    } else {
        echo "<p>No se encontraron resultados</p>";
    }
}

$conn->close();
?>
