<!DOCTYPE html>
<html lang="es">
<?php session_start(); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <header>
        <h2 class='border'>Aquarium</h2>
        <h2 class='wave'>Aquarium</h2>
<br>
<br>
<br>
<br>
<br>
 <nav>
        <ul>
            <a href="index.php">Inicio</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <!-- Si el usuario ha iniciado sesión -->
                <a href="user.php"><?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
            <?php else: ?>
                <!-- Si el usuario no ha iniciado sesión -->
                <a href="login.php">Iniciar sesión</a>
                <a href="register.php">Registrarse</a>
            <?php endif; ?>
        </ul>
    </nav>
    </header>
