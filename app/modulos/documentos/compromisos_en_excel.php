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
* maneja el modulo DOCUMENTAL/Alarmas_en_excel en union con CDocumento y CDocumentoData
*
* @see CDocumento
* @see CDocumentoData
*
* @package  modulos
* @subpackage documental
* @author Alejandro Daza
* @version 2020.01
* @copyright apdaza
*/
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=compromisos_abiertos.xls");
require('../../clases/datos/CDocumentoData.php');
require('../../config/conf_reportes.php');
$operador		= $_REQUEST['operador'];
$fecha_inicio 	= $_REQUEST['txt_fecha_inicio'];
$fecha_fin 		= $_REQUEST['txt_fecha_fin'];

if ($fecha_inicio =="" || $fecha_inicio =="0000-00-00" ) $fecha_inicio="2013-08-01";
if ($fecha_fin =="" || $fecha_fin =="0000-00-00" ) $fecha_fin=date("Y-m-d");
$sql = "SELECT DISTINCT c.com_id, c.com_actividad, dos_nombre,
                        d.doc_version, c.com_fecha_limite,
                        c.com_fecha_entrega, te.ces_nombre, c.com_observaciones, te.ces_id
                        FROM compromiso c INNER JOIN
                             documento d ON d.doc_id=c.doc_id INNER JOIN
                             documento_subtema dos ON d.dos_id=dos.dos_id INNER JOIN
                             compromiso_estado te ON te.ces_id = c.ces_id LEFT JOIN
                             compromiso_responsable cr ON cr.com_id = c.com_id LEFT JOIN
                             documento_actor da ON da.doa_id = cr.doa_id
                        WHERE c.com_fecha_limite >= '".$fecha_inicio."' and c.com_fecha_limite <= '".$fecha_fin."' order by c.com_fecha_limite ";
//echo ("<br>sql:".$sql);

$r = $db->ejecutarConsulta($sql);
$compromisos = null;
if($r){
	$cont = 0;
	while($w = mysqli_fetch_array($r)){
		$responsables = '';
		$sql1 = "SELECT doa_nombre
								FROM documento_actor r  INNER JOIN
									 compromiso_responsable cr on r.doa_id=cr.doa_id INNER JOIN
									 compromiso c on cr.com_id=c.com_id
								WHERE cr.com_id=". $w['com_id'] ." order by doa_nombre";
		$rr = $db->ejecutarConsulta($sql1);
		while($x = mysqli_fetch_array($rr)){
			$responsables .= $x['doa_nombre'].",";
		}
		$longitud = strlen($responsables)-1;

		$responsable = substr ($responsables,0,$longitud);

		$compromisos[$cont]['id'] = $w['com_id'];
		$compromisos[$cont]['dos_nombre'] = $w['dos_nombre'];
		$compromisos[$cont]['responsable'] = $responsable;
		$compromisos[$cont]['com_actividad'] = $w['com_actividad'];
		$compromisos[$cont]['doc_version'] = "Acta No. ".$w['doc_version'];
		$compromisos[$cont]['com_fecha_limite'] = $w['com_fecha_limite'];
		$compromisos[$cont]['ces_nombre'] = $w['ces_nombre'];
		$compromisos[$cont]['com_observaciones'] = $w['com_observaciones'];
		$cont++;
	}
}

//echo "<br>".$sql."<br>";
echo "<table width='80%' border='1' align='center'>";
//encabezado
echo"<tr><th colspan = '7'><center></center></th></tr>";
echo"<tr><th colspan = '7' bgcolor='#CCCCCC'><center>REPORTE DE LOS COMPROMISOS CON FECHA DE CUMPLIMIENTO ENTRE</center></th></tr>";
echo"<tr><th colspan = '7' bgcolor='#ffffff'><center>".($fecha_inicio)."     Y     ".($fecha_fin)."</center></th></tr>";
echo"<tr><th colspan = '7'><center></center></th></tr>";
//titulos
	echo "<tr>";
	echo "
	<th>Tema</th>
	<th>Responsable</th>
	<th>Compromiso</th>
	<th>Acta que genera el compromiso</th>
	<th>Fecha max.para responder</th>
	<th>Estado</th>
	<th>Observaciones</th>";
	echo "</tr>";
//datos
$contador = 0;

while($contador < $cont){
	echo "<tr>";
	  echo "<td><center>".($compromisos[$contador]['dos_nombre'])."</center></td>
			<td>".($compromisos[$contador]['responsable'])."</td>
			<td>".($compromisos[$contador]['com_actividad'])."</td>
			<td>".($compromisos[$contador]['doc_version'])."</td>
			<td>".($compromisos[$contador]['com_fecha_limite'])."</td>
			<td>".($compromisos[$contador]['ces_nombre'])."</td>
			<td>".($compromisos[$contador]['com_observaciones'])."</td>";
	echo "</tr>";
	$contador++;
}
echo "</table>";
?>
