<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

include '../includes/db.php';

// Obtener datos del usuario
$userId = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT gender FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Carpeta donde están almacenados los documentos
$documentFolder = '../documents/';

// Obtener todos los archivos en la carpeta de documentos
$documents = array_diff(scandir($documentFolder), array('.', '..'));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard del Usuario</title>
    <link rel="stylesheet" href="../assets/css/user_dash_style.css">
    <script src="../assets/js/keys.js"></script>
    
    <!-- PDF.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
</head>
<body>

    <!-- Include del header -->
    <?php include '../includes/user_header.php'; ?>

    <h2>Documentos</h2>
    <table>
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
                            <!-- Botón para ver documento -->
                            <button onclick="viewDocument('<?php echo urlencode($document); ?>')" class="flat-button">Ver</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Ventana modal para visualizar documentos -->
    <div id="modal" style="display:none;">
        <div id="modal-content">
            <span id="close" onclick="closeModal()">&times;</span>

            <!-- Contenedor para el visor de PDF -->
            <div id="pdf-container"></div>
        </div>
    </div>

    <script>
    let pdfDoc = null; // Documento PDF
    let pageNum = 1; // Página actual
    const pageCache = []; // Caché de páginas renderizadas

    // Función para ver un documento en el modal
    function viewDocument(documentName) {
        const url = `../documents/${documentName}`;
        document.getElementById('modal').style.display = 'block';
        renderPDF(url);  // Llamamos a la función que renderiza el PDF
    }

    // Función para renderizar el PDF usando PDF.js
    function renderPDF(url) {
        const pdfContainer = document.getElementById('pdf-container');
        pdfContainer.innerHTML = ''; // Limpiar cualquier contenido previo

        // Cargar el archivo PDF usando PDF.js
        pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            renderPage(pageNum); // Renderizar la primera página
        }).catch(function(error) {
            console.error('Error al cargar el PDF:', error);
        });
    }

    // Función para renderizar una página específica del PDF
    function renderPage(pageNum) {
        pdfDoc.getPage(pageNum).then(function(page) {
            const viewport = page.getViewport({ scale: 1.3 });
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            // Renderizar la página en el canvas
            page.render({ canvasContext: context, viewport: viewport }).promise.then(function() {
                pageCache[pageNum] = canvas; // Guardar la página en caché
                document.getElementById('pdf-container').appendChild(canvas); // Agregar el canvas al contenedor
            });
        });
    }

    // Función para cargar más páginas cuando el usuario hace scroll
    document.getElementById('pdf-container').addEventListener('scroll', function() {
        const container = document.getElementById('pdf-container');
        const scrollPosition = container.scrollTop + container.clientHeight;
        const contentHeight = container.scrollHeight;

        // Si el usuario llega al final del contenedor, cargar la siguiente página
        if (scrollPosition >= contentHeight - 50 && pageNum < pdfDoc.numPages) {
            pageNum++;
            if (!pageCache[pageNum]) {
                renderPage(pageNum); // Renderizar la siguiente página si no está en caché
            }
        }
    });

    // Función para cerrar el modal
    function closeModal() {
        document.getElementById('modal').style.display = 'none';
        document.getElementById('pdf-container').innerHTML = ''; // Limpiar el visor de PDF
        pageCache.length = 0; // Limpiar la caché de páginas
    }

    // Cerrar el modal cuando el usuario hace clic fuera de él
    window.onclick = function(event) {
        const modal = document.getElementById('modal');
        if (event.target === modal) {
            closeModal();
        }
    };
    </script>
    
</body>
</html>
