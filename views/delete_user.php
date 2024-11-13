<?php
session_start();
include '../includes/db.php';

$userIdToDelete = $_GET['id'];
$currentUserId = $_SESSION['user_id'];

// Verificar si se intenta eliminar el usuario activo
if ($userIdToDelete == $currentUserId) {
    header("Location: user_management.php?error=No puedes eliminar tu propio usuario.");
    exit;
}

// Eliminar usuario de la base de datos
$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$userIdToDelete]);
header("Location: user_management.php?success=Usuario eliminado con éxito.");
