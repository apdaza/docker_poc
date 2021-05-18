<?php
/**
*Gestion Interventoria - Fenix
*
*<ul>
*<li> Redcom Ltda <www.redcom.com.co></li>
*<li> Proyecto RUNT</li>
*</ul>
*/

/**
* Modulo Involucrados
* maneja el modulo involucrados/inventario_en_excel en union con CInvolucrado y CInvolucradoData
*
* @see CInvolucrado
* @see CInvolucradoData
*
* @package  modulos
* @subpackage involucrados
* @author Redcom Ltda
* @version 2013.01.00
* @copyright Ministerio de Transporte
*/
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=inventarios.xls");
require('../../clases/datos/CInvolucradoData.php');
require('../../config/conf_reportes.php');
$operador		= $_REQUEST['operador'];
$fecha_fin 		= $_REQUEST['txt_fecha_fin'];

if ($fecha_fin =="" || $fecha_fin =="0000-00-00" ) $fecha_fin="2019-01-01";
$sql = "select i.*,m.*,d.*,it.*,ii.*,iq.*,im.*,ie.*
				from involucrado i
				INNER JOIN municipio                 m ON   i.mun_id=m.mun_id
				INNER JOIN departamento              d ON   m.dep_id=d.dep_id
				INNER JOIN involucrado_tipo         it ON  it.ivt_id=i.ivt_id
				INNER JOIN operador 				 o ON   o.ope_id=i.ope_id
				LEFT  JOIN inventario_involucrado 	ii ON  i.ivl_id = ii.ivl_id
                INNER JOIN inventario_equipo 		iq ON iq.ine_id = ii.ine_id
                INNER JOIN inventario_marca 		im ON im.inm_id = ii.inm_id
                INNER JOIN inventario_estado 		ie ON ie.ies_id = ii.ies_id
				where 1 order by d.dep_nombre, m.mun_nombre,i.ivl_nombre,iq.iNE_nombre";
//echo ("<br>sql:".$sql);

$r = $db->ejecutarConsulta($sql);
$salida = null;
if($r){
	$cont = 0;
	while($w = mysql_fetch_array($r)){
		$salida[$cont]['id'] 	 		= $w['ivl_id'];
		$salida[$cont]['municipio'] 	= $w['dep_nombre']."<br>".$w['mun_nombre'];
		$salida[$cont]['nombre'] 		= $w['ivl_nombre'];
		$salida[$cont]['equipo'] 		= $w['ine_nombre'];
		$salida[$cont]['marca'] 		= $w['inm_nombre'];
		$salida[$cont]['modelo'] 		= $w['ini_modelo'];
		$salida[$cont]['serie'] 		= $w['ini_serie'];
		$salida[$cont]['placa'] 		= $w['ini_placa'];
		$salida[$cont]['fecha'] 		= $w['ini_fecha_compra'];
		$salida[$cont]['estado'] 		= $w['ies_nombre'];
		$cont++;
	}
}
										
//echo "<br>".$sql."<br>";
echo "<table width='80%' border='1' align='center'>";
//encabezado
echo"<tr><th colspan = '9'><center></center></th></tr>";
echo"<tr><th colspan = '9' bgcolor='#CCCCCC'><center>REPORTE DE LOS INVENTARIOS POR INVOLUCRADO</center></th></tr>";
echo"<tr><th colspan = '9'><center></center></th></tr>";
//titulos
	echo "<tr>";
	echo "
	<th>Depto/Mpio</th>
	<th>Nombre</th>
	<th>Equipo</th>
	<th>Marca</th>
	<th>Modelo</th>
	<th>Serie</th>
	<th>Placa</th>
	<th>Fecha de Compra</th>
	<th>Estado</th>";	
	echo "</tr>";
//datos 
$contador = 0;

while($contador < $cont){
	echo "<tr>";
	  echo "<td><center>".($salida[$contador]['municipio'])."</center></td>
			<td>".($salida[$contador]['nombre'])."</td>
			<td>".($salida[$contador]['equipo'])."</td>
			<td>".($salida[$contador]['marca'])."</td>
			<td>".($salida[$contador]['modelo'])."</td>
			<td>".($salida[$contador]['serie'])."</td>
			<td>".($salida[$contador]['placa'])."</td>
			<td>".($salida[$contador]['fecha'])."</td>			
			<td>".($salida[$contador]['estado'])."</td>";		
	echo "</tr>";
	$contador++;
}
echo "</table>";	
?>	
