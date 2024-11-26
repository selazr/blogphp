<?php include 'includes/header.php'; ?>
<?php if (isset($_SESSION['user_name'])) header('Location: index.php') ?>
<link rel="stylesheet" href="styles/register.css">

<?php
require 'includes/connect.php';

$errores = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom']);
    $cognom = trim($_POST['cognom']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $data = $_POST['data'];

    // Validación básica de campos
    if (empty($nom) || empty($cognom) || empty($email) || empty($password) || empty($data)) {
        $errores[] = "Todos los campos son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Formato de correo no válido.";
    } elseif ($password !== $confirmPassword) {
        $errores[] = "Las contraseñas no coinciden.";
    } else {
        // Encriptación de la contraseña
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Insertar en la base de datos
        $stmt = $pdo->prepare("INSERT INTO usuaris (nom, cognom, email, password, data) VALUES (?, ?, ?, ?, ?)");
        try {
            if ($stmt->execute([$nom, $cognom, $email, $passwordHash, $data])) {
                echo "<p style='color: green;'>Usuario registrado con éxito.</p>";
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Código de error para clave duplicada
                $errores[] = "El correo ya está registrado.";
            } else {
                $errores[] = "Error al registrar el usuario: " . $e->getMessage();
            }
        }
    }
}

if (!empty($errores)) {
    foreach ($errores as $error) {
        echo "<p style='color: red;'>$error</p>";
    }
}
?>

<form action="register.php" method="POST">
    <div class="content">
        <div class="register">
            <p>¿Tienes cuenta? <a href="login.php">Logeate aquí</a></p>
            <label for="nom">Nombre</label>
            <input type="text" name="nom" id="nom" required>

            <label for="cognom">Apellido</label>
            <input type="text" name="cognom" id="cognom" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>

            <label for="confirmPassword">Confirmar Contraseña</label>
            <input type="password" name="confirmPassword" id="confirmPassword" required>

            <label for="data">Fecha de Nacimiento</label>
            <input type="date" name="data" id="data" required>

            <div class="button-container">
                <button type="submit">Registrar</button>
            </div>
        </div>
    </div>

</form>

<?php include 'includes/footer.php'; ?>
