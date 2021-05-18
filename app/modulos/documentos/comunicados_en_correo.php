<?php
/**
* Sistema GPC
*
*<ul>
* <li> MadeOpen <madeopensoftware.com></li>
* <li> Proyecto KBT </li>
*</ul>
*/

/**
* Modulo Documental
* maneja el modulo DOCUMENTAL en union con CComunicado y CComunicadoData
*
* @package  modulos
* @subpackage documental
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/

include '../../config/conf_Reportes.php';
include_once('../../clases/datos/CComunicadoData.php');
include('../../clases/datos/CUsuarioData.php');

$docData = new CComunicadoData($db);
// Trae los comunicados que se vencen mañana y pasado mañana.      
$criterio = "d.der_id <> 3 AND d.doc_fecha_respuesta BETWEEN date_format(ADDDATE(CURDATE(), INTERVAL 1  DAY),'%Y-%m-%d')  and date_format(ADDDATE(CURDATE(), INTERVAL 2 DAY),'%Y-%m-%d')";
// Ejecuta la consulta en la bd.
$correspondencia = $docData->getComunicadosNotificacionCorreo($criterio, 'doc_fecha_radicado');
$contador = 0;
$cont = count($correspondencia);
$documentos = null;

//Recorre cada uno de los comunicados y envia el correo a su responsable.
while ($contador < $cont) {
    $usu_id = $correspondencia[$contador]['usu_id'];
    
    $codigor = $correspondencia[$contador]['codigor'];
    $fecha = $correspondencia[$contador]['fecha'];
    $descripcion = $correspondencia[$contador]['descripcion'];
    $fechamax = $correspondencia[$contador]['fechamax'];    
    $valores = "$usu_id,$usu_correo,$codigor,$fecha,$descripcion,$fechamax";
    
    $para = $correspondencia[$contador]['correo'];
    $copia = '';
    
    $corres = $docData->sendMailAlerta($valores,$para, $copia);
    $contador++;
}
?>
