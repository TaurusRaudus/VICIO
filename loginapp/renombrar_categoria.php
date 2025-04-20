<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit;
}
require 'db.php';

$id          = intval($_POST['categoria_id']);
$nuevoNombre = trim($_POST['nuevo_nombre']);
if ($nuevoNombre === '') {
    die("El nuevo nombre no puede estar vacío.");
}

$stmt = $conn->prepare("
    UPDATE categorias
       SET nombre = :nombre
     WHERE id = :id
");
$stmt->execute([
    'nombre' => $nuevoNombre,
    'id'     => $id
]);

echo "Categoría renombrada a «{$nuevoNombre}». <a href='editar_categorias.php'>Volver</a>";
?>
