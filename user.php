<?php require_once "includes/header.php"; ?>
<?php if (!isset($_SESSION['user_name'])) header('Location: index.php') ?>

    <h1>Bienvenido <?php echo htmlspecialchars($_SESSION['user_name'])?></h1>
    <a href="includes/logout.php">Cerrar sesión</a>
<?php require_once "includes/footer.php";  ?>