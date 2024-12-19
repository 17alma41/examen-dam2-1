<?php
// Datos de la base de datos
$servername = "mysql";
$username = "user";
$password = "userpassword";
$dbname = "mydb";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener todos los usuarios
$sql = "SELECT id, name, password FROM users";
$result = $conn->query($sql);

// Mostrar los usuarios
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<p>ID: " . $row["id"]. " - Name: " . $row["name"]. " - Password: " . $row["password"]. "</p>";
    }
} else {
    echo "<p>No hay usuarios.</p>";
}

$conn->close();
?>
