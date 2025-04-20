<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administrador</title>
</head>
<body>
    <h1>Bienvenido Administrador</h1>

    <p>Selecciona una opcion:</p>

    <form action="agregar_contenido.php" method="get" style="display:inline;">
        <button type="submit">Agregar Contenido</button>
    </form>

    <form action="editar_categorias.php" method="get" style="display:inline;">
        <button type="submit">Editar Categoria</button>
    </form>

    <form action="buscar_contenido.php" method="get" style="display:inline;">
        <button type="submit">Buscar Contenido</button>
    </form>


    <form action="logout.php" method="post" style="display:inline;">
        <button type="submit">Cerrar Sesion</button>
    </form>
</body>
</html>
