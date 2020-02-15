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
* maneja el modulo DOCUMENTOS/Comunicados_en_excel en union con CDocumento y CDocumentoData
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
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=consolidado_comunicados.xls");
require('../../clases/datos/CDocumentoData.php');
require('../../config/conf_reportes.php');
$operador		= $_REQUEST['operador'];
$fecha_inicio 	= $_REQUEST['txt_fecha_inicio'];
$fecha_fin 		= $_REQUEST['txt_fecha_fin'];

if ($fecha_inicio =="" || $fecha_inicio =="0000-00-00" ) $fecha_inicio="2013-08-01";
if ($fecha_fin =="" || $fecha_fin =="0000-00-00" ) $fecha_fin=date("Y-m-d");

function calculardias($fecha1, $fecha2){
	$dato1 = explode("-", $fecha1);
	$dato2 = explode("-", $fecha2);
	//defino fecha 1
	$ano1 = $dato1[0];
	$mes1 = $dato1[1];
	$dia1 = $dato1[2];

	//defino fecha 2
	$ano2 = $dato2[0];
	$mes2 = $dato2[1];
	$dia2 = $dato2[2];

	//calculo timestam de las dos fechas
	$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
	/* echo ("$timestamp1"."<br>");  */
	$timestamp2 = mktime(4,12,0,$mes2,$dia2,$ano2);
	/* echo ("$timestamp2"."<br>"); */
	$segundos_diferencia = $timestamp2 - $timestamp1; //resto a una fecha la otra */
	/* echo ("$segundos_diferencia"."<br>"); */
	$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); //convierto segundos en días
	$dias_diferencia = round($dias_diferencia); //obtengo el valor absoulto de los días (quito el posible signo negativo)

	return $dias_diferencia;
}

$sql = "select ad.doa_nombre as autor,sd.dos_nombre, count(*) as cantidad
				from documento_comunicado d
				inner join documento_subtema 	sd on d.dos_id = sd.dos_id
				inner  join documento_actor 		ad on d.doa_id_autor = ad.doa_id
				inner  join documento_actor 		dd on d.doa_id_dest = dd.doa_id
				left  join usuario 				us on d.usu_id = us.usu_id
				where d.doc_fecha_radicado >= '".$fecha_inicio."' and d.doc_fecha_radicado <= '".$fecha_fin."' group by autor, sd.dos_nombre";
//echo "<br>".$sql."<br>";
$r = $db->ejecutarConsulta($sql);
echo "<table width='80%' border='1' align='center'>";
//encabezado
echo"<tr><th colspan = '3'><center></center></th></tr>";
echo"<tr><th colspan = '3' bgcolor='#CCCCCC'><center>REPORTE CONSOLIDADO DE COMUNICADOS</center></th></tr>";
echo"<tr><th colspan = '3' bgcolor='#ffffff'><center>".$fecha_inicio."     Y     ".$fecha_fin."</center></th></tr>";
echo"<tr><th colspan = '3'><center></center></th></tr>";
//titulos
	echo "<tr>";
	echo "
	<th>Emitido por</th>
	<th>Subtema de Documento</th>
	<th>Cantidad</th>";
	echo "</tr>";
//datos 
while($w = mysqli_fetch_array($r)){
	$fecha=$w['doc_fecha_respuesta'];
	if ($fecha=="0000-00-00") $fecha="";

	echo "<tr>";
	  echo "<td><center>".$w['autor']."</center></td>
			<td>".$w['dos_nombre']."</td>
			<td>".$w['cantidad']."</td>";
	echo "</tr>";
}
echo "</table>";
?>
