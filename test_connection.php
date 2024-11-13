<?php
include 'includes/db.php';

if ($pdo) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Error en la conexión.";
}
?>
