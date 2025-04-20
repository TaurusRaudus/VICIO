<?php
require 'db.php';

$archivo = null;

// BUSQUEDA DEL CODIGO //////////////////////////////
if (isset($_GET['codigo']) && !empty($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    $stmt = $conn->prepare("
        SELECT titulo, autor, descripcion, tipo, url, precio
        FROM contenidos
        WHERE id = :codigo
    ");

    $stmt->execute(['codigo' => $codigo]);
    $archivo = $stmt->fetch(PDO::FETCH_ASSOC);
}
///////////////////////////////////////////////////////
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Buscar Contenido</title>
</head>
<body>
    <h2>Buscar Contenido</h2>
    <form action="buscar_contenido.php" method="GET">
        <label for="codigo">Codigo de Archivo:</label><br>
        <input type="text" id="codigo" name="codigo" placeholder="Introduce un codigo..." required><br><br>
        <button type="submit">Buscar</button>
    </form>
    
    <?php if ($archivo): ?>
        <h3>Detalles del Archivo</h3>
        <p><strong>Título:</strong> <?= htmlspecialchars($archivo['titulo']) ?></p>
        <p><strong>Autor:</strong> <?= htmlspecialchars($archivo['autor']) ?></p>
        <p><strong>Descripción:</strong> <?= htmlspecialchars($archivo['descripcion']) ?></p>
        <p><strong>Tipo:</strong> <?= htmlspecialchars($archivo['tipo']) ?></p>
        <p><strong>Precio:</strong> $<?= htmlspecialchars($archivo['precio']) ?></p>
        <p><strong>Archivo:</strong></p>
        <img src="<?= htmlspecialchars($archivo['url']) ?>" alt="Archivo subido" style="max-width: 400px;" />
        <p><a href="<?= htmlspecialchars($archivo['url']) ?>" download>Descargar</a></p>
    <?php elseif (isset($_GET['codigo'])): ?>
        <p>No se encontró ningún contenido con el código proporcionado.</p>
    <?php endif; ?>

    <p><a href="vista_admin.php">← Volver al panel</a></p>
</body>
</html>
