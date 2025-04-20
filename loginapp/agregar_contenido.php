<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit;
}
require 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Agregar Contenido - VIS_IO</title>
</head>
<body>
  <h2>Agregar contenido</h2>
  <form action="procesar_contenido.php" method="POST" enctype="multipart/form-data">
    <label>Nombre (título):</label><br>
    <input type="text" name="titulo" required><br><br>

    <label>Autor:</label><br>
    <input type="text" name="autor" required><br><br>

    <label>Precio:</label><br>
    <input type="number" step="0.01" name="precio" required><br><br>

    <label>Categoría:</label><br>
    <select name="categoria" required>
      <?php
      $stmt = $conn->query("SELECT id, nombre FROM categorias ORDER BY nombre");
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          echo "<option value=\"{$row['id']}\">{$row['nombre']}</option>";
      }
      ?>
    </select><br><br>

    <label>Descripción:</label><br>
    <textarea name="descripcion" rows="4"></textarea><br><br>

    <label>Archivo:</label><br>
    <input type="file" name="archivo" required><br><br>

    <button type="submit">Subir</button>
  </form>

  <p><a href="vista_admin.php">← Volver al panel</a></p>
</body>
</html>
