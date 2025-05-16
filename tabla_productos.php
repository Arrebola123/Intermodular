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

// Consulta SQL para obtener los últimos 10 productos, incluyendo la descripción
$sql = "SELECT p.id, p.nombre, p.numero_de_modelo, p.precio, p.stock_disponible, 
               p.imagen1, 
               p.descripcion, c.nombre AS categoria, v.nombre AS proveedor 
        FROM productos p
        LEFT JOIN categorias c ON p.id_categoria = c.id
        LEFT JOIN proveedores v ON p.id_proveedor = v.id
        ORDER BY p.id DESC 
        LIMIT 10";

// Ejecutar la consulta con manejo de errores
$result = $conn->query($sql) or die("Error en la consulta: " . $conn->error);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Últimos Productos</title>
    <link rel="stylesheet" href="styles_tablas.css">
</head>
<body>
    <div class="table-container">
        <h2>Productos Registrados</h2>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Modelo</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Imagen 1</th>
                <th>Categoría</th>
                <th>Proveedor</th>
                <th>Eliminar</th>
                <th>Editar</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                   <tr>
                        <td><?php echo htmlspecialchars($row["nombre"]); ?></td>
                        <td><?php echo htmlspecialchars($row["numero_de_modelo"]); ?></td>
                        <td><?php echo number_format($row["precio"], 2); ?> €</td>
                        <td><?php echo $row["stock_disponible"]; ?></td>
                        <td>
                            <?php if (!empty($row["imagen1"])) { ?>
                                <img src="<?php echo htmlspecialchars($row["imagen1"]); ?>" alt="Imagen 1">
                            <?php } else { echo "No disponible"; } ?>
                        </td>
                        <td><?php echo htmlspecialchars($row["categoria"]); ?></td>
                        <td><?php echo htmlspecialchars($row["proveedor"]); ?></td>
                        <td>
                            <form method="POST" action="eliminar_producto.php" onsubmit="return confirm('¿Seguro que quieres eliminar este producto?');">
                                <input type="hidden" name="id_producto" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="delete_btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor">
  <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
</svg></button></td>
                            </form>
                            <form action="editar_producto.php" method="GET">
                                <td>
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <button type="submit" class="edit_btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
</svg></button>
    </td>
</form>
                        
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='12'>No hay registros</td></tr>";
            }
            ?>
        </table>
    </div>
    <button onclick="location.href='formulario_productos.php'">Volver al formulario</button>
</body>
</html>
<?php
$conn->close();
?>
