<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login/login.php");
    exit;
}

include '../includes/db.php';

// Obtener usuarios de la base de datos
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Definir el encabezado para la descarga del CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="usuarios.csv"');

// Abrir el flujo de salida
$output = fopen('php://output', 'w');

// Escribir encabezados de columna
fputcsv($output, ['ID', 'Nombre de Usuario', 'Rol']);

// Escribir datos de usuario
foreach ($users as $user) {
    fputcsv($output, [$user['id'], $user['username'], $user['role']]);
}

fclose($output);
exit;
?>
