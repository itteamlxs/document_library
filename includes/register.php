<?php
session_start();
include '../includes/db.php';

// Manejo del formulario de registro
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
    $role = $_POST['role']; // Obtener el rol del formulario
    $gender = $_POST['gender']; // Obtener el género del formulario

    // Insertar el nuevo usuario en la base de datos
    $stmt = $pdo->prepare("INSERT INTO users (username, password, role, gender) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$username, $password, $role, $gender])) {
        header("Location: ../login/login.php?success=Registro exitoso. Puedes iniciar sesión.");
        exit;
    } else {
        $error = "Error al registrar el usuario. Intenta de nuevo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Registro de Usuario</h1>
    <?php if (isset($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Nombre de usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <h4>Rol de Usuario</h4>
        <select name="role" required>
            <option value="user">Usuario</option>
            <option value="admin">Administrador</option>
            <option value="sudo">Super Usuario</option> <!-- Nuevo rol agregado -->
        </select>
        <h4>Género</h4>
        <select name="gender" required>
            <option value="masculino">Masculino</option>
            <option value="femenino">Femenino</option>
        </select>
        <button type="submit">Registrar</button>
    </form>
    <p>¿Ya tienes una cuenta? <a href="../login/login.php">Inicia sesión</a></p>
</body>
</html>
