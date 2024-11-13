<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/header_footer.css"> <!-- Archivo CSS para estilos -->
    <title>Cooperativa</title>
</head>
<body>
    <header class="site-header">
        <div class="logo">
            <img src="../assets/images/nav_var_logo.png" alt="Logo Cooperativa"> <!-- Cambia la ruta según tu estructura -->
        </div>
        <div class="user-welcome">
            <h2><?php echo $user['gender'] === 'masculino' ? 'Bienvenido' : 'Bienvenida'; ?>, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
        </div>
        <nav class="header-nav">
            <button onclick="window.location.href='../login/logout.php'">Cerrar sesión</button>
        </nav>
    </header>