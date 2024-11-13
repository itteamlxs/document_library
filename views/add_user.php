<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login/login.php");
    exit;
}

include '../includes/db.php';

// Manejo de la creación de un nuevo usuario
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role']) && isset($_POST['gender'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);
    $gender = trim($_POST['gender']); // Captura del género

    // Validación básica
    if (!empty($username) && !empty($password) && !empty($role) && !empty($gender)) {
        // Hash de la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Inserción en la base de datos
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role, gender) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$username, $hashed_password, $role, $gender])) {
            // Redirigir a la gestión de usuarios con un mensaje de éxito
            header("Location: user_management.php?success=Usuario agregado con éxito.");
            exit;
        } else {
            // Redirigir a la gestión de usuarios con un mensaje de error
            header("Location: user_management.php?error=Error al agregar el usuario.");
            exit;
        }
    } else {
        // Redirigir a la gestión de usuarios con un mensaje de error
        header("Location: user_management.php?error=Por favor, completa todos los campos.");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario</title>
</head>
<body>
    <h2>Agregar Nuevo Usuario</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Nombre de usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <select name="role" required>
            <option value="user">Usuario</option>
            <option value="admin">Administrador</option>
        </select>
        <select name="gender" required>
            <option value="masculino">Masculino</option>
            <option value="femenino">Femenino</option>
        </select>
        <button type="submit">Agregar Usuario</button>
    </form>
    <a href="user_management.php">Volver a la gestión de usuarios</a>
</body>
</html>
