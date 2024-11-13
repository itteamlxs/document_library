<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login/login.php");
    exit;
}

include '../includes/db.php';

$message = '';
$user = null;

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        $message = "Usuario no encontrado.";
    }
}

if (isset($_POST['update'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    // Validaciones
    if (empty($username)) {
        $message = "El nombre de usuario es obligatorio.";
    } elseif (empty($role)) {
        $message = "El rol es obligatorio.";
    } else {
        // Actualizar solo si se proporciona una nueva contraseña
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?");
            if ($stmt->execute([$username, $hashedPassword, $role, $userId])) {
                header("Location: user_management.php");
                exit;
            } else {
                $message = "Error al actualizar el usuario.";
            }
        } else {
            $stmt = $pdo->prepare("UPDATE users SET username = ?, role = ? WHERE id = ?");
            if ($stmt->execute([$username, $role, $userId])) {
                header("Location: user_management.php");
                exit;
            } else {
                $message = "Error al actualizar el usuario.";
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
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../assets/css/edit_user.css">
    <script src="../assets/js/keys.js"></script>
</head>
<body>
    <h1>Editar Usuario</h1>
    <?php if ($message): ?>
        <div class="alert alert-warning"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <?php if ($user): ?>
        <form method="post">
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            <input type="password" name="password" placeholder="Nueva Contraseña (dejar en blanco si no se desea cambiar)">
            <select name="role" required>
                <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>Usuario</option>
                <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrador</option>
            </select>
            <br/>
            <button type="submit" name="update">Actualizar Usuario</button>
        </form>
    <?php else: ?>
        <p>Usuario no encontrado.</p>
    <?php endif; ?>
    <a href="user_management.php">Volver a la Gestión de Usuarios</a>
</body>
</html>
