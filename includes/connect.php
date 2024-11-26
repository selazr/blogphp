<?php
$host = 'localhost';
$dbname = 'blog';
$username = 'root';
$password = ''; // Si la contraseña está vacía, deja esta cadena vacía

try {
    $pdo = new
    PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
