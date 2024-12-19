<?php
// Datos de la base de datos
$servername = "mysql";
$username = "user";
$password = "userpassword";
$dbname = "mydb";

// Crear conexión con la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

echo "<h1>Hola Mundo</h1>"; // Mostrar el mensaje de "Hola Mundo"

echo "<p>Fecha y Hora Actual: " . date("Y-m-d H:i:s") . "</p>"; // Mostrar la fecha y hora actual

echo "<p>Versión de PHP: " . phpversion() . "</p>"; // Mostrar la versión de PHP

echo "<p>Versión de Apache: " . apache_get_version() . "</p>"; // Mostrar la versión de Apache

echo "<p>IP del Servidor: " . $_SERVER['SERVER_ADDR'] . "</p>"; // Mostrar la IP del servidor

echo "<p>IP del Cliente: " . $_SERVER['REMOTE_ADDR'] . "</p>"; // Mostrar la IP del cliente
?>
