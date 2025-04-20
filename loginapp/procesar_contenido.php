<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit;
}
require 'db.php';

// VERIFICAMOS AL ADMIN //////////////////////
$idAdmin = $_SESSION['admin_id'] ?? 1; // Falta la verificacion que el admin sea el correcto, por ahora solo es por defecto
$stmt = $conn->prepare("SELECT COUNT(*) FROM administradores WHERE id = :id");
$stmt->execute(['id' => $idAdmin]);

if ($stmt->fetchColumn() == 0) {
    die("No se encontro el adminsitrador.");
}
///////////////////////////////////////////////

// Recoger datos
$titulo      = $_POST['titulo'];
$autor       = $_POST['autor'];
$precio      = $_POST['precio'];
$categoria   = $_POST['categoria'];
//$formato     = $_POST['formato'];
$descripcion = $_POST['descripcion'];

// Procesar archivo
if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
    die("Error al subir el archivo.");
}

$uploadsDir = __DIR__ . '/uploads/';
if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}

$tmpName  = $_FILES['archivo']['tmp_name'];
$origName = basename($_FILES['archivo']['name']);

// DETECCION DEL MYME TYPE ///////////////
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $tmpName);
finfo_close($finfo);

// MIME TYPES DEFINIDOS //////////////////
$mimeMapping = [
    'image/jpeg'      => 'JPG',
    'image/png'       => 'PNG',
    'video/quicktime' => 'MOV',
    'video/mp4'       => 'MP4',
    'audio/mpeg'      => 'MP3'
];

if (!array_key_exists($mimeType, $mimeMapping)) {
    die("El formato del archivo subido no es valido.");
}

$detectedFormat = $mimeMapping[$mimeType];

/////////////////////////////////////////

// RUTA RELATIVA ///////////////////////////////////////////////////////
$relativePath = 'uploads/' . uniqid() . "_" . $origName; // Ruta relativa
$target = __DIR__ . '/' . $relativePath;

if (!move_uploaded_file($tmpName, $target)) {
    die("No se pudo mover el archivo subido.");
}

$url = $relativePath;
///////////////////////////////////////////////////////////////////////

// Guardar metadata en BD
$stmt = $conn->prepare("
    INSERT INTO contenidos
      (titulo,  autor, descripcion, tipo, url, precio, id_admins)
    VALUES
      (:titulo, :autor, :descripcion, :tipo, :url, :precio, :id_admins)
");

$stmt->execute([
    'titulo'      => $titulo,
    'autor'       => $autor,
    'descripcion' => $descripcion,
    'tipo'        => $detectedFormat,
    'url'         => $relativePath,
    'precio'      => $precio,
    'id_admins'  => $idAdmin //?? 1 // por defecto puedes dejar 1 si es un admin fijo
]);



// ID PARA BUSQUEDA
$idArchivo = $conn->lastInsertId();

echo "Contenido subido con exito.";
echo "El código del archivo es: <strong>{$idArchivo}</strong>. <a href='vista_admin.php'>Volver al panel</a>"
?>
