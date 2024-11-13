<?php
session_start();
include '../includes/db.php';

$error_message = "";

// Si el usuario ya está autenticado, redirigirlo al dashboard
if (isset($_SESSION['user_id'])) {
    // Redirigir a la página correspondiente según el rol del usuario
    if ($_SESSION['role'] === 'admin') {
        header("Location: ../views/dashboard.php");
    } elseif ($_SESSION['role'] === 'user') {
        header("Location: ../views/user_dashboard.php");
    }
    exit;
}

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Verificación del usuario
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Almacenar información del usuario en la sesión
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirigir según el rol del usuario
        if ($user['role'] === 'admin') {
            header("Location: ../views/dashboard.php");
        } elseif ($user['role'] === 'user') {
            header("Location: ../views/user_dashboard.php");
        }
        exit;
    } else {
        $error_message = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <script src="../assets/js/keys.js"></script>
</head>
<body>
    <div class="login-container">
        <img src="../assets/images/logotipo.png" alt="Logo" class="logo"> <!-- Asegúrate de que la ruta del logo sea correcta -->
        <h2>Iniciar Sesión</h2>
        <form method="post" id="loginForm">
            <input type="text" name="username" placeholder="Nombre de usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit" name="login" class="btn">Iniciar sesión</button>
        </form>
        <?php if ($error_message): ?>
            <br/>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <p class="info">¿No tienes una cuenta? Contacta al administrador.</p>
    </div>
    <script>
        const form = document.getElementById('loginForm');
        form.addEventListener('submit', function() {
            form.querySelector('.btn').classList.add('loading');
        });
    </script>
</body>
</html>
