<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo "Procesando..";
//$url[] = "http://" . $_SERVER['HTTP_HOST'] . "/modulos/documentos/comunicados_en_correo.php";
//$url[] = "http://pruebas_adres.sisinfoits.com:8148/modulos/documentos/comunicados_en_correo.php"; //Pruebas
$url[] = "https://supernotariado.sisinfoits.com:8149/modulos/documentos/comunicados_en_correo.php"; //Produccion
foreach ($url as $link):
    echo $online = file_get_contents($link);
endforeach;
echo "Proceso Terminado.";
?>

