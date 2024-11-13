<?php
$host = 'localhost'; // Cambia esto si tu servidor es diferente
$db = 'biblioteca_documentos';
$user = 'root'; // Cambia esto por tu usuario de base de datos
$pass = ''; // Cambia esto por tu contraseña de base de datos

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    // Configurar el modo de error de PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Conexión fallida: " . $e->getMessage());
}
?>
