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
* Modulo Riesgos
* maneja el modulo RIESGOS en union con CRiesgo y CRiesgoData
*
* @see CRiesgo
* @see CRiesgoData
*
* @package  modulos
* @subpackage riesgos
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/

	//no permite el acceso directo
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=riesgos.xls");
require('../../config/conf_reportes.php');
$operador		= $_REQUEST['operador'];

$sql = "SELECT  r.rie_id, r.rie_descripcion, r.rie_estrategia, r.rie_fecha_deteccion,
						im.rim_nombre,im.rim_valor, pr.rpr_nombre,pr.rpr_valor, ca.rca_nombre,
						r.rie_fecha_actualizacion, es.res_nombre,a.alc_nombre
				FROM riesgo r
				INNER JOIN alcance a ON a.alc_id  = r.alc_id
				INNER JOIN riesgo_impacto im ON im.rim_id = r.rim_id
				INNER JOIN riesgo_probabilidad pr ON pr.rpr_id = r.rpr_id
				INNER JOIN riesgo_categoria ca ON ca.rca_id = r.rca_id
				INNER JOIN riesgo_estado es ON es.res_id = r.res_id
				WHERE a.ope_id=".$operador." order by a.alc_nombre";

//echo "<br>".$sql."<br>"; //and (es.res_id=3 or es.res_id=4) and ca.rca_id>3
$r = $db->ejecutarConsulta($sql);


echo "<table border=1>";
echo"<tr><th colspan = '12'><center></center></th></tr>";
echo"<tr><th colspan = '12' bgcolor='#CCCCCC'><center>REPORTE DE RIESGOS</center></th></tr>";
echo"<tr><th colspan = '12'><center></center></th></tr>";
//titulos
	echo "<tr>";
	echo "<th>Id</th>
	<th>Alcance</th>
	<th>Descripcion Riesgo</th>
	<th>Estrategia</th>
	<th>Ultima Accion</th>
	<th>Fecha Deteccion</th>
	<th>Fecha Actualizacion</th>
	<th>Impacto</th>
	<th>Probabilidad</th>
	<th>Categoria</th>
	<th>Estado</th>
	<th>Responsable(s)</th>";
	echo "</tr>";
//datos
while($w = mysqli_fetch_array($r)){

	$responsables = '';
	$sql = "select doa_nombre from documento_actor r
				inner join riesgo_responsable cr on r.doa_id=cr.doa_id
				inner join riesgo c on cr.rie_id=c.rie_id
				where cr.rie_id=". $w['rie_id'] ." order by doa_nombre";
	$rr = $db->ejecutarConsulta($sql);;
	while($x = mysqli_fetch_array($rr)){
			$responsables .= $x['doa_nombre'].",";
	}
	$longitud = strlen($responsables)-1;
	$responsable = substr ($responsables,0,$longitud);
	$tabla = "riesgo_accion";
	$campos = "rac_descripcion";
	$criterio = "rie_id=".$w['rie_id']." order by rac_fecha desc limit 1";
	$zz = $db->recuperarCampo($tabla,$campos,$criterio);

	echo "<tr>";
		echo "<td>".($w['rie_id'])."</td>
		<td>".($w['alc_nombre'])."</td>
		<td>".($w['rie_descripcion'])."</td>
		<td>".($w['rie_estrategia'])."</td>
		<td>".($zz)."</td>
		<td>".($w['rie_fecha_deteccion'])."</td>
		<td>".($w['rie_fecha_actualizacion'])."</td>
		<td>".($w['rim_nombre'])."</td>
		<td>".($w['rpr_nombre'])."</td>
		<td>".($w['rca_nombre'])."</td>
		<td>".($w['res_nombre'])."</td>
		<td>".($responsable)."</td>";
	echo "</tr>";
}
echo "</table>";
?>
