# FILES (DEV)

**Files** es un servicio para compartir archivos facilmente con otras personas usando enlaces directos en redes sociales. Actualmente solo soporta Discord, pero proximamente iré añadiendo mas funciones.
PD: Si, primera vez que uso el README.md :grin:

![image](https://files.jorge603.xyz/file/65de64.png)

# Como ejecutar Files en mi PC

Files puede ser ejecutado en Windows Server o en Linux:

# Windows 10/11, Windows Server

- Servidor Web (XAMPP, WAMP Server, etc)
- Visual Studio Code o el editor de codigo de tu preferencia.
- Sentido comun

1. Instala un servidor Web (recomendado XAMPP).
2. Inicia el servidor Apache
3. Inicia el servidor MySQL
4. Descarga el código fuente de FILES.
5. Descomprime la carpeta en una carpeta que el servidor web pueda encontrar.
6. Entra al navegador web e ingresa a localhost/carpeta/donde/alojaste/files/
7. Listo, tienes instalado FILES.

# Linux (Testeado en Fedora 38 Server Edition y Ubuntu Server 22.04.3 LTS)

- Servidor Web Apache (no ha sido testeado en NGNIX)
- PHP 7 (recomendado PHP 8.X)
- MariaDB

1. Instala Apache, activa el servicio usando sudo systemctl enable httpd.
2. Instala MariaDB y activa el servicio usando sudo systemctl enable mariadb.
3. Descarga el código fuente de Files.
4. Descomprime el codigo fuente en /var/www/html/
5. Reinicia el proceso httpd con sudo systemctl restart httpd
6. Ingresa a la página usando la IP del servidor o en localhost dependiendo del caso.
7. Listo, tienes instalado FILES.
