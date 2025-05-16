<?php
include 'conexion.php';

// Verificar si se recibió el ID del producto
if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];

    // Obtener los datos del producto
    $sql = "SELECT * FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
    } else {
        die("❌ Producto no encontrado.");
    }
}

// Obtener categorías, proveedores y marcas
$sql_categorias = "SELECT id, nombre FROM categorias";
$sql_proveedores = "SELECT id, nombre FROM proveedores";
$sql_marcas = "SELECT id, nombre FROM marca";

$categorias = $conn->query($sql_categorias)->fetch_all(MYSQLI_ASSOC);
$proveedores = $conn->query($sql_proveedores)->fetch_all(MYSQLI_ASSOC);
$marcas = $conn->query($sql_marcas)->fetch_all(MYSQLI_ASSOC);

// Si se envía el formulario, actualizar el producto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $numero_de_modelo = $_POST['numero_de_modelo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $materiales = $_POST['materiales'];
    $movimiento = $_POST['movimiento'];
    $resistencia_al_agua = $_POST['resistencia_al_agua'];
    $cristal = $_POST['cristal'];
    $stock_disponible = $_POST['stock_disponible'];
    $id_categoria = $_POST['id_categoria'];
    $id_proveedor = $_POST['id_proveedor'];
    $id_marca = $_POST['id_marca'];
    $id_producto = $_POST['id_producto'];

    // Por defecto, usamos la imagen actual
    $imagen1 = $producto['imagen1'];

    // Si el usuario sube una nueva imagen
    if (isset($_FILES['imagen1']) && $_FILES['imagen1']['error'] === UPLOAD_ERR_OK) {
        $imagen_tmp_name = $_FILES['imagen1']['tmp_name'];
        $imagen_name = $_FILES['imagen1']['name'];
        $imagen_destino = 'imgs/' . $imagen_name;

        if (move_uploaded_file($imagen_tmp_name, $imagen_destino)) {
            $imagen1 = $imagen_name; // Usamos la nueva imagen
        } else {
            echo "❌ Error al mover la imagen.";
        }
    }

    // Actualizar el producto con la imagen correcta
    $sql = "UPDATE productos 
            SET nombre=?, numero_de_modelo=?, descripcion=?, materiales=?, movimiento=?, resistencia_al_agua=?, cristal=?, precio=?, stock_disponible=?, id_categoria=?, id_proveedor=?, id_marca=?, imagen1=? 
            WHERE id=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssdisiisi", $nombre, $numero_de_modelo, $descripcion, $materiales, $movimiento, $resistencia_al_agua, $cristal, $precio, $stock_disponible, $id_categoria, $id_proveedor, $id_marca, $imagen1, $id_producto);

    if ($stmt->execute()) {
        echo "✅ Producto actualizado con éxito.";
        echo "<meta http-equiv='refresh' content='2;url=tabla_productos.php'>";
    } else {
        echo "❌ Error al actualizar: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="styles_formulario.css">
</head>
<body>
  <header>
    <h2>Editar Producto</h2>
    <div>
    <button onclick="window.location.href= 'tabla_productos.php'">
    <span>Volver</span></button>
    </div>
  </header>

    <div class="form-container">
    <form action="insertar_productos.php" method="post" enctype="multipart/form-data">
      
      <!-- Contenedor de dos columnas -->
      <div class="form-columns">
    <div class="column">
          <fieldset class="section">
            <legend>Datos del Producto</legend>

            <input type="hidden" name="id_producto" value="<?php echo $producto['id']; ?>">

            <div class="form-group">
              <label for="nombre">Nombre del Producto *</label>
              <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
            </div>

            <div class="form-group">
              <label for="numero_de_modelo">Número de Modelo *</label>
              <input type="text" id="numero_de_modelo" name="numero_de_modelo" value="<?php echo htmlspecialchars($producto['numero_de_modelo']); ?>" required>
            </div>

            <div class="form-group">
              <label for="descripcion">Descripción *</label>
              <textarea id="descripcion" name="descripcion" rows="3" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
            </div>

            <div class="form-group">
              <label for="precio">Precio (€) *</label>
              <input type="number" id="precio" name="precio" step="0.01" value="<?php echo $producto['precio']; ?>" required>
            </div>
          </fieldset>

          <fieldset class="section">
            <legend>Imágenes del Producto</legend>
            <div class="form-group">
              <label for="imagen1">Imagen Principal *</label>
              <input type="file" id="imagen1" name="imagen1" accept="image/*" value="<?php  echo $producto['imagen1']; ?>">
            </div>
            <div class="form-group">
        <label for="id_marca">Marca</label>
        <select name="id_marca" id="id_marca" required>
            <option value="" disabled>Selecciona la marca</option>
            <?php foreach ($marcas as $marca): ?>
                <option value="<?= $marca['id'] ?>" <?= ($marca['id'] == $producto['id_marca']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($marca['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

            <button type="submit"> <span>Guardar cambios</span></button>
            </div>

          </fieldset>

        <!-- Columna derecha -->
        <div class="column">
          <fieldset class="section">
            <legend>Más Datos</legend>

            <div class="form-group">
              <label for="materiales">Materiales *</label>
              <input type="text" id="materiales" name="materiales" value="<?php echo htmlspecialchars($producto['materiales']); ?>" required>
            </div>

            <div class="form-group">
              <label for="movimiento">Movimiento *</label>
              <input type="text" id="movimiento" name="movimiento" value="<?php echo htmlspecialchars($producto['movimiento']); ?>" required>
            </div>

            <div class="form-group">
              <label for="resistencia_al_agua">Resistencia al Agua *</label>
              <input type="text" id="resistencia_al_agua" name="resistencia_al_agua" value="<?php echo htmlspecialchars($producto['resistencia_al_agua']); ?>" required>
            </div>

            <div class="form-group">
              <label for="cristal">Cristal *</label>
              <input type="text" id="cristal" name="cristal" value="<?php echo htmlspecialchars($producto['cristal']); ?>" required>
            </div>

            <div class="form-group">
              <label for="stock_disponible">Stock Disponible *</label>
              <input type="number" id="stock_disponible" name="stock_disponible" value="<?php echo $producto['stock_disponible']; ?>" required>
            </div>
          </fieldset>

          <fieldset class="section">
            <legend>Categoría y Proveedor</legend>

            <div class="form-group">
        <label for="id_categoria">Categoría</label>
        <select name="id_categoria" id="id_categoria" required>
            <option value="" disabled>Selecciona la categoría</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['id'] ?>" <?= ($categoria['id'] == $producto['id_categoria']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($categoria['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="id_proveedor">Proveedor</label>
        <select name="id_proveedor" id="id_proveedor" required>
            <option value="" disabled>Selecciona el proveedor</option>
            <?php foreach ($proveedores as $proveedor): ?>
                <option value="<?= $proveedor['id'] ?>" <?= ($proveedor['id'] == $producto['id_proveedor']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($proveedor['nombre']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
          </fieldset>
        </div>
      </div>
    </form>
  </div>   
</body>
</html>
