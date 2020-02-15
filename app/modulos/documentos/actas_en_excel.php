<?php
/**
* Sistema POC
*
*<ul>
* <li> MadeOpen <madeopensoftware.com></li>
* <li> Proyecto KBT </li>
*</ul>
*/

/**
* Modulo Documental
* maneja el modulo DOCUMENTAL/Actas_en_excel en union con CDocumento y CDocumentoData
*
* @see CDocumento
* @see CDocumentoData
*
* @package  modulos
* @subpackage documental
* @author Alejandro Daza
* @version 2019.02
* @copyright apdaza
*/
header('Content-type: application/vnd.ms-excel; charset=UTF-8');
header("Content-Disposition: attachment; filename=Reporte_actas.xls");
require('../../clases/datos/CDocumentoData.php');
require('../../config/conf_reportes.php');
$operador		= $_REQUEST['operador'];
$fecha_inicio 	= $_REQUEST['txt_fecha_inicio'];
$fecha_fin 		= $_REQUEST['txt_fecha_fin'];

$sql = "select d.doc_fecha, d.doc_descripcion, d.doc_archivo, d.doc_version, sd.dos_nombre,doe_nombre
				from documento d
				inner join documento_tipo td on d.dti_id = td.dti_id
				inner join documento_tema tm on d.dot_id = tm.dot_id
				inner join documento_subtema sd on d.dos_id = sd.dos_id
				inner join documento_estado ted on ted.doe_id = d.doe_id
				where d.dot_id=5 and d.doc_fecha >= '".$fecha_inicio."' and d.doc_fecha <= '".$fecha_fin."' order by sd.dos_nombre,d.doc_version";
//echo "<br>".$sql."<br>";
$r = $db->ejecutarConsulta($sql);
echo "<table border=1>";
//titulos
	echo "<tr>";
	echo "<th></th><th></th><th>REPORTE DE ACTAS</th>";
	echo "</tr>";
	echo "<tr>";
	echo "<th>Subtema</th>
	<th>Version</th>
	<th>Descripcion</th>
	<th>Fecha</th>
	<th>Estado</th>
	<th>Nombre del archivo</th>";
	echo "</tr>";
//datos
while($w = mysqli_fetch_array($r)){
	if(mb_detect_encoding($w['doc_descripcion'], 'UTF-8, ISO-8859-1')=='UTF-8'){
			$descripcion = htmlentities($w['doc_descripcion']);
	} else {
		$descripcion = $w['doc_descripcion'];
	}
echo "<tr>";
	echo "<td>".($w['dos_nombre'])."</td>
	<td>".($w['doc_version'])."</td>
	<td>".$descripcion."</td>
	<td>".($w['doc_fecha'])."</td>
	<td>".($w['doe_nombre'])."</td>
	<td>".($w['doc_archivo'])."</td>";
echo "</tr>";
}
echo "</table>";
?>
