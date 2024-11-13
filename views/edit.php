<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

include '../includes/db.php';

$message = '';
if (isset($_GET['document'])) {
    $documentName = urldecode($_GET['document']);
    $documentFolder = '../documents/';
    $filePath = $documentFolder . $documentName;

    // Verificar si el archivo existe
    if (!file_exists($filePath)) {
        $message = "Documento no encontrado.";
    }
}

if (isset($_POST['update'])) {
    $newName = trim($_POST['new_name']);
    $documentName = $_POST['document_name']; // Nombre original del archivo

    if (empty($newName)) {
        $message = "El nuevo nombre es obligatorio.";
    } else {
        // Asegurarse de que el nuevo nombre no contenga caracteres maliciosos
        $newName = basename($newName); 

        $newFilePath = $documentFolder . $newName;

        // Verificar si ya existe un archivo con ese nombre
        if (file_exists($newFilePath)) {
            $message = "Ya existe un archivo con ese nombre.";
        } else {
            // Renombrar el archivo
            if (rename($filePath, $newFilePath)) {
                // Aquí podrías actualizar la base de datos si es necesario
                $_SESSION['message'] = 'Documento renombrado exitosamente.';
                header("Location: dashboard.php");
                exit;
            } else {
                $message = "Error al actualizar el nombre del documento.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Documento</title>
    <link rel="stylesheet" href="../assets/css/edit.css">
    <script src="../assets/js/keys.js"></script>
</head>
<body>
    <h1>Editar Documento</h1>
    
    <?php if ($message): ?>
        <div class="alert alert-warning"><?php echo $message; ?></div>
    <?php endif; ?>
    
    <form method="post">
        <input type="hidden" name="document_name" value="<?php echo htmlspecialchars($documentName); ?>">
        <label for="new_name">Nuevo Nombre del Documento:</label>
        <input type="text" name="new_name" id="new_name" value="<?php echo htmlspecialchars($documentName); ?>" required>
        <button type="submit" name="update">Actualizar Documento</button>
    </form>
    
    <a href="dashboard.php">Volver al Dashboard</a>
</body>
</html>
