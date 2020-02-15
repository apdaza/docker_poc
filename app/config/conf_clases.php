<?php

/**
 * Archivo de configuracion para la carga de las clases.
 */
/**
 * carga de los achivos de clases
 */
$dir = './clases/datos/';
$handle = opendir($dir);
while ($file = readdir($handle)) {
    if ($file != "." && $file != "..") {
        require_once($dir . $file);
    }
}
closedir($handle);
// Cargamos las clases de la capa de interfaz
$dir = './clases/interfaz/';
$handle = opendir($dir);
while ($file = readdir($handle)) {
    if ($file != "." && $file != "..") {
        require_once($dir . $file);
    }
}
closedir($handle);
// Cargamos las clases de la capa de aplicación
$dir = './clases/aplicacion/';
$handle = opendir($dir);
while ($file = readdir($handle)) {
    if ($file != "." && $file != "..") {
        require_once($dir . $file);
    }
}
closedir($handle);
//cargamos las clases para generacion de charts

require_once './clases/libchart/libchart/classes/libchart.php';

//cargamos las clases para lectura de xls
//require_once './clases/Excel/reader.php';

//cargamos las clases para generar Excel
//equire_once './clases/Excel/PHPExcel.php';
?>
