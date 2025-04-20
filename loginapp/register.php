<?php
// Mostrar errores para debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexion a la base de datos
require 'db.php';

// Validaciones del formulario (Una lista de errores baiscamente)

$errores = [];

// Obtener datos del formulario
$nombre = $_POST['username'];
$correo = $_POST['email'];
$contraseña = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$terminos = isset($_POST['terms']);

// AREA DE VALIDACIONES /////////////////////////////////////////////////////////////////

// NOMBRE ////////////////////////////////////////////////////
if (strlen($nombre) < 5) {
    $errores[] = "El nombre de usuario debe tener al menos 5 caracteres.";
}
//////////////////////////////////////////////////////////////

// CORREO ///////////////////////////////////
if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores[] = "El correo electronico no es valido.";
}
////////////////////////////////////////////

// CONTRASEÑA //////////////////////////////
// La contraseña debe tener alguno de estos, y si, tambien incluye mayusuculas
if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[!\"#$%&\'()*+,\-.\/:;<=>?@[\]^_`{|}~]).{5,}$/', $contraseña)) {
    $errores[] = "La contraseña debe tener al menos 5 caracteres, una letra mayuscula, un numero y un caracter especial.";
}

if ($contraseña !== $confirm_password) {
    die(" Las contraseñas no coinciden");
}
////////////////////////////////////////////

// TERMINOS ////////////////////////////////
if (!$terminos) {
    $errores[] = "Se deben aceptar los terminos y conficiones.";
}
///////////////////////////////////////////

// Si hubieran errores aqui se deberian mostrar, si no se avanza con el resto del codigo
if (!empty($errores)) {
    foreach ($errores as $error) {
        echo "<p style='color: red;'>$error</p>";
    }
    exit;
}

///////////////////////////////////////////////////////// FIN DE AREA DE VALIDACIONES //

// Hashear la contrasena
$hashed_password = password_hash($contraseña, PASSWORD_BCRYPT);

// Verificar si el usuario o el correo ya existen
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE nombre = :nombre OR correo = :correo");
$stmt->execute(['nombre' => $nombre, 'correo' => $correo]);

if ($stmt->rowCount() > 0) {
    die(" El usuario o el correo ya existen");
}

// Insertar el nuevo usuario
$stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, contraseña) VALUES (:nombre, :correo, :pass)");
$stmt->execute([
    'nombre' => $nombre,
    'correo' => $correo,
    'pass' => $hashed_password
]);

echo " Registro exitoso. <a href='login.html'>Iniciar sesión</a> Aqui deberia enviarte a la pagina de inicio del usuario";
?>
