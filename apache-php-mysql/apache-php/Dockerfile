# Usar una imagen base de Apache
FROM php:8.2-apache

# Instalar la extensión mysqli
RUN docker-php-ext-install mysqli

# /var/www/html/ directorio predeterminado donde Apache busca los archivos que debe mostrar
WORKDIR /var/www/html/

# Copiar el archivo
COPY index.php users.php ./
# Copiar el archivo info.php y random.php
# COPY random.php info.php ./

# Cambiar los permisos para que sean accesibles por Apache
# RUN chmod 644 /var/www/html/*.php

# Exponer el puerto en el que se va a ejecutar, en este caso del servidor apache se suele utilizar el 80
EXPOSE 80

# Crear la image
# docker build -t apache-php-server .

# Ejecutar la imagen y lanzarla localmente
# docker run -p 8001:80 apache-php-server