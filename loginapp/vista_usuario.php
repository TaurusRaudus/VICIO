<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inicio Usuario</title>
</head>
<body style="background-color: black; color: white;">
    <div style="background-color: red; padding: 10px;">
        <h1 style="display:inline;">VIS_IO</h1>
        <span style="margin-left: 20px;">Saldo</span>
        <span style="margin-left: 20px;">Descargas</span>
        <span style="margin-left: 20px;">Da un obsequio</span>
        <a href="logout.php" style="margin-left: 20px; color:white;">Cerrar sesión</a>
    </div>

    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></h2>

    <input type="text" placeholder="Buscar fotos, sonidos, videos">
    <button>🔍</button>

    <br><br>
    <button>Mejor valorados</button>
    <button>Más descargados</button>
    <button>Dar un regalo</button>

    <h3>Tus descargas:</h3>
    <div style="display: flex;">
        <div style="width: 100px; height: 100px; background: gray; margin-right: 10px;"></div>
        <div style="width: 100px; height: 100px; background: gray;"></div>
    </div>

    <h3>Te obsequiaron!</h3>
    <div style="width: 200px; height: 100px; background: white; color: black;">
        Descárgalo ahora!
    </div>

    <form action="logout.php" method="post" style="display:inline;">
        <button type="submit">Cerrar Sesion</button>
    </form>
</body>
</html>
