
<?php
include 'includes/header.php';
require_once 'includes/connect.php'; // Incluye la conexión a la base de datos
$errores = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validar campos vacíos
    if (empty($email)) {
        $errores[] = "El campo 'email' es obligatorio.";
    }

    if (empty($password)) {
        $errores[] = "El campo 'contraseña' es obligatorio.";
    }

    if (empty($errores)) {
        try {
            // Verificar si el usuario existe
            $query = "SELECT id, nom, password FROM usuaris WHERE email = :email";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($password, $usuario['password'])) {
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $usuario['nom']; // Guarda el nombre del usuario
                header("Location: index.php"); // Redirige al usuario a la página principal
                exit;
            } else {
                $errores[] = "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
            }
        } catch (PDOException $e) {
            $errores[] = "Hubo un error en el sistema. Inténtalo de nuevo más tarde.";
        }
    }
}
?>
<?php if (isset($_SESSION['user_name'])) header('Location: index.php') ?>

<link rel="stylesheet" href="styles/login.css">
    <?php if (!empty($errores)): ?>
        <ul style="color: red;">
            <?php foreach ($errores as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="">
    <div class="login">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Introduce tu correo" required>

        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" placeholder="Introduce tu contraseña" required>

        <div class="button-container">
            <button type="submit">Login</button>
        </div>
        <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
    </div>
    </form>
</body>
</html>
<?php require_once "includes/footer.php";  ?>
