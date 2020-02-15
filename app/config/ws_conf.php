<?php

require_once ('../clases/nusoap/nusoap.php');
//Identificador del interventor
define('ID_INTERVENTOR', 'Intv10');

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'pncav_stand');

function ejecutarConsulta($sql) {
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $result = mysqli_query($link, $sql);

    if ($result) {
        return $result;
    }

    mysqli_close($link);
}

?>
