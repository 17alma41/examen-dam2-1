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

// Consulta para obtener los usuarios
$sql = "SELECT id, name, password FROM users";
$result = $conn->query($sql);

// Mostrar los usuarios
if ($result->num_rows > 0) {
    echo "<h2>Usuarios en la Base de Datos:</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Contraseña</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["password"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "<p>No se encontraron usuarios en la base de datos.</p>";
}

// Cerrar la conexión
$conn->close();
?>
