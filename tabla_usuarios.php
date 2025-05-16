<?php
include 'conexion.php';

// Consulta SQL para obtener los usuarios con su rol específico
$sql = "SELECT u.id, u.dni, u.nombre, u.administrador, c.correo, e.fecha_contratacion, e.rol 
        FROM usuarios u
        LEFT JOIN clientes c ON u.id = c.id_usuario
        LEFT JOIN empleados e ON u.id = e.id_usuario";

$result = $conn->query($sql) or die("Error en la consulta: " . $conn->error);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="styles_tablas.css">
</head>
<body>
    <div class="table-container">
        <h2>Usuarios Registrados</h2>
        <table>
            <tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Fecha de Contratación</th>
                <th>Rol</th>
                <th>Administrador</th>
                <th>Eliminar</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["dni"]); ?></td>
                        <td><?php echo htmlspecialchars($row["nombre"]); ?></td>
                        <td><?php echo $row["correo"] ? htmlspecialchars($row["correo"]) : "-"; ?></td>
                        <td><?php echo $row["fecha_contratacion"] ? htmlspecialchars($row["fecha_contratacion"]) : "-"; ?></td>
                        <td><?php echo $row["rol"] ? htmlspecialchars($row["rol"]) : "Cliente"; ?></td>
                        <td><?php echo $row["administrador"] ? "Sí" : "No"; ?></td>
                        <td>
                            <form method="POST" action="eliminar_usuario.php" onsubmit="return confirm('¿Seguro que quieres eliminar este usuario?');">
                                <input type="hidden" name="id_usuario" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="delete_btn">🗑</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='7'>No hay registros</td></tr>";
            }
            ?>
        </table>
    </div>
    <button onclick="location.href='panel_control.html'">Volver al panel de control</button>
</body>
</html>
<?php
$conn->close();
?>
