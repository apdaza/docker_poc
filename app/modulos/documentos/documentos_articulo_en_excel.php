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
* maneja el modulo OBLIGACIONES/obligaciones_en_excel en union con CObligacionInterventoria y CObligacionInterventoriaData
*
* @see CObligacionInterventoria
* @see CObligacionInterventoriaData
*
* @package  modulos
* @subpackage obligaciones
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=documentos_articulo_en_excel.xls");
require('../../clases/datos/CDocumentoArticuloData.php');
require('../../config/conf_reportes.php');
$operador		= $_REQUEST['operador'];

$sql = "SELECT *
		FROM documento d
		INNER JOIN documento_subtema dos ON d.dos_id = dos.dos_id
		LEFT JOIN documento_articulo a ON d.doc_id = a.doc_id
		LEFT JOIN alcance al ON a.alc_id = al.alc_id
		where dti_id=5 and d.ope_id = ".$operador." order by doc_version,doa_nombre, alc_nombre";
//echo ("<br>sql:".$sql);

$r = $db->ejecutarConsulta($sql);
$normas = null;
if($r){
	$cont = 1;
	while($w = mysqli_fetch_array($r)){
		$normas[$cont]['id'] 				= $w['doc_id'];
		$normas[$cont]['doc_fecha'] 		= $w['doc_fecha'];
		$normas[$cont]['doc_version'] 		= $w['doc_version'];
		$normas[$cont]['doc_descripcion'] 	= $w['doc_descripcion'];
		$normas[$cont]['doa_nombre'] 		= $w['doa_nombre'];
		$normas[$cont]['doa_descripcion'] 	= $w['doa_descripcion'];
		$normas[$cont]['alc_nombre'] 		= $w['alc_nombre'];
		$cont++;
	}
}

//echo "<br>".$sql."<br>";
echo "<table width='80%' border='1' align='center'>";
//encabezado
echo"<tr><th colspan = '7'><center></center></th></tr>";
echo"<tr><th colspan = '7' bgcolor='#CCCCCC'><center>REPORTE DE LAS NORMAS VS ALCANCE</center></th></tr>";
echo"<tr><th colspan = '7'><center></center></th></tr>";
echo"<tr><th colspan = '7'><center></center></th></tr>";
//titulos
	echo "<tr>";
	echo "
	<th>No.</th>
	<th>fecha</th>
	<th>normatividad</th>
	<th>descripcion</th>
	<th>articulo</th>
	<th>descripcion</th>
	<th>registro</th>";
	echo "</tr>";
//datos
$contador = 1;

while($contador < $cont){
	echo "<tr>";
	  echo "<td><center>".($contador)."</center></td>
			<td>".($normas[$contador]['doc_fecha'])."</td>
			<td>".($normas[$contador]['doc_version'])."</td>
			<td>".($normas[$contador]['doc_descripcion'])."</td>
			<td>".($normas[$contador]['doa_nombre'])."</td>
			<td>".($normas[$contador]['doa_descripcion'])."</td>
			<td>".($normas[$contador]['alc_nombre'])."</td>
			";
	echo "</tr>";
	$contador++;
}
echo "</table>";
?>
