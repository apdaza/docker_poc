 <?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);
//error_reporting(E_ALL);
define('MODULO_DEFECTO', 'cerrar');

session_start();
$session = array('usuario_sesion_pry', 'clave_sesion_pry');
define('_VALID_PRY', 1);


include('../../clases/datos/CData.php');
include('../../clases/aplicacion/CDataLog.php');
include('../../config/conf.php');
$db = new CData(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$db->conectar();
?>
