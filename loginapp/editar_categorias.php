<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit;
}
require 'db.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Categorías - VIS_IO</title>
</head>
<body>
  <h2>Editar Categorías</h2>

  <!-- Agregar nueva categoría -->
  <form action="insertar_categorias.php" method="POST">
    <label>Nueva categoría:</label><br>
    <input type="text" name="nueva_categoria" required>
    <button type="submit">Agregar</button>
  </form>

  <hr>

  <!-- Renombrar categoría -->
  <form action="renombrar_categoria.php" method="POST">
    <label>Categoría a renombrar:</label><br>
    <select name="categoria_id" required>
      <?php
      // Asegúrate de que esta tabla exista y de que esté funcionando correctamente
      $stmt = $conn->query("SELECT id, nombre FROM categorias ORDER BY nombre");
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          echo "<option value=\"{$row['id']}\">{$row['nombre']}</option>";
      }
      ?>
    </select><br><br>

    <label>Nuevo nombre:</label><br>
    <input type="text" name="nuevo_nombre" required>
    <button type="submit">Renombrar</button>
  </form>

  <form action="logout.php" method="post" style="display:inline;">
        <button type="submit">Cerrar Sesion</button>
    </form>

  <p><a href="vista_admin.php">← Volver al panel</a></p>
</body>
</html>
