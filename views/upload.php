<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login/login.php");
    exit;
}

$message = ''; // Para almacenar mensajes de error o éxito

if (isset($_POST['upload'])) {
    //$title = trim($_POST['title']);  // Obtener el título proporcionado por el usuario
    $file = $_FILES['document'];

    // Validaciones
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $message = "Error al subir el archivo. Inténtalo de nuevo.";
    } elseif (!in_array(pathinfo($file['name'], PATHINFO_EXTENSION), ['pdf', 'doc', 'docx', 'ppt', 'pptx'])) {
        $message = "Solo se permiten archivos PDF, DOCX, PPTX.";
    } elseif ($file['size'] > 2 * 1024 * 1024) { // 2 MB
        $message = "El archivo es demasiado grande. El tamaño máximo permitido es de 2 MB.";
    } else {
        // Si no se proporciona título, usamos el nombre original del archivo
        if (empty($title)) {
            $title = pathinfo($file['name'], PATHINFO_FILENAME);  // Usar el nombre original del archivo
        }

        // Definir el archivo de destino con el nombre proporcionado o el original
        $targetDir = "../documents/";
        $targetFile = $targetDir . basename($title . "." . pathinfo($file['name'], PATHINFO_EXTENSION)); // Usar el nombre del usuario o el original

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            $message = "Documento subido con éxito.";
        } else {
            $message = "Error al mover el archivo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Documento</title>
    <link rel="stylesheet" href="../assets/css/upload_styles.css">
    <script src="../assets/js/keys.js"></script>
</head>
<body>
    <h1>Subir Documento</h1>
    <?php if ($message): ?>
        <div class="alert alert-warning"><?php echo $message; ?></div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <!--<input type="text" name="title" placeholder="Título del documento (opcional)">-->
        <input type="file" name="document" accept=".pdf,.doc,.docx,.ppt,.pptx" required>
        <button type="submit" name="upload">Subir Documento</button>
    </form>
    <a href="dashboard.php">Volver al Dashboard</a>
</body>
</html>
