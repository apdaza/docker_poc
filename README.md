# Docker POC

## Para iniciar el contenedor:

- docker-compose up -d
- en el navegador abrir http://localhost:8890/
- usuario: admin, clave: test
- importar para la base de datos el archivo madeopen_kbt.sql
- en el navegador abrir http://localhost/
- usuario: admin, clave:admin

## Configuración cliente de Google y API

1. Tener una cuenta de Google y estar asociado como developer en Google.
2. Ir al siguiente link https://console.cloud.google.com/ y crear un proyecto.
3. Asociar el API de Google Drive al proyecto.
4. Dentro de API y Servicios crear una credencial **ID de cliente de OAuth** como se ve en la figura 
![](https://imgur.com/PY9xPKU.png)
5. Seleccionar el **Tipo** que es **Aplicación Web**, también ingresar un **nombre** a la credencial.
6. En los campos de texto **URI*** por el momento dejar el localhost http://localhost y en **URI de redireccionamiento autorizados** seleccionar la ruta dentro del servidor web la siguiente direccion. http://localhost/< ruta del contenido dentro del servidor web>/oauth2callback.php
![](https://imgur.com/JANXM2V.png)
7. Guardar las credenciales y descargarlas con el nombre **credentials.json**.

## Obtención del token.json

Para la obtención del token una vez descargado las credenciales se debe realizar lo siguiente: 
1. Ejecutar el getToken.sh
    ``` sh getToken.sh    ``` 
2. Durante la ejecución nos generará una url para obtener los permisos que serán concedidos al proyecto para obtener un código que nos entrega google. El código se muestra en el módulo de archivos del sistema. Este código se debe ingresar dentro de la terminal, si todo sale correcto nos generará el **token.json**.