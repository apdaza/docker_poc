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
* maneja el modulo OBLIGACIONES/obligaciones_en_excel en union con CObligacionInterventoria y CObligacionInterventoriaData
*
* @see CObligacionInterventoria
* @see CObligacionInterventoriaData
*
* @package  modulos
* @subpackage obligaciones
* @author Alejandro Daza
* @version 2019.02
* @copyright apdaza
*/
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=obligaciones_en_excel.xls");
require('../../clases/datos/CObligacionInterventoriaData.php');
require('../../config/conf_reportes.php');
$operador		= $_REQUEST['operador'];
$anio 			= $_REQUEST['sel_anio'];
$mes 			= $_REQUEST['sel_mes'];

$sql = "select *
		from obligacion_concesion_traza    		oct
		inner join obligacion_concesion      	ocs on oct.ocs_id=ocs.ocs_id
		inner join obligacion_clausula      	obc on obc.obc_id=ocs.obc_id
		inner join obligacion_componente    	oco on oco.oco_id=ocs.oco_id
		inner join obligacion_periodicidad  	obp on obp.obp_id=ocs.obp_id
		inner join obligacion_estado			obe on obe.obe_id=oct.obe_id
		where oct_anio= ".$anio." and oct_mes= ".$mes." order by oco_nombre, ocs_literal";
//echo ("<br>sql:".$sql);

$r = $db->ejecutarConsulta($sql);
$obligaciones = null;
if($r){
	$cont = 1;
	while($w = mysqli_fetch_array($r)){
		$obligaciones[$cont]['id'] 				= $w['cau_id'];
		$obligaciones[$cont]['componente'] 		= $w['oco_nombre'];
		$obligaciones[$cont]['clausula'] 		= $w['obc_nombre'];
		$obligaciones[$cont]['literal'] 		= $w['ocs_literal'];
		$obligaciones[$cont]['descripcion'] 	= $w['ocs_descripcion'];
		$oblig_int=null;
		$sql1 = "select obi_literal FROM  obligacion_conc_int oci
				inner join obligacion_interventoria obi on obi.obi_id=oci.obi_id
				where oci.ocs_id=". $w['ocs_id'] ." order by obi.obi_literal";
		//echo("<br>".$sql1);
		$x = $db->ejecutarConsulta($sql1);
		if($x){
			$cont1 = 0;
			while($z = mysqli_fetch_array($x)){
				$oblig_int = $oblig_int."<br>".$z['obi_literal'];
				$cont1++;
			}
		}
		$obligaciones[$cont]['obligacion'] 		= $oblig_int;
		$obligaciones[$cont]['periodicidad'] 	= $w['obp_nombre'];
		$obligaciones[$cont]['criterio'] 		= $w['ocs_criterio'];
		$obligaciones[$cont]['estado'] 			= $w['obe_nombre'];
		$obligaciones[$cont]['evidencia'] 		= $w['oct_evidencia'];
		$obligaciones[$cont]['gestion'] 		= $w['oct_gestion'];
		$obligaciones[$cont]['recomendacion'] 	= $w['oct_recomendacion'];
		$obligaciones[$cont]['id'] 	= $w['oct_id'];
		$cont++;
	}
}

//echo "<br>".$sql."<br>";
echo "<table width='80%' border='1' align='center'>";
//encabezado
echo"<tr><th colspan = '12'><center></center></th></tr>";
echo"<tr><th colspan = '12' bgcolor='#CCCCCC'><center>REPORTE DE LAS OBLIGACIONES PARA EL PERIODO</center></th></tr>";
echo"<tr><th colspan = '12' bgcolor='#CCCCCC'><center>".($anio)."-".($mes)."</center></th></tr>";
echo"<tr><th colspan = '12'><center></center></th></tr>";
echo"<tr><th colspan = '12'><center></center></th></tr>";
//titulos
	echo "<tr>";
	echo "
	<th>Nro</th>
	<th>Componente</th>
	<th>Literal</th>
	<th>Obligacion Concesion</th>
	<th>Obligacion Interventoria</th>
	<th>Periodicidad</th>
	<th>Criterio de aceptacion</th>
	<th>Estado</th>
	<th>Evidencia</th>
	<th>Gestion</th>
	<th>Recomendacion</th>
	<th>Id</th>";
	echo "</tr>";
//datos
$contador = 1;

while($contador < $cont){
	echo "<tr>";
	  echo "<td><center>".($contador)."</center></td>
			<td>".($obligaciones[$contador]['componente'])."</td>
			<td>".($obligaciones[$contador]['literal'])."</td>
			<td>".($obligaciones[$contador]['descripcion'])."</td>
			<td>".($obligaciones[$contador]['obligacion'])."</td>
			<td>".($obligaciones[$contador]['periodicidad'])."</td>
			<td>".($obligaciones[$contador]['criterio'])."</td>
			<td>".($obligaciones[$contador]['estado'])."</td>
			<td>".($obligaciones[$contador]['evidencia'])."</td>
			<td>".($obligaciones[$contador]['gestion'])."</td>
			<td>".($obligaciones[$contador]['recomendacion'])."</td>
			<td>".($obligaciones[$contador]['id'])."</td>
			";
	echo "</tr>";
	$contador++;
}
echo "</table>";
?>
