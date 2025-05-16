<?php
include 'conexion.php';
// Consulta SQL para obtener los últimos 10 productos, incluyendo la descripción
$sql = "SELECT id, nombre, logo from marca;";

// Ejecutar la consulta con manejo de errores
$result = $conn->query($sql) or die("Error en la consulta: " . $conn->error);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Últimas Marcas</title>
    <link rel="stylesheet" href="styles_tablas.css">
</head>
<body>
    <div class="table-container">
        <h2>Productos Registrados</h2>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Logo</th>
                <th>Eliminar</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                   <tr>
                        <td><?php echo htmlspecialchars($row["nombre"]); ?></td>
                        <td>
                            <?php if (!empty($row["logo"])) { ?>
                                <img src="<?php echo htmlspecialchars($row["logo"]); ?>" alt="Logo">
                            <?php } else { echo "No disponible"; } ?>
                        </td>
                        
                        <td>
                            <form method="POST" action="eliminar_producto.php" onsubmit="return confirm('¿Seguro que quieres eliminar este producto?');">
                                <input type="hidden" name="id_producto" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="delete_btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
  <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
</svg></button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='12'>No hay registros</td></tr>";
            }
            ?>
        </table>
    </div>
    <button onclick="location.href='formulario-marca.html'">Volver al formulario</button>
</body>
</html>
<?php
$conn->close();
?>
