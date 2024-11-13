<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

// Especificar la carpeta donde están almacenados los documentos
$documentFolder = '../documents/';

// Obtener todos los archivos en la carpeta de documentos
$documents = array_diff(scandir($documentFolder), array('.', '..'));

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos Disponibles</title>
    <link rel="stylesheet" href="../assets/css/dash_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Header -->
    <?php include '../includes/header.php'; ?>

    <div class="dashboard-container">
        <h2>Documentos Disponibles</h2>
        <table class="document-table">
            <thead>
                <tr>
                    <th>Nombre del Documento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($documents)): ?>
                    <tr>
                        <td colspan="2">No hay documentos disponibles.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($documents as $document): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($document); ?></td>
                            <td>
                                <button class="btn" onclick="viewDocument('<?php echo urlencode($document); ?>')">Ver</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Modal para visualización de documentos -->
        <div id="modal" class="modal" style="display:none;">
            <div id="modal-content">
                <span id="close" class="close" onclick="closeModal()">&times;</span>
                <iframe id="document-viewer" style="width:100%; height:550px;" frameborder="0"></iframe>
            </div>
        </div>
    </div>

    <script>
    // Función para ver un documento en el modal
    function viewDocument(documentName) {
        const url = `<?php echo $documentFolder; ?>${documentName}`;
        document.getElementById('document-viewer').src = url;
        document.getElementById('modal').style.display = 'block';
    }

    // Función para cerrar el modal
    function closeModal() {
        document.getElementById('modal').style.display = 'none';
        document.getElementById('document-viewer').src = '';
    }

    // Cerrar el modal al hacer clic fuera de él
    window.onclick = function(event) {
        const modal = document.getElementById('modal');
        if (event.target === modal) {
            closeModal();
        }
    };
    </script>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
