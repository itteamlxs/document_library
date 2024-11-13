<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

include '../includes/db.php'; // Conexión a la base de datos si es necesario

// Verificar si el parámetro 'document' está presente en la URL
if (isset($_GET['document'])) {
    $document = $_GET['document'];

    // Carpeta donde se encuentran los documentos
    $documentFolder = '../documents/';

    // Ruta completa al documento
    $filePath = $documentFolder . basename($document);

    // Verificar si el archivo existe
    if (file_exists($filePath)) {
        // Intentar eliminar el archivo
        if (unlink($filePath)) {
            // Si la eliminación fue exitosa, mostrar mensaje
            $_SESSION['message'] = "Documento eliminado con éxito.";
        } else {
            // Si hubo un error al eliminar, mostrar mensaje de error
            $_SESSION['message'] = "Error al eliminar el documento.";
        }
    } else {
        // Si el archivo no existe, mostrar mensaje de error
        $_SESSION['message'] = "El documento no existe.";
    }
} else {
    // Si no se proporciona un parámetro 'document', mostrar mensaje de error
    $_SESSION['message'] = "No se proporcionó el documento a eliminar.";
}

// Redirigir de nuevo a la página de dashboard
header("Location: dashboard.php");
exit;
?>

