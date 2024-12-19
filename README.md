# Documentación examen

## Entorno
Trabajaremos con Apache + mySQL + PHP.

El entorno que debes crear se compone de:

- Servidor Web Apache.
- Servidor de Base de Datos MySQL.
- Varios archivos PHP que se sirvan desde el servidor web.

Instalar Apache en Linux mediante `apt install apache2` y gestionar el servicio mediante `systemctl`.

También deberíamos instalarnos docker con `snap install docker`.

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

docker run -p 8001:80 apache-php-random # Lanzar la imagen
```

- Accedemos al http://localhost:8001 para comprobar que funciona
    - En la siguiente ruta nos muestra el archivo random: http://localhost:8001/random.php
    - Y en esta la información de php: http://localhost:8001/info.php

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
    - También insertamos algunos usuarios

4. Modificamos el archivo `index.php` para crear una conexión con el archivo sql.

5. Creamos un archivo denominado `users.php` que muestre todos los usuarios de la tabla de `users`

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

7. Lanzarlo para comprobar que funciona localmente
```bash
docker-compose build # Construir la imagen

docker-compose up -d # Lanzar la imagen
```

- Accedemos al http://localhost:8080 para comprobar que funciona
    - Y en la siguiente ruta nos muestra los usuarios que existen: http://localhost:8080/users.php

