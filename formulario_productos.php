<?php
include 'conexion.php';

// Obtener categorías de la BD
$sql_categorias = "SELECT id, nombre FROM categorias";
$result_categorias = $conn->query($sql_categorias);
if (!$result_categorias) {
    die("Error al obtener categorías: " . $conn->error);
}

// Obtener proveedores de la BD
$sql_proveedores = "SELECT id, nombre FROM proveedores";
$result_proveedores = $conn->query($sql_proveedores);
if (!$result_proveedores) {
    die("Error al obtener proveedores: " . $conn->error);
}

// Obtener marcas de la BD
$sql_marcas = "SELECT id, nombre FROM marca";
$result_marcas = $conn->query($sql_marcas);
if(!$result_marcas){
  die("Error al obtener marcas: " . $conn->error);
}

// Guardar resultados en arrays
$categorias = $result_categorias->fetch_all(MYSQLI_ASSOC);
$proveedores = $result_proveedores->fetch_all(MYSQLI_ASSOC);
$marcas = $result_marcas->fetch_all(MYSQLI_ASSOC);

// Cerrar conexión ya que los datos han sido extraídos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Productos</title>
  <link rel="stylesheet" href="styles_formulario.css">
</head>
<body>
  <header>
  <div>
  <button href="#" onclick="window.location.href= 'panel_control.html'">
            <span>Volver al panel de control</span>
            <svg width="13px" height="10px" viewBox="0 0 13 10">
            <path d="M1,5 L11,5"></path>
           <polyline points="8 1 12 5 8 9"></polyline>
          </svg>
          </button>
  </div>
    <h2>Registro de Productos</h2>
    <form action="tabla_productos.php" method="get">
            <button href="#">
            <span>Ver productos</span>
            <svg width="13px" height="10px" viewBox="0 0 13 10">
            <path d="M1,5 L11,5"></path>
           <polyline points="8 1 12 5 8 9"></polyline>
          </svg>
          </button>
            </form>
  </header>

  <div class="form-container">
    <form action="insertar_productos.php" method="post" enctype="multipart/form-data">
      
      <!-- Contenedor de dos columnas -->
      <div class="form-columns">

        <!-- Columna izquierda -->
        <div class="column">
          <fieldset class="section">
            <legend>Datos del Producto</legend>

            <div class="form-group">
              <label for="nombre">Nombre del Producto *</label>
              <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="form-group">
              <label for="numero_de_modelo">Número de Modelo *</label>
              <input type="text" id="numero_de_modelo" name="numero_de_modelo" required>
            </div>

            <div class="form-group">
              <label for="descripcion">Descripción *</label>
              <textarea id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>

            <div class="form-group">
              <label for="precio">Precio (€) *</label>
              <input type="number" id="precio" name="precio" step="0.01" required>
            </div>
          </fieldset>

          <fieldset class="section">
            <legend>Imágenes del Producto</legend>
            <div class="form-group">
              <label for="imagen1">Imagen Principal *</label>
              <input type="file" id="imagen1" name="imagen1" accept="image/*" required>
            </div>
            <div class="form-group">
              <label for="id_marca">Marca</label>
              <select name="id_marca" id="id_marca">
    <option value="" disabled selected>Selecciona la marca</option>
    <?php foreach ($marcas as $marca): ?>
        <option value="<?= $marca['id'] ?>"><?= htmlspecialchars($marca['nombre']) ?></option>
    <?php endforeach; ?>
</select>

            </div>

            <button href="#" class="submitBtn">
            <span>Agregar producto</span>
            <svg width="13px" height="10px" viewBox="0 0 13 10">
            <path d="M1,5 L11,5"></path>
            <polyline points="8 1 12 5 8 9"></polyline>
            </svg>
            </button>
            </div>

          </fieldset>

        <!-- Columna derecha -->
        <div class="column">
          <fieldset class="section">
            <legend>Más Datos</legend>

            <div class="form-group">
              <label for="materiales">Materiales *</label>
              <input type="text" id="materiales" name="materiales" required>
            </div>

            <div class="form-group">
              <label for="movimiento">Movimiento *</label>
              <input type="text" id="movimiento" name="movimiento" required>
            </div>

            <div class="form-group">
              <label for="resistencia_al_agua">Resistencia al Agua *</label>
              <input type="text" id="resistencia_al_agua" name="resistencia_al_agua" required>
            </div>

            <div class="form-group">
              <label for="cristal">Cristal *</label>
              <input type="text" id="cristal" name="cristal" required>
            </div>

            <div class="form-group">
              <label for="stock_disponible">Stock Disponible *</label>
              <input type="number" id="stock_disponible" name="stock_disponible" required>
            </div>
          </fieldset>

          <fieldset class="section">
            <legend>Categoría y Proveedor</legend>

            <div class="form-group">
              <label for="id_categoria">Categoría *</label>
              <select name="id_categoria" id="id_categoria" required>
                <option value="" disabled selected>Selecciona una categoría</option>
                <?php foreach ($categorias as $categoria): ?>
                  <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['nombre']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label for="id_proveedor">Proveedor *</label>
              <select name="id_proveedor" id="id_proveedor" required>
                <option value="" disabled selected>Selecciona un proveedor</option>
                <?php foreach ($proveedores as $proveedor): ?>
                  <option value="<?= $proveedor['id'] ?>"><?= htmlspecialchars($proveedor['nombre']) ?></option>
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
