<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login/login.php");
    exit;
}

include '../includes/db.php';

// Obtener usuarios de la base de datos
$stmt_users = $pdo->query("SELECT * FROM users");
$users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

// Manejo de mensajes de éxito o error
$message = '';
if (isset($_GET['success'])) {
    $message = htmlspecialchars($_GET['success']);
} elseif (isset($_GET['error'])) {
    $message = htmlspecialchars($_GET['error']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="../assets/css/user_management.css">
    <script src="../assets/js/keys.js"></script>
    <script>
        function confirmAddUser() {
            return confirm("¿Estás seguro de que deseas agregar este usuario?");
        }

        function autoCloseMessage() {
            const messageElement = document.getElementById('message');
            if (messageElement) {
                setTimeout(() => {
                    messageElement.style.display = 'none';
                }, 3000); // Cierra el mensaje después de 3 segundos
            }
        }

        window.onload = autoCloseMessage; // Ejecuta al cargar la página
    </script>
</head>
<body>
    <h1>Gestión de Usuarios</h1>
    <a href="dashboard.php">Volver al Home</a>
    <a href="../includes/export_users.php">Exportar Usuarios a CSV</a>
    
    <button onclick="document.getElementById('addUserModal').style.display='block'">Agregar Usuario</button>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de Usuario</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($users)): ?>
                <tr>
                    <td colspan="4">No hay usuarios disponibles.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td>
                            <button onclick="editUser(<?php echo $user['id']; ?>)">Editar</button>
                            <?php if ($user['id'] !== $_SESSION['user_id']): ?>
                                <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?');">Eliminar</a>
                            <?php else: ?>
                                
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Ventana modal para agregar usuario -->
    <div id="addUserModal" style="display:none;">
        <div id="modal-content">
            <span id="close" onclick="document.getElementById('addUserModal').style.display='none'">&times;</span>
            <h3>Agregar Usuario</h3>
            <form method="post" action="add_user.php" onsubmit="return confirmAddUser();">
                <input type="text" name="username" placeholder="Nombre de usuario" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <h4 id="rol" class="title">Rol de Usuario</h4>
                <select class="role" name="role" required>
                    <option value="user">Usuario</option>
                    <option value="admin">Administrador</option>
                </select>
                <h4 class="title">Género</h4>
                <select name="gender" required>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                </select>
                <button type="submit">Agregar</button>
            </form>
        </div>
    </div>

    <!-- Mensaje de éxito o error -->
    <?php if ($message): ?>
        <div id="message" class="alert <?php echo isset($_GET['error']) ? 'error' : 'success'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <script>
        function editUser(id) {
            window.location.href = "edit_user.php?id=" + id;
        }
    </script>
</body>
</html>
