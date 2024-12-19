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

// Procesar las solicitudes CRUD

// Crear un nuevo usuario (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['password'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("INSERT INTO users (name, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $name, $password);
    $stmt->execute();
    $stmt->close();

    echo "<p>Usuario '$name' creado con éxito.</p>";
}

// Actualizar un usuario (PUT)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id']) && isset($_POST['update_name']) && isset($_POST['update_password'])) {
    $id = $_POST['update_id'];
    $name = $_POST['update_name'];
    $password = $_POST['update_password'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $password, $id);
    $stmt->execute();
    $stmt->close();

    echo "<p>Usuario con ID $id actualizado a '$name'.</p>";
}

// Borrar un usuario (DELETE)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    echo "<p>Usuario con ID $id eliminado.</p>";
}

// Mostrar todos los usuarios (GET)
echo "<h2>Usuarios en la Base de Datos:</h2>";

$sql = "SELECT id, name, password FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr><th>ID</th><th>Nombre</th><th>Contraseña</th><th>Acciones</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"]. "</td>
                <td>" . $row["name"]. "</td>
                <td>" . $row["password"]. "</td>
                <td>
                    <form action='users.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='update_id' value='" . $row["id"] . "'>
                        <input type='text' name='update_name' value='" . $row["name"] . "'>
                        <input type='text' name='update_password' value='" . $row["password"] . "'>
                        <button type='submit'>Actualizar</button>
                    </form>
                    <form action='users.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='delete_id' value='" . $row["id"] . "'>
                        <button type='submit'>Eliminar</button>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay usuarios.</p>";
}

// Formulario para crear un nuevo usuario
echo "<h2>Crear un nuevo usuario:</h2>
      <form action='users.php' method='POST'>
          <label for='name'>Nombre:</label><br>
          <input type='text' id='name' name='name' required><br><br>
          <label for='password'>Contraseña:</label><br>
          <input type='password' id='password' name='password' required><br><br>
          <button type='submit'>Crear Usuario</button>
      </form>";

$conn->close();
?>
