<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit;
}
require 'db.php';

$nueva = trim($_POST['nueva_categoria']);
if ($nueva === '') {
    die("El nombre de categoría no puede estar vacío.");
}

$stmt = $conn->prepare("INSERT INTO categorias (nombre) VALUES (:nombre)");
$stmt->execute(['nombre' => $nueva]);

echo "Categoría «{$nueva}» creada. <a href='editar_categorias.php'>Volver</a>";
?>
