# Documentación examen

## Entorno
Trabajaremos con Apache + mySQL + PHP.

El entorno que debes crear se compone de:

- Servidor Web Apache.
- Servidor de Base de Datos MySQL.
- Varios archivos PHP que se sirvan desde el servidor web.

Instalar Apache en Linux mediante `apt install apache2` y gestionar el servicio mediante `systemctl`.

## Sprint 1
1. **Fork** al repositorio de datadiego/examen-dam2-1 .
    - Comprobación de que el repositorio funciona correctamente.

2. **Docker hub**
    - Sesión iniciada en docker hub.
    - Sesión iniciada en docker en la **consola**.

## Sprint 2
1. Creamos la carpeta **apache** y en ella tenemos lo siguiente:
    - Un archivo **Dockerfile**, el cual configuraremos para lanzar un `archivo.html`
    - Una carpeta **public** donde se situará el `index.html` el cual mostraremos en la vista
    - `index.html` con un "Hola Mundo!"

2. Lanzarla localmente para comprobar que funciona.
```bash
docker build -t apache-holamundo # Construir la imagen

docker run -p 8000:80 apache-holamundo # Lanzar la imagen
```

- Accedemos al http://localhost:8000 para comprobar que funciona

## Sprint 3
1. Creamos una nueva carpeta llamada **apache-php**.

2. A continuación nuestro servidor web Apache debe servir un archivo `index.php` que muestre:
    - Un mensaje de hola mundo.
    - La fecha y hora actual.
    - La versión de PHP que estás utilizando.
    - La versión de Apache que estás utilizando.
    - La IP del servidor.
    - La IP del cliente

3. Lanzarla localmente para comprobar que funciona.
```bash
docker build -t apache-php # Construir la imagen

docker run -p 8001:80 apache-php # Lanzar la imagen
```

- Accedemos al http://localhost:8001 para comprobar que funciona

## Sprint 4
1. Seguimos en la carpeta **apache-php**.

2. Creamos un archivo `info.php`.
    - En este archivo implementaremos la funcion `phpinfo();`

3. Creamos un archivo `random.php`, que devuelva un JSON con lo siguiente:
    - Un número aleatorio entre 1 y 100.
    - Un mensaje que diga si el número es par o impar.
    - Un elemento aleatorio de un array que contenga al menos 5 elementos, a tu elección.

4. Lanzarla localmente para comprobar que funciona.
```bash
docker build -t apache-php-random # Construir la imagen

docker run -p 8002:80 apache-php-random # Lanzar la imagen
```

- Accedemos al http://localhost:8002 para comprobar que funciona
    - En la siguiente ruta nos muestra el archivo random: http://localhost:8002/random.php
    - Y en esta la información de php: http://localhost:8002/info.php

## Sprint 5
1. Creamos una carpeta nueva llamada **apache-php-mysql**, en ella tendremos los siguiente
    - Copiamos la carpeta **apache-php**
    - Creamos el archivo `docker-compose.yml`
    - Creamos otro archivo sql llamado `init.sql`

2. Configuramos el archivo `docker-compose.yml`
    ```yml
        version: '3.8'

        services:
        apache-php:
            build: ./apache-php
            ports:
            - "8080:80"
            networks:
            - app-network
            depends_on:
            - mysql

        mysql:
            image: mysql:5.7
            environment:
            MYSQL_ROOT_PASSWORD: rootpassword
            MYSQL_DATABASE: mydb
            MYSQL_USER: user
            MYSQL_PASSWORD: userpassword
            volumes:
            - ./init.sql:/docker-entrypoint-initdb.d/init.sql
            networks:
            - app-network

        networks:
        app-network:
            driver: bridge
    ```

3. Crear una base de datos en `init.sql` que contenga:
    - Una tabla de usuarios con los campos `id`, `name` y `password`.
    - También insertamos algunos usuarios.

4. Modificamos el archivo `index.php` para crear una conexión con el archivo sql.

5. Creamos un archivo denominado `users.php` que muestre todos los usuarios de la tabla de `users`.

6. Nuestro proyecto debería estar quedando tal que así:
```
apache-php-mysql
├── apache-php
│   ├── Dockerfile
│   ├── index.php
│   ├── info.php
│   ├── random.php
|   ├── users.php
└── docker-compose.yml
|
└── init.sql
```

7. Lanzarlo para comprobar que funciona localmente.
```bash
docker-compose build # Construir la imagen

docker-compose up -d # Lanzar la imagen
```

- Accedemos al http://localhost:8080 para comprobar que funciona
    - Y en la siguiente ruta nos muestra los usuarios que existen: http://localhost:8080/users.php.

## Extra: CRUD
1. Modificamos el archivo `users.php` para añadir el CRUD con lo siguiente:

    - Leer archivos (Operación GET)
        - Consultar datos para obtener los usuarios.
        - Los usuarios se muestra en una tabla de HTML.
        - **Código**:
            ```php
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
            ```

    - Crear usuario (Operación POST)
        - Se proporciona un formulario donde se puede ingresar un nombre y contraseña.
        - El scrip PHP revibe los datos y los inserta en la base de datos.
        - **Código para el formulario:**
            ```html
                <h2>Crear un nuevo usuario:</h2>
                <form action="users.php" method="POST">
                    <label for="name">Nombre:</label><br>
                    <input type="text" id="name" name="name" required><br><br>
                    <label for="password">Contraseña:</label><br>
                    <input type="password" id="password" name="password" required><br><br>
                    <button type="submit">Crear Usuario</button>
                </form>
            ```
        - **Código para procesar los datos de creación de usuarios:**
            ```php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name']) && isset($_POST['password'])) {
                $name = $_POST['name'];
                $password = $_POST['password'];

                $stmt = $conn->prepare("INSERT INTO users (name, password) VALUES (?, ?)");
                $stmt->bind_param("ss", $name, $password);
                $stmt->execute();
                $stmt->close();

                echo "<p>Usuario '$name' creado con éxito.</p>";
                }
            ```

    - Actualizar usuario (Operación POST)    
        - Cada usuario en la lista tiene un formulario prellenado con su nombre y contraseña actuales. El usuario puede modificar estos valores

        - **Código para formulario de actualización de usuarios:**
            ```html
                <form action="users.php" method="POST" style="display:inline;">
                <input type="hidden" name="update_id" value="ID_DEL_USUARIO">
                <input type="text" name="update_name" value="NOMBRE_ACTUAL_DEL_USUARIO">
                <input type="text" name="update_password" value="CONTRASEÑA_ACTUAL_DEL_USUARIO">
                <button type="submit">Actualizar</button>
                </form>
            ```
        - **Código para procesar la actualización del usuario:**
            ```php
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
            ```
    
    - Eliminar un usuario (Operación POST)
        - En cada fila de la tabla de usuarios hay un botón "Eliminar" que permite borrar ese usuario de la base de datos
        - Cuando se hace clic en "Eliminar", se envía una solicitud POST con el id del usuario que se desea eliminar.

        - **Código para formulario de eliminación de usuarios:**
            ```html
                <form action="users.php" method="POST" style="display:inline;">
                <input type="hidden" name="delete_id" value="ID_DEL_USUARIO">
                <button type="submit">Eliminar</button>
                </form>
            ```
        - **Código para procesar la eliminación del usuario:**
            ```php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
                $id = $_POST['delete_id'];

                $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->close();

                echo "<p>Usuario con ID $id eliminado.</p>";
                }
            ```