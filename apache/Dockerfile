# Usar una imagen base de Apache
FROM httpd:2.4

# Copiar el archivo
# public/index.html es para que busque en una subcarpeta
COPY public/index.html /usr/local/apache2/htdocs/

# Exponer el puerto en el que se va a ejecutar, en este caso del servidor apache se suele utilizar el 80
EXPOSE 8000 

# Crear la image
# docker build -t apache-server .

# Ejecutar la imagen y lánzarla localmente
# docker run -p 8000:80 apache-server