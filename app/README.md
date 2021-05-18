# Sistema GPC
- MadeOpen <madeopensoftware.com>
- Proyecto KBT
- Alejandro Daza
- version 2019.02
- apdaza.gmail.com

## Tecnologias
- PHP 7
- Mysql 5

## Instalación:
- Despliegue el directorio en el DocumentRoot del servidor apache.
- Crear la base de datos en el gestor debla base de datos MySql.
- Importe el archivo .sql que se encuentra en la carpeta sql para poblar la base de datos.
- Modifique los siguientes parametros del archivo conf.php en la carpeta config
  - host de la base de datos: define('DB_HOST','localhost');
  - usuario de la base de datos: define('DB_USER','usuario');
  - clave del usuario de la base de datos: define('DB_PASSWORD','clave');
  - base de datos: define('DB_NAME','basededatos');
